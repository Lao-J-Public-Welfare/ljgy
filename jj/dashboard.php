<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

$user_id = $_SESSION['user_id'];

function call_cf_api($subdomain, $type, $content, $method = 'POST', $record_id = null) {
    $zone_id = CF_ZONE_ID;
    $token = CF_API_TOKEN;
    $full_name = $subdomain . '.' . BASE_DOMAIN;
    
    $data = json_encode([
        'type' => $type,
        'name' => $full_name,
        'content' => $content,
        'ttl' => 300,
        'proxied' => true
    ]);
    
    $url = "https://api.cloudflare.com/client/v4/zones/$zone_id/dns_records";
    if ($method == 'PUT' && $record_id) {
        $url .= "/$record_id";
    }
    
    $cmd = "curl -s -X $method '$url' \\
            -H 'Authorization: Bearer $token' \\
            -H 'Content-Type: application/json' \\
            --data '$data'";
    
    $output = shell_exec($cmd);
    $result = json_decode($output, true);
    
    return isset($result['success']) && $result['success'] === true;
}

function get_cf_record_id($subdomain) {
    $zone_id = CF_ZONE_ID;
    $token = CF_API_TOKEN;
    $full_name = $subdomain . '.' . BASE_DOMAIN;
    
    $cmd = "curl -s -X GET 'https://api.cloudflare.com/client/v4/zones/$zone_id/dns_records?name=" . urlencode($full_name) . "' \\
            -H 'Authorization: Bearer $token' \\
            -H 'Content-Type: application/json'";
    
    $output = shell_exec($cmd);
    $result = json_decode($output, true);
    
    if ($result && $result['success'] && !empty($result['result'])) {
        return $result['result'][0]['id'];
    }
    return null;
}

// 处理编辑
if (isset($_GET['edit'])) {
    $stmt = $pdo->prepare("SELECT * FROM domains WHERE id = ? AND user_id = ?");
    $stmt->execute([$_GET['edit'], $user_id]);
    $edit_domain = $stmt->fetch();
}

// 处理更新
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_id'])) {
    $id = $_POST['update_id'];
    $new_subdomain = strtolower(trim($_POST['subdomain']));
    $new_target = trim($_POST['target']);
    $new_type = $_POST['type'];
    
    // 获取旧域名信息
    $stmt = $pdo->prepare("SELECT subdomain FROM domains WHERE id = ? AND user_id = ?");
    $stmt->execute([$id, $user_id]);
    $old = $stmt->fetch();
    
    if ($old) {
        // 检查新子域名是否被其他域名占用
        $stmt = $pdo->prepare("SELECT id FROM domains WHERE subdomain = ? AND user_id != ?");
        $stmt->execute([$new_subdomain, $user_id]);
        if ($stmt->fetch()) {
            $error = "子域名已被占用";
        } else {
            // 删除旧CF记录
            $old_record_id = get_cf_record_id($old['subdomain']);
            if ($old_record_id) {
                $zone_id = CF_ZONE_ID;
                $token = CF_API_TOKEN;
                $cmd = "curl -s -X DELETE 'https://api.cloudflare.com/client/v4/zones/$zone_id/dns_records/$old_record_id' \\
                        -H 'Authorization: Bearer $token'";
                shell_exec($cmd);
            }
            
            // 添加新CF记录
            if (call_cf_api($new_subdomain, $new_type, $new_target)) {
                $stmt = $pdo->prepare("UPDATE domains SET subdomain = ?, target = ?, type = ? WHERE id = ?");
                $stmt->execute([$new_subdomain, $new_target, $new_type, $id]);
                $success = "修改成功";
                unset($edit_domain);
            } else {
                $error = "DNS修改失败";
            }
        }
    }
}

// 处理添加
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['subdomain']) && !isset($_POST['update_id'])) {
    $subdomain = strtolower(trim($_POST['subdomain']));
    $target = trim($_POST['target']);
    $type = $_POST['type'];
    
    // 检查数量限制
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM domains WHERE user_id = ?");
    $stmt->execute([$user_id]);
    $count = $stmt->fetchColumn();
    
    if ($count >= MAX_DOMAINS) {
        $error = "已达上限（" . MAX_DOMAINS . "个）";
    } else {
        // 检查子域名是否已被占用
        $stmt = $pdo->prepare("SELECT id FROM domains WHERE subdomain = ?");
        $stmt->execute([$subdomain]);
        if ($stmt->fetch()) {
            $error = "子域名已被占用";
        } else {
            if (call_cf_api($subdomain, $type, $target)) {
                $stmt = $pdo->prepare("INSERT INTO domains (user_id, subdomain, target, type) VALUES (?, ?, ?, ?)");
                $stmt->execute([$user_id, $subdomain, $target, $type]);
                $success = "添加成功";
            } else {
                $error = "DNS添加失败";
            }
        }
    }
}

// 处理删除
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $pdo->prepare("SELECT subdomain FROM domains WHERE id = ? AND user_id = ?");
    $stmt->execute([$id, $user_id]);
    $domain = $stmt->fetch();
    
    if ($domain) {
        $record_id = get_cf_record_id($domain['subdomain']);
        if ($record_id) {
            $zone_id = CF_ZONE_ID;
            $token = CF_API_TOKEN;
            $cmd = "curl -s -X DELETE 'https://api.cloudflare.com/client/v4/zones/$zone_id/dns_records/$record_id' \\
                    -H 'Authorization: Bearer $token'";
            shell_exec($cmd);
        }
        $stmt = $pdo->prepare("DELETE FROM domains WHERE id = ? AND user_id = ?");
        $stmt->execute([$id, $user_id]);
    }
    header('Location: dashboard.php');
    exit;
}

