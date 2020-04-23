<?php

namespace App\Http\Controllers;

use App\Phone;
use Illuminate\Http\Request;
use DataTables;

class PhoneController extends Controller
{
    public function getDataTable(){
        $data = Phone::all();
        return Datatables::of($data)
            ->addColumn('action', function($data){
                return '<a onclick="deleteDataPhone('. $data->id . ')" style="margin:2px;" class="btn btn-danger btn-xs ">Delete</a>';
            })
            ->addColumn('cCreateDate', function($data){
                return date("d-m-Y H.i.s", strtotime($data->created_at));;
            })
            ->addColumn('cUpdateDate', function($data){
                return date("d-m-Y H.i.s", strtotime($data->updated_at));;
            })
            ->rawColumns(['action'])
            ->addIndexColumn()->make(true);
    }

    public function delete(Request $request) {
        $status = Phone::destroy($request->id);
        if($status){
            return response()->json(null);
        } else {
            return response()->json($status = 420);
        }
    }
}
