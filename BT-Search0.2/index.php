<?php
include 'function.php';

if (!empty($_POST['keyword'])) {
	$search_data_tmp = Get_search(htmlspecialchars(trim($_POST['keyword'])), '', '', $key, $SITE['url']);
	$search_data = json_decode($search_data_tmp, true);
	if (!isset($search_data['Error'])) {
		$keyword = $search_data['keyword'];
		$collpage = $search_data['collpage'];
		$currentpage = $search_data['currentpage'];
		batchsql($search_data['data'], htmlspecialchars(trim($_POST['keyword'])));
	} else {
		$keyword = $default_keyword;
	}
} elseif (!empty($_GET['keyword'])) {
	$st = false;
	$keyword = htmlspecialchars(trim($_GET['keyword']));
} else {
	$st = true;
	$keyword = null;
}


if (!empty($_GET['keyword']) && !empty($_GET['collpage']) && !empty($_GET['currentpage'])) {
	$search_data_tmp = Get_search(htmlspecialchars(trim($_GET['keyword'])), htmlspecialchars(trim($_GET['currentpage'])), htmlspecialchars(trim($_GET['collpage'])), $key, $SITE['url']);
	$search_data = json_decode($search_data_tmp, true);
	if (!isset($search_data['Error'])) {
		$keyword = $search_data['keyword'];
		$collpage = $search_data['collpage'];
		$currentpage = $search_data['currentpage'];
	} else {
		$keyword = $default_keyword;
	}
}

