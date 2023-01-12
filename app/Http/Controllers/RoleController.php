<?php
namespace App\Http\Controllers;

use App\Event\UserChat;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
class RoleController extends Controller
{
public function  allusers(){
// $user= User::all();
// return response()->json(["data"=>$user]  );
dd(file(public_path('/storage/1665565347.jpg')));
return response()->
file(
    public_path('/storage/1665565347.jpg')
);
}
    public function registeruser(Request $request)
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
        $image->move(public_path('/storage/'), $imageName);
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
            // dd($user->roleid);
        //     if($user->roleid==3)
        //     {
        //      $users = User::where('cnic', $user->cnic)
        //     ->join('residents', 'residents.residentid', '=' , 'users.id')->first();
        //     $tk =   $request->user()->createToken('token')->plainTextToken;
        //     return response()->json([
        //         "success" => true,
        //         "data" => $users,
        //         "Bearer" => $tk
        //     ]);
        // }

        if ($user->roleid == 3) {

            $users = User::where('cnic', $user->cnic)->first();
            $tk =   $request->user()->createToken('token')->plainTextToken;
            return response()->json([
                "success" => true,
                "data" => $users,
                "Bearer" => $tk
            ]);

        }
           else if($user->roleid==4)
            {
            $user = User::where('cnic', $user->cnic)
            ->join('gatekeepers', 'gatekeepers.gatekeeperid', '=' , 'users.id')->first();
            $tk =   $request->user()->createToken('token')->plainTextToken;
            return response()->json([
                "success" => true,
                "data" => $user,
                "Bearer" => $tk
            ]);}
            else if($user->roleid==2)
            {
            $user = User::where('cnic', $user->cnic)
            ->join('subadminsocieties', 'subadminsocieties.subadminid', '=' , 'users.id')->first();
            $tk =   $request->user()->createToken('token')->plainTextToken;
            return response()->json([
                "success" => true,
                "data" => $user,
                "Bearer" => $tk
            ]);}


            else if($user->roleid==5)
            {
                $user = User::where('cnic', $user->cnic)
            ->join('familymembers', 'familymembers.familymemberid', '=' , 'users.id')->select(
                'users.id',
                "users.firstname",
                "users.lastname",
                "users.cnic",
                "users.address",
                "users.mobileno",
                "users.roleid",
                "users.rolename",
                "users.created_at",
                "users.updated_at",
                "users.image",
                "users.fcmtoken",
                "familymembers.residentid",
                "familymembers.subadminid",


                )->first();

            $tk =   $request->user()->createToken('token')->plainTextToken;
            return response()->json([
                "success" => true,
                "data" => $user,
                "Bearer" => $tk
            ]);}
            else
            {
                $tk =   $request->user()->createToken('token')->plainTextToken;
                return response()->json([
                    "success" => true,
                    "data" => $user,
                    "Bearer" => $tk
                ]);
            }
        }
        else if (!Auth::attempt(['cnic' => $request->cnic, 'password' => $request->password])) {
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

        public  function fcmtokenrefresh(Request $request)


        {
            $isValidate = Validator::make($request->all(), [

                'id' => 'required|exists:users,id',
                'fcmtoken'=>'required'

            ]);

            if ($isValidate->fails()) {
                return response()->json([

                    "errors" => $isValidate->errors()->all(),
                    "success" => false

                ], 403);
            }
            $user = User::find($request->id);

            $user->fcmtoken = $request->fcmtoken;

            $user->update();


            return response()->json([
                "success" => true,
                "data" => $user,
                "message" => "fcm token  Updated Successfully"
            ]);
        }



        public  function resetpassword(Request $request)


        {
            $isValidate = Validator::make($request->all(), [

                'id' => 'required|exists:users,id',
                'password'=>'required'

            ]);

            if ($isValidate->fails()) {
                return response()->json([

                    "errors" => $isValidate->errors()->all(),
                    "success" => false

                ], 403);
            }
            $user = User::find($request->id);

            $user->password = Hash::make($request->password);;

            $user->update();


            return response()->json([
                "success" => true,
                "message" => "Password Updated Successfully"
            ]);
        }

        public function fire(){


            event(new UserChat('hello worldkekekekek'));


        }


}
