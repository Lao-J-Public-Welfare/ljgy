<?php
/* *
 * 功能：彩虹易支付服务器异步通知页面
 * 版本：3.3
 * 日期：2012-07-23
 * 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
 * 该代码仅供学习和研究支付宝接口使用，只是提供一个参考。


 *************************页面功能说明*************************
 * 创建该页面文件时，请留心该页面文件中无任何HTML代码及空格。
 * 该页面不能在本机电脑测试，请到服务器上做测试。请确保外部可以访问该页面。
 * 该页面调试工具请使用写文本函数logResult，该函数已被默认关闭，见alipay_notify_class.php中的函数verifyNotify
 * 如果没有收到该页面返回的 success 信息，支付宝会在24小时内按一定的时间策略重发通知
 */

require_once("./inc.php");
require_once(XPAY_ROOT."epay/epay.config.php");

switch ($conf['epay_v']) {
    case '2':
        require_once(XPAY_ROOT."epay/EpayCoreV2.class.php");
        //计算得出通知验证结果
        $epay = new EpayCoreV2($epay_config);
        $verify_result = $epay->verify($_GET);
        break;
    default:
        require_once(XPAY_ROOT."epay/EpayCoreV1.class.php");
        //计算得出通知验证结果
        $epay = new EpayCoreV1($epay_config);
        $verify_result = $epay->verifyNotify();
        break;
}

if($verify_result && ($conf['alipay_api']==1 || $conf['qqpay_api']==1 || $conf['wxpay_api']==1)) {
	//商户订单号
	$out_trade_no = daddslashes($_GET['out_trade_no']);

	//支付宝交易号
	$trade_no = $_GET['trade_no'];

	//交易状态
	$trade_status = $_GET['trade_status'];

	//金额
	$money = (float)$_GET['money'];
	
	$srow=$DB->getRow("SELECT * FROM pre_order WHERE trade_no='{$out_trade_no}' limit 1 for update");
    $user=$DB->getRow("SELECT * FROM pre_user WHERE uid='{$srow['uid']}' limit 1 for update");
    if ($_GET['trade_status'] == 'TRADE_SUCCESS' && $srow['status']==0 && round($srow['money'],2)==round($money,2)) {
		
        if($srow['status']==0 && round($srow['money'],2)==round($money,2)){
        $DB->exec("update `pre_order` set `status` ='1' where `trade_no`='{$out_trade_no}'");
				$DB->exec("update `pre_order` set `endtime` ='{$date}' where `trade_no`='{$out_trade_no}'");
				$DB->exec("update `pre_user` set rmb='{$user['money']}'+'{$srow['money']}' where uid='{$srow['uid']}'");
    			$jj = $DB->insert('detailed', ['uid'=>$user['user'], 'type'=>'收入', 'data'=>'用户充值'.$srow['money'].'元', 'before_change'=>$user['rmb'], 'money'=>$srow['money'], 'after_change'=>$user['rmb']+$srow['money'], 'date'=>$date]);
            linkmsg('恭喜您成功充值[ '.$srow['money'].' ]元！','/user/', 1);
		}else{
          linkmsg('充值失败请联系站长！','/user/', 1);
    }
    }
    echo "success";
} else {
    //验证失败
    echo "fail";
}
?>