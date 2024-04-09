<?php
namespace App\Http\Controllers;

use App\Models\Consist;
use App\Models\Transaction;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Worker;


class MovementController extends BaseController {
    public function view(Request $request){
        $move = Transaction::selectRaw('
                items.title,
                items.id as item,
                workers.id as worker,
                transactions.worker_to_id,
                transactions.color_id,
                workers.pib,
                workers.ceh_id, 
                transactions.count, 
                transactions.type_id,
                transactions_types.title as type,
                date')
            ->join('items', 'items.id', '=', 'transactions.item_id_id')
            ->join('workers', 'workers.id', '=', 'transactions.worker_from_id')
            ->join('transactions_types', 'transactions_types.id', '=', 'transactions.type_id')
            ->orderBy('date', 'asc')
            ->get();

        $consists = Consist::all();
        $cons = [];
        foreach($consists as $cn) {
            $cons[$cn->what_id][] = ['item' => $cn->have_id, 'count' => $cn->count];
        }

        // $i = 0;
        // $i++;
        // if($i>20) break;
        
        $anomalies = [];
        $workers = [];
        foreach($move as $mv) {
            switch($mv->type_id) {
                case 1:                     // ->
                    if(isset($workers[$mv->worker][$mv->item][$mv->color_id ?? 'n']))
                        $workers[$mv->worker][$mv->item][$mv->color_id ?? 'n'] -= $mv->count;
                    else
                        $workers[$mv->worker][$mv->item][$mv->color_id ?? 'n'] = -$mv->count;

                    $anomalies[$mv->worker.'-'.$mv->worker_to_id][1][$mv->item][$mv->color_id ?? 'n'] = $mv->count;
                break;

                case 2:                     // <-
                    if(isset($workers[$mv->worker][$mv->item][$mv->color_id ?? 'n']))
                        $workers[$mv->worker][$mv->item][$mv->color_id ?? 'n'] += $mv->count;
                    else
                        $workers[$mv->worker][$mv->item][$mv->color_id ?? 'n'] = $mv->count;

                    if($mv->worker_to_id == 1) {
                        if(isset($workers[1][$mv->item][$mv->color_id ?? 'n']))
                            $workers[1][$mv->item][$mv->color_id ?? 'n'] -= $mv->count;
                        else
                            $workers[1][$mv->item][$mv->color_id ?? 'n'] = -$mv->count;
                    }

                    if($mv->worker_to_id != 1){
                        if(isset($anomalies[$mv->worker_to_id.'-'.$mv->worker][1][$mv->item][$mv->color_id ?? 'n']))
                            $anomalies[$mv->worker_to_id.'-'.$mv->worker][1][$mv->item][$mv->color_id ?? 'n'] -= $mv->count;
                        else
                            $anomalies[$mv->worker.'-'.$mv->worker_to_id][1][$mv->item][$mv->color_id ?? 'n'] = $mv->count;
                    }
                break;

                default:
                    if($mv->type_id == 3){  // +
                        if(isset($workers[$mv->worker][$mv->item][$mv->color_id ?? 'n']))
                            $workers[$mv->worker][$mv->item][$mv->color_id ?? 'n'] += $mv->count;
                        else
                            $workers[$mv->worker][$mv->item][$mv->color_id ?? 'n'] = $mv->count;
                    } else {                // -
                        if(isset($workers[$mv->worker][$mv->item][$mv->color_id ?? 'n']))
                            $workers[$mv->worker][$mv->item][$mv->color_id ?? 'n'] -= $mv->count;
                        else
                            $workers[$mv->worker][$mv->item][$mv->color_id ?? 'n'] = -$mv->count;
                    }

                    if($mv->worker != 1){   // subitems
                        if(isset($cons[$mv->item])){
                            foreach($cons[$mv->item] as $cn) {
                                if(isset($workers[$mv->worker][$cn['item']])){
                                    if(isset($workers[$mv->worker][$cn['item']][$mv->color_id ?? 'n']))
                                        $workers[$mv->worker][$cn['item']][$mv->color_id ?? 'n'] -= $mv->count * $cn['count'];
                                    else
                                        $workers[$mv->worker][$cn['item']]['n'] -= $mv->count * $cn['count'];
                                } else {
                                    if(isset($workers[$mv->worker][$cn['item']][$mv->color_id ?? 'n']))
                                        $workers[$mv->worker][$cn['item']][$mv->color_id ?? 'n'] = -$mv->count * $cn['count'];
                                    else
                                        $workers[$mv->worker][$cn['item']]['n'] = -$mv->count * $cn['count'];
                                }
                            }
                        }
                    }
                break;
            }
        }
        
        return view('move')
            ->withWorkers($workers)
            ->withConsists($cons)
            ->withAnomaly($anomalies)
            ->withMoves($move);
    }

}