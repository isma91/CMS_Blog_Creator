<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="description" content="blog description" />
	<title>blog title</title>
	<link media="all" type="text/css" rel="stylesheet" href="media/css/bootstrap.min.css" />
	<link media="all" type="text/css" rel="stylesheet" href="media/css/bootstrap-theme.min.css" />
	<link media="all" type="text/css" rel="stylesheet" href="media/css/mui.min.css" />
	<link media="all" type="text/css" rel="stylesheet" href="media/css/style.css" />
  <script src="media/js/jquery-2.1.4.min.js"></script>
  <script src="media/js/post.js"></script>
</head>
<body>
	<div class="container">
    <?php echo $menu; ?>
    <div class="display-error"></div>
    <h1 class="title"></h1>
    <div class="jumbotron">
      <a href="./?page=home" class="mui-btn retour">Back <span class="glyphicon glyphicon-share-alt"></span></a>
      <div class="mui-panel">
        <div class="mui-panel"><h2 class="title" id="post_title"></h2></div>
        <div class="mui-panel" id="post_content"></div>
        <div class="mui-panel" id="post_medias"></div>
        <div class="mui-panel" id="post_footer"></div>
        <div class="mui-panel" id="post_add_comment"></div>
        <div class="mui-panel" id="post_comments"></div>
      </form>
    </div>
  </div>
</div>
</body>
</html>