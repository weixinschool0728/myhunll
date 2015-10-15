-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2015 年 10 月 15 日 03:22
-- 服务器版本: 5.6.12-log
-- PHP 版本: 5.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `model_init`
--
CREATE DATABASE IF NOT EXISTS `model_init` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `model_init`;

-- --------------------------------------------------------

--
-- 表的结构 `m_admin_log`
--

CREATE TABLE IF NOT EXISTS `m_admin_log` (
  `log_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `log_time` int(10) unsigned NOT NULL DEFAULT '0',
  `user_id` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `log_info` varchar(255) NOT NULL DEFAULT '',
  `ip_address` varchar(15) NOT NULL DEFAULT '',
  PRIMARY KEY (`log_id`),
  KEY `log_time` (`log_time`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `m_admin_user`
--

CREATE TABLE IF NOT EXISTS `m_admin_user` (
  `user_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `user_name` varchar(60) NOT NULL DEFAULT '',
  `email` varchar(60) NOT NULL DEFAULT '',
  `password` varchar(32) NOT NULL DEFAULT '',
  `ad_salt` varchar(10) DEFAULT NULL,
  `add_time` int(11) NOT NULL DEFAULT '0',
  `last_login` int(11) NOT NULL DEFAULT '0',
  `last_ip` varchar(15) NOT NULL DEFAULT '',
  `action_list` text NOT NULL,
  `nav_list` text NOT NULL,
  `lang_type` varchar(50) NOT NULL DEFAULT '',
  `suppliers_id` smallint(5) unsigned DEFAULT '0',
  `todolist` longtext,
  `role_id` smallint(5) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  KEY `user_name` (`user_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `m_area`
--

CREATE TABLE IF NOT EXISTS `m_area` (
  `area_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `area_name` varchar(90) NOT NULL DEFAULT '',
  `keywords` varchar(255) NOT NULL DEFAULT '',
  `pid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `sort_order` tinyint(1) unsigned NOT NULL DEFAULT '50',
  `deleted` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '删除1 正常0',
  `grade` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`area_id`),
  KEY `pid` (`pid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- 转存表中的数据 `m_area`
--

INSERT INTO `m_area` (`area_id`, `area_name`, `keywords`, `pid`, `sort_order`, `deleted`, `grade`) VALUES
(1, '长沙市', '长沙', 0, 50, 0, 0),
(2, '湘西', '湘西', 0, 50, 0, 0),
(3, '怀化', '怀化', 0, 50, 0, 0),
(4, '芙蓉区', '', 1, 50, 0, 0),
(5, '雨花区', '', 1, 50, 0, 0),
(6, '天心区', '', 1, 50, 0, 0),
(7, '开福区', '', 1, 50, 0, 0),
(8, '岳麓区', '', 1, 50, 0, 0),
(9, '望城县', '', 1, 50, 0, 0),
(10, '宁乡县', '', 1, 50, 0, 0),
(11, '浏阳市', '', 1, 50, 0, 0),
(12, '长沙县', '', 1, 50, 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `m_cart`
--

CREATE TABLE IF NOT EXISTS `m_cart` (
  `cart_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `goods_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `goods_name` varchar(120) NOT NULL DEFAULT '',
  `goods_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `goods_number` smallint(5) unsigned NOT NULL DEFAULT '0',
  `goods_attr` text NOT NULL,
  `fuwushijian` int(10) DEFAULT NULL,
  `goods_attr_id` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`cart_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `m_category`
--

CREATE TABLE IF NOT EXISTS `m_category` (
  `cat_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `cat_name` varchar(90) NOT NULL DEFAULT '',
  `keywords` varchar(255) NOT NULL DEFAULT '',
  `pid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '父类ID',
  `sort_order` tinyint(1) unsigned NOT NULL DEFAULT '50' COMMENT '排序次序',
  `deleted` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '删除1 正常0',
  `shuxing` text NOT NULL COMMENT '属性',
  PRIMARY KEY (`cat_id`),
  KEY `parent_id` (`pid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- 转存表中的数据 `m_category`
--

INSERT INTO `m_category` (`cat_id`, `cat_name`, `keywords`, `pid`, `sort_order`, `deleted`, `shuxing`) VALUES
(1, '策划师', '策划师', 0, 50, 0, 'a:1:{s:6:"风格";a:4:{i:0;s:6:"中式";i:1;s:6:"西式";i:2;s:6:"定制";i:3;s:6:"户外";}}'),
(2, '司仪', '司仪', 0, 50, 0, 'a:3:{s:6:"风格";a:4:{i:0;s:6:"中式";i:1;s:6:"西式";i:2;s:6:"教堂";i:3;s:6:"户外";}s:12:"主持形式";a:4:{i:0;s:12:"搞笑幽默";i:1;s:12:"优雅大方";i:2;s:12:"大气磅礴";i:3;s:12:"综合多变";}s:6:"专业";a:3:{i:0;s:12:"播音专业";i:1;s:12:"电台主持";i:2;s:6:"其它";}}'),
(3, '摄像', '摄像', 0, 50, 0, ''),
(4, '摄影', '摄影', 0, 50, 0, ''),
(5, '车队', '车队', 0, 50, 0, ''),
(6, '跟妆', '跟妆', 0, 50, 0, ''),
(7, '布置', '布置', 0, 50, 0, ''),
(8, '演艺', '演艺', 0, 50, 0, ''),
(9, '舞美', '舞美', 0, 50, 0, ''),
(10, '酒店', '酒店', 0, 50, 0, ''),
(11, '喜铺', '喜铺', 0, 50, 0, '');

-- --------------------------------------------------------

--
-- 表的结构 `m_comment`
--

CREATE TABLE IF NOT EXISTS `m_comment` (
  `comment_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `comment_type` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `user_name` varchar(60) NOT NULL DEFAULT '',
  `content` text NOT NULL,
  `comment_rank` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0',
  `ip_address` varchar(15) NOT NULL DEFAULT '',
  `deleted` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '删除1 审核-1 正常0',
  `goods_id` int(10) unsigned NOT NULL DEFAULT '0',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`comment_id`),
  KEY `goods_id` (`goods_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `m_goods`
--

CREATE TABLE IF NOT EXISTS `m_goods` (
  `goods_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `cat_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '分类ID',
  `area_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '地区ID',
  `user_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '所属店铺',
  `goods_name` varchar(120) NOT NULL DEFAULT '' COMMENT '商品标题',
  `click_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '点击次数',
  `goods_number` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '产品数量',
  `goods_weight` decimal(10,3) unsigned NOT NULL DEFAULT '0.000',
  `yuan_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '原价',
  `price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '售价',
  `promote_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '活动价',
  `promote_start_date` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '活动开始日期',
  `promote_end_date` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '活动结束日期',
  `warn_number` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '警告数量',
  `keywords` varchar(255) NOT NULL DEFAULT '' COMMENT '关键字',
  `goods_desc` text NOT NULL COMMENT '商品详情',
  `goods_img` varchar(255) NOT NULL DEFAULT '' COMMENT '商品图片',
  `comment_number` smallint(16) NOT NULL DEFAULT '0' COMMENT '评论数量',
  `extension_code` varchar(30) NOT NULL DEFAULT '' COMMENT '扩展字段',
  `is_on_sale` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否大减价',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `sort_order` smallint(4) unsigned NOT NULL DEFAULT '100' COMMENT '商品排序',
  `is_delete` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '删除为1',
  `is_best` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `is_new` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `is_hot` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `last_update` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`goods_id`),
  KEY `area_id` (`area_id`),
  KEY `cat_id` (`cat_id`),
  KEY `last_update` (`last_update`),
  KEY `promote_end_date` (`promote_end_date`),
  KEY `promote_start_date` (`promote_start_date`),
  KEY `sort_order` (`sort_order`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `m_goods`
--

INSERT INTO `m_goods` (`goods_id`, `cat_id`, `area_id`, `user_id`, `goods_name`, `click_count`, `goods_number`, `goods_weight`, `yuan_price`, `price`, `promote_price`, `promote_start_date`, `promote_end_date`, `warn_number`, `keywords`, `goods_desc`, `goods_img`, `comment_number`, `extension_code`, `is_on_sale`, `add_time`, `sort_order`, `is_delete`, `is_best`, `is_new`, `is_hot`, `last_update`) VALUES
(1, 12, 0, 0, '12分类产品1', 0, 0, '0.000', '0.00', '0.00', '0.00', 0, 0, 1, '', 'asdas的', 'asdas的', 4, '', 1, 0, 100, 0, 0, 0, 0, 0),
(2, 12, 0, 0, '', 0, 0, '0.000', '0.00', '0.00', '0.00', 0, 0, 1, '', '12商品2', '', 0, '', 1, 0, 100, 0, 0, 0, 0, 0),
(3, 13, 0, 0, '13上平', 0, 0, '0.000', '0.00', '0.00', '0.00', 0, 0, 1, '', '按时打算打算打算打算', '', 0, '', 1, 0, 100, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `m_goods_cat`
--

CREATE TABLE IF NOT EXISTS `m_goods_cat` (
  `goods_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `cat_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`goods_id`,`cat_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `m_order`
--

CREATE TABLE IF NOT EXISTS `m_order` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_no` varchar(32) NOT NULL,
  `user_id` int(11) NOT NULL COMMENT '用户id',
  `cart_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `product_fee` int(11) NOT NULL DEFAULT '0' COMMENT '商品合計金額',
  `goods_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `goods_name` varchar(120) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '订单状态 1生成订单,2完成订单,3取消订单',
  `pay_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '支付方式 0:支付宝 1:微信支付',
  `pay_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '支付状态 0：未支付; 1：已支付;',
  `pay_info` text NOT NULL COMMENT '支付card等信息',
  `trade_no` varchar(255) DEFAULT NULL COMMENT '支付平台交易号',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`order_id`),
  UNIQUE KEY `order_code` (`order_no`),
  KEY `user_order_index` (`user_id`,`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='order' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `m_role`
--

CREATE TABLE IF NOT EXISTS `m_role` (
  `role_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `role_name` varchar(60) NOT NULL DEFAULT '',
  `action_list` text NOT NULL,
  `role_describe` text,
  PRIMARY KEY (`role_id`),
  KEY `user_name` (`role_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `m_users`
--

CREATE TABLE IF NOT EXISTS `m_users` (
  `user_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(60) NOT NULL DEFAULT '' COMMENT '邮箱',
  `open_id` varchar(32) NOT NULL DEFAULT '' COMMENT '用于微信开发',
  `user_name` varchar(60) NOT NULL DEFAULT '' COMMENT '会员名',
  `password` varchar(32) NOT NULL DEFAULT '' COMMENT '密码',
  `question` varchar(255) NOT NULL DEFAULT '' COMMENT '问题',
  `answer` varchar(255) NOT NULL DEFAULT '' COMMENT '答案',
  `sex` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '性别',
  `head_url` varchar(255) NOT NULL COMMENT '头像',
  `birthday` varchar(255) NOT NULL DEFAULT '0' COMMENT '生日',
  `rank_points` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '评分',
  `reg_time` varchar(255) NOT NULL DEFAULT '0' COMMENT '注册时间',
  `last_login` varchar(255) NOT NULL DEFAULT '0' COMMENT '最近登录时间',
  `last_ip` varchar(15) NOT NULL DEFAULT '' COMMENT '最近登录IP',
  `visit_count` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '被访问次数',
  `user_rank` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '用户等级',
  `shopman_id` mediumint(9) NOT NULL DEFAULT '0' COMMENT '0表示普通用户 非0 表示是店主并且是店主信息编号',
  `address` varchar(255) DEFAULT '0' COMMENT '用户详细地址',
  `salt` varchar(10) NOT NULL DEFAULT '0' COMMENT '盐 加密密码',
  `qq` varchar(20) NOT NULL COMMENT 'QQ号码',
  `mobile_phone` varchar(20) NOT NULL COMMENT '手机号就是登录名',
  `is_validated` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否生效0表示生效，其它表示失效',
  `credit_line` decimal(10,2) unsigned NOT NULL COMMENT '账户余额',
  `passwd_question` varchar(50) DEFAULT NULL COMMENT '密码问题',
  `passwd_answer` varchar(255) DEFAULT NULL COMMENT '密码答案',
  `server_form` varchar(21) NOT NULL COMMENT '服务形式',
  `shenfenzheng_url` varchar(255) NOT NULL COMMENT '身份证照地址',
  `yingyezhizhao_url` varchar(255) NOT NULL COMMENT '营业执照照片地址',
  `true_name` varchar(30) NOT NULL COMMENT '真实姓名',
  `location` varchar(255) NOT NULL COMMENT '所在省市区',
  `weixin` varchar(20) NOT NULL COMMENT '微信号码',
  `server_content` varchar(30) NOT NULL COMMENT '服务|内容',
  `shopman_reg_time` varchar(255) NOT NULL DEFAULT '0' COMMENT '婚礼人注册时间',
  PRIMARY KEY (`user_id`,`head_url`),
  UNIQUE KEY `user_name` (`user_name`),
  KEY `email` (`email`),
  KEY `openid` (`open_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='用户表' AUTO_INCREMENT=14 ;

--
-- 转存表中的数据 `m_users`
--

INSERT INTO `m_users` (`user_id`, `email`, `open_id`, `user_name`, `password`, `question`, `answer`, `sex`, `head_url`, `birthday`, `rank_points`, `reg_time`, `last_login`, `last_ip`, `visit_count`, `user_rank`, `shopman_id`, `address`, `salt`, `qq`, `mobile_phone`, `is_validated`, `credit_line`, `passwd_question`, `passwd_answer`, `server_form`, `shenfenzheng_url`, `yingyezhizhao_url`, `true_name`, `location`, `weixin`, `server_content`, `shopman_reg_time`) VALUES
(12, '123456@qq.com', '', '杨靖', '3cc801d53a5b138bf1d725d44151d6e3', '', '', 0, '/Public/Uploads/image/hunliren/20151010/14444645273739883419.jpg', '0', 0, '1444464448', '1444464448', '127.0.0.1', 0, 0, 1, '随便填', 'i~63F,', '123456', '13574506835', 0, '0.00', NULL, NULL, '个人', '/Public/Uploads/image/hunliren/20151010/14444645273838445157.jpg', '', '杨靖', '湖南省|娄底市|冷水江市', '123456', '策划师|司仪', '1444464527'),
(13, '', '', '杨靖1', '62dbea88c65a2522726e78cf896b55b9', '', '', 0, '', '0', 0, '1444562281', '1444562281', '127.0.0.1', 0, 0, 0, '0', 'Y[0@Tz', '', '13574508888', 0, '0.00', NULL, NULL, '', '', '', '', '', '', '', '0');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
