<?php
namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Roles;
use App\Models\Admin;

class AuthController extends BaseController {
    public function register() {
        $roles = Roles::orderBy('priority', 'desc')->get();
        return view('auth.register')
            ->withRoles($roles);
    }

    public function login(Request $request) {
        $phone = substr($request->phone, 0, 1) == '+' ? substr($request->phone, 1, 12) : $request->phone;
        $credentials["phone"] = substr('380', 0, 12 - strlen($phone)) . $phone;
        $credentials["password"] = $request->password;

        if (Auth::attempt($credentials)) {
            if(Auth::user()->allowed == 0){
                Auth::logout();
                return back()->with('msg', 'Вашу заявку ще не прийняли');
            }
            $user = Auth::user();
            return redirect('/' . $user->role->accesses[0]->slug);
        }

        return back()->with('msg', 'He вірний номер телефона, a може i пароль');
    }

    public function adduser(Request $request) {
        $phone = substr($request->phone, 0, 1) == '+' ? substr($request->phone, 1, 12) : $request->phone;
        $phone = substr('380', 0, 12 - strlen($phone)) . $phone;

        if(isset(Admin::where('phone' , '=', $phone)->first()->pib))
            return redirect('/')->with('msg', 'Такий номер телефону вже зареєстрований');

        Admin::create([
            'pib' => $request->pib,
            'role_id' => $request->role,
            'phone' => $phone,
            'password' => $request->password,
            'allowed' => 0
        ]);

        return redirect('/')->with('msg', 'Вашу заявку було подано, очікуйте');
    }

    public function logout(Request $request) {
        Auth::logout();
        return redirect('/');
    }

}
