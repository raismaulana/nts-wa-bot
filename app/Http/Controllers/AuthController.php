<?php

namespace App\Http\Controllers;

use Session;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function login(Request $request)
    {   
        $u = $request->post('username');
        $p = $request->post('password');

        $user = DB::table('users')->whereRaw("BINARY `username` = ?",[$u]);

        if ($user->exists()) {
            $user = $user->first();
            if (Hash::check($p, $user->password)) {
                Session::put(['id' => $user->id, 'name' => $user->name, 'username' => $user->username, 'role' => $user->role]);
                if ($user->role == 1) {
                    return redirect('home');
                } else {
                    return redirect('home');
                }
            } else {
                return redirect('/');
            }
        } else {
            return redirect('/');
        }
        // return redirect('home');
    }

    public function logout()
    {
        Session::flush();
        return redirect('/');
    }
}
