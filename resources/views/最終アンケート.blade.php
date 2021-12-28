@extends('layouts.baseBasic')

@section('content')
<h1>終了アンケート</h1>
<div style="text-align:center; border: 2px solid #000000;">
    レイアウト1
    <div>
        <img src="images/先行研究デザイン.png" width="270" height="286" class="imagery">
    </div>
</div>
<br>
<div style="text-align:center; border: 2px solid #000000;">
    レイアウト2
    <div>
        <img src="images/提案デザイン.png" width="270" height="286" class="imagery">
    </div>
</div>
<br>
<form action="/終了アンケート" method="POST">
    @csrf
    <p>どちらのレイアウトが良いレイアウトだと思ったか<span style="color: #F00;">【必須】<br>
        <div class="evalbox" id="makeImg">
            <div>
                1
                <input type="radio" name="selectedLayout" value=bad id=selectedBad required>
                <label for=selectedBad id="lavelSelectBad"></label>
            </div>
            <div>
                2
                <input type="radio" name="selectedLayout" value=basic id=selectedBasic required>
                <label for=selectedBasic id="lavelSelectedBasic"></label>

            </div>
        </div>
    </p><br>

    <p>
        理由</span><br>
        <textarea name="reason" rows="6" cols="60"></textarea><br>
    </p><br>


    <input type="hidden" name="token" value="{{ $token }}"/><br />
    <input type="hidden" name="layoutflag" value="end"/><br />
    </table>
    <button class="btn btn-success"> 送信 </button>
    </form>


@endsection
