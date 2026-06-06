<?php
/**
 * 控制台
**/
include("../includes/common.php");
$title='控制台';
if($islogin==1){}else linkmsg('请先登陆后再进行操作~', './login.php');
$user=$DB->getColumn("SELECT count(*) FROM pre_user");
$domain=$DB->getColumn("SELECT count(*) FROM pre_url");
$record=$DB->getColumn("SELECT count(*) FROM pre_record");
$shop=$DB->getColumn("SELECT count(*) FROM pre_shop");
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>分析页</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="/assets/component/pear/css/pear.css" />
	<link rel="stylesheet" href="/assets/admin/css/other/console1.css" />
</head>

<body class="pear-container">

<div class="layui-row layui-col-space10">
	<div class="layui-col-xs6 layui-col-md3">
		<div class="layui-card top-panel">
			<div class="layui-card-header">域名数量</div>
			<div class="layui-card-body">
				<div class="layui-row layui-col-space5">
					<div class="layui-col-xs8 layui-col-md8 top-panel-number" style="color: #28333E;" id="api">
						<?php echo $domain;?>
					</div>
					<div class="layui-col-xs4 layui-col-md4 top-panel-tips">
                    <svg t="1765348270416" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="4808" width="200" height="200"><path d="M512 985.6c-185.6 0-358.4-108.8-435.2-281.6-6.4-12.8 0-32 12.8-38.4 12.8-6.4 32 0 38.4 12.8 64 153.6 217.6 249.6 377.6 249.6 166.4 0 313.6-96 377.6-249.6 6.4-12.8 25.6-19.2 38.4-12.8 12.8 6.4 19.2 25.6 12.8 38.4-64 172.8-236.8 281.6-422.4 281.6zM102.4 371.2h-12.8c-12.8-12.8-19.2-25.6-12.8-44.8C147.2 153.6 320 38.4 512 38.4s358.4 115.2 435.2 288c6.4 12.8 0 32-12.8 38.4-12.8 6.4-32 0-38.4-12.8-64-153.6-217.6-249.6-384-249.6s-313.6 102.4-384 256c0 6.4-12.8 12.8-25.6 12.8z" fill="#F4C32D" p-id="4809"></path><path d="M70.4 627.2L0 364.8h38.4l38.4 172.8c0 19.2 6.4 38.4 6.4 51.2 6.4-25.6 12.8-44.8 12.8-51.2l51.2-179.2H192l38.4 134.4c6.4 32 19.2 64 19.2 89.6 0-6.4 6.4-25.6 12.8-51.2l38.4-166.4h32L262.4 627.2h-32l-57.6-198.4c0-19.2-6.4-25.6-6.4-32 0 12.8-6.4 19.2-6.4 32l-57.6 198.4h-32zM416 627.2L345.6 364.8H384l38.4 172.8c0 19.2 6.4 38.4 6.4 51.2 6.4-25.6 12.8-44.8 12.8-51.2l51.2-179.2h44.8L576 492.8c6.4 32 19.2 64 19.2 89.6 0-6.4 6.4-25.6 6.4-51.2l38.4-166.4h32l-64 262.4H576l-57.6-198.4c0-19.2-6.4-25.6-6.4-32 0 12.8-6.4 19.2-6.4 32L448 627.2h-32zM755.2 627.2l-70.4-262.4h38.4l38.4 172.8c6.4 19.2 12.8 38.4 12.8 51.2 6.4-25.6 12.8-44.8 12.8-51.2l51.2-179.2h44.8l38.4 134.4c6.4 32 19.2 64 19.2 89.6 6.4-19.2 6.4-38.4 12.8-57.6l38.4-166.4h32l-70.4 262.4h-32l-57.6-198.4c-6.4-19.2-6.4-25.6-6.4-32 0 12.8-6.4 19.2-6.4 32l-57.6 198.4h-38.4z" fill="#F4C32D" p-id="4810"></path></svg>					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="layui-col-xs6 layui-col-md3">
		<div class="layui-card top-panel">
			<div class="layui-card-header">解析数量</div>
			<div class="layui-card-body">
				<div class="layui-row layui-col-space5">
					<div class="layui-col-xs8 layui-col-md8 top-panel-number" style="color: #28333E;" id="apis">
						<?php echo $record;?>
					</div>
					<div class="layui-col-xs4 layui-col-md4 top-panel-tips">
                    <svg t="1765348293551" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="4959" width="200" height="200"><path d="M618.666667 170.666667h-128c-46.933333 0-85.333333 38.4-85.333334 85.333333v128c0 46.933333 38.4 85.333333 85.333334 85.333333h130.133333c21.333333-19.2 46.933333-34.133333 72.533333-44.8 6.4-12.8 10.666667-25.6 10.666667-40.533333v-128c0-46.933333-38.4-85.333333-85.333333-85.333333zM128 469.333333h128c46.933333 0 85.333333-38.4 85.333333-85.333333v-128c0-46.933333-38.4-85.333333-85.333333-85.333333H128c-46.933333 0-85.333333 38.4-85.333333 85.333333v128c0 46.933333 38.4 85.333333 85.333333 85.333333z m407.466667 296.533334c-4.266667 8.533333-10.666667 14.933333-21.333334 14.933333s-17.066667-4.266667-21.333333-14.933333l-27.733333-117.333334V640c2.133333-8.533333 6.4-12.8 14.933333-14.933333 8.533333 0 14.933333 4.266667 17.066667 14.933333l17.066666 89.6 17.066667-57.6v-14.933333c0-46.933333 12.8-89.6 34.133333-128H128c-46.933333 0-85.333333 38.4-85.333333 85.333333v149.333333c0 46.933333 38.4 85.333333 85.333333 85.333334h492.8c-34.133333-29.866667-61.866667-70.4-74.666667-115.2l-10.666666 32z m-266.666667-117.333334l-27.733333 117.333334c-4.266667 10.666667-10.666667 14.933333-21.333334 14.933333s-19.2-4.266667-21.333333-14.933333L172.8 682.666667 149.333333 765.866667c-4.266667 8.533333-10.666667 14.933333-21.333333 14.933333s-17.066667-4.266667-21.333333-14.933333l-27.733334-117.333334V640c2.133333-8.533333 6.4-12.8 14.933334-14.933333 8.533333 0 14.933333 4.266667 17.066666 14.933333l17.066667 89.6L157.866667 640c4.266667-8.533333 8.533333-12.8 17.066666-12.8s14.933333 4.266667 17.066667 12.8l27.733333 93.866667 19.2-89.6c2.133333-10.666667 6.4-14.933333 17.066667-14.933334 8.533333 0 14.933333 4.266667 14.933333 14.933334-2.133333 0-2.133333 2.133333-2.133333 4.266666z m194.133333 0l-27.733333 117.333334c-4.266667 10.666667-10.666667 14.933333-21.333333 14.933333s-19.2-4.266667-21.333334-14.933333L366.933333 682.666667 341.333333 765.866667c-4.266667 8.533333-10.666667 14.933333-21.333333 14.933333s-17.066667-4.266667-21.333333-14.933333l-27.733334-117.333334V640c2.133333-8.533333 6.4-12.8 14.933334-14.933333 8.533333 0 14.933333 4.266667 17.066666 14.933333l17.066667 89.6 27.733333-93.866667c4.266667-8.533333 8.533333-12.8 17.066667-12.8s14.933333 4.266667 17.066667 12.8l27.733333 93.866667 19.2-89.6c2.133333-10.666667 6.4-14.933333 17.066667-14.933333 8.533333 0 14.933333 4.266667 14.933333 14.933333 2.133333 4.266667 2.133333 6.4 2.133333 8.533333zM789.333333 469.333333c-106.666667 0-192 85.333333-192 192s85.333333 192 192 192 192-85.333333 192-192-85.333333-192-192-192z m74.666667 234.666667H789.333333v38.4c0 10.666667-12.8 17.066667-21.333333 10.666667L674.133333 682.666667c-6.4-4.266667-6.4-14.933333 0-21.333334l93.866667-70.4c8.533333-6.4 21.333333 0 21.333333 10.666667V640h74.666667c17.066667 0 32 14.933333 32 32s-14.933333 32-32 32z" p-id="4960"></path></svg>					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="layui-col-xs6 layui-col-md3">
		<div class="layui-card top-panel">
			<div class="layui-card-header">用户数量</div>
			<div class="layui-card-body">
				<div class="layui-row layui-col-space5">
					<div class="layui-col-xs8 layui-col-md8 top-panel-number" style="color: #28333E;" id="yh">
						<?php echo $user;?>
					</div>
					<div class="layui-col-xs4 layui-col-md4  top-panel-tips">
						<svg t="1727369805621" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="9014" width="200" height="200"><path d="M525.5 596.2c-156.1 0-282.6 127.7-282.6 285.2h565.2c0-157.5-126.5-285.2-282.6-285.2z" fill="#FCEE21" p-id="9015"></path><path d="M491.2 892.8H187.3c-6.3 0-11.4-5.1-11.4-11.4 0-142.9 91.5-267.7 227.8-310.5 6-1.9 12.4 1.4 14.3 7.4 1.9 6-1.5 12.4-7.4 14.3C287.4 631.2 203.5 741.9 198.8 870h292.3c6.3 0 11.4 5.1 11.4 11.4s-5.1 11.4-11.3 11.4z" fill="#3E3A39" p-id="9016"></path><path d="M561.7 272.8c36.5 30.5 59.7 76.4 59.7 127.7 0 92-74.5 166.5-166.5 166.5-19.6 0-38.5-3.4-55.9-9.7 28.9 24.2 66.1 38.8 106.8 38.8 92 0 166.5-74.5 166.5-166.5-0.1-72.3-46.2-133.8-110.6-156.8z" fill="#F8B62D" p-id="9017"></path><path d="M621.4 400.6c0-51.3-23.2-97.2-59.7-127.7-17.5-6.2-36.3-9.7-55.9-9.7-92 0-166.5 74.5-166.5 166.5 0 51.3 23.2 97.2 59.7 127.7 17.5 6.2 36.3 9.7 55.9 9.7 91.9 0 166.5-74.6 166.5-166.5z" fill="#FCEE21" p-id="9018"></path><path d="M491.2 607.5c-106.1 0-192.4-86.3-192.4-192.4 0-25.4 4.9-50.1 14.5-73.4 2.4-5.8 9.1-8.6 14.9-6.2 5.8 2.4 8.6 9.1 6.2 14.9-8.5 20.5-12.8 42.3-12.8 64.7 0 93.6 76.1 169.7 169.7 169.7S661 508.7 661 415.1s-76.1-169.7-169.7-169.7c-37 0-72.1 11.7-101.6 33.8-5 3.8-12.2 2.7-15.9-2.3-3.8-5-2.7-12.2 2.3-15.9 33.5-25.1 73.3-38.3 115.2-38.3 106.1 0 192.4 86.3 192.4 192.4-0.1 106.1-86.4 192.4-192.5 192.4z" fill="#3E3A39" p-id="9019"></path><path d="M340.1 320c-1.9 0-3.7-0.5-5.5-1.4-5.5-3-7.5-9.9-4.5-15.4 3.2-5.8 7.7-11 13-15 5-3.8 12.2-2.7 15.9 2.3 3.8 5 2.7 12.2-2.3 15.9-2.8 2.1-5.1 4.8-6.7 7.8-2 3.7-5.9 5.8-9.9 5.8z" fill="#3E3A39" p-id="9020"></path><path d="M198.5 509.1c-17 0-30.8-13.8-30.8-30.8s13.8-30.8 30.8-30.8 30.8 13.8 30.8 30.8c0 16.9-13.8 30.8-30.8 30.8z m0-46.5c-8.6 0-15.7 7-15.7 15.7 0 8.6 7 15.7 15.7 15.7 8.6 0 15.7-7 15.7-15.7-0.1-8.7-7.1-15.7-15.7-15.7z" fill="#47B7F8" p-id="9021"></path><path d="M174.3 326.8h-13.5v-13.5c0-3.6-2.9-6.5-6.5-6.5s-6.5 2.9-6.5 6.5v13.5h-13.5c-3.6 0-6.5 2.9-6.5 6.5s2.9 6.5 6.5 6.5h13.5v13.5c0 3.6 2.9 6.5 6.5 6.5s6.5-2.9 6.5-6.5v-13.5h13.5c3.6 0 6.5-2.9 6.5-6.5s-2.9-6.5-6.5-6.5zM915.5 327.9H902v-13.5c0-3.6-2.9-6.5-6.5-6.5s-6.5 2.9-6.5 6.5v13.5h-13.5c-3.6 0-6.5 2.9-6.5 6.5s2.9 6.5 6.5 6.5H889v13.5c0 3.6 2.9 6.5 6.5 6.5s6.5-2.9 6.5-6.5v-13.5h13.5c3.6 0 6.5-2.9 6.5-6.5s-2.9-6.5-6.5-6.5z" fill="#F7E42F" p-id="9022"></path><path d="M874.7 463.4H859v-15.7c0-4.2-3.4-7.6-7.6-7.6s-7.6 3.4-7.6 7.6v15.7h-15.7c-4.2 0-7.6 3.4-7.6 7.6s3.4 7.6 7.6 7.6h15.7v15.7c0 4.2 3.4 7.6 7.6 7.6s7.6-3.4 7.6-7.6v-15.7h15.7c4.2 0 7.6-3.4 7.6-7.6s-3.4-7.6-7.6-7.6z" fill="#F8B62D" p-id="9023"></path><path d="M277 258.2m-11.4 0a11.4 11.4 0 1 0 22.8 0 11.4 11.4 0 1 0-22.8 0Z" fill="#F8B62D" p-id="9024"></path><path d="M785.3 318.2m-15.2 0a15.2 15.2 0 1 0 30.4 0 15.2 15.2 0 1 0-30.4 0Z" fill="#F8B62D" p-id="9025"></path><path d="M689.2 168.4m-15.2 0a15.2 15.2 0 1 0 30.4 0 15.2 15.2 0 1 0-30.4 0Z" fill="#F7E42F" p-id="9026"></path><path d="M503.9 175.3c-17 0-30.8-13.8-30.8-30.8s13.8-30.8 30.8-30.8 30.8 13.8 30.8 30.8c0.1 17-13.8 30.8-30.8 30.8z m0-46.5c-8.6 0-15.7 7-15.7 15.7 0 8.6 7 15.7 15.7 15.7s15.7-7 15.7-15.7-7-15.7-15.7-15.7z" fill="#F8B62D" p-id="9027"></path><path d="M322.3 102.3c-1.6-1.6-4.3-1.6-5.9 0-0.8 0.8-1.2 1.9-1.2 3s0.4 2.2 1.2 3l13.5 13.5c0.8 0.8 1.8 1.2 3 1.2 1.1 0 2.2-0.4 3-1.2 1.6-1.6 1.6-4.3 0-5.9l-13.6-13.6zM357.9 137.9c-0.8-0.8-1.8-1.2-3-1.2-1.1 0-2.2 0.4-3 1.2-1.6 1.6-1.6 4.3 0 5.9l13.5 13.5c0.8 0.8 1.8 1.2 3 1.2 1.1 0 2.2-0.4 3-1.2 0.8-0.8 1.2-1.8 1.2-3 0-1.1-0.4-2.2-1.2-3l-13.5-13.4zM354.9 123c1.1 0 2.2-0.4 3-1.2l13.5-13.5c0.8-0.8 1.2-1.8 1.2-3 0-1.1-0.4-2.2-1.2-3-1.6-1.6-4.3-1.6-5.9 0L352 115.8c-1.6 1.6-1.6 4.3 0 5.9 0.7 0.8 1.8 1.3 2.9 1.3zM329.8 137.9l-13.5 13.5c-0.8 0.8-1.2 1.9-1.2 3s0.4 2.2 1.2 3c0.8 0.8 1.8 1.2 3 1.2 1.1 0 2.2-0.4 3-1.2l13.5-13.5c1.6-1.6 1.6-4.3 0-5.9-1.6-1.7-4.4-1.7-6-0.1zM332.4 129.8c0-2.3-1.9-4.2-4.2-4.2h-19.1c-2.3 0-4.2 1.9-4.2 4.2 0 2.3 1.9 4.2 4.2 4.2h19.1c2.4 0 4.2-1.9 4.2-4.2zM378.5 125.6h-19.1c-2.3 0-4.2 1.9-4.2 4.2 0 2.3 1.9 4.2 4.2 4.2h19.1c2.3 0 4.2-1.9 4.2-4.2 0-2.3-1.9-4.2-4.2-4.2zM343.9 90.9c-2.3 0-4.2 1.9-4.2 4.2v19.1c0 2.3 1.9 4.2 4.2 4.2s4.2-1.9 4.2-4.2V95.1c0-2.3-1.9-4.2-4.2-4.2zM343.9 141.2c-2.3 0-4.2 1.9-4.2 4.2v19c0 2.3 1.9 4.2 4.2 4.2s4.2-1.9 4.2-4.2v-19c0-2.3-1.9-4.2-4.2-4.2z" fill="#FAEE00" p-id="9028"></path><path d="M948.1 892.8H921c-6.3 0-11.4-5.1-11.4-11.4S914.8 870 921 870h27.1c6.3 0 11.4 5.1 11.4 11.4s-5.1 11.4-11.4 11.4zM110.5 892.8H75.9c-6.3 0-11.4-5.1-11.4-11.4S69.6 870 75.9 870h34.7c6.3 0 11.4 5.1 11.4 11.4s-5.2 11.4-11.5 11.4z" fill="#3E3A39" p-id="9029"></path><path d="M877.6 892.8H146.4c-6.3 0-11.4-5.1-11.4-11.4s5.1-11.4 11.4-11.4h731.2c6.3 0 11.4 5.1 11.4 11.4s-5.1 11.4-11.4 11.4z" fill="#3E3A39" p-id="9030"></path><path d="M716.3 778.4m-143.3 0a143.3 143.3 0 1 0 286.6 0 143.3 143.3 0 1 0-286.6 0Z" fill="#FFFFFF" p-id="9031"></path><path d="M709.6 933.1c-93.1 0-168.9-75.8-168.9-168.9 0-93.1 75.8-168.9 168.9-168.9S878.5 671 878.5 764.1c0 93.2-75.7 169-168.9 169z m0-315.1c-80.6 0-146.2 65.6-146.2 146.2S629 910.4 709.6 910.4s146.2-65.6 146.2-146.2c0-80.7-65.6-146.2-146.2-146.2z" fill="#3E3A39" p-id="9032"></path><path d="M697.8 845.9c-2.8 0-5.5-1-7.6-2.9l-73.1-65.6c-4.7-4.2-5.1-11.4-0.9-16.1 4.2-4.7 11.4-5.1 16.1-0.9l63.9 57.4 87.3-114.2c3.8-5 11-5.9 15.9-2.1 5 3.8 5.9 11 2.1 15.9l-94.8 123.9c-1.9 2.5-4.8 4.1-8 4.4-0.2 0.2-0.5 0.2-0.9 0.2z" fill="#3E3A39" p-id="9033"></path></svg>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="layui-col-xs6 layui-col-md3">
		<div class="layui-card top-panel">
			<div class="layui-card-header">整租域名数量</div>
			<div class="layui-card-body">
				<div class="layui-row layui-col-space5">
					<div class="layui-col-xs8 layui-col-md8 top-panel-number" style="color: #28333E;" id="yhs">
						<?php echo $shop;?>
					</div>
					<div class="layui-col-xs4 layui-col-md4 top-panel-tips">
                        <svg t="1765348315626" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="5109" width="200" height="200"><path d="M60.085936 963.870552a205.78953 205.78953 0 0 1 0-290.639318L206.68538 526.5678a54.966793 54.966793 0 0 1 77.618999 77.746977l-146.471466 146.215509a95.983923 95.983923 0 0 0 135.46531 135.529299l266.707326-266.195412a95.983923 95.983923 0 0 0 0-135.529299 54.774825 54.774825 0 0 1 77.235063-77.746977 205.085648 205.085648 0 0 1 0 290.639317l-266.195412 266.643338a206.365434 206.365434 0 0 1-290.959264 0z m346.56595-346.62994a205.149637 205.149637 0 0 1 0-290.639318l266.195412-266.195412a205.597562 205.597562 0 0 1 290.959264 290.639318l-146.471466 146.663434a55.030782 55.030782 0 0 1-77.746977-77.746978l146.599445-146.663433a95.983923 95.983923 0 0 0-135.593289-135.529299L483.886949 404.412261a95.983923 95.983923 0 0 0 0 135.529299 54.006954 54.006954 0 0 1 0 77.299052 53.559029 53.559029 0 0 1-77.235063 0z" fill="#1684F6" p-id="5110"></path></svg>					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="layui-row layui-col-space15">
    <!-- 左侧：图表区域（占2/3） -->
    <div class="layui-col-md8">
        <div class="layui-card">
            <div class="layui-card-header">
                <i class="layui-icon layui-icon-chart"></i> 支付订单统计
            </div>
            <div class="layui-card-body">
                <div id="echarts-records" style="height:420px;"></div>
            </div>
        </div>
		<div class="layui-card">
            <div class="layui-card-header">
                <i class="layui-icon layui-icon-tips"></i> 安全提示
            </div>
            <div class="layui-card-body">
                <div class="author-message">
					<?php 
					if(empty($conf['ip_plugin'])){
						echo '<p class="highlight">当前未配置IP查询插件，请至应用商城下载后IP查询配置中启用</p>';
					}
					if($conf['admin_pwd']=='123456'){
						echo '<p class="highlight">当前密码为默认弱密码，请尽快修改</p>';
					}
					if($conf['reg_off'] == 0 ){
						echo '<p class="highlight">当前系统已禁止注册新用户</p>';
					}
					?>
                </div>
            </div>
        </div>
    </div>
    <div class="layui-col-md4">
        <!-- 系统信息卡片 -->
        <div class="layui-card">
            <div class="layui-card-header">
                <i class="layui-icon layui-icon-set"></i> 系统信息
            </div>
            <div class="layui-card-body">
                <ul class="system-info">
                    <li>
                        <span class="info-label">当前版本</span>
                        <span class="info-value version">v<?php echo $auth['app_version'] ?? '1.0'; ?></span>
                    </li>
                    <li>
                        <span class="info-label">基于框架UI</span>
                        <span class="info-value">PearAdmin + LayUI</span>
                    </li>
                    <li>
                        <span class="info-label">程序名称</span>
                        <span class="info-value">幻影二级域名分发系统PHP版本</span>
                    </li>
                    <li>
                        <span class="info-label">主要特色</span>
                        <span class="info-value">多云解析 / 二级分发 / 整租分发 / 安装简单 / 插件化 / 模板化</span>
                    </li>
                    <li>
                        <span class="info-label">支持类型</span>
                        <span class="info-value">腾讯云 / 阿里云 / 百度云 / 火山引擎 / 西部数码 / DNSLA / 华为云 / cloudflare / 幻影DNS / 迅风DNS / 彩虹聚合DNS / 派小星DNS</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- 作者寄语卡片 -->
        <div class="layui-card">
            <div class="layui-card-header">
                <i class="layui-icon layui-icon-tips"></i> 作者寄语
            </div>
            <div class="layui-card-body">
                <div class="author-message">
                    <p>当前程序为新发布状态，BUG肯定会有的，如遇到请在关于系统页面进入博客反馈！</p>
                    <p class="highlight">目前所有功能已经全部进行测试，正常使用！</p>
                </div>
            </div>
        </div>
        
        <!-- 舔狗日记卡片 -->
        <div class="layui-card">
            <div class="layui-card-header">
                <i class="layui-icon layui-icon-heart"></i> 每日一句
            </div>
            <div class="layui-card-body">
                <div class="daily-quote">
                    <div class="quote-icon">💬</div>
                    <div class="quote-content">
                        <?php 
                        $tiangou = json_decode(@file_get_contents('https://api.suyanw.cn/api/tiangou.php?type=json'), true);
                        echo $tiangou['text'] ?? '今天的努力，是为了明天更好的自己。加油！';
                        ?>
                    </div>
                    <div class="quote-footer">— 每日分享</div>
                </div>
            </div>
        </div>

    
