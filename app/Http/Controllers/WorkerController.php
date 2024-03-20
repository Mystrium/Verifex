<?php
namespace App\Http\Controllers;

use App\Models\Worker;
use App\Models\WorkType;
use App\Models\Ceh;
use App\Models\RoleItem;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class WorkerController extends BaseController {

    public function view(){
        $worktypes = WorkType::all();
        $cehs = Ceh::select('ceh.*','ceh_types.title as ctitle')->leftJoin('ceh_types', 'ceh_types.id', '=', 'ceh.type_id')->get();
        $workitems = Worker::all();
        return view('worker')
            ->withTypes($worktypes)
            ->withCehs($cehs)
            ->withWorkers($workitems);
    }

    public function add(Request $request){
        Worker::create([
            'pib' => $request->pib,
            'ceh_id' => $request->ceh,
            'role_id' => $request->type,
            'phone' => $request->phone,
            'passport' => $request->passport,
            'password' => $request->password,
            'checked' => 1
        ]);

        return redirect('/workers');
    }

    public function edit($id, Request $request){
        Worker::find($id)->update([
            'title' => $request->title,
            'unit_id' => $request->unit,
            'hascolor' => $request->hascolor,
            'price' => $request->price,
            'url_photo' => $request->photo,
            'url_instruction' => $request->instruction,
            'description' => $request->description
        ]);

        return redirect('/workers');
    }

    public function delete($id){
        Worker::destroy($id);

        return redirect('/workers');
    }

}