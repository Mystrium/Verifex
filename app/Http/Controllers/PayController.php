<?php
namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use App\Models\Worker;


class PayController extends BaseController {
    public function view(Request $request) {
        $start = $request->period[0] ?? Carbon::now()->startOfWeek()->subDays(7)->toDateString();
        $end = $request->period[1] ?? Carbon::now()->startOfWeek()->toDateString();
        
        $pays = Worker::selectRaw('
                DATE_FORMAT(transactions.date, "%d.%m.%Y") as date, 
                sum(transactions.count * items.price) as sum,
                workers.id,
                workers.pib, 
                work_types.min_pay')
            ->join('transactions', 'transactions.worker_from_id', '=', 'workers.id')
            ->join('items', 'items.id', '=', 'transactions.item_id_id')
            ->join('work_types', 'work_types.id', '=', 'workers.role_id')
            ->whereNull('transactions.worker_to_id')
            ->whereBetween(DB::raw('DATE(date)'), [$start, $end])
            ->orderBy('date', 'asc')
            ->groupByRaw('workers.id, WEEK(DATE(date))')
            ->get();
        
        return view('pay/index')
            ->withPeriod([$start, $end])
            ->withPays($pays);
    }

    public function byworker($id, Request $request) {
        $start = $request->period[0] ?? Carbon::now()->startOfWeek()->subDays(7)->toDateString();
        $end = $request->period[1] ?? Carbon::now()->startOfWeek()->toDateString();

        $worker = Worker::select('workers.pib')->find($id);
        $pays = Worker::select(
                'transactions.count', 
                'items.price', 
                'workers.id',
                'items.title', 
                'work_types.min_pay', 
                'transactions.date')
            ->join('transactions', 'transactions.worker_from_id', '=', 'workers.id')
            ->join('items', 'items.id', '=', 'transactions.item_id_id')
            ->join('work_types', 'work_types.id', '=', 'workers.role_id')
            ->where('workers.id', '=', $id)
            ->whereBetween(DB::raw('DATE(date)'), [$start, $end])
            ->whereNull('transactions.worker_to_id')
            ->orderBy('date', 'asc')
            ->get();
        
        return view('pay/worker')
            ->withWorker($worker)
            ->withPays($pays);
    }
    
}