<?php
namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Worker;


class MovementController extends BaseController {

    public function view(Request $request){
        $pays = Worker::
            select(DB::raw('sum(if(transactions.type_id = 4, transactions.count * -1, transactions.count) * items.price) as sum'), 'workers.id', 'workers.pib', 'work_types.min_pay', 'transactions.date')
            ->join('transactions', 'transactions.worker_from_id', '=', 'workers.id')
            ->join('items', 'items.id', '=', 'transactions.item_id_id')
            ->join('work_types', 'work_types.id', '=', 'workers.role_id')
            ->where('workers.id', '<>', 1)
            ->whereIn('transactions.type_id', [4, 3])
            ->orderBy('date', 'desc')
            ->groupBy('workers.id')
            ->get();
        
        return view('pay/index')->withPays($pays);
    }

}