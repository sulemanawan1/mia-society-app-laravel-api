<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

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
            'roleid' => 'required',
            'rolename' => 'required',
            'password' => 'required',
        ]);


        if ($isValidate->fails()) {
            return response()->json([
                "errors" => $isValidate->errors()->all(),
                "success" => false

            ], 403);
        }
        $user = new User;


        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->cnic = $request->cnic;
        $user->roleid = $request->roleid;
        $user->rolename = $request->rolename;
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

            $user = Auth::user();
            $tk =   $request->user()->createToken('token')->plainTextToken;



            return response()->json([
                "success" => false,
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
}
