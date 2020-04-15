<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// import file model Person
use App\Response;

class ResponseController extends Controller
{
    // mengambil semua data
    public function all()
    {
        return Response::all();
    }

    // mengambil data by id
    public function show($id)
    {
        return Response::find($id);
    }

    // menambah data
    public function store(Request $request)
    {
        return Response::create($request->all());
    }

    // mengubah data
    public function update($id, Request $request)
    {
        $response = Response::find($id);
        $response->update($request->all());
        return $response;
    }

    // menghapus data
    public function delete($id)
    {
        $response = Response::find($id);
        $response->delete();
        return 204;
    }
}
