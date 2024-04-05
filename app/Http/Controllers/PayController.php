<?php
namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use App\Models\Worker;


class PayController extends BaseController {

    public function view(){
        $pays = Worker::selectRaw('
                DATE_FORMAT(transactions.date, "%d.%m.%Y") as date, 
                sum(if(transactions.type_id = 4, transactions.count * -1, transactions.count) * items.price) as sum,
                workers.id,
                workers.pib, 
                work_types.min_pay')
            ->join('transactions', 'transactions.worker_from_id', '=', 'workers.id')
            ->join('items', 'items.id', '=', 'transactions.item_id_id')
            ->join('work_types', 'work_types.id', '=', 'workers.role_id')
            ->where('workers.id', '<>', 1)
            ->whereIn('transactions.type_id', [4, 3])
            ->orderBy('date', 'desc')
            ->groupByRaw('workers.id, DATE(date)')
            ->get();
        
        return view('pay/index')->withPays($pays);
    }

    public function byworker($id){
        $worker = Worker::select('workers.pib')->find($id);
        $pays = Worker::select(
                'transactions.count', 
                'items.price', 
                'workers.id',
                'items.title', 
                'work_types.min_pay', 
                'transactions.date', 
                'transactions.type_id')
            ->join('transactions', 'transactions.worker_from_id', '=', 'workers.id')
            ->join('items', 'items.id', '=', 'transactions.item_id_id')
            ->join('work_types', 'work_types.id', '=', 'workers.role_id')
            ->where('workers.id', '=', $id)
            ->whereIn('transactions.type_id', [4, 3])
            ->orderBy('date', 'desc')
            ->get();
        
        return view('pay/worker')
            ->withWorker($worker)
            ->withPays($pays);
    }


}