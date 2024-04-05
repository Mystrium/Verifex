<?php
namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\WorkHour;
use App\Models\Consist;
use App\Models\Worker;
use App\Models\Item;


class ChartController extends BaseController {

    public function view(Request $request){
        $items = Item::select('items.id', 'items.url_photo', 'items.title', 'units.title as unit')
            ->join('units', 'units.id', '=', 'items.unit_id')
            ->whereNotIn('items.id', 
                Consist::select('have_id')
                    ->get()
                    ->toArray())
            ->get();

        return view('cost')
            ->withItems($items);
    }

    public function hours(Request $request){
        $start = $request->start ?? Carbon::now()->subDays(100);
        $end = $request->end ?? Carbon::now();

        $hours = WorkHour::selectRaw('DATE(start) as date, time')
            ->where('worker_id', '=', $request->id)
            ->whereBetween('start', [$start, $end])
            ->get();
dd($hours); // ------
        $data = [];
        $data['label'] = $hours->pluck('date')->all();
        $data['time']  = $hours->pluck('time')->all();

        return view('charts/index')
            ->withData($data);
    }

    public function pay(Request $request){
        $pays = Worker::selectRaw(
                'date(transactions.date) as date,
                GREATEST(
                    sum(
                        if(transactions.type_id = 4, transactions.count * -1, transactions.count) 
                            * items.price), 
                        work_types.min_pay) 
                    as pay')
            ->join('transactions', 'transactions.worker_from_id', '=', 'workers.id')
            ->join('items', 'items.id', '=', 'transactions.item_id_id')
            ->join('work_types', 'work_types.id', '=', 'workers.role_id')
            ->where(
                'workers.id', 
                '=', 
                $request->id)
            ->whereIn('transactions.type_id', [4, 3])
            ->whereBetween(
                'date', 
                [
                    $request->start, 
                    $request->end
                ])
            ->orderBy('date', 'desc')
            ->groupByRaw('DATE(date)')
            ->get();

        $pay_map = [];
        foreach($pays as $pay)
            $pay_map[$pay->date] = $pay->pay;

        return view('charts/index')->withItems($pay_map);
    }

    public function items(Request $request){
        $items = Worker::selectRaw(
            'date(transactions.date) as date,
            sum(if(transactions.type_id = 4, transactions.count * -1, transactions.count)) as count,
            items.title')
        ->join('transactions', 'transactions.worker_from_id', '=', 'workers.id')
        ->join('items', 'items.id', '=', 'transactions.item_id_id')
        ->join('work_types', 'work_types.id', '=', 'workers.role_id')
        ->where(
            'workers.id', 
            '=', 
            $request->id)
        ->whereIn('transactions.type_id', [4, 3])
        ->whereBetween(
            'date', 
            [
                $request->start, 
                $request->end
            ])
        ->orderBy('date', 'desc')
        ->groupBy('items.id')
        ->get();

        $items_map = [];
        foreach($items as $item)
            $items_map[$item->date][] = [$item->title => $item->count];

        return view('charts/index')->withItems($items);
    }

}