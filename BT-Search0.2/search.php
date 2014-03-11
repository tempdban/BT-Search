<?php
set_time_limit('120');
include 'function.php';

/**
* 处理提交过来的关键词
* 通过则URL编码
* 不通过则返回301
*/

if (!empty($_POST['keyword']) && $_POST['key'] == $key) {
	$str_temp = strip_tags(trim($_POST['keyword']));
	if (in_array($str_temp, $badword)) {
		header('Content-Type: application/json; charset=utf-8');
	 	echo json_encode(array('Error' => '此关键词被列入黑名单!'));
		exit();
	}
	$keyword = urldecode($str_temp);
	// 将搜索词写到数据库
	$medoo = new medoo($GLOBALS['DB']);
	$medoo->insert("bt_tags", array('tags' => $str_temp));
	// 计算页数

	if (!isset($_POST['collpage'])) {
		$Coll_Page = Counts($keyword);
	} else {
		$Coll_Page = '0';
	}

	// 如果没有指定当前页则默认采集一页
	if (!empty($_POST['currentpage'])) {
		$page = intval(trim($_POST['currentpage']));
		$data = Collection($keyword, '/'.$page);
		$currentpage = $page;
	} else {
		$data = Collection($keyword, '/');
		$currentpage = '1';
	}
	header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 
	header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT"); 
	header("Cache-Control: no-cache, must-revalidate"); 
	header("Pramga: no-cache");
	header('Content-Type: application/json; charset=utf-8');
	echo json_encode(array('keyword' => $keyword, 'collpage' => $Coll_Page, 'currentpage' => $currentpage, 'data' => $data));
} else {
	 header('Content-Type: application/json; charset=utf-8');
	 echo json_encode(array('Error' => 'Null'));
}
?>