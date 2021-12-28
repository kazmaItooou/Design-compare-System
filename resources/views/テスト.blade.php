<!-- レイアウト選択-->
@php
switch ($layoutflag) {
case 'basic':
$layout = 'Basic';
break;
case 'bad':
$layout = 'Bad';
break;
}
$selectedLayout = 'layouts.base' . $layout;
@endphp
@extends($selectedLayout)

<!-- badレイアウトのときの消去法の説明位置-->
@if ($layoutflag == 'bad')
<blockquote text-align="center">
    <div text-align="left">
        <b>
            <p>
                消去法で考える際に、「消」を押すことでその選択肢に線を引くことができます
            </p>
        </b>
    </div>
</blockquote>
@endif

<!-- 現在の問題数-->
@section('qAmount')
@if ($layoutflag == 'basic')
問{{ $Qnum}}/{{ $qAmount }}
@else
問{{ $Qnum}}
@endif
@endsection

<!-- すでに回答済み-->
@section('content')
@if ($isSetflag == true && $token != 'dummy')
先ほど回答した問題はすでに回答済みであったため記録されていません！<br><br>
@endif

<!-- 消去法のjs-->
<script src="{{ asset('/js/selectsLine-through.js') }}"></script>
<!-- 問題のマウスオーバのjs-->
<script src="{{ asset('/js/questionMouseover.js') }}"></script>
<form method="post" action="/テスト">
    @csrf
    <div>
        <!-- 問題表示-->
        <div id="box5">
            <p>
                {{ $question }}
            </p>
        </div>
        <!-- 問題表示終わり-->
        <p>
            <br>
            <!-- htmlラジオボタン出力 -->
        <div id="selects">
            @php
            //渡された問題を繰り返し出力
            $num = 1;
            foreach($choises as &$value):
            @endphp

            <!-- 問題basicレイアウト -->
            @if ($layoutflag == 'basic' )
            <div style="display:table; width:100%;">
                <div  style="display:table-cell; width:30px;">
                    <button class="eliminateMethod-button" id="eliminateMethod{{ $num }}" type="button"
                        onclick="torikeshi('question{{ $num }}')">消
                    </button>
                </div>
                <div style="display:table; width:100%;">
                    <div style="display:table-cell; width:30px;">
                        <input type="radio" name="choise" value={{ $num }} id={{ $num }}
                            onMouseOver="changeColor( 'over', 'question{{ $num }}' )"
                            onMouseOut="changeColor( 'out', 'question{{ $num }}' )" required>
                    </div>
                    <div id="question{{ $num }}">
                        <label for={{ $num }} id="lavel{{ $num }}" style="color:#1f1f1f display:table-cell;"
                            onMouseOver="changeColorBasicLayout( 'over', 'question{{ $num }}' )"
                            onMouseOut="changeColorBasicLayout( 'out', 'question{{ $num }}' )">
                            {{ $value }}
                    </div>
                </div>
                </label><br>
            </div>
            <!-- 問題badレイアウト -->
            @elseif(($layoutflag == 'bad'))
            <div style="display:table; width:100%;">
                <div id="eliminateMethod{{ $num }}" type="button" onclick="torikeshi('question{{ $num }}')"
                    style="display:table-cell; width:30px;">消
                </div>
                <div style="display:table; width:100%;">
                    <div style="display:table-cell; width:30px;">
                        <input type="radio" name="choise" value={{ $num }} id={{ $num }} required>
                    </div>
                    <div id="question{{ $num }}">
                        <label for={{ $num }} id="lavel{{ $num }}" style="display:table-cell;"
                            onMouseOver="changeColorBadLayout( 'over', 'question{{ $num }}' )"
                            onMouseOut="changeColorBadLayout( 'out', 'question{{ $num }}' )">
                            {{ $value }}
                    </div>
                </div>
            </div>
            </label><br>
            @endif
            @php
            $num++;
            endforeach;
            @endphp
        </div>
    </div>
    <!-- htmlラジオボタン出力終わり -->

    <!-- 次の問題に渡すトークン、問題の正答 -->
    <input type="hidden" name="token" value="{{ $token }}" />
    <input type="hidden" name="correctAns" value="{{ $correctAns }}" />
    <input type="hidden" name="Qnum" value="{{ $Qnum }}" />
    <input type="hidden" name="qpat" value="{{ $qpat }}" />
    <input type="hidden" name="layoutflag" value="{{ $layoutflag }}" />
    <input type="hidden" name="startTime" value="{{ $startTime }}" />
    </p>
    <div id="contents-nextQ">
        <p><input type="submit" value="次の問題" class="nextquestion btn--orange btn--shadow"></p>
    </div>

    <!-- 問題basic消去法説明 -->
    @if ($layoutflag == 'basic')
    <blockquote text-align="center">
        <div id = "eliminateMethod-exposition" text-align="left">
                消去法で考える際に、「消」を押すことでその選択肢に線を引くことができます。
        </div>
    </blockquote>
    @endif

</form>

@endsection
