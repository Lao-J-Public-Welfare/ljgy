<?php
include("./includes/common.php");
$title='二级域名分发服务平台';


?>

<!-- /**
 * name：index.php
 * 
 * @author     HuanYing
 * @qq        419437697
 * @email     admin@52hyjs.com
 * @website   www.52hyjs.com
 * @date       7/5/2025 4:21:38 PM
 * @version    1.0.0
 * @copyright  Copyright (c) 2025, HuanYing. All rights reserved.
 */ -->


<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title><?php echo $conf['title']; ?> - <?php echo $title; ?></title>
    <meta name="keywords" content="<?php echo $conf['keywords']; ?>"/>
    <meta name="description" content="<?php echo $conf['description']?>">
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
    <meta name="author" content="HuanYing">
    <meta name="founder" content="<?php echo $conf['title']; ?>">
    <!-- <link rel="stylesheet" href="assets/libs/layui/css/layui.css"/>
    <link rel="stylesheet" href="assets/css/main.css"/>
    <link rel="stylesheet" href="assets/css/load.css"/> -->
    <link href="https://fonts.loli.net/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #6366f1;
            --primary-dark: #4f46e5;
            --secondary: #f59e0b;
            --accent: #10b981;
            --text-primary: #111827;
            --text-secondary: #6b7280;
            --text-light: #9ca3af;
            --bg-primary: #ffffff;
            --bg-secondary: #f9fafb;
            --bg-dark: #1f2937;
            --border: #e5e7eb;
            --border-light: #f3f4f6;
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
            --shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
            --radius: 0.75rem;
            --radius-lg: 1rem;
            --radius-xl: 1.5rem;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: var(--bg-primary);
            color: var(--text-primary);
            line-height: 1.6;
            font-weight: 400;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* 加载动画 */
        .page-loading {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: var(--bg-primary);
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .loading-container {
            text-align: center;
        }

        .loading-spinner {
            width: 48px;
            height: 48px;
            border: 3px solid var(--border-light);
            border-top: 3px solid var(--primary);
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto 1rem;
        }

        .loading-text {
            font-size: 0.875rem;
            color: var(--text-secondary);
            font-weight: 500;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* 导航栏 */
        .header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border);
            z-index: 1000;
            padding: 1rem 0;
            transition: all 0.3s ease;
        }

        .header.scrolled {
            background: rgba(255, 255, 255, 0.98);
            box-shadow: var(--shadow-lg);
        }

        .container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 1.5rem;
        }

        .nav {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--text-primary);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .logo-icon {
            width: 32px;
            height: 32px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1rem;
            font-weight: 700;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 2rem;
            list-style: none;
        }

        .nav-links a {
            color: var(--text-secondary);
            text-decoration: none;
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: var(--radius);
            transition: all 0.2s ease;
        }

        .nav-links a:hover {
            color: var(--text-primary);
            background: var(--bg-secondary);
        }

        .nav-links .btn-primary {
            background: var(--primary);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: var(--radius);
            font-weight: 600;
            box-shadow: var(--shadow);
        }

        .nav-links .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
            box-shadow: var(--shadow-lg);
        }

        /* 英雄区域 */
        .hero {
            padding: 8rem 0 6rem;
            background: linear-gradient(135deg, var(--bg-secondary) 0%, var(--bg-primary) 100%);
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                radial-gradient(circle at 20% 80%, rgba(99, 102, 241, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(245, 158, 11, 0.1) 0%, transparent 50%);
            pointer-events: none;
        }

        .hero-content {
            position: relative;
            z-index: 1;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: center;
        }

        .hero-text h1 {
            font-size: clamp(2.5rem, 5vw, 4rem);
            font-weight: 900;
            line-height: 1.1;
            margin-bottom: 1.5rem;
            background: linear-gradient(135deg, var(--text-primary) 0%, var(--primary) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-text p {
            font-size: 1.125rem;
            color: var(--text-secondary);
            margin-bottom: 2.5rem;
            line-height: 1.7;
        }

        .hero-buttons {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.875rem 2rem;
            border: none;
            border-radius: var(--radius);
            font-size: 1rem;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
            box-shadow: var(--shadow);
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .btn-secondary {
            background: var(--bg-primary);
            color: var(--text-primary);
            border: 2px solid var(--border);
        }

        .btn-secondary:hover {
            background: var(--bg-secondary);
            border-color: var(--primary);
            transform: translateY(-2px);
        }

        .hero-visual {
            position: relative;
            height: 500px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .hero-card {
            background: var(--bg-primary);
            border-radius: var(--radius-xl);
            padding: 2rem;
            box-shadow: var(--shadow-xl);
            border: 1px solid var(--border);
            position: relative;
            max-width: 400px;
            width: 100%;
        }

        .hero-card::before {
            content: '';
            position: absolute;
            top: -2px;
            left: -2px;
            right: -2px;
            bottom: -2px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: var(--radius-xl);
            z-index: -1;
            opacity: 0.1;
        }

        .card-header {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1.5rem;
        }

        .card-icon {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--text-primary);
        }

        .card-content {
            color: var(--text-secondary);
            line-height: 1.6;
        }

        /* 特性区域 */
        .features {
            padding: 6rem 0;
            background: var(--bg-primary);
        }

        .section-header {
            text-align: center;
            margin-bottom: 4rem;
        }

        .section-title {
            font-size: clamp(2rem, 4vw, 3rem);
            font-weight: 800;
            color: var(--text-primary);
            margin-bottom: 1rem;
        }

        .section-subtitle {
            font-size: 1.125rem;
            color: var(--text-secondary);
            max-width: 600px;
            margin: 0 auto;
            line-height: 1.6;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 2rem;
        }

        .feature-card {
            background: var(--bg-primary);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            padding: 2.5rem 2rem;
            text-align: center;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        .feature-card:hover::before {
            transform: scaleX(1);
        }

        .feature-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-xl);
            border-color: var(--primary);
        }

        .feature-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 1.5rem;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: var(--radius-lg);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: white;
            position: relative;
        }

        .feature-icon::after {
            content: '';
            position: absolute;
            top: -2px;
            left: -2px;
            right: -2px;
            bottom: -2px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: var(--radius-lg);
            z-index: -1;
            opacity: 0.3;
        }

        .feature-card h3 {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 1rem;
        }

        .feature-card p {
            color: var(--text-secondary);
            line-height: 1.6;
        }

        /* 演示区域 */
        .demo {
            padding: 6rem 0;
            background: var(--bg-secondary);
        }

        .demo-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: center;
        }

        .demo-text h2 {
            font-size: clamp(2rem, 4vw, 3rem);
            font-weight: 800;
            color: var(--text-primary);
            margin-bottom: 1.5rem;
        }

        .demo-text p {
            font-size: 1.125rem;
            color: var(--text-secondary);
            margin-bottom: 2rem;
            line-height: 1.7;
        }

        .demo-visual {
            background: var(--bg-primary);
            border-radius: var(--radius-xl);
            padding: 2rem;
            box-shadow: var(--shadow-xl);
            border: 1px solid var(--border);
            position: relative;
        }

        .demo-visual::before {
            content: '';
            position: absolute;
            top: -2px;
            left: -2px;
            right: -2px;
            bottom: -2px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: var(--radius-xl);
            z-index: -1;
            opacity: 0.1;
        }

        .demo-visual img {
            width: 100%;
            height: auto;
            border-radius: var(--radius);
        }

        /* 页脚 */
        .footer {
            background: var(--bg-dark);
            color: white;
            padding: 4rem 0 2rem;
        }

        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 3rem;
            margin-bottom: 3rem;
        }

        .footer-section h3 {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            color: white;
        }

        .footer-section p {
            color: #d1d5db;
            line-height: 1.6;
            margin-bottom: 0.75rem;
        }

        .footer-section a {
            color: #d1d5db;
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .footer-section a:hover {
            color: var(--primary);
        }

        .footer-section img {
            max-width: 150px;
            border-radius: var(--radius);
            margin-bottom: 1rem;
            border: 2px solid rgba(255, 255, 255, 0.1);
        }

        .footer-copyright {
            text-align: center;
            padding-top: 2rem;
            border-top: 1px solid #374151;
            color: #9ca3af;
        }

        .footer-copyright a {
            color: #9ca3af;
            text-decoration: none;
        }

        .footer-copyright a:hover {
            color: var(--primary);
        }

        /* 响应式设计 */
        @media (max-width: 768px) {
            .container {
                padding: 0 1rem;
            }

            .nav-links {
                display: none;
            }

            .hero-content {
                grid-template-columns: 1fr;
                gap: 3rem;
                text-align: center;
            }

            .demo-content {
                grid-template-columns: 1fr;
                gap: 3rem;
                text-align: center;
            }

            .features-grid {
                grid-template-columns: 1fr;
            }

            .hero-buttons {
                justify-content: center;
            }

            .hero-visual {
                height: auto;
            }
        }

        @media (max-width: 480px) {
            .hero {
                padding: 6rem 0 4rem;
            }

            .features {
                padding: 4rem 0;
            }

            .demo {
                padding: 4rem 0;
            }

            .feature-card {
                padding: 2rem 1.5rem;
            }

            .btn {
                padding: 0.75rem 1.5rem;
                font-size: 0.875rem;
            }
        }
    </style>
</head>
<body>
<div class="page-loading">
    <div class="loading-container">
        <div class="loading-spinner"></div>
        <div class="loading-text">正在加载...</div>
    </div>
</div>

<!-- 导航栏 -->
<header class="header" id="header">
    <div class="container">
        <nav class="nav">
            <a href="./" class="logo">
                <div class="logo-icon">D</div>
                <?php echo $conf['title']; ?>
            </a>
            <ul class="nav-links">
                <li><a href="/">首页</a></li>
                <?php if($islogins==1){ ?>
                <li><a href="user" target="_blank" class="btn-primary">用户中心</a></li>
                <?php } else { ?>
                <li><a href="user/login.php" target="_blank">登录</a></li>
                <li><a href="user/reg.php" target="_blank" class="btn-primary">注册</a></li>
                <?php } ?>
            </ul>
        </nav>
    </div>
</header>

<!-- 英雄区域 -->
<section class="hero">
    <div class="container">
        <div class="hero-content">
            <div class="hero-text">
                <h1><?php echo $conf['title']; ?></h1>
                <p>专业的二级域名分发服务平台，支持阿里、腾讯、西部、华为等各大平台，注册账号即可免费使用，让您的域名管理更加高效便捷。</p>
                <div class="hero-buttons">
                    <a href="user" class="btn btn-secondary" target="_blank">
                        <i class="layui-icon layui-icon-user"></i>
                        立即使用
                    </a>
                </div>
            </div>
            <div class="hero-visual">
                <div class="hero-card">
                    <div class="card-header">
                        <div class="card-icon">
                            <i class="layui-icon layui-icon-app"></i>
                        </div>
                        <div class="card-title">平台特色</div>
                    </div>
                    <div class="card-content">
                        支持多平台域名解析，操作简单，功能强大，让您的域名管理更加高效便捷。
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 特性区域 -->
<section class="features">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">核心优势</h2>
            <p class="section-subtitle">为什么选择我们的平台，我们为您提供最优质的服务体验</p>
        </div>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="layui-icon layui-icon-fonts-code"></i>
                </div>
                <h3>技术创新</h3>
                <p>采用先进的域名解析技术，提供更周全、更稳定、更细致的产品及服务，成为行业软件创新先驱者。</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="layui-icon layui-icon-app"></i>
                </div>
                <h3>多平台支持</h3>
                <p>支持阿里云、腾讯云、西部数码、华为云等各大域名服务商，提供可靠、灵活、安全、可扩展的解决方案。</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="layui-icon layui-icon-cellphone"></i>
                </div>
                <h3>专业服务</h3>
                <p>拥有丰富的行业运营经验，更懂如何解决不同客户的需求，为您提供专业的技术支持和售后服务。</p>
            </div>
        </div>
    </div>
</section>

<!-- 演示区域 -->
<section class="demo">
    <div class="container">
        <div class="demo-content">
            <div class="demo-text">
                <h2>人性化面板</h2>
                <p>我们提供直观易用的管理界面，让您能够一目了然地管理所有域名。操作简单，功能强大，无论是新手还是专业人士都能快速上手。</p>
                <a href="/user" class="btn btn-primary">
                    <i class="layui-icon layui-icon-user"></i>
                    立即体验
                </a>
            </div>
            <div class="demo-visual">
                <img src="<?=TEMPLATE_INDEX;?>/image.png" alt="<?php echo $conf['title']; ?>">
            </div>
        </div>
    </div>
</section>

<!-- 页脚 -->
<footer class="footer">
    <div class="container">
        <div class="footer-content">
            <div class="footer-section">
                <h3>官方交流群</h3>
                <img src="https://api.5aqx.cn/qrcode/api.php?data=<?php echo $conf['qun']; ?>" alt="QQ群二维码">
                <p>扫码免费加入<?php echo $conf['title']; ?>官方交流QQ群，与各位大佬一起交流技术、讨论问题。</p>
            </div>
            <div class="footer-section">
                <h3>联系我们</h3>
                <p>
                    <i class="layui-icon layui-icon-login-qq"></i>
                    <a href="https://wpa.qq.com/msgrd?v=3&uin=<?php echo $conf['qq']; ?>&site=qq&menu=yes&jumpflag=1" target="_blank">QQ: <?php echo $conf['qq']; ?></a>
                </p>
                <p>
                    <i class="layui-icon layui-icon-dialogue"></i>
                    <?php $mail_name = $conf['mail_recv'] ? $conf['mail_recv'] : $conf['mail_name2']; ?>
                    <a href="mailto:<?php echo $mail_name; ?>">邮箱: <?php echo $mail_name; ?></a>
                </p>
                <p>
                    <i class="layui-icon layui-icon-website"></i>
                    <a href="<?php echo $siteurl; ?>">网址: <?php echo $siteurl; ?></a>
                </p>
            </div>
            
        </div>
        <div class="footer-copyright">
            <p>Copyright © <?php echo date('Y');?> <?php echo $_SERVER['HTTP_HOST']; ?>. All rights reserved.</p>
            <p><a href="https://beian.miit.gov.cn/" target="_blank"><?php echo $conf['icp']; ?></a></p>
        </div>
    </div>
</footer>

<script type="text/javascript">
    // 页面加载完成后隐藏加载动画
    window.addEventListener('load', function() {
        setTimeout(function() {
            document.querySelector('.page-loading').style.opacity = '0';
            setTimeout(function() {
                document.querySelector('.page-loading').style.display = 'none';
            }, 300);
        }, 800);
    });
    
    // 导航栏滚动效果
    window.addEventListener('scroll', function() {
        const header = document.getElementById('header');
        if (window.scrollY > 50) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
    });
    
    
    // 特性卡片动画
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);
    
    document.querySelectorAll('.feature-card').forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(30px)';
        card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(card);
    });
</script>
</body>
</html> 