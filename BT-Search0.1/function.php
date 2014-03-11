<?php
include 'config.php';
include 'class/Medoo.class.php';
include 'class/Curl.class.php';
include 'class/Simple_html_dom.class.php';
include 'class/phpfastcache/phpfastcache.php';

/**
* 显示最近搜索的关键词列表
*/
function Recentsearches() {
	$medoo = new medoo($GLOBALS['DB']);
	$searches_keyword = $medoo->query("select tags from bt_tags order by id desc limit 60")->fetchAll();
	return $searches_keyword;
}

/**
* 刚刚被搜索的种子列表
*/
function RecentBT($hava = true, $keyword = NUll) {
	$medoo = new medoo($GLOBALS['DB']);
	if ($hava) {
		$bt_list = $medoo->query("select * from bt_data order by tid asc limit 30")->fetchAll();
	} else {
		$bt_list = $medoo->select("bt_data", array('name', 'size', 'date', 'url'), array('LIKE' => array('name' => $keyword), 'LIMIT' => '20'));
	}
	return $bt_list;
}

/**
* 磁力链转换为种子
*/
function Magnetic_turn_seeds($magnet){
	@$bt_data = file_get_contents('http://code.76lt.com/magnet-bt/torrent.php?magnet='.$magnet);
	if ($bt_data == false) {
		echo "<script>alert('抱歉，无法转换这个磁力链接为种子。');</script>";
	} else {
		header('Content-type: application/octet-stream; charset=utf8');
		Header("Accept-Ranges: bytes");
		header('Content-Disposition: attachment; filename='.'BT_'.time().'.torrent');
		echo $bt_data;
	}
}

/**
* 获取网页内容并缓存到本地
*/
function Curl_content($keyword, $page = '') {
	$cache = phpFastCache("files", array("path"=>"cache"));
	$htmlconter = $cache->get($keyword.$page);
	if ($htmlconter == null) {
		$curl = new cURL();
		$url = 'http://www.torrentkitty.com/search/';
		$content = $curl->get($url.$keyword.$page);
		$cache->set($keyword.$page, $content, 2592000);
		return $content;
	} else {
		return $htmlconter;
	}
}

/*
* 计算翻页页数
*/
function Counts($keyword, $lowercase = true, $forceTagsClosed=true, $target_charset = DEFAULT_TARGET_CHARSET, $stripRN=true, $defaultBRText=DEFAULT_BR_TEXT, $defaultSpanText=DEFAULT_SPAN_TEXT) {
	$dom = new simple_html_dom(null, $lowercase, $forceTagsClosed, $target_charset, $stripRN, $defaultBRText, $defaultSpanText);
	$content = Curl_content($keyword);
	$dom->load($content, $lowercase, $stripRN);
	foreach($dom->find('div[class=pagination]') as $element) {}
	if (isset($element)) {
		foreach($element->find('a') as $tt) { $pagenum[] = $tt->href; }
		$pos = array_search(max($pagenum), $pagenum);
		$dom->clear();
		return $pagenum[$pos];
	} else {
		return '0';
	}
}

/*
* 页面正则到内容
*/
function Collection($keyword, $page) {
	$content = Curl_content($keyword, $page);
	preg_match_all("/<tr><td class=\"name\">(.+?)<\/td><\/tr>/ms", $content, $list);
	$lu_list = array();
	if (is_array($list['0'])) {
		for ($i=0; $i < count($list['0']); $i++) { 
			$video_list = $list['0'];
			preg_match_all("/<td(.[^>]*)>(.+?)<\/td>/ms", $video_list[$i], $video_info[]);
			preg_match ("/href=\"magnet:(.+?)\"/ms", $video_info[$i]['2']['3'], $magnet_infos[]);
			$bt = array();
			$bt['name'] = $video_info[$i]['2']['0'];
			$bt['size'] = $video_info[$i]['2']['1'];
			$bt['date'] = $video_info[$i]['2']['2'];
			$bt['url'] = "magnet:".$magnet_infos[$i]['1'];
			$bt_json[$i] =$bt;
		}
		return $bt_json;
	} else {
		return false;
	}
}

/*
* 请求搜索
*/
function Get_search($keyword, $currentpage='', $collpage='', $key, $url) {
	$curlPost = 'keyword='.urlencode($keyword).'&key='.urlencode($key).'&currentpage='.urlencode($currentpage);
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url.'search.php');
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);
	$data = curl_exec($ch);
	curl_close($ch);
	return $data;
}

/*
* 批量插入数据
*/
function batchsql($data, $keyword) {
	$medoo = new medoo($GLOBALS['DB']);
	if (is_array($data)) {
		foreach ($data as $video) {
		 $medoo->insert("bt_data", array('name' => $video['name'], 'size' => $video['size'], 'date' => $video['date'], 'createtime' => date("Y-m-d H:i:s"), 'tag' => $keyword, 'url' => $video['url']));
		}
	}
}