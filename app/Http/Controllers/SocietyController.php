<?php

namespace App\Http\Controllers;

use App\Models\Society;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SocietyController extends Controller
{

    public function addsociety(Request $request)

    {

        $isValidate = Validator::make($request->all(), [
            'societyname' => 'required',
            'societyaddress' => 'required',
            'superadminid' => 'required|exists:users,id',


        ]);


        if ($isValidate->fails()) {
            return response()->json([
                "errors" => $isValidate->errors()->all(),
                "success" => false

            ], 403);
        }


        $society = new Society();


        $society->societyname = $request->societyname;
        $society->societyaddress = $request->societyaddress;
        $society->superadminid = $request->superadminid;
        $society->save();


        return response()->json(["data" => $society]);
    }


    public  function updatesociety (Request $request)


    {
        $isValidate = Validator::make($request->all(), [
            'societyname' => 'required',
            'societyaddress' => 'required',
            'id' => 'required|exists:societies,id',


        ]);


        if ($isValidate->fails()) {
            return response()->json([
                "errors" => $isValidate->errors()->all(),
                "success" => false

            ], 403);
        }


        $society = Society::find($request->id);


        $society->societyname = $request->societyname;
        $society->societyaddress = $request->societyaddress;
        $society->save();


        return response()->json([
            "success"=>true,
            "data" => $society,
        "message"=> "society update successfully"
    ]);



    }
    public function viewallsocieties($userid)

    {

        // dd($userid);

        $society = Society::where('superadminid', $userid)->get();


        return response()->json(["data" => $society]);
    }
    public function deletesociety($id)

    {

        // dd($userid);

        $society = Society::where('id', $id)->delete();


        return response()->json(["data" => $society,"message"=>"delete society successfully"]);
    }




     public function    searchsociety($q)
     {



         $society =  Society::where('societyname','LIKE','%' .$q.'%') ->
         orWhere('societyaddress','LIKE','%'.$q.'%')->get();

        return response()->json(["data" => $society]);

     }


}
