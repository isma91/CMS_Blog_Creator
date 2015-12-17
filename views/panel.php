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
	<meta name="description" content="panel description" />
	<title>Panel</title>
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
         <h2 class="title">Update your Account</h2>
         <div class="account">
            <form action="#" method="POST">
               <input type="hidden" name="name" value="<?php echo $_SESSION['name'];?>">
               <div class="mui-textfield ">
                  <input name="lastname" type="text" value="<?php echo $me['lastname']; ?>">
                  <label>Last Name</label>
              </div>
              <div class="mui-textfield">
                  <input name="firstname" type="text" value="<?php echo $me['firstname']; ?>">
                  <label>First Name</label>
              </div>
              <div class="mui-textfield">
                  <input name="email" type="email" value="<?php echo $me['email']; ?>">
                  <label>Email<span id="span_label_email"></span></label>
              </div>
              <button type="submit" class="mui-btn" name="user_update" id="user_update">
                  Update you Account 
                  <span class="glyphicon glyphicon-ok"></span>
              </button>
          </form>
          <form action="#" method="GET">
           <input type="hidden" name="user" value="delete">
           <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>">
           <input type="hidden" name="page" value="panel">
           <button type="submit" class="mui-btn">
              Delete your Account ? 
              <span class="glyphicon glyphicon-remove"></span>
          </button>
      </form>
  </div>
  <button class="mui-btn toggle_account">
    Display your Account
    <span class="glyphicon glyphicon-user"></span>
</button>
</div>
<div class="jumbotron">
 <h2 class="title">Here is the list of your blogs</h2>
 <div class="blogs">
    <?php foreach ($blogs as $blog) {
       ?>
       <div class="mui-panel">
          <h3><?php echo $blog['name']; ?></h3>
          <form action="#" method="GET">
             <input type="hidden" name="blog" value="edit">
             <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
             <input type="hidden" name="id" value="<?php echo $blog['id']; ?>">
             <input type="hidden" name="page" value="panel">
             <button type="submit" class="mui-btn crud_blog crud_blog_edit">
                Edit
                <span class="glyphicon glyphicon-pencil"></span>
            </button>
        </form>
        <form action="#" method="GET">
         <input type="hidden" name="blog" value="delete">
         <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
         <input type="hidden" name="id" value="<?php echo $blog['id']; ?>">
         <input type="hidden" name="page" value="panel">
         <button type="submit" class="mui-btn crud_blog">
            Remove
            <span class="glyphicon glyphicon-remove"></span>
        </button>
    </form>
    <form action="#" method="GET">
     <input type="hidden" name="post" value="create">
     <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
     <input type="hidden" name="id" value="<?php echo $blog['id']; ?>">
     <input type="hidden" name="page" value="panel">
     <button type="submit" class="mui-btn crud_blog">
         Create a post on <?php echo $blog['name']; ?>
         <span class="glyphicon glyphicon-plus"></span>
     </button>
 </form>
 <form action="#" method="GET">
     <input type="hidden" name="page" value="panel">
     <input type="hidden" name="blog" value="post">
     <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
     <input type="hidden" name="blog_id" value="<?php echo $blog['id']; ?>">
     <button type="submit" class="mui-btn crud_blog crud_blog_post">
        This blog's posts
        <span class="glyphicon glyphicon-list-alt"></span>
    </button>
</form>
</div>
<?php
}
?>
</div>
<button class="mui-btn toggle_blogs">
    Display all your blogs
    <span class="glyphicon glyphicon-folder-open"></span>
</button>
</div>
<div class="jumbotron">
 <h2 class="title">Create a Blog</h2>
 <div class="create_blog">
    <form action="#" method="POST">
       <div class="mui-textfield">
          <input name="name" type="text" id="blog_name">
          <label>Blog's Name</label>
      </div>
      <div class="mui-textfield">
          <input name="slug" type="text" id="blog_domain">
          <label>Blog's Domain</label>
      </div>
      <span id="blog_slug">.blog-creator.prod</span>
      <div class="mui-textfield">
          <textarea name="description"></textarea>
          <label>Blog's Description</label>
      </div>
      <button type="submit" name="create_blog" class="mui-btn">
        Create
        <span class="glyphicon glyphicon-plus"></span>
    </button>
</form>
</div>
<button type="submit" name="create_blog" class="mui-btn toggle_create_blog">
    Display Create Blog
    <span class="glyphicon glyphicon-plus"></span>
</button>
</div>
</div>
</body>
</html>