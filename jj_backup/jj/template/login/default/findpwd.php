<?php
$title="找回密码";
include '../includes/common.php';
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
					<span>Dns User Findpwd</span>
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
							<input lay-verify="required" name="username" value="" placeholder="请输入登录账号" autocomplete="off"
								class="layui-input">
						</div>
					</div>

					<div class="layui-form-item">
						<div class="layui-input-wrap">
							<div class="layui-input-prefix">
								<i class="layui-icon layui-icon-email"></i>
							</div>
							<input class="layui-input" name="email" placeholder="请输入邮箱" autocomplete="off"
                           lay-verType="tips" lay-verify="required">
						</div>
					</div>
					
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

					

					<div class="layui-form-item">
						<div class="remember-passsword">
							<div class="remember-cehcked">
								<a href="reg.php" class="greenText">新用户注册</a>
								<a href="login.php" class="greenText" style="float:right;">返回登录</a>
							</div>
						</div>
					</div>
					<div class="login-btn">
						<button type="button" class="layui-btn findpwd" lay-filter="findpwd" lay-submit>重 置</button>
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
<script type="text/javascript">
	layui.use(['jquery', 'form', 'button', 'popup', 'formX'], function () {
		let $ = layui.jquery;
		let form = layui.form;
		let button = layui.button;
		let popup = layui.popup;
		let formX = layui.formX;
		
		/* 图形验证码 */
		let captchaUrl = '../includes/lib/ValidateCode.php';
		$('img.codeImage').click(function () {
			this.src = captchaUrl + '?r=' + (new Date).getTime();
		}).trigger('click');
		
		
		form.on('submit(findpwd)', function (data) {
			let user = $("input[name='username']").val();
			let email = $("input[name='email']").val();
			let code = $("input[name='code']").val();
			let csrf_token=$("input[name='csrf_token']").val();
			button.load({
				elem: '.findpwd',
				time: 1000,
				done: function() {
					$.ajax({
						type: "POST",
						url: "ajax.php?act=forget",
						data: {
							"user": user,
							"email": email,
							"code": code,
                			"csrf_token": csrf_token
						},
						dataType: 'json',
						success: function(data) {
							if (data.code == 0) {
								popup.success(data.msg, function() {
									location.href = "./login.php"
								});
							} else {
								popup.failure(data.msg);
							}
						}
					});
				}
			});
		});
	});
</script>
</body>
</html>