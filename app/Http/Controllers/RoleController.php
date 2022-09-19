<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
class RoleController extends Controller
{
public function  allusers(){

$user= User::all();


return response()->json(["data"=>$user]  );


}



    public function register(Request $request)
    {

        $isValidate = Validator::make($request->all(), [
            'firstname' => 'required|string|max:191',
            'lastname' => 'required|string|max:191',
            'cnic' => 'required|unique:users|max:191',
            'address' => 'required',
            'mobileno' => 'required|unique:users|max:191',
            'roleid' => 'required',
            'rolename' => 'required',
            'password' => 'required',
            'image' => 'required|image|max:2048',
        ]);


        if ($isValidate->fails()) {
            return response()->json([
                "errors" => $isValidate->errors()->all(),
                "success" => false

            ], 403);
        }

    //     $image = $request->image;
    //       //  base64 encoded
    //     $image = str_replace('data:image/png;base64,', '', $image);
    //     $image = str_replace(' ', '+', $image);
    //     $imageName = time().'.'.'png';
    //    File::put(public_path('images'). '/' . $imageName, base64_decode($image));

        $image = $request->file('image');
        $imageName= time().".".$image->extension();
        $image->move(public_path('images'), $imageName);



        $user = new User;

        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->cnic = $request->cnic;
        $user->address= $request->address;
        $user->mobileno= $request->mobileno;
        $user->roleid = $request->roleid;
        $user->rolename = $request->rolename;
        $user->image=$imageName;
        $user->password = Hash::make($request->password);
        $user->save();
        $tk =   $user->createToken('token')->plainTextToken;

        return response()->json(
            [
                "token" => $tk,
                "success" => true,
                "message" => "User Register Successfully",
                "data" => $user,
            ]
        );
    }



    public function login(Request $request)
    {

        $isValidate = Validator::make($request->all(), [

            'cnic' => 'required',
            'password' => 'required',
        ]);





        if ($isValidate->fails()) {
            return response()->json([
                "errors" => $isValidate->errors()->all(),
                "success" => false

            ], 403);
        } else if (Auth::attempt(['cnic' => $request->cnic, 'password' => $request->password])) {

            $user = Auth:: user();

            $tk =   $request->user()->createToken('token')->plainTextToken;


            return response()->json([
                "success" => true,
                "data" => $user,
                "Bearer" => $tk


            ]);
        } else if (!Auth::attempt(['cnic' => $request->cnic, 'password' => $request->password])) {

            return response()->json([
                "success" => false,
                "data" => "Unauthorized"

            ], 401);
        }
    }



    public function logout (Request $request) {


        $request->user()->currentAccessToken()->delete();

        return response(['message' => 'You have been successfully logged out.'], 200);
        }
}
