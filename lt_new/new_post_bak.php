<?php

$upload_max_size = 10 * 1024 * 1024; 
$allowed_images = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
$allowed_videos = ['video/mp4', 'video/webm', 'video/ogg'];
require_once 'config.php';

if (!isLoggedIn()) {
    redirect('login.php');
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    
    if (empty($title) || empty($content)) {
        $error = '标题和内容不能为空';
    } else {
        
        $images = [];
        if (!empty($_FILES['images']['name'][0])) {
            $upload_dir = 'uploads/images/';
            if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
            
            foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
                if ($_FILES['images']['error'][$key] == 0) {
                    $finfo = finfo_open(FILEINFO_MIME_TYPE);
                    $mime = finfo_file($finfo, $tmp_name);
                    finfo_close($finfo);

                    if (in_array($mime, $allowed_images) && $_FILES['images']['size'][$key] <= $upload_max_size) {
                        $ext = pathinfo($_FILES['images']['name'][$key], PATHINFO_EXTENSION);
                        $filename = uniqid() . '.' . $ext;
                        move_uploaded_file($tmp_name, $upload_dir . $filename);
                        $images[] = $filename;
                    }
                }
            }
        }

        
        $video = '';
        if (!empty($_FILES['video']['name']) && $_FILES['video']['error'] == 0) {
            $upload_dir = 'uploads/videos/';
            if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
            
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime = finfo_file($finfo, $_FILES['video']['tmp_name']);
            finfo_close($finfo);

            if (in_array($mime, $allowed_videos) && $_FILES['video']['size'] <= 50 * 1024 * 1024) {
                $ext = pathinfo($_FILES['video']['name'], PATHINFO_EXTENSION);
                $filename = uniqid() . '.' . $ext;
                move_uploaded_file($_FILES['video']['tmp_name'], $upload_dir . $filename);
                $video = $filename;
            }
        }

        
        $stmt = $pdo->prepare("INSERT INTO posts (user_id, title, content, images, video) VALUES (?, ?, ?, ?, ?)");
        if ($stmt->execute([$_SESSION['user_id'], $title, $content, json_encode($images), $video])) {
            redirect('index.php');
        } else {
            $error = '发帖失败，请稍后重试';
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>发帖 - 牢J公益</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { background: #f5f5f5; font-family: sans-serif; }
        .container { max-width: 800px; margin: 0 auto; padding: 20px; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; padding: 20px; background: white; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .logo { font-size: 24px; font-weight: bold; color: #333; }
        .nav a { margin-left: 20px; color: #666; text-decoration: none; }
        .nav a:hover { color: #007bff; }
        .card { background: white; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); padding: 30px; }
        h1 { margin-bottom: 30px; color: #333; }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 5px; color: #666; }
        input, textarea { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 16px; }
        textarea { height: 200px; resize: vertical; }
        button { padding: 12px 30px; background: #007bff; color: white; border: none; border-radius: 4px; font-size: 16px; cursor: pointer; }
        button:hover { background: #0056b3; }
        .error { color: #dc3545; margin-bottom: 15px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">牢J公益</div>
            <div class="nav">
                <a href="index.php">首页</a>
                <a href="new_post.php">发帖</a>
                <a href="profile.php"><?php echo $_SESSION['username']; ?></a>
                <a href="logout.php">退出</a>
            </div>
        </div>

        <div class="card">
            <h1>发布新帖子</h1>
            <?php if ($error): ?>
                <div class="error"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            <form method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label>标题</label>
                    <input type="text" name="title" required>
                </div>
                <div class="form-group">
                    <label>内容</label>
                    <textarea name="content" required></textarea>
                </div>
                <div class="form-group">
                    <label>上传图片（最多5张）</label>
                    <input type="file" name="images[]" accept="image/*" multiple>
                    <small style="color:#999;">支持 jpg/png/gif/webp，每张不超过10MB</small>
                </div>
                <div class="form-group">
                    <label>上传视频（最多1个）</label>
                    <input type="file" name="video" accept="video/*">
                    <small style="color:#999;">支持 mp4/webm/ogg，不超过50MB</small>
                </div>
                <button type="submit">发布</button>
            </form>
        </div>
    </div>
</body>
</html>
