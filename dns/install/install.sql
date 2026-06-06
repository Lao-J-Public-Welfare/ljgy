SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- --------------------------------------------------------
-- 表结构 `pre_cache`
-- --------------------------------------------------------
CREATE TABLE `pre_cache` (
  `k` varchar(32) NOT NULL,
  `v` longtext,
  `expire` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`k`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- 表结构 `pre_config`
-- --------------------------------------------------------
CREATE TABLE `pre_config` (
  `k` varchar(32) NOT NULL,
  `v` text,
  PRIMARY KEY (`k`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `pre_config` (`k`, `v`) VALUES
('admin_pwd', '123456'),
('admin_user', 'admin'),
('description', '幻影二级域名分发系统'),
('gg', '本站提供二级域名用于测试、学习等，请勿将二级域名用于一切非法用途，一切责任自负！3元解析一次，用到域名到期！需要积分请联系QQ：123456789'),
('icoimg', '/assets/images/favicon.ico'),
('icp', '备案号'),
('keywords', '幻影二级域名分发系统'),
('logoimg', '/assets/images/logo.png'),
('qq', '419437697'),
('qun', 'https://qm.qq.com/q/Ot9wmFGNC8'),
('recordgg', '绝对禁止解析列如:代刷 ，外挂，侵权视频，侵权游戏，侵权版权，av，灰产，盲盒，假客服，黄赌毒诈骗，支付，码支付，商城等违法违规产品，如有违法违规 本平台会无条件删除所有解析永久封号，购买的积分无法退款，域名一经解析不支持更换域名以及修改前缀。解析即代表同意以上规则，不同意请别购买。'),
('sms_tpl_edit', '尊敬的用户，您本次验证码为：{code}，请勿将验证码提供给他人，请尽快完成操作。若非你本人操作，请忽略。'),
('template', 'mb11'),
('title', '幻影二级域名分发系统'),
('urlkeywords', '幻影,网络科技'),
('workorder_type', '解析问题|域名无法使用|充值没到账');

-- --------------------------------------------------------
-- 表结构 `pre_detailed`
-- --------------------------------------------------------
CREATE TABLE `pre_detailed` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` varchar(150) DEFAULT NULL,
  `type` varchar(20) DEFAULT NULL,
  `before_change` decimal(10,2) NOT NULL DEFAULT '0.00',
  `after_change` decimal(10,2) NOT NULL DEFAULT '0.00',
  `money` decimal(10,2) NOT NULL DEFAULT '0.00',
  `date` datetime NOT NULL,
  `data` text,
  PRIMARY KEY (`id`),
  KEY `idx_uid` (`uid`),
  KEY `idx_date` (`date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- 表结构 `pre_dns`
-- --------------------------------------------------------
CREATE TABLE `pre_dns` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dns` text,
  `config_name` varchar(50) DEFAULT NULL,
  `created_name` varchar(50) DEFAULT NULL,
  `config` text,
  `created` text,
  `remark` varchar(255) DEFAULT NULL,
  `add_time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- 表结构 `pre_email`
-- --------------------------------------------------------
CREATE TABLE `pre_email` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `content` text NOT NULL,
  `addtime` datetime NOT NULL,
  `endtime` datetime NOT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- 表结构 `pre_gonggao`
-- --------------------------------------------------------
CREATE TABLE `pre_gonggao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(11) NOT NULL DEFAULT '0',
  `title` varchar(50) DEFAULT NULL,
  `domain` varchar(150) DEFAULT NULL,
  `content` text,
  `color` varchar(10) DEFAULT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_type` (`type`),
  KEY `idx_date` (`date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------
-- 表结构 `pre_group`
-- --------------------------------------------------------
CREATE TABLE `pre_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(225) DEFAULT NULL,
  `recode` text,
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `zhekou` varchar(50) DEFAULT NULL,
  `endtime` varchar(20) DEFAULT NULL,
  `active` int(1) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `pre_group` (`id`, `name`, `recode`, `price`, `zhekou`, `endtime`, `active`, `date`) VALUES
(100, '默认用户组', 'A,CNAME,AAAA,NS,MX,SRV,TXT,CAA,REDIRECT_URL,FORWARD_URL', '0.00', '100', '默认用户组不可删除可修改', 1, '2025-12-04 17:39:57');

-- --------------------------------------------------------
-- 表结构 `pre_icptype`
-- --------------------------------------------------------
CREATE TABLE `pre_icptype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` text NOT NULL,
  `data` varchar(255) DEFAULT NULL,
  `sort` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `pre_icptype` (`id`, `type`, `data`, `sort`) VALUES
(4, '阿里云备案', '阿里云备案', 1),
(5, '腾讯云企业备案', '腾讯云企业备案', 0);

-- --------------------------------------------------------
-- 表结构 `pre_illegal_record`
-- --------------------------------------------------------
CREATE TABLE `pre_illegal_record` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `record_id` int(11) NOT NULL,
  `username` varchar(64) NOT NULL,
  `url` varchar(255) NOT NULL,
  `record` varchar(255) NOT NULL,
  `keyword` varchar(100) NOT NULL,
  `context` text,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_record_id` (`record_id`),
  KEY `idx_username` (`username`),
  KEY `idx_created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- 表结构 `pre_link`
-- --------------------------------------------------------
CREATE TABLE `pre_link` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) DEFAULT NULL,
  `domain` varchar(150) DEFAULT NULL,
  `img` text,
  `content` text,
  `link_href` tinyint(2) NOT NULL DEFAULT '0',
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_date` (`date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------
-- 表结构 `pre_log`
-- --------------------------------------------------------
CREATE TABLE `pre_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` varchar(150) DEFAULT NULL,
  `name` varchar(20) DEFAULT NULL,
  `date` datetime NOT NULL,
  `ip` varchar(32) DEFAULT NULL,
  `city` varchar(20) DEFAULT NULL,
  `browser` varchar(225) DEFAULT NULL,
  `data` text,
  PRIMARY KEY (`id`),
  KEY `idx_uid` (`uid`),
  KEY `idx_date` (`date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- 表结构 `pre_order`
-- --------------------------------------------------------
CREATE TABLE `pre_order` (
  `trade_no` varchar(64) NOT NULL,
  `out_trade_no` varchar(150) NOT NULL,
  `api_trade_no` varchar(150) NOT NULL,
  `type` varchar(20) DEFAULT NULL,
  `tid` int(11) NOT NULL,
  `uid` int(11) UNSIGNED NOT NULL,
  `name` varchar(64) DEFAULT NULL,
  `money` varchar(32) DEFAULT NULL,
  `ip` varchar(20) DEFAULT NULL,
  `buyer` varchar(30) DEFAULT NULL,
  `addtime` datetime DEFAULT NULL,
  `endtime` datetime DEFAULT NULL,
  `date` date DEFAULT NULL,
  `domain` varchar(64) DEFAULT NULL,
  `status` tinyint(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`trade_no`),
  KEY `idx_uid` (`uid`),
  KEY `idx_status` (`status`),
  KEY `idx_addtime` (`addtime`),
  KEY `idx_out_trade_no` (`out_trade_no`(50))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------
-- 表结构 `pre_other`
-- --------------------------------------------------------
CREATE TABLE `pre_other` (
  `trade_no` varchar(64) NOT NULL,
  `type` varchar(20) DEFAULT NULL,
  `channel` varchar(10) DEFAULT NULL,
  `zid` int(11) UNSIGNED NOT NULL DEFAULT '1',
  `tid` int(11) NOT NULL,
  `input` text NOT NULL,
  `num` int(11) UNSIGNED NOT NULL DEFAULT '1',
  `addtime` datetime DEFAULT NULL,
  `endtime` datetime DEFAULT NULL,
  `name` varchar(64) DEFAULT NULL,
  `money` varchar(32) DEFAULT NULL,
  `ip` varchar(20) DEFAULT NULL,
  `user` varchar(32) DEFAULT NULL,
  `inviteid` int(11) UNSIGNED DEFAULT NULL,
  `domain` varchar(64) DEFAULT NULL,
  `status` tinyint(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`trade_no`),
  KEY `idx_zid` (`zid`),
  KEY `idx_status` (`status`),
  KEY `idx_addtime` (`addtime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- 表结构 `pre_record`
-- --------------------------------------------------------
CREATE TABLE `pre_record` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` varchar(225) DEFAULT NULL,
  `user` varchar(150) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `url` varchar(225) DEFAULT NULL,
  `type` varchar(225) DEFAULT NULL,
  `line` varchar(150) DEFAULT NULL,
  `value` varchar(225) DEFAULT NULL,
  `TTL` varchar(150) DEFAULT NULL,
  `stop` varchar(255) DEFAULT NULL,
  `data` text,
  `status` int(1) NOT NULL DEFAULT '1',
  `add_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `record_type` int(3) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_uid` (`uid`),
  KEY `idx_url` (`url`),
  KEY `idx_status` (`status`),
  KEY `idx_end_time` (`end_time`),
  KEY `idx_record_type` (`record_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- 表结构 `pre_regcode`
-- --------------------------------------------------------
CREATE TABLE `pre_regcode` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT '0',
  `type` int(1) NOT NULL DEFAULT '0',
  `code` varchar(32) NOT NULL,
  `to` varchar(32) DEFAULT NULL,
  `time` int(11) NOT NULL,
  `ip` varchar(20) DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  `errcount` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_code` (`code`),
  KEY `idx_to_type` (`to`,`type`),
  KEY `idx_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- 表结构 `pre_sendlog`
-- --------------------------------------------------------
CREATE TABLE `pre_sendlog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(1) DEFAULT NULL,
  `uid` varchar(150) DEFAULT NULL,
  `name` varchar(20) DEFAULT NULL,
  `date` datetime NOT NULL,
  `ip` varchar(32) DEFAULT NULL,
  `city` varchar(20) DEFAULT NULL,
  `browser` varchar(225) DEFAULT NULL,
  `data` text,
  `status` int(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_type` (`type`),
  KEY `idx_uid` (`uid`),
  KEY `idx_date` (`date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- 表结构 `pre_shop`
-- --------------------------------------------------------
CREATE TABLE `pre_shop` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dns` text,
  `user_uid` int(11) DEFAULT NULL,
  `url_id` varchar(50) DEFAULT NULL,
  `url` varchar(50) DEFAULT NULL,
  `endtime` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_user_uid` (`user_uid`),
  KEY `idx_url_id` (`url_id`),
  KEY `idx_endtime` (`endtime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- 表结构 `pre_url`
-- --------------------------------------------------------
CREATE TABLE `pre_url` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dns_key` varchar(32) NOT NULL,
  `domain_id` varchar(50) NOT NULL,
  `domain` varchar(50) NOT NULL,
  `icptype` int(1) DEFAULT '0',
  `icp` varchar(50) DEFAULT NULL,
  `domain_type` int(1) NOT NULL DEFAULT '0',
  `second_count` int(10) DEFAULT '0',
  `exclusive_count` int(10) DEFAULT NULL,
  `add_time` datetime NOT NULL,
  `state` int(1) DEFAULT NULL,
  `files` varchar(255) DEFAULT NULL,
  `sort` int(10) DEFAULT NULL,
  `cert_force` varchar(255) DEFAULT NULL,
  `qianzhui` varchar(255) DEFAULT NULL,
  `remark` text,
  `description` text,
  `second_prices` text,
  `api_state` tinyint(4) DEFAULT '0',
  `api_price` decimal(10,2) DEFAULT '0.00',
  `exclusive_prices` text,
  PRIMARY KEY (`id`),
  KEY `idx_domain` (`domain`),
  KEY `idx_state` (`state`),
  KEY `idx_sort` (`sort`),
  KEY `idx_domain_type` (`domain_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- 表结构 `pre_user_sign`
-- --------------------------------------------------------
CREATE TABLE `pre_user_sign` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `sign_date` date NOT NULL,
  `sign_time` datetime NOT NULL,
  `points` int(11) DEFAULT 10,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_date` (`user_id`,`sign_date`),
  KEY `idx_user_id` (`user_id`),
  KEY `idx_sign_date` (`sign_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- 表结构 `pre_plugin`
-- --------------------------------------------------------
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

-- --------------------------------------------------------
-- 表结构 `pre_user`
-- --------------------------------------------------------
CREATE TABLE `pre_user` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(32) NOT NULL,
  `pwd` varchar(255) NOT NULL,
  `qq` varchar(20) DEFAULT NULL,
  `rmb` decimal(10,2) NOT NULL DEFAULT '0.00',
  `group` int(11) NOT NULL DEFAULT '100',
  `email` varchar(64) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `dlip` varchar(45) DEFAULT NULL,
  `add_time` datetime DEFAULT NULL,
  `end_time` datetime DEFAULT NULL,
  `cert` tinyint(4) NOT NULL DEFAULT '0',
  `certtype` tinyint(4) NOT NULL DEFAULT '0',
  `certmethod` tinyint(4) NOT NULL DEFAULT '0',
  `certno` varchar(18) DEFAULT NULL,
  `certname` varchar(32) DEFAULT NULL,
  `certtime` datetime DEFAULT NULL,
  `certtoken` varchar(64) DEFAULT NULL,
  `certcorpno` varchar(30) DEFAULT NULL,
  `certcorpname` varchar(80) DEFAULT NULL,
  `cert_cause` text,
  `token` text,
  `apikey` text NOT NULL,
  `qq_uid` varchar(32) DEFAULT NULL,
  `wx_uid` varchar(32) DEFAULT NULL,
  `alipay_uid` varchar(32) DEFAULT NULL,
  `boss` varchar(150) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`uid`),
  UNIQUE KEY `uk_user` (`user`),
  KEY `idx_group` (`group`),
  KEY `idx_email` (`email`),
  KEY `idx_phone` (`phone`),
  KEY `idx_status` (`status`),
  KEY `idx_add_time` (`add_time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- 表结构 `pre_userlog`
-- --------------------------------------------------------
CREATE TABLE `pre_userlog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` varchar(150) DEFAULT NULL,
  `name` varchar(20) DEFAULT NULL,
  `date` datetime NOT NULL,
  `ip` varchar(32) DEFAULT NULL,
  `city` varchar(20) DEFAULT NULL,
  `browser` varchar(225) DEFAULT NULL,
  `data` text,
  PRIMARY KEY (`id`),
  KEY `idx_uid` (`uid`),
  KEY `idx_date` (`date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- 表结构 `pre_workorder`
-- --------------------------------------------------------
CREATE TABLE `pre_workorder` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uid` int(11) UNSIGNED NOT NULL DEFAULT '1',
  `type` int(1) UNSIGNED NOT NULL DEFAULT '0',
  `orderid` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `content` text NOT NULL,
  `picurl` varchar(255) DEFAULT NULL,
  `addtime` datetime NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_uid` (`uid`),
  KEY `idx_status` (`status`),
  KEY `idx_addtime` (`addtime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- 表结构 `pre_messages`
-- --------------------------------------------------------
CREATE TABLE `pre_messages` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uid` bigint(20) UNSIGNED NOT NULL,
  `sender_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `type` text NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_uid` (`uid`),
  KEY `idx_uid_is_read` (`uid`,`is_read`),
  KEY `idx_created` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- 表结构 `pre_notice`
-- --------------------------------------------------------
CREATE TABLE `pre_notice` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `type` text NOT NULL,
  `time` text NOT NULL,
  `message` int(2) NOT NULL,
  `email` int(2) NOT NULL,
  `subject` text,
  `content` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `pre_notice` (`id`, `type`, `time`, `message`, `email`, `subject`, `content`) VALUES
(1, '用户注册成功通知', '用户注册成功后', 1, 1, '用户添加解析', NULL),
(2, '域名解析恢复通知', '域名解析暂停恢复通知', 1, 1, '域名解析恢复通知', NULL),
(3, '登录成功通知', '用户登录成功时', 1, 1, '账号登录提醒', NULL),
(4, '域名解析过期删除通知', '域名解析过期删除时', 1, 1, '域名解析到期通知', NULL),
(5, '域名解析暂停通知', '域名解析暂停时', 1, 1, '域名解析暂停通知', NULL),
(6, '添加解析通知', '添加域名解析时', 1, 1, '域名解析记录添加提醒', NULL),
(7, '修改解析通知', '修改域名解析时', 1, 1, '域名解析记录修改通知', NULL),
(8, '删除解析通知', '用户删除解析时', 1, 1, '域名解析记录删除通知', NULL),
(9, '整租域名到期通知', '整租域名到期时', 1, 1, '整租域名到期通知', NULL),
(10, '会员到期通知', '会员到期时', 1, 1, '会员到期通知', NULL);

-- --------------------------------------------------------
-- 表结构 `pre_dns_diff`
-- --------------------------------------------------------
CREATE TABLE `pre_dns_diff` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL,
  `domain` varchar(255) NOT NULL,
  `type` tinyint(4) NOT NULL,
  `name` varchar(100) NOT NULL,
  `record_type` varchar(10) NOT NULL,
  `value` varchar(255) NOT NULL,
  `cloud_record_id` varchar(50) DEFAULT NULL,
  `remark` text,
  `add_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `status` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_user` (`user`),
  KEY `idx_domain` (`domain`),
  KEY `idx_type` (`type`),
  KEY `idx_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;