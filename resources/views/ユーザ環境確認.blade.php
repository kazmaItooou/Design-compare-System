@extends('layouts.baseDefault')

@section('content')
現在使用しているデバイスはスマートフォンです。
このシステムはスマートフォンでの回答は推奨されていません。
PCでの回答を前提にしています。<br>
それでも、回答をすすめる場合は「すすむ」ボタンから回答を開始してください。<br>

<input type="button" onclick="location.href='/事前アンケートスマホ' "value="すすむ">

@endsection
