<?php

namespace App\Http\Controllers;

use App\Models\TaskLabel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskLabelController extends Controller
{
    public function get_all(){
        $user   = Auth::user();
        return TaskLabel::where("user_id",$user->id)->get();
    }

    public function insert(Request $request){
        $request->validate([
            "name"  => "required"
        ]);

        $user   = Auth::user();

        $data   = new TaskLabel();
        $data->name     = $request->input("name");
        $data->user_id  = $user->id;
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
            "name"  => "required"
        ]);

        $user   = Auth::user();

        $data   = TaskLabel::find($id);
        if(empty($data)){
            return response()->json([
                "status"    => "error",
                "message"   => "Data not found"
            ],422);
        }
        $data->name     = $request->input("name");

        if($user->id !== $data->user_id){
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

        $data   = TaskLabel::find($id);
        if(empty($data)){
            return response()->json([
                "status"    => "error",
                "message"   => "Data not found"
            ],422);
        }

        if($user->id !== $data->user_id){
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
