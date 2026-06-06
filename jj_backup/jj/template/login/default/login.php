<?php
/**
 * 登录
**/
include '../includes/common.php';
$title="用户登录";
if($islogins==1)linkmsg('您已登录！', '/user', 1);
// include 'header.php';
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title><?php echo $conf['title']?> - <?php echo $title ?></title>
    <link rel="icon" href="/favicon.ico" type="image/ico">
    <meta name="keywords" content="<?php echo $conf['keywords']; ?>"/>
    <meta name="description" content="<?php echo $conf['description']; ?>">
    <meta name="author" content="HuanYing">
	<!-- 样 式 文 件 -->
	<link rel="stylesheet" href="/assets/component/pear/css/pear.css" />
	<link rel="stylesheet" href="/assets/admin/css/other/login.css" />
	<link rel="stylesheet" href="/assets/admin/css/variables.css" />
    <link rel="stylesheet" href="//at.alicdn.com/t/c/font_3711899_5krgq0p8pqe.css"/>
    <link rel="stylesheet" href="/assets/admin/css/captcha.css" type="text/css" />
	<script>if (window.self != window.top) { top.location.reload();}</script>
</head>
<!-- 代 码 结 构 -->
<div class="login-page" style="background-image: url(/assets/admin/images/background.svg)">
	<div class="layui-row">
		<div class="layui-col-sm6 login-bg layui-hide-xs">
			<img class="login-bg-img" src="/assets/admin/images/banner.png" alt="" />
		</div>
<div class="layui-col-sm6 layui-col-xs12 login-form">
	<div class="layui-form">
		<div class="form-center">
			<div class="form-center-box">
				<div class="top-log-title">
					<img class="top-log" src="/assets/images/favicon.ico" alt="" />
					<span>Dns User Login</span>
				</div>
				<div class="top-desc">
					以 超 乎 想 象 的 速 度 构 建 内 部 工 具
				</div>
				<div style="margin-top: 30px;">
				    <input type="hidden" name="csrf_token" value="<?php echo $csrf_token?>">
					<div class="layui-form-item">
						<div class="layui-input-wrap">
							<div class="layui-input-prefix">
								<i class="layui-icon layui-icon-username"></i>
							</div>
							<input lay-verify="required" name="user" value="" placeholder="请输入登录账号" autocomplete="off"
								class="layui-input">
						</div>
					</div>
					<div class="layui-form-item">
						<div class="layui-input-wrap">
							<div class="layui-input-prefix">
								<i class="layui-icon layui-icon-password"></i>
							</div>
							<input type="password" name="pass" value="" lay-verify="required|pass" placeholder="请输入登录密码" autocomplete="off" class="layui-input" lay-affix="eye">
						</div>
					</div>
					<?php if($conf['captcha_open'] == 0): ?>
				<?php else: ?>
					<div class="tab-log-verification">
						<div class="verification-text">
							<div class="layui-input-wrap">
								<div class="layui-input-prefix">
									<i class="layui-icon layui-icon-auz"></i>
								</div>
								<input lay-verify="required" name="code" placeholder="验证码" autocomplete="off" class="layui-input">
							</div>
						</div>
						<img class="codeImage" alt=""/>
					</div>
				<?php endif; ?>
					
					<div class="layui-form-item">
						<div class="remember-passsword">
							<div class="remember-cehcked">
								<a href="findpwd.php" class="greenText">忘记密码?</a>
								<a href="reg.php" class="greenText" style="float:right;">新用户注册</a>
							</div>
						</div>
					</div>
					<div class="login-btn">
						<button type="button" class="layui-btn login" lay-filter="login" lay-submit>登 录</button>
					</div>
					<div class="other-login">
						<div class="other-login-methods">
							其他方式
						</div>
						<div class="greenText">
							<?php if($conf['login_qq']!=0){ ?>
							<a href="connect.php?type=qq"><i class="layui-icon layui-icon-login-qq" style="color:#3492ed;"></i></a>&emsp;
							<?php } if($conf['login_wx']!=0){ ?>
							<a href="wx_connect.php?type=wx"><i class="layui-icon layui-icon-login-wechat" style="color:#4daf29;"></i></a>&emsp;
							<?php } ?>
						</div> 
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
	</div>
</div>

<script src="/assets/component/layui/layui.js"></script>
<script src="/assets/component/pear/pear.js"></script>
<script src="//static.geetest.com/static/tools/gt.js"></script>
<script src="//static.geetest.com/v4/gt4.js"></script>
<?php include 'footer.php';?>
<script type="text/javascript">
    layui.use(['jquery', 'layer', 'form', 'button', 'popup'], function () {
        var $ = layui.jquery;
		var layer = layui.layer;
		var form = layui.form;
		var button = layui.button;
		var popup = layui.popup;
		
        /* 图形验证码 */
        var captchaUrl = '../includes/lib/ValidateCode.php';
        $('img.codeImage').click(function () {
            this.src = captchaUrl + '?r=' + (new Date).getTime();
        }).trigger('click');
        
       
        $(document).ready(function(){
        	if($("#captchaGt").length>0) captcha_open=1;
        	form.on('submit(login)', function (data) {
        		var user=$("input[name='user']").val();
        		var pass=$("input[name='pass']").val();
        		var code=$("input[name='code']").val();
        		if(user=='' || pass==''){popup.failure(type==1?'账号和密码不能为空！':'ID和密钥不能为空！');return false;}
        		
        		button.load({
        			elem: '.login',
        			time: 1000,
        			done: function() {
                        $.ajax({
                            type: "POST",
                            url: "ajax.php?act=login",
                            data: {user:user, pwd:pass, code:code,},
                            dataType: 'json',
                            success: function(data) {
                                if (data.code == 0) {
        							popup.success(data.msg, function() {
        								location.href = "../user"
        							});
                                } else {
                                    popup.failure(data.msg);
                                    $.captchaObj.reset();
                                }
                            }
                        });
        			}
        		});
        	});
        });
        
    });
</script>
</body>
</html>