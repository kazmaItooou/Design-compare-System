@extends('layouts.baseDefault')

@section('content')
<h1>アンケート</h1>
今回答した以下のレイアウトのアンケートを答えてください。
<div style="text-align:center; border: 2px solid #000000;">
    <img src="images/先行研究デザイン.png" width="540" height="572" class="imagery">
</div>
<br>
<h1>アンケート内容</h1>
<form action="/テストアンケート" method="POST">
    @csrf
    以下は回答必須項目です。
    <div>
        最も目を引く要素<span style="color: #F00;">【必須】</span><br>
        <div style="display:table; width:100%;">
            <div style="display:table-cell;width:30px;">
                <input type="radio" name="strikingSymbol" value=1 id=ssValue1 required>
            </div>
            <div>
                <label for=ssValue1 id="sslavel1">消去法説明<br>
                    <img src="images/先行研究デザイン_消去法説明.png" width="350" height=auto class="imagery">
                </label>
            </div>
        </div><br>

        <div style="display:table; width:100%;">
            <div style="display:table-cell;width:30px;">
                <input type="radio" name="strikingSymbol" value=2 id=ssValue2 required>
            </div>
            <div>
                <label for=ssValue2 id="sslavel2">問題<br>
                    <img src="images/先行研究デザイン_問題.png" width="350" height=auto class="imagery">
                </label>
            </div>
        </div><br>

        <div style="display:table; width:100%;">
            <div style="display:table-cell;width:30px;">
                <input type="radio" name="strikingSymbol" value=3 id=ssValue3 required>
            </div>
            <div>
                <label for=ssValue3 id="sslavel3">次の問題ボタン<br>
                    <img src="images/先行研究デザイン_次の問題.png" width="200" height=auto class="imagery">
                </label>
            </div>
        </div><br>

        <div style="display:table; width:100%;">
            <div style="display:table-cell;width:30px;">
                <input type="radio" name="strikingSymbol" value=4 id=ssValue4 required>
            </div>
            <div>
                <label for=ssValue4 id="sslavel4">著作権表記<br>
                    <img src="images/先行研究デザイン_フッター.png" width="350" height=auto class="imagery">
                </label>
            </div>
        </div><br>
    </div><br>

    <div>
        問題の集中のしやすさ<span style="color: #F00;">【必須】</span><br>
        <div class="evalbox" id="makeImg">
            <p><br>使いにくい
            </p>
            <div>
                1
                <input type="radio" name="usabilityNum" value=1 id=value1 required>
                <label for=value1 id="lavel1"></label>
            </div>
            <div>
                2
                <input type="radio" name="usabilityNum" value=2 id=value2 required>
                <label for=value2 id="lavel2"></label>

            </div>
            <div>
                3
                <input type="radio" name="usabilityNum" value=3 id=value3 required>
                <label for=value3 id="lavel3"></label>
            </div>
            <div>
                4
                <input type="radio" name="usabilityNum" value=4 id=value4 required>
                <label for=value4 id="lavel4"></label>

            </div>
            <div>
                5
                <input type="radio" name="usabilityNum" value=5 id=value5 required>
            </div>
            <p><br>使いやすい
            </p>
        </div>
    </div><br>
以下は任意回答項目です。感想があれば書いてください。なければ無記述で構いません。<br><br>
    <p>
        デザインの良いと思った点<br>
        <textarea name="positiveImpression" rows="6" cols="60"></textarea><br>
    </p><br>

    <p>
        デザインの悪いと思った点<br>
        <textarea name="negativeImpression" rows="6" cols="60"></textarea><br>
    </p><br>

    <p>
        その他感想</span><br>
        <textarea name="otherImpression" rows="6" cols="60"></textarea><br>
    </p><br>

    <input type="hidden" name="token" value="{{ $token }}" /><br />
    <input type="hidden" name="qpat" value="{{ $qpat }}" />
    <input type="hidden" name="layoutflag" value="{{ $layoutflag }}" /><br />
    </table>
    <button class="btn btn-success"> 次へ進む</button>
</form>


@endsection
