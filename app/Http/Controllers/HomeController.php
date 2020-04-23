<?php

namespace App\Http\Controllers;

use App\Auth;
use Illuminate\Http\Request;
use Session;

class HomeController extends Controller
{

    public function index()
    {
        $role = Session::get('role');
        $name = Session::get('name');
        $context = ['name' => $name];
        if($role == '1') {
            $context += ['role' => 'Administrator',];
            return view('home', $context);
        } else {
            $context += ['role' => 'Super Administrator',];
            return view('su/home', $context);
        }
    }
}
