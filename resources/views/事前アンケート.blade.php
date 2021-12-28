@extends('layouts.baseDefault')

@section('content')
<!-- ここから本文記入 -->
<h1>挨拶</h1>
今回の実験にご協力いただきありがとうございます。<br>
我が鈴木研究室は、システムや授業のアンケートを行い、その結果を分析することを主な研究内容として取り組んでいます。
本実験でも同様にそのような研究を行います。<br><br>
<h1>全体注意事項</h1>
URL改変＆ソース改変などをすると意図しない動作を起こす可能性があるためご遠慮ください。<br>
また、上記の行動をしなかったのも関わらずご動作が見られた場合は早急にご報告ください。<br><br>
<h1>実験中の注意事項</h1>
以下の表示が出るまでは実験が継続します。<br>
<span style="color: #F00;">タブを閉じる指示があるまでは、途中でブラウザを閉じないでください。</span><br>
<div>
    <img src="images/実験終了.png" width="468" height="142" class="imagery">
</div>

<h1>実験内容</h1>
システムに従って2種類のレイアウトで問題を回答してもらい、アンケートを行います。
問題数は実験1、実験2合わせて22問(各11問)です。<br>
10分あればすべての内容を終わらせることができると思います。<br>
必須項目には「<span style="color: #F00;">【必須】</span>」の表示があるので、
回答必須項目です。それ以外は任意回答項目です。ただし、一言や短い文で構いませんので回答は欲しいです。
<h1>実験開始</h1>
まずは以下の事前アンケートに答えてください。<br>
<!-- 直前投稿エリア -->
<!-- フォームエリア -->
<form action="/アンケート処理中" method="POST">
    @csrf
    <p>
        学籍番号<span style="color: #F00;">【必須】</span><br>
        <input name="studentNumber" placeholder="EP18009" required><br>
    </p>
<!--
    <p>
        メールアドレス（テスト回答結果詳細希望者のみ入力）<br>
        <input name="e-mail" placeholder="mail@example.com"><br>
    </p>
-->
    <p>
        学年<span style="color: #F00;">【必須】<br>
            <select name="grade" size="1" required>>
                <option value="">学年を選択</option>
                <option value="1">1年生</option>
                <option value="2">2年生</option>
                <option value="3">3年生</option>
                <option value="4">4年生</option>
                <option value="5">その他</option>
            </select>
    </p>

    <p>
        情報処理技術者試験<span style="color: #F00;">【必須】
            <select name="ipass" size="1" required>>
                <option value="">状況を選択</option>
                <option value="未取得">未取得、学習経験なし<br>（学習は主に講義のみなど）</option>
                <option value="学習経験あり">学習経験あり（情報処理技術者演習Aの履修済み、独学など）</option>
                <option value="取得済み">ITパスポート、基本情報技術者試験などを取得済み</option>
                <option value="その他">その他</option>
                <option value="答えたくない">答えたくない</option>
            </select>
    </p>
    <br>
    <button class="btn btn-success"> 次へ </button>
</form>
<!-- // 本文ココまで*-->

@endsection
