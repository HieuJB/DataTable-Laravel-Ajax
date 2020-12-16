<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\modelBooks;
use DataTables;
class BooksController extends Controller
{
   
    public function index(Request $request)
    {
        $books = modelBooks::all();
        if($request->ajax()){
            $data = modelBooks::all();
            return DataTables::of($data)->addIndexColumn()->addColumn('action',function($row){
                $btn = '<a href="javascript:void(0)"  data-toggle="tooltip" id="edit" data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editBook">Edit</a>';
                $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip" id="remove"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteBook">Delete</a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
        return view('book',compact('books'));
    }

    public function add_data(Request $req){
       $data_add = new modelBooks();
       $data_add->name=$req->name;
       $data_add->email=$req->email;
       $data_add->save();
       return Response()->json($data_add);
   }
    public function find_id_edit(Request $req){
    $Data_find = modelBooks::find($req->id);
    return Response()->json($Data_find);
    }
    public function edit_data(Request $req){
        $data_edit = modelBooks::find($req->id);
        $data_edit->name=$req->name;
        $data_edit->email=$req->email;
        $data_edit->save();
        return Response()->json($data_edit);
    }
    public function remove_data(Request $req){
        $data_remove = modelBooks::find($req->id);
        $data_remove->delete();
        return Response()->json($data_remove);

    }
}
