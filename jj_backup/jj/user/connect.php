<?php
/**
 * QQ互联orQQ聚合登录
**/
include("../includes/common.php");

$Oauth_config['apiurl']=$conf['login_apiurl'];
$Oauth_config['appid']=$conf['login_appid'];
$Oauth_config['appkey']=$conf['login_appkey'];
$Oauth_config['callback']=$siteurl.'user/connect.php';

if($_GET['code'] && ($conf['login_qq']==1)){
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
	
	$userqq=$DB->getRow("SELECT * FROM pre_user WHERE `qq_uid`='{$openid}' limit 1");
	if($userqq){
		$user=$userqq['user'];
		$pwd=$userqq['pwd'];
		if($islogins==1){
			@header('Content-Type: text/html; charset=UTF-8');
			linkmsg('当前QQ已绑定用户:'.$user.'，请勿重复绑定！', './index.php');
			// exit("<script language='javascript'>alert('当前QQ已绑定用户:{$user}，请勿重复绑定！');window.location.href='./index.php';</script>");
		}
		$DB->insert('userlog', ['uid'=>$user, 'name'=>'QQ快捷登录', 'data'=>'QQ快捷登录用户中心成功', 'ip'=>$clientip, 'city'=>$city, 'browser'=>$browser, 'date'=>$date]);
		$session=md5($user.$pwd.$password_hash);
		$expiretime=time()+604800;
		$token=authcode("{$user}\t{$session}\t{$expiretime}", 'ENCODE', SYS_KEY);
		setcookie("user_token", $token, time() + 604800);
		$DB->update('user', ['last' => $date, 'dlip'=>$clientip], ['user' => $user]);
		linkmsg('QQ登录成功！', '/user', 1);
// 		exit("<script language='javascript'>window.location.href='./';</script>");
	}elseif($islogins==1){
		$sds=$DB->update('user', ['qq_uid' => $openid], ['user' => $user]);
		@header('Content-Type: text/html; charset=UTF-8');
		linkmsg('已成功绑定QQ！', './index.php');
		// exit("<script language='javascript'>alert('已成功绑定QQ！');window.location.href='./index.php';</script>");
	}else{
		$_SESSION['Oauth_qq_uid']=$openid;
		@header('Content-Type: text/html; charset=UTF-8');
		linkmsg('请输入用户名和密码完成绑定和登录', './login.php?connect=true');
		// exit("<script language='javascript'>alert('请输入用户名和密码完成绑定和登录');window.location.href='./login.php?connect=true';</script>");
	}
}elseif($islogins==1 && isset($_GET['unbind'])){
	$DB->update('user', ['qq_uid' => NULL], ['user' => $user]);
	@header('Content-Type: text/html; charset=UTF-8');
	linkmsg('您已成功解绑QQ！', './index.php');
	// exit("<script language='javascript'>alert('您已成功解绑QQ！');window.location.href='./index.php';</script>");
}elseif($islogins==1 && !isset($_GET['bind'])){
	@header('Content-Type: text/html; charset=UTF-8');
	linkmsg('您已登陆！', './');
	// exit("<script language='javascript'>alert('您已登陆！');window.location.href='./';</script>");
}else{
	if($conf['login_qq']==1){
		if(!$conf['login_apiurl'] || !$conf['login_appid'] || !$conf['login_appkey'])sysmsg('未配置聚合登录');
		$Oauth=new \lib\Oauth($Oauth_config);
		$arr = $Oauth->login('qq');
		if(isset($arr['code']) && $arr['code']==0){
			exit("<script language='javascript'>window.location.replace('{$arr['url']}');</script>");
		}elseif(isset($arr['code'])){
			sysmsg('</h3>'.$arr['msg']);
		}else{
			sysmsg('获取登录数据失败');
		}
	}
}
