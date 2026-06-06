<?php
require 'inc.php';
session_start();
@header('Content-Type: text/html; charset=UTF-8');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>正在为您跳转到支付页面，请稍候...</title>
    <style type="text/css">
        body {margin:0;padding:0;}
        p {position:absolute;
            left:50%;top:50%;
            width:330px;height:30px;
            margin:-35px 0 0 -160px;
            padding:20px;font:bold 14px/30px "宋体", Arial;
            background:#f9fafc url(/assets/load.gif) no-repeat 20px 26px;
            text-indent:22px;border:1px solid #c5d0dc;}
        #waiting {font-family:Arial;}
    </style>
<script>
function open_without_referrer(link){
document.body.appendChild(document.createElement('iframe')).src='javascript:"<script>top.location.replace(\''+link+'\')<\/script>"';
}
</script>
</head>
<body>
<?php

$type=isset($_GET['type'])?daddslashes($_GET['type']):sysmsg('No type!');
$orderid=isset($_GET['orderid'])?daddslashes($_GET['orderid']):sysmsg('No orderid!');
if(!is_numeric($orderid))sysmsg('订单号不符合要求!');
$row=$DB->getRow("SELECT * FROM pre_order WHERE trade_no=:trade_no limit 1", [':trade_no'=>$orderid]);
if(!$row['trade_no'])sysmsg('该订单号不存在，请返回来源地重新发起请求！');
if($row['money']=='0' || !preg_match('/^[0-9.]+$/', $row['money']))sysmsg('订单金额不合法');
if($row['status']>=1)sysmsg('该订单已支付完成，请返回重新生成订单');

$DB->exec("update `pre_order` set `type`=:type where `trade_no`=:trade_no", [':type'=>$type, ':trade_no'=>$orderid]);
$ordername = !empty($conf['ordername'])?ordername_replace($conf['ordername'],$row['name'],$orderid):$row['name'];

if(($type=='alipay'&&$conf['alipay_api']==1) || ($type=='qqpay'&&$conf['qqpay_api']==1) || ($type=='wxpay'&&$conf['wxpay_api']==1)){ //易支付
    require_once(XPAY_ROOT."epay/epay.config.php");
    switch ($conf['epay_v']) {
        case '2':
            require_once(XPAY_ROOT."epay/EpayCoreV2.class.php");
            $parameter = array(
            	"type" => $type,
            	"notify_url" => $sitepayurl.'/epay_notify.php',
            	"return_url" => $sitepayurl.'/epay_return.php',
            	"out_trade_no" => $orderid,
            	"name" => $ordername,
            	"money"	=> $row['money'],
            );
            //建立请求
            $epay = new EpayCoreV2($epay_config);
            break;
        default:
        	require_once(XPAY_ROOT."epay/EpayCoreV1.class.php");
        	$parameter = array(
            	"pid" => $epay_config['pid'],
            	"type" => $type,
            	"notify_url" => $sitepayurl.'/epay_notify.php',
            	"return_url" => $sitepayurl.'/epay_return.php',
            	"out_trade_no" => $orderid,
            	"name" => $ordername,
            	"money"	=> $row['money'],
            );
        	//建立请求
        	$epay = new EpayCoreV1($epay_config);
            break;
    }
    $html_text = $epay->pagePay($parameter);
    echo $html_text;
}elseif($type=='alipay' && $conf['alipay_api']==2){ //支付宝
	if(strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger')!==false){
		include(XPAY_ROOT.'alipay/wxopen.php');
		exit;
	}

	if(checkmobile()==true){
		require_once(XPAY_ROOT."alipay/model/builder/AlipayTradeWapPayContentBuilder.php");
		require_once(XPAY_ROOT."alipay/AlipayTradeService.php");

		//构造参数
		$payRequestBuilder = new AlipayTradeWapPayContentBuilder();
		$payRequestBuilder->setSubject($ordername);
		$payRequestBuilder->setTotalAmount($row['money']);
		$payRequestBuilder->setOutTradeNo($orderid);

		$aop = new AlipayTradeService($config);
		echo $aop->wapPay($payRequestBuilder);
	}else{
		require_once(XPAY_ROOT."alipay/model/builder/AlipayTradePagePayContentBuilder.php");
		require_once(XPAY_ROOT."alipay/AlipayTradeService.php");

		//构造参数
		$payRequestBuilder = new AlipayTradePagePayContentBuilder();
		$payRequestBuilder->setSubject($ordername);
		$payRequestBuilder->setTotalAmount($row['money']);
		$payRequestBuilder->setOutTradeNo($orderid);

		$aop = new AlipayTradeService($config);
		echo $aop->pagePay($payRequestBuilder);
	}
}elseif($type=='alipay' && $conf['alipay_api']==3){ //支付宝当面付扫码支付
	echo "<script>window.location.href='./alipay.php?trade_no={$orderid}';</script>";
	exit;
}elseif($type=='wxpay'){ //微信支付
	$DB->exec("update `pre_order` set `domain` ='{$_SERVER['HTTP_HOST']}' where `trade_no`='{$orderid}'");
	if(strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger')!==false){
		echo "<script>window.location.href='./wxjspay.php?trade_no={$orderid}&d=1';</script>";
	}elseif(checkmobile()==true){
		echo "<script>window.location.href='./wxwappay.php?trade_no={$orderid}';</script>";
	}else{
		echo "<script>window.location.href='./wxpay.php?trade_no={$orderid}';</script>";
	}
}elseif($type=='qqpay'){ //QQ支付
	if(checkmobile()==true){
		echo "<script>window.location.href='./qqwappay.php?trade_no={$orderid}';</script>";
	}else{
		echo "<script>window.location.href='./qqpay.php?trade_no={$orderid}';</script>";
	}
}

?>
<p>正在为您跳转到支付页面，请稍候...</p>
</body>
</html>