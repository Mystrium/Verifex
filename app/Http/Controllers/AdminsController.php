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

    public function add(Request $request) {
        $phone = substr($request->phone, 0, 1) == '+' ? substr($request->phone, 1, 12) : $request->phone;
        $phone = substr('380', 0, 12 - strlen($phone)) . $phone;

        $used_phone = Admin::where('phone', '=', $phone)->first();
        if(isset($used_phone))
            return back()->with('msg', 'Телефон вже використовується');

        Admin::create([
            'pib' => $request->pib,
            'role_id' => $request->role,
            'phone' => $phone,
            'password' => $request->password,
            'allowed' => 1
        ]);

        return redirect('/admins');
    }

    public function edit($id) {
        $edit = Admin::find($id);

        if(empty($edit))
            abort(404);

        if($edit->allowed == 1)
            if(Auth::user()->role->priority > $edit->role->priority)
                abort(403, 'У вашої ролі немає доступу до цієї сторінки :`(');

        $roles = Roles::all();

        return view('admins/new')
            ->withRoles($roles)
            ->withEdit($edit)
            ->withAct('update');
    }

    public function profile() {
        $edit = Admin::find(Auth::user()->id);

        $roles = Roles::all();

        return view('admins/new')
            ->withRoles($roles)
            ->withEdit($edit)
            ->withAct('update');
    }

    public function update($id, Request $request){
        $toedit = Admin::find($id);

        $phone = substr($request->phone, 0, 1) == '+' ? substr($request->phone, 1, 12) : $request->phone;
        $phone = substr('380', 0, 12 - strlen($phone)) . $phone;

        $used_phone = Admin::where('phone', '=', $phone)->first();
        if(isset($used_phone))
            if($used_phone->id != $id)
                return back()->with('msg', 'Телефон вже використовується');

        $toedit->pib = $request->pib;
        $toedit->role_id = $request->role;
        $toedit->phone = $phone;
        $toedit->allowed = $request->allowed ? 1 : 0;

        if(isset($request->password))
            $toedit->password = $request->password;

        $toedit->update();

        return redirect('/admins');
    }

    public function saveprofile(Request $request){
        $toedit = Admin::find(Auth::user()->id);

        $phone = substr($request->phone, 0, 1) == '+' ? substr($request->phone, 1, 12) : $request->phone;
        $phone = substr('380', 0, 12 - strlen($phone)) . $phone;

        $used_phone = Admin::where('phone', '=', $phone)->first();
        if(isset($used_phone))
            if($used_phone->id != Auth::user()->id)
                return back()->with('msg', 'Телефон вже використовується');

        $toedit->pib = $request->pib;
        $toedit->role_id = $request->role;
        $toedit->phone = $phone;
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