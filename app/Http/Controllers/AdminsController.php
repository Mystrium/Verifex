<?php
namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Roles;
use App\Models\Admin;

class AdminsController extends BaseController {
    public function view(){
        $admins = Admin::select('admins.*', 'roles.title as role', 'roles.priority as prior')
            ->leftJoin('roles', 'roles.id', '=', 'admins.role_id')
            ->orderBy('priority')
            ->get();

        return view('admins/index')
            ->withAdmins($admins);
    }

    public function new() {
        $roles = Roles::orderBy('priority', 'desc')->get();

        return view('admins/new')
            ->withAct('add')
            ->withRoles($roles);
    }

    public function add(Request $request){
        Admin::create([
            'pib' => $request->pib,
            'role_id' => $request->role,
            'phone' => substr('380', 0, 12 - strlen($request->phone)) . $request->phone,
            'password' => $request->password,
            'allowed' => 1
        ]);

        return redirect('/admins');
    }

    public function edit($id) {
        $edit = Admin::find($id);
        
        if(empty($edit))
            abort(404);

        if(Auth::user()->role->priority <= $edit->role->priority)
            abort(403, 'У вашої ролі немає доступу до цієї сторінки :`(');

        $roles = Roles::all();

        return view('admins/new')
            ->withRoles($roles)
            ->withEdit($edit)
            ->withAct('update');
    }

    public function update($id, Request $request){
        $toedit = Admin::find($request->id);

        $toedit->pib = $request->pib;
        $toedit->role_id = $request->role;
        $toedit->phone = $request->phone;
        $toedit->allowed = $request->allowed ? 1 : 0;

        if(isset($request->password))
            $toedit->password = $request->password;

        $toedit->update();

        return redirect('/admins');
    }

    public function delete($id) {
        $mess = '';
        try {
            Admin::destroy($id);
        } catch(\Illuminate\Database\QueryException $ex) {
            $mess = $ex->getCode();
        }

        return back()->with('msg', $mess);
    }

    public function check($id, Request $request){
        Admin::find($id)->update(['allowed' => $request->status ? 1 : 0]);

        return redirect('/admins');
    }

}