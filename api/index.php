<?php
session_start();
require '../autoload.php';

use controllers\BlogsController;
use controllers\PostsController;
use controllers\CommentsController;
use controllers\CategoriesController;
use controllers\MailsController;
use controllers\UsersController;

if (isset($_GET['blog'])) {
	$limit = (isset($_GET['limit']) && (is_int($_GET['limit']) || is_numeric($_GET['limit']))) ? $_GET['limit'] : 10;
	$o = new BlogsController();
	$blog = $o->getBlogBySlug($_GET['blog'], $limit);
}
if (isset($_GET['post'])) {
	$o = new PostsController();
	$post = $o->readPost($_GET['post'], 1);
}
if (isset($_GET['comments'])) {
	$o = new CommentsController();
	$comments = $o->getCommentsByPostId($_GET['comments']);
}
if (isset($_GET['categories'])) {
	$o = new CategoriesController();
	$categories = $o->get();
}

if (isset($_POST['title']) && isset($_POST['content']) && isset($_POST['post_id']) && isset($_POST['send']) && $_POST['send'] == 'comment') {
	$o = new CommentsController();
	echo $o->create($_POST['post_id'], $_POST['content'], $_POST['title'], $_POST["note"]);
}


if (isset($_POST['vote']) && isset($_POST['comment_id']) && isset($_POST['send']) && $_POST['send'] == 'vote') {
	$o = new CommentsController();
	if ($_POST['vote'] === 'plus') {
		echo $o->setPlusComment($_POST['comment_id']);
	} elseif ($_POST['vote'] === 'minus') {
		echo $o->setMinusComment($_POST['comment_id']);
	}
}

if (isset($_GET['connected'])) {
	$connected = UsersController::isConnected();
	if ($connected) {
		echo json_encode(array('connected' => true, 'id' => $_SESSION['id'], 'token' => $_SESSION['token'], 'name' => $_SESSION['name']));
	} else {
		echo json_encode(array('connected' => false));
	}
}

if (isset($post)) {
	echo $post;
}
if (isset($blog)) {
	echo $blog;
}
if (isset($comments)) {
	echo $comments;
}
if (isset($categories)) {
	echo $categories;
}

?>