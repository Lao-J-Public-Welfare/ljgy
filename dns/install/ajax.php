<?php
$act = isset($_GET['act']) ? $_GET['act'] : null;
/* 返回内容类型，默认返回JSON */
header('Content-Type: application/json; charset=utf-8');
function Huanying_json($msg) {
    header('Content-Type: application/json; charset=utf-8');
    exit (json_encode($msg, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
}
function random($length, $numeric = 0) {
	$seed = base_convert(md5(microtime().$_SERVER['DOCUMENT_ROOT']), 16, $numeric ? 10 : 35);
	$seed = $numeric ? (str_replace('0', '', $seed).'012340567890') : ($seed.'zZ'.strtoupper($seed));
	$hash = '';
	$max = strlen($seed) - 1;
	for($i = 0; $i < $length; $i++) {
		$hash .= $seed[mt_rand(0, $max)];
	}
	return $hash;
}
switch($act) {
    case 'config_put': //写入数据表文件
	$db_host = isset($_POST['db_host']) ? $_POST['db_host'] : NULL;
	$db_port = isset($_POST['db_port']) ? $_POST['db_port'] : NULL;
	$db_user = isset($_POST['db_user']) ? $_POST['db_user'] : NULL;
	$db_pwd = isset($_POST['db_pwd']) ? $_POST['db_pwd'] : NULL;
	$db_name = isset($_POST['db_name']) ? $_POST['db_name'] : NULL;
	$db_qz = isset($_POST['db_qz']) ? $_POST['db_qz'] : 'hywl';

	if ($db_host == null || $db_port == null || $db_user == null || $db_pwd == null || $db_name == null || $db_qz == null) {
		Huanying_json(['code' => '-1', 'msg' => '保存错误，请确保每项都不为空']);
	} else {
		$config = '<?php
/*数据库配置*/
$dbconfig = [
	"host" => "' . $db_host . '", //数据库服务器
	"port" => ' . $db_port . ', //数据库端口
	"user" => "' . $db_user . '", //数据库用户名
	"pwd" => "' . $db_pwd . '", //数据库密码
	"dbname" => "' . $db_name . '", //数据库名
	"dbqz" => "' . $db_qz . '" //数据表前缀
];
?>';
        try {
            $con = mysqli_connect($db_host, $db_user, $db_pwd, $db_name, $db_port);
            if (!$con) {
                $error_code = mysqli_connect_errno();
                if ($error_code == 2002) {
                    Huanying_json(['code' => '-1', 'msg' => '连接数据库失败，数据库地址填写错误！']);
                } elseif ($error_code == 1045) {
                    Huanying_json(['code' => '-1', 'msg' => '连接数据库失败，数据库用户名或密码填写错误！']);
                } elseif ($error_code == 1044) {
                    Huanying_json(['code' => '-1', 'msg' => '连接数据库失败，数据库名填写错误！']);
                } elseif ($error_code == 1049) {
                    Huanying_json(['code' => '-1', 'msg' => '连接数据库失败，数据库名不存在！']);
                } else {
                    Huanying_json(['code' => '-1', 'msg' => '连接数据库失败，[' . $error_code . ']' . mysqli_connect_error()]);
                }
            } elseif (version_compare(mysqli_get_server_info($con), '5.5.3', '<')) {
                Huanying_json(['code' => '-1', 'msg' => 'MySQL数据库版本太低，需要MySQL 5.6或以上版本！']);
            } elseif (file_put_contents('../includes/config.php', $config)) {
                if (function_exists("opcache_reset")) @opcache_reset();
                Huanying_json(['code' => '0', 'msg' => 'ok']);
            } else {
                Huanying_json(['code' => '-1', 'msg' => '保存失败，请确保网站根目录具有写入权限']);
            }
        } catch (mysqli_sql_exception $e) {
            Huanying_json(['code' => '-1', 'msg' => '连接数据库失败，错误信息：' . $e->getMessage()]);
        }
	}
	break;
	case 'config_dr': //导入数据库
	include_once '../includes/config.php';
	date_default_timezone_set("PRC");
	$date = date("Y-m-d H:i:s");
	$sql=file_get_contents("install.sql");
	$sql=explode(';',$sql);
	$sql[] = "INSERT INTO `pre_config` VALUES ('sqlupdate', '".$date."')";
	$sql[] = "INSERT INTO `pre_config` VALUES ('build', '".$date."')";
	$sql[] = "INSERT INTO `pre_config` VALUES ('cronkey', '".rand(100000,999999)."')";
	$sql[] = "INSERT INTO `pre_config` VALUES ('syskey', '".random(32)."')";
	$cn = mysqli_connect($dbconfig['host'],$dbconfig['user'],$dbconfig['pwd'],$dbconfig['dbname'],$dbconfig['port']);
	if (!$cn) Huanying_json(['code' => '-1', 'msg' => '链接数据库失败:['.mysqli_connect_errno().']'.mysqli_connect_error()]);
	mysqli_query($cn, "set sql_mode = ''");
	mysqli_query($cn, "set names utf8");
	$t=0; $e=0; $error='';
	for($i=0;$i<count($sql);$i++) {
		if (trim($sql[$i])=='')continue;
		if(mysqli_query($cn, str_replace('pre_',$dbconfig['dbqz'].'_',$sql[$i]))) {
			++$t;
		} else {
			++$e;
			$error.=mysqli_error($cn).'<br/>';
		}
	}
	if($e==0) {
	    @file_put_contents("install.lock",'幻影云信息科技程序安装锁');
		Huanying_json(['code' => '0', 'msg' => '安装成功！<br/>SQL成功'.$t.'句/失败'.$e.'句']);
	} else {
		Huanying_json(['code' => '-1', 'msg' => '安装失败<br/>SQL成功'.$t.'句/失败'.$e.'句<br/>错误信息：'.$error]);
	}
	break;
}