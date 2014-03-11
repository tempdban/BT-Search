<?php
include 'function.php';
if (isset($_GET['keyword'])) {
	$keyword = strip_tags(trim($_GET['keyword']));
} else {
	$keyword = '无人区';
}
//取得最近搜索的关键词
$medoo = new medoo("bt-wget");
$list_data = $medoo->query("select distinct(tags) as tags from bt_tags order by id desc limit 40")->fetchAll();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>磁力种子采集站 - Dev</title>
<meta name="keywords"
	content="BT,BT种子,种子,种子搜索,BT搜索,资源搜索,云点播,云播放,云播,火焰云点播,音符云点播,小二云点播,彩虹云点播," />
<meta name="description"
	content="磁力种子,提供影片搜索、BT种子、视频下载链接在线快速播放，手机云点播,iPad云点播,免费云点播，支持多浏览器、苹果和安卓系统、ipad等移动设备" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/bootstrap-theme.min.css">
<link href="css/style.css" rel="stylesheet">
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>

</head>
<body>

	<div class="container">
		 <div class="navbar navbar-default" role="navigation">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="http://bt.kslr.net/">BT-Wget</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="http://bt.kslr.net/">首页</a></li>
            <li><a href="cache/tarms.txt">使用条款</a></li>
            <li><a href="" data-toggle="modal" data-target="#myModal">反馈错误</a></li>
            <li><a href="javascript:alert('Mail: kslrwang@gmail.com')">获得源代码</a></li>
	      </li>
          </ul>
         <form class="navbar-form navbar-left" role="search" method="get" action="search.php">
	      <div class="form-group">
	        <input type="text" class="form-control" placeholder="<?php echo htmlspecialchars($keyword);?>" name="keyword">
	      </div>
	      <button type="submit" class="btn btn-default">搜索</button>
	    </form>
        </div>
      </div>
      <div class="alert alert-danger">不要搜索这么屌的关键词了，小心被和谐。</div>
      <div class="row">
      	<div class="col-lg-12">
      		<h4>刚刚被搜索的词:</h4>
      		<?php 
      		foreach($list_data as $cont){
      			echo '<a href="index.php?keyword='.$cont['tags'].'" class="btn btn-info" target="_blank">'.$cont['tags'].'</a>';
      		}
      		?>
      	</div>      
      </div>


<div class="history">
	<div class="col-lg-12">
	<h4>刚刚搜索的种子</h4>	
	<?php
	if ($keyword == '无人区') {
		$bt_list = $medoo->query("select * from bt_data order by tid desc limit 60")->fetchAll();
	} else {
		$bt_list = $medoo->select("bt_data", array('bt_name', 'bt_size', 'bt_date', 'url'), array('LIKE' => array('AND' => array('bt_name' => $keyword))));
		
	}	

	$header_url = array (
			'http://yun.dybeta.com/play.php#!u=',
			'http://www.huoyan.tv/api.php#!u=',
			'http://www.weivod.com/?u=',
			'http://www.vodzx.com/#!u=',
	);
	
	echo "<table class=\"table table-bordered\" border=\"1\"><tr><th>影片名字</th><th>种子大小</th><th>上传日期</th><th>磁力种子</th><th>在线观看</th></tr>";
	if (empty($bt_list)) {
		echo "<tr>";
		echo "<td>抱歉，没有搜索到数据</td>";
		echo "<td></td>";
		echo "<td></td>";
		echo "<td><a href='#' target='_blank'>查看种子<a></td>";
		echo "<td>";
		echo "<a class='btn btn-info' href='' target='_blank'>1</a>";
		echo "</td></tr>";
	} else {
		foreach ($bt_list as $lu ) {
			echo "<tr>";
			echo "<td class='name'>" . $lu['bt_name'] . "</td>";
			echo "<td>" . $lu['bt_size'] . "</td>";
			echo "<td>" . date('Y-m-d', strtotime($lu['bt_date'])) . "</td>";
			echo "<td><a href='".$lu['url']."' >查看种子<a></td>";
			echo "<td>";
			$n = 1;
			foreach ($header_url as $head_url ) {
				echo "<a class=\"btn btn-info\" href=\"" . $head_url . $lu['url'] . "\" target=\"_blank\">$n</a>";
				$n ++;
			}
			echo "</td></tr>";
		}
	}
	echo "</table>";
	?>
	</div>
</div>
</div>
<div class="ogg">
		<p>© 2014 BT Wget All Rights Reserved. 访问量：<?PHP
$countfile = "cache/countnum.txt";
$fp = fopen($countfile, "r+");
$countnum = fread ($fp,10);
fclose ($fp);
echo $countnum;
?></p>
</div>

<?PHP
$countfile = "cache/countnum.txt";
$fp = fopen($countfile, "r+");
$countnum = fread ($fp,10);
fclose ($fp);
$countnum = $countnum + 1;
$fp = fopen($countfile, "w+");
fwrite ($fp,$countnum);
fclose ($fp);
?>
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">建议反馈</h4>
      </div>
      <div class="modal-body">
        <!-- Duoshuo Comment BEGIN -->
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
<!-- Duoshuo Comment END -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</body>
</html>