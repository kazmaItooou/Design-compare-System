<?php
namespace App\Services;

use App\Models\{
    BeforeAq,
    EndAq,
    BadLayoutAq,
    BasicLayoutAq,
    TestResult,
};
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class endAqService
{
    public static function sendBeforeAq($token){
        $path = config('constants.ENQUETE_PATH') . '/before/' . $token . '.json';//問題jsonのpath
        $ansArray = json_decode(Storage::get($path), true);
        BeforeAq::create([
            'student_id' => $ansArray['studentNumber'],
            'token' => $token,
            'experimet_datetime' => Carbon::now(),
            'e-mail' => '',
            'grade' => (int)$ansArray['grade'],
            'exam_state' => $ansArray['ipass'],
            'is_phone' => (bool)$ansArray['isPhone'],
        ]);
    }

    public static function sendEndAq($token){
        $path = config('constants.ENQUETE_PATH') . '/end/' . $token . '.json';//問題jsonのpath
        $ansArray = json_decode(Storage::get($path), true);
        EndAq::create([
            'token' => $token,
            'selected_layout' => $ansArray['selectLayout'],
            'reason' => $ansArray['reason'],
        ]);
    }

    public static function sendBadLayoutAq($token){
        $path = config('constants.ENQUETE_PATH') . '/bad/' . $token . '.json';//問題jsonのpath
        $ansArray = json_decode(Storage::get($path), true);
        BadLayoutAq::create([
            'token' => $token,
            'striking_symbol' => $ansArray['strikingSymbol'],
            'usability_num' => (int)$ansArray['usabilityNum'],
            'positive_impression' => $ansArray['positiveImpression'],
            'negative_impression' => $ansArray['negativeImpression'],
            'other_impression' => $ansArray['otherImpression'],
        ]);
    }

    public static function sendBasicLayoutAq($token){
        $path = config('constants.ENQUETE_PATH') . '/basic/' . $token . '.json';//問題jsonのpath
        $ansArray = json_decode(Storage::get($path), true);
        BasicLayoutAq::create([
            'token' => $token,
            'striking_symbol' => $ansArray['strikingSymbol'],
            'usability_num' => (int)$ansArray['usabilityNum'],
            'positive_impression' => $ansArray['positiveImpression'],
            'negative_impression' => $ansArray['negativeImpression'],
            'other_impression' => $ansArray['otherImpression'],
        ]);
    }

    //回答結果をDBに送信
    public static function sendAnswer($layoutflag, $token){
        $dir = 'Anser' . $layoutflag . 'Layout';//レイアウトでディレクトリを変える
        $path = './MonitorAnser/' . $dir . '/' . $token . '.json';//問題jsonのpath
        $ansArray = json_decode(Storage::get($path), true);

        $testResults = [];
        foreach($ansArray as &$ans){
            $testResults[] = [
                'token' => $token,
                'first_layout' => config('constants.FIRST_LAYOUT'),
                'layout' => $layoutflag,
                'qpat' => (int)$ans['qpattern'],
                'qnum' => (int)$ans['qnumber'],
                'iscorrect' => (boolean)$ans['iscorrect'],
                'time_required' => (double)$ans['timeRequired'],
            ];
        }
        TestResult::insert($testResults);
    }
}
