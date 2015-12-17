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
	<title>Admin panel</title>
	<meta charset="utf-8">
	<style type="text/css">
	#user {
		display: none;
	}
	</style>
</head>
<body>
	<a href="?logout=1&amp;token=<?= $_SESSION['token'] ?>">Déconnexion</a>
	<p>Bienvenue <?= $_SESSION['name'] ?>.</p>
	<div id="blog">
		<?= (isset($blog_error)) ? $blog_error : ""; ?>
		<?php
		if (isset($edit_blog) && !empty($edit_blog)) {
			var_dump('edit');
			?>
			<fieldset>
				<legend>Edit my blog</legend>
				<a href="./">Back</a>
				<form action="#" method="post">
					Name : <input type="text" name="name" value="<?= $edit_blog['name']; ?>">
					Slug : <input type="text" name="slug" value="<?= $edit_blog['slug']; ?>">
					<input type="hidden" name="id" value="<?= $edit_blog['id']; ?>">
					<input type="hidden" name="token" value="<?= $_SESSION['token']; ?>">
					Description :<textarea name="description"><?= $edit_blog['description']; ?></textarea>
					<input type="submit" name="blog_edit">
				</form>
			</fieldset>
			<?php
		} else {
			?>
			<fieldset>
				<legend>Create a blog !</legend>
				<form action="#" method="post">
					<label for="name">Blog's name : </label><input type="text" name="name" id="name">
					<label for="domain">Blog's domain : </label><input type="text" name="slug" id="slug">
					<label for="description">Blog's description : </label><textarea name="description" id="description"></textarea>
					<input type="submit" name="create_blog">
				</form>
			</fieldset>
			<fieldset>
				<legend>My blogs</legend>
				<ul>
					<?php foreach ($blogs as $blog) { ?>
					<li><?= $blog['name']; ?> - 
						<a href="?blog=edit&amp;token=<?= $_SESSION['token'] ?>&amp;id=<?= $blog['id'] ?>&amp;page=panel">edit</a> - 
						<a href="?blog=delete&amp;token=<?= $_SESSION['token'] ?>&amp;id=<?= $blog['id'] ?>&amp;page=panel">delete</a> - 
						<a href="?blog=post&amp;token=<?= $_SESSION['token'] ?>&amp;blog_id=<?= $blog['id'] ?>&amp;page=panel">posts</a>
					</li>
					<?php } ?>
				</ul>
			</fieldset>

			<?php	
		}
		?>
	</div>
	<div id="user">
		<?= (isset($user_error)) ? $user_error : ""; ?>
		<fieldset>
			<legend>Update your account</legend>
			<form action="#" method="post">
				firstname <input type="text" value="<?= $me['firstname']; ?>" name="firstname">
				lastname <input type="text" value="<?= $me['lastname']; ?>" name="lastname">
				name <input type="text" value="<?= $me['name']; ?>" name="name">
				email <input type="text" value="<?= $me['email']; ?>" name="email">
				<input type="submit" name="user_update">
			</form>
			<a href="?user=delete&amp;token=<?= $_SESSION['token'] ?>&amp;page=panel">Remove my account ? :(</a>
		</fieldset>
	</div>
	<div id="posts">
		<?php if (isset($posts)) { ?>
		<fieldset>
			<legend>My posts</legend>
			<ul>
				<?php foreach ($posts as $post) { ?>
				<li><?php echo $post['title']; ?> - 
					<a href="?post=edit&amp;post_id=<?php echo $post['id']; ?>&amp;token=<?php echo $_SESSION['token']; ?>&amp;page=panel">edit</a> - 
					<a href="?post=delete&amp;post_id=<?php echo $post['id']; ?>&amp;token=<?php echo $_SESSION['token']; ?>&amp;page=panel">delete</a>
				</li>
				<?php } ?>
			</ul>
			<form action="#" method="post">
				<p>Create new post :</p>
				<input type="text" name="title">
				<textarea name="content"></textarea>
				<input type="submit" name="create_post">
			</form>
		</fieldset>
		<?php } ?>

		<?php if (isset($one)) { ?>
		<fieldset>
			<legend>Edit article</legend>
			<?php echo (isset($post_error)) ? $post_error : ""; ?>
			<form action="#" method="post">
				<input type="text" name="title" value="<?php echo $one['title']; ?>"></input>
				<textarea name="content"><?php echo $one['content']; ?></textarea>
				<input type="submit" name="post_update">
			</form>
		</fieldset>
		<?php } ?>
	</div>
</body>
</html>