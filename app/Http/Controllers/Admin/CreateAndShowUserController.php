<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CreateAndShowUserController extends Controller
{
    public function ShowUser(){
        $users = User::latest('id')->paginate(4);
        return view('forms.admin.CreateAndShowUser',compact('users'));
    }

    public function CreateUser(Request $request){

        // $this->validate($request, [
        //     'name' => 'required|min:5',
        //     'email' => 'required|max:255|email|unique:users',
        //     'password' => 'required|min:6'
        // ]);

        // $user = new User;
        // $user->name = $request->input('name');
        // $user->email = $request->input('email');
        // $user->password = Hash::make($request->input('password'));
        // $user->role=$request->role;

        // $user->save();

        // return redirect()->route('admin.ShowUser')->with('success','User Has Added');
        
        $validatetor = Validator::make($request->all(),[
            'name' => 'required|min:5',
            'email' => 'required|max:255|email|unique:users',
            'password' => 'required|min:6'
        ]);

        if($validatetor->fails())
        {
            return response()->json([
                'status' => 400,
                'errors' => $validatetor->messages(),
            ]);
        }
        else
        {
            $user = new User;
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->password = Hash::make($request->input('password'));
            $user->role = $request->role;
    
            $user->save();
            return response()->json([
                'status' => 200,
            ]);
        }
    }

    public function DeleteUser($id){
        $user = User::find($id);
        $user->delete();

        return response()->json([
            'status' => 200,
        ]);
    }

    public function EditUser($id){
        $user = User::find($id);
        if($user)
        {
            return response()->json([
                'status' => 200,
                'data' => $user
            ]);    
        }
    }

    public function UpdateUser(Request $request,$id)
    {
        $user = User::find($id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->role = $request->role;

        $user->update();
        return response()->json([
            'status' => 200,
        ]);
    }

    public function FilterUser(Request $request){
        $userrole = $request->filterUser;
        $users = User::where('role','=',$userrole)->get();

        if($users->count() >= 1)
        {
            return view('forms.admin.FilterUser',compact('users'));
        }
        else
        {
            return response()->json([
                'status' => 400,
            ]);
        }
    }

    public function SearchUser(Request $request){
        $users = User::where('email', 'like', '%' . $request->search . '%')->get();
        //$users = User::where('email','=',$request->search)->get();
        if($users->count() >= 1){
            return view('forms.admin.FilterUser',compact("users"));
        }
        else
        {
            return response()->json([
                'status' => 400,
            ]);
        }
    }
}
