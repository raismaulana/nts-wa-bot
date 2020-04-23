<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use DataTables;
use Session;

class UserController extends Controller
{
    public function getDataTable(){
        $data = User::where('role', '!=' , 0)->get();
        return Datatables::of($data)
            ->addColumn('cRole', function($data){
                return ($data->role == 0) ? '<span class="badge badge-primary" style="background-color: blue;">Super Admin</span>' : '<span class="badge badge-secondary">Admin</span>' ; 
            })
            ->addColumn('cPassword', function(){
                return '**********';
            })
            ->addColumn('action', function($data){
                return  '<a onclick="editDataUser('. $data->id . ')" style="margin:2px;" class="btn btn-primary btn-xs"> Edit</a>' .
                        '<a onclick="deleteDataUser('. $data->id . ')" style="margin:2px;" class="btn btn-danger btn-xs ">Delete</a>';
            })
            ->addColumn('cCreateDate', function($data){
                return date("d-m-Y H.i.s", strtotime($data->created_at));
            })
            ->addColumn('cUpdateDate', function($data){
                return date("d-m-Y H.i.s", strtotime($data->updated_at));
            })
            ->rawColumns(['cRole', 'action'])
            ->addIndexColumn()->make(true);
    }

    public function getById($id) {
        $result = User::where('id', $id);
        if ($result->exists()){
            return response($result->get());
        } else {
            return response(['status' => false]);
        }
    }

    public function delete(Request $request) {
        $status = User::destroy($request->id);
        if($status){
            return response()->json(null);
        } else {
            return response()->json($status = 420);
        }
    }

    public function post(Request $request)
    {
        $request->merge(['password'=> bcrypt($request->password)]);
        $status = User::create($request->all());
        if ($status) {
            return response(['status' => true]);
        } else {
            return response(['status' => false]);
        }
    }

    public function update(Request $request) {
        $status = User::where('id', $request->id)
                    ->update([
                        'password' => bcrypt($request->password),
                    ]);
        if ($status) {
            return response(['status' => true]);
        } else {
            return response(['status' => false]);
        }
    }

    public function checkUsername($username)
    {
        $status = User::where('username', $username);
        if (!$status->exists()){
            return response(['status' =>true]);
        } else {
            return response(['status' => false]);
        }
    }
}
