<?php
error_reporting(0);
session_start();
@header('Content-Type: text/html; charset=UTF-8');
if(file_exists('install.lock')){
    exit('<div style="font-family: \'Inter\', sans-serif; max-width: 800px; margin: 100px auto; padding: 40px; background: white; border-radius: 16px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); text-align: center;">
        <h1 style="color: #ff4757; font-weight: 600;">安装锁定</h1>
        <p style="color: #666; font-size: 16px; line-height: 1.6; margin: 20px 0;">您已经安装过本系统，如需重新安装请删除 <span style="background: #f1f2f6; padding: 4px 8px; border-radius: 4px; font-family: monospace;">install/install.lock</span> 文件</p>
        <a href="../" style="display: inline-block; margin-top: 20px; padding: 12px 24px; background: #4b7bec; color: white; text-decoration: none; border-radius: 8px; font-weight: 500; transition: all 0.3s;">返回首页</a>
    </div>');
}

$version = str_replace('.','',PHP_VERSION);
$PHPVer = substr($version,0,2);
$_SESSION['checksession']=1;

/**
 * 检测PHP函数是否存在
 */
function checkfunc($f, $m = false) {
    if (function_exists($f)) {
        return '<span class="status-badge success"><i class="icon-check"></i> 支持</span>';
    } else {
        if ($m == false) {
            return '<span class="status-badge warning"><i class="icon-close"></i> 不支持</span>';
        } else {
            return '<span class="status-badge danger"><i class="icon-close"></i> 不支持</span>';
        }
    }
}

/**
 * 检测PHP类是否存在
 */
function checkclass($f, $m = false) {
    if (class_exists($f)) {
        return '<span class="status-badge success"><i class="icon-check"></i> 支持</span>';
    } else {
        if ($m == false) {
            return '<span class="status-badge warning"><i class="icon-close"></i> 不支持</span>';
        } else {
            return '<span class="status-badge danger"><i class="icon-close"></i> 不支持</span>';
        }
    }
}

/**
 * 检测PHP扩展是否加载
 */
function checkExtension($extension, $required = true) {
    if (extension_loaded($extension)) {
        return '<span class="status-badge success"><i class="icon-check"></i> 支持</span>';
    } else {
        if ($required == false) {
            return '<span class="status-badge warning"><i class="icon-close"></i> 不支持</span>';
        } else {
            return '<span class="status-badge danger"><i class="icon-close"></i> 不支持</span>';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>幻影二级域名分发系统 - 安装向导</title>
    <link href="https://fonts.loli.net/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@7.2.96/css/materialdesignicons.min.css">
    <style>
        :root {
            --primary: #6366f1;
            --primary-light: #818cf8;
            --primary-dark: #4f46e5;
            --success: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-700: #374151;
            --gray-900: #111827;
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #e4e8f0 100%);
            color: var(--gray-900);
            min-height: 100vh;
            padding: 40px 20px;
            line-height: 1.5;
        }
        
        .install-container {
            max-width: 1000px;
            margin: 0 auto;
            background: white;
            border-radius: 16px;
            box-shadow: var(--shadow-lg);
            overflow: hidden;
        }
        
        .install-header {
            padding: 24px 32px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            color: white;
        }
        
        .install-header h1 {
            font-weight: 600;
            font-size: 24px;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .install-header h1 i {
            font-size: 28px;
        }
        
        .install-body {
            padding: 40px;
        }
        
        .step-indicator {
            display: flex;
            justify-content: space-between;
            margin-bottom: 40px;
            position: relative;
        }
        
        .step-indicator::before {
            content: '';
            position: absolute;
            top: 16px;
            left: 0;
            right: 0;
            height: 2px;
            background: var(--gray-200);
            z-index: 1;
        }
        
        .step {
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            z-index: 2;
        }
        
        .step-number {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: var(--gray-200);
            color: var(--gray-700);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            margin-bottom: 8px;
            transition: all 0.3s;
        }
        
        .step.active .step-number {
            background: var(--primary);
            color: white;
        }
        
        .step.completed .step-number {
            background: var(--success);
            color: white;
        }
        
        .step-label {
            font-size: 14px;
            color: var(--gray-700);
            font-weight: 500;
        }
        
        .step.active .step-label {
            color: var(--primary);
            font-weight: 600;
        }
        
        .step.completed .step-label {
            color: var(--success);
        }
        
        .step-content {
            display: none;
            animation: fadeIn 0.3s ease;
        }
        
        .step-content.active {
            display: block;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .form-group {
            margin-bottom: 24px;
        }
        
        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--gray-700);
        }
        
        .form-control {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid var(--gray-300);
            border-radius: 8px;
            font-size: 15px;
            transition: all 0.2s;
        }
        
        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2);
        }
        
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            border: none;
            font-size: 15px;
            gap: 8px;
        }
        
        .btn-primary {
            background: var(--primary);
            color: white;
        }
        
        .btn-primary:hover {
            background: var(--primary-dark);
        }
        
        .btn-outline {
            background: transparent;
            border: 1px solid var(--gray-300);
            color: var(--gray-700);
        }
        
        .btn-outline:hover {
            background: var(--gray-100);
        }
        
        .btn-success {
            background: var(--success);
            color: white;
        }
        
        .btn-success:hover {
            background: #0d9c6d;
        }
        
        .action-buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 40px;
        }
        
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 4px 8px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 500;
        }
        
        .status-badge.success {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success);
        }
        
        .status-badge.warning {
            background: rgba(245, 158, 11, 0.1);
            color: var(--warning);
        }
        
        .status-badge.danger {
            background: rgba(239, 68, 68, 0.1);
            color: var(--danger);
        }
        
        .requirements-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 24px;
        }
        
        .requirements-table th, 
        .requirements-table td {
            padding: 12px 16px;
            text-align: left;
            border-bottom: 1px solid var(--gray-200);
        }
        
        .requirements-table th {
            font-weight: 600;
            color: var(--gray-700);
            background: var(--gray-100);
        }
        
        .requirements-table tr:hover td {
            background: var(--gray-100);
        }
        
        .progress-container {
            margin: 40px 0;
            text-align: center;
        }
        
        .progress-bar {
            height: 8px;
            background: var(--gray-200);
            border-radius: 4px;
            overflow: hidden;
            margin-bottom: 16px;
        }
        
        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, var(--primary) 0%, var(--success) 100%);
            width: 0;
            transition: width 0.3s ease;
        }
        
        .progress-text {
            font-size: 14px;
            color: var(--gray-700);
        }
        
        .progress-details {
            margin-top: 16px;
            font-size: 13px;
            color: var(--gray-700);
        }
        
        .completion-screen {
            text-align: center;
            padding: 40px 0;
        }
        
        .completion-icon {
            width: 80px;
            height: 80px;
            background: var(--success);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px;
            color: white;
            font-size: 40px;
        }
        
        .completion-title {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 16px;
            color: var(--gray-900);
        }
        
        .completion-message {
            font-size: 16px;
            color: var(--gray-700);
            margin-bottom: 32px;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }
        
        .completion-actions {
            display: flex;
            justify-content: center;
            gap: 16px;
        }
        
        @media (max-width: 768px) {
            .install-body {
                padding: 24px;
            }
            
            .step-indicator {
                gap: 8px;
            }
            
            .step-label {
                font-size: 12px;
                text-align: center;
            }
            
            .action-buttons {
                flex-direction: column-reverse;
                gap: 12px;
            }
            
            .btn {
                width: 100%;
            }
        }
        /* 弹窗样式部分 */
        .custom-alert {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s ease;
        }
        
        .custom-alert.active {
            opacity: 1;
            pointer-events: all;
        }
        
        .custom-alert-box {
            background: white;
            border-radius: 12px;
            width: 90%;
            max-width: 400px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            transform: translateY(20px);
            transition: transform 0.3s ease;
        }
        
        .custom-alert.active .custom-alert-box {
            transform: translateY(0);
        }
        
        .custom-alert-header {
            padding: 16px 24px;
            border-bottom: 1px solid var(--gray-200);
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .custom-alert-body {
            padding: 24px;
            color: var(--gray-700);
        }
        
        .custom-alert-footer {
            padding: 16px 24px;
            border-top: 1px solid var(--gray-200);
            display: flex;
            justify-content: flex-end;
            gap: 12px;
        }
        
        .custom-alert-icon {
            font-size: 24px;
        }
        
        .custom-alert-icon.error {
            color: var(--danger);
        }
        
        .custom-alert-icon.warning {
            color: var(--warning);
        }
        
        .custom-alert-icon.success {
            color: var(--success);
        }
        
        .custom-alert-title {
            font-weight: 600;
            font-size: 18px;
            color: var(--gray-900);
        }
    </style>
</head>
<body>
    <div class="install-container">
        <div class="install-header">
            <h1><i class="mdi mdi-puzzle-outline"></i> 幻影二级域名分发系统 - 安装向导</h1>
        </div>
        
        <div class="install-body">
            <div class="step-indicator">
                <div class="step active" id="step1-indicator">
                    <div class="step-number">1</div>
                    <div class="step-label">环境检查</div>
                </div>
                <div class="step" id="step2-indicator">
                    <div class="step-number">2</div>
                    <div class="step-label">数据库配置</div>
                </div>
                <div class="step" id="step3-indicator">
                    <div class="step-number">3</div>
                    <div class="step-label">导入数据</div>
                </div>
                <div class="step" id="step4-indicator">
                    <div class="step-number">4</div>
                    <div class="step-label">完成安装</div>
                </div>
            </div>
            
            <!-- 步骤1：环境检查 -->
            <div class="step-content active" id="step1-content">
                <h2 style="margin-bottom: 24px; font-weight: 600; color: var(--gray-900);">系统环境检查</h2>
                <p style="margin-bottom: 24px; color: var(--gray-700);">请确保您的服务器满足以下系统要求，以保证系统能够正常运行。</p>
                
                <table class="requirements-table">
                    <thead>
                        <tr>
                            <th>项目</th>
                            <th>要求</th>
                            <th>当前状态</th>
                            <th>说明</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>PHP 8.2+</td>
                            <td>必须</td>
                            <td><?php echo ($PHPVer == '82')?'<span class="status-badge success"><i class="mdi mdi-check"></i> '.PHP_VERSION.'</span>':'<span class="status-badge danger"><i class="mdi mdi-close"></i> '.PHP_VERSION.'</span>'; ?></td>
                            <td>PHP版本支持</td>
                        </tr>
                        <tr>
                            <td>curl_exec()</td>
                            <td>必须</td>
                            <td><?php echo checkfunc('curl_exec', true); ?></td>
                            <td>抓取网页功能</td>
                        </tr>
                        <tr>
                            <td>file_get_contents()</td>
                            <td>必须</td>
                            <td><?php echo checkfunc('file_get_contents', true); ?></td>
                            <td>文件读取功能</td>
                        </tr>
                        <tr>
                            <td>PDO扩展</td>
                            <td>必须</td>
                            <td><?php echo checkclass('PDO', true); ?></td>
                            <td>数据库连接</td>
                        </tr>
                        <tr>
                            <td>fileinfo扩展</td>
                            <td>必须</td>
                            <td><?php echo checkExtension('fileinfo', true); ?></td>  <!-- 这里改成 checkExtension -->
                            <td>文件信息检测</td>
                        </tr>
                        <tr>
                            <td>GD扩展</td>
                            <td>必须</td>
                            <td><?php echo checkExtension('gd', true); ?></td>
                            <td>图片处理</td>
                        </tr>
                        <tr>
                            <td>MySQLi扩展</td>
                            <td>必须</td>
                            <td><?php echo checkExtension('mysqli', true); ?></td>
                            <td>MySQL数据库支持</td>
                        </tr>
                        <tr>
                            <td>OpenSSL扩展</td>
                            <td>必须</td>
                            <td><?php echo checkExtension('openssl', true); ?></td>
                            <td>加密功能</td>
                        </tr>
                        <tr>
                            <td>session支持</td>
                            <td>必须</td>
                            <td><?php echo checkfunc('session_start', true); ?></td>
                            <td>会话管理</td>
                        </tr>
                        
                        <tr>
                            <td>最大执行时间</td>
                            <td>推荐</td>
                            <td>
                                <?php 
                                $maxExecutionTime = ini_get('max_execution_time');
                                if ($maxExecutionTime >= 30 || $maxExecutionTime == 0) {
                                    echo '<span class="status-badge success"><i class="icon-check"></i> ' . $maxExecutionTime . '秒</span>';
                                } else {
                                    echo '<span class="status-badge warning"><i class="icon-close"></i> ' . $maxExecutionTime . '秒</span>';
                                }
                                ?>
                            </td>
                            <td>脚本执行时间</td>
                        </tr>
                        <tr>
                            <td>内存限制</td>
                            <td>推荐</td>
                            <td>
                                <?php 
                                $memoryLimit = ini_get('memory_limit');
                                if (intval($memoryLimit) >= 128 || $memoryLimit == -1) {
                                    echo '<span class="status-badge success"><i class="icon-check"></i> ' . $memoryLimit . '</span>';
                                } else {
                                    echo '<span class="status-badge warning"><i class="icon-close"></i> ' . $memoryLimit . '</span>';
                                }
                                ?>
                            </td>
                            <td>PHP内存限制</td>
                        </tr>
                    </tbody>
                </table>
                
                <div class="action-buttons">
                    <div></div>
                    <button class="btn btn-primary" id="step1-next">下一步 <i class="mdi mdi-arrow-right"></i></button>
                </div>
            </div>
            
            <!-- 步骤2：数据库配置 -->
            <div class="step-content" id="step2-content">
                <h2 style="margin-bottom: 24px; font-weight: 600; color: var(--gray-900);">数据库配置</h2>
                <p style="margin-bottom: 24px; color: var(--gray-700);">请填写您的MySQL数据库连接信息，系统将自动创建所需的数据表。</p>
                
                <form id="db-config-form">
                    <div class="form-group">
                        <label class="form-label">数据库地址</label>
                        <input type="text" name="db_host" value="localhost" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">数据库端口</label>
                        <input type="text" name="db_port" value="3306" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">数据库用户名</label>
                        <input type="text" name="db_user" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">数据库密码</label>
                        <input type="password" name="db_pwd" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">数据库名称</label>
                        <input type="text" name="db_name" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">数据表前缀</label>
                        <input type="text" name="db_qz" value="hywl" class="form-control" required>
                    </div>
                </form>
                
                <div class="action-buttons">
                    <button class="btn btn-outline" id="step2-prev"><i class="mdi mdi-arrow-left"></i> 上一步</button>
                    <button class="btn btn-primary" id="step2-next">下一步 <i class="mdi mdi-arrow-right"></i></button>
                </div>
            </div>
            
            <!-- 步骤3：导入数据 -->
            <div class="step-content" id="step3-content">
                <h2 style="margin-bottom: 24px; font-weight: 600; color: var(--gray-900);">导入数据库</h2>
                <p style="margin-bottom: 24px; color: var(--gray-700);">系统将自动导入所需的数据库结构和初始数据，请耐心等待。</p>
                
                <div class="progress-container">
                    <div class="progress-bar">
                        <div class="progress-fill" id="import-progress"></div>
                    </div>
                    <div class="progress-text" id="progress-text">准备导入...</div>
                    <div class="progress-details" id="progress-details"></div>
                </div>
                
                <div class="action-buttons">
                    <button class="btn btn-outline" id="step3-prev"><i class="mdi mdi-arrow-left"></i> 上一步</button>
                    <button class="btn btn-primary" id="step3-next">开始导入 <i class="mdi mdi-database-import"></i></button>
                </div>
            </div>
            
            <!-- 步骤4：完成安装 -->
            <div class="step-content" id="step4-content">
                <div class="completion-screen">
                    <div class="completion-icon">
                        <i class="mdi mdi-check"></i>
                    </div>
                    <h2 class="completion-title">安装完成</h2>
                    <p class="completion-message">
                        幻影二级域名分发系统已成功安装！<br>
                        默认管理员账号：<strong>admin</strong>，密码：<strong>123456</strong><br>
                        请及时登录后台修改默认密码以保证系统安全。
                    </p>
                    
                    <div class="completion-actions">
                        <a href="../admin" class="btn btn-success"><i class="mdi mdi-monitor-dashboard"></i> 进入后台</a>
                        <a href="../" class="btn btn-primary"><i class="mdi mdi-home"></i> 访问首页</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- 弹窗提示 -->
    <div class="custom-alert" id="customAlert">
        <div class="custom-alert-box">
            <div class="custom-alert-header">
                <i class="mdi custom-alert-icon" id="alertIcon"></i>
                <div class="custom-alert-title" id="alertTitle">提示</div>
            </div>
            <div class="custom-alert-body" id="alertMessage"></div>
            <div class="custom-alert-footer">
                <button class="btn btn-outline" id="alertCancelBtn" style="display: none;">取消</button>
                <button class="btn btn-primary" id="alertConfirmBtn">确定</button>
            </div>
        </div>
    </div>
    <script src="https://static.qiantucdn.com/assets/components/jquery-3.7.1.min.js"></script>
    <script>
        function showAlert(message, title = '提示', type = 'info') {
            const alert = $('#customAlert');
            const icon = $('#alertIcon');
            const alertTitle = $('#alertTitle');
            const alertMessage = $('#alertMessage');
            
            // 设置图标和颜色
            icon.removeClass().addClass('mdi custom-alert-icon');
            switch(type) {
                case 'error':
                    icon.addClass('mdi-alert-circle error');
                    break;
                case 'warning':
                    icon.addClass('mdi-alert warning');
                    break;
                case 'success':
                    icon.addClass('mdi-check-circle success');
                    break;
                default:
                    icon.addClass('mdi-information info');
            }
            
            // 设置标题和内容
            alertTitle.text(title);
            alertMessage.html(message);
            
            // 显示弹窗
            alert.addClass('active');
            
            // 返回一个Promise以便处理确认
            return new Promise((resolve) => {
                $('#alertConfirmBtn').off('click').on('click', function() {
                    alert.removeClass('active');
                    resolve(true);
                });
            });
        }
        $(document).ready(function() {
            // 步骤导航
            function goToStep(step) {
                $('.step-content').removeClass('active');
                $('#step'+step+'-content').addClass('active');
                
                $('.step').removeClass('active completed');
                for (let i = 1; i < step; i++) {
                    $('#step'+i+'-indicator').addClass('completed');
                }
                $('#step'+step+'-indicator').addClass('active');
            }
            
            // 第一步：下一步
            $('#step1-next').click(async function() {
                let hasError = false;
                $('.status-badge.danger').each(function() {
                    if ($(this).closest('tr').find('td:nth-child(2)').text() === '必须') {
                        hasError = true;
                        return false;
                    }
                });
                
                if (hasError) {
                    await showAlert(
                        '您的服务器环境不满足系统要求，请解决所有标红的问题后再继续安装。',
                        '环境检查',
                        'error'
                    );
                    return;
                }
                
                goToStep(2);
            });
            
            // 第二步：上一步
            $('#step2-prev').click(function() {
                goToStep(1);
            });
            
            // 第二步：下一步 - 保存数据库配置
            $('#step2-next').click(function() {
                const formData = $('#db-config-form').serialize();
                
                $('#step2-next').html('<i class="mdi mdi-loading mdi-spin"></i> 检查中...').prop('disabled', true);
                
                $.ajax({
                    type: "POST",
                    url: "ajax.php?act=config_put",
                    data: formData,
                    dataType: "json",
                    success: function(response) {
                        if (response.code == 0) {
                            goToStep(3);
                        } else {
                            showAlert(response.msg, '数据库配置错误', 'error');
                        }
                    },
                    error: function() {
                        showAlert('请求失败，请检查网络连接', '网络错误', 'error');
                    },
                    complete: function() {
                        $('#step2-next').html('下一步 <i class="mdi mdi-arrow-right"></i>').prop('disabled', false);
                    }
                });
            });
            
            // 第三步：上一步
            $('#step3-prev').click(function() {
                goToStep(2);
            });
            
            // 第三步：下一步 - 导入数据库
            $('#step3-next').click(function() {
                $('#step3-next').html('<i class="mdi mdi-loading mdi-spin"></i> 导入中...').prop('disabled', true);
                
                // 模拟进度条更新
                let progress = 0;
                const progressInterval = setInterval(function() {
                    progress += Math.random() * 10;
                    if (progress > 100) progress = 100;
                    
                    $('#import-progress').css('width', progress + '%');
                    $('#progress-text').text('导入中: ' + Math.floor(progress) + '%');
                    
                    if (progress >= 100) {
                        clearInterval(progressInterval);
                        $('#progress-text').text('导入完成，正在处理...');
                    }
                }, 300);
                
                // 实际导入请求
                $.ajax({
                    type: "GET",
                    url: "ajax.php?act=config_dr",
                    dataType: "json",
                    success: function(response) {
                        clearInterval(progressInterval);
                        
                        if (response.code == 0) {
                            $('#import-progress').css('width', '100%');
                            $('#progress-text').text('导入完成！');
                            $('#progress-details').html('<i class="mdi mdi-check-circle" style="color: var(--success);"></i> ' + response.msg);
                            
                            setTimeout(function() {
                                goToStep(4);
                            }, 1500);
                        } else {
                            $('#progress-text').text('导入失败');
                            $('#progress-details').html('<i class="mdi mdi-alert-circle" style="color: var(--danger);"></i> ' + response.msg);
                            $('#step3-next').html('重试导入 <i class="mdi mdi-database-import"></i>').prop('disabled', false);
                        }
                    },
                    error: function() {
                        clearInterval(progressInterval);
                        $('#progress-text').text('请求失败');
                        $('#progress-details').text('无法连接到服务器，请检查网络连接');
                        $('#step3-next').html('重试导入 <i class="mdi mdi-database-import"></i>').prop('disabled', false);
                    }
                });
            });
        });
    </script>
</body>
</html>