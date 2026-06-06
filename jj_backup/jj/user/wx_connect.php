<?php
/**
 * 微信聚合登录
**/
include("../includes/common.php");

$Oauth_config['apiurl']=$conf['login_apiurl'];
$Oauth_config['appid']=$conf['login_appid'];
$Oauth_config['appkey']=$conf['login_appkey'];
$Oauth_config['callback']=$siteurl.'user/wx_connect.php';

if($_GET['code'] && ($conf['login_wx']==1)){
		$type = isset($_GET['type'])?$_GET['type']:exit('{"code":-1,"msg":"no type"}');
		$Oauth=new \lib\Oauth($Oauth_config);
		$arr = $Oauth->callback();
		if(isset($arr['code']) && $arr['code']==0){
			$openid=$arr['social_uid'];
			$access_token=$arr['access_token'];
		}elseif(isset($arr['code'])){
			sysmsg('</h3>'.$arr['msg']);
		}else{
			sysmsg('获取登录数据失败');
		}

	$userwx=$DB->getRow("SELECT * FROM pre_user WHERE `wx_uid`='{$openid}' limit 1");
	if($userwx){
		$user=$userwx['user'];
		$pwd=$userwx['pwd'];
		if($islogins==1){
			@header('Content-Type: text/html; charset=UTF-8');
            linkmsg('当前微信已绑定用户:'.$user.'，请勿重复绑定！', './index.php');
		}
		$DB->insert('userlog', ['uid'=>$user, 'name'=>'微信快捷登录', 'data'=>'微信快捷登录用户中心成功', 'ip'=>$clientip, 'city'=>$city, 'browser'=>$browser, 'date'=>$date]);
		$session=md5($user.$pwd.$password_hash);
		$expiretime=time()+604800;
		$token=authcode("{$user}\t{$session}\t{$expiretime}", 'ENCODE', SYS_KEY);
		setcookie("user_token", $token, time() + 604800);
		$DB->update('user', ['last' => $date, 'dlip'=>$clientip], ['user' => $user]);
		linkmsg('微信登录成功！', '/user', 1);
	}elseif($islogins==1){
		$sds=$DB->update('user', ['wx_uid' => $openid], ['user' => $user]);
		@header('Content-Type: text/html; charset=UTF-8');
        linkmsg('已成功绑定微信！', './index.php');
	}else{
		$_SESSION['Oauth_wx_uid']=$openid;
		@header('Content-Type: text/html; charset=UTF-8');
        linkmsg('请输入用户名和密码完成绑定和登录', './login.php?connect=true');
	}
}elseif($islogins==1 && isset($_GET['unbind'])){
	$DB->update('user', ['wx_uid' => NULL], ['user' => $user]);
	@header('Content-Type: text/html; charset=UTF-8');
    linkmsg('您已成功解绑微信！', './index.php');
}elseif($islogins==1 && !isset($_GET['bind'])){
	@header('Content-Type: text/html; charset=UTF-8');
    linkmsg('您已登陆！', './');
}else{
	if($conf['login_wx']==1){
		if(!$conf['login_apiurl'] || !$conf['login_appid'] || !$conf['login_appkey'])linkmsg('未配置好聚合登录信息', './');
		$Oauth=new \lib\Oauth($Oauth_config);
		$arr = $Oauth->login('wx');
		if(isset($arr['code']) && $arr['code']==0){
			exit("<script language='javascript'>window.location.replace('{$arr['url']}');</script>");
		}elseif(isset($arr['code'])){
			sysmsg('</h3>'.$arr['msg']);
		}else{
			sysmsg('获取登录数据失败');
		}
	}
}
