<?php
require '../autoload.php';

use controllers\BlogsController;
use controllers\PostsController;

if (isset($_GET['blog'])) {
    $limit = (isset($_GET['limit']) && (is_int($_GET['limit']) || is_numeric($_GET['limit']))) ? $_GET['limit'] : 10;
    $o = new BlogsController();
    $blog = $o->getBlogBySlug($_GET['blog'], $limit);
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