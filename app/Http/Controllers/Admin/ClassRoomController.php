<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassRoom;
use App\Models\Subjects;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClassRoomController extends Controller
{
    public function index(){
        $getdata = ClassRoom::all();
        $getdatasubject = Subjects::all();
        return view('forms.admin.ClassRoom',compact('getdata','getdatasubject'));
    }

    public function AddClass(Request $request){

        $class = new ClassRoom;
        $class ->cr_name = $request->input('cr_name');
        $class ->cr_created_by = Auth::user()->id;

        $class->save();

        return response()->json([
            'status' => 200,
        ]);
        
    }

    public function EditClass ($id){
        $classroom = ClassRoom::find($id);
        if($classroom)
        {
            return response()->json([
                'status' => 200,
                'data' => $classroom,
            ]);
        }
    }

    public function UpdateClass(Request $request,$id){

        $classroom = ClassRoom::find($id);
        $classroom->cr_name = $request->input('cr_name');
        $classroom->cr_status = $request->input('cr_status');
        $classroom->cr_deleted = $request->input('cr_deleted');

        $classroom->update();
        return response()->json([
            'status' => 200,
        ]);

    }

    public function FilterStatus(Request $request){

        $classstatus = $request->filterStatus;
        $getdata = ClassRoom::where('cr_status','=',$classstatus)->get();

        if($getdata->count() >= 1)
        {
            return view('forms.admin.FilterClassRoom',compact('getdata'));
        }
        else
        {
            return response()->json([
                'status' => 400,
            ]);
        }
    }
}
