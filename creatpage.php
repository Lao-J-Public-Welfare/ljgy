<?php




$baseDir = '/opt/data/user_pages/';  
$maxFolders = 10;  


if (!is_dir($baseDir)) {
    mkdir($baseDir, 0755, true);
}

$message = '';
$messageType = '';
$newUrl = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $folder = trim($_POST['folder'] ?? '');
    $filename = trim($_POST['filename'] ?? '');
    $code = $_POST['code'] ?? '';
    
    
    if (!preg_match('/^[a-zA-Z0-9_-]+$/', $folder)) {
        $message = '文件夹名只能包含字母、数字、下划线、短横线';
        $messageType = 'error';
    }
    
    elseif (!preg_match('/^[a-zA-Z0-9_.-]+$/', $filename)) {
        $message = '文件名只能包含字母、数字、下划线、短横线、点';
        $messageType = 'error';
    }
    elseif (preg_match('/\.php$/i', $filename)) {
        $message = '禁止创建 PHP 文件';
        $messageType = 'error';
    }
    else {
        
        $existingFolders = glob($baseDir . '*', GLOB_ONLYDIR);
        if (count($existingFolders) >= $maxFolders && !is_dir($baseDir . $folder)) {
            $message = "最多只能创建 {$maxFolders} 个文件夹";
            $messageType = 'error';
        } else {
            
            $targetDir = $baseDir . $folder;
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0755, true);
            }
            
            
            $filePath = $targetDir . '/' . $filename;
            
            
            $code = preg_replace('/<\?php/i', '&lt;?php', $code);
            $code = preg_replace('/<\?=/i', '&lt;?=', $code);
            
            if (file_put_contents($filePath, $code)) {
                
                if ($filename === 'index.html' || $filename === 'index.htm') {
                    $newUrl = "https:
                } else {
                    $newUrl = "https:
                }
                $message = "创建成功！";
                $messageType = 'success';
            } else {
                $message = '写入失败，请检查目录权限';
                $messageType = 'error';
            }
        }
    }
}


$pages = [];
foreach (glob($baseDir . '*', GLOB_ONLYDIR) as $folderPath) {
    $folder = basename($folderPath);
    foreach (glob($folderPath . '/*.{html,htm}', GLOB_BRACE) as $filePath) {
        $filename = basename($filePath);
        if ($filename === 'index.html' || $filename === 'index.htm') {
            $url = "https:
        } else {
            $url = "https:
        }
        $pages[] = [
            'folder' => $folder,
            'file' => $filename,
            'url' => $url
        ];
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>牢J公益 · 自助建站</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { background: #ffffff; font-family: sans-serif; display: flex; justify-content: center; align-items: center; min-height: 100vh; }
        .container { max-width: 700px; width: 100%; padding: 20px; }
        .card { background: white; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); padding: 30px; }
        h1 { text-align: center; margin-bottom: 10px; color: #333; }
        .sub { text-align: center; color: #666; font-size: 14px; margin-bottom: 25px; }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 5px; color: #666; font-weight: 500; }
        input[type=text], textarea { 
            width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 4px; font-size: 14px; 
            font-family: monospace;
        }
        textarea { min-height: 250px; resize: vertical; font-family: 'Courier New', monospace; }
        input:focus, textarea:focus { outline: none; border-color: #007bff; }
        button { 
            width: 100%; padding: 12px; background: #007bff; color: white; border: none; 
            border-radius: 4px; font-size: 16px; cursor: pointer; 
        }
        button:hover { background: #0056b3; }
        .success { 
            margin-bottom: 20px; padding: 12px; background: #d4edda; color: #155724; 
            border: 1px solid #c3e6cb; border-radius: 4px; 
        }
        .error { 
            margin-bottom: 20px; padding: 12px; background: #f8d7da; color: #721c24; 
            border: 1px solid #f5c6cb; border-radius: 4px; 
        }
        .tip {
            background: #fff3cd;
            border: 1px solid #ffeeba;
            padding: 12px;
            border-radius: 4px;
            font-size: 13px;
            margin-bottom: 20px;
            color: #856404;
        }
        .result-link {
            margin-top: 15px;
            padding: 12px;
            background: #e8f0fe;
            border-radius: 4px;
            word-break: break-all;
        }
        .result-link a {
            color: #007bff;
            text-decoration: none;
        }
        .result-link a:hover {
            text-decoration: underline;
        }
        .pages-list {
            margin-top: 25px;
            border-top: 1px solid #eee;
            padding-top: 20px;
        }
        .pages-list h3 {
            font-size: 16px;
            margin-bottom: 15px;
            color: #333;
        }
        .page-item {
            background: #f9f9f9;
            padding: 10px 12px;
            border-radius: 4px;
            margin-bottom: 8px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            font-size: 13px;
        }
        .page-info {
            font-family: monospace;
            color: #666;
        }
        .page-link {
            color: #007bff;
            text-decoration: none;
            font-size: 12px;
        }
        .page-link:hover {
            text-decoration: underline;
        }
        .back {
            text-align: center;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }
        .back a {
            color: #007bff;
            text-decoration: none;
            font-size: 14px;
        }
        .back a:hover {
            text-decoration: underline;
        }
        code {
            background: #f5f5f5;
            padding: 2px 5px;
            border-radius: 3px;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <h1>牢J公益 · 自助建站</h1>
            <div class="sub">粘贴代码，立刻上线 | 免费网页托管</div>

            <?php if ($message): ?>
                <div class="<?php echo $messageType; ?>">
                    <?php echo htmlspecialchars($message); ?>
                    <?php if ($newUrl): ?>
                        <div class="result-link">
                            访问地址：<a href="<?php echo $newUrl; ?>" target="_blank"><?php echo $newUrl; ?></a>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <div class="tip">
                提示：<br>
                • 文件夹名和文件名只能用 字母、数字、下划线、短横线<br>
                • 不支持 PHP 文件（安全限制）<br>
                • 最多只能建 <?php echo $maxFolders; ?> 个文件夹<br>
                • 如果文件名是 index.html，访问文件夹路径即可<br>
                • 文件夹名全局唯一，先到先得
            </div>

            <form method="post">
                <div class="form-group">
                    <label>文件夹名（全局唯一）</label>
                    <input type="text" name="folder" placeholder="例如：myblog、test、2024" required pattern="[a-zA-Z0-9_-]+">
                </div>
                <div class="form-group">
                    <label>文件名</label>
                    <input type="text" name="filename" placeholder="例如：index.html、about.html" required pattern="[a-zA-Z0-9_.-]+">
                </div>
                <div class="form-group">
                    <label>网页代码（HTML/CSS/JS）</label>
                    <textarea name="code" placeholder="粘贴你的 HTML 代码..."></textarea>
                </div>
                <button type="submit">立即发布</button>
            </form>

            <?php if (!empty($pages)): ?>
                <div class="pages-list">
                    <h3>已创建的页面</h3>
                    <?php foreach ($pages as $page): ?>
                        <div class="page-item">
                            <span class="page-info"><?php echo htmlspecialchars($page['folder']); ?> / <?php echo htmlspecialchars($page['file']); ?></span>
                            <a href="<?php echo $page['url']; ?>" target="_blank" class="page-link">访问</a>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <div class="back">
                <a href="ping.php">去在线Ping</a> | 
                <a href="dlj.php">去短链接</a>
            </div>
        </div>
    </div>
</body>
</html>
