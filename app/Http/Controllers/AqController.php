<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use DB;
use App\Models\BeforeAq;

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
        $token = $this->get_csrf_token();

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

        $path = "./layoutOrder.json"; //レイアウト比較の順番

        //なければ作成
        if (!Storage::exists($path)) {
            $jsonData = json_encode([
                "firstLayout" => "bad",
            ]);
            Storage::put($path, $jsonData);
        }

        // //レイアウト比較の順番の読み込み
        // $file = Storage::get($path);
        // $firstLayoutArray = json_decode($file, true);
        // $firstLayout = $firstLayoutArray['firstLayout'];

        $token = $request['token'];
        $isCorected = $request['isCorected'];
        $qpat = $this->getPattern(); //問題の種類を選ぶフラグ
        $layoutPat = $this->getFirstLayout();
        $isfirst = true;
        if($isCorected){
            $viewName = 'studentNumError';
        }else{
            $viewName = '問題開始前画面'. $layoutPat;
        }
        return view($viewName, compact('token', 'qpat','isfirst'));
    }

    //32バイトのCSRFトークンを作成
    function get_csrf_token()
    {
        $TOKEN_LENGTH = 16; //16*2=32バイト
        $bytes = openssl_random_pseudo_bytes($TOKEN_LENGTH);
        return bin2hex($bytes);
    }

    //問題パターンを決める
    function getPattern()
    {
        //rand(1, 2);

        $path = "./testerNumber.json"; //被験者数ファイル

        //被験者ファイルなければ作成
        if (!Storage::exists($path)) {
            $testerNumArray = array(
                "testerNumber" => 0,
            );
            $jsonData = json_encode($testerNumArray);

            Storage::put($path, $jsonData);
        }
        //被験者数の読み込み
        $file = Storage::get($path);
        $testerNumArray = json_decode($file, true);
        $testerNumArray['testerNumber']++;
        $testerNumber = $testerNumArray['testerNumber'];
        $jsonData = json_encode($testerNumArray);
        Storage::put($path, $jsonData);
        return ($testerNumber % 2) + 1; //奇数偶数でパターンを決定
    }

    public static function getFirstLayout(){
        $path = "./layoutOrder.json"; //レイアウト比較の順番
        //レイアウト比較の順番の読み込み
        $file = Storage::get($path);
        $firstLayoutArray = json_decode($file, true);
        $firstLayout = $firstLayoutArray['firstLayout'];
        return $firstLayout;
    }
}
