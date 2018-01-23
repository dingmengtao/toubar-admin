-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: 2018-01-21 11:59:49
-- 服务器版本： 5.7.19
-- PHP Version: 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `toubar-admin`
--

-- --------------------------------------------------------

--
-- 表的结构 `investor`
--

DROP TABLE IF EXISTS `investor`;
CREATE TABLE IF NOT EXISTS `investor` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '用户（投资人）id',
  `user_id` int(11) UNSIGNED NOT NULL COMMENT '用户id',
  `name` varchar(30) NOT NULL COMMENT '用户名',
  `company` varchar(300) DEFAULT NULL COMMENT '所在机构',
  `job` varchar(300) DEFAULT NULL COMMENT '职位',
  `telephone` varchar(50) NOT NULL COMMENT '手机号',
  `img_url` varchar(300) DEFAULT NULL COMMENT '用户（投资人）头像路径',
  `identify_one_url` varchar(300) DEFAULT NULL COMMENT '用户（投资人）名片路径1',
  `identify_two_url` varchar(300) DEFAULT NULL COMMENT '用户（投资人）名片路径2',
  `isaudit` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否审核（0否，1是（默认））',
  `isshow` int(1) DEFAULT '1' COMMENT '是否前台显示（1：是，0否）',
  `delete_time` int(11) DEFAULT NULL COMMENT '删除时间',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  `update_time` int(11) DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `investor`
--

INSERT INTO `investor` (`id`, `user_id`, `name`, `company`, `job`, `telephone`, `img_url`, `identify_one_url`, `identify_two_url`, `isaudit`, `isshow`, `delete_time`, `create_time`, `update_time`) VALUES
(8, 3, '丁梦涛', '杭州应韦科技有限公司', 'PHP开发', '15237179191', '20171219/5a38c97972f5bYd0roYb.jpg', '20171219/5a38c97972f5bYd0roYb.jpg', NULL, 1, 1, NULL, 1513671033, 1513671033),
(9, 3, '丁梦涛', '杭州应韦科技有限公司', 'PHP开发', '15237179192', '20171219/5a38cd0d918baXk5oV44.jpg', '20171219/5a38cd0d918baXk5oV44.jpg', NULL, 1, 1, NULL, 1513671949, 1513671949),
(10, 3, '张三', '杭州滨江', '总经理', '15237179193', '20171227/5a43616a01af7yOTsN3RzFCw7a5BqLzk.jpg', '20171227/5a43616c5b494lqEpeBq4Viu1KWVuzwl.png', NULL, 1, 1, NULL, 1514365333, 1514365333),
(11, 3, '王胖子', '陕西考古研究所', '考古研究员', '15237179195', '20171229/5a45b4fba88a4coWbjIqukBQueEXusYW.jpg', '20171229/5a45b4fbad73bonNCeFR8EBemvbw18PO.png', NULL, 1, 1, NULL, 1514517758, 1514517758),
(12, 3, '吴邪', '杭州土夫子古物研究所', '富二代研究员', '15237179194', '20171229/5a45ce85b635cJ8Wsf5XiagBTjBtZ3CE.jpg', '20171229/5a45cea9646579AYXSXxGreGmGnZIXRx.png', NULL, 1, 1, NULL, 1514524352, 1514524352);

-- --------------------------------------------------------

--
-- 表的结构 `investor_trade`
--

