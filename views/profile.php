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
if (isset($_GET["profile"])) {
  if (is_numeric($_GET["profile"])) {
    $get_user_by_id = $user->getUserById($_GET["profile"]);
    if ($get_user_by_id === false) {
      $get_user_by_id = $user->getUserById(1);
    }
  } else {
    $get_user_by_id = $user->getUserById(1);
  }
}
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
    if (isset($user_error)) {
      echo '<div class="alert alert-info display-error">' . $user_error . '</div>';
    }
    ?>
    <?php echo $menu; ?>
    <h1 class="title">Welcome to <span id="user_name"><?php echo $get_user_by_id["name"]; ?></span>'s profile</h1>
    <div class="jumbotron jumbotron_profile">
      <div class="mui-panel">
        Lastname : <?php echo $get_user_by_id["lastname"]; ?>
      </div>
      <div class="mui-panel">
        Firstname : <?php echo $get_user_by_id["firstname"]; ?>
      </div>
      <div class="mui-panel">
      <span class="glyphicon glyphicon-envelope"></span>
        Email : <?php echo $get_user_by_id["email"]; ?>
      </div>
    </div>
  </div>
</body>
</html>