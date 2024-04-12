<?php
namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Consist;
use App\Models\Worker;
use App\Models\Color;
use App\Models\Item;


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

        $colors = Color::whereIn('id', $move->pluck('color_id'))->get();
        $users = Worker::select('id', 'pib', 'ceh_id')->whereIn('id', $move->pluck('worker'))->get();
        $items = Item::selectRaw('items.id as id, items.title, units.title as unit')
            ->join('units', 'units.id', '=', 'items.unit_id')
            ->whereIn('items.id', $move->pluck('item'))
            ->get();
        
        $anomalies = [];
        $workers = [];
        foreach($move as $mv) {
            switch($mv->type_id) {
                case 1:                     // ->
                    if(isset($workers[$mv->worker][$mv->item][$mv->color_id ?? 'n']))
                        $workers[$mv->worker][$mv->item][$mv->color_id ?? 'n'] -= $mv->count;
                    else
                        $workers[$mv->worker][$mv->item][$mv->color_id ?? 'n'] = -$mv->count;
                    
                    $anomalies[$mv->worker.'-'.$mv->worker_to_id][1][$mv->item][$mv->color_id ?? 'n']['time'] = $mv->date;
                    $anomalies[$mv->worker.'-'.$mv->worker_to_id][1][$mv->item][$mv->color_id ?? 'n']['val'] = $mv->count;
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
                        if(isset($anomalies[$mv->worker_to_id.'-'.$mv->worker][1][$mv->item][$mv->color_id ?? 'n']['val']))
                            $anomalies[$mv->worker_to_id.'-'.$mv->worker][1][$mv->item][$mv->color_id ?? 'n']['val'] -= $mv->count;
                        else
                            $anomalies[$mv->worker.'-'.$mv->worker_to_id][1][$mv->item][$mv->color_id ?? 'n']['val'] = $mv->count;
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
                                    // if(isset($workers[$mv->worker][$cn['item']][$mv->color_id ?? 'n']))
                                        $workers[$mv->worker][$cn['item']][$mv->color_id ?? 'n'] -= $mv->count * $cn['count'];
                                    // else
                                    //     $workers[$mv->worker][$cn['item']][$mv->color_id ?? 'n'] -= $mv->count * $cn['count'];
                                } else {
                                    // if(isset($workers[$mv->worker][$cn['item']][$mv->color_id ?? 'n']))
                                        $workers[$mv->worker][$cn['item']][$mv->color_id ?? 'n'] = -$mv->count * $cn['count'];
                                    // else
                                    //     $workers[$mv->worker][$cn['item']][$mv->color_id ?? 'n'] = -$mv->count * $cn['count'];
                                }
                            }
                        }
                    }
                break;
            }
        }

        $this->removeZeroAnomalies($anomalies);
        $this->removeZeroValues($workers);
        
        return view('move')
            ->withWorkers($workers)
            ->withConsists($cons)
            ->withAnomaly($anomalies)
            ->withNames($users)
            ->withItemsnames($items)
            ->withColornames($colors)
            ->withMoves($move);
    }

    function removeZeroAnomalies(&$array) {
        foreach ($array as $key => &$value) {
            if (is_array($value)) {
                if(isset($value['val']) && $value['val'] == 0)
                    unset($value['time']);
                $this->removeZeroAnomalies($value);
                if (empty($value))
                    unset($array[$key]);
            } elseif ($value === 0)
                unset($array[$key]);
        }
    }

    function removeZeroValues(&$array) {
        foreach ($array as $key => &$value) {
            if (is_array($value)) {
                $this->removeZeroValues($value);
                if (empty($value))
                    unset($array[$key]);
            } elseif ($value === 0)
                unset($array[$key]);
        }
    }

}