DROP TABLE IF EXISTS `investor_trade`;
CREATE TABLE IF NOT EXISTS `investor_trade` (
  `investor_id` int(11) UNSIGNED NOT NULL,
  `trade_id` int(11) UNSIGNED NOT NULL,
  `delete_time` int(11) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`investor_id`,`trade_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `investor_trade`
--

INSERT INTO `investor_trade` (`investor_id`, `trade_id`, `delete_time`, `create_time`, `update_time`) VALUES
(8, 1, NULL, 1513671033, 1513671033),
(8, 2, NULL, 1513671033, 1513671033),
(8, 3, NULL, 1513671033, 1513671033),
(9, 1, NULL, 1513671949, 1513671949),
(9, 2, NULL, 1513671949, 1513671949),
(9, 3, NULL, 1513671949, 1513671949),
(10, 3, NULL, 1514365334, 1514365334),
(10, 9, NULL, 1514365334, 1514365334),
(10, 12, NULL, 1514365334, 1514365334),
(11, 5, NULL, 1514517758, 1514517758),
(11, 7, NULL, 1514517758, 1514517758),
(11, 11, NULL, 1514517758, 1514517758),
(12, 4, NULL, 1514524352, 1514524352),
(12, 7, NULL, 1514524352, 1514524352);

-- --------------------------------------------------------

--
-- 表的结构 `item`
--

DROP TABLE IF EXISTS `item`;
CREATE TABLE IF NOT EXISTS `item` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '项目id',
  `user_id` int(11) UNSIGNED NOT NULL COMMENT '对应用户id',
  `name` varchar(300) NOT NULL COMMENT '项目名称',
  `stage_id` int(11) UNSIGNED NOT NULL COMMENT '融资阶段',
  `telephone` varchar(50) NOT NULL COMMENT '联系电话',
  `bp_url` varchar(300) NOT NULL COMMENT '项目BP路径',
  `video_url` varchar(300) DEFAULT NULL COMMENT '项目视频路径',
  `img_url` varchar(300) DEFAULT NULL COMMENT '视频第一帧图片',
  `isgood` tinyint(1) DEFAULT '0' COMMENT '精选项目字段（0非精选，1精选）',
  `isaudit` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否审核（0费审核，1审核（默认））',
  `isshow` int(1) DEFAULT '1' COMMENT '是否前台显示（1：是，0否）',
  `delete_time` int(11) DEFAULT NULL COMMENT '删除时间',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  `update_time` int(11) DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COMMENT='项目相关';

--
-- 转存表中的数据 `item`
--

INSERT INTO `item` (`id`, `user_id`, `name`, `stage_id`, `telephone`, `bp_url`, `video_url`, `img_url`, `isgood`, `isaudit`, `isshow`, `delete_time`, `create_time`, `update_time`) VALUES
(9, 2, 'test', 1, '15237179193', '', '20171219/5a38ce413fa1a4LOyb5i.mp4', '20171219/5a38c97972777g10FIzm.png', 1, 1, 1, NULL, 1513672257, 1513672257),
(10, 2, 'test', 1, '15237179193', '', '20171219/5a38de50d2dd1kLe3fXT.mp4', '20171219/5a38c97972777g10FIzm.png', 1, 1, 1, NULL, 1513676369, 1513676369),
(12, 2, '互联网应用', 3, '15237179193', '', '20171227/5a4338f860d2bu3FtXqPiK3SZRwxTKW1.mp4', '20171227/5a4338f860d2bu3FtXqPiK3SZRwxTKW1.jpg', 0, 1, 1, NULL, 1514354943, 1514354943),
(13, 2, '医疗大数据服务', 4, '15237179193', '', '20171227/5a43396c0350bTTvIbbKq4OWGF2Wqxy5.mp4', '20171227/5a43396c0350bTTvIbbKq4OWGF2Wqxy5.jpg', 0, 1, 1, NULL, 1514355056, 1514355056),
(14, 2, '影视募资', 5, '15237179193', '', '20171227/5a4339f012f14BE5av75Wow4XCj7p0uP.mp4', '20171227/5a4339f012f14BE5av75Wow4XCj7p0uP.jpg', 0, 1, 1, NULL, 1514355188, 1514355188),
(15, 2, '高端地产', 6, '15237179193', '', '20171227/5a433abf99680TMycTbxI3pKal2RSda7.mp4', '20171227/5a433abf99680TMycTbxI3pKal2RSda7.jpg', 0, 1, 1, NULL, 1514355393, 1514355393),
(16, 2, '智慧教育', 5, '15237179193', '', '20171228/5a448b00e0d29ekbJ77yzzSChchGk4AD.mp4', '20171228/5a448b00e0d29ekbJ77yzzSChchGk4AD.jpg', 0, 1, 1, NULL, 1514441479, 1514441479),
(17, 2, '影视投资', 4, '15237179193', '', '20171228/5a448b6e3b0b9L9dZky2j14pJz3Ombkd.mp4', '20171228/5a448b6e3b0b9L9dZky2j14pJz3Ombkd.jpg', 0, 1, 1, NULL, 1514441584, 1514441584),
(18, 2, '考古设备研究', 4, '15237179193', '', '20171229/5a45a2807b516egWn0weePx4D3LwOwac.mp4', '20171229/5a45a2807b516egWn0weePx4D3LwOwac.jpg', 0, 1, 1, NULL, 1514513094, 1514513094),
(19, 2, '路桥工程', 2, '15237179193', '', '20171229/5a45a2fa51292MbeS9QZ5VSzENDqE0Vx.mp4', '20171229/5a45a2fa51292MbeS9QZ5VSzENDqE0Vx.jpg', 0, 1, 1, NULL, 1514513150, 1514513150),
(20, 2, '高端实验室建设', 3, '15237179193', '', '20171229/5a45a43e5e0aceAHVKUBEtRhCo3qaXyh.mp4', '20171229/5a45a43e5e0aceAHVKUBEtRhCo3qaXyh.jpg', 0, 1, 1, NULL, 1514513474, 1514513474),
(21, 2, '智能检测设备', 6, '15237179193', '', '20171229/5a45d8db8d621HYAiqG21Yseh3CEaU1f.mp4', '20171229/5a45d8db8d621HYAiqG21Yseh3CEaU1f.jpg', 0, 1, 1, NULL, 1514526942, 1514526942),
(22, 2, '高分子材料研究', 6, '15237179193', '', '20171229/5a45e75e2db62QOcpr7JRpnN0WrlrLES.mp4', '20171229/5a45e75e2db62QOcpr7JRpnN0WrlrLES.jpg', 0, 1, 1, NULL, 1514530654, 1514530654),
(23, 2, '重工器械研发', 3, '15237179193', '', '20171229/5a45e939b33caf6seApAML1yWapsVCxU.mp4', '20171229/5a45e939b33caf6seApAML1yWapsVCxU.jpg', 0, 1, 1, NULL, 1514531286, 1514531286);

-- --------------------------------------------------------

--
-- 表的结构 `item_trade`
--

DROP TABLE IF EXISTS `item_trade`;
CREATE TABLE IF NOT EXISTS `item_trade` (
  `item_id` int(11) UNSIGNED NOT NULL COMMENT '项目id',
  `trade_id` int(11) UNSIGNED NOT NULL COMMENT '行业id',
  `delete_time` int(11) DEFAULT NULL COMMENT '删除时间',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  `update_time` int(11) DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`item_id`,`trade_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='项目与所属行业中间表';

--
-- 转存表中的数据 `item_trade`
--

INSERT INTO `item_trade` (`item_id`, `trade_id`, `delete_time`, `create_time`, `update_time`) VALUES
(9, 1, NULL, 1513672257, 1513672257),
(9, 2, NULL, 1513672257, 1513672257),
(9, 3, NULL, 1513672257, 1513672257),
(10, 1, NULL, 1513676369, 1513676369),
(10, 2, NULL, 1513676369, 1513676369),
(10, 3, NULL, 1513676369, 1513676369),
(11, 4, NULL, 1514354731, 1514354731),
(11, 8, NULL, 1514354731, 1514354731),
(11, 11, NULL, 1514354731, 1514354731),
(12, 3, NULL, 1514354943, 1514354943),
(12, 9, NULL, 1514354943, 1514354943),
(12, 12, NULL, 1514354943, 1514354943),
(13, 2, NULL, 1514355056, 1514355056),
(13, 3, NULL, 1514355056, 1514355056),
(13, 10, NULL, 1514355056, 1514355056),
(14, 4, NULL, 1514355188, 1514355188),
(14, 5, NULL, 1514355188, 1514355188),
(14, 9, NULL, 1514355188, 1514355188),
(15, 5, NULL, 1514355393, 1514355393),
(15, 6, NULL, 1514355393, 1514355393),
(15, 11, NULL, 1514355393, 1514355393),
(16, 4, NULL, 1514441479, 1514441479),
(16, 8, NULL, 1514441479, 1514441479),
(16, 10, NULL, 1514441479, 1514441479),
(17, 4, NULL, 1514441584, 1514441584),
(17, 11, NULL, 1514441584, 1514441584),
(17, 12, NULL, 1514441584, 1514441584),
(18, 5, NULL, 1514513095, 1514513095),
(18, 7, NULL, 1514513095, 1514513095),
(18, 10, NULL, 1514513095, 1514513095),
(19, 4, NULL, 1514513150, 1514513150),
(19, 5, NULL, 1514513150, 1514513150),
(19, 11, NULL, 1514513150, 1514513150),
(20, 3, NULL, 1514513474, 1514513474),
(20, 5, NULL, 1514513474, 1514513474),
(20, 10, NULL, 1514513474, 1514513474),
(21, 3, NULL, 1514526942, 1514526942),
(21, 10, NULL, 1514526942, 1514526942),
(21, 12, NULL, 1514526942, 1514526942),
(22, 5, NULL, 1514530654, 1514530654),
(22, 6, NULL, 1514530654, 1514530654),
(22, 10, NULL, 1514530654, 1514530654),
(23, 4, NULL, 1514531286, 1514531286),
(23, 7, NULL, 1514531286, 1514531286),
(23, 10, NULL, 1514531286, 1514531286);

-- --------------------------------------------------------

--
-- 表的结构 `stage`
--

DROP TABLE IF EXISTS `stage`;
CREATE TABLE IF NOT EXISTS `stage` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '融资阶段id',
  `name` varchar(50) NOT NULL COMMENT '融资阶段名称',
  `isshow` int(1) NOT NULL DEFAULT '1' COMMENT '是否前台显示（1：是，0否）',
  `delete_time` int(11) DEFAULT NULL COMMENT '删除时间',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  `update_time` int(11) DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='融资阶段相关';

--
-- 转存表中的数据 `stage`
--

INSERT INTO `stage` (`id`, `name`, `isshow`, `delete_time`, `create_time`, `update_time`) VALUES
(1, '全部阶段', 1, NULL, 1513050322, 1513050322),
(2, '种子轮', 1, NULL, 1513050322, 1513050322),
(3, '天使轮', 1, NULL, 1513050322, 1513050322),
(4, 'Pre-A轮', 1, NULL, 1513050322, 1513050322),
(5, 'A轮', 1, NULL, 1513050322, 1513050322),
(6, 'B轮', 1, NULL, 1513050322, 1513050322);

-- --------------------------------------------------------

--
-- 表的结构 `trade`
--

DROP TABLE IF EXISTS `trade`;
CREATE TABLE IF NOT EXISTS `trade` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '行业id',
  `name` varchar(50) NOT NULL COMMENT '行业名称',
  `isshow` int(1) NOT NULL DEFAULT '1' COMMENT '是否前台显示（1：是，0否）',
  `type` varchar(50) DEFAULT 'circle' COMMENT '类型',
  `delete_time` int(11) DEFAULT NULL COMMENT '删除时间',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  `update_time` int(11) DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `trade`
--

INSERT INTO `we_trade` (`id`, `name`, `status`, `type`, `delete_time`, `create_time`, `update_time`) VALUES
(1, '全部项目', 1, 'circle', NULL, 1513050322, 1513050322),
(2, '新零售', 1, 'circle', NULL, 1513050322, 1513050322),
(3, '互联网', 1, 'circle', NULL, 1513050322, 1513050322),
(4, '电子商务', 1, 'circle', NULL, 1513050322, 1513050322),
(5, '金融', 1, 'circle', NULL, 1513050322, 1513050322),
(6, '企业服务', 1, 'circle', NULL, 1513050322, 1513050322),
(7, '大数据', 1, 'circle', NULL, 1513050322, 1513050322),
(8, '云计算', 1, 'circle', NULL, 1513050322, 1513050322),
(9, '物联网', 1, 'circle', NULL, 1513050322, 1513050322),
(10, '生活消费', 1, 'circle', NULL, 1513050322, 1513050322),
(11, '消费升级', 1, 'circle', NULL, 1513050322, 1513050322),
(12, '文化娱乐', 1, 'circle', NULL, 1513050322, 1513050322),
(13, '教育培训', 1, 'circle', NULL, 1513050322, 1513050322),
(14, '房产家居', 1, 'circle', NULL, 1513050322, 1513050322),
(15, '交通出行', 1, 'circle', NULL, 1513050322, 1513050322),
(16, '智能驾驶', 1, 'circle', NULL, 1513050322, 1513050322),
(17, '网络安全', 1, 'circle', NULL, 1513050322, 1513050322),
(18, '共享经济', 1, 'circle', NULL, 1513050322, 1513050322),
(19, 'AR/VR', 1, 'circle', NULL, 1513050322, 1513050322),
(20, '无人机', 1, 'circle', NULL, 1513050322, 1513050322),
(21, '人工智能', 1, 'circle', NULL, 1513050322, 1513050322),
(22, '机器人', 1, 'circle', NULL, 1513050322, 1513050322),
(23, '医疗健康', 1, 'circle', NULL, 1513050322, 1513050322),
(24, '生物医药', 1, 'circle', NULL, 1513050322, 1513050322),
(25, '节能环保', 1, 'circle', NULL, 1513050322, 1513050322),
(26, '智能硬件', 1, 'circle', NULL, 1513050322, 1513050322),
(27, '社交网络', 1, 'circle', NULL, 1513050322, 1513050322),
(28, '媒体营销', 1, 'circle', NULL, 1513050322, 1513050322),
(29, '工具软件', 1, 'circle', NULL, 1513050322, 1513050322),
(30, '游戏动漫', 1, 'circle', NULL, 1513050322, 1513050322),
(31, '物流运输', 1, 'circle', NULL, 1513050322, 1513050322),
(32, '新能源', 1, 'circle', NULL, 1513050322, 1513050322),
(33, '新农业', 1, 'circle', NULL, 1513050322, 1513050322),
(34, '新材料', 1, 'circle', NULL, 1513050322, 1513050322),
(35, '智能制造', 1, 'circle', NULL, 1513050322, 1513050322),
(36, '法律', 1, 'circle', NULL, 1513050322, 1513050322),
(37, '安全', 1, 'circle', NULL, 1513050322, 1513050322),
(38, '体育', 1, 'circle', NULL, 1513050322, 1513050322),
(39, '区块链', 1, 'circle', NULL, 1513050322, 1513050322);

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '用户id',
  `openid` varchar(50) NOT NULL COMMENT '用户微信openid',
  `nickname` varchar(100) DEFAULT NULL COMMENT '用户微信名（昵称）',
  `country` varchar(50) DEFAULT NULL COMMENT '微信用户所属国家',
  `province` varchar(50) DEFAULT NULL COMMENT '微信用户所属省份',
  `city` varchar(100) DEFAULT NULL COMMENT '微信用户所属城市',
  `gender` tinyint(1) DEFAULT NULL COMMENT '微信用户性别（1：男，2：女）',
  `language` varchar(50) DEFAULT NULL COMMENT '微信用户使用语言',
  `extend` varchar(255) DEFAULT NULL COMMENT '扩展字段',
  `delete_time` int(11) DEFAULT NULL COMMENT '删除时间',
  `create_time` int(11) DEFAULT NULL COMMENT '注册时间',
  `update_time` int(11) DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `openid` (`openid`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`id`, `openid`, `nickname`, `country`, `province`, `city`, `gender`, `language`, `extend`, `delete_time`, `create_time`, `update_time`) VALUES
(10, 'oJWz60PxIt1n7vLLm91Dzq0VekrI', '丁丁丁梦涛', 'China', 'Henan', 'Zhoukou', 1, 'zh_CN', NULL, NULL, 1515327389, 1515339879);

-- --------------------------------------------------------

--
-- 表的结构 `we_banner`
--

DROP TABLE IF EXISTS `we_banner`;
CREATE TABLE IF NOT EXISTS `we_banner` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `we_categories`
--

DROP TABLE IF EXISTS `we_categories`;
CREATE TABLE IF NOT EXISTS `we_categories` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) UNSIGNED DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `page_template` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `content` text COLLATE utf8mb4_unicode_ci,
  `thumbnail` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keywords` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `order` int(11) NOT NULL DEFAULT '0',
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `we_categories_parent_id_foreign` (`parent_id`),
  KEY `we_categories_created_by_foreign` (`created_by`),
  KEY `we_categories_updated_by_foreign` (`updated_by`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `we_cms_navigation`
--

DROP TABLE IF EXISTS `we_cms_navigation`;
CREATE TABLE IF NOT EXISTS `we_cms_navigation` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order` int(11) NOT NULL DEFAULT '0',
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `we_core_modules`
--