// 获取域名列表
$stmt = $pdo->prepare("SELECT * FROM domains WHERE user_id = ?");
$stmt->execute([$user_id]);
$domains = $stmt->fetchAll();
$used_count = count($domains);

// 获取用户邮箱
$stmt = $pdo->prepare("SELECT email FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();
if (!$user) {
    session_destroy();
    header('Location: index.php');
    exit;
}
$email = $user['email'];
?>
<!DOCTYPE html>
<html>
<head><title>我的域名 - 牢J公益</title>
<style>
*{margin:0;padding:0;box-sizing:border-box}
body{font-family:system-ui;background:#f0f2f5;padding:20px}
.container{max-width:800px;margin:0 auto}
.card{background:white;border-radius:12px;padding:24px;margin-bottom:20px;box-shadow:0 2px 8px rgba(0,0,0,0.1)}
h1{color:#3498db;margin-bottom:8px}
h2{font-size:18px;margin-bottom:16px;color:#333}
.user-info{color:#666;margin-bottom:20px;padding-bottom:10px;border-bottom:1px solid #eee}
.form-group{margin-bottom:15px}
label{display:block;margin-bottom:5px;font-weight:600}
input,select{width:100%;padding:10px;border:1px solid #ddd;border-radius:6px;margin-bottom:15px}
button{background:#3498db;color:white;border:none;padding:10px 20px;border-radius:6px;cursor:pointer}
.domain-list{list-style:none;margin-top:20px}
.domain-list li{display:flex;justify-content:space-between;align-items:center;padding:12px 0;border-bottom:1px solid #eee}
.edit-btn{background:#f39c12;padding:4px 12px;font-size:12px;border-radius:4px;color:white;text-decoration:none;margin-right:5px}
.delete-btn{background:#e74c3c;padding:4px 12px;font-size:12px;border-radius:4px;color:white;text-decoration:none}
.error{color:#e74c3c;margin-bottom:15px}
.success{color:#27ae60;margin-bottom:15px}
.logout{float:right;color:#666;text-decoration:none}
.limit-info{background:#e8f4f8;padding:10px;border-radius:6px;margin-bottom:20px}
small{color:#888}
</style>
</head>
<body>
<div class="container">
<div class="card">
<h1>牢J公益 · 域名分发</h1>
<div class="user-info">
<?php echo htmlspecialchars($email); ?>
<a href="logout.php" class="logout">退出</a>
</div>
<div class="limit-info">
已使用 <?php echo $used_count; ?> / <?php echo MAX_DOMAINS; ?> 个域名
</div>

<?php if (isset($edit_domain)): ?>
<h2>编辑域名</h2>
<form method="post">
<input type="hidden" name="update_id" value="<?php echo $edit_domain['id']; ?>">
<div class="form-group">
<label>记录类型</label>
<select name="type" required>
<option value="A" <?php echo $edit_domain['type'] == 'A' ? 'selected' : ''; ?>>A记录（指向IP）</option>
<option value="CNAME" <?php echo $edit_domain['type'] == 'CNAME' ? 'selected' : ''; ?>>CNAME记录（指向域名）</option>
</select>
</div>
<div class="form-group">
<label>子域名前缀</label>
<input type="text" name="subdomain" value="<?php echo htmlspecialchars($edit_domain['subdomain']); ?>" required>
<small>.<?php echo BASE_DOMAIN; ?></small>
</div>
<div class="form-group">
<label>目标地址</label>
<input type="text" name="target" value="<?php echo htmlspecialchars($edit_domain['target']); ?>" required>
</div>
<button type="submit">保存修改</button>
<a href="dashboard.php" style="margin-left:10px;color:#666;">取消</a>
</form>
<?php elseif ($used_count < MAX_DOMAINS): ?>
<h2>申请新域名</h2>
<form method="post">
<div class="form-group">
<label>记录类型</label>
<select name="type" required>
<option value="A">A记录（指向IP）</option>
<option value="CNAME">CNAME记录（指向域名）</option>
</select>
</div>
<div class="form-group">
<label>子域名前缀</label>
<input type="text" name="subdomain" placeholder="例如: myblog" required>
<small>.<?php echo BASE_DOMAIN; ?></small>
</div>
<div class="form-group">
<label>目标地址</label>
<input type="text" name="target" placeholder="A记录填IP，CNAME填域名" required>
</div>
<button type="submit">申请</button>
</form>
<?php else: ?>
<div class="error">已达上限，无法继续申请</div>
<?php endif; ?>

<?php if (isset($error)) echo "<div class='error'>$error</div>"; ?>
<?php if (isset($success)) echo "<div class='success'>$success</div>"; ?>
</div>

<div class="card">
<h2>我的域名列表</h2>
<?php if (empty($domains)): ?>
<p style="color:#888;">暂无域名</p>
<?php else: ?>
<ul class="domain-list">
<?php foreach ($domains as $d): ?>
<li>
<div>
<strong><?php echo htmlspecialchars($d['subdomain']); ?>.<?php echo BASE_DOMAIN; ?></strong>
<br><small>类型: <?php echo $d['type']; ?> | 指向: <?php echo htmlspecialchars($d['target']); ?></small>
</div>
<div>
<a href="?edit=<?php echo $d['id']; ?>" class="edit-btn">编辑</a>
<a href="?delete=<?php echo $d['id']; ?>" class="delete-btn" onclick="return confirm('确定删除？')">删除</a>
</div>
</li>
<?php endforeach; ?>
</ul>
<?php endif; ?>
</div>
</div>
</body>
</html>
