<?php

namespace App\Http\Controllers;

use App\Response;
use Illuminate\Http\Request;
use DataTables;
use DB;

class ResponseController extends Controller
{
    public function getDataTable(){
        $data = Response::all();
        return Datatables::of($data)
            ->addColumn('action', function($data){
                return  '<a onclick="editDataResponse('. $data->id . ')" style="margin:2px;" class="btn btn-primary btn-xs"> Edit</a>' .
                        '<a onclick="deleteDataResponse('. $data->id . ')" style="margin:2px;" class="btn btn-danger btn-xs ">Delete</a>';
            })
            ->rawColumns(['action'])
            ->addIndexColumn()->make(true);
    }

    public function getById($id) {
        $result = DB::table('responses')->where('id', $id);
        if ($result->exists()){
            return response($result->get());
        } else {
            return response(['status' => false]);
        }
    }
    
    public function delete(Request $request) {
        $status = Response::destroy($request->id);
        if($status) {
            return response()->json(null);
        } else {
            return response()->json($status = 420);
        }
    }

    public function post(Request $request)
    {
        $data['code'] = $request->code;
        $data['question'] = str_replace('\r\n','\n',$request->question);
        $data['answer'] = str_replace('\r\n','\n',$request->answer);
        $status = Response::create($data);
        if ($status) {
            return response(['status' => true]);
        } else {
            return response(['status' => false]);
        }
    }

    public function update(Request $request) {
        $status = DB::table('responses')
            ->where('id', $request->id)
            ->update([
                'question' => $request->question,
                'answer' => $request->answer,
            ]);
        if ($status) {
            return response(['status' => true]);
        } else {
            return response(['status' => false]);
        }
    }

    public function checkCode($code)
    {
        $status = DB::table('responses')->where('code', $code);
        if (!$status->exists()){
            return response(['status' =>true]);
        } else {
            return response(['status' => false]);
        }
    }
}
