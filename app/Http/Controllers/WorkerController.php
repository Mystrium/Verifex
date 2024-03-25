<?php
namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Models\WorkType;
use App\Models\Worker;
use App\Models\Ceh;

class WorkerController extends BaseController {

    public function view(){
        $workers = Worker::select('workers.*', 'ceh.title','ceh_types.title as ctitle', 'work_types.title as role')
            ->leftJoin('ceh', 'ceh.id', '=', 'workers.ceh_id')
            ->leftJoin('ceh_types', 'ceh_types.id', '=', 'ceh.type_id')
            ->leftJoin('work_types', 'work_types.id', '=', 'workers.role_id')
            ->get();
        $cehs = Ceh::select('ceh.*','ceh_types.title as ctitle')->leftJoin('ceh_types', 'ceh_types.id', '=', 'ceh.type_id')->get();
        $worktypes = WorkType::all();
        return view('workers/index')
            ->withTypes($worktypes)
            ->withCehs($cehs)
            ->withWorkers($workers);
    }

    public function new() {
        $worktypes = WorkType::all();
        $cehs = Ceh::select('ceh.*','ceh_types.title as ctitle')
            ->leftJoin('ceh_types', 'ceh_types.id', '=', 'ceh.type_id')
            ->get();
        $worker = Worker::all();
        return view('workers/new')
            ->withAct('add')
            ->withTypes($worktypes)
            ->withCehs($cehs)
            ->withWorkers($worker);
    }

    public function add(Request $request){
        Worker::create([
            'pib' => $request->pib,
            'ceh_id' => $request->ceh,
            'role_id' => $request->role,
            'phone' => $request->phone,
            'passport' => $request->passport,
            'password' => $request->password,
            'checked' => 1
        ]);

        return redirect('/workers');
    }

    public function edit($id) {
        $worker = Worker::find($id);
        $cehs = Ceh::select('ceh.*','ceh_types.title as ctitle')
            ->leftJoin('ceh_types', 'ceh_types.id', '=', 'ceh.type_id')
            ->get();
        $worktypes = WorkType::all();
        return view('workers/new')
            ->withTypes($worktypes)
            ->withCehs($cehs)
            ->withEdit($worker)
            ->withAct('update');
    }

    public function update($id, Request $request){
        if($request->password != null){
            Worker::find($id)->update([
                'pib' => $request->pib,
                'ceh_id' => $request->ceh,
                'role_id' => $request->role,
                'phone' => $request->phone,
                'passport' => $request->passport,
                'password' => $request->password,
                'checked' => $request->cheched ? 1 : 0
            ]);
        } else {
            Worker::find($id)->update([
                'pib' => $request->pib,
                'ceh_id' => $request->ceh,
                'role_id' => $request->role,
                'phone' => $request->phone,
                'passport' => $request->passport,
                'checked' => $request->cheched ? 1 : 0
            ]);
        }

        return redirect('/workers');
    }

    public function delete($id){
        Worker::destroy($id);

        return redirect('/workers');
    }

}