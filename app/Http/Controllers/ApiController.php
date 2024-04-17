<?php
namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Hash;

use App\Models\{
    TransactionType,
    Transaction,
    WorkHour,
    WorkType,
    Worker,
    Color,
    Item,
    Ceh
};

class ApiController extends BaseController {

    public function login(Request $request){
        $worker = Worker::where('phone', '=', $request->phone)->get()[0];
        if ($worker == null)
            return response(null, 404);
        if (!Hash::check($request->password, $worker->password))
            return response(null, 403);
        if ($worker->checked == 0)
            return response(null, 418);
        return response()->json($worker);
    }

    public function register(Request $request){
        if(isset(Worker::where('phone', '=', $request->phone)->get()[0]))
            return response(null, 409);
        $newworker = Worker::create([
            'pib'       => $request->pib,
            'ceh_id'    => $request->ceh_id,
            'role_id'   => $request->role_id,
            'phone'     => $request->phone,
            'passport'  => $request->passport,
            'password'  => $request->password,
            'checked'   => 0
        ]);
        return response()->json($newworker->id);
    }

    public function cehs(){
        $cehs = Ceh::select('ceh.*', 'ceh_types.title as type')
            ->join('ceh_types', 'ceh_types.id', '=', 'ceh.type_id')
            ->get();
        return response()->json($cehs);
    }

    public function roles(Request $request){
        $roles = WorkType::where('cehtype_id', '=', $request->type_id)->get();
        return response()->json($roles);
    }

    public function items(Request $request){
        $items = Item::select('items.*', 'units.title as unit')
            ->leftJoin('role_items', 'role_items.item_id', '=', 'items.id')
            ->join('units', 'units.id', '=', 'items.unit_id')
            ->where('role_id', '=', $request->role)
            ->get();
        return response()->json($items);
    }

    public function colors(){
        return response()->json(Color::all());
    }

    public function transtypes(Request $request) {
        $types = TransactionType::whereIn('id',
                explode(',',
                    WorkType::select('operations')
                        ->find($request->role_id)['operations']
                        )
            )->get();

        return response()->json($types);
    }

    public function transact(Request $request){
        $isok = Transaction::create([
            'type_id'        => $request->type_id,
            'worker_from_id' => $request->worker_from,
            'worker_to_id'   => $request->worker_to,
            'item_id_id'     => $request->item_id,
            'color_id'       => $request->color_id,
            'count'          => $request->count,
            'date'           => Carbon::now()
                                ->timezone('Europe/Kyiv')
                                ->toDateTimeString()
        ]);
        if ($isok == null)
            return response(null, 404);
        return response(null, 200);
    }

    public function worktime(Request $request){
        $isok = WorkHour::create([
            'worker_id' => $request->worker,
            'start'     => $request->start,
            'time'      => $request->time
        ]);
        if ($isok == null)
            return response(null, 404);
        return response(null, 200);
    }

    public function workers(Request $request) {
        $role = Worker::select('work_types.title')
            ->join('work_types', 'work_types.id', '=', 'workers.role_id')
            ->where('workers.id', '=', $request->id)
            ->get();

        if(isset($role[0]) && $role[0]->title == 'Кладовщик'){
            $workers = Worker::select('workers.id', 'pib', 'work_types.title as role', 'ceh.title', 'ceh_types.title as type')
            ->join('ceh', 'ceh.id', '=', 'workers.ceh_id')
            ->join('ceh_types', 'ceh_types.id', '=', 'ceh.type_id')
            ->join('work_types', 'work_types.id', '=', 'workers.role_id')
            ->where('workers.id', '<>', $request->id)
            ->whereRaw(
                'ceh_id IN ( 
                    SELECT ceh_id 
                    FROM workers 
                    WHERE id = ' . $request->id . ') 
                OR (work_types.title = "Кладовщик") 
                OR (workers.id = 1)')
            ->get();
            return response()->json($workers);
        }

        $workers = Worker::select('workers.id', 'pib', 'work_types.title as role', 'ceh.title', 'ceh_types.title as type')
            ->join('ceh', 'ceh.id', '=', 'workers.ceh_id')
            ->join('ceh_types', 'ceh_types.id', '=', 'ceh.type_id')
            ->join('work_types', 'work_types.id', '=', 'workers.role_id')
            ->where('workers.id', '<>', 1)
            ->where('workers.id', '<>', $request->id)
            ->whereRaw(
                'ceh_id IN ( 
                    SELECT ceh_id 
                    FROM workers 
                    WHERE id = ' . $request->id . 
                ')')
            ->get();
        return response()->json($workers);
    }

    public function hours_chart(Request $request){
        $hours = WorkHour::selectRaw('DATE(start) as date, time as value')
            ->where('worker_id', '=', $request->id)
            ->whereBetween('start', [$request->start, $request->end])
            ->orderBy('date', 'desc')
            ->get();

        // $hours_map = [];
        // foreach($hours as $hour)
        //     $hours_map[$hour->date] = $hour->time;

        return response()->json($hours);
    }

    public function pay_chart(Request $request){
        $pays = Worker::selectRaw(
                'date(transactions.date) as date,
                GREATEST(
                    sum(
                        if(transactions.type_id = 4, transactions.count * -1, transactions.count) 
                            * items.price), 
                        work_types.min_pay) 
                    as value')
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

        // $pay_map = [];
        // foreach($pays as $pay)
        //     $pay_map[$pay->date] = $pay->pay;

        return response()->json($pays);
    }

    public function items_chart(Request $request){
        $items = Worker::selectRaw(
            'date(transactions.date) as date,
            sum(if(transactions.type_id = 4, transactions.count * -1, transactions.count)) as count,
            items.title')
        ->join('transactions', 'transactions.worker_from_id', '=', 'workers.id')
        ->join('items', 'items.id', '=', 'transactions.item_id_id')
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

        return response()->json($items_map);
    }
}