<?php
use controllers\BlogsController;
use controllers\UsersController;
?>

<?php
$user = new UsersController();
$user->render();
$me = $user->getMe();
$user_error = $user->getError();
?>

<?php
$blog = new BlogsController();
$blog->render();
$blogs = $blog->getBlogs();
$blog_error = $blog->getError();
?>



<!DOCTYPE html>
<html>
<head>
	<title>Admin panel</title>
	<meta charset="utf-8">
	<style type="text/css">
	#blog {
		
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
				<legend>My blogs</legend>
				<ul>
					<?php
					foreach ($blogs as $blog) {
						?>
						<li><?= $blog['name']; ?> - <a href="?blog=edit&amp;token=<?= $_SESSION['token'] ?>&amp;id=<?= $blog['id'] ?>">edit</a> - <a href="?blog=delete&amp;token=<?= $_SESSION['token'] ?>&amp;id=<?= $blog['id'] ?>">delete</a></li>
						<?php
					}
					?>
				</ul>
			</fieldset>

			<fieldset>
				<legend>Create a blog !</legend>
				<form action="#" method="post">
					<label for="name">Blog's name : </label><input type="text" name="name" id="name">
					<label for="domain">Blog's domain : </label><input type="text" name="slug" id="slug">
					<label for="description">Blog's description : </label><textarea name="description" id="description"></textarea>
					<input type="submit" name="create_blog">
				</form>
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
		<a href="?user=delete&amp;token=<?= $_SESSION['token'] ?>">Remove my account ? :(</a>
		</fieldset>
	</div>
</body>
</html>