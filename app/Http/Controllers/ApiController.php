<?php
namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\TransactionType;
use App\Models\Transaction;
use App\Models\WorkHour;
use App\Models\WorkType;
use App\Models\Worker;
use App\Models\Color;
use App\Models\Item;
use App\Models\Ceh;
use Hash;

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

    public function transtypes(){
        return response()->json(TransactionType::all());
    }

    public function transact(Request $request){
        $isok = Transaction::create([
            'type_id'        => $request->type_id,
            'worker_from_id' => $request->worker_from,
            'worker_to_id'   => $request->worker_to,
            'item_id_id'     => $request->item_id,
            'color_id'       => $request->color_id,
            'count'          => $request->count,
            'date'           => Carbon::now()->toDateTimeString()
        ]);
        if ($isok == null)
            return response(null, 404);
        return response(null, 200);
    }

    public function worktime(Request $request){
        $isok = WorkHour::create([
            'worker_id' => $request->worker,
            'date'      => $request->date,
            'start'     => $request->start
        ]);
        if ($isok == null)
            return response(null, 404);
        return response(null, 200);
    }

    public function workers(Request $request){
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
                ') OR (work_types.title = "Кладовщик")')
            ->get();
        return response()->json($workers);
    }

}