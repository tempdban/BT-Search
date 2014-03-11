<?php
define('IN_SYS', TRUE);
// ========== 数据库配置 ==========
$GLOBALS['DB'] = array(
	'database_type' => 'mysql',
	'database_name' => 'bt-wget',
	'server' => 'localhost',
	'username' => 'bt-user',
	'password' => 'nA4N4R4RWF2sazG9',
	'port' => 3306,
	'charset' => 'utf8',
	'option' => array(PDO::ATTR_CASE => PDO::CASE_NATURAL)
	);

$SITE['url'] = "http://bt.kslr.net/"; //网站地址  注意,网址后面必须加上/
$SITE['title'] = '磁力种子搜索站'; //网站标题
$SITE['keywords'] = 'BT,BT种子,种子,种子搜索,BT搜索,资源搜'; //网站关键词
$SITE['description'] = '磁力种子,提供影片搜索、BT种子、视频下载链接在线快速播放'; //网站描述
$badword = array('胡锦涛','江泽民', '邓小平', '毛泽东');	//过滤的关键词
$key = 'f9FkTlB25C';	//加盐字符
$default_keyword = '无人区';  //默认的关键词