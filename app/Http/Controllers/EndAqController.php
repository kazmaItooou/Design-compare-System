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
    public function aqProcessing(Request $request) {
        $token = $request->input('token');
        $layoutflag = $request->input('layoutflag');
        $selectLayout = $request->input('selectedLayout');
        $reason = $request->input('reason') ?? '';
        $AqDataArray = [
            "selectLayout" => $selectLayout,
            "reason" => $reason,
        ];

        $path = "./MonitorAnser/enquete/" . $layoutflag . "/" . $token . ".json";
        Storage::put($path, json_encode($AqDataArray));

        return redirect()->action([EndAqController::class, 'aqProcessed'], ['token' => $token]);
    }

    // 処理後、実験終了画面を出す
    public function aqProcessed(Request $request) {
        $token = $request['token'];
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
