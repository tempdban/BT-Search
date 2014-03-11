<?php
include 'function.php';

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
			        <input type="text" class="form-control" placeholder="<?php echo htmlspecialchars($default_keyword);?>" name="keyword">
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

  	<!-- 提交资源 -->
    <div class="row">
      <div class="col-lg-12 col-lg">
      	<h4>提交资源</h4>
      	<div class="panel panel-primary">
		  <div class="panel-heading">
		    <h3 class="panel-title">添加ED2K链接</h3>
		  </div>
		  <div class="panel-body">
		  	<form class="ed2k" name="ed2kform" method="post" action="">
		  		<p>输入ED2K链接  <input id="ed2klink" class="input" type="txt" value=""/>
		  		<button type="submit" class="btn btn-default" onClick="ed2k()">添加</button></p>
		  	</form>
		  </div>
		</div>

		<div class="panel panel-success">
		  <div class="panel-heading">
		    <h3 class="panel-title">上传BT种子</h3>
		  </div>
		  <div class="panel-body">
		    <form class="ed2k" method="post" action="upload.php">
		  		<p>输入ED2K链接  <input class="input" type="txt" value=""/>
		  		<button type="submit" class="btn btn-default">搜索</button></p>
		  	</form>
		  </div>
		</div>
      </div>      
    </div>

	</div>
	<!-- 提交资源结束 -->
	
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
<script type="text/javascript">
// function ed2k() {
// 	var ed2klink = $("#ed2klink");
// 	if (ed2klink.val() == "") {
// 		alert("请填写ED2K连接");
// 	} else {
// 		$.ajax({
// 			url:'upload.php',
// 			type:'POST',
// 			// data:{ed2klink:$("#ed2klink").val()},
// 			data:{ed2klink:$("#ed2klink").val()},	
// 			success: function (res) {
// 		      alert(res);   
// 		    },
// 		    error: function(res) {
// 		       alert(res);  
// 		    }   
// 		})
// 	}
// }
function ed2k() {
  $.ajax({
    type: "GET",
    url: "last/Update_list",
    data: "",
    dataType: 'text',
    success: function (res) {
      alert(res);   
    },
    error: function(res) {
       alert(res);  
    }
    })
}
</script>
</body>
</html>