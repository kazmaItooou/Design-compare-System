<?php
// UNIX TIMESTAMPを[$timestamp]という変数に格納する
$timestamp = time() ;
$now = microtime(true);
$msStr = substr(explode(".", (microtime(true) . ""))[1], 0, 3);
// 出力する
//echo time().".$msStr";
echo $now;
//echo date( "Y/m/d h:i:s" , $timestamp ).".$msStr" ;