DROP TABLE IF EXISTS `we_core_modules`;
CREATE TABLE IF NOT EXISTS `we_core_modules` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `alias` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `installed_version` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `we_core_modules_alias_unique` (`alias`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `we_core_modules`
--

INSERT INTO `we_core_modules` (`id`, `alias`, `installed_version`, `created_at`, `updated_at`) VALUES
(1, 'webed-acl', '4.0.2', '2017-10-25 23:30:32', '2017-10-25 23:30:32'),
(2, 'webed-assets', '4.0.2', '2017-10-25 23:30:32', '2017-10-25 23:30:32'),
(3, 'webed-core', '4.0.15', '2017-10-25 23:30:32', '2018-01-09 01:59:32'),
(4, 'webed-caching', '4.0.1', '2017-10-25 23:30:32', '2017-10-25 23:30:32'),
(5, 'webed-custom-fields', '4.0.10', '2017-10-25 23:30:32', '2018-01-09 01:59:44'),
(6, 'webed-elfinder', '4.0.1', '2017-10-25 23:30:32', '2017-10-25 23:30:33'),
(7, 'webed-hook', '4.0.2', '2017-10-25 23:30:32', '2017-10-25 23:30:33'),
(8, 'webed-menus', '4.0.5', '2017-10-25 23:30:32', '2017-10-25 23:30:33'),
(9, 'webed-modules-management', '4.0.10', '2017-10-25 23:30:32', '2017-10-25 23:30:33'),
(10, 'webed-pages', '4.0.3', '2017-10-25 23:30:32', '2017-10-25 23:30:33'),
(11, 'webed-settings', '4.0.1', '2017-10-25 23:30:32', '2017-10-25 23:30:33'),
(12, 'webed-shortcode', '4.0.1', '2017-10-25 23:30:32', '2017-10-25 23:30:33'),
(13, 'webed-static-blocks', '4.0.2', '2017-10-25 23:30:32', '2017-10-25 23:30:33'),
(14, 'webed-themes-management', '4.0.4', '2017-10-25 23:30:32', '2017-10-25 23:30:33'),
(15, 'webed-users', '4.0.5', '2017-10-25 23:30:32', '2017-10-25 23:30:33');

-- --------------------------------------------------------

--
-- 表的结构 `we_custom_fields`
--

DROP TABLE IF EXISTS `we_custom_fields`;
CREATE TABLE IF NOT EXISTS `we_custom_fields` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `use_for` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `use_for_id` int(10) UNSIGNED NOT NULL,
  `field_item_id` int(10) UNSIGNED NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `we_custom_fields_field_item_id_foreign` (`field_item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `we_field_groups`
--

DROP TABLE IF EXISTS `we_field_groups`;
CREATE TABLE IF NOT EXISTS `we_field_groups` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rules` text COLLATE utf8mb4_unicode_ci,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `order` int(11) NOT NULL DEFAULT '0',
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `we_field_groups_created_by_foreign` (`created_by`),
  KEY `we_field_groups_updated_by_foreign` (`updated_by`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `we_field_items`
--

DROP TABLE IF EXISTS `we_field_items`;
CREATE TABLE IF NOT EXISTS `we_field_items` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `field_group_id` int(10) UNSIGNED NOT NULL,
  `parent_id` int(10) UNSIGNED DEFAULT NULL,
  `order` int(11) DEFAULT '0',
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `instructions` text COLLATE utf8mb4_unicode_ci,
  `options` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `we_field_items_field_group_id_foreign` (`field_group_id`),
  KEY `we_field_items_parent_id_foreign` (`parent_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `we_menus`
--

DROP TABLE IF EXISTS `we_menus`;
CREATE TABLE IF NOT EXISTS `we_menus` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `we_menus_created_by_foreign` (`created_by`),
  KEY `we_menus_updated_by_foreign` (`updated_by`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `we_menus`
--

INSERT INTO `we_menus` (`id`, `title`, `slug`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(5, '产品列表', 'list-product', 1, 1, 1, '2017-12-13 16:55:36', '2017-12-13 16:55:43');

-- --------------------------------------------------------

--
-- 表的结构 `we_menu_nodes`
--

DROP TABLE IF EXISTS `we_menu_nodes`;
CREATE TABLE IF NOT EXISTS `we_menu_nodes` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `menu_id` int(10) UNSIGNED NOT NULL,
  `parent_id` int(10) UNSIGNED DEFAULT NULL,
  `entity_id` int(10) UNSIGNED DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon_font` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `css_class` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `target` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `we_menu_nodes_menu_id_foreign` (`menu_id`),
  KEY `we_menu_nodes_parent_id_foreign` (`parent_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `we_menu_nodes`
--

INSERT INTO `we_menu_nodes` (`id`, `menu_id`, `parent_id`, `entity_id`, `type`, `url`, `title`, `icon_font`, `css_class`, `target`, `order`, `created_at`, `updated_at`) VALUES
(2, 5, NULL, 8, 'category', 'http://web.my2/blog/product.html', '产品', '', '', '', 0, '2017-12-13 16:55:36', '2017-12-13 16:55:36');

-- --------------------------------------------------------

--
-- 表的结构 `we_news`
--

DROP TABLE IF EXISTS `we_news`;
CREATE TABLE IF NOT EXISTS `we_news` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `page_template` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `content` text COLLATE utf8mb4_unicode_ci,
  `thumbnail` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keywords` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `type` tinyint(4) NOT NULL DEFAULT '0',
  `order` int(11) NOT NULL DEFAULT '0',
  `is_featured` tinyint(4) NOT NULL DEFAULT '0',
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `we_news`
--

INSERT INTO `we_news` (`id`, `title`, `page_template`, `slug`, `description`, `content`, `thumbnail`, `keywords`, `status`, `type`, `order`, `is_featured`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'test', NULL, 'test', '<p>testtesttesttesttesttesttesttesttest</p>', '<p>testtesttesttesttesttesttesttesttesttesttesttesttest</p>', NULL, 'test', 1, 1, 0, 0, 1, 1, '2018-01-18 09:57:29', '2018-01-18 09:57:56', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `we_news_bak`
--

DROP TABLE IF EXISTS `we_news_bak`;
CREATE TABLE IF NOT EXISTS `we_news_bak` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `page_template` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `content` text COLLATE utf8mb4_unicode_ci,
  `thumbnail` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keywords` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `type` tinyint(4) NOT NULL DEFAULT '0',
  `order` int(11) NOT NULL DEFAULT '0',
  `is_featured` tinyint(4) NOT NULL DEFAULT '0',
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `we_news_created_by_foreign` (`created_by`),
  KEY `we_news_updated_by_foreign` (`updated_by`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `we_news_bak`
--

INSERT INTO `we_news_bak` (`id`, `title`, `page_template`, `slug`, `description`, `content`, `thumbnail`, `keywords`, `status`, `type`, `order`, `is_featured`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '$data[\'created_by\'] = get_current_logged_user_id();', NULL, '$data[\'created_by\'] = get_current_logged_user_id();', '<p><br />\r\n$data[&#39;created_by&#39;] = get_current_logged_user_id();<br />\r\n<br />\r\n$data[&#39;created_by&#39;] = get_current_logged_user_id();<br />\r\n&nbsp;</p>', '<p><br />\r\n$data[&#39;created_by&#39;] = get_current_logged_user_id();<br />\r\n<br />\r\n$data[&#39;created_by&#39;] = get_current_logged_user_id();<br />\r\n<br />\r\n$data[&#39;created_by&#39;] = get_current_logged_user_id();<br />\r\n<br />\r\n$data[&#39;created_by&#39;] = get_current_logged_user_id();<br />\r\n<br />\r\n$data[&#39;created_by&#39;] = get_current_logged_user_id();<br />\r\n&nbsp;</p>', '/uploads/news/2d37bbbc68.jpg', '$data[\'created_by\'] = get_current_logged_user_id();', 1, 1, 0, 0, 1, 1, '2018-01-18 07:10:16', '2018-01-18 07:28:15', NULL),
(2, '2222222222222222222222222', NULL, '2222222222222222222222222', '<p>22222222222222222222222222222222222222222222222222</p>', '<p>222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222</p>', '/uploads/news/2d37bbbc68.jpg', '2222222222222222222222222', 1, 0, 1, 0, 1, 1, '2018-01-18 07:26:38', '2018-01-18 07:33:24', '2018-01-18 07:33:24'),
(3, 'test', NULL, 'test', '<p>testtesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttest</p>', '<p>testtesttesttesttesttesttesttesttesttest</p>\r\n\r\n<p>testtesttesttesttesttesttesttesttesttest</p>\r\n\r\n<p>testtesttesttesttesttesttesttesttesttest</p>\r\n\r\n<p>testtesttesttesttesttesttesttesttesttest</p>\r\n\r\n<p>testtesttesttesttesttesttesttesttesttest</p>\r\n\r\n<p>testtesttesttesttesttesttesttesttesttest</p>', '/uploads/news/2d37bbbc68.jpg', 'testtesttesttesttesttesttesttesttesttest', 1, 0, 0, 0, 1, NULL, '2018-01-18 08:30:16', '2018-01-18 08:30:16', NULL),
(4, '这是一个测试', NULL, '这是一个测试', '<p>这是一个测试</p>\r\n\r\n<p>这是一个测试</p>\r\n\r\n<p>&nbsp;</p>', '<p>这是一个测试</p>\r\n\r\n<p>这是一个测试</p>\r\n\r\n<p>这是一个测试</p>\r\n\r\n<p>这是一个测试</p>\r\n\r\n<p>这是一个测试</p>\r\n\r\n<p>这是一个测试</p>\r\n\r\n<p>这是一个测试</p>\r\n\r\n<p>&nbsp;</p>', '/uploads/news/2d37bbbc68.jpg', '这是一个测试', 1, 0, 2, 1, 1, 1, '2018-01-18 08:34:53', '2018-01-18 08:35:32', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `we_pages`
--

DROP TABLE IF EXISTS `we_pages`;
CREATE TABLE IF NOT EXISTS `we_pages` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `page_template` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `content` text COLLATE utf8mb4_unicode_ci,
  `thumbnail` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keywords` text COLLATE utf8mb4_unicode_ci,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `order` int(11) NOT NULL DEFAULT '0',
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `we_pages_created_by_foreign` (`created_by`),
  KEY `we_pages_updated_by_foreign` (`updated_by`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `we_pages`
--

INSERT INTO `we_pages` (`id`, `title`, `page_template`, `slug`, `description`, `content`, `thumbnail`, `keywords`, `status`, `order`, `created_by`, `updated_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(8, '关于我们', 'about_us', 'AboutUs', NULL, '<p>mediusum</p>', NULL, NULL, 1, 0, 1, NULL, NULL, '2017-12-13 16:21:32', '2017-12-13 16:21:32'),
(9, '联系我们', 'contact_us', 'CantactUs', NULL, '<p>联系我们</p>', NULL, NULL, 1, 0, 1, NULL, NULL, '2017-12-13 16:23:49', '2017-12-13 16:23:49'),
(10, 'FAQ', 'faq', 'faq', NULL, '<p>问：</p>\r\n\r\n<p>答：</p>', NULL, NULL, 1, 0, 1, NULL, NULL, '2017-12-13 16:30:37', '2017-12-13 16:30:37'),
(11, '首页', 'homepage', 'homepage', NULL, '<p>首页内容</p>', NULL, NULL, 1, 0, 1, NULL, NULL, '2017-12-13 16:41:09', '2017-12-13 16:41:09');

-- --------------------------------------------------------

--
-- 表的结构 `we_password_resets`
--

DROP TABLE IF EXISTS `we_password_resets`;
CREATE TABLE IF NOT EXISTS `we_password_resets` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` varchar(170) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(170) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `we_password_resets_email_index` (`email`),
  KEY `we_password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `we_permissions`
--

DROP TABLE IF EXISTS `we_permissions`;
CREATE TABLE IF NOT EXISTS `we_permissions` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `module` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `we_permissions_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=71 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `we_permissions`
--

INSERT INTO `we_permissions` (`id`, `name`, `slug`, `module`) VALUES
(1, 'Access to dashboard', 'access-dashboard', 'webed-core'),
(2, 'System commands', 'use-system-commands', 'webed-core'),
(3, 'View roles', 'view-roles', 'webed-acl'),
(4, 'Create roles', 'create-roles', 'webed-acl'),
(5, 'Edit roles', 'edit-roles', 'webed-acl'),
(6, 'Delete roles', 'delete-roles', 'webed-acl'),
(7, 'View permissions', 'view-permissions', 'webed-acl'),
(8, 'Assign roles', 'assign-roles', 'webed-acl'),
(9, 'View cache management page', 'view-cache', 'webed-caching'),
(10, 'Modify cache', 'modify-cache', 'webed-caching'),
(11, 'Clear cache', 'clear-cache', 'webed-caching'),
(12, 'View custom fields', 'view-custom-fields', 'webed-custom-fields'),
(13, 'Create field group', 'create-field-groups', 'webed-custom-fields'),
(14, 'Edit field group', 'edit-field-groups', 'webed-custom-fields'),
(15, 'Delete field group', 'delete-field-groups', 'webed-custom-fields'),
(16, 'View files', 'elfinder-view-files', 'webed-elfinder'),
(17, 'View menus', 'view-menus', 'webed-menus'),
(18, 'Delete menus', 'delete-menus', 'webed-menus'),
(19, 'Create menus', 'create-menus', 'webed-menus'),
(20, 'Edit menus', 'edit-menus', 'webed-menus'),
(21, 'View plugins', 'view-plugins', 'webed-modules-management'),
(22, 'View pages', 'view-pages', 'webed-pages'),
(23, 'Create pages', 'create-pages', 'webed-pages'),
(24, 'Edit pages', 'edit-pages', 'webed-pages'),
(25, 'Delete pages', 'delete-pages', 'webed-pages'),
(26, 'Restore deleted pages', 'restore-deleted-pages', 'webed-pages'),
(27, 'Delete pages permanently', 'force-delete-pages', 'webed-pages'),
(28, 'View settings page', 'view-settings', 'webed-settings'),
(29, 'Edit settings', 'edit-settings', 'webed-settings'),
(30, 'View static blocks', 'view-static-blocks', 'webed-static-blocks'),
(31, 'Create static blocks', 'create-static-blocks', 'webed-static-blocks'),
(32, 'Edit static blocks', 'update-static-blocks', 'webed-static-blocks'),
(33, 'Delete static blocks', 'delete-static-blocks', 'webed-static-blocks'),
(34, 'View themes', 'view-themes', 'webed-themes-management'),
(35, 'View theme options', 'view-theme-options', 'webed-themes-management'),
(36, 'Update theme options', 'update-theme-options', 'webed-themes-management'),
(37, 'View users', 'view-users', 'webed-users'),
(38, 'Create users', 'create-users', 'webed-users'),
(39, 'Edit other users', 'edit-other-users', 'webed-users'),
(40, 'Delete users', 'delete-users', 'webed-users'),
(41, 'Force delete users', 'force-delete-users', 'webed-users'),
(42, 'View posts', 'view-posts', 'webed-blog'),
(43, 'Create posts', 'create-posts', 'webed-blog'),
(44, 'Update posts', 'update-posts', 'webed-blog'),
(45, 'Delete posts', 'delete-posts', 'webed-blog'),
(46, 'Restore deleted posts', 'restore-deleted-posts', 'webed-blog'),
(47, 'Delete posts permanently', 'force-delete-posts', 'webed-blog'),
(48, 'View categories', 'view-categories', 'webed-blog'),
(49, 'Create categories', 'create-categories', 'webed-blog'),
(50, 'Update categories', 'update-categories', 'webed-blog'),
(51, 'Delete categories', 'delete-categories', 'webed-blog'),
(52, 'Restore deleted categories', 'restore-deleted-categories', 'webed-blog'),
(53, 'Delete categories permanently', 'force-delete-categories', 'webed-blog'),
(54, 'View tags', 'view-tags', 'webed-blog'),
(55, 'Create tags', 'create-tags', 'webed-blog'),
(56, 'Update tags', 'update-tags', 'webed-blog'),
(57, 'Delete tags', 'delete-tags', 'webed-blog'),
(58, 'Restore deleted tags', 'restore-deleted-tags', 'webed-blog'),
(59, 'Delete tags permanently', 'force-delete-tags', 'webed-blog'),
(64, 'View backups', 'view-backups', 'webed-backup'),
(65, 'Download backups', 'download-backups', 'webed-backup'),
(66, 'Create backups', 'create-backups', 'webed-backup'),
(67, 'Delete backups', 'delete-backups', 'webed-backup'),
(70, '修改首页banner', 'banner', 'banner');

-- --------------------------------------------------------

--
-- 表的结构 `we_plugins`
--

DROP TABLE IF EXISTS `we_plugins`;
CREATE TABLE IF NOT EXISTS `we_plugins` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `alias` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `installed_version` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `enabled` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `installed` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `we_plugins_alias_unique` (`alias`),
  KEY `we_plugins_updated_by_foreign` (`updated_by`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `we_plugins`
--

INSERT INTO `we_plugins` (`id`, `alias`, `installed_version`, `enabled`, `installed`, `created_at`, `updated_at`, `updated_by`) VALUES
(1, 'webed-blog', '4.0.3', 1, 1, '2017-10-25 23:33:23', '2018-01-18 09:56:23', NULL),
(2, 'webed-backup', '3.1.3', 0, 1, '2018-01-03 22:16:19', '2018-01-03 23:45:42', NULL),
(3, 'banner', '1.0', 1, 1, '2018-01-07 19:45:26', '2018-01-18 10:02:24', NULL),
(4, 'share', '1.0', 1, 1, '2018-01-08 00:18:12', '2018-01-18 10:01:40', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `we_posts`
--

DROP TABLE IF EXISTS `we_posts`;
CREATE TABLE IF NOT EXISTS `we_posts` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `page_template` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `content` text COLLATE utf8mb4_unicode_ci,
  `thumbnail` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keywords` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `category_id` int(10) UNSIGNED DEFAULT NULL,
  `is_featured` tinyint(4) NOT NULL DEFAULT '0',
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `we_posts_category_id_foreign` (`category_id`),
  KEY `we_posts_created_by_foreign` (`created_by`),
  KEY `we_posts_updated_by_foreign` (`updated_by`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `we_posts_categories`
--

DROP TABLE IF EXISTS `we_posts_categories`;
CREATE TABLE IF NOT EXISTS `we_posts_categories` (
  `post_id` int(10) UNSIGNED NOT NULL,
  `category_id` int(10) UNSIGNED NOT NULL,
  KEY `we_posts_categories_post_id_foreign` (`post_id`),
  KEY `we_posts_categories_category_id_foreign` (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `we_posts_tags`
--

DROP TABLE IF EXISTS `we_posts_tags`;
CREATE TABLE IF NOT EXISTS `we_posts_tags` (
  `post_id` int(10) UNSIGNED NOT NULL,
  `tag_id` int(10) UNSIGNED NOT NULL,
  UNIQUE KEY `we_posts_tags_post_id_tag_id_unique` (`post_id`,`tag_id`),
  KEY `we_posts_tags_tag_id_foreign` (`tag_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `we_products`
--

DROP TABLE IF EXISTS `we_products`;
CREATE TABLE IF NOT EXISTS `we_products` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `page_template` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `content` text COLLATE utf8mb4_unicode_ci,
  `thumbnail` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keywords` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `category_id` int(10) UNSIGNED DEFAULT NULL,
  `is_featured` tinyint(4) NOT NULL DEFAULT '0',
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `we_products_updated_by_foreign` (`updated_by`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `we_roles`
--

DROP TABLE IF EXISTS `we_roles`;
CREATE TABLE IF NOT EXISTS `we_roles` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `we_roles_slug_unique` (`slug`),
  KEY `we_roles_created_by_foreign` (`created_by`),
  KEY `we_roles_updated_by_foreign` (`updated_by`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `we_roles`
--

INSERT INTO `we_roles` (`id`, `name`, `slug`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'super-admin', NULL, NULL, '2017-10-25 23:30:01', '2017-10-25 23:30:01');

-- --------------------------------------------------------

--
-- 表的结构 `we_roles_permissions`
--

DROP TABLE IF EXISTS `we_roles_permissions`;
CREATE TABLE IF NOT EXISTS `we_roles_permissions` (
  `role_id` int(10) UNSIGNED NOT NULL,
  `permission_id` int(10) UNSIGNED NOT NULL,
  UNIQUE KEY `we_roles_permissions_role_id_permission_id_unique` (`role_id`,`permission_id`),
  KEY `we_roles_permissions_permission_id_foreign` (`permission_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `we_settings`
--

DROP TABLE IF EXISTS `we_settings`;
CREATE TABLE IF NOT EXISTS `we_settings` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `option_key` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `option_value` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `we_settings_option_key_unique` (`option_key`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `we_settings`
--

INSERT INTO `we_settings` (`id`, `option_key`, `option_value`, `created_at`, `updated_at`) VALUES
(1, 'default_homepage', '2', '2017-11-01 19:33:31', '2017-11-01 19:33:31'),
(2, 'main_menu', 'index', '2017-11-01 19:33:31', '2017-11-01 19:33:31'),
(3, 'site_title', '首页', '2017-11-01 19:33:31', '2017-11-01 19:33:31'),
(4, 'app_name', 'Laravel', '2017-11-01 19:33:32', '2017-11-01 19:33:32'),
(5, 'site_logo', '/uploads/QQ%E6%88%AA%E5%9B%BE20171031153026.png', '2017-11-01 19:33:32', '2017-11-01 19:33:32'),
(6, 'favicon', '', '2017-11-01 19:33:32', '2017-11-01 19:33:32');

-- --------------------------------------------------------

--
-- 表的结构 `we_share`
--

DROP TABLE IF EXISTS `we_share`;
CREATE TABLE IF NOT EXISTS `we_share` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `link_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `thumbnail` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `is_featured` tinyint(4) NOT NULL DEFAULT '0',
  `order` int(11) NOT NULL DEFAULT '0',
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `we_share_created_by_foreign` (`created_by`),
  KEY `we_share_updated_by_foreign` (`updated_by`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `we_share`
--

INSERT INTO `we_share` (`id`, `title`, `link_url`, `thumbnail`, `status`, `is_featured`, `order`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'FaceBook', 'http://www.facebook.com/sharer.php?u=https://www.baidu.com', '/uploads/shares/Facebook.png', 1, 0, 0, 1, 1, '2018-01-11 07:35:24', '2018-01-15 08:22:09', NULL),
(2, 'Twitter', 'https://twitter.com/intent/tweet?url=https://www.baidu.com&via=test&text=caredin', '/uploads/shares/Twitter.png', 1, 0, 0, 1, 1, '2018-01-15 07:21:45', '2018-01-15 08:23:43', NULL),
(3, 'Instagram', 'http://instagram.com/', '/uploads/shares/instagram.jpg', 0, 0, 0, 1, 1, '2018-01-15 09:07:03', '2018-01-16 04:05:03', NULL),
(4, 'Tumblr', 'http://www.tumblr.com/', '/uploads/shares/Tumblr.png', 1, 0, 0, 1, NULL, '2018-01-16 04:01:21', '2018-01-16 04:01:21', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `we_static_blocks`
--

DROP TABLE IF EXISTS `we_static_blocks`;
CREATE TABLE IF NOT EXISTS `we_static_blocks` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `we_static_blocks_created_by_foreign` (`created_by`),
  KEY `we_static_blocks_updated_by_foreign` (`updated_by`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `we_static_blocks`
--

INSERT INTO `we_static_blocks` (`id`, `title`, `slug`, `content`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, 'new', 'new', '<p>sdsdadd</p>', 1, NULL, NULL, '2017-10-31 01:35:49', '2017-10-31 01:35:49', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `we_tags`
--

DROP TABLE IF EXISTS `we_tags`;
CREATE TABLE IF NOT EXISTS `we_tags` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `order` int(11) NOT NULL DEFAULT '0',
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `we_tags_created_by_foreign` (`created_by`),
  KEY `we_tags_updated_by_foreign` (`updated_by`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `we_themes`
--

DROP TABLE IF EXISTS `we_themes`;
CREATE TABLE IF NOT EXISTS `we_themes` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `alias` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `enabled` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `installed` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `installed_version` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `we_themes_alias_unique` (`alias`),
  KEY `we_themes_updated_by_foreign` (`updated_by`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `we_themes`
--

INSERT INTO `we_themes` (`id`, `alias`, `enabled`, `installed`, `installed_version`, `created_at`, `updated_at`, `updated_by`) VALUES
(1, 'newstv', 1, 1, '4.0.1', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `we_theme_options`
--

DROP TABLE IF EXISTS `we_theme_options`;
CREATE TABLE IF NOT EXISTS `we_theme_options` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `theme_id` int(10) UNSIGNED NOT NULL,
  `key` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  UNIQUE KEY `we_theme_options_theme_id_key_unique` (`theme_id`,`key`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `we_theme_options`
--

INSERT INTO `we_theme_options` (`id`, `theme_id`, `key`, `value`) VALUES
(1, 1, 'footer_information', '我得到的多多多多多'),
(2, 1, 'footer_copyright', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `we_users`
--

DROP TABLE IF EXISTS `we_users`;
CREATE TABLE IF NOT EXISTS `we_users` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `display_name` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `first_name` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `activation_code` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mobile_phone` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sex` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'male',
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `birthday` datetime DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `last_login_at` timestamp NULL DEFAULT NULL,
  `last_activity_at` timestamp NULL DEFAULT NULL,
  `disabled_until` datetime DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `we_users_username_unique` (`username`),
  UNIQUE KEY `we_users_email_unique` (`email`),
  KEY `we_users_created_by_foreign` (`created_by`),
  KEY `we_users_updated_by_foreign` (`updated_by`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `we_users`
--

INSERT INTO `we_users` (`id`, `username`, `email`, `password`, `display_name`, `first_name`, `last_name`, `activation_code`, `avatar`, `phone`, `mobile_phone`, `sex`, `status`, `birthday`, `description`, `remember_token`, `created_by`, `updated_by`, `last_login_at`, `last_activity_at`, `disabled_until`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'admin', '742055597@qq.com', '$2y$10$VFigQ5aQt3sZsCLqp5f4B.uOYLWzuPz3LJJ66YqlAbNtfDnn.o/mm', 'Super Admin', 'Admin', '0', NULL, NULL, NULL, NULL, 'male', 1, NULL, NULL, 'kJMNPcxAjiEeWq75OLz5ebTPfb1x8LYyFRmhxeJW7klOHFkE9kkZ5M4vJwsF', NULL, NULL, '2018-01-20 16:21:09', NULL, NULL, NULL, '2017-10-25 23:30:32', '2018-01-20 16:21:09');

-- --------------------------------------------------------

--
-- 表的结构 `we_users_roles`
--

DROP TABLE IF EXISTS `we_users_roles`;
CREATE TABLE IF NOT EXISTS `we_users_roles` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL,
  UNIQUE KEY `we_users_roles_user_id_role_id_unique` (`user_id`,`role_id`),
  KEY `we_users_roles_role_id_foreign` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `we_users_roles`
--

INSERT INTO `we_users_roles` (`user_id`, `role_id`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- 表的结构 `we_view_trackers`
--

DROP TABLE IF EXISTS `we_view_trackers`;
CREATE TABLE IF NOT EXISTS `we_view_trackers` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `entity` varchar(170) COLLATE utf8_unicode_ci NOT NULL,
  `entity_id` int(10) UNSIGNED NOT NULL,
  `count` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `we_view_trackers_entity_entity_id_unique` (`entity`,`entity_id`),
  KEY `we_view_trackers_entity_index` (`entity`),
  KEY `we_view_trackers_entity_id_index` (`entity_id`),
  KEY `we_view_trackers_count_index` (`count`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `we_view_trackers`
--

INSERT INTO `we_view_trackers` (`id`, `entity`, `entity_id`, `count`) VALUES
(1, 'webed-pages', 1, 29),
(2, 'webed-blog.categories', 1, 7),
(3, 'webed-blog.posts', 1, 4),
(4, 'webed-blog.categories', 3, 3),
(5, 'webed-pages', 2, 88),
(6, 'webed-pages', 3, 34),
(7, 'webed-blog.categories', 5, 5),
(8, 'webed-pages', 4, 1),
(9, 'webed-blog.categories', 6, 1),
(10, 'webed-blog.categories', 7, 2),
(11, 'webed-blog.posts', 2, 14),
(12, 'webed-pages', 5, 2),
(13, 'webed-pages', 6, 9),
(14, 'webed-pages', 7, 25),
(15, 'webed-blog.posts', 3, 16),
(16, 'webed-pages', 8, 40),
(17, 'webed-pages', 9, 4),
(18, 'webed-pages', 10, 6),
(19, 'webed-pages', 11, 191),
(20, 'webed-blog.categories', 8, 23),
(21, 'webed-blog.posts', 4, 13),
(22, 'webed-blog.categories', 9, 1),
(23, 'webed-blog.posts', 5, 1);

--
-- 限制导出的表
--

--
-- 限制表 `we_categories`
--
ALTER TABLE `we_categories`
  ADD CONSTRAINT `we_categories_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `we_users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `we_categories_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `we_categories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `we_categories_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `we_users` (`id`) ON DELETE SET NULL;

--
-- 限制表 `we_custom_fields`
--
ALTER TABLE `we_custom_fields`
  ADD CONSTRAINT `we_custom_fields_field_item_id_foreign` FOREIGN KEY (`field_item_id`) REFERENCES `we_field_items` (`id`) ON DELETE CASCADE;

--
-- 限制表 `we_field_groups`
--
ALTER TABLE `we_field_groups`
  ADD CONSTRAINT `we_field_groups_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `we_users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `we_field_groups_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `we_users` (`id`) ON DELETE CASCADE;

--
-- 限制表 `we_field_items`
--
ALTER TABLE `we_field_items`
  ADD CONSTRAINT `we_field_items_field_group_id_foreign` FOREIGN KEY (`field_group_id`) REFERENCES `we_field_groups` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `we_field_items_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `we_field_items` (`id`) ON DELETE CASCADE;

--
-- 限制表 `we_menus`
--
ALTER TABLE `we_menus`
  ADD CONSTRAINT `we_menus_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `we_users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `we_menus_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `we_users` (`id`) ON DELETE SET NULL;

--
-- 限制表 `we_menu_nodes`
--
ALTER TABLE `we_menu_nodes`
  ADD CONSTRAINT `we_menu_nodes_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `we_menus` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `we_menu_nodes_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `we_menu_nodes` (`id`) ON DELETE SET NULL;

--
-- 限制表 `we_news_bak`
--
ALTER TABLE `we_news_bak`
  ADD CONSTRAINT `we_news_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `we_users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `we_news_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `we_users` (`id`) ON DELETE SET NULL;

--
-- 限制表 `we_pages`
--
ALTER TABLE `we_pages`
  ADD CONSTRAINT `we_pages_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `we_users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `we_pages_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `we_users` (`id`) ON DELETE SET NULL;

--
-- 限制表 `we_plugins`
--
ALTER TABLE `we_plugins`
  ADD CONSTRAINT `we_plugins_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `we_users` (`id`) ON DELETE SET NULL;

--
-- 限制表 `we_posts`
--
ALTER TABLE `we_posts`
  ADD CONSTRAINT `we_posts_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `we_categories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `we_posts_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `we_users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `we_posts_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `we_users` (`id`) ON DELETE SET NULL;

--
-- 限制表 `we_posts_categories`
--
ALTER TABLE `we_posts_categories`
  ADD CONSTRAINT `we_posts_categories_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `we_categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `we_posts_categories_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `we_posts` (`id`) ON DELETE CASCADE;

--
-- 限制表 `we_posts_tags`
--
ALTER TABLE `we_posts_tags`
  ADD CONSTRAINT `we_posts_tags_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `we_posts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `we_posts_tags_tag_id_foreign` FOREIGN KEY (`tag_id`) REFERENCES `we_tags` (`id`) ON DELETE CASCADE;

--
-- 限制表 `we_products`
--
ALTER TABLE `we_products`
  ADD CONSTRAINT `we_products_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `we_users` (`id`) ON DELETE SET NULL;

--
-- 限制表 `we_roles`
--
ALTER TABLE `we_roles`
  ADD CONSTRAINT `we_roles_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `we_users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `we_roles_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `we_users` (`id`) ON DELETE SET NULL;

--
-- 限制表 `we_roles_permissions`
--
ALTER TABLE `we_roles_permissions`
  ADD CONSTRAINT `we_roles_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `we_permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `we_roles_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `we_roles` (`id`) ON DELETE CASCADE;

--
-- 限制表 `we_share`
--
ALTER TABLE `we_share`
  ADD CONSTRAINT `we_share_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `we_users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `we_share_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `we_users` (`id`) ON DELETE SET NULL;

--
-- 限制表 `we_static_blocks`
--
ALTER TABLE `we_static_blocks`
  ADD CONSTRAINT `we_static_blocks_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `we_users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `we_static_blocks_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `we_users` (`id`) ON DELETE SET NULL;

--
-- 限制表 `we_tags`
--
ALTER TABLE `we_tags`
  ADD CONSTRAINT `we_tags_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `we_users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `we_tags_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `we_users` (`id`) ON DELETE SET NULL;

--
-- 限制表 `we_users`
--
ALTER TABLE `we_users`
  ADD CONSTRAINT `we_users_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `we_users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `we_users_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `we_users` (`id`) ON DELETE SET NULL;

--
-- 限制表 `we_users_roles`
--
ALTER TABLE `we_users_roles`
  ADD CONSTRAINT `we_users_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `we_roles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `we_users_roles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `we_users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