<style>
/* 自定义样式 */
.system-info {
    margin: 0;
    padding: 0;
}
.system-info li {
    display: flex;
    justify-content: space-between;
    padding: 12px 0;
    border-bottom: 1px solid #f6f6f6;
}
.system-info li:last-child {
    border-bottom: none;
}
.info-label {
    color: #666;
    font-weight: normal;
}
.info-value {
    color: #333;
    font-weight: 500;
}
.info-value.version {
    color: #5FB878;
    font-weight: bold;
}
.info-value.features {
    color: #FF5722;
}

.author-message {
    line-height: 1.8;
    color: #666;
}
.author-message .highlight {
    color: #FF5722;
    font-weight: 500;
    margin-top: 10px;
}

.daily-quote {
    padding: 15px;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-radius: 8px;
    border-left: 4px solid #5FB878;
}
.quote-icon {
    font-size: 24px;
    margin-bottom: 10px;
}
.quote-content {
    font-size: 15px;
    line-height: 1.6;
    color: #333;
    margin-bottom: 10px;
    font-style: italic;
}
.quote-footer {
    text-align: right;
    color: #999;
    font-size: 12px;
}

/* 卡片悬停效果 */
.layui-card {
    transition: all 0.3s ease;
    border-radius: 8px;
    overflow: hidden;
}
.layui-card:hover {
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    transform: translateY(-2px);
}

