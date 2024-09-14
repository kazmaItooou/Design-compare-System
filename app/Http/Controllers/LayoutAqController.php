<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LayoutAqController extends Controller
{
    // アンケート結果の処理
    public function aqProcessing(Request $request) {
        $token = $request->input('token');
        $layoutflag = $request->input('layoutflag');
        $qpat = $request->input('qpat');

        $strikingSymbol = $request->input('strikingSymbol');
        $usabilityNum = $request->input('usabilityNum');
        $positiveImpression = $request->input('positiveImpression') ?? '';
        $negativeImpression = $request->input('negativeImpression') ?? '';
        $otherImpression = $request->input('otherImpression') ?? '';
        $aqDataArray = [
            "strikingSymbol" => (int)$strikingSymbol,
            "usabilityNum" => (int)$usabilityNum,
            "positiveImpression" => $positiveImpression,
            "negativeImpression" => $negativeImpression,
            "otherImpression" => $otherImpression,
        ];
        $path = "./MonitorAnser/enquete/" . $layoutflag . "/" . $token . ".json";
        Storage::put($path, json_encode($aqDataArray));

        return redirect()->action([LayoutAqController::class, 'aqProcessed'], ['token' => $token,'layoutflag' => $layoutflag,'qpat' => $qpat]);
    }

    // 処理後、実験終了画面かbadlayout開始画面を出す
    public function aqProcessed(Request $request) {
        $token = $request['token'];
        $layoutflag = $request['layoutflag'];
        $qpat = $request['qpat'];
        //パターンを変更する
        if($qpat == 1){
            $qpat++;
        }else{
            $qpat--;
        }

        $isfirst = false;
        $viewName = "";
        if($layoutflag == config('constants.FIRST_LAYOUT')){
            if(config('constants.FIRST_LAYOUT') == "basic"){
                $viewName = "問題開始前画面bad";
            }else{
                $viewName = "問題開始前画面basic";
            }
        }else{
            $viewName = "最終アンケート";
        }
        return view($viewName, compact('token', 'qpat','isfirst'));
    }
}
