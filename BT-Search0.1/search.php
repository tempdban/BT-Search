<?php
include 'function.php';

if (isset($_GET['keyword'])) {
	$str = $_GET['keyword'];
	$keyword = urldecode($str);
} else {
	header("HTTP/1.1 301 Moved Permanently");
	header("Location: index.php");
	exit();
}
$url = 'http://www.torrentkitty.com/search/';
if (!empty($str)) {
	$medoo = new medoo("bt-wget");
	$tag = $medoo->insert("bt_tags", array('tags' => $str));
}

$curl = new cURL ();
$content = $curl->get ( $url . $keyword );

preg_match_all ( "/<tr><td class=\"name\">(.+?)<\/td><\/tr>/ms", $content, $list );
$lu_list = array ();
if (is_array ( $list [0] )) {
	foreach ( $list [0] as $video_list ) {
		preg_match_all ( "/<td(.[^>]*)>(.+?)<\/td>/ms", $video_list, $video_info );
		preg_match ( "/href=\"magnet:(.+?)\"/ms", $video_info [2] [3], $magnet_infos );
		$magnet_url = "magnet:" . $magnet_infos [1];
		$video = array ();
		$video ['name'] = $video_info [2] [0];
		$video ['size'] = $video_info [2] [1];
		$video ['date'] = $video_info [2] [2];
		$video ['url'] = $magnet_url;
		$medoo = new medoo("bt-wget");
		$bt_info[] = $medoo->insert("bt_data", array('bt_name' => $video['name'], 'bt_size' => $video['size'], 'bt_date' => $video['date'], 'createtime' => date("Y-m-d H:i:s"), 'tag' => $str, 'url' => $video['url']));
		// var_dump($medoo->error());
	}
}

Header ( "HTTP/1.1 301 Moved Permanently" );
Header ( "Location: index.php?keyword=$str" );
exit ();
?>