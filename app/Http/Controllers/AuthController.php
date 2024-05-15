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
        $credentials = $request->only('phone', 'password');

        if (Auth::attempt($credentials)) {
            if(Auth::user()->allowed == 0){
                Auth::logout();
                return back()->with('msg', 'Вашу заявку ще не прийняли');
            }
            return redirect('/items');
        }

        return back()->with('msg', 'Не вірний номер телефона, а може і пароль');
    }

    public function adduser(Request $request) {
        $phone = substr('380', 0, 12 - strlen($request->phone)) . $request->phone;

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
