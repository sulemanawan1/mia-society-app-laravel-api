<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Resident;
use App\Models\Owner;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ResidentController extends Controller
{
    public function registerresident(Request $request)


    {
        $isValidate = Validator::make($request->all(), [
            'firstname' => 'required|string|max:191',
            'lastname' => 'required|string|max:191',
            'cnic' => 'required|unique:users|max:191',
            'address' => 'required',
            'mobileno' => 'required',
            'roleid' => 'required',
            'rolename' => 'required',
            'password' => 'required',
            'image' => 'required|image',
            "subadminid"=>'required|exists:users,id',
            "vechileno"=>"required",
            "residenttype"=>"required",
            "propertytype"=>"required",
            "ownername"=>"nullable",
            "owneraddress"=>"nullable",
            "ownermobileno"=>"nullable",



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
        $user->address = $request->address;
        $user->mobileno = $request->mobileno;
        $user->roleid = $request->roleid;
        $user->rolename = $request->rolename;
        $user->password = Hash::make($request->password);
        $image = $request->file('image');
        $imageName = time() . "." . $image->extension();
        $image->move(public_path('/storage/'), $imageName);
        $user->image = $imageName;
        $user->save();
        $tk =   $user->createToken('token')->plainTextToken;
        $resident = new Resident;
        $resident->residentid=$user->id;
        $resident->subadminid=$request->subadminid;
        $resident->vechileno=$request->vechileno;
        $resident->residenttype=$request->residenttype;
        $resident->propertytype=$request->propertytype;
        $resident->save();


        if ($request->residenttype=="Rental")
        {
        $owner = new Owner;
        $owner->residentid=$resident->residentid;
        $owner->ownername=$request->ownername;
        $owner->owneraddress=$request->owneraddress;
        $owner->ownermobileno=$request->ownermobileno;
        $owner->save();


        }

        return response()->json(
            [
                "token" => $tk,
                "success" => true,
                "message" => "Resident Register to our system Successfully",
                "data" => $user,

            ]
        );





    }

    public function viewresidents($id)



    {
        $data = Resident::where('subadminid', $id)->join('users', 'users.id', '=', 'residents.residentid')->get();


        return response()->json(
            [
                "success" => true,
                "data" => $data


            ]

        );

    }


    public function deleteresident($id)

    {

        $resident= Resident::where('residentid', $id)->delete();

        return response()->json([

            "success" => true,
            "data" => $resident,
            "message" => "Resident Deleted successfully"
        ]);
    }

}
