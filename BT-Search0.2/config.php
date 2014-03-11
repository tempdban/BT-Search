<?php
define('IN_SYS', TRUE);
// ========== 数据库配置 ==========
$GLOBALS['DB'] = array(
	'database_type' => 'mysql',	//使用mysql数据库，暂只支持mysql
	'database_name' => 'bt-wget', //数据库名称
	'server' => 'localhost',	//数据库地址
	'username' => 'bt-user',	//数据库用户名
	'password' => 'nA4N4R4RWF2sazG9',	//数据库密码
	'port' => 3306,	//数据库端口
	'charset' => 'utf8',	//数据库编码
	'option' => array(PDO::ATTR_CASE => PDO::CASE_NATURAL) //推荐开启mysql的PDO扩展
	);

$SITE['url'] = "http://bt.kslr.net/"; //网站地址  注意,网址后面必须加上/
$SITE['title'] = '磁力种子搜索站'; //网站标题
$SITE['keywords'] = 'BT,BT种子,种子,种子搜索,BT搜索,资源搜'; //网站关键词
$SITE['description'] = '磁力种子,提供影片搜索、BT种子、视频下载链接在线快速播放'; //网站描述
$badword = array('胡锦涛','江泽民', '邓小平', '毛泽东');	//过滤的关键词
$key = 'f9FkTlB25C';	//认证字符
$default_keyword = '无人区';  //默认的关键词