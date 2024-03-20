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
        if (!Hash::check($request->password, $worker->password))
            $worker = null;
        return json_encode($worker);
    }

    public function register(Request $request){
        $newworker = Worker::create([
            'pib' => $request->pib,
            'ceh_id' => $request->ceh,
            'role_id' => $request->type,
            'phone' => $request->phone,
            'passport' => $request->passport,
            'password' => $request->password,
            'checked' => 0
        ]);
        return json_encode($newworker);
    }

    public function cehs(){
        return json_encode(Ceh::all());
    }

    public function roles(){
        return json_encode(WorkType::all());
    }

}