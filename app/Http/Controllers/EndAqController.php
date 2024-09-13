<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\{
    Storage,
    DB,
};

use App\Services\endAqService;

class EndAqController extends Controller
{
    // アンケート結果の処理
    public function aqProcessing() {
        $token = $_POST['token'];
        $layoutflag = $_POST['layoutflag'];

        $selectLayout = $_POST['selectedLayout'];
        $reason = $_POST['reason'];
        $AqDataArray = array(
            "selectLayout" => $selectLayout,
            "reason" => $reason,

        );
        $path = "./MonitorAnser/enquete/" . $layoutflag . "/" . $token . ".json";
        $jsonData = json_encode($AqDataArray);
        //file_put_contents($path, $jsonData);
        Storage::put($path, $jsonData);

        return redirect()->action([EndAqController::class, 'aqProcessed'], ['token' => $token]);
    }

    // 処理後、実験終了画面を出す
    public function aqProcessed(Request $request) {
        $token =  $request['token'];

        DB::beginTransaction();
        try {
            endAqService::sendBeforeAq($token);
            endAqService::sendEndAq($token);
            endAqService::sendBasicLayoutAq($token);
            endAqService::sendBadLayoutAq($token);
            endAqService::sendAnswer('basic', $token);
            endAqService::sendAnswer('bad', $token);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }

        return view('実験終了',['token' => $token]);
    }
}
