<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>牢J公益</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'PingFang SC', 'Microsoft YaHei', sans-serif;
            background: #fff;
            color: #333;
            line-height: 1.5;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .header {
            background: white;
            position: sticky;
            top: 0;
            z-index: 100;
            border-bottom: 2px solid #3498db;
        }

        .header-content {
            max-width: 100%;
            margin: 0;
            padding: 16px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: 700;
            color: #3498db;
        }

        .nav a {
            color: #333;
            text-decoration: none;
            margin-left: 32px;
            font-size: 0.9rem;
            transition: 0.2s;
        }

        .nav a:hover {
            color: #3498db;
        }

        .container {
            max-width: 100%;
            margin: 0;
            padding: 40px 24px;
            flex: 1;
        }

        .hero {
            text-align: center;
            padding: 80px 0;
            background: #f8f9fa;
            margin-bottom: 40px;
            border-radius: 8px;
        }

        .hero h1 {
            font-size: 2.5rem;
            font-weight: 600;
            margin-bottom: 16px;
            color: #1a1a1a;
        }

        .hero p {
            font-size: 1rem;
            color: #666;
            max-width: 600px;
            margin: 0 auto 24px;
        }

        .btn {
            display: inline-block;
            background: #3498db;
            color: white;
            padding: 10px 28px;
            border-radius: 4px;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            transition: 0.2s;
            border: none;
            cursor: pointer;
        }

        .btn:hover {
            background: #2980b9;
            transform: translateY(-1px);
        }

        .btn-outline {
            background: transparent;
            border: 1px solid #3498db;
            color: #3498db;
        }

        .btn-outline:hover {
            background: #3498db;
            color: white;
        }

        .stats {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            gap: 32px;
            margin-bottom: 60px;
            text-align: center;
        }

        .stat-item h3 {
            font-size: 2rem;
            font-weight: 700;
            color: #3498db;
        }

        .stat-item p {
            color: #666;
            font-size: 0.85rem;
            margin-top: 8px;
        }

        .section-title {
            font-size: 1.8rem;
            font-weight: 600;
            margin-bottom: 32px;
            padding-bottom: 16px;
            border-bottom: 2px solid #3498db;
            display: inline-block;
            color: #1a1a1a;
        }

        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 24px;
            margin-top: 32px;
        }

        .card {
            background: #fff;
            border-radius: 8px;
            padding: 24px;
            transition: 0.2s;
            border: 1px solid #e0e0e0;
            box-shadow: 0 1px 2px rgba(0,0,0,0.02);
        }

        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 24px rgba(0,0,0,0.08);
            border-color: #3498db;
        }

        .card h3 {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 12px;
            color: #1a1a1a;
        }

        .card p {
            color: #666;
            font-size: 0.85rem;
            margin-bottom: 16px;
            word-break: break-all;
        }

        .card .btn {
            padding: 6px 16px;
            font-size: 0.8rem;
        }

        .partners {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 32px;
            margin-top: 40px;
            text-align: center;
        }

        .partners-grid {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 24px;
            margin-top: 24px;
        }

        .partner-item {
            background: white;
            padding: 8px 24px;
            border-radius: 40px;
            font-size: 0.85rem;
            color: #333;
            border: 1px solid #e0e0e0;
        }

        .join {
            background: #3498db;
            color: white;
            text-align: center;
            padding: 60px 0;
            margin-top: 40px;
            width: 100%;
        }

        .join h2 {
            font-size: 1.8rem;
            margin-bottom: 16px;
            color: white;
        }

        .join p {
            margin-bottom: 32px;
            opacity: 0.9;
            color: white;
        }

        .join .btn {
            background: white;
            color: #3498db;
        }

        .join .btn:hover {
            background: #f0f0f0;
        }

        .footer {
            background: #3498db;
            text-align: center;
            padding: 40px 24px;
            color: white;
            font-size: 0.75rem;
            width: 100%;
        }

        .footer a {
            color: white;
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .services-grid {
                grid-template-columns: 1fr;
            }
            .nav a {
                margin-left: 16px;
            }
            .hero h1 {
                font-size: 1.8rem;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-content">
            <div class="logo">牢J公益</div>
            <div class="nav">
                <a href="#">首页</a>
                <a href="#services">服务</a>
                <a href="#join">加入</a>
            </div>
        </div>
    </div>

    <div class="container">
        <br><br>
        <div class="stats">
            <div class="stat-item"><h3>160+</h3><p>用户</p></div>
            <div class="stat-item"><h3>8+</h3><p>公益服务</p></div>
            <div class="stat-item"><h3>100%</h3><p>免费开放</p></div>
            <div class="stat-item"><h3>110+天</h3><p>运行</p></div>
        </div>

        <div class="services-grid">
            <div class="card"><h3>公益云盘</h3><p>免费云存储，支持WebDAV</p><a href="https://yp.ljgy123.top" class="btn btn-outline">使用</a></div>
            <div class="card"><h3>备用云盘</h3><p>备用的云存储服务</p><a href="https://pan.ljgy123.top" class="btn btn-outline">使用</a></div>
            <div class="card"><h3>论坛</h3><p>开发者交流论坛</p><a href="https://lt.ljgy123.top" class="btn btn-outline">访问</a></div>
            <div class="card"><h3>开放API</h3><p>时间、IP、二维码、TTS语音等接口</p><a href="https://www.ljgy123.top/api/" class="btn btn-outline">API集</a></div>
            <div class="card"><h3>快捷创建网页</h3><p>粘贴HTML代码发布</p><a href="https://e.ljgy123.top" class="btn btn-outline">创建</a></div>
              <div class="card"><h3>公益二级域名</h3><p>免费二级域名分发</p><a href="https://org.ljgy123.top" class="btn btn-outline">使用</a></div>
            <div class="card"><h3>新闻站</h3><p>新闻站</p><a href="https://news.ljgy123.top" class="btn btn-outline">使用</a></div>
            <div class="card"><h3>其他子页面</h3><p>其他页面</p><a href="https://www.ljgy123.top/subpage.html" class="btn btn-outline">使用</a></div>
             <div class="card"><h3>公益广告</h3><p>公益广告，欢迎大家联系官方将您的服务推荐给我们，我们将会根据需求添加到该页面中，或者是向我们推荐一些公益广告！十分感谢！</p><a href="https://www.ljgy123.top/advertisement/" class="btn btn-outline">进入</a></div>
        </div>
    </div>

    <div class="join" id="join">
        <div class="container">
            <h2>加入我们</h2>
            <p>欢迎各公益团队、技术社区及个人开发者交流合作。</p>
            <a href="https://qm.qq.com/q/gsUKE03fuU" class="btn">加入QQ群聊</a>
        </div>
    </div>

    <div class="footer">
        <div class="container">
            <p>© 2026 牢J公益</p>
            <p><a href="https://www.ljgy123.top">https://www.ljgy123.top</a></p>
            <p style="margin-top: 8px;">联系邮箱：<a href="mailto:ljgy@ljgy123.top">ljgy@ljgy123.top</a></p>
        </div>
    </div>
</body>
</html>
