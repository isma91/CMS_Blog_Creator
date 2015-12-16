<?php
require '../autoload.php';

use controllers\BlogsController;
use controllers\PostsController;

if (isset($_GET['blog'])) {
    $page = (isset($_GET['page']) && (is_int($_GET['page']) || is_numeric($_GET['page']))) ? $_GET['page'] : 0;
    $o = new BlogsController();
    $blog = $o->getBlogBySlug($_GET['blog'], $page);
}
if (isset($_GET['post'])) {
	$o = new PostsController();
	$post = $o->readPost($_GET['post'], 1);
}
if (isset($post)) {
	echo $post;
}
if (isset($blog)) {
    echo $blog;
}