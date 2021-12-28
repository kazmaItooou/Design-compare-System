@extends('layouts.baseBasic')

@section('content')
<h1>問題開始前注意事項</h1>
@if($isfirst)
これから、レイアウト検証のための<b>実験1</b>を行います。
@else
<span style="color: #F00;">まだ実験は終了していません！</span><br>
　これから、レイアウト検証のための<b>実験2</b>を行います。
先程のテストは<b>実験1</b>です。これはその続きです。
@endif
@php
    //問題数計算qAmount
    $qmax = 1;
    $path = "./questions/pat" . $qpat . "_q" . 1 . ".json";//問題jsonのpath
    while(file_exists($path)){
        $qmax++;
        $path = "./questions/pat" . $qpat . "_q" . $qmax . ".json";//問題jsonのpath
    }
    $qmax--;
    $qAmount = $qmax;
@endphp
<h2>テスト問題の内容</h1>
　情報処理技術者試験（基本情報技術者試験の午前問題、ITパスポート試験）の内容のテクノロジ系から、情報工学科所属の学生であれば回答が容易と推測されるものを中心に抜粋してきた問題です。<br>
<h2>注意事項</h1>
<ul>
    <li>問題数は{{ $qAmount }}問</li>
    <li>回答を行うために問題内容をインターネット、書籍などで調べることは禁止である。（正確な実験結果を出すことが出来なくなってしまう恐れがあるため）</li>
    <li>計算問題が1問あるためメモ用紙を用意することが望ましい。</li>
    <li>本来の試験では使用できませんが、電卓の使用は可です。</li>
    <li>問題はすべてラジオボタンであり必須選択である。</li>
    <li>回答時間目安は2～5分あれば終わらすことができると考えている。</li>
    <li>問題の回答は実験を最後まで進めなければサーバへ送信されません！ご注意ください！</li>
</ul>
<form action="/テスト" method="get">
    <input type="hidden" name="token" value="{{$token}}"/>
    <input type="hidden" name="Qnum" value="1"/>
    <input type="hidden" name="layoutflag" value="basic"/>
    <input type="hidden" name="qpat" value="{{$qpat}}"/>
    <input type="submit" value="問題を開始する" />
</form>
@endsection
