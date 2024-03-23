<?php
namespace App\Http\Controllers;

use App\Models\Ceh;
use App\Models\WorkType;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Models\Worker;
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
        return response()->json(Ceh::all());
    }

    public function roles(){
        return response()->json(WorkType::all());
    }

}