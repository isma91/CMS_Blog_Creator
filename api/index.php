<?php
require '../autoload.php';

use controllers\BlogsController;

if (isset($_GET['slug'])) {
    $page = (isset($_GET['page']) && (is_int($_GET['page']) || is_numeric($_GET['page']))) ? $_GET['page'] : 0;
    $o = new BlogsController();
    $blog = $o->getBlogBySlug($_GET['slug'], $page);
}
if (isset($blog)) {
    var_dump($blog);
}