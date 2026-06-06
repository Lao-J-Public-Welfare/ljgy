<?php
/**
 * 系统管理
**/
include '../includes/common.php';
$title='系统管理';
include 'head.php';
$mod=isset($_GET['mod'])?$_GET["mod"]:NULL;
if($mod=="site"){
?>

<div class="layui-card">
    <div class="layui-card-header">网站信息配置</div>
    <div class="layui-card-body">
        <form method="post" id="formAdvForm" class="layui-form" role="form">
            <div class="layui-form-item">
                <div class="layui-inline">
                  <label class="layui-form-label">网站标题</label>
                  <div class="layui-input-inline">
                    <input type="text" name="title" placeholder="网站主要标题" value="<?=$conf['title']?>" class="layui-input">
                  </div>
                  
                </div>
                <div class="layui-inline">
                  <label class="layui-form-label">站长QQ</label>
                  <div class="layui-input-inline">
                    <input type="number" name="qq" placeholder="网站站长QQ号" value="<?=$conf['qq']?>" class="layui-input">
                  </div>
                </div>
                <div class="layui-inline">
                  <label class="layui-form-label">备案信息</label>
                  <div class="layui-input-inline">
                    <input type="text" name="icp" placeholder="网站备案号" value="<?=$conf['icp']?>" class="layui-input">
                  </div>
                </div>
                <div class="layui-inline">
                        <label class="layui-form-label">网站LOGO</label>
                        <div class="layui-input-block">
                            <input type="text" class="layui-input" id="logourl" name="logoimg" value="<?=$conf['logoimg']?>" placeholder="填写logo图片URL，没有请留空" style="padding-right: 80px;" disabled="">
                            <button type="button" class="layui-btn layui-btn-warm" title="查看图片" style="position: absolute;top: 0;right: 0px; cursor: pointer;"><i class="layui-icon layui-icon-picture"></i></button>
                            <button id="upload-logo" type="button" class="layui-btn layui-btn-success upload-logo" title="上传图片" style="position: absolute;top: 0;right: 57px;cursor: pointer;"><i class="layui-icon layui-icon-upload"></i></button>
                        </div>
                    </div>
                <div class="layui-inline">
                        <label class="layui-form-label">ICO站标</label>
                        <div class="layui-input-block">
                            <input type="text" class="layui-input" id="icourl" name="icoimg" value="<?=$conf['icoimg']?>" placeholder="填写站标图片URL，没有请留空" style="padding-right: 80px;" disabled="">
                            <button type="button" class="layui-btn layui-btn-warm" title="查看图片" style="position: absolute;top: 0;right: 0px; cursor: pointer;"><i class="layui-icon layui-icon-picture"></i></button>
                            <button id="upload-ico" type="button" class="layui-btn layui-btn-success upload-ico" title="上传图片" style="position: absolute;top: 0;right: 57px;cursor: pointer;"><i class="layui-icon layui-icon-upload"></i></button>
                        </div>
                    </div>

            </div>
            
            <div class="layui-form-item">
                <label class="layui-form-label">站点关键词</label>
                <div class="layui-input-block">
                    <input class="layui-hide" type="text" id="keywordstags" name="keywords" placeholder="请输入网站关键词" value="<?=$conf['keywords']?>">
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">网站描述</label>
                <div class="layui-input-block">
                    <textarea class="layui-textarea" name="description" placeholder="网站信息描述" rows="5"><?php echo htmlspecialchars($conf['description']); ?></textarea>
                </div>
            </div>

            <div class="layui-form-item">
                <div class="layui-col-md6">
                  <label class="layui-form-label">QQ加群链接</label>
                  <div class="layui-input-block">
                    <input type="text" name="qun" class="layui-input" placeholder="填写你的QQ加群链接" value="<?=$conf['qun']?>">
                  </div>
                </div>
            </div>
            
            <div class="layui-form-item">
                <label class="layui-form-label">邀请返佣</label>
                <div class="layui-input-block">
                    <select name="invite_open" class="layui-input" lay-filter="invite_open">
                        <option <?php echo $conf['invite_open'] == 0 ? 'selected ' : '' ?>value="0">关闭</option>
                        <option <?php echo $conf['invite_open'] == 1 ? 'selected ' : '' ?>value="1">开启</option>
                    </select>
                </div>
            </div>
            <div class="layui-form-item" id="invite_open_off" style="<?php echo $conf['invite_open']!=1?'display:none;':null; ?>">
                <label class="layui-form-label">返佣余额</label>
                <div class="layui-input-block">
                    <input type="number" name="invite_rate" class="layui-input" placeholder="被邀请用户注册账号，给邀请者分成的余额" value="<?=$conf['invite_rate']?>">
                    <div class="layui-word-aux">例如：固定返佣 1 直接填写余额(整数)</div>
                </div>
            </div>
            
            <div class="layui-form-item">
                <div class="layui-col-md6">
                    <label class="layui-form-label">注册赠送余额</label>
                    <div class="layui-input-block">
                        <input type="number" name="reg_m" class="layui-input" placeholder="填写注册自动赠送用户多少余额，不赠送留空即可" value="<?=$conf['reg_m']?>">
                    </div>
                </div>
            </div>
            
            <div class="layui-form-item">
                <label class="layui-form-label">解析页面公告</label>
                <div class="layui-input-block">
                    <input type="text" name="recordgg" class="layui-input" placeholder="填写解析页面顶部公告" value="<?=$conf['recordgg']?>">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">用户注册</label>
                <div class="layui-input-block">
                    <select name="reg_off" class="layui-input" lay-filter="reg_off">
                        <option <?php echo $conf['reg_off'] == 1 ? 'selected ' : '' ?>value="1">开启</option>
                        <option <?php echo $conf['reg_off'] == 0 ? 'selected ' : '' ?>value="0">关闭</option>
                    </select>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">签到功能</label>
                <div class="layui-input-block">
                    <select name="qiandao" class="layui-input" lay-filter="qiandao">
                        <option <?php echo $conf['qiandao'] == 0 ? 'selected ' : '' ?>value="0">关闭</option>
                        <option <?php echo $conf['qiandao'] == 1 ? 'selected ' : '' ?>value="1">开启</option>
                    </select>
                </div>
            </div>
                <div class="layui-inline">
                  <label class="layui-form-label">签到最小金额</label>
                  <div class="layui-input-inline">
                    <input type="number" name="qaindao_mix" placeholder="签到最小金额" value="<?=$conf['qaindao_mix']?>" class="layui-input">
                  </div>
                  
                </div>
                <div class="layui-inline">
                  <label class="layui-form-label">签到最大金额</label>
                  <div class="layui-input-inline">
                    <input type="number" name="qaindao_max" placeholder="签到最大金额" value="<?=$conf['qaindao_max']?>" class="layui-input">
                  </div>
                  
                </div>
            <div class="layui-form-item layui-input-block">
                <button type="reset" id="formreset" class="pear-btn">&emsp;重置&emsp;</button>
                <button class="pear-btn pear-btn-primary" type="button" lay-filter="Submit_btn" lay-submit>&emsp;提交&emsp;</button>
            </div>
        </form>
    </div>
</div>

<?php }elseif($mod=="veridy"){ ?>

<div class="layui-card">
    <div class="layui-card-header">人机验证配置</div>
    <div class="layui-card-body">
        <form method="post" id="formAdvForm" class="layui-form" role="form">
            
            <div class="layui-form-item">
                <label class="layui-form-label">人机验证</label>
                <div class="layui-input-block">
                    <select id="captcha_open" name="captcha_open" class="layui-input" lay-filter="captcha_open">
                        <option <?php echo $conf['captcha_open'] == 0 ? 'selected ' : '' ?>value="0">关闭验证</option>
                        <option <?php echo $conf['captcha_open'] == 1 ? 'selected ' : '' ?>value="1">图形验证</option>
                    </select>
                </div>
            </div>

            <div class="layui-form-item layui-input-block">
                <button type="reset" id="formreset" class="pear-btn">&emsp;重置&emsp;</button>
                <button class="pear-btn pear-btn-primary" type="button" lay-filter="Submit_btn" lay-submit>&emsp;提交&emsp;</button>
            </div>
        </form>
    </div>
</div>
<?php }elseif($mod=="ztrecord"){ ?>

<div class="layui-card">
    <div class="layui-card-header">暂停解析配置</div>
    <div class="layui-card-body">
        <form method="post" id="formAdvForm" class="layui-form" role="form">
            
            <div class="layui-form-item">
                <label class="layui-form-label">解析类型</label>
                <div class="layui-input-block">
                    <select name="type">
                        <option value="A">A记录</option>
                        <option value="CNAME">CNAME记录</option>
                    </select>
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">解析值</label>
                <div class="layui-input-block">
                    <input type="text" name="value" placeholder="解析值" class="layui-input" value="<?=$conf['value']?>">
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">暂停原因</label>
                <div class="layui-input-block">
                    <textarea class="layui-textarea" name="stop_reason" placeholder="请输入暂停原因,分割" rows="5"><?php echo htmlspecialchars($conf['stop_reason']); ?></textarea>
                </div>
            </div>

            <div class="layui-form-item layui-input-block">
                <button type="reset" id="formreset" class="pear-btn">&emsp;重置&emsp;</button>
                <button class="pear-btn pear-btn-primary" type="button" lay-filter="Submit_btn" lay-submit>&emsp;提交&emsp;</button>
            </div>
        </form>
    </div>
</div>

<?php }elseif($mod=="wgjc"){ ?>

<div class="layui-card">
    <div class="layui-card-header">云端违规检测配置</div>
    <div class="layui-card-body">
        <form method="post" id="formAdvForm" class="layui-form" role="form">
            
            

            <div class="layui-form-item">
                <label class="layui-form-label">云端地址：</label>
                <div class="layui-input-block">
                    <input type="text" name="wgjcurl" placeholder="输入https://  /结尾" class="layui-input" value="<?=$conf['wgjcurl']?>">
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">云端秘钥：</label>
                <div class="layui-input-block">
                    <input type="text" name="wgjctoken" placeholder="输入云端违规检测秘钥" class="layui-input" value="<?=$conf['wgjctoken']?>">
                </div>
            </div>


            <div class="layui-form-item">
                            <label class="layui-form-label">云端开启</label>
                            <div class="layui-input-block">
                                <input type="radio" name="wgjctype" value="0" title="关闭" checked>
                                <input type="radio" name="wgjctype" value="1" title="开启">
                            </div>
                        </div>
            

            <div class="layui-form-item layui-input-block">
                <button type="reset" id="formreset" class="pear-btn">&emsp;重置&emsp;</button>
                <button class="pear-btn pear-btn-primary" type="button" lay-filter="Submit_btn" lay-submit>&emsp;提交&emsp;</button>
            </div>
        </form>
    </div>
</div>

<?php }elseif($mod=="cloud"){ ?>

<div class="layui-card">
    <div class="layui-card-header">云端用户账号配置</div>
    <div class="layui-card-body">
        <form method="post" id="formAdvForm" class="layui-form" role="form">
            <div class="layui-form-item">
                <label class="layui-form-label">云端账号</label>
                <div class="layui-input-block">
                    <input type="text" name="cloud_user" class="layui-input" placeholder="幻影Cloud云端的用户账号" value="<?=$conf['cloud_user']?>">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">云端密码</label>
                <div class="layui-input-block">
                    <input type="password" name="cloud_pwd" class="layui-input" placeholder="幻影Cloud云端的用户密码" value="<?=$conf['cloud_pwd']?>">
                </div>
            </div>

            <div class="layui-form-item layui-input-block">
                <button class="pear-btn pear-btn-primary layui-btn-fluid" lay-filter="Submit_btn" lay-submit>保存</button>
            </div>
        </form>
        <fieldset class="layui-elem-field">
            <legend>关于云端</legend>
            <div class="layui-field-box">
                <?php if(!empty($conf['cloud_user']) && !empty($conf['cloud_pwd'])) { ?>
                您已配置完成云端用户账号信息 🔜 <button class="pear-btn pear-btn-xs pear-btn-warming" lay-filter="cloud_lt" lay-submit>点此测试连通性</button><br>
                这里查询您的余额 🔜 <button class="pear-btn pear-btn-xs pear-btn-warming" lay-filter="cloud_yue" lay-submit>点此查询账户余额</button>
                <?php }else{ ?>
                输入你在幻影Cloud云端的用户账号信息
                没有请注册 🔜 <a class="pear-btn pear-btn-xs pear-btn-warming" href="http://cloud.dnsjxz.cn/user/reg.php" target="_blank">点此注册</a>
                <?php } ?>
            </div>
        </fieldset>
    </div>
</div>

<?php }elseif($mod=='pay'){ ?>

<div class="layui-card">
    <div class="layui-card-header">支付配置</div>
    <div class="layui-card-body">
        <form method="post" id="formAdvForm" class="layui-form" role="form">

            <div class="layui-form-item">
                <label class="layui-form-label">支付宝支付</label>
                <div class="layui-input-block">
                    <select class="layui-input" name="alipay_api">
                        <option <?php echo $conf['alipay_api'] == 0 ? 'selected ' : '' ?>value="0">关闭</option>
                        <option <?php echo $conf['alipay_api'] == 1 ? 'selected ' : '' ?>value="1">易支付免签约接口</option>
                       
                    </select>
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">QQ支付</label>
                <div class="layui-input-block">
                    <select class="layui-input" name="qqpay_api">
                        <option <?php echo $conf['qqpay_api'] == 0 ? 'selected ' : '' ?>value="0">关闭</option>
                        <option <?php echo $conf['qqpay_api'] == 1 ? 'selected ' : '' ?>value="1">易支付免签约接口</option>
                    </select>
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">微信支付</label>
                <div class="layui-input-block">
                    <select class="layui-input" name="wxpay_api">
                        <option <?php echo $conf['wxpay_api'] == 0 ? 'selected ' : '' ?>value="0">关闭</option>
                        <option <?php echo $conf['wxpay_api'] == 1 ? 'selected ' : '' ?>value="1">易支付免签约接口</option>
                        
                    </select>
                </div>
            </div>
            <div class="layui-form-item layui-input-block">
                <button type="reset" id="formreset" class="pear-btn">&emsp;重置&emsp;</button>
                <button class="pear-btn pear-btn-primary" type="button" lay-filter="Submit_btn" lay-submit>&emsp;提交&emsp;</button>
            </div>
        </form>
    </div>
</div>

<!--易支付配置-->
<?php if ($conf['alipay_api'] == 1 || $conf['qqpay_api'] == 1 || $conf['wxpay_api'] == 1) {?>

<div class="layui-card">
    <div class="layui-card-header">易支付配置</div>
    <div class="layui-card-body">
        <form method="post" id="formAdvForm" class="layui-form" role="form">

            <div class="layui-form-item">
                <label class="layui-form-label">签名方式</label>
                <div class="layui-input-block">
                    <select class="layui-input" name="epay_v" lay-filter="epay_v">
                        <option <?php echo $conf['epay_v'] == 1 ? 'selected ' : '' ?>value="1">V1接口（MD5签名方式）</option>
                        <option <?php echo $conf['epay_v'] == 2 ? 'selected ' : '' ?>value="2">V2接口（RSA签名方式）</option>
                    </select>
                </div>
            </div>
            
            <div class="layui-form-item">
                <label class="layui-form-label">接口网址</label>
                <div class="layui-input-block">
                    <input type="text" name="epay_url" class="layui-input" value="<?php echo $conf['epay_url'];?>" placeholder="需要加http(s)://和结尾/">
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">商户ID</label>
                <div class="layui-input-block">
                    <input type="text" name="epay_pid" class="layui-input" value="<?php echo $conf['epay_pid'];?>">
                </div>
            </div>
            
            <div class="layui-form-item" id="epay_off_1" style="<?php echo $conf['epay_v']==2?'display:none;':null; ?>">
                <label class="layui-form-label">商户密钥</label>
                <div class="layui-input-block">
                    <input type="text" name="epay_key" class="layui-input" value="<?php echo $conf['epay_key'];?>">
                </div>
            </div>

            <div class="layui-form-item" id="epay_off_2" style="<?php echo $conf['epay_v']==1?'display:none;':null; ?>">
                <label class="layui-form-label">平台公钥(RSA2)</label>
                <div class="layui-input-block">
                    <textarea class="layui-textarea" name="epay_public_key" placeholder="平台公钥" rows="5"><?php echo htmlspecialchars($conf['epay_public_key']); ?></textarea>
                </div>
            </div>
            <div class="layui-form-item" id="epay_off_3" style="<?php echo $conf['epay_v']==1?'display:none;':null; ?>">
                <label class="layui-form-label">商户私钥(RSA2)</label>
                <div class="layui-input-block">
                    <textarea class="layui-textarea" name="epay_private_key" placeholder="商户私钥" rows="5"><?php echo htmlspecialchars($conf['epay_private_key']); ?></textarea>
                </div>
            </div>

            <div class="layui-form-item layui-input-block">
                <button type="reset" id="formreset" class="pear-btn">&emsp;重置&emsp;</button>
                <button class="pear-btn pear-btn-primary" type="button" lay-filter="Submit_btn" lay-submit>&emsp;提交&emsp;</button>
            </div>
        </form>
    </div>
</div>
<?php } ?>
<!--易支付配置-->


<?php }elseif($mod=='certificate'){ ?>

<div class="layui-card">
    <div class="layui-card-header">实名认证</div>
    <div class="layui-card-body">
        <!-- 表单开始 -->
        <form method="post" id="formAdvForm" class="layui-form" role="form">
            
            <div class="layui-form-item">
                <label class="layui-form-label">实名认证</label>
                <div class="layui-input-block">
                    <select class="layui-input" name="cert_open" lay-filter="cert_open">
                        <option <?php echo $conf['cert_open'] == 0 ? 'selected ' : '' ?>value="0">关闭</option>
                        <option <?php echo $conf['cert_open'] == 1 ? 'selected ' : '' ?>value="1">幻影API(支付宝实名认证)</option>
                    </select>
                </div>
            </div>
            
            <div class="layui-form-item" id="cert_open_off2" style="<?php echo ($conf['cert_open']!=1)?'display:none;':null; ?>">
                <label class="layui-form-label">APIKEY</label>
                <div class="layui-input-block">
                    <input type="text" name="APIKEY" value="<?php echo $conf['APIKEY']; ?>" class="layui-input" placeholder="" />
                </div>
            </div>
            
            <div class="layui-form-item" id="cert_open_off3" style="<?php echo $conf['cert_open']==0?'display:none;':null; ?>">
                <label class="layui-form-label">实名费用</label>
                <div class="layui-input-block">
                    <input type="text" name="cert_money" value="<?php echo $conf['cert_money']; ?>" class="layui-input" placeholder="留空或0为免认证费用" />
                </div>
            </div>
            
            <div class="layui-form-item layui-input-block">
                <button type="reset" id="formreset" class="pear-btn">&emsp;重置&emsp;</button>
                <button class="pear-btn pear-btn-primary" type="button" lay-filter="Submit_btn" lay-submit>&emsp;提交&emsp;</button>
            </div>
        </form>
        <hr>
        <div style="padding: 10px 30px 20px 30px;">
            <h4>幻影API(支付宝实名认证)</h4>
            <p class="layui-text"><a href="https://api.52hyjs.com/?mod=doc&id=21" target="_blank" rel="noreferrer">点击进入</a>接口0.3元/次</p>
            <br>
        </div>
    </div>
</div>

<?php }elseif($mod=="mail"){ ?>

<div class="layui-card">
    <div class="layui-card-header">邮箱模块</div>
    <div class="layui-card-body">
        <form method="post" id="formAdvForm" class="layui-form" role="form">

            <div class="layui-form-item">
                <label class="layui-form-label">发信模式</label>
                <div class="layui-input-block">
                    <select id="mail_cloud" name="mail_cloud" class="layui-input" lay-filter="mail_cloud">
                        <option <?php echo $conf['mail_cloud'] == 0 ? 'selected ' : '' ?>value="0">SMTP发信</option>
                        <option <?php echo $conf['mail_cloud'] == 1 ? 'selected ' : '' ?>value="1">搜狐Sendcloud</option>
                        <option <?php echo $conf['mail_cloud'] == 2 ? 'selected ' : '' ?>value="2">阿里云邮件推送</option>
                    </select>
                </div>
            </div>

            <div id="mail_cloud1" style="<?php echo $conf['mail_cloud']>1?'display:none;':null; ?>">
                <div class="layui-form-item">
                    <div class="layui-col-md6">
                        <label class="layui-form-label">smtp服务器</label>
                        <div class="layui-input-block">
                            <input type="text" name="mail_smtp" id="mail_smtp" class="layui-input" value="<?=$conf['mail_smtp']?>">
                        </div>
                    </div>
                    <div class="layui-col-md6">
                        <label class="layui-form-label">SMTP端口</label>
                        <div class="layui-input-block">
                            <input type="text" name="mail_post" id="mail_post" class="layui-input" value="<?=$conf['mail_post']?>">
                        </div>
                    </div>
                </div>

                <div class="layui-form-item">
                    <div class="layui-col-md6">
                        <label class="layui-form-label">邮箱账号</label>
                        <div class="layui-input-block">
                            <input type="text" name="mail_user" id="mail_user" class="layui-input" value="<?=$conf['mail_user']?>">
                        </div>
                    </div>
                    <div class="layui-col-md6">
                        <label class="layui-form-label">邮箱密码</label>
                        <div class="layui-input-block">
                            <input type="text" name="mail_pass" id="mail_pass" class="layui-input" value="<?=$conf['mail_pass']?>">
                        </div>
                    </div>
                </div>
            </div>

            <div id="mail_cloud2" style="<?php echo $conf['mail_cloud']==0?'display:none;':null; ?>">
                <div class="layui-form-item">
                    <div class="layui-inline">
                        <label class="layui-form-label">API_USER</label>
                        <div class="layui-input-inline">
                            <input type="text" name="mail_apiuser" id="mail_apiuser" class="layui-input" value="<?=$conf['mail_apiuser']?>">
                        </div>
                    </div>
                    <div class="layui-inline">
                        <label class="layui-form-label">API_KEY</label>
                        <div class="layui-input-inline">
                            <input type="text" name="mail_apikey" id="mail_apikey" class="layui-input" value="<?=$conf['mail_apikey']?>">
                        </div>
                    </div>
                    <div class="layui-inline">
                        <label class="layui-form-label">发信邮箱</label>
                        <div class="layui-input-inline">
                            <input type="text" name="mail_name2" id="mail_name2" class="layui-input" value="<?=$conf['mail_name2']?>">
                        </div>
                    </div>
                </div>
            </div>

            <hr />

            <div class="layui-form-item">
                <label class="layui-form-label">收信邮箱</label>
                <div class="layui-input-block">
                    <input type="text" name="mail_recv" id="mail_recv" class="layui-input" value="<?=$conf['mail_recv']?>" placeholder="请填写您的收信邮箱" />
                    <div class="layui-word-aux">不填则无法测试发信是否正常【仅测试发信使用】</div>
                </div>
            </div>


            
                    
            
            <div class="layui-form-item layui-input-block">
                <button type="reset" id="formreset" class="pear-btn">&emsp;重置&emsp;</button>
                <button class="pear-btn pear-btn-primary" type="button" lay-filter="Submit_btn" lay-submit>&emsp;提交&emsp;</button>
            </div>
        </form>

        <fieldset class="layui-elem-field">
            <legend>关于邮箱</legend>
            <div class="layui-field-box">
                <?php
if ($conf['mail_recv']) {
echo '<button type="button" class="pear-btn pear-btn-xs pear-btn-warming" id="mailtest">给 ';
echo $conf['mail_recv'] ? $conf['mail_recv'] : $conf['mail_name2'];
echo ' 发一封测试邮件</button>';
}
?>
                <br>
                此功能为用户下单时给自己发邮件提醒。<br />
                使用普通模式发信时，建议使用QQ邮箱，SMTP服务器smtp.qq.com，端口465，密码不是QQ密码也不是邮箱独立密码，是QQ邮箱设置界面生成的<a class="pear-btn pear-btn-xs pear-btn-warm" href="http://service.mail.qq.com/cgi-bin/help?subtype=1&&no=1001256&&id=28" target="_blank" rel="noreferrer">授权码</a>。为确保发信成功率，发信邮箱和收信邮箱最好同一个<br />
                阿里云邮件推送：<a href="https://www.aliyun.com/product/directmail" target="_blank" rel="noreferrer">点此进入</a>｜<a href="https://usercenter.console.aliyun.com/#/manage/ak" target="_blank" rel="noreferrer">获取AK/SK</a>
            </div>
        </fieldset>
    </div>
</div>

<?php }elseif($mod=="cron"){ ?>

<div class="layui-card">
    <div class="layui-card-header">计划任务设置</div>
    <div class="layui-card-body">
        <form method="post" id="formAdvForm" class="layui-form" role="form">
            <div class="layui-form-item">
                <label class="layui-form-label">计划密钥</label>
                <div class="layui-input-block">
                    <input type="text" name="cronkey" class="layui-input" placeholder="计划任务访问密钥" value="<?=$conf['cronkey']?>">
                </div>
            </div>
            <div class="layui-form-item layui-input-block">
                <button class="pear-btn pear-btn-primary layui-btn-fluid" lay-filter="Submit_btn" lay-submit>保存</button>
            </div>
        </form>
    </div>
</div>

<div class="layui-card">
    <div class="layui-card-header">计划任务列表</div>
    <div class="layui-card-body">

        <div class="layui-form-item">
            <label class="layui-form-label">过期会员</label>
            <div class="layui-input-block">
                <input type="text" value="<?php echo $siteurl?>cron.php?do=userendtime&key=<?php echo $conf['cronkey']?>" class="layui-input" disabled="" />
                <div class="layui-word-aux">每10分钟访问一次即可</div>
            </div>
        </div>
        
        <div class="layui-form-item">
            <label class="layui-form-label">解析过期检测</label>
            <div class="layui-input-block">
                <input type="text" name="crontime" class="layui-input" value="<?php echo $siteurl?>cron.php?do=record&key=<?php echo $conf['cronkey']?>">
                <div class="layui-word-aux">每1小时访问一次即可</div>
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">整租域名</label>
            <div class="layui-input-block">
                <input type="text" value="<?php echo $siteurl?>cron.php?do=endtimedomain&key=<?php echo $conf['cronkey']?>" class="layui-input" disabled="" />
                <div class="layui-word-aux">每10分钟访问一次即可</div>
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">解析关键词检测</label>
            <div class="layui-input-block">
                <input type="text" name="crontime" class="layui-input" value="<?php echo $siteurl?>cron2.php?do=checkkeywords&key=<?php echo $conf['cronkey']?>">
                <div class="layui-word-aux">每1小时访问一次即可</div>
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">异常解析检测</label>
            <div class="layui-input-block">
                <input type="text" name="crontime" class="layui-input" value="<?php echo $siteurl?>cron.php?do=ycrecord&key=<?php echo $conf['cronkey']?>">
                <div class="layui-word-aux">每天访问一次即可</div>
            </div>
        </div>
        

    </div>
</div>

<?php }elseif($mod=="iptype"){ ?>

<div class="layui-card">
    <div class="layui-card-header">用户IP地址获取设置</div>
    <div class="layui-card-body">
        <form method="post" id="formAdvForm" class="layui-form" role="form">
            <div class="layui-form-item">
                <label class="layui-form-label">IP获取方式</label>
                <div class="layui-input-block">
                    <select name="ip_type" class="layui-input">
                        <option <?php echo $conf['ip_type'] == 0 ? 'selected ' : '' ?>value="0">0_X_FORWARDED_FOR</option>
                        <option <?php echo $conf['ip_type'] == 1 ? 'selected ' : '' ?>value="1">1_X_REAL_IP</option>
                        <option <?php echo $conf['ip_type'] == 2 ? 'selected ' : '' ?>value="2">2_REMOTE_ADDR</option>
                    </select>
                </div>
            </div>


            <div class="layui-form-item">
                <label class="layui-form-label">查询插件</label>
                <div class="layui-input-block">
                    <select name="ip_plugin" id="ip_plugin" class="layui-input" lay-filter="ip_plugin">
                        <option value="">请选择IP查询插件</option>
                    </select>
                    <div class="layui-form-mid layui-word-aux" id="plugin-desc"></div>
                </div>
                <div class="layui-form-mid layui-word-aux">不同的IP查询插件，查询的精度不一致可以按需求选择，IP位置查询会影响系统整体性能可以选择服务器请求最快的插件！</div>
            </div>

            <div class="layui-form-item layui-input-block">
                <button class="pear-btn pear-btn-primary layui-btn-fluid" type="button" lay-filter="Submit_btn" lay-submit>&emsp;提交&emsp;</button>
            </div>
        </form>
        <hr />
        <fieldset class="layui-elem-field">
            <legend>关于用户IP地址获取</legend>
            <div class="layui-field-box">
                此功能设置用于防止用户伪造IP请求。<br />
                X_FORWARDED_FOR：之前的获取真实IP方式，极易被伪造IP<br />
                X_REAL_IP：在网站使用CDN的情况下选择此项，在不使用CDN的情况下也会被伪造<br />
                REMOTE_ADDR：直接获取真实请求IP，无法被伪造，但可能获取到的是CDN节点IP<br />
            </div>
        </fieldset>

    </div>
</div>
<?php }elseif($mod=="phone"){ ?>
<div class="layui-card">
            <div class="layui-card-header">短信模块</div>
            <div class="layui-card-body">
                <form method="post" class="layui-form" id="formAdvForm" lay-filter="formAdvForm" role="form">
                    <div class="layui-form-item layui-row">
                        <div class="layui-inline layui-col-md12">
                            <label class="layui-form-label">短信接口</label>
                            <div class="layui-input-block">
                                <select id="sms_api" name="sms_api" class="layui-input" lay-filter="sms_api">
                                    <option <?php echo $conf['sms_api'] == 0 ? 'selected ' : '' ?>value="0">关闭短信</option>
                                    <option <?php echo $conf['sms_api'] == 1 ? 'selected ' : '' ?>value="1">短信宝平台</option>
                                    <option <?php echo $conf['sms_api'] == 2 ? 'selected ' : '' ?>value="2">腾讯云短信</option>
                                    <option <?php echo $conf['sms_api'] == 3 ? 'selected ' : '' ?>value="3">赛邮云</option>
                                </select>
                            </div>
                        </div>
                        <!-- 短信宝 -->
                        <div id="send_sms" style="<?php if($conf['sms_api'] == 0){echo'display:none;';}?>">
                            <div class="layui-inline layui-col-md4">
                                <label class="layui-form-label">账号 | ID</label>
                                <div class="layui-input-block">
                                    <input type="text" name="sms_id" id="sms_id" class="layui-input" value="<?=$conf['sms_id']?>">
                                </div>
                            </div>
    
                            <div class="layui-inline layui-col-md4">
                                <label class="layui-form-label">密码 | KEY</label>
                                <div class="layui-input-block">
                                    <input type="text" name="sms_key" id="sms_key" class="layui-input" value="<?=$conf['sms_key']?>">
                                </div>
                            </div>
    
                            <div class="layui-inline layui-col-md4">
                                <label class="layui-form-label">签名 | ID</label>
                                <div class="layui-input-block">
                                    <input type="text" name="sms_sign_name" id="sms_sign_name" class="layui-input" value="<?=$conf['sms_sign_name']?>">
                                </div>
                            </div>
    
                            <div class="layui-inline layui-col-md12">
                                <label class="layui-form-label">修改模板ID</label>
                                <div class="layui-input-block">
                                    <input type="text" class="layui-input" name="sms_tpl_edit" id="sms_tpl_edit" value="<?=$conf['sms_tpl_edit']?>">
                                </div>
                            </div>
                            
                            <hr>
    
                            <fieldset class="layui-elem-field">
                                <legend>关于短信</legend>
                                <div class="layui-field-box">
                                    短信宝平台地址：<a class="layui-btn layui-btn-xs layui-btn-normal" href="http://www.smsbao.com" target="_blank">点此进入</a> | 模板ID处写模板内容（不含签名，验证码用{code}代替）<br>
                                </div>
                            </fieldset>
                        </div>
                        <!-- 腾讯云短信 -->
                        <div id="tencent_form" style="display:none;">
                            <div class="layui-inline layui-col-md4">
                                <label class="layui-form-label">SecretId</label>
                                <div class="layui-input-block">
                                    <input type="text" name="sms_id" class="layui-input" value="<?=$conf['sms_id']?>">
                                </div>
                            </div>
                            <div class="layui-inline layui-col-md4">
                                <label class="layui-form-label">SecretKey</label>
                                <div class="layui-input-block">
                                    <input type="text" name="sms_key" class="layui-input" value="<?=$conf['sms_key']?>">
                                </div>
                            </div>
                            <div class="layui-inline layui-col-md4">
                                <label class="layui-form-label">签名</label>
                                <div class="layui-input-block">
                                    <input type="text" name="sms_sign_name" class="layui-input" value="<?=$conf['sms_sign_name']?>">
                                </div>
                            </div>
                            <div class="layui-inline layui-col-md4">
                                <label class="layui-form-label">模板ID</label>
                                <div class="layui-input-block">
                                    <input type="text" class="layui-input" name="sms_tpl_edit" value="<?=$conf['sms_tpl_edit']?>">
                                </div>
                            </div>
                            <div class="layui-inline layui-col-md4">
                                <label class="layui-form-label">SdkAppId</label>
                                <div class="layui-input-block">
                                    <input type="text" class="layui-input" name="sms_sdkappid" value="<?=isset($conf['sms_sdkappid'])?$conf['sms_sdkappid']:''?>">
                                </div>
                            </div>
                            
                            <fieldset class="layui-elem-field">
                                <legend>关于短信</legend>
                                <div class="layui-field-box">
                                    腾讯云短信地址：<a class="layui-btn layui-btn-xs layui-btn-normal" href="https://cloud.tencent.com/product/sms" target="_blank">点此进入</a> | 模板ID处写模板内容（不含签名，验证码用{code}代替）<br>
                                </div>
                            </fieldset>
                        </div>
                        <!-- 赛邮云 -->
                        <div id="send_sms3" style="<?php if($conf['sms_api'] == 3){echo'display:none;';}?>">
                            <div class="layui-inline layui-col-md4">
                                <label class="layui-form-label">AppID</label>
                                <div class="layui-input-block">
                                    <input type="text" name="sms_id" class="layui-input" value="<?=$conf['sms_id']?>">
                                </div>
                            </div>
                            <div class="layui-inline layui-col-md4">
                                <label class="layui-form-label">AppKey</label>
                                <div class="layui-input-block">
                                    <input type="text" name="sms_key" class="layui-input" value="<?=$conf['sms_key']?>">
                                </div>
                            </div>
                            <div class="layui-inline layui-col-md4">
                                <label class="layui-form-label">签名</label>
                                <div class="layui-input-block">
                                    <input type="text" name="sms_sign_name" class="layui-input" value="<?=$conf['sms_sign_name']?>">
                                </div>
                            </div>
                            <div class="layui-inline layui-col-md12">
                                <label class="layui-form-label">模板内容</label>
                                <div class="layui-input-block">
                                    <input type="text" class="layui-input" name="sms_tpl_edit" value="<?=$conf['sms_tpl_edit']?>">
                                </div>
                            </div>
                            <fieldset class="layui-elem-field">
                                <legend>关于短信</legend>
                                <div class="layui-field-box">
                                    赛邮云平台地址：<a class="layui-btn layui-btn-xs layui-btn-normal" href="https://www.saiyouyun.com/" target="_blank">点此进入</a> | 模板内容写后台报备的模板（不含签名，验证码用{code}代替）<br>
                                </div>
                            </fieldset>
                        </div>

                    </div>
                    <div class="layui-form-item layui-input-block">
                        <button type="reset" id="formreset" class="pear-btn">&emsp;重置&emsp;</button>
                        <button class="pear-btn pear-btn-primary" type="button" lay-filter="Submit_btn" lay-submit>&emsp;提交&emsp;</button>
                    </div>
                </form>
            </div>
        </div>


<?php }elseif($mod=="kuaijie"){ ?>

<div class="layui-card">
    <div id="divLoading">
        <div class="layui-card-header">快捷登录</div>
        <div class="layui-card-body">
            <form method="post" id="formAdvForm" class="layui-form" role="form">

                <div class="layui-form-item">
                    <label class="layui-form-label">QQ登录</label>
                    <div class="layui-input-block">
                        <select name="login_qq" class="layui-input">
                            <option <?php echo $conf['login_qq'] == 0 ? 'selected ' : '' ?>value="0">关闭</option>
                            <option <?php echo $conf['login_qq'] == 1 ? 'selected ' : '' ?>value="1">彩虹聚合登录</option>
                        </select>
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">微信登录</label>
                    <div class="layui-input-block">
                        <select name="login_wx" class="layui-input">
                            <option <?php echo $conf['login_wx'] == 0 ? 'selected ' : '' ?>value="0">关闭</option>
                            <option <?php echo $conf['login_wx'] == 1 ? 'selected ' : '' ?>value="1">彩虹聚合登录</option>
                        </select>
                    </div>
                </div>

                <div class="layui-form-item layui-input-block">
                    <button type="reset" id="formreset" class="pear-btn">&emsp;重置&emsp;</button>
                    <button class="pear-btn pear-btn-primary" type="button" lay-filter="Submit_btn" lay-submit>&emsp;提交&emsp;</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php if($conf['login_qq']==1 || $conf['login_alipay']==1 || $conf['login_wx']==1){ ?>
<div class="layui-card">
    <div class="layui-card-header">彩虹聚合登录</div>
    <div class="layui-card-body">
        <form method="post" id="formAdvForm" class="layui-form" role="form">
            
            <div class="layui-form-item">
                <label class="layui-form-label">登录API接口</label>
                <div class="layui-input-block">
                    <input type="text" name="login_apiurl" class="layui-input" placeholder="彩虹聚合登录api接口" value="<?=$conf['login_apiurl']?>">
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">APPID</label>
                <div class="layui-input-block">
                    <input type="text" name="login_appid" class="layui-input" placeholder="登录APPID" value="<?=$conf['login_appid']?>">
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">APPKEY</label>
                <div class="layui-input-block">
                    <input type="text" name="login_appkey" class="layui-input" placeholder="登录APPKEY" value="<?=$conf['login_appkey']?>">
                </div>
            </div>

            <div class="layui-form-item layui-input-block">
                <button type="reset" id="formreset" class="pear-btn">&emsp;重置&emsp;</button>
                <button class="pear-btn pear-btn-primary" type="button" lay-filter="Submit_btn" lay-submit>&emsp;提交&emsp;</button>
            </div>
        </form>
    </div>
</div>
<?php } ?>

<?php }elseif($mod=="gongdan"){ ?>

<div class="layui-card">
    <div class="layui-card-header">工单配置</div>
    <div class="layui-card-body">
        <!-- 表单开始 -->
        <form method="post" id="formAdvForm" class="layui-form" role="form">

            <div class="layui-form-item">
                <label class="layui-form-label">反馈工单</label>
                <div class="layui-input-block">
                    <select name="workorder_open" class="layui-input" default="<?=$conf['workorder_open']?>">
                        <option <?php echo $conf['workorder_open'] == 0 ? 'selected ' : '' ?>value="0">关闭</option>
                        <option <?php echo $conf['workorder_open'] == 1 ? 'selected ' : '' ?>value="1">开启</option>
                    </select>
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">上传图片</label>
                <div class="layui-input-block">
                    <select name="workorder_pic" class="layui-input" default="<?=$conf['workorder_pic']?>">
                        <option <?php echo $conf['workorder_pic'] == 0 ? 'selected ' : '' ?>value="0">关闭</option>
                        <option <?php echo $conf['workorder_pic'] == 1 ? 'selected ' : '' ?>value="1">开启</option>
                    </select>
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">问题类型</label>
                <div class="layui-input-block">
                    <textarea class="layui-textarea" name="workorder_type" placeholder="使用“|”隔开" rows="5"><?php echo htmlspecialchars($conf['workorder_type']); ?></textarea>
                    <div class="layui-word-aux">多个分类使用“|”隔开</div>
                </div>
            </div>

            <div class="layui-form-item layui-input-block">
                <button type="reset" id="formreset" class="pear-btn">&emsp;重置&emsp;</button>
                <button class="pear-btn pear-btn-primary" type="button" lay-filter="Submit_btn" lay-submit>&emsp;提交&emsp;</button>
            </div>
        </form>
    </div>
</div>

<?php }elseif($mod=='template'){ ?>
 <?php
$index_templates = Template::getList('index');
$login_templates = Template::getList('login');
?>
<div class="layui-card">
    <div class="layui-tab layui-tab-brief" lay-filter="userInfoTab">
        <ul class="layui-tab-title">
            <li class="layui-this"><i class="layui-icon layui-icon-theme"> 前台模板</i></li>
            <li><i class="layui-icon layui-icon-face-smile"> 登录模板</i></li>
        </ul>
        <div class="layui-tab-content">
            <!-- 前台模板标签页 -->
            <div class="layui-tab-item layui-show">
                <div class="layui-card-body">
                    <div style="white-space:nowrap;overflow-x: auto;">
                        <table class="layui-table">
                            <thead>
                                <tr>
                                    <th>模板图片</th>
                                    <th>模板名称</th>
                                    <th>模板作者</th>
                                    <th>模板版本</th>
                                    <th>模板介绍</th>
                                    <th>模板操作</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(empty($index_templates)): ?>
                                    <tr>
                                        <td colspan="6" style="text-align: center;">没有找到前台模板</td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach($index_templates as $template): ?>
                                        <?php 
                                        $config = Template::getConfig($template, 'index');
                                        $image_path = Template::getImagePath($template, 'index');
                                        ?>
                                        <tr>
                                            <td><img src="<?php echo $image_path; ?>" width="120" height="60" alt="<?php echo $template; ?>" onerror="this.src='https://img.52hyjs.com/2026/01/04/6959f51db2d25.png'"></td>
                                            <td><?php echo $template; ?></td>
                                            <td><?php echo htmlspecialchars($config['zuozhe']); ?></td>
                                            <td><?php echo htmlspecialchars($config['version']); ?></td>
                                            <td><?php echo htmlspecialchars($config['jieshao']); ?></td>
                                            <?php if($conf['template'] != $template): ?>
                                                <td><a href="javascript:changeIndexTemplate('<?php echo $template; ?>')" class="layui-btn layui-btn-sm">点击更换</a></td>
                                            <?php else: ?>
                                                <td><a class="layui-btn layui-btn-sm layui-btn-disabled">使用中</a></td>
                                            <?php endif; ?>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <!-- 登录模板标签页 -->
            <div class="layui-tab-item">
                <div class="layui-card-body">
                    <div style="white-space:nowrap;overflow-x: auto;">
                        <table class="layui-table">
                            <thead>
                                <tr>
                                    <th>模板图片</th>
                                    <th>模板名称</th>
                                    <th>模板作者</th>
                                    <th>模板版本</th>
                                    <th>模板介绍</th>
                                    <th>模板操作</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(empty($login_templates)): ?>
                                    <tr>
                                        <td colspan="6" style="text-align: center;">没有找到登录模板</td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach($login_templates as $template): ?>
                                        <?php 
                                        $config = Template::getConfig($template, 'login');
                                        $image_path = Template::getImagePath($template, 'login');
                                        ?>
                                        <tr>
                                            <td><img src="<?php echo $image_path; ?>" width="120" height="60" alt="<?php echo $template; ?>" onerror="this.src='https://img.52hyjs.com/2026/01/04/6959f51db2d25.png'"></td>
                                            <td><?php echo $template; ?></td>
                                            <td><?php echo htmlspecialchars($config['zuozhe']); ?></td>
                                            <td><?php echo htmlspecialchars($config['version']); ?></td>
                                            <td><?php echo htmlspecialchars($config['jieshao']); ?></td>
                                            <?php 
                                            // 获取当前使用的登录模板，如果没有单独设置则使用前台模板
                                            $current_login_template = isset($conf['login_template']) ? $conf['login_template'] : (isset($conf['template']) ? $conf['template'] : '');
                                            ?>
                                            <?php if($current_login_template != $template): ?>
                                                <td><a href="javascript:changeLoginTemplate('<?php echo $template; ?>')" class="layui-btn layui-btn-sm">点击更换</a></td>
                                            <?php else: ?>
                                                <td><a class="layui-btn layui-btn-sm layui-btn-disabled">使用中</a></td>
                                            <?php endif; ?>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php } ?>
