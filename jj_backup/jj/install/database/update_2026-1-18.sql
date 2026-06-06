-- 添加签到表
CREATE TABLE IF NOT EXISTS `pre_user_sign` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `sign_date` date NOT NULL COMMENT '签到日期',
  `sign_time` datetime NOT NULL COMMENT '签到时间',
  `points` int(11) DEFAULT 10 COMMENT '获得积分',
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_date` (`user_id`, `sign_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='签到表'; 

-- 添加DNS插件表
CREATE TABLE `pre_plugin` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '插件ID',
  `name` varchar(50) NOT NULL COMMENT '插件唯一标识（英文名）',
  `showname` varchar(100) NOT NULL COMMENT '插件显示名称',
  `author` varchar(100) DEFAULT NULL COMMENT '作者',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态：0-未启用，1-已启用',
  `config_name` varchar(255) DEFAULT NULL COMMENT '秘钥ID类型',
  `created_name` varchar(255) DEFAULT NULL COMMENT '秘钥token类型',
  `remark` varchar(255) DEFAULT NULL COMMENT '秘钥说明',
  PRIMARY KEY (`id`),
  KEY `idx_status` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COMMENT='插件基本信息表';

-- 更新版本号数据库
INSERT INTO `pre_config` (`k`, `v`) 
VALUES ('sqlupdate', '2026-1-18:00:00') 
ON DUPLICATE KEY UPDATE `v` = '2026-1-18 00:00:00';