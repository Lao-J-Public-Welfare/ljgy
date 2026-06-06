<?php
require './inc.php';

$trade_no=isset($_GET['trade_no'])?daddslashes($_GET['trade_no']):exit('No trade_no!');

@header('Content-Type: text/html; charset=UTF-8');

$row=$DB->getRow("SELECT * FROM pre_order WHERE trade_no='{$trade_no}' limit 1");

if($row['status']==1){
	exit('{"code":1,"msg":"付款成功","backurl":"/user/?mod=money"}');
}else{
	exit('{"code":-1,"msg":"未付款"}');
}
?>