<?php include 'foot.php'; ?>
<script>
   layui.use(['layer', 'form', 'element', 'jquery', 'upload' ,'tagsInput' ,'toast'], function () {
    let form = layui.form;
    let $ = layui.$;
    let layer = layui.layer;
    let upload = layui.upload;
    let element = layui.element;
    let tagsInput = layui.tagsInput;
    let toast = layui.toast;

    // 上传logo文件
        var uploadInst = upload.render({
            elem: '.upload-logo', //绑定元素
            url: 'ajax.php?act=uploadlogo', //上传接口
            accept: 'images', // 只允许上传图片
            acceptMime: 'image/*', // 只允许上传图片
            size: 5120, //单位kb
            done: function(res){
                //上传完毕回调
                if(res.code === 0){
                    toast.success({
                                message: res.msg,
                            });
                    
                    $("#logourl").val(res.url);
                }else{
                    toast.error({
                                message: res.msg,
                            });
                    
                }
            },
            error: function(){
                //请求异常回调
                toast.error({
                                message: '请求上传接口异常！',
                            });
                
            }
        });
        
        var uploadIcoInst = upload.render({
          elem: '#upload-ico',
          url: 'ajax.php?act=uploadico',
          accept: 'images',
          acceptMime: 'image/x-icon',
          exts: 'ico',
          size: 5120,
          done: function(res){
            if(res.code === 0){
              toast.success({
                                message: res.msg,
                            });
              $("#icourl").val(res.url); // 将上传成功的图片URL写入到表单输入框内
            }else{
              toast.error({
                                message: res.msg,
                            });
            }
          },
          error: function(){
            toast.error({
                                message: '请求上传接口异常！',
                            });
          }
        });
        
        // 绑定查看图片按钮的点击事件
        $('button[title="查看图片"]').on('click', function() {
            var imgUrl = $(this).prev().val();
            // 如果输入框中有图片链接，则打开新窗口显示图片
            if (imgUrl) {
              layer.open({
                type: 1,
                title: '当前图片',
                closeBtn: 1,
                area: ['90%', '90%'],
                skin: 'layui-layer-nobg', //没有背景色
                shadeClose: true,
                content: '<img src="' + imgUrl + '" alt="" width="100%" height="100%">'
              });
            } else {
                toast.error({
                                message: '请先上传图片',
                            });
            }
        });

    // 关键词样式
    $('#keywordstags').tagsInput();   
    //邮箱信息
        form.on('select(mail_cloud)', function(data){ 
            if(data.value == 0){
            	$("#mail_cloud1").show(500);
            	$("#mail_cloud2").hide(500);
            }else{
            	$("#mail_cloud1").hide(500);
            	$("#mail_cloud2").show(500);
            }
        });
    // 短信配置
        form.on('select(sms_api)', function(data){
            if(data.value == '1'){
                $("#send_sms").show(500);
                $("#tencent_form").hide(500);
                $("#send_sms3").hide(500);
            }else if(data.value == '2'){
                $("#send_sms").hide(500);
                $("#tencent_form").show(500);
                $("#send_sms3").hide(500);
            }else if(data.value == '3'){
                $("#send_sms").hide(500);
                $("#tencent_form").hide(500);
                $("#send_sms3").show(500);
            }else{
                $("#send_sms").hide(500);
                $("#tencent_form").hide(500);
                $("#send_sms3").hide(500);
            }
        });
        //短信配置显示
        $(function(){
            var v = $('#sms_api').val();
            if(v == '1'){
                $("#send_sms").show();
                $("#tencent_form").hide();
                $("#send_sms3").hide();
            }else if(v == '2'){
                $("#send_sms").hide();
                $("#tencent_form").show();
                $("#send_sms3").hide();
            }else if(v == '3'){
                $("#send_sms").hide();
                $("#tencent_form").hide();
                $("#send_sms3").show();
            }else{
                $("#send_sms").hide();
                $("#tencent_form").hide();
                $("#send_sms3").hide();
            }
        });

        // 获取IP插件列表
        $.ajax({
            url: './ajax.php?act=plugin&mod=iplist',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                // 清空现有选项（保留第一个提示选项）
                $('#ip_plugin').find('option:not(:first)').remove();
                
                if (response.code === 0 && response.data && response.data.length > 0) {
                    // 有插件的情况
                    window.pluginData = {};
                    
                    $.each(response.data, function(index, plugin) {
                        // 存储插件数据
                        window.pluginData[plugin.pluginName] = plugin;
                        
                        // 添加选项
                        $('#ip_plugin').append($('<option>', {value: plugin.pluginName,text: plugin.showname}));
                        
                        // 默认选择第一个插件
                        if (index === 0) {
                            $('#ip_plugin').val(plugin.pluginName);
                            $('#plugin-desc').text(plugin.description || '');
                        }
                    });
                }else{
                    $('#ip_plugin').append($('<option>', {value: '',text: response.msg}));
                    $('#plugin-desc').text(response.msg || '');
                }
                
                // 重新渲染layui表单
                layui.form.render('select');
            }
        });

          // 表单提交
        form.on('submit(Submit_btn)', function (data) { 
                var loading = layer.msg('正在保存配置...', { icon: 16, shade: 0.3, time: 0 });
                $.ajax({
                    type: "POST",
                    url: "ajax.php?act=set",
                    data: data.field,
                    dataType: "json",
                    success: function(data) {
                        layer.close(loading);
                        if (data.code == 0) {
                            toast.success({
                                message: data.msg,
                            });
                            setTimeout(function(){
                                location.reload();
                            }, 2500);
                        } else {
                            toast.error({
                                message: data.msg,
                            });
                        }
                    }
                });
                return false;
        });

        // 测试连通性
        form.on('submit(cloud_lt)', function(data){
            var loading = layer.msg('正在测试连通性...', { icon: 16, shade: 0.3, time: 0 });
            $.ajax({
                type: "POST",
                url: "ajax.php?act=cloud_lt",
                data: data.field,
                dataType: "json",
                success: function(data) {
                    layer.close(loading);
                    if (data.code == 0) {
                        toast.success({
                                message: data.msg,
                            });
                    } else {
                        toast.error({
                                message: data.msg,
                            });
                    }
                }
            });
            return false;
        });
        // 查询余额
        form.on('submit(cloud_yue)', function(data){
            var loading = layer.msg('正在查询余额...', { icon: 16, shade: 0.3, time: 0 });
            $.ajax({
                type: "POST",
                url: "ajax.php?act=cloud_yue",
                data: data.field,
                dataType: "json",
                success: function(data) {
                    layer.close(loading);
                    if (data.code == 0) {
                        toast.success({
                                message: data.msg,
                            });
                    } else {
                        toast.error({
                                message: data.msg,
                            });
                    }
                }
            });
            return false;
        });

        window.changeIndexTemplate = function(template) { //更换首页模板
            var loading = layer.msg('正在更换首页模板中...', { icon: 16, shade: 0.3, time: 0 });
            $.ajax({
                type: 'POST',
                url: 'ajax.php?act=set',
                data: {
                    template: template
                },
                dataType: 'json',
                success: function(data) {
                    layer.close(loading);
                    if (data.code == 0) {
                        toast.success({
                                message: data.msg,
                            });
                        setTimeout(function() {
                            location.reload(); // 刷新页面
                        }, 1500); //1.5秒后刷新
                    } else {
                         toast.error({
                                message: data.msg,
                            });
                    }
                },
                error: function(data) {
                    layer.close(loading);
                     toast.error({
                                message: '服务器错误',
                            });
                    return false;
                }
            });
            return false;
        }
        // 登录模板切换
        window.changeLoginTemplate = function(template) {
            var loading = layer.msg('正在更换登录模板中...', { icon: 16, shade: 0.3, time: 0 });
            $.ajax({
                type: 'POST',
                url: 'ajax.php?act=set',
                data: {
                    login_template: template
                },
                dataType: 'json',
                success: function(data) {
                    layer.close(loading);
                    if (data.code == 0) {
                        toast.success({
                            message: data.msg,
                        });
                        setTimeout(function() {
                            location.reload(); // 刷新页面
                        }, 1500); //1.5秒后刷新
                    } else {
                        toast.error({
                            message: data.msg,
                        });
                    }
                },
                error: function(data) {
                    layer.close(loading);
                    toast.error({
                        message: '服务器错误',
                    });
                    return false;
                }
            });
            return false;
        }

        // 邮箱发信
        $('#mailtest').click(function () {
        var loading = layer.msg('正在测试中...', { icon: 16, shade: 0.3, time: 0 });
            $.ajax({
                type: "GET",
                url: "ajax.php?act=mailtest",
                dataType: "json",
                success: function(data) {
                    layer.close(loading);
                    if (data.code == 0) {
                        toast.success({
                            message: data.msg,
                        });
                    } else {
                        toast.error({
                            message: data.msg,
                        });
                    }
                }
            });
        }); 
    
        
       
    });
</script>
    

</body>
</html>