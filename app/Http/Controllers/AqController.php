<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use DB;

class AqController extends Controller
{
    // Indexページの表示
    public function index()
    {
        //ユーザーエージェントを取得
        $ua = $_SERVER['HTTP_USER_AGENT'];
        //スマホと判定する文字リスト
        $ua_list = array('iPhone', 'iPad', 'iPod', 'Android');
        $isPhone = false;
        foreach ($ua_list as $ua_smt) {
            //ユーザーエージェントに文字リストの単語を含む場合はTRUE、それ以外はFALSE
            if (strpos($ua, $ua_smt) !== false) {
                $isPhone  = true;
            }
        }
        $viewName = '事前アンケート';
        if ($isPhone == true) {
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
    public function aqProcessing()
    {
        // 投稿内容の受け取って変数に入れる
        $token = $this->get_csrf_token();

        $ua = $_SERVER['HTTP_USER_AGENT'];
        //スマホと判定する文字リスト
        $ua_list = array('iPhone', 'iPad', 'iPod', 'Android');
        $isPhone = false;
        foreach ($ua_list as $ua_smt) {
            //ユーザーエージェントに文字リストの単語を含む場合はTRUE、それ以外はFALSE
            if (strpos($ua, $ua_smt) !== false) {
                $isPhone  = true;
            }
        }

        /*
        トークンとともに事前アンケートをjsonに登録
        */
        $studentNumber = $_POST['studentNumber'];
        $grade = $_POST['grade'];
        $ipass = $_POST['ipass'];
        $AqDataArray = array(
            "studentNumber" => $studentNumber,
            "grade" => (int)$grade,
            "ipass" => $ipass,
            "isPhone" => $isPhone,
        );
        $path = "./MonitorAnser/enquete/before/" . $token . ".json";
        $jsonData = json_encode($AqDataArray);
        //file_put_contents($path, $jsonData);
        Storage::put($path, $jsonData);

        $selectFunc = 'aqProcesed';
        //学籍番号がすでにアンケートに回答していないかを確認
        $isCorected = (DB::table('before_aq')->where('student_id', $studentNumber)->count() >=1) ;
        // 変数をビューに渡す
        return redirect()->action('AqController@aqProcesed', compact('token','isCorected'));
    }

    // 処理後、問題開始画面を出す
    public function aqProcesed(Request $request)
    {

        $path = "./layoutOrder.json"; //レイアウト比較の順番

        //なければ作成
        if (!Storage::exists($path)) {
            $testerNumArray = array(
                "firstLayout" => "bad",
            );
            $jsonData = json_encode($testerNumArray);
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
