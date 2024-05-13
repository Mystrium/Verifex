<?php
namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Purchase;
use App\Models\Consist;
use App\Models\Color;
use App\Models\Item;
use App\Models\Ceh;


class MovementController extends BaseController {
    public function view(Request $request) {
        if (!Storage::disk('local')->exists('storage/materialceh.txt'))
            Storage::disk('local')->put('storage/materialceh.txt', '1:1');
        $storeman = explode(':', Storage::disk('local')->get('storage/materialceh.txt'));
        
        $storage = DB::table('purchases')
            ->selectRaw('
                1 as purch,
                purchases.id as trans,
                purchases.item_id as item,
                ' . $storeman[0] . ' as worker,
                null as worker_to_id,
                purchases.color_id,
                purchases.count, 
                date')
            ->join('ceh', 'ceh.id', '=', DB::raw($storeman[0]));
            // ->join('ceh_types', 'ceh_types.id', '=', 'ceh.type_id');    //debug

        $skip = $request->skip ?? 0;

        $move = Transaction::selectRaw('
                0 as purch,
                transactions.id as trans,
                transactions.item_id_id as item,
                workers.ceh_id as worker,
                worker_to.ceh_id as worker_to_id,
                transactions.color_id,
                transactions.count, 
                date')
            ->join('workers', 'workers.id', '=', 'transactions.worker_from_id')
            ->join('workers as worker_to', 'worker_to.id', '=', 'transactions.worker_to_id', 'left outer')
            ->union($storage)
            ->orderBy('date', 'desc')
            ->skip($skip)->limit(PHP_INT_MAX)
            ->get();

        if($move[0]->purch == 0){
            $curr_move = Transaction::selectRaw('
                    items.id as item,
                    items.title as item_title,
                    workers.id as f_worker,
                    workers.pib as from_pib,
                    worker_to.id as t_worker,
                    worker_to.pib as to_pib,
                    colors.title as color,
                    colors.hex as hex,
                    transactions.count,
                    date')
                ->where('transactions.id', '=', $move[0]->trans)
                ->join('items', 'items.id', '=', 'transactions.item_id_id')
                ->join('workers', 'workers.id', '=', 'transactions.worker_from_id')
                ->join('workers as worker_to', 'worker_to.id', '=', 'transactions.worker_to_id', 'left outer')
                ->join('colors', 'colors.id', '=', 'transactions.color_id', 'left outer')
                ->get();
        } else {
            $curr_move = Purchase::selectRaw('
                    items.id as item,
                    items.title as item_title,
                    workers.id as to_worker,
                    workers.pib as from_pib,
                    colors.title as color,
                    -1 as t_worker,
                    colors.hex as hex,
                    purchases.count,
                    date')
                ->where('purchases.id', '=', $move[0]->trans)
                ->join('items', 'items.id', '=', 'purchases.item_id')
                ->join('workers', 'workers.id', '=', DB::raw($storeman[1]))
                ->join('colors', 'colors.id', '=', 'purchases.color_id', 'left outer')
                ->get();
        }
        // dd($curr_move);


        $consists = Consist::select('what_id', 'have_id', 'count', 'hascolor')
            ->join('items', 'items.id', '=', 'consists.have_id')
            ->get();

        $cons = [];
        foreach($consists as $cn) {
            $cons[$cn->what_id][] = 
                [
                    'item' => $cn->have_id,
                    'count' => $cn->count,
                    'color' => $cn->hascolor
                ];
        }

        $colors = Color::whereIn('id', $move->pluck('color_id'))->get();
        $users = Ceh::select('ceh.id', 'ceh.title', 'ceh_types.title as type')
            ->join('ceh_types', 'ceh_types.id', '=', 'ceh.type_id')
            ->whereIn('ceh.id', $move->pluck('worker'))
            ->get();
        
        $items_ids = [];
        $workers = [];
        foreach($move as $mv) {
            $items_ids[] = $mv->item;
            if(isset($mv->worker_to_id)) {
                    // ->
                if(isset($workers[$mv->worker][$mv->item][$mv->color_id ?? 'n']))
                    $workers[$mv->worker][$mv->item][$mv->color_id ?? 'n'] -= $mv->count;
                else
                    $workers[$mv->worker][$mv->item][$mv->color_id ?? 'n'] = -$mv->count;

                    // <-
                if(isset($workers[$mv->worker_to_id][$mv->item][$mv->color_id ?? 'n']))
                    $workers[$mv->worker_to_id][$mv->item][$mv->color_id ?? 'n'] += $mv->count;
                else
                    $workers[$mv->worker_to_id][$mv->item][$mv->color_id ?? 'n'] = $mv->count;

                // if($mv->worker_to_id == 1) {
                //     if(isset($workers[1][$mv->item][$mv->color_id ?? 'n']))
                //         $workers[1][$mv->item][$mv->color_id ?? 'n'] -= $mv->count;
                //     else
                //         $workers[1][$mv->item][$mv->color_id ?? 'n'] = -$mv->count;
                // }

            } else {
                if(isset($workers[$mv->worker][$mv->item][$mv->color_id ?? 'n']))
                    $workers[$mv->worker][$mv->item][$mv->color_id ?? 'n'] += $mv->count;
                else
                    $workers[$mv->worker][$mv->item][$mv->color_id ?? 'n'] = $mv->count;

                if($mv->worker != 1){   // subitems
                    if(isset($cons[$mv->item])){
                        foreach($cons[$mv->item] as $cn) {
                            if(isset($workers[$mv->worker][$cn['item']])){
                                if($cn['color'] == 1) {
                                    if(isset($workers[$mv->worker][$cn['item']][$mv->color_id ?? 'n']))
                                        $workers[$mv->worker][$cn['item']][$mv->color_id ?? 'n'] -= abs($mv->count) * $cn['count'];
                                    else
                                        $workers[$mv->worker][$cn['item']][$mv->color_id ?? 'n'] = -abs($mv->count) * $cn['count'];
                                } else {
                                    if(isset($workers[$mv->worker][$cn['item']]['n']))
                                        $workers[$mv->worker][$cn['item']]['n'] -= abs($mv->count) * $cn['count'];
                                    else
                                        $workers[$mv->worker][$cn['item']]['n'] = -abs($mv->count) * $cn['count'];
                                }
                            } else {
                                if($cn['color'] == 1)
                                    $workers[$mv->worker][$cn['item']][$mv->color_id ?? 'n'] = -abs($mv->count) * $cn['count'];
                                else
                                    $workers[$mv->worker][$cn['item']]['n'] = -abs($mv->count) * $cn['count'];
                            }
                            $items_ids[] = $cn['item'];
                        }
                    }
                }
            }
        }

        $items = Item::selectRaw('items.id as id, items.title, units.title as unit')
            ->join('units', 'units.id', '=', 'items.unit_id')
            ->whereIn('items.id', $items_ids)
            ->get();

        $this->removeZeroValues($workers);
        
        return view('movement.cehs')
            ->withWorkers($workers)
            ->withConsists($cons)
            ->withNames($users)
            ->withItemsnames($items)
            ->withColornames($colors)
            ->withOffset($skip)
            ->withCurrentmove($curr_move[0])
            ->withMoves($move);
    }

    function removeZeroValues(&$array) {
        foreach ($array as $key => &$value) {
            if (is_array($value)) {
                $this->removeZeroValues($value);
                if (empty($value))
                    unset($array[$key]);
            } elseif ($value == 0)
                unset($array[$key]);
        }
    }

    public function delete($id){
        Transaction::destroy($id);
        return redirect()->back();
    }


    public function movement(Request $request) {
        $start = $request->period[0] ?? Carbon::now()->subDays(30)->toDateString();
        $end = $request->period[1] ?? Carbon::now()->toDateString();

        $move = Transaction::selectRaw('
                transactions.id as trans,
                workers.pib,
                workers.ceh_id,
                ceh.title as ceh_title,
                ceh_types.title as cehtype,
                workerto.pib as to_pib,
                ceh_to.title as cehto_title,
                ceh_type_to.title as cehtypeto,
                items.title,
                items.id as item,
                workers.id as worker,
                transactions.worker_to_id,
                transactions.color_id,
                colors.hex,
                colors.title as color,
                transactions.count,
                units.title as unit,
                date')
            ->join('items',                     'items.id',         '=', 'transactions.item_id_id')
            ->join('workers',                   'workers.id',       '=', 'transactions.worker_from_id')
            ->join('ceh',                       'workers.ceh_id',   '=', 'ceh.id')
            ->join('ceh_types',                 'ceh.type_id',      '=', 'ceh_types.id')
            ->join('workers as workerto',       'workerto.id',      '=', 'transactions.worker_to_id')
            ->join('ceh as ceh_to',             'workerto.ceh_id',  '=', 'ceh_to.id')
            ->join('ceh_types as ceh_type_to',  'ceh_to.type_id',   '=', 'ceh_type_to.id')
            ->join('colors',                    'colors.id',        '=', 'transactions.color_id')
            ->join('units',                     'units.id',         '=', 'items.unit_id')
            ->whereBetween(DB::raw('DATE(date)'), [$start, $end])
            ->whereNotNull('worker_to_id')
            ->orderBy('date', 'desc')
            ->get();

        return view('movement.move')
            ->withPeriod([$start, $end])
            ->withMoves($move);
    }

    public function production(Request $request) {
        $start = $request->period[0] ?? Carbon::now()->subDays(7)->toDateString();
        $end = $request->period[1] ?? Carbon::now()->toDateString();

        $move = Transaction::selectRaw('
                ceh_id,
                items.title,
                items.id as item,
                ceh.title as ceh,
                ceh_types.title as type,
                transactions.color_id,
                workers.id as worker,
                workers.pib,
                colors.hex,
                colors.title as color,
                units.title as unit,
                sum(transactions.count) as count
                ')
            ->join('items', 'items.id', '=', 'transactions.item_id_id')
            ->join('workers', 'workers.id', '=', 'transactions.worker_from_id')
            ->join('ceh', 'ceh.id', '=', 'workers.ceh_id')
            ->join('ceh_types', 'ceh_types.id', '=', 'ceh.type_id')
            ->join('colors', 'colors.id', '=', 'transactions.color_id', 'left outer')
            ->join('units',                     'units.id',         '=', 'items.unit_id')
            ->whereNull('worker_to_id')
            ->whereBetween(DB::raw('DATE(date)'), [$start, $end])
            ->groupBy('ceh_id', 'item_id_id')
            ->when(!empty($request->byworker), function ($q) {
                return $q->groupBy('worker_from_id');
            })
            ->when(!empty($request->bycolor), function ($q) {
                return $q->groupBy('color_id');
            })
            ->orderBy('ceh_id')
            ->get();

        return view('movement.production')
            ->withGroup(['worker' => $request->byworker, 'color' => $request->bycolor])
            ->withPeriod([$start, $end])
            ->withMoves($move);
    }

}