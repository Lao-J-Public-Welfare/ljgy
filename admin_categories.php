<?php
require_once 'config.php';

if (!isAdmin()) {
    redirect('index.php');
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add'])) {
        $name = trim($_POST['name']);
        $description = trim($_POST['description']);
        if (!empty($name)) {
            $pdo->prepare("INSERT INTO categories (name, description) VALUES (?, ?)")->execute([$name, $description]);
        }
    } elseif (isset($_POST['edit'])) {
        $id = (int)$_POST['id'];
        $name = trim($_POST['name']);
        $description = trim($_POST['description']);
        if (!empty($name)) {
            $pdo->prepare("UPDATE categories SET name = ?, description = ? WHERE id = ?")->execute([$name, $description, $id]);
        }
    } elseif (isset($_POST['delete'])) {
        $id = (int)$_POST['id'];
        $pdo->prepare("DELETE FROM categories WHERE id = ?")->execute([$id]);
    }
    header("Location: admin_categories.php");
    exit;
}


$categories = $pdo->query("
    SELECT c.*,
           (SELECT COUNT(*) FROM groups WHERE id = c.id) as group_count,
           (SELECT COUNT(*) FROM posts WHERE id = c.id) as post_count
    FROM categories c
    ORDER BY c.id DESC
")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>分类管理 - 牢J公益</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { background: #f5f5f5; font-family: sans-serif; }
        .container { max-width: 1000px; margin: 0 auto; padding: 20px; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; padding: 20px; background: white; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .logo { font-size: 24px; font-weight: bold; color: #333; }
        .nav a { margin-left: 20px; color: #666; text-decoration: none; }
        .nav a:hover { color: #007bff; }
        .card { background: white; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); padding: 30px; margin-bottom: 20px; }
        h1 { margin-bottom: 20px; color: #333; }
        h2 { margin-bottom: 15px; color: #333; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; color: #666; }
        input, textarea { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 16px; }
        textarea { height: 80px; resize: vertical; }
        .btn { padding: 10px 20px; background: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer; }
        .btn:hover { background: #218838; }
        .btn-small { padding: 5px 10px; font-size: 12px; margin-right: 5px; }
        .btn-edit { background: #ffc107; color: #333; }
        .btn-edit:hover { background: #e0a800; }
        .btn-delete { background: #dc3545; color: white; }
        .btn-delete:hover { background: #c82333; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #eee; }
        th { background: #f5f5f5; }
        .edit-form { display: none; margin-top: 10px; padding: 15px; background: #f5f5f5; border-radius: 4px; }
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
                <a href="profile.php"><?php echo $_SESSION['username']; ?></a>
                <a href="admin.php">管理</a>
                <a href="logout.php">退出</a>
            </div>
        </div>

        <div class="card">
            <h1>分类管理</h1>

            <h2>添加新分类</h2>
            <form method="post">
                <div class="form-group">
                    <input type="text" name="name" placeholder="分类名称" required>
                </div>
                <div class="form-group">
                    <textarea name="description" placeholder="分类描述"></textarea>
                </div>
                <button type="submit" name="add" class="btn">添加分类</button>
            </form>

            <h2 style="margin-top:30px;">现有分类</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>名称</th>
                        <th>描述</th>
                        <th>小组数</th>
                        <th>帖子数</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($categories as $cat): ?>
                    <tr>
                        <td><?php echo $cat['id']; ?></td>
                        <td><?php echo htmlspecialchars($cat['name']); ?></td>
                        <td><?php echo htmlspecialchars($cat['description'] ?? ''); ?></td>
                        <td><?php echo $cat['group_count']; ?></td>
                        <td><?php echo $cat['post_count']; ?></td>
                        <td>
                            <button class="btn-small btn-edit" onclick="showEditForm(<?php echo $cat['id']; ?>)">编辑</button>
                            <form method="post" style="display:inline;" onsubmit="return confirm('确定删除该分类？所有关联的小组和帖子将变为未分类！')">
                                <input type="hidden" name="id" value="<?php echo $cat['id']; ?>">
                                <button type="submit" name="delete" class="btn-small btn-delete">删除</button>
                            </form>
                        </td>
                    </tr>
                    <tr id="edit-form-<?php echo $cat['id']; ?>" style="display:none;">
                        <td colspan="6">
                            <div class="edit-form">
                                <form method="post">
                                    <input type="hidden" name="id" value="<?php echo $cat['id']; ?>">
                                    <div class="form-group">
                                        <input type="text" name="name" value="<?php echo htmlspecialchars($cat['name']); ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <textarea name="description"><?php echo htmlspecialchars($cat['description'] ?? ''); ?></textarea>
                                    </div>
                                    <button type="submit" name="edit" class="btn-small">保存</button>
                                    <button type="button" class="btn-small btn-edit" onclick="hideEditForm(<?php echo $cat['id']; ?>)">取消</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="footer">
            © 2026 牢J公益
        </div>
    </div>

    <script>
        function showEditForm(id) {
            document.getElementById('edit-form-' + id).style.display = 'table-row';
        }
        function hideEditForm(id) {
            document.getElementById('edit-form-' + id).style.display = 'none';
        }
    </script>
</body>
</html>
