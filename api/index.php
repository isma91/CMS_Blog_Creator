<?php
session_start();
require '../autoload.php';

use controllers\BlogsController;
use controllers\PostsController;
use controllers\CommentsController;
use controllers\CategoriesController;
use controllers\MailsController;

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
	echo $o->create($_POST['post_id'], $_POST['content'], $_POST['title']);
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