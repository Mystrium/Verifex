<?php
namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\WorkHour;
use App\Models\Consist;
use App\Models\Worker;
use App\Models\Item;

class ChartController extends BaseController {
    public function items(Request $request) {
        $start = $request->period[0] ?? Carbon::now()->subDays(30)->toDateString();
        $end  =  $request->period[1] ?? Carbon::now()->toDateString();

        $prods = Item::select('id')
            ->whereNotIn('items.id', 
                Consist::select('have_id')
                    ->get()
                    ->toArray())
            ->whereIn('items.id',
                Consist::select('what_id')
                    ->get()
                    ->toArray())
            ->get()
            ->pluck('id')
            ->toArray();

        $produced = Transaction::selectRaw('
                items.title,
                colors.title as color,
                item_id_id,
                color_id,
                count as count')
            ->join('items', 'items.id', '=', 'transactions.item_id_id')
            ->join('colors', 'colors.id', '=', 'transactions.color_id')
            ->whereBetween(DB::raw('DATE(date)'), [$start, $end])
            ->whereNull('worker_to_id')
            ->whereIn('item_id_id', $prods)
            // ->groupBy('item_id_id')
            ->get();

        $data = [];
        foreach($produced as $prd) {
            $data['label'][] = $prd->title;
            $data['val'][] = $prd->count;
        }

        return view('charts/index')
            ->withRoute('items')
            ->withPagetitle('Виробіток продукції')
            ->withPeriod([$start, $end])
            ->withData($data)
            ->withChart('pie')
            ->withTest($produced);
    }

    public function hours(Request $request){
        $start = $request->period[0] ?? Carbon::now()->subDays(30)->toDateString();
        $end  =  $request->period[1] ?? Carbon::now()->toDateString();

        $hours = WorkHour::selectRaw('workers.pib, worker_id, DATE(start) as date, TIME_TO_SEC(time) as time')
            ->join('workers', 'workers.id', '=', 'work_hours.worker_id')
            ->whereBetween(DB::raw('DATE(start)'), [$start, $end])
            ->get();

        // $data = [];
        // foreach($hours as $prd){
        //     $data['label'][] = $prd->date;
        //     $data['val'][] = $prd->time;
        // }

        // $data = [
        //     {"data":[
        //         {"x":1625443200,"y":11.74},
        //         {"x":1626048,"y":12.43},
        //         {"x":1626652800,"y":34.18}
        //     ],
        //     "label":"Hike"},
        //     {"data":[
        //         {"x":1624233600,"y":5.27},
        //         {"x":1630281600,"y":7.32}
        //     ],
        //     "label":"Kayaking"
        //     }
        // ];

        $lines = [];
        foreach($hours as $prd) {
            $lines[$prd->pib][] = [
                'x' => $prd->date,
                'y' => $prd->time
            ];
        }

        $data = [];
        foreach($lines as $line => $name){
            $data[] = [
                'data' => $line,
                'label' => $name
            ];
        }
        
        return view('charts/index')
            ->withRoute('hours')
            ->withPagetitle('Відвідування робітників')
            ->withPeriod([$start, $end])
            ->withData($data)
            ->withChart('line')
            ->withTest($hours);
    }
    
    public function payment(Request $request){
        $start = $request->period[0] ?? Carbon::now()->subDays(30)->toDateString();
        $end  =  $request->period[1] ?? Carbon::now()->toDateString();

        $pays = Worker::selectRaw(
                'workers.pib,
                workers.id,
                date(transactions.date) as date,
                sum(transactions.count * items.price) as value')
            ->join('transactions', 'transactions.worker_from_id', '=', 'workers.id')
            ->join('items', 'items.id', '=', 'transactions.item_id_id')
            ->whereNull('transactions.worker_to_id')
            ->whereBetween(
                DB::raw('DATE(date)'),
                [
                    $start,
                    $end
                ])
            ->orderBy('date', 'desc')
            ->groupByRaw('DATE(date)')
            ->get();

        $data = [];
        foreach($pays as $prd){
            $data['label'][] = $prd->pib;
            $data['val'][] = $prd->value;
        }

        return view('charts/index')
            ->withRoute('payment')
            ->withPagetitle('Рейтинг зарплат')
            ->withPeriod([$start, $end])
            ->withData($data)
            ->withChart('pie')
            ->withTest($pays);
    }

    public function production(Request $request){
        $start = $request->period[0] ?? Carbon::now()->subDays(30)->toDateString();
        $end  =  $request->period[1] ?? Carbon::now()->toDateString();

        $items = Worker::selectRaw(
            'workers.pib,
            workers.id,
            date(transactions.date) as date,
            sum(transactions.count) as count,
            items.title')
        ->join('transactions', 'transactions.worker_from_id', '=', 'workers.id')
        ->join('items', 'items.id', '=', 'transactions.item_id_id')
        ->whereNull('transactions.worker_to_id')
        ->whereBetween(
            DB::raw('DATE(date)'),
            [
                $start, 
                $end
            ])
        ->orderBy('date', 'desc')
        ->groupBy('items.id')
        ->get();

        $data = [];
        foreach($items as $prd){
            $data['label'][] = $prd->title;
            $data['val'][] = $prd->count;
        }

        return view('charts/index')
            ->withRoute('production')
            ->withPagetitle('Рейтинг виробітку')
            ->withPeriod([$start, $end])
            ->withData($data)
            ->withChart('pie')
            ->withTest($items);
    }

}