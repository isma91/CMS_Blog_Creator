<?php
use controllers\BlogsController;
use controllers\UsersController;
use controllers\PostsController;

$user = new UsersController();
$user->render();
$user_error = $user->getError();
$me = $user->getMe();
$blog = new BlogsController();
$blog->render();
$blog_error = $blog->getError();
$blogs = $blog->getBlogs();
$edit_blog = $blog->getBlog();
$post = new PostsController();
$post->render();
$post_error = $post->getError();
$posts = $post->getPosts();
$one = $post->getPost();
var_dump($one);
?>
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
	<script src="media/js/panel.js"></script>
</head>
<body>
	<div class="container">
    <?php
    if (isset($blog_error)) {
      echo '<div class="alert alert-info display-error">' . $blog_error . '</div>';
    }
    if (isset($user_error)) {
      echo '<div class="alert alert-info display-error">' . $user_error . '</div>';
    }
    ?>
    <?php echo $menu; ?>
    <h1 class="title">Welcome to your panel, <span id="user_name"><?php echo $_SESSION['name']; ?></span></h1>
    <div class="jumbotron update_post">
      <a href="./?page=panel" class="mui-btn retour">Back <span class="glyphicon glyphicon-share-alt"></span></a>
      <?php
      if (isset($one)) {
        ?>
          <form action="#" method="POST">
            <div class="mui-textfield ">
              <input name="title" type="text" value="<?php echo $one['title']; ?>">
              <label>Post title</label>
            </div>
            <div class="mui-textfield">
              <textarea name="content"><?php echo $one["content"]; ?></textarea>
              <label>Post content</label>
            </div>
            <input type="hidden" name="page" value="panel">
            <input type="hidden" name="post_id" value="<?php echo $one['id']; ?>">
            <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
            <button type="submit" name="post_update" class="mui-btn button_post_update">
              Update this post
              <span class="glyphicon glyphicon-ok"></span>
            </button>
          </form>
        <?php
      }
      ?>
    </div>
  </div>
</body>
</html>