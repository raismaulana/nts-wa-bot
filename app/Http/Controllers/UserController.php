<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// import file model Person
use App\User;

class UserController extends Controller
{
    // mengambil semua data
    public function all()
    {
        return User::all();
    }

    // mengambil data by id
    public function show($id)
    {
        return User::find($id);
    }

    // menambah data
    public function store(Request $request)
    {
        return User::create($request->all());
    }

    // mengubah data
    public function update($id, Request $request)
    {
        $user = User::find($id);
        $user->update($request->all());
        return $user;
    }

    // menghapus data
    public function delete($id)
    {
        $user = User::find($id);
        $user->delete();
        return 204;
    }
}
