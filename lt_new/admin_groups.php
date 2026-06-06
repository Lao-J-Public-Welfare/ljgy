<?php
require_once 'config.php';

if (!isAdmin()) {
    redirect('index.php');
}


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete'])) {
    $id = (int)$_POST['id'];
    $pdo->prepare("DELETE FROM groups WHERE id = ?")->execute([$id]);
    header("Location: admin_groups.php");
    exit;
}

$groups = $pdo->query("SELECT g.*, c.name as category_name FROM groups g LEFT JOIN categories c ON g.category_id = c.id ORDER BY g.id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head><title>小组管理</title></head>
<body>
<h1>小组管理</h1>
<form method="post">
    <input type="text" name="name" placeholder="小组名称" required>
    <textarea name="description" placeholder="简介"></textarea>
    <button type="submit" name="add">添加</button>
</form>
<table border="1">
    <?php foreach ($groups as $g): ?>
    <tr>
        <td><?php echo $g['id']; ?></td>
        <td><?php echo $g['name']; ?></td>
        <td><?php echo $g['category_name']; ?></td>
        <td>
            <form method="post" onsubmit="return confirm('删除？')">
                <input type="hidden" name="id" value="<?php echo $g['id']; ?>">
                <button type="submit" name="delete">删除</button>
            </form>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
</body>
</html>
