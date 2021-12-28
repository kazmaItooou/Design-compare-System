<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="Content-Style-Type" content="text/css">
<meta http-equiv="Content-Script-Type" content="text/javascript">
<meta name="description" content="">
<meta name="keywords" content="">
<title>実験サイト</title>
<link rel="stylesheet" href={{ asset('css/base-basic.css') }} type="text/css">
<link rel="stylesheet" href={{ asset('css/several-stepEvaluationBox.css') }} type="text/css">
<link rel="stylesheet" href={{ asset('css/image.css') }} type="text/css">
</head>
<body>
<div id="wrapper">
<!-- ヘッダー始まり -->
<div id="header">
<h1>中部テスティング</h1>
<div id="qAmount">
    @yield('qAmount')
</div>
</div>
<!-- // header END -->
<div id="contents">
<!-- ここから本文記入 -->
<!-- 直前投稿エリア -->

<!-- コンタクト挿入 -->
@yield('content')

<!-- // 本文ココまで*-->
</div>
<!-- // contents END -->
<div id="footer">
<p>Copyright &copy; 中部大学 工学部 情報工学科 鈴木研究室 EP18009伊藤和真. All Rights Reserved.</p>
</div>
<!-- // footer END -->
</div>
<!-- // wrapper END -->
</body>
</html>
