<?php

namespace App\Http\Controllers;

use App\Models\TaskLabel;
use App\Models\Tasks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TasksController extends Controller
{
    public function get_all($tasklabel_id){
        $user   = Auth::user();

        $tasklabel   = TaskLabel::find($tasklabel_id);
        if(empty($tasklabel->user_id) || $user->id !== $tasklabel->user_id){
            return response()->json([]);
        }

        return Tasks::where("tasklabel_id",$tasklabel_id)->get();
    }

    public function insert(Request $request){
        $request->validate([
            "tasklabel_id" => "required",
            "title"  => "required",
            "description"  => "required",
            "dueDate"  => "required|date_format:Y-m-d H:i",
        ]);

        $user   = Auth::user();

        $data   = new Tasks();
        $data->tasklabel_id     = $request->input("tasklabel_id");
        $data->title     = $request->input("title");
        $data->description     = $request->input("description");
        $data->dueDate     = $request->input("dueDate").":00";
        
        $tasklabel   = TaskLabel::find($data->tasklabel_id);
        if(empty($tasklabel->user_id) || $user->id !== $tasklabel->user_id){
            return response()->json([
                "status"    => "error",
                "message"   => "Failed, please try again"
            ],422);
        }
        
        if($data->save()){
            return response()->json([
                "status"    => "success",
                "message"   => "Successfuly insert data"
            ]);
        }
        
        return response()->json([
            "status"    => "error",
            "message"   => "Failed, please try again"
        ],422);
    }

    public function update(Request $request,$id){
        $request->validate([
            "title"  => "required",
            "description"  => "required",
            "dueDate"  => "required|date_format:Y-m-d H:i",
        ]);

        $user   = Auth::user();

        $data   = Tasks::find($id);
        if(empty($data)){
            return response()->json([
                "status"    => "error",
                "message"   => "Data not found"
            ],422);
        }

        $data->title     = $request->input("title");
        $data->description     = $request->input("description");
        $data->dueDate     = $request->input("dueDate").":00";

        $tasklabel   = TaskLabel::find($data->tasklabel_id);
        if(empty($tasklabel->user_id) || $user->id !== $tasklabel->user_id){
            return response()->json([
                "status"    => "error",
                "message"   => "Failed, please try again"
            ],422);
        }

        if($data->save()){
            return response()->json([
                "status"    => "success",
                "message"   => "Successfuly update data"
            ]);
        }

        return response()->json([
            "status"    => "error",
            "message"   => "Failed, please try again"
        ],422);
    }

    public function delete(Request $request,$id){

        $user   = Auth::user();

        $data   = Tasks::find($id);
        if(empty($data)){
            return response()->json([
                "status"    => "error",
                "message"   => "Data not found"
            ],422);
        }

        $tasklabel   = TaskLabel::find($data->tasklabel_id);
        if(empty($tasklabel->user_id) || $user->id !== $tasklabel->user_id){
            return response()->json([
                "status"    => "error",
                "message"   => "Failed, please try again"
            ],422);
        }

        if($data->delete()){
            return response()->json([
                "status"    => "success",
                "message"   => "Successfuly delete data"
            ]);
        }

        return response()->json([
            "status"    => "error",
            "message"   => "Failed, please try again"
        ],422);
    }
    
}
