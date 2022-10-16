<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Notice;
use Carbon\Carbon;
class NoticeBoardController extends Controller
{
    public function addnoticeboarddetail(Request $request)
    {
        $isValidate = Validator::make($request->all(), [
            'noticetitle' => 'required|string',
            'noticedetail' => 'required|string',
            'startdate' => 'required|date',
            'enddate' => 'required|date',
            'starttime' => 'required|after:' . Carbon::now()->format('H:i:s'),
            'endtime' => 'required|after:start_time',
            'status' => 'required',
            'subadminid' => 'required|exists:users,id',
        ]);
        if ($isValidate->fails()) {
            return response()->json([
                "errors" => $isValidate->errors()->all(),
                "success" => false
            ], 403);
        }
        $notice = new Notice();
        $notice->noticetitle = $request->noticetitle;
        $notice->noticedetail = $request->noticedetail;
        $notice->startdate =  Carbon::parse($request->startdate);
        $notice->enddate =  Carbon::parse($request->enddate);
        $notice->starttime = $request->starttime;
        $notice->endtime = $request->endtime;
        $notice->status = $request->status;
        $notice->subadminid = $request->subadminid;
        $notice->save();
        $tk = 'ct99wz8wTeemXnjYoM0KCe:APA91bEj3t_hU0LKRPCS6lVsvMHJDj_Yg4ES_OneTJBJSgxNi10Wlxpff5ZSX9eVYgZzAyoYP6k6EkGJNI0t2LHJyf39eCGkFAhMiHhU3gSGsAPc75Yz7cpjZ6MnY_KT_V7a_DhlOmdb';
        $tk1 = 'd_JmZJF6Qfqd4g9RdxUEqB:APA91bE3FO0n7xWo9E1S4cEH1jgq63aSPZdxSVd6EDruH96WdMR_lvfsRGmB8tja1KRloDyLiZMujlbtzxsuxsTFjrCu-6IUyf8hF7puN0pATH4mX7eVmGeUHJ54oKNg_CrN3N9n5g-w';
        $tk2='cSxb9-tvSMil-hn_mQXVhJ:APA91bF7Qm38y5CNqRZLRx6pSAJPkagCgZCDwgGu7O7D2BIPnjFm0iO6gdp2e0Wms-GnvaELtwnz0G5G_A-BnsVWzTb5LwLpXfx4-2wZ_Q1QXxmUfms4y_Z3Qhf8fIHCq8QO4lykqbVB';
        $serverkey = 'AAAAcuxXPmA:APA91bEz-6ptcGS8KzmgmSLjb-6K_bva-so3i6Eyji_ihfncqXttVXjdBQoU6V8sKilzLb9MvSHFId-KK7idDwbGo8aXHpa_zjGpZuDpM67ICKM7QMCGUO_JFULTuZ_ApIOxdF3TXeDR';
        $url = 'https://fcm.googleapis.com/fcm/send';
        $mydata = [
            'registration_ids' => [$tk, $tk1,$tk2],
            "data" => $notice,
            "notification" => [
                'title' => $notice->noticetitle, 'body' => $notice->noticedetail,
                'description' => "jani"
            ]
        ];
        $finaldata = json_encode($mydata);
        $headers = array(
            'Authorization: key=' . $serverkey,
            'Content-Type: application/json'
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $finaldata);
        $result = curl_exec($ch);
        // var_dump($result);
        curl_close($ch);
        return response()->json([
            'message' => 'success',
            'data' => $notice
        ], 200);
    }
    public function viewallnotices($subadminid)
    {
        $notice = Notice::where('subadminid', $subadminid)->get();
        return response()->json(["data" => $notice]);
    }
    public function deletenotice($id)
    {
        $notice =   Notice::find($id);
        if ($notice != null) {
            $notice = Notice::where('id', $id)->delete();
            return response()->json([
                'data' => true,
                "data" => $notice, "message" => "delete Notice successfully"
            ], 200);
        } else {
            return response()->json([
                "data" => false,
                "message" => "Notice Not deleted"
            ]);
        }
    }
    public  function updatenotice(Request $request)
    {
        $isValidate = Validator::make($request->all(), [
            'noticetitle' => 'required|string',
            'noticedetail' => 'required|string',
            'startdate' => 'required|date',
            'enddate' => 'required|date',
            'starttime' => 'required|after:' . Carbon::now()->format('H:i:s'),
            'endtime' => 'required',
            'status' => 'required',
            'id' => 'required|exists:notices,id',
        ]);
        if ($isValidate->fails()) {
            return response()->json([
                "errors" => $isValidate->errors()->all(),
                "success" => false
            ], 403);
        }
        $notice = Notice::find($request->id);
        $notice->noticetitle = $request->noticetitle;
        $notice->noticedetail = $request->noticedetail;
        $notice->startdate =  Carbon::parse($request->startdate)->format('y-m-d');
        $notice->enddate =  Carbon::parse($request->enddate)->format('y-m-d');
        $notice->starttime = $request->starttime;
        $notice->endtime = $request->endtime;
        $notice->status = $request->status;
        $notice->save();
        return response()->json([
            "success" => true,
            "data" => $notice,
            "message" => "notice update successfully"
        ]);
    }
}
