<?php
namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\RoleAccess;
use App\Models\Access;
use App\Models\Roles;

class RolesController extends BaseController {
    public function view() {
        $roleasseses = RoleAccess::select('role_id', 'title')
            ->join('accesses', 'accesses.id', '=', 'role_access.access_id')
            ->get();

        $roles = Roles::orderBy('priority')->get();

        return view('roles/index')
            ->withAccesses($roleasseses)
            ->withRoles($roles);
    }

    public function new() {
        $accesses = Access::all();
        return view('roles/new')
            ->withAccesses($accesses)
            ->withAct('add');
    }

    public function add(Request $request){
        $priority = $request->priority > Auth::user()->role->priority ? $request->priority : Auth::user()->role->priority + 1;

        $newrole = Roles::create([
            'title' => $request->title,
            'priority' => $priority,
        ]);

        if($request->accesses){
            for($i=0; $i<count($request->accesses); $i++){
                RoleAccess::create([
                    'role_id' => $newrole->id,
                    'access_id' => $request->accesses[$i], 
                ]);
            }
        }

        return redirect('/roles');
    }

    public function edit($id) {
        $toedit = Roles::find($id);
        $roles_access = RoleAccess::select('access_id')->where('role_id', '=', $id)->get();
        $roles_access2 = [];
        foreach($roles_access as $acc)
            $roles_access2[] = $acc->access_id;
        $accesses = Access::all();
        return view('roles/new')
            ->withAccesses($accesses)
            ->withEdit($toedit)
            ->withRoleaccesses($roles_access2)
            ->withAct('update');
    }

    public function update($id, Request $request){
        Roles::find($id)->update([
            'title' => $request->title,
            'priority' => $request->priority,
        ]);

        RoleAccess::where('role_id', '=', $id)->delete();
        if($request->accesses){
            for($i=0; $i<count($request->accesses); $i++){
                RoleAccess::create([
                    'role_id' => $id,
                    'access_id' => $request->accesses[$i], 
                ]);
            }
        }

        return redirect('/roles');
    }

    public function delete($id){
        $mess = '';
        try {
            Roles::destroy($id);
        } catch(\Illuminate\Database\QueryException $ex) {
            $mess = $ex->getCode();
        }
        return back()->with('msg', $mess);
    }

}