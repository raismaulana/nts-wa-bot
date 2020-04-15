<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// import file model Person
use App\Auth;

class AuthController extends Controller
{
    // mengambil semua data
    public function all()
    {
        return Auth::all();
    }

    // mengambil data by id
    public function show($id)
    {
        return Auth::find($id);
    }

    // menambah data
    public function store(Request $request)
    {
        return Auth::create($request->all());
    }

    // mengubah data
    public function update($id, Request $request)
    {
        $auth = Auth::find($id);
        $auth->update($request->all());
        return $auth;
    }

    // menghapus data
    public function delete($id)
    {
        $auth = Auth::find($id);
        $auth->delete();
        return 204;
    }
}
