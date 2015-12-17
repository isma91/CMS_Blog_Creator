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
      <a href="./?page=panel" class="mui-btn retour">Back <span class="glyphicon glyphicon-share-alt"></span></a>
      <?php
      if (isset($posts)) {
        if (count($posts) !== 0) {
          foreach ($posts as $post) {
            ?>
            <div class="mui-panel">
              <div class="mui-panel"><h2 class="title"><?php echo $post["title"]; ?></h2></div>
              <div class="mui-panel"><p><?php echo str_replace("\n", "</br>", $post["content"]); ?></p></div>
              <div class="mui-panel"><p>Créer le <i><?php echo $post["created_at"]; ?></i></p></div>
              <form action="#" method="GET">
                <input type="hidden" name="page" value="panel">
                <input type="hidden" name="post" value="edit">
                <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>">
                <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
                <button type="submit" name="blog_edit" class="mui-btn button_blog_update">
                  Edit
                  <span class="glyphicon glyphicon-pencil"></span>
                </button>
              </form>
              <form action="#" method="GET">
                <input type="hidden" name="page" value="panel">
                <input type="hidden" name="post" value="delete">
                <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>">
                <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
                <button type="submit" name="blog_edit" class="mui-btn button_blog_remove">
                  Remove
                  <span class="glyphicon glyphicon-remove"></span>
                </button>
              </form>
            </div>
            <?php
          }
        } else {
          ?>
          <div class="mui-panel"><h2 class="title">No Post on this Blog !!</h2></div>
          <?php
        }
      }
      ?>
    </div>
  </div>
</body>
</html>