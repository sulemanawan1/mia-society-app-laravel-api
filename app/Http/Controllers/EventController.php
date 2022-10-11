<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Event;
use App\Models\Eventimage;
use App\Models\User;
use App\Notifications\EventNotifications;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
class EventController extends Controller
{

    public function addevent(Request $request)
    {

        $isValidate = Validator::make($request->all(), [

            'userid' => 'required|exists:users,id',
            'roleid' => 'required',
            'rolename' => 'required',
            'title' => 'required',
            'description' => 'required',
            'startdate' => 'required|date',
            'enddate' => 'required|date',
            'active'=> 'required'



        ]);


        if ($isValidate->fails()) {
            return response()->json([
                "errors" => $isValidate->errors()->all(),
                "success" => false

            ], 403);
        }

        $event = new Event();
        $event->userid=$request->userid;
        $event->roleid=$request->roleid;
        $event->rolename=$request->rolename;
        $event->title=$request->title;
        $event->description=$request->description;
        $event->startdate=  Carbon::parse($request->startdate)->format('Y-m-d');
        $event->enddate= Carbon::parse($request->enddate)->format('Y-m-d');
        $event->active=$request->active;
        $event->save();

        if(auth()->user()){

            $users = User::find(auth()->user()->id);
          

            $users->notify(new  EventNotifications($event));
        }





        return response()->json(["data" => $event]);




    }


    public function addeventimages(Request $request)
    {

        if(!$request->hasFile('fileName')) {
            return response()->json(['upload_file_not_found'], 400);
        }

        $allowedfileExtension=['pdf','jpg','png'];
        $files = $request->file('fileName');
        $errors = [];
dd($request->all());
        foreach ($files as $file) {

            $extension = $file->getClientOriginalExtension();

            $check = in_array($extension,$allowedfileExtension);

            if($check) {
                foreach($request->fileName as $mediaFiles) {

                    $path = $mediaFiles->store('public/images');
                    $name = $mediaFiles->getClientOriginalName();

                    //store image file into directory and db
                    $save = new Event();
                    $save->eventid = $request->eventid;
                    $save->image = $path;
                    $save->save();
                }
            } else {
                return response()->json(['invalid_file_format'], 422);
            }

            return response()->json(['file_uploaded'], 200);

        }
    }

    //     $isValidate = Validator::make(
    //         $request->all(), [

    //         'eventid' => 'required|exists:events,id',
    //         'image' => 'required',

    //     ]);


    //     if ($isValidate->fails()) {
    //         return response()->json([
    //             "errors" => $isValidate->errors()->all(),
    //             "success" => false

    //         ], 403);
    //     }



    //     $event = new Event();

    //     if($request->files->has('image'))
    //     {
    //         $images = $request->files->get('image');

    //         dd($images);

    //        foreach( $images as $image)
    //        {

    //         // print($images);

    //         $image = $request->files->get('image');
    //         $filename = time() . "." . $image->extension();
    //         $image->move(public_path('/storage/'), $filename);

    //            $event->eventid=$request->eventid;
    //            $event->image=$filename;
    //            $event->save();


    //        }
    //        return response()->json(["data" => $event]);

    //     }















    //     }




    // public function events($userid)

    // {

    //     // dd($userid);

    //     $event = Event::where('userid', $userid)->get();


    //     return response()->json(["data" => $event]);
    // }



    // public function deleteevent($id)

    // {


    //     // dd($userid);

    //     $event = Event::where('id', $id)->delete();

    //     if($event==1)
    //     {        return response()->json([
    //         "success"=>true,
    //       "message"=>"event deleted successfully"]);}

    //     return response()->json([
    //         "success"=>false,
    //         "message"=>"failed to delete event"],403);








    public  function updateevent (Request $request)


    {

        $isValidate = Validator::make($request->all(), [

            'title' => 'required',
            'description' => 'required',
            'startdate' => 'required|date',
            'enddate' => 'required|date',
            'active'=> 'required',
            'id'=> 'required|exists:events,id',


        ]);


        if ($isValidate->fails()) {
            return response()->json([
                "errors" => $isValidate->errors()->all(),
                "success" => false

            ], 403);
        }


        $event = Event::find($request->id);

        $event->title=$request->title;
        $event->description=$request->description;
        $event->startdate=  Carbon::parse($request->startdate)->format('Y-m-d');
        $event->enddate= Carbon::parse($request->enddate)->format('Y-m-d');
        $event->active=$request->active;
        $event->update();



        return response()->json([
            "success"=>true,
            "data" => $event,
        "message"=> "event details update successfully"
    ]);



    }




    // Activity::orderBy('created_at','desc')->get();
}
