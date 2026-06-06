<?php
include("../includes/common.php");
$title='代理首页';
include './head.php';
$record=$DB->getColumn("SELECT count(*) FROM pre_record where user='{$user_name}'" );
$domain=$DB->getColumn("SELECT count(*) FROM pre_url");
$stats = get_user_sign_stats($DB, $user_id);
?>
<link rel="stylesheet" href="/assets/admin/css/other/console1.css" />
<link rel="stylesheet" href="/assets/admin/css/other/console2.css" />
<link rel="stylesheet" href="/assets/admin/css/other/person.css" />
<body class="pear-container">
<div class="layui-row layui-col-space15">
    <!-- 左 -->
    <div class="layui-col-md3">
		<div class="layui-card">
			<div class="layui-card-body" style="padding: 25px;">
				<div class="text-center layui-text">
					<div class="user-info-head" id="userInfoHead">
						<img src="https://q4.qlogo.cn/headimg_dl?dst_uin=<?php echo $user_qq; ?>&amp;spec=100" width="115px" height="115px" alt="">
					</div>
					<h2 style="padding-top: 20px;font-size: 20px;">UID: <font color="#17C19D"><?php echo $user_id; ?></font></h2>
					<p style="padding-top: 8px;margin-top: 10px;font-size: 13.5px;">China ， 中国</p>
				</div>
				<div class="layui-text" style="padding-top: 30px;">
                    <table class="layui-table">
                      <tbody>
                        <tr>
                          <td>账户余额：</td>
                          <td><span class="layui-badge layui-badge-red">￥ <?php echo $user_rmb; ?></span></td>
                        </tr>
                        <tr>
                          <td>我的等级：</td>
                          <td><?php if(!empty($user_vip)){ echo '<span class="layui-badge layui-badge-blue">'.$user_vip.'</span>';}else{ echo '<span class="layui-badge layui-badge-gray">普通用户</span>'; } ?></td>
                        </tr>
                      </tbody>
                    </table>
                </div>

                <?php if($conf['qiandao'] == 1){ ?>
                     <!-- 签到 -->
                    <div class="sign-module" id="signModule" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 10px; padding: 20px; color: white; margin: 20px 0;">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <div>
                                <h3 style="margin: 0; font-size: 18px;">每日签到</h3>
                                <p style="margin: 5px 0 0 0; font-size: 12px; opacity: 0.9;">签到获得随机金额（<?=$conf['qaindao_mix']?>-<?=$conf['qaindao_max']?>元）</p>
                            </div>
                            
                            <?php if ($stats['today_signed']): ?>
                                <div id="todaySignedInfo" style="background: rgba(255,255,255,0.2); padding: 8px 15px; border-radius: 20px; font-size: 14px;">
                                    <span>今日已签到</span>
                                    <span style="margin-left: 10px; font-weight: bold;">+<?php echo $stats['today_points']; ?>元</span>
                                </div>
                            <?php else: ?>
                                <div id="todaySignedInfo" style="display: none;"></div>
                            <?php endif; ?>
                        </div>
                        
                        <div style="text-align: center; margin: 30px 0;">
                            <button id="signBtn" class="sign-btn" 
                                    style="width: 100px; height: 100px; border-radius: 50%; border: 3px solid white; 
                                        background: <?php echo $stats['today_signed'] ? 'rgba(255,255,255,0.2)' : 'transparent'; ?>; 
                                        color: white; font-size: 16px; cursor: <?php echo $stats['today_signed'] ? 'not-allowed' : 'pointer'; ?>;
                                        transition: all 0.3s;"
                                    <?php echo $stats['today_signed'] ? 'disabled' : ''; ?>>
                                <?php if ($stats['today_signed']): ?>
                                    ✓<br>
                                    <span style="font-size: 12px;">已签到</span>
                                <?php else: ?>
                                    签到<br>
                                    <span style="font-size: 12px;">点击签到</span>
                                <?php endif; ?>
                            </button>
                        </div>
                        
                        <div style="display: flex; justify-content: space-around; text-align: center; border-top: 1px solid rgba(255,255,255,0.2); padding-top: 15px;">
                            <div>
                                <div id="monthDays" style="font-size: 20px; font-weight: bold;"><?php echo $stats['month_days']; ?></div>
                                <div style="font-size: 12px; opacity: 0.9;">本月签到</div>
                            </div>
                            <div>
                                <div id="totalDays" style="font-size: 20px; font-weight: bold;"><?php echo $stats['total_days']; ?></div>
                                <div style="font-size: 12px; opacity: 0.9;">总签到</div>
                            </div>
                            <div>
                                <div id="totalPoints" style="font-size: 20px; font-weight: bold;"><?php echo $stats['total_points']; ?></div>
                                <div style="font-size: 12px; opacity: 0.9;">总金额</div>
                            </div>
                        </div>
                    </div>

                    <!-- 签到成功动画效果 -->
                    <div id="signSuccessAnimation" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.7); z-index: 9999; justify-content: center; align-items: center;">
                        <div style="text-align: center; color: white;">
                            <div style="font-size: 60px; margin-bottom: 20px;">🎉</div>
                            <div style="font-size: 24px; font-weight: bold; margin-bottom: 10px;">签到成功！</div>
                            <div id="signPoints" style="font-size: 32px; font-weight: bold; color: #FFD700;"></div>
                        </div>
                    </div>

              <?php  }else{  }?>

               
                   


			</div>

			<div style="height: 45px;border-top: 1px whitesmoke solid;text-align: center;line-height: 45px;font-size: 13.5px;">
				<span>今日事 ，今日毕</span>
			</div>
		</div>
        <div class="layui-card">
            <div class="layui-card-body">
                <fieldset class="layui-elem-field">
                    <div class="layui-field-box">
                        <p class="HuanYing_time">--</p>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>
    <!-- 右 -->
    <div class="layui-col-md9">
        <!-- 快捷方式 -->
        <div class="layui-row layui-col-space15">
        	<div class="layui-col-xs12 layui-col-md6">
        		<div class="layui-card top-panel">
        			<div class="layui-card-header">我的解析数量</div>
        			<div class="layui-card-body">
        				<div class="layui-row layui-col-space5">
        					<div class="layui-col-xs8 layui-col-md8 top-panel-number" style="color: #28333E;" id="api">
        						<?php echo $record;?>
        					</div>
        					<div class="layui-col-xs4 layui-col-md4 top-panel-tips">
        						<svg t="1727405079144" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="42404" width="200" height="200"><path d="M293 108h30.3v59.8H293V108zM323.3 168.2h6.9v52.1h-6.9v-52.1zM285.8 168.2h7.2v52.1h-7.2v-52.1zM293 168.2h30.3v52.1H293v-52.1zM374.2 108h30.3v59.8h-30.3V108zM367 168.2h7.2v52.1H367v-52.1zM404.5 168.2h7.3v52.1h-7.3v-52.1zM374.2 168.2h30.3v52.1h-30.3v-52.1zM456.2 108h30.3v59.8h-30.3V108zM486.5 168.2h7.3v52.1h-7.3v-52.1zM449 168.2h7.2v52.1H449v-52.1zM456.2 168.2h30.3v52.1h-30.3v-52.1zM537.5 108h30.3v59.8h-30.3V108zM567.8 168.2h7.2v52.1h-7.2v-52.1zM530.2 168.2h7.3v52.1h-7.3v-52.1zM537.5 168.2h30.3v52.1h-30.3v-52.1zM619.5 108h30.3v59.8h-30.3V108zM649.8 168.2h7.2v52.1h-7.2v-52.1zM612.2 168.2h7.3v52.1h-7.3v-52.1zM619.5 168.2h30.3v52.1h-30.3v-52.1zM700.7 108H731v59.8h-30.3V108zM731 168.2h7.2v52.1H731v-52.1zM693.8 168.2h6.9v52.1h-6.9v-52.1zM700.7 168.2H731v52.1h-30.3v-52.1zM693.8 856.2h30.3V916h-30.3v-59.8zM686.5 804.1h7.3v52.1h-7.3v-52.1zM724.1 804.1h6.9v52.1h-6.9v-52.1zM693.8 804.1h30.3v52.1h-30.3v-52.1zM612.2 856.2h30.3V916h-30.3v-59.8zM604.5 804.1h7.3v52.1h-7.3v-52.1zM642.1 804.1h7.3v52.1h-7.3v-52.1z" fill="#f8b62d" p-id="42405"></path><path d="M612.2 804.1h30.3v52.1h-30.3v-52.1zM530.2 856.2h31.5V916h-31.5v-59.8zM523.3 804.1h6.9v52.1h-6.9v-52.1zM560.9 804.1h6.9v52.1h-6.9v-52.1z" fill="#f8b62d" p-id="42406"></path><path d="M530.2 804.1h31.5v52.1h-31.5v-52.1zM449 856.2h30.3V916H449v-59.8zM441.7 804.1h7.3v52.1h-7.3v-52.1zM479.3 804.1h7.2v52.1h-7.2v-52.1zM449 804.1h30.3v52.1H449v-52.1zM367 856.2h30.3V916H367v-59.8zM360.5 804.1h6.9v52.1h-6.9v-52.1zM397.3 804.1h7.2v52.1h-7.2v-52.1z" fill="#f8b62d" p-id="42407"></path><path d="M367 804.1h30.3v52.1H367v-52.1zM285.8 856.2h30.3V916h-30.3v-59.8zM278.5 804.1h7.3v52.1h-7.3v-52.1zM316.1 804.1h7.2v52.1h-7.2v-52.1zM285.8 804.1h30.3v52.1h-30.3v-52.1zM857 294.2h59v30.3h-59v-30.3zM805.3 324.5H857v8.1h-51.7v-8.1zM805.3 287.8H857v6.9h-51.7v-6.9z" fill="#f8b62d" p-id="42408"></path><path d="M805.3 294.2H857v30.3h-51.7v-30.3zM857 377.5h59v30.3h-59v-30.3zM805.3 369.4H857v7.3h-51.7v-7.3zM805.3 407.8H857v7.2h-51.7v-7.2zM805.3 377.5H857v30.3h-51.7v-30.3zM857 459.9h59v30.3h-59v-30.3zM805.3 490.6H857v6.9h-51.7v-6.9zM805.3 452.6H857v7.3h-51.7v-7.3z" fill="#f8b62d" p-id="42409"></path><path d="M805.3 459.9H857v30.3h-51.7v-30.3zM857 541.9h59v30.3h-59v-30.3zM805.3 533.8H857v7.3h-51.7v-7.3zM805.3 572.6H857v7.3h-51.7v-7.3zM805.3 541.9H857v30.3h-51.7v-30.3zM857 624.7h59V655h-59v-30.3zM805.3 655H857v7.3h-51.7V655zM805.3 617H857v7.3h-51.7V617zM805.3 624.7H857V655h-51.7v-30.3zM857 705.9h59v30.3h-59v-30.3zM805.3 737H857v7.3h-51.7V737zM805.3 699.9H857v6.8h-51.7v-6.8z" fill="#f8b62d" p-id="42410"></path><path d="M805.3 705.9H857v30.3h-51.7v-30.3zM108 705.9h59v30.3h-59v-30.3zM167 737h51.7v7.3H167V737zM167 699.9h51.7v6.8H167v-6.8z" fill="#f8b62d" p-id="42411"></path><path d="M167 705.9h51.7v30.3H167v-30.3zM108 624.7h59V655h-59v-30.3zM167 617h51.7v7.3H167V617zM167 655h51.7v7.3H167V655zM167 624.7h51.7V655H167v-30.3zM108 541.9h59v30.3h-59v-30.3zM167 572.6h51.7v7.3H167v-7.3zM167 533.8h51.7v7.3H167v-7.3zM167 541.9h51.7v30.3H167v-30.3zM108 459.9h59v30.3h-59v-30.3zM167 452.6h51.7v7.3H167v-7.3zM167 490.6h51.7v6.9H167v-6.9z" fill="#f8b62d" p-id="42412"></path><path d="M167 459.9h51.7v30.3H167v-30.3zM108 377.5h59v30.3h-59v-30.3zM167 369.4h51.7v7.3H167v-7.3zM167 407.8h51.7v7.2H167v-7.2zM167 377.5h51.7v30.3H167v-30.3zM108 294.2h59v30.3h-59v-30.3zM167 324.5h51.7v8.1H167v-8.1zM167 287.8h51.7v6.9H167v-6.9z" fill="#f8b62d" p-id="42413"></path><path d="M167 294.2h51.7v30.3H167v-30.3zM554.8 440.1h-15.4V493h14.9c20.2 0 30.7-8.9 30.7-26.7 0.1-17.3-10-26.2-30.2-26.2zM405.3 441.3h-0.8c-0.4 4.8-1.2 9.3-2.8 13.7l-18.6 57.4h43.2l-18.6-57c-1.1-3.6-2-8.4-2.4-14.1z" fill="#f8b62d" p-id="42414"></path><path d="M732.2 247.4H293.8c-28.7 0-51.7 23.8-51.7 52.1v434.3c0 29.1 23.4 52.1 51.7 52.1h438.3c28.7 0 51.7-23.8 51.7-52.1V299.5c0.1-29.1-23.3-52.1-51.6-52.1zM447 577l-12.1-37.6h-59.4L363.3 577h-37.6l59.8-164h40.8l58.2 164H447z m155.9-71.9c-12.1 10.1-27.5 14.9-45.7 14.5h-17.8V577h-34.7V413h55.8c40.4 0 60.6 17.4 60.6 51.7 0 17-6.1 30.3-18.2 40.4z m78 71.9h-34.7V413h34.7v164z" fill="#f8b62d" p-id="42415"></path></svg>
        					</div>
        				</div>
        			</div>
        		</div>
        	</div>
        	<div class="layui-col-xs12 layui-col-md6">
        		<div class="layui-card top-panel">
        			<div class="layui-card-header">平台域名数量</div>
        			<div class="layui-card-body">
        				<div class="layui-row layui-col-space5">
        					<div class="layui-col-xs8 layui-col-md8 top-panel-number" style="color: #28333E;" id="apime">
        						<?php echo $domain;?>
        					</div>
        					<div class="layui-col-xs4 layui-col-md4 top-panel-tips">
        						<svg t="1727369805621" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="9014" width="200" height="200"><path d="M525.5 596.2c-156.1 0-282.6 127.7-282.6 285.2h565.2c0-157.5-126.5-285.2-282.6-285.2z" fill="#FCEE21" p-id="9015"></path><path d="M491.2 892.8H187.3c-6.3 0-11.4-5.1-11.4-11.4 0-142.9 91.5-267.7 227.8-310.5 6-1.9 12.4 1.4 14.3 7.4 1.9 6-1.5 12.4-7.4 14.3C287.4 631.2 203.5 741.9 198.8 870h292.3c6.3 0 11.4 5.1 11.4 11.4s-5.1 11.4-11.3 11.4z" fill="#3E3A39" p-id="9016"></path><path d="M561.7 272.8c36.5 30.5 59.7 76.4 59.7 127.7 0 92-74.5 166.5-166.5 166.5-19.6 0-38.5-3.4-55.9-9.7 28.9 24.2 66.1 38.8 106.8 38.8 92 0 166.5-74.5 166.5-166.5-0.1-72.3-46.2-133.8-110.6-156.8z" fill="#F8B62D" p-id="9017"></path><path d="M621.4 400.6c0-51.3-23.2-97.2-59.7-127.7-17.5-6.2-36.3-9.7-55.9-9.7-92 0-166.5 74.5-166.5 166.5 0 51.3 23.2 97.2 59.7 127.7 17.5 6.2 36.3 9.7 55.9 9.7 91.9 0 166.5-74.6 166.5-166.5z" fill="#FCEE21" p-id="9018"></path><path d="M491.2 607.5c-106.1 0-192.4-86.3-192.4-192.4 0-25.4 4.9-50.1 14.5-73.4 2.4-5.8 9.1-8.6 14.9-6.2 5.8 2.4 8.6 9.1 6.2 14.9-8.5 20.5-12.8 42.3-12.8 64.7 0 93.6 76.1 169.7 169.7 169.7S661 508.7 661 415.1s-76.1-169.7-169.7-169.7c-37 0-72.1 11.7-101.6 33.8-5 3.8-12.2 2.7-15.9-2.3-3.8-5-2.7-12.2 2.3-15.9 33.5-25.1 73.3-38.3 115.2-38.3 106.1 0 192.4 86.3 192.4 192.4-0.1 106.1-86.4 192.4-192.5 192.4z" fill="#3E3A39" p-id="9019"></path><path d="M340.1 320c-1.9 0-3.7-0.5-5.5-1.4-5.5-3-7.5-9.9-4.5-15.4 3.2-5.8 7.7-11 13-15 5-3.8 12.2-2.7 15.9 2.3 3.8 5 2.7 12.2-2.3 15.9-2.8 2.1-5.1 4.8-6.7 7.8-2 3.7-5.9 5.8-9.9 5.8z" fill="#3E3A39" p-id="9020"></path><path d="M198.5 509.1c-17 0-30.8-13.8-30.8-30.8s13.8-30.8 30.8-30.8 30.8 13.8 30.8 30.8c0 16.9-13.8 30.8-30.8 30.8z m0-46.5c-8.6 0-15.7 7-15.7 15.7 0 8.6 7 15.7 15.7 15.7 8.6 0 15.7-7 15.7-15.7-0.1-8.7-7.1-15.7-15.7-15.7z" fill="#47B7F8" p-id="9021"></path><path d="M174.3 326.8h-13.5v-13.5c0-3.6-2.9-6.5-6.5-6.5s-6.5 2.9-6.5 6.5v13.5h-13.5c-3.6 0-6.5 2.9-6.5 6.5s2.9 6.5 6.5 6.5h13.5v13.5c0 3.6 2.9 6.5 6.5 6.5s6.5-2.9 6.5-6.5v-13.5h13.5c3.6 0 6.5-2.9 6.5-6.5s-2.9-6.5-6.5-6.5zM915.5 327.9H902v-13.5c0-3.6-2.9-6.5-6.5-6.5s-6.5 2.9-6.5 6.5v13.5h-13.5c-3.6 0-6.5 2.9-6.5 6.5s2.9 6.5 6.5 6.5H889v13.5c0 3.6 2.9 6.5 6.5 6.5s6.5-2.9 6.5-6.5v-13.5h13.5c3.6 0 6.5-2.9 6.5-6.5s-2.9-6.5-6.5-6.5z" fill="#F7E42F" p-id="9022"></path><path d="M874.7 463.4H859v-15.7c0-4.2-3.4-7.6-7.6-7.6s-7.6 3.4-7.6 7.6v15.7h-15.7c-4.2 0-7.6 3.4-7.6 7.6s3.4 7.6 7.6 7.6h15.7v15.7c0 4.2 3.4 7.6 7.6 7.6s7.6-3.4 7.6-7.6v-15.7h15.7c4.2 0 7.6-3.4 7.6-7.6s-3.4-7.6-7.6-7.6z" fill="#F8B62D" p-id="9023"></path><path d="M277 258.2m-11.4 0a11.4 11.4 0 1 0 22.8 0 11.4 11.4 0 1 0-22.8 0Z" fill="#F8B62D" p-id="9024"></path><path d="M785.3 318.2m-15.2 0a15.2 15.2 0 1 0 30.4 0 15.2 15.2 0 1 0-30.4 0Z" fill="#F8B62D" p-id="9025"></path><path d="M689.2 168.4m-15.2 0a15.2 15.2 0 1 0 30.4 0 15.2 15.2 0 1 0-30.4 0Z" fill="#F7E42F" p-id="9026"></path><path d="M503.9 175.3c-17 0-30.8-13.8-30.8-30.8s13.8-30.8 30.8-30.8 30.8 13.8 30.8 30.8c0.1 17-13.8 30.8-30.8 30.8z m0-46.5c-8.6 0-15.7 7-15.7 15.7 0 8.6 7 15.7 15.7 15.7s15.7-7 15.7-15.7-7-15.7-15.7-15.7z" fill="#F8B62D" p-id="9027"></path><path d="M322.3 102.3c-1.6-1.6-4.3-1.6-5.9 0-0.8 0.8-1.2 1.9-1.2 3s0.4 2.2 1.2 3l13.5 13.5c0.8 0.8 1.8 1.2 3 1.2 1.1 0 2.2-0.4 3-1.2 1.6-1.6 1.6-4.3 0-5.9l-13.6-13.6zM357.9 137.9c-0.8-0.8-1.8-1.2-3-1.2-1.1 0-2.2 0.4-3 1.2-1.6 1.6-1.6 4.3 0 5.9l13.5 13.5c0.8 0.8 1.8 1.2 3 1.2 1.1 0 2.2-0.4 3-1.2 0.8-0.8 1.2-1.8 1.2-3 0-1.1-0.4-2.2-1.2-3l-13.5-13.4zM354.9 123c1.1 0 2.2-0.4 3-1.2l13.5-13.5c0.8-0.8 1.2-1.8 1.2-3 0-1.1-0.4-2.2-1.2-3-1.6-1.6-4.3-1.6-5.9 0L352 115.8c-1.6 1.6-1.6 4.3 0 5.9 0.7 0.8 1.8 1.3 2.9 1.3zM329.8 137.9l-13.5 13.5c-0.8 0.8-1.2 1.9-1.2 3s0.4 2.2 1.2 3c0.8 0.8 1.8 1.2 3 1.2 1.1 0 2.2-0.4 3-1.2l13.5-13.5c1.6-1.6 1.6-4.3 0-5.9-1.6-1.7-4.4-1.7-6-0.1zM332.4 129.8c0-2.3-1.9-4.2-4.2-4.2h-19.1c-2.3 0-4.2 1.9-4.2 4.2 0 2.3 1.9 4.2 4.2 4.2h19.1c2.4 0 4.2-1.9 4.2-4.2zM378.5 125.6h-19.1c-2.3 0-4.2 1.9-4.2 4.2 0 2.3 1.9 4.2 4.2 4.2h19.1c2.3 0 4.2-1.9 4.2-4.2 0-2.3-1.9-4.2-4.2-4.2zM343.9 90.9c-2.3 0-4.2 1.9-4.2 4.2v19.1c0 2.3 1.9 4.2 4.2 4.2s4.2-1.9 4.2-4.2V95.1c0-2.3-1.9-4.2-4.2-4.2zM343.9 141.2c-2.3 0-4.2 1.9-4.2 4.2v19c0 2.3 1.9 4.2 4.2 4.2s4.2-1.9 4.2-4.2v-19c0-2.3-1.9-4.2-4.2-4.2z" fill="#FAEE00" p-id="9028"></path><path d="M948.1 892.8H921c-6.3 0-11.4-5.1-11.4-11.4S914.8 870 921 870h27.1c6.3 0 11.4 5.1 11.4 11.4s-5.1 11.4-11.4 11.4zM110.5 892.8H75.9c-6.3 0-11.4-5.1-11.4-11.4S69.6 870 75.9 870h34.7c6.3 0 11.4 5.1 11.4 11.4s-5.2 11.4-11.5 11.4z" fill="#3E3A39" p-id="9029"></path><path d="M877.6 892.8H146.4c-6.3 0-11.4-5.1-11.4-11.4s5.1-11.4 11.4-11.4h731.2c6.3 0 11.4 5.1 11.4 11.4s-5.1 11.4-11.4 11.4z" fill="#3E3A39" p-id="9030"></path><path d="M716.3 778.4m-143.3 0a143.3 143.3 0 1 0 286.6 0 143.3 143.3 0 1 0-286.6 0Z" fill="#FFFFFF" p-id="9031"></path><path d="M709.6 933.1c-93.1 0-168.9-75.8-168.9-168.9 0-93.1 75.8-168.9 168.9-168.9S878.5 671 878.5 764.1c0 93.2-75.7 169-168.9 169z m0-315.1c-80.6 0-146.2 65.6-146.2 146.2S629 910.4 709.6 910.4s146.2-65.6 146.2-146.2c0-80.7-65.6-146.2-146.2-146.2z" fill="#3E3A39" p-id="9032"></path><path d="M697.8 845.9c-2.8 0-5.5-1-7.6-2.9l-73.1-65.6c-4.7-4.2-5.1-11.4-0.9-16.1 4.2-4.7 11.4-5.1 16.1-0.9l63.9 57.4 87.3-114.2c3.8-5 11-5.9 15.9-2.1 5 3.8 5.9 11 2.1 15.9l-94.8 123.9c-1.9 2.5-4.8 4.1-8 4.4-0.2 0.2-0.5 0.2-0.9 0.2z" fill="#3E3A39" p-id="9033"></path></svg>
        					</div>
        				</div>
        			</div>
        		</div>
        	</div>
        </div>
        <div class="layui-row layui-col-space15">
        <?php
            // 直接查询数据库显示公告
                $gonggao_sql = "SELECT * FROM pre_gonggao WHERE type = 0 ORDER BY date DESC LIMIT 10";
                $gonggao_list = $DB->getAll($gonggao_sql);
                if(!empty($gonggao_list)){ 
        ?>
            <div class="layui-col-md12 layui-col-sm6">
                <div class="layui-card">
                    <div class="layui-card-header">用户公告</div>
                    <div class="layui-card-body">
    					<div class="layui-tab layui-tab-brief" lay-filter="docDemoTabBrief">
    						<div class="layui-tab-content">
    							<div class="layui-tab-item layui-show">
                                  <?php foreach($gonggao_list as $res){ ?>
        								<div class="layui-row layui-col-space10" style="margin: 15px;">
        									<div class="layui-col-md1">
        										<img src="/assets/admin/images/act.jpg" style="width: 100%;height: 100%;border-radius: 5px;" />
        									</div>
        									<div class="layui-col-md11" style="height: 80px;">
        										<a href="<?php echo $res['domain'] ?>"><div class="title" style="color: <?php echo $res['color'];?>;"><?php echo $res['title']?></div></a>
        										<div class="content">
        											<a class="pear-btn pear-btn-xs" onclick="layer.open({title: '公告内容：<?php echo $res['title']?>', btn: ['已阅'], area: ['90%', '90%'], shade: 0.6, shadeClose: true, maxmin: true, anim: 0, closeBtn: 0, content: `<?php echo htmlspecialchars($res['content'], ENT_QUOTES, 'UTF-8');?>`});">点击查看公告内容</a>
        										</div>
        										<div class="comment"><?php echo $res['date']?></div>
        									</div>
        								</div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</div>

<!-- js部分 -->
<?php include 'foot.php';?>
<script type="text/javascript">
    layui.use(['jquery', 'layer', 'element', 'form', 'table', 'count'], function () {
        let $ = layui.jquery;
        let layer = layui.layer;
        let element = layui.element;
        let form = layui.form;
        let table = layui.table;
        let count = layui.count;


   // 签到
        $(document).ready(function() {
            if (typeof toast === 'undefined') {
                // 简易toast替代方案
                window.toast = {
                    success: function(options) {
                        layer.msg(options.message, {icon: 1, time: options.duration || 2000});
                    },
                    error: function(options) {
                        layer.msg(options.message, {icon: 2, time: options.duration || 2000});
                    }
                };
            }
            
            // 签到按钮点击事件
            $('#signBtn').on('click', function() {
                if ($(this).prop('disabled')) {
                    return false;
                }
                
                var loading = layer.msg('正在签到中...', { icon: 16, shade: 0.3, time: 0 });
                
                $.ajax({
                    type: "POST",
                    url: "./ajax.php?act=userinfo&mod=sign",
                    dataType: "json",
                    success: function(response) {
                        layer.close(loading);
                        var code = parseInt(response.code);
                        
                        if (code === 0) {
                            var amount = extractAmountFromMsg(response.msg);
                            
                            showSignAnimation(amount, response.msg || '签到成功！');
                            
                            updateSignStatus(response);
                            
                            // 显示成功提示
                            setTimeout(function() {
                                // toast.success({ 
                                //     message: response.msg,
                                //     duration: 2000
                                // });
                            }, 1500);
                        } else {
                            toast.error({ 
                                message: response.msg || '签到失败',
                                duration: 2000
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        layer.close(loading);
                        
                        var errorMsg = '签到请求失败，请稍后重试';
                        if (xhr.status === 403) {
                            errorMsg = '今日已签到';
                        }
                        
                        toast.error({ 
                            message: errorMsg,
                            duration: 2000
                        });
                        
                        console.error('签到请求失败:', error);
                    }
                });
            });
            
            // 从消息中提取金额（例如：从"签到成功！获得 10.74 元"提取10.74）
            function extractAmountFromMsg(msg) {
                if (!msg) return 0;
                
                // 匹配数字（包括小数）
                var matches = msg.match(/(\d+(\.\d+)?)/g);
                if (matches && matches.length > 0) {
                    return parseFloat(matches[0]);
                }
                return 0;
            }
            
            // 显示签到成功动画
            function showSignAnimation(amount, message) {
                var animation = $('#signSuccessAnimation');
                var pointsElement = $('#signPoints');
                
                // 显示金额，如果没有提取到金额则显示消息
                if (amount > 0) {
                    pointsElement.text('+' + amount.toFixed(2) + '元');
                } else {
                    // 如果没有金额，显示消息或默认文本
                    pointsElement.text(message || '签到成功！');
                }
                
                animation.fadeIn(300);
                
                // 3秒后自动隐藏
                setTimeout(function() {
                    animation.fadeOut(300);
                }, 3000);
                
                // 点击任意位置关闭
                animation.on('click', function() {
                    $(this).fadeOut(300);
                });
            }
            
            // 更新签到状态
            function updateSignStatus(data) {
                // 禁用签到按钮
                $('#signBtn')
                    .css('background', 'rgba(255,255,255,0.2)')
                    .css('cursor', 'not-allowed')
                    .prop('disabled', true)
                    .html('✓<br><span style="font-size: 12px;">已签到</span>');
                
                // 从消息中提取金额
                var amount = extractAmountFromMsg(data.msg);
                var displayText = amount > 0 ? '+' + amount.toFixed(2) + '元' : data.msg;
                
                // 显示今日已签到信息
                var todayInfo = $('#todaySignedInfo');
                todayInfo.html('<span>今日已签到</span><span style="margin-left: 10px; font-weight: bold;">' + displayText + '</span>')
                    .css('display', 'block')
                    .css('background', 'rgba(255,255,255,0.2)')
                    .css('padding', '8px 15px')
                    .css('border-radius', '20px')
                    .css('font-size', '14px');
                
                // 注意：你的后端可能没有返回stats数据，所以这部分可能需要调整
                // 如果后端不返回统计数据，可以发起另一个请求获取统计数据
                if (data.stats) {
                    $('#monthDays').text(data.stats.month_days || 0);
                    $('#totalDays').text(data.stats.total_days || 0);
                    $('#totalPoints').text(data.stats.total_points || 0);
                } else {
                    // 如果没有stats数据，可以请求获取统计数据
                    // loadStatsData();
                }
            }
            
            // 可选：加载统计数据
            function loadStatsData() {
                $.ajax({
                    type: "POST",
                    url: "./ajax.php?act=userinfo&mod=stats",
                    dataType: "json",
                    success: function(data) {
                        if (data.code == 0) {
                            $('#monthDays').text(data.month_days || 0);
                            $('#totalDays').text(data.total_days || 0);
                            $('#totalPoints').text(data.total_points || 0);
                            $('#avgPoints').text(data.avg_points || 0);
                        }
                    }
                });
            }
            
            // 如果用户已经签到，添加脉冲动画效果
            if ($('#signBtn').prop('disabled')) {
                setInterval(function() {
                    $('#signBtn').animate({
                        'border-color': 'rgba(255,255,255,0.5)'
                    }, 500).animate({
                        'border-color': 'white'
                    }, 500);
                }, 3000);
            }
            
            // 页面加载时自动获取统计数据（如果需要）
            // loadStatsData();
        });

    
        
        showDateText = function () {
            let myDate = new Date;
            let year = myDate.getFullYear(); //获取当前年
            let mon = myDate.getMonth() + 1; //获取当前月
            let date = myDate.getDate(); //获取当前日
            let h = myDate.getHours();//获取当前小时数(0-23)
            let m = myDate.getMinutes();//获取当前分钟数(0-59)
            let s = myDate.getSeconds();//获取当前秒
            let week = myDate.getDay();
            let weeks = ["星期日", "星期一", "星期二", "星期三", "星期四", "星期五", "星期六"];
            $(".HuanYing_time").text(year + "年" + mon + "月" + date + "日 " + h + "时" + m + "分" + s + "秒 " + weeks[week]);
        };
        showDateText();
        setInterval(showDateText, 1000);
        
        
    });
</script>
</body>
</html>