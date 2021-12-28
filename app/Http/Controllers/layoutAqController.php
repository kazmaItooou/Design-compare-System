<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use AqController;
class layoutAqController extends Controller
{
    // アンケート結果の処理
    public function aqProcessing() {
        $token = $_POST['token'];
        $layoutflag = $_POST['layoutflag'];
        $qpat = $_POST['qpat'];
        $layoutflag = $_POST['layoutflag'];

        $strikingSymbol = $_POST['strikingSymbol'];
        $usabilityNum = $_POST['usabilityNum'];
        $positiveImpression = $_POST['positiveImpression'];
        $negativeImpression = $_POST['negativeImpression'];
        $otherImpression = $_POST['otherImpression'];
        $AqDataArray = array(
            "strikingSymbol" => (int)$strikingSymbol,
            "usabilityNum" => (int)$usabilityNum,
            "positiveImpression" => $positiveImpression,
            "negativeImpression" => $negativeImpression,
            "otherImpression" => $otherImpression,
        );
        $path = "./MonitorAnser/enquete/" . $layoutflag . "/" . $token . ".json";
        $jsonData = json_encode($AqDataArray);
        //file_put_contents($path, $jsonData);
        Storage::put($path, $jsonData);

        return redirect()->action('layoutAqController@aqProcessed', ['token' => $token,'layoutflag' => $layoutflag,'qpat' => $qpat]);
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

        $path = "./layoutOrder.json"; //レイアウト比較の順番
        //レイアウト比較の順番の読み込み
        $file = Storage::get($path);
        $firstLayoutArray = json_decode($file, true);
        $firstLayout = $firstLayoutArray['firstLayout'];
        $isfirst = false;
        $viewName = "";
        if($layoutflag == $firstLayout){

            if($firstLayout == "basic"){
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
