<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class QuestionController extends Controller
{
    // Indexページの表示
    public function index(Request $request) {
        $token = $request['token'];
        //レイアウトのflag (bad , basic)
        $layoutflag = $request['layoutflag'];
        $Qnum = $request['Qnum'];
        $qpat = $request['qpat'];
        $isSetflag = $request['isSetflag'];
        $choise = 0;
        $qAmount = $request['qAmount'];

        //開始時間をミリ秒単位で計測
        $startTime = microtime(true);

        //Qnumが1回目のときにパターンの問題数をファイル数から算出
        if($qAmount == Null){
            $qmax = 1;
            $path = "./questions/pat" . $qpat . "_q" . 1 . ".json";//問題jsonのpath
            while(file_exists($path)){
                $qmax++;
                $path = "./questions/pat" . $qpat . "_q" . $qmax . ".json";//問題jsonのpath
            }
            $qmax--;
            $qAmount = $qmax;
        }

        /*
        問題をjsonから取りだす
        */
        //$path = "./questions/" . $layoutflag . "_q" . $Qnum . ".json";//問題jsonのpath
        $path = "./questions/pat" . $qpat . "_q" . $Qnum . ".json";//問題jsonのpath
        //変数初期化
        $question = "";//問
        $choises = array();//選択肢
        $correctAns = 0;//正答
        $viewName= "";//表示するview

        /*
        レイアウトに沿った問題をjsonから読み込む
        */

        //問題ファイルがないとき（問題が終了したとき）はviewを変更
        if(!file_exists($path)){
            $viewName = "テスト" . $layoutflag . "アンケート";
        }else{
            $viewName= "テスト";
            $json = file_get_contents($path);
            $json = mb_convert_encoding($json, 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');
            $arr = json_decode($json,true);

            $question = $arr['question']['ask'];
            foreach($arr['question']['choises'] as &$value){
                array_push($choises, $value);
            }
            $correctAns = $arr['question']['ans'];
        }

        //アンケートに回答していないtokenの場合エラーを出す
        $monitorPath = "./MonitorAnser/enquete/before/" . $token . ".json";
        if (!Storage::exists($monitorPath)) {
            $viewName = "TokenError";
        }
        return view($viewName,
        compact('token','Qnum','qpat','layoutflag','question','choises','correctAns','startTime','isSetflag','qAmount'));
    }

    //post内容を回答処理
    public function AnsProsessing() {
        //POSTされたデータを変数に格納
        $token = $_POST['token'];
        $choise = $_POST['choise'];
        $correctAns = $_POST['correctAns'];
        $Qnum = $_POST['Qnum'];
        $qpat = $_POST['qpat'];
        $layoutflag = $_POST['layoutflag'];
        $startTime = $_POST['startTime'];

        //問題回答にかかった時間を計算
        $endTime = microtime(true);
        $timeRequired = (float)$endTime - (float)$startTime;

        $isCorrect = ($correctAns == $choise);
        //データをtokenごとにjsonに保存する
        $dir = "Anser".$layoutflag."Layout";//レイアウトでディレクトリを変える
        $path = "./MonitorAnser/" . $dir . "/" . $token . ".json";//問題jsonのpath

        $monitordata = array(
            "qpattern" => (int)$qpat,
            "qnumber" => (int)$Qnum,
            "iscorrect" => $isCorrect,
            "timeRequired" => $timeRequired
        );
        //ファイルがないときは作成
        if(!Storage::exists($path)){
            $jsonData = json_encode(array());
            Storage::put($path, $jsonData);
        }
        //token.jsonを読み込む
        $file = Storage::get($path);
        $ansArray = json_decode($file, true);

        //問題がすでに回答済みかをチェック
        $isSetflag = false;
        foreach($ansArray as &$ans){
            if($ans['qnumber'] == $Qnum){
                $isSetflag = true;
                break;
            }
        }

        //問題が回答されていなければ書き込みを行う
        if(!$isSetflag){
            array_Push($ansArray, $monitordata);
            $jsonData = json_encode($ansArray);
            Storage::put($path, $jsonData);
        }
        $Qnum++;
        return redirect()->action('QuestionController@index',
        compact('token','Qnum','qpat','layoutflag','isSetflag'));
    }
}
