<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\assign_subject;
use App\Models\Subjects;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubjectController extends Controller
{
    public function index(){
        
        $getdata = Subjects::all();
        $assignsubject = assign_subject::all();
        return view('forms.admin.Subject',compact('getdata','assignsubject'));

    }

    public function AddSubject(Request $request){
        
        $subject = new Subjects;
        $subject ->sub_name = $request->input('sub_name');
        $subject ->sub_create = Auth::user()->id;
        $subject ->sub_type = $request->sub_type;

        $subject->save();
        
        return response()->json([
            'status' => 200,
        ]);

    }

    public function EditSubject($id){

        $subject = Subjects::find($id);
        if($subject)
        {
            return response()->json([
                'status' => 200,
                'data' => $subject,
            ]);
        }
    }

    public function UpdateSubject(Request $request,$id){

        $subject = Subjects::find($id);
        $subject->sub_name = $request->input('sub_name');
        $subject->sub_status = $request->input('sub_status');
        $subject->sub_delete = $request->input('sub_delete');

        $subject->update();
        return response()->json([
            'status' => 200,
        ]);
    }

    public function AssignSubject(Request $request){

        foreach ($request->subject_id as $subjectid) {

            $assignsubject = new assign_subject();

            $assignsubject->class_id = $request->class_id;
            $assignsubject->as_create_by = Auth::user()->id;
            $assignsubject->subject_id = $subjectid;
            $assignsubject->save();
        }
        
        return response()->json([
            'status' => 200,
        ]);
    }

}
