<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    //

    public function index(){
        $studentData = Student::all();
        return view('forms.admin.Student',compact('studentData'));
    }
    
    public function Addstudent(Request $request){
        $studentAcc = new User();
        $studentAcc -> name = $request -> name;
        $studentAcc -> email = $request -> email;
        $studentAcc -> password = $request -> password;
        $studentAcc -> save();

        $request -> validate([
            'profile' => 'image|mimes:jpeg,png,jpg',
        ]);

        $studentInfo = new Student();
        $studentInfo -> fname = $request -> input('fname');
        $studentInfo -> lname = $request -> input('lname');
        $studentInfo -> gender = $request -> gender;
        $studentInfo -> dob = $request -> input('dob');
        $studentInfo -> phone = $request -> input('phone');

        if($request -> hasFile('profile')){ // insert image
            $file = $request -> file('profile');
            $extension = $file -> getClientOriginalExtension(); 
            $profile = time(). '.' .$extension;
            $file ->move('storage/images/',$profile);
            $studentInfo -> profile = $profile;
        }

        $studentInfo -> save();

        return response()->json([
            'status' => 200, 
        ]);
    }

    public function EditStudent($id){
        $student = Student::find($id);

        if($student)
        {
            return response()->json([
                'status' => 200,
                'data' => $student,
            ]);
        }
    }

    public function UpdateStudent(Request $request , $id){


        $request -> validate([
            'profile' => 'image|mimes:jpeg,png,jpg',
        ]);

        $studentInfo = Student::find($id);
        $studentInfo -> fname = $request -> input('updatefname');
        $studentInfo -> lname = $request -> input('updatelname');
        $studentInfo -> gender = $request -> updategender;
        $studentInfo -> dob = $request -> input('updatedob');
        $studentInfo -> phone = $request -> input('updatephone');

        if($request -> hasFile('updateprofile')){ // insert image
            $file = $request -> file('updateprofile');
            $extension = $file -> getClientOriginalExtension(); 
            $profile = time(). '.' .$extension;
            $file ->move('storage/images/',$profile);
            $studentInfo -> profile = $profile;
        }

        $studentInfo ->update();

        return response()->json([
            'status' => 200, 
        ]);
    }
}
