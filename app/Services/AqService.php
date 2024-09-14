<?php
namespace App\Services;

use Illuminate\Support\Facades\Storage;

class AqService
{
    //32バイトのCSRFトークンを作成
    //＊ただの個人識別情報
    public static function getCsrfToken()
    {
        $TOKEN_LENGTH = 16; //16*2=32バイト
        $bytes = openssl_random_pseudo_bytes($TOKEN_LENGTH);
        return bin2hex($bytes);
    }

    /**
     * 問題の種類を選ぶ
     */
    public static function getQuestionPattern(){
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
        $testerNumArray = json_decode(Storage::get($path), true);
        $testerNumArray['testerNumber']++;
        Storage::put($path, json_encode($testerNumArray));
        return ($testerNumArray['testerNumber'] % 2) + 1; //奇数偶数でパターンを決定
    }
}
