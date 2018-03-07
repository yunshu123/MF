# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.7.17)
# Database: mphp
# Generation Time: 2018-03-07 08:17:50 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table mf_post
# ------------------------------------------------------------

DROP TABLE IF EXISTS `mf_post`;

CREATE TABLE `mf_post` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT '1' COMMENT '用户',
  `title` varchar(255) NOT NULL COMMENT '标题',
  `title_second` varchar(255) NOT NULL DEFAULT '' COMMENT '副标题',
  `title_style` varchar(255) NOT NULL DEFAULT '' COMMENT '标题样式',
  `html_path` varchar(100) NOT NULL DEFAULT '' COMMENT 'html路径',
  `html_file` varchar(100) NOT NULL DEFAULT '' COMMENT 'html文件名',
  `catalog_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '分类',
  `special_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '专题编号',
  `introduce` text COMMENT '摘要',
  `image_list` text COMMENT '组图',
  `seo_title` varchar(255) NOT NULL DEFAULT '' COMMENT 'SEO标题',
  `seo_description` text COMMENT 'SEO描述',
  `seo_keywords` varchar(255) NOT NULL DEFAULT '' COMMENT 'SEO关键字',
  `content` mediumtext NOT NULL COMMENT '内容',
  `copy_from` varchar(100) NOT NULL DEFAULT '' COMMENT '来源',
  `copy_url` varchar(255) NOT NULL DEFAULT '' COMMENT '来源url',
  `redirect_url` varchar(255) NOT NULL DEFAULT '' COMMENT '跳转URL',
  `tags` varchar(255) NOT NULL DEFAULT '' COMMENT 'tags',
  `view_count` int(10) unsigned NOT NULL DEFAULT '1' COMMENT '查看次数',
  `commend` enum('Y','N') NOT NULL DEFAULT 'N' COMMENT '推荐',
  `attach_status` enum('Y','N') NOT NULL DEFAULT 'N' COMMENT '是否上传附件',
  `attach_file` varchar(255) NOT NULL DEFAULT '' COMMENT '附件名称',
  `attach_thumb` varchar(255) NOT NULL DEFAULT '' COMMENT '附件缩略图',
  `favorite_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '收藏数量',
  `attention_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '关注次数',
  `top_line` enum('Y','N') NOT NULL DEFAULT 'N' COMMENT '置顶',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '最后更新时间',
  `reply_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '回复次数',
  `reply_allow` enum('Y','N') NOT NULL DEFAULT 'Y' COMMENT '允许评论',
  `sort_desc` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `status` enum('Y','N') NOT NULL DEFAULT 'Y' COMMENT '是否显示',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (`id`),
  KEY `tags_index` (`tags`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='内容管理';

LOCK TABLES `mf_post` WRITE;
/*!40000 ALTER TABLE `mf_post` DISABLE KEYS */;

INSERT INTO `mf_post` (`id`, `user_id`, `title`, `title_second`, `title_style`, `html_path`, `html_file`, `catalog_id`, `special_id`, `introduce`, `image_list`, `seo_title`, `seo_description`, `seo_keywords`, `content`, `copy_from`, `copy_url`, `redirect_url`, `tags`, `view_count`, `commend`, `attach_status`, `attach_file`, `attach_thumb`, `favorite_count`, `attention_count`, `top_line`, `update_time`, `reply_count`, `reply_allow`, `sort_desc`, `status`, `create_time`)
VALUES
	(14,1,'天河二号以每秒3.3亿亿次的速度再居世界超算榜首 上演帽子戏法','','','','',2,1,'据外媒报道，23日在德国莱比锡市发布的第43届世界超级计算机500强排行榜上，中国超级计算机系统“天河二号”以每秒3.386亿亿次的浮点运算速度稳居榜首，获得世界超算“三连冠”。 ','','','','','<p style=\"text-indent:2em;\">\r\n	<img src=\"http://www.yii.local/uploads/images/201406/5e7d89999bb.jpg\" alt=\"\" height=\"418\" width=\"772\" /> \r\n</p>\r\n<p style=\"text-indent:2em;\">\r\n	<span style=\"font-size:14px;\">北京时间6月24日消息，据美国科技网站</span><a href=\"http://www.cnet.com/news/top500-supercomputer-race-hits-a-slow-patch/\" target=\"_blank\"><span style=\"font-size:14px;\">CNET</span></a><span style=\"font-size:14px;\">报道，23日在德国莱比锡市发布的</span><a href=\"http://top500.org/blog/lists/2014/06/press-release/\" target=\"_blank\"><span style=\"font-size:14px;\">第43届世界超级计算机500强排行榜</span></a><span style=\"font-size:14px;\">上，中国超级计算机系统“天河二号”以每秒3.386亿亿次的浮点运算速度稳居榜首，获得世界超算“三连冠”。美国能源部下属橡树岭国家实验室的“泰坦”则连续3次屈居亚军，其浮点运算速度为每秒1.759亿亿次。</span> \r\n</p>\r\n<p style=\"text-indent:2em;\">\r\n	<span style=\"font-size:14px;\">2010年，由国防科技大学研制的天河一号在超算排行榜上首次夺冠，2013年，天河二号又两度位列榜首，昨天，天河二号第3次被评为全球最快的计算机，获得世界超算三连冠。</span> \r\n</p>\r\n<p style=\"text-indent:2em;\">\r\n	<span style=\"font-size:14px;\">据悉，国际TOP500组织是发布全球已安装的超级计算机系统排名的权威机构，每年发布两次，其目的是促进国际超级计算机领域的交流和合作，促进超级计算机的推广应用。</span> \r\n</p>\r\n<p style=\"text-indent:2em;\">\r\n	<span style=\"font-size:14px;\">超级计算机是计算机中功能最强、运算速度最快、存储容量最大的一类计算机，多用于国家高科技领域和尖端技术研究。如：模拟核武器爆炸、模拟地球的气候、分析飞机的空气动力学和研究生物的大脑等。这些机器通常占用很大的橱柜和消耗大量的电力。</span> \r\n</p>\r\n<p style=\"text-align:center;\">\r\n	<img src=\"/uploads/attached/image/201406/f6cf41e3649.jpg\" alt=\"\" /> \r\n</p>\r\n<p style=\"text-indent:2em;\">\r\n	<span style=\"font-size:14px;\">世界上最快的计算机的性能在过去的二十年中一直在稳步的提升，最新数据显示，这个增长趋势在放缓。从2013年11月至今，排行榜前500的所有超级计算机的性能总和从25亿亿次提高到了27.4亿亿次。相关分析人士认为这是一个明显的增长放缓。</span> \r\n</p>\r\n<p style=\"text-indent:2em;\">\r\n	<span style=\"font-size:14px;\">另外，在过去的五年内，排行榜最后一位的超级计算机以每年55%的速度提升，而1994年至2008年间，性能曾以每年90%的速度增长。</span> \r\n</p>','csdn','http://www.csdn.net/article/2014-06-24/2820355','','超级计算机,中国',34,'N','Y','uploads/images/201406/5e7d89999bb.jpg','uploads/thumbs/201406/small_5e7d89999bb.jpg',0,0,'N',1404120867,0,'Y',0,'N',1379554460),
	(49,1,'mac 终端 使用ftp命令','','','','',3,0,'1. 连接ftp服务器   格式：ftp [hostname| ip-address]   a)ftp ftp.drivehq.com   b)服务器询问你用户名和口令，输入后即可。   2. 下载文件   下载文件通常用get和mget这两条命令。   a) get   格式：get [remote-file] [local-file]   将单个文件从远端主机中传送至本地主机中.   b) mget   格式：mget [remote-files]   将多个文件从远端主机中传送至本地主机中.   如要获取服务器上Cahce目录下的所有文件,则   ftp&amp;gt; cd /rC...','','','','','<p style=\"color:#232323;font-family:Corbel, Verdana, Arial, Helvetica, sans-serif;font-size:14px;\">\r\n	1. 连接ftp服务器\r\n</p>\r\n<p style=\"color:#232323;font-family:Corbel, Verdana, Arial, Helvetica, sans-serif;font-size:14px;\">\r\n	格式：ftp [hostname| ip-address]\r\n</p>\r\n<p style=\"color:#232323;font-family:Corbel, Verdana, Arial, Helvetica, sans-serif;font-size:14px;\">\r\n	a)ftp ftp.drivehq.com\r\n</p>\r\n<p style=\"color:#232323;font-family:Corbel, Verdana, Arial, Helvetica, sans-serif;font-size:14px;\">\r\n	b)服务器询问你用户名和口令，输入后即可。\r\n</p>\r\n<p style=\"color:#232323;font-family:Corbel, Verdana, Arial, Helvetica, sans-serif;font-size:14px;\">\r\n	2. 下载文件\r\n</p>\r\n<p style=\"color:#232323;font-family:Corbel, Verdana, Arial, Helvetica, sans-serif;font-size:14px;\">\r\n	下载文件通常用get和mget这两条命令。\r\n</p>\r\n<p style=\"color:#232323;font-family:Corbel, Verdana, Arial, Helvetica, sans-serif;font-size:14px;\">\r\n	a) get\r\n</p>\r\n<p style=\"color:#232323;font-family:Corbel, Verdana, Arial, Helvetica, sans-serif;font-size:14px;\">\r\n	格式：get [remote-file] [local-file]\r\n</p>\r\n<p style=\"color:#232323;font-family:Corbel, Verdana, Arial, Helvetica, sans-serif;font-size:14px;\">\r\n	将单个文件从远端主机中传送至本地主机中.\r\n</p>\r\n<p style=\"color:#232323;font-family:Corbel, Verdana, Arial, Helvetica, sans-serif;font-size:14px;\">\r\n	b) mget\r\n</p>\r\n<p style=\"color:#232323;font-family:Corbel, Verdana, Arial, Helvetica, sans-serif;font-size:14px;\">\r\n	格式：mget [remote-files]\r\n</p>\r\n<p style=\"color:#232323;font-family:Corbel, Verdana, Arial, Helvetica, sans-serif;font-size:14px;\">\r\n	将多个文件从远端主机中传送至本地主机中.\r\n</p>\r\n<p style=\"color:#232323;font-family:Corbel, Verdana, Arial, Helvetica, sans-serif;font-size:14px;\">\r\n	如要获取服务器上Cahce目录下的所有文件,则\r\n</p>\r\n<p style=\"color:#232323;font-family:Corbel, Verdana, Arial, Helvetica, sans-serif;font-size:14px;\">\r\n	ftp&amp;gt; cd /rCache\r\n</p>\r\n<p style=\"color:#232323;font-family:Corbel, Verdana, Arial, Helvetica, sans-serif;font-size:14px;\">\r\n	ftp&amp;gt; mget *.*&nbsp;\r\n</p>\r\n<p style=\"color:#232323;font-family:Corbel, Verdana, Arial, Helvetica, sans-serif;font-size:14px;\">\r\n	3.上传文件\r\n</p>\r\n<p style=\"color:#232323;font-family:Corbel, Verdana, Arial, Helvetica, sans-serif;font-size:14px;\">\r\n	a) put\r\n</p>\r\n<p style=\"color:#232323;font-family:Corbel, Verdana, Arial, Helvetica, sans-serif;font-size:14px;\">\r\n	格式：put local-file [remote-file]\r\n</p>\r\n<p style=\"color:#232323;font-family:Corbel, Verdana, Arial, Helvetica, sans-serif;font-size:14px;\">\r\n	将本地主机中一个文件传送至远端主机.\r\n</p>\r\n<p style=\"color:#232323;font-family:Corbel, Verdana, Arial, Helvetica, sans-serif;font-size:14px;\">\r\n	b) mput\r\n</p>\r\n<p style=\"color:#232323;font-family:Corbel, Verdana, Arial, Helvetica, sans-serif;font-size:14px;\">\r\n	将本地主机中一批文件传送至远端主机.\r\n</p>\r\n<p style=\"color:#232323;font-family:Corbel, Verdana, Arial, Helvetica, sans-serif;font-size:14px;\">\r\n	如要把本地当前目录下所有odt文件上传到服务器Doc目录下\r\n</p>\r\n<p style=\"color:#232323;font-family:Corbel, Verdana, Arial, Helvetica, sans-serif;font-size:14px;\">\r\n	ftp&amp;gt; cd /Doc&nbsp;\r\n</p>\r\n<p style=\"color:#232323;font-family:Corbel, Verdana, Arial, Helvetica, sans-serif;font-size:14px;\">\r\n	ftp&amp;gt; mput *.odt\r\n</p>\r\n<p style=\"color:#232323;font-family:Corbel, Verdana, Arial, Helvetica, sans-serif;font-size:14px;\">\r\n	4. 断开连接\r\n</p>\r\n<p style=\"color:#232323;font-family:Corbel, Verdana, Arial, Helvetica, sans-serif;font-size:14px;\">\r\n	bye：中断与服务器的连接。\r\n</p>\r\n<p style=\"color:#232323;font-family:Corbel, Verdana, Arial, Helvetica, sans-serif;font-size:14px;\">\r\n	ftp&amp;gt; bye\r\n</p>\r\n<p style=\"color:#232323;font-family:Corbel, Verdana, Arial, Helvetica, sans-serif;font-size:14px;\">\r\n	另：默认的本地目录是home。\r\n</p>\r\n<p style=\"color:#232323;font-family:Corbel, Verdana, Arial, Helvetica, sans-serif;font-size:14px;\">\r\n	&nbsp; &nbsp; &nbsp; &nbsp; 输入help即可获得所有命令的帮助。\r\n</p>','','','','mac',4,'N','N','','',0,0,'N',1465644747,0,'Y',0,'Y',1465644747);

/*!40000 ALTER TABLE `mf_post` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
