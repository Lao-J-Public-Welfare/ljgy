<?php
if(!defined('IN_CRONLITE'))exit();
class Template {

	static public function getList($type = 'index'){
		// 根据类型获取对应目录下的模板列表
		$dir = TEMPLATE_ROOT . $type . '/';
		$dirArray = array();
		
		if (is_dir($dir) && false != ($handle = opendir($dir))) {
            while (false !== ($file = readdir($handle))) {
                if ($file != "." && $file != ".." && is_dir($dir . $file)) {
                    $dirArray[] = $file;
                }
            }
            closedir($handle);
        }
        return $dirArray;
	}

	static public function load($type, $template_name, $page = 'index'){
		global $conf;
		
		// 允许的模板类型
		$allowed_types = array('index', 'login');
		
		$type = strtolower($type);
		
		if(in_array($type, $allowed_types)){
    		// 安全验证
    		if(!preg_match('/^[a-zA-Z0-9]+$/', $template_name)) exit('error');
    		if(!preg_match('/^[a-zA-Z0-9_]+$/', $page)) exit('error');
    		
    		// 构建文件路径
    		$filename = TEMPLATE_ROOT . $type . '/' . $template_name . '/' . $page . '.php';
    		
    		// 如果是index类型，检查是否有默认模板
    		if($type == 'index'){
    			$default_template = isset($conf['template']) && $conf['template'] ? $conf['template'] : 'default';
    			$filename_default = TEMPLATE_ROOT . $type . '/' . $default_template . '/' . $page . '.php';
    		}
    		// 如果是login类型，检查是否有登录模板配置，没有则使用默认模板default
    		else if($type == 'login'){
    			// 直接使用配置的登录模板，如果没有配置则使用默认模板default
    			$login_template = isset($conf['login_template']) && $conf['login_template'] ? $conf['login_template'] : 'default';
    			$filename_default = TEMPLATE_ROOT . $type . '/' . $login_template . '/' . $page . '.php';
    		}
    		
    		if(file_exists($filename)){
    			return $filename;
    		}elseif(isset($filename_default) && file_exists($filename_default)){
    			return $filename_default;
    		}else{
    			// 尝试查找最基础的默认模板
    			$fallback_file = TEMPLATE_ROOT . $type . '/default/' . $page . '.php';
    			if(file_exists($fallback_file)){
    				return $fallback_file;
    			}else{
    				sysmsg('<h3>找不到模板文件！</h3><p>文件路径: ' . htmlspecialchars($filename) . '</p>');
    			}
    		}
    	}else{
    		exit('不支持的模板类型！');
    	}
	}

	static public function exists($template_name, $type = 'index'){
		// 检查模板是否存在
		$filename = TEMPLATE_ROOT . $type . '/' . $template_name . '/index.php';
		return file_exists($filename);
	}
	
	// 获取模板的配置信息
	static public function getConfig($template_name, $type = 'index'){
		$config_file = TEMPLATE_ROOT . $type . '/' . $template_name . '/config.php';
		if(file_exists($config_file)){
			return include $config_file;
		}
		return array(
			'zuozhe' => '未知作者',
			'version' => '1.0',
			'jieshao' => '无介绍'
		);
	}
	
	// 获取模板的图片路径
	static public function getImagePath($template_name, $type = 'index'){
		$image_file = TEMPLATE_ROOT . $type . '/' . $template_name . '/image.png';
		// 如果存在返回相对路径，否则返回默认图片
		if(file_exists($image_file)){
			return '/template/' . $type . '/' . $template_name . '/image.png';
		}
		return '/template/noimage.png'; // 返回一个默认图片路径
	}
	
	// 获取当前使用的前台模板名称
	static public function getCurrentTemplate(){
		global $conf;
		return isset($conf['template']) ? $conf['template'] : 'mb11';
	}
	
	// 获取当前使用的登录模板名称
	static public function getLoginTemplate(){
		global $conf;
		// 优先使用登录模板配置，否则使用默认模板mb11
		return isset($conf['login_template']) ? $conf['login_template'] : 'mb11';
	}
	
	// 简化的加载方法，保持与原代码兼容
	static public function loadIndex($name = 'index'){
		return self::load('index', self::getCurrentTemplate(), $name);
	}
	
	static public function loadLogin($name = 'login'){
		return self::load('login', self::getLoginTemplate(), $name);
	}
	
	// 新增：直接加载指定模板的页面
	static public function loadTemplatePage($template_name, $page, $type = 'index'){
		return self::load($type, $template_name, $page);
	}
	
	// 新增：便捷方法
	static public function loadRegister(){
		return self::loadLogin('reg');
	}
	
	static public function loadForget(){
		return self::loadLogin('findpwd');
	}
}