<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LayoutViewController extends Controller


{
    // Indexページの表示
    public function bad(){
        $token = "dummy";
        $choise = "dummy";
        $correctAns = "";
        $Qnum = "1";
        $qpat = "1";
        $qAmount = "1";
        $layoutflag = "bad";
        $startTime = "dummy";
        $isSetflag = true;
        $choises = array();//選択肢
        $path = "./questions/pat" . $qpat . "_q" . $Qnum . ".json";//問題jsonのpath
        $json = file_get_contents($path);
        $json = mb_convert_encoding($json, 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');
        $arr = json_decode($json,true);

        $question = $arr['question']['ask'];
        foreach($arr['question']['choises'] as &$value){
            array_push($choises, $value);
        }
        $correctAns = $arr['question']['ans'];

        return view("テスト",compact('token','Qnum','qpat','layoutflag','question','choises','correctAns','startTime','isSetflag','qAmount'));
    }

    public function basic(){
        $token = "dummy";
        $choise = "dummy";
        $correctAns = "";
        $Qnum = "1";
        $qpat = "1";
        $qAmount = "1";
        $layoutflag = "basic";
        $startTime = "dummy";
        $isSetflag = true;
        $choises = array();//選択肢
        $path = "./questions/pat" . $qpat . "_q" . $Qnum . ".json";//問題jsonのpath
        $json = file_get_contents($path);
        $json = mb_convert_encoding($json, 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');
        $arr = json_decode($json,true);

        $question = $arr['question']['ask'];
        foreach($arr['question']['choises'] as &$value){
            array_push($choises, $value);
        }
        $correctAns = $arr['question']['ans'];

        return view("テスト",compact('token','Qnum','qpat','layoutflag','question','choises','correctAns','startTime','isSetflag','qAmount'));
    }



    public function basicReform1(){
        $token = "dummy";
        $choise = "dummy";
        $correctAns = "";
        $Qnum = "1";
        $qpat = "1";
        $qAmount = "1";
        $layoutflag = "basicReform1";
        $startTime = "dummy";
        $isSetflag = true;
        $choises = array();//選択肢
        $path = "./questions/pat" . $qpat . "_q" . $Qnum . ".json";//問題jsonのpath
        $json = file_get_contents($path);
        $json = mb_convert_encoding($json, 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');
        $arr = json_decode($json,true);

        $question = $arr['question']['ask'];
        foreach($arr['question']['choises'] as &$value){
            array_push($choises, $value);
        }
        $correctAns = $arr['question']['ans'];

        return view("テスト",compact('token','Qnum','qpat','layoutflag','question','choises','correctAns','startTime','isSetflag','qAmount'));
    }
}
