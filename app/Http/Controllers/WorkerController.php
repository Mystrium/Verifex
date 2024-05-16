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
            ->orderBy('id', 'desc')
            ->get();

        return view('workers/index')
            ->withWorkers($workers);
    }

    public function new() {
        $worktypes = WorkType::all();
        $cehs = Ceh::select('ceh.*','ceh_types.title as ctitle')
            ->leftJoin('ceh_types', 'ceh_types.id', '=', 'ceh.type_id')
            ->orderBy('type_id')
            ->get();

        $position_cehs = Ceh::selectRaw('ceh.id as cehid, work_types.id, work_types.title')
            ->join('ceh_types', 'ceh_types.id', '=', 'ceh.type_id')
            ->join('work_types', 'work_types.cehtype_id', '=', 'ceh_types.id')
            ->get();

        return view('workers/new')
            ->withAct('add')
            ->withTypes($worktypes)
            ->withCehs($cehs)
            ->withPosistionmap($position_cehs);
    }

    public function add(Request $request){
        $phone = substr($request->phone, 0, 1) == '+' ? substr($request->phone, 1, 12) : $request->phone;
        $phone = substr('380', 0, 12 - strlen($phone)) . $phone;

        $used_phone = Worker::where('phone', '=', $phone)->first();
        if(isset($used_phone))
            return back()->with('msg', 'Телефон вже використовується');

        Worker::create([
            'pib' => $request->pib,
            'ceh_id' => $request->ceh,
            'role_id' => $request->role,
            'phone' => $phone,
            'passport' => $request->passport,
            'password' => $request->password,
            'checked' => 1
        ]);

        return redirect('/workers');
    }

    public function edit($id) {
        $worker = Worker::find($id);
        if(empty($worker))
            abort(404);

        $cehs = Ceh::select('ceh.*','ceh_types.title as ctitle')
            ->leftJoin('ceh_types', 'ceh_types.id', '=', 'ceh.type_id')
            ->orderBy('type_id')
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
        $toedit = Worker::find($id);

        $phone = substr($request->phone, 0, 1) == '+' ? substr($request->phone, 1, 12) : $request->phone;
        $phone = substr('380', 0, 12 - strlen($phone)) . $phone;

        $used_phone = Worker::where('phone', '=', $phone)->first();
        if(isset($used_phone))
            if($used_phone->id != $id)
                return back()->with('msg', 'Телефон вже використовується');

        $toedit->pib = $request->pib;
        $toedit->ceh_id = $request->ceh;
        $toedit->role_id = $request->role;
        $toedit->phone = $phone;
        $toedit->passport = $request->passport;
        $toedit->checked = $request->checked ? 1 : 0;

        if(isset($request->password))
            $toedit->password = $request->password;

        $toedit->update();

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