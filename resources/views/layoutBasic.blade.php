@extends('layouts.baseBasic')

@section('content')
親和図法を説明したものはどれか。
<form method="post" action="example.cgi">

    <p>デフォルト<br>
    <input type="radio" name="q1" value="はい">
    事態の進展とともに様々な事象が想定される問題について，対応策を検討し望ましい結果に至るプロセスを定める方法である。
    <br>
    <input type="radio" name="q1" value="いいえ">
    収集した情報を相互の関連によってグループ化し，解決すべき問題点を明確にする方法である。
    <br>
    <input type="radio" name="q1" value="いいえ">
    複雑な要因の絡み合う事象について，その事象間の因果関係を明らかにする方法である。
    <br>
    <input type="radio" name="q1" value="いいえ">
    目的・目標を達成するための手段・方策を順次展開し，最適な手段・方策を追求していく方法である。
    <br>
    </p>

    <div id="contents-nextQ">
        <p><input type="submit" value="次の問題" class="nextquestion btn--orange btn--shadow"></p>
    </div>


</form>

@endsection


//実験終了
Route::post('/実験終了', 'ExperimentEndController@aqProcessing');
Route::get('/実験終了', 'ExperimentEndController@aqProcessed');

