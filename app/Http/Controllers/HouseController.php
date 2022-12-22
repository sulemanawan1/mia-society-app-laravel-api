<?php

namespace App\Http\Controllers;

use App\Models\House;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class HouseController extends Controller
{

    // public function addhouses(Request $request)
    // {

    //  $isValidate = Validator::make($request->all(), [

    //         'sid'=>'required|exists:streets,id',
    //          'from'=>'required',
    //          'to'=>'required',
    //     ]);
    //     if ($isValidate->fails()) {
    //         return response()->json([
    //             "errors" => $isValidate->errors()->all(),
    //             "success" => false
    //         ], 403);
    //     }
    //                 $houses= new Houses();
    //                 $from =(int) $request->from;
    //                 $to =(int) $request->to;

    //     for($i=$from;$i<$to;$i++){


    //     $status= $houses->insert(    [

    //             [
    //             "address"=>'House no '.$i,
    //             'sid'=>$request->sid,
    //             'created_at'=>date('Y-m-d H:i:s'),
    //             'updated_at'=> date('Y-m-d H:i:s')],

    //     ]);

    //         }


    //     return response()->json([
    //         "success" => true,
    //         "data" => $status,
    //     ]);
    // }




    public function addhouses(Request $request)
    {

     $isValidate = Validator::make($request->all(), [

            'sid'=>'required|exists:streets,id',
             'from'=>'required',
             'to'=>'required',
        ]);
        if ($isValidate->fails()) {
            return response()->json([
                "errors" => $isValidate->errors()->all(),
                "success" => false
            ], 403);
        }
                    $houses= new House();
                    $from =(int) $request->from;
                    $to =(int) $request->to;

        for($i=$from;$i<$to;$i++){


        $status= $houses->insert(    [

                [
                "address"=>'House no '.$i,
                'sid'=>$request->sid,
                'created_at'=>date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s')],

        ]);

            }


        return response()->json([
            "success" => true,
            "data" => $status,
        ]);
    }




public function houses($sid)
{
    $houses =  House::where('sid', $sid)->get();
    $noofhouse=  $houses->count($sid);


    return response()->json([
        "success" => true,
        "data" => $houses,
        "noofhouses"=>$noofhouse
    ]);

}
public function viewhousesforresidents($streetid)
    {
        $house = House::where('sid',$streetid)->get();
        return response()->json(["data" => $house]);
    }


}