// 处理磁力链转换为种子
if (!empty($_GET['magnetbt'])) {
	Magnetic_turn_seeds(strip_tags(trim($_GET['magnetbt'])));
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $SITE['title']; ?></title>
<meta name="keywords" content=<?php echo $SITE['keywords']; ?> />
<meta name="description" content="<?php echo $SITE['description']; ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="stylesheet" href="public/css/bootstrap.min.css">
	<link rel="stylesheet" href="public/css/bootstrap-theme.min.css">
	<link href="public/css/style.css" rel="stylesheet">
	<script type="text/javascript" src="public/js/jquery.min.js"></script>
	<script type="text/javascript" src="public/js/bootstrap.min.js"></script>

</head>
<body>
	<div class="container">
		<!-- 网站导航栏 -->
		<div class="navbar navbar-default" role="navigation">
	        <div class="navbar-header">
	          <a class="navbar-brand" href="http://bt.kslr.net/">BT-Wget</a>
	        </div>
	        <div class="navbar-collapse collapse">
	          <ul class="nav navbar-nav">
	            <li class="active"><a href="http://bt.kslr.net/">首页</a></li>
	            <li><a href="tarms.txt">使用条款</a></li>
	            <li><a href="" data-toggle="modal" data-target="#face">反馈建议</a></li>
	            <li><a href="javascript:alert('请给我发送邮件 Mail: kslrwang@gmail.com')">获得源代码</a></li>
	            <li><a href="http://www.kslr.net">作者网站</a></li>
		      </li>
	          </ul>
		         <form class="navbar-form navbar-left" role="search" method="post" action="index.php">
			      <div class="form-group">
			        <input type="text" class="form-control" placeholder="<?php echo htmlspecialchars($keyword);?>" name="keyword">
			        <input type="hidden" name="key" value="f9FkTlB25C">
			      </div>
			      <button type="submit" class="btn btn-default">搜索</button>
			    </form>
	        </div>
      	</div>
    	<!-- 网站导航栏结束 -->
    <!-- 顶部提示 -->
    <div class="alert alert-info alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <p>不要搜索这么屌的关键词了，小心被和谐。<br>程序开发测试中，偶尔可能会无法使用<br>另外，维护和谐社会，共创美好明天。</p>
  	</div>

  	<!-- 顶部刚搜索的关键词 -->
    <div class="row">
      <div class="col-lg-12 col-lg">
      	<h4>刚刚被搜索的词:</h4>
      	<?php 
      	foreach(Recentsearches() as $keyword_cont){
      		echo '<a href="index.php?keyword='.$keyword_cont['tags'].'" class="label label-primary" target="_blank">'.$keyword_cont['tags'].'</a> ';
      	} 
      	?>
      </div>      
    </div>

    <!-- 刚刚搜索过的种子列表 -->
	<div class="history">
		<div class="col-lg-12">
                    <h4>刚刚搜索的种子</h4>
			<?php 
			// 在线播放API网站列表
			$Broadcast = array (
				'电影离线点播' => 'http://yun.dybeta.com/play.php#!u=',
				'火焰云点播' => 'http://www.huoyan.tv/api.php#!u=',
				'微点播' => 'http://www.weivod.com/?u=',
				'多姿云点播' => 'http://www.vodzx.com/#!u=',
			);
			// 种子列表表格
			if (isset($search_data)) {
				if (isset($search_data['Error'])) {
					echo "<table class=\"table table-bordered table table-hover\" border=\"1\">";
					echo "<tr>";
					echo "<td>".$search_data['Error']."</td>";
					echo "</tr></table>";
					$list = RecentBT();
				} else {
					$list = $search_data['data'];
				}
			} else {
				$list = RecentBT($st, $keyword);
			}
			echo "<table class=\"table table-bordered table table-hover\" border=\"1\"><tr><th id='thdn'>影片名字</th><th>种子大小</th><th>上传日期</th><th>磁力/种子</th><th>在线观看</th></tr>";
				if (is_array($list)) {
					foreach ($list as $magnetic ) {
						echo "<tr>";
						echo "<td id='list_td'>" . $magnetic['name'] . "</td>";
						echo "<td id='list_td'>" . $magnetic['size'] . "</td>";
						echo "<td id='list_td'>" . date('Y-m-d', strtotime($magnetic['date'])) . "</td>";
						echo "<td id='list_td'><a href='".$magnetic['url']."'>磁力<a><a href='index.php?magnetbt=".$magnetic['url']."'/>种子</a></td>";
						echo "<td>";
						echo '<div class="btn-group">
							<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
						    在线观看 <span class="caret"></span>
						  </button><ul class="dropdown-menu" role="menu">';
						foreach ($Broadcast as $broad_title => $broad_url ) {
							echo '<li><a target="_blank" href="'.$broad_url.$magnetic['url'];
							echo '"> '.$broad_title.'</a></li>';
						}
						echo "</ul></div>";
						echo "</td>";
						echo "</tr>";
					}
				} else {
					echo '<tr><td>没有数据，请尝试其他关键词</td><td></td><td></td><td></td><td></td></tr>';
				}
			echo '</table>';
			?>
			</div>
		</div>
		<!-- 列表底部页码-->
		<?php
		if (!empty($search_data['collpage']) && !empty($search_data['currentpage'])) {
			$collpage = intval($search_data['collpage']);
			$currentpage = intval($search_data['currentpage']);
			if ($collpage != '0') {
				if ($currentpage >= '10') {
					$currentpage_sta = $currentpage - '4';
					$currentpage_end = $currentpage + '5';
				} else {
					$currentpage_sta = '1';
					$currentpage_end = '10';
				}
				echo '<ul class="pagination">';
				for ($i = $currentpage_sta; $i <= $currentpage_end; $i++) {
					if ($currentpage == $i || $currentpage == '0') {
						echo '<li class="active"><a href="index.php?keyword='.$keyword.'&collpage='.$collpage.'&currentpage='.$i.'">'.$i.'</a></li>';
					} else {
						echo '<li><a href="index.php?keyword='.$keyword.'&collpage='.$collpage.'&currentpage='.$i.'">'.$i.'</a></li>';
					}
					
				}
				echo '</ul>';
			}
		}
		?>
		<!-- 网站底部页码结束 -->
	</div>
	<!-- 网站主体结束 -->
	
	<!-- 底部 -->
	<div class="footer navbar-default">
			<p>© 2014 BT Wget All Rights Reserved. <a href="Update_records.txt"/>更新记录</a></p>
	</div>
	<!-- 底部结束 -->

<!-- 建议反馈 -->
<div class="modal fade" id="face" tabindex="-1" role="dialog" aria-labelledby="facev" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="facev">建议反馈</h4>
      </div>
      <div class="modal-body">
        <!-- 多说评论框 -->
		<div class="ds-thread"></div>
		<script type="text/javascript">
			var duoshuoQuery = {short_name:"bt-wget"};
				(function() {
					var ds = document.createElement('script');
					ds.type = 'text/javascript';ds.async = true;
					ds.src = 'http://static.duoshuo.com/embed.js';
					ds.charset = 'UTF-8';
					(document.getElementsByTagName('head')[0] 
					|| document.getElementsByTagName('body')[0]).appendChild(ds);
				})();
		</script>
		<!-- 多说评论框结束 -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
      </div>
    </div>
  </div>
</div>
<!-- 建议反馈结束 -->
</body>
</html>