.layui-card-header {
    font-weight: 600;
    color: #333;
    border-bottom: 1px solid #f0f0f0;
}
</style>
    </div>
</div>
<?php include 'foot.php';?>
</body>
</html>
<script>
    layui.use(['jquery', 'layer', 'form', 'echarts', 'element', 'count'], function() {
        let $ = layui.jquery;
        let layer = layui.layer;
        let form = layui.form;
        let echarts = layui.echarts;
        let element = layui.element;
        let count = layui.count;
		let echartsRecords = echarts.init(document.getElementById('echarts-records'), 'walden');
			$.get('./ajax.php?act=jiluMoney', function(data) {
				// 提取日期
				let dates = data.data.map(item => item[`date${data.data.indexOf(item)}`]);
				
				// 提取金额（保持为数字类型）
				let money = data.data.map(item => parseFloat(item[`money${data.data.indexOf(item)}`]));
				
				echartsRecords.setOption({
					xAxis: {
						type: 'category',
						data: dates,
						splitLine: false
					},
					yAxis: {
						type: 'value',
						splitLine: false
					},
					grid: {
						x: 50, y: 50, x2: 50, y2: 50
					},
					series: [{
						data: money, // 使用数字类型的金额数据
						type: 'bar',
						showBackground: true,
						backgroundStyle: {
							color: 'rgba(180, 180, 180, 0.2)'
						},
						itemStyle: {
							color: '#16baaa'
						},
						label: {
							show: true, // 显示柱状图顶部的标签
							position: 'top', // 标签位置在柱子顶部
							formatter: (params) => `￥${params.value.toFixed(2)}` // 格式化标签内容
						}
					}],
					tooltip: {
						trigger: 'axis',
						axisPointer: { type: 'shadow' },
						formatter: (params) => {
							// 格式化 tooltip 内容
							let date = params[0].name; // 获取日期
							let value = params[0].value; // 获取金额
							return `${date}<br/>￥${value.toFixed(2)}`; // 显示日期和金额
						}
					}
				});
			}, 'json');
        
        setInterval(() => echartsRecords.resize(), 500);
        window.onresize = () => echartsRecords.resize();
 });
</script>