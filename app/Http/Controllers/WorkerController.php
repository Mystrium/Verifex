<?php
namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Models\WorkType;
use App\Models\Worker;
use App\Models\Ceh;
use Illuminate\Support\Facades\Redirect;

class WorkerController extends BaseController {

    public function view(){
        $workers = Worker::where('workers.id', '<>', '1')
            ->select('workers.*', 'ceh.title','ceh_types.title as ctitle', 'work_types.title as role')
            ->leftJoin('ceh', 'ceh.id', '=', 'workers.ceh_id')
            ->leftJoin('ceh_types', 'ceh_types.id', '=', 'ceh.type_id')
            ->leftJoin('work_types', 'work_types.id', '=', 'workers.role_id')
            ->get();

        return view('workers/index')
            ->withWorkers($workers);
    }

    public function new() {
        $worktypes = WorkType::all();
        $cehs = Ceh::select('ceh.*','ceh_types.title as ctitle')
            ->leftJoin('ceh_types', 'ceh_types.id', '=', 'ceh.type_id')
            ->get();
        $worker = Worker::all();

        $position_cehs = Ceh::selectRaw('ceh.id as cehid, work_types.id, work_types.title')
            ->join('ceh_types', 'ceh_types.id', '=', 'ceh.type_id')
            ->join('work_types', 'work_types.cehtype_id', '=', 'ceh_types.id')
            ->get();

        return view('workers/new')
            ->withAct('add')
            ->withTypes($worktypes)
            ->withCehs($cehs)
            ->withPosistionmap($position_cehs)
            ->withWorkers($worker);
    }

    public function add(Request $request){
        Worker::create([
            'pib' => $request->pib,
            'ceh_id' => $request->ceh,
            'role_id' => $request->role,
            'phone' => substr('380', 0, 12 - strlen($request->phone)) . $request->phone,
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

        $position_cehs = Ceh::selectRaw('ceh.id as cehid, work_types.id, work_types.title')
        ->join('ceh_types', 'ceh_types.id', '=', 'ceh.type_id')
        ->join('work_types', 'work_types.cehtype_id', '=', 'ceh_types.id')
        ->get();
        
        return view('workers/new')
            ->withTypes($worktypes)
            ->withCehs($cehs)
            ->withEdit($worker)
            ->withPosistionmap($position_cehs)
            ->withAct('update');
    }

    public function update($id, Request $request){
        if($request->password != null){
            Worker::find($id)->update([
                'pib' => $request->pib,
                'ceh_id' => $request->ceh,
                'role_id' => $request->role,
                'phone' => substr('380', 0, 12 - strlen($request->phone)) . $request->phone,
                'passport' => $request->passport,
                'password' => $request->password,
                'checked' => $request->checked ? 1 : 0
            ]);
        } else {
            Worker::find($id)->update([
                'pib' => $request->pib,
                'ceh_id' => $request->ceh,
                'role_id' => $request->role,
                'phone' => substr('380', 0, 12 - strlen($request->phone)) . $request->phone,
                'passport' => $request->passport,
                'checked' => $request->checked ? 1 : 0
            ]);
        }

        return redirect('/workers');
    }

    public function delete($id) {
        $mess = '';
        try {
            Worker::destroy($id);
        } catch(\Illuminate\Database\QueryException $ex) {
            $mess = $ex->getCode();
        }

        return back()->with('msg', $mess);
    }

    public function check($id, Request $request){
        Worker::find($id)->update(['checked' => $request->status ? 1 : 0]);

        return redirect('/workers');
    }

}