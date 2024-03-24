<?php
namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Models\WorkType;
use App\Models\Worker;
use App\Models\Item;
use App\Models\Ceh;
use Hash;

class ApiController extends BaseController {

    public function login(Request $request){
        $worker = Worker::where('phone', '=', $request->phone)->get()[0];
        if($worker == null)
            return response(null, 404);
        if (!Hash::check($request->password, $worker->password))
            return response(null, 403);
        return response()->json($worker);
    }

    public function register(Request $request){
        if(Worker::where('phone', '=', $request->phone) != null)
            return response(null, 409);
        $newworker = Worker::create([
            'pib' => $request->pib,
            'ceh_id' => $request->ceh,
            'role_id' => $request->type,
            'phone' => $request->phone,
            'passport' => $request->passport,
            'password' => $request->password,
            'checked' => 0
        ]);
        return response()->json($newworker);
    }

    public function cehs(){
        $cehs = Ceh::select('ceh.*', 'ceh_types.title as type')
            ->join('ceh_types', 'ceh_types.id', '=', 'ceh.type_id')
            ->get();
        return response()->json();
    }

    public function roles(Request $request){
        $roles = WorkType::where('cehtype_id', '=', $request->type_id)->get();
        return response()->json($roles);
    }

    public function items(Request $request){
        $items = Item::select('items.*')
            ->leftJoin('role_items', 'role_items.item_id', '=', 'items.id')
            ->where('role_id', '=', $request->role);
        return response()->json($items);
    }


}