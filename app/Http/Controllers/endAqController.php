<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use DB;

class endAqController extends Controller
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

        return redirect()->action('endAqController@aqProcessed',['token' => $token]);
    }

    // 処理後、実験終了画面を出す
    public function aqProcessed(Request $request) {
        $token =  $request['token'];
        //TODO
        //収集データをDBに送信
        //事前アンケート

        //事前アンケートをDBに送信
        $this->sendBeforeAq($token);
        $this->sendEndAq($token);
        //レイアウトアンケートをDBに送信
        //途中アンケート
        $this->sendBasicLayoutAq($token);
        $this->sendBadLayoutAq($token);

        //回答結果をDBに送信
        $this->sendAnswer('basic', $token);
        $this->sendAnswer('bad', $token);

        return view('実験終了',['token' => $token]);
    }

    public function sendBeforeAq($token){
        $path = "./MonitorAnser/enquete/before/" . $token . ".json";//問題jsonのpath
        $file = Storage::get($path);
        $ansArray = json_decode($file, true);

        $studentNumber = $ansArray['studentNumber'];
        $grade = (int)$ansArray['grade'];
        $ipass = $ansArray['ipass'];
        $isPhone = (bool)$ansArray['isPhone'];
        DB::insert('insert into before_aq
        values (?, ?,CURRENT_TIMESTAMP, ?, ?, ?, ?)', [$studentNumber, $token,"", $grade, $ipass, $isPhone]);
    }

    public function sendEndAq($token){
        $path = "./MonitorAnser/enquete/end/" . $token . ".json";//問題jsonのpath
        $file = Storage::get($path);
        $ansArray = json_decode($file, true);

        $selectLayout = $ansArray['selectLayout'];
        $reason = $ansArray['reason'];
        DB::insert('insert into end_aq
        values (?, ?, ?)', [ $token, $selectLayout, $reason]);
    }

    public function sendBadLayoutAq($token){
        $path = "./MonitorAnser/enquete/bad/" . $token . ".json";//問題jsonのpath
        $file = Storage::get($path);
        $ansArray = json_decode($file, true);

        $strikingSymbol = $ansArray['strikingSymbol'];
        $usabilityNum = (int)$ansArray['usabilityNum'];
        $positiveImpression = $ansArray['positiveImpression'];
        $negativeImpression = $ansArray['negativeImpression'];
        $otherImpression = $ansArray['otherImpression'];
        DB::insert('insert into bad_layout_aq
        values (?, ?, ?,?, ?, ?)', [ $token, $strikingSymbol, $usabilityNum, $positiveImpression, $negativeImpression, $otherImpression]);
    }

    public function sendBasicLayoutAq($token){
        $path = "./MonitorAnser/enquete/basic/" . $token . ".json";//問題jsonのpath
        $file = Storage::get($path);
        $ansArray = json_decode($file, true);

        $strikingSymbol = $ansArray['strikingSymbol'];
        $usabilityNum = (int)$ansArray['usabilityNum'];
        $positiveImpression = $ansArray['positiveImpression'];
        $negativeImpression = $ansArray['negativeImpression'];
        $otherImpression = $ansArray['otherImpression'];
        DB::insert('insert into basic_layout_aq
        values (?, ?, ?,?, ?, ?)', [ $token, $strikingSymbol, $usabilityNum, $positiveImpression, $negativeImpression, $otherImpression]);
    }

    //回答結果をDBに送信
    public function sendAnswer($layoutflag, $token){
        $dir = "Anser".$layoutflag."Layout";//レイアウトでディレクトリを変える
        $path = "./MonitorAnser/" . $dir . "/" . $token . ".json";//問題jsonのpath
        $file = Storage::get($path);
        $ansArray = json_decode($file, true);

        $path = "./layoutOrder.json"; //レイアウト比較の順番
        //レイアウト比較の順番の読み込み
        $file = Storage::get($path);
        $firstLayoutArray = json_decode($file, true);
        $firstLayout = $firstLayoutArray['firstLayout'];

        foreach($ansArray as &$ans){
            $qpat = (int)$ans['qpattern'];
            $qnum = (int)$ans['qnumber'];
            $iscorrect = (boolean)$ans['iscorrect'];
            $timeRequired = (double)$ans['timeRequired'];
            DB::insert('insert into test_result
            values (?, ? ,? , ?, ?, ?, ?)', [$token, $firstLayout,$layoutflag,$qpat, $qnum, $iscorrect, $timeRequired]);
        }
    }
}
