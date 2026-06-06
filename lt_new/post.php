<?php
require_once 'config.php';

$post_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if (!$post_id) {
    redirect('index.php');
}

$stmt = $pdo->prepare("SELECT p.*, u.username, u.avatar FROM posts p JOIN users u ON p.user_id = u.id WHERE p.id = ?");
$stmt->execute([$post_id]);
$post = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$post) {
    die('帖子不存在');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['content'])) {
    if (!isLoggedIn()) {
        redirect('login.php');
    }
    $content = trim($_POST['content']);
    if (!empty($content)) {
        $stmt = $pdo->prepare("INSERT INTO comments (post_id, user_id, content, created_at) VALUES (?, ?, ?, NOW())");
        $stmt->execute([$post_id, $_SESSION['user_id'], $content]);
        header("Location: post.php?id=$post_id");
        exit;
    }
}

$stmt = $pdo->prepare("SELECT c.*, u.username, u.avatar FROM comments c JOIN users u ON c.user_id = u.id WHERE c.post_id = ? ORDER BY c.created_at ASC");
$stmt->execute([$post_id]);
$comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($post['title']); ?> - 牢J公益</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { background: #f5f5f5; font-family: sans-serif; }
        .container { max-width: 800px; margin: 0 auto; padding: 20px; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; padding: 20px; background: white; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .logo { font-size: 24px; font-weight: bold; color: #333; }
        .nav a { margin-left: 20px; color: #666; text-decoration: none; }
        .nav a:hover { color: #007bff; }
        .post-card { background: white; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); padding: 30px; margin-bottom: 30px; }
        .post-header { display: flex; align-items: center; margin-bottom: 20px; }
        .avatar { width: 50px; height: 50px; border-radius: 50%; margin-right: 15px; }
        .post-author { font-size: 18px; font-weight: bold; color: #333; }
        .post-time { margin-left: 15px; color: #999; font-size: 14px; }
        .post-title { font-size: 28px; margin-bottom: 20px; color: #333; }
        .post-content { color: #666; line-height: 1.8; margin-bottom: 20px; }
        .post-content img { max-width: 100%; max-height: 400px; display: block; margin: 10px 0; border-radius: 4px; }
        .post-content video { max-width: 100%; max-height: 400px; margin: 10px 0; border-radius: 4px; }
        .post-actions { display: flex; gap: 20px; padding-top: 20px; border-top: 1px solid #eee; }
        .like-btn, .share-btn { cursor: pointer; color: #666; font-size: 14px; padding: 5px 10px; border-radius: 4px; background: none; border: none; }
        .like-btn:hover, .share-btn:hover { background: #f0f0f0; color: #007bff; }
        .like-btn.liked { color: #e74c3c; }
        .like-count { margin-left: 4px; }
        .comment-section { background: white; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); padding: 30px; }
        .comment-form { margin-bottom: 30px; }
        textarea { width: 100%; padding: 15px; border: 1px solid #ddd; border-radius: 4px; font-size: 16px; min-height: 100px; resize: vertical; }
        .btn { padding: 10px 20px; background: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer; }
        .btn:hover { background: #0056b3; }
        .comment { display: flex; gap: 15px; margin-bottom: 20px; padding-bottom: 20px; border-bottom: 1px solid #eee; }
        .comment-avatar { width: 40px; height: 40px; border-radius: 50%; }
        .comment-content { flex: 1; }
        .comment-author { font-weight: bold; color: #333; margin-right: 10px; }
        .comment-time { color: #999; font-size: 12px; }
        .comment-text { margin-top: 5px; color: #666; }
        .footer { text-align: center; margin-top: 40px; padding: 20px; color: #999; border-top: 1px solid #ddd; }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <div class="logo">牢J公益</div>
        <div class="nav">
            <a href="index.php">首页</a>
            <a href="new_post.php">发帖</a>
            <?php if (isLoggedIn()): ?>
                <a href="profile.php"><?php echo $_SESSION['username']; ?></a>
                <a href="logout.php">退出</a>
            <?php else: ?>
                <a href="login.php">登录</a>
                <a href="register.php">注册</a>
            <?php endif; ?>
        </div>
    </div>

    <div class="post-card">
        <div class="post-header">
            <img src="<?php echo getAvatar($post['user_id']); ?>" class="avatar">
            <div>
                <span class="post-author"><?php echo htmlspecialchars($post['username']); ?></span>
                <span class="post-time"><?php echo date('Y-m-d H:i', strtotime($post['created_at'])); ?></span>
            </div>
        </div>
        <h1 class="post-title"><?php echo htmlspecialchars($post['title']); ?></h1>
        <div class="post-content">
            <?php echo nl2br(htmlspecialchars($post['content'])); ?>
            <?php if (!empty($post['images']) && $post['images'] != '[]'): ?>
                <?php $images = json_decode($post['images'], true); ?>
                <?php foreach ($images as $img): ?>
                    <?php if (!empty($img)): ?>
                        <img src="/uploads/images/<?php echo $img; ?>">
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>
            <?php if (!empty($post['video'])): ?>
                <video controls><source src="/uploads/videos/<?php echo $post['video']; ?>"></video>
            <?php endif; ?>
        </div>
        <div class="post-actions">
            <button class="like-btn" data-id="<?php echo $post['id']; ?>" data-type="post">
                点赞 <span class="like-count"><?php echo $post['like_count'] ?? 0; ?></span>
            </button>
            <button class="share-btn" data-url="https://lt.ljgy123.top/go/<?php echo $post['id']; ?>">
    分享
</button>
        </div>
    </div>

    <div class="comment-section">
        <h3 style="margin-bottom: 20px;">评论 (<?php echo count($comments); ?>)</h3>
        <?php if (isLoggedIn()): ?>
        <div class="comment-form">
            <form method="post">
                <textarea name="content" placeholder="写下你的评论..." required></textarea>
                <button type="submit" class="btn">发表评论</button>
            </form>
        </div>
        <?php endif; ?>
        <?php foreach ($comments as $comment): ?>
        <div class="comment">
            <img src="<?php echo getAvatar($comment['user_id']); ?>" class="comment-avatar">
            <div class="comment-content">
                <div>
                    <span class="comment-author"><?php echo htmlspecialchars($comment['username']); ?></span>
                    <span class="comment-time"><?php echo date('Y-m-d H:i', strtotime($comment['created_at'])); ?></span>
                </div>
                <div class="comment-text"><?php echo nl2br(htmlspecialchars($comment['content'])); ?></div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <div class="footer">
        © 2026 牢J公益
    </div>
</div>

<script>
document.querySelectorAll('.like-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const id = this.dataset.id;
        const type = this.dataset.type;
        const countSpan = this.querySelector('.like-count');

        fetch('/like.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `type=${type}&id=${id}&format=json`
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                countSpan.textContent = data.count;
                if (data.liked) {
                    this.classList.add('liked');
                } else {
                    this.classList.remove('liked');
                }
            } else {
                alert('请先登录');
            }
        });
    });
});

document.querySelectorAll('.share-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const url = this.dataset.url;
        if (navigator.share && window.innerWidth <= 768) {
            navigator.share({ title: '牢J公益', url: url });
        } else {
            prompt('分享这个链接给朋友', url);
        }
    });
});
</script>
</body>
</html>
