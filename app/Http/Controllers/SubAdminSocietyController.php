<?php

namespace App\Http\Controllers;

use App\Models\subadminsociety;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class SubAdminSocietyController extends Controller
{

    public function   registersubadmin(Request $request)

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
            'superadminid' => 'required|exists:users,id',
            'societyid' => 'required|exists:societies,id'

        ]);
        if ($isValidate->fails()) {
            return response()->json([
                "errors" => $isValidate->errors()->all(),
                "success" => false

            ], 403);
        }
        $image = $request->file('image');
        $imageName= time().".".$image->extension();
        $image->move(public_path('images'), $imageName);

        $user = new User;
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->cnic = $request->cnic;
        $user->address = $request->address;
        $user->mobileno = $request->mobileno;
        $user->roleid = $request->roleid;
        $user->rolename = $request->rolename;
        $user->password = Hash::make($request->password);
        $user->image = $imageName;
        $user->save();
        $tk =   $user->createToken('token')->plainTextToken;
        $subadminsociety = new subadminsociety;
        $subadminsociety->superadminid = $request->superadminid;
        $subadminsociety->societyid = $request->societyid;
        $subadminsociety->subadminid = $user->id;

        $subadminsociety->save();

        return response()->json(
            [
                "token" => $tk,
                "success" => true,
                "message" => "Sub Admin Assign to Society Successfully",
                "data" => $user,
            ]
        );
    }

    public function deletesubadmin($id)

    {

        $userid = User::where('id', $id)->delete();

        return response()->json([

            "success" => true,
            "data" => $userid,
            "message" => "Sub admin Deleted successfully"
        ]);
    }


    public  function updatesubadmin(Request $request)


    {
        $isValidate = Validator::make($request->all(), [
            'firstname' => 'required|string|max:191',
            'lastname' => 'required|string|max:191',
            'cnic' => 'required|unique:users|max:191',
            'mobileno' => 'required|unique:users|max:191',
            'address' => 'required',
            'password' => 'required',
            'id'=>'required'

        ]);

        if ($isValidate->fails()) {
            return response()->json([

                "errors" => $isValidate->errors()->all(),
                "success" => false

            ], 403);
        }

        $user = User::find($request->id);

        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->cnic = $request->cnic;
        $user->mobileno = $request->mobileno;
        $user->address = $request->address;
        $user->password = $request->password;
        $user->save();

        return response()->json([
            "success" => true,
            "data" => $user,
            "message" => "Sub Admin Details Updated Successfully"
        ]);
    }

    public  function viewsubadmin($id)


    {
        // $subadmin = subadminsociety::where('superadminid', $id)->get();

      $data= subadminsociety::where('superadminid', $id) ->
      join('users', 'users.id', '=', 'subadminsocieties.superadminid')->get();


        // $subadmin = subadminsociety::where('superadminid', $id)->get();

        return response()->json(["success"=> true,
            "data" =>$data


            ]

        );




    }
}

