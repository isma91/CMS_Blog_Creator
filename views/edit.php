<?php
use controllers\BlogsController;
use controllers\UsersController;
use controllers\PostsController;
?>

<?php
$user = new UsersController();
$user->render();
$user_error = $user->getError();
$me = $user->getMe();
?>

<?php
$blog = new BlogsController();
$blog->render();
$blog_error = $blog->getError();
$blogs = $blog->getBlogs();
$edit_blog = $blog->getBlog();
?>

<?php
$post = new PostsController();
$post->render();
$post_error = $post->getError();
$posts = $post->getPosts();
$one = $post->getPost();
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
    <div class="jumbotron">
     <?php
     if (isset($edit_blog) && !empty($edit_blog)) {
      ?>
      <a href="./?page=panel" class="mui-btn retour">Back <span class="glyphicon glyphicon-share-alt"></span></a>
      <form action="#" method="POST">
        <input type="hidden" name="id" value="<?php echo $edit_blog['id']; ?>">
        <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
        <div class="mui-textfield ">
          <input name="name" type="text" value="<?php echo $edit_blog['name']; ?>">
          <label>Blog's Name</label>
        </div>
        <div class="mui-textfield ">
          <input name="slug" type="text" value="<?php echo $edit_blog['slug']; ?>">
          <label>Blog's Domain</label>
        </div>
        <div class="mui-textfield ">
          <textarea name="description"><?php echo $edit_blog["description"]; ?></textarea>
          <label>Blog's Description</label>
        </div>
        <button type="submit" name="blog_edit" class="mui-btn button_blog_update">
          Update the Blog
          <span class="glyphicon glyphicon-ok"></span>
        </button>
      </form>
      <?php
    } else {
    }
    ?>
  </div>
</div>
</body>
</html>