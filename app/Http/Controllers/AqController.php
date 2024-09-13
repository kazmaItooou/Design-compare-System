<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\BeforeAq;
use App\Services\AqService;

class AqController extends Controller
{
    private const UA_LIST = ['iPhone', 'iPad', 'iPod', 'Android'];
    // Indexページの表示
    public function index(Request $request)
    {
        //ユーザーエージェントを取得
        $ua = $request->header('User-Agent');
        $isPhone = false;
        foreach (self::UA_LIST as $ua_smt) {
            if (strpos($ua, $ua_smt)) {
                $isPhone = true;
                break;
            }
        }
        $viewName = '事前アンケート';
        if ($isPhone) {
            $viewName = 'ユーザ環境確認';
        }
        return view($viewName);
    }

    public function userAgentPhone()
    {
        return view('事前アンケート');
    }
    // 投稿された内容を表示するページ

    // アンケート結果の処理
    public function aqProcessing(Request $request)
    {
        // 投稿内容の受け取って変数に入れる
        $token = AqService::getCsrfToken();

        $ua = $request->header('User-Agent');
        $isPhone = false;
        foreach (self::UA_LIST as $ua_smt) {
            if (strpos($ua, $ua_smt)) {
                $isPhone  = true;
                break;
            }
        }
        /*
        トークンとともに事前アンケートをjsonに登録
        */
        $studentNumber = $request->input('studentNumber');
        $grade = $request->input('grade');
        $ipass = $request->input('ipass');
        $AqDataArray = [
            "studentNumber" => $studentNumber,
            "grade" => (int)$grade,
            "ipass" => $ipass,
            "isPhone" => $isPhone,
        ];
        $path = "./MonitorAnser/enquete/before/" . $token . ".json";
        Storage::put($path, json_encode($AqDataArray));
        //学籍番号がすでにアンケートに回答していないかを確認
        $isCorected = (BeforeAq::where('student_id', $studentNumber)->count() >= 1) ;
        return redirect()->action([AqController::class,'aqProcesed'], compact('token','isCorected'));
    }

    // 処理後、問題開始画面を出す
    public function aqProcesed(Request $request)
    {
        $token = $request['token'];
        $isCorected = $request['isCorected'];
        $qpat = AqService::getQuestionPattern();
        $isfirst = true;
        if($isCorected){
            $viewName = 'studentNumError';
        }else{
            $viewName = '問題開始前画面'. config('constants.FIRST_LAYOUT');
        }
        return view($viewName, compact('token', 'qpat','isfirst'));
    }
}
