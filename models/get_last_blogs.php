<?php
$config = include_once './../config.php';
$dbname = "home";
$bdd = new PDO('mysql:host=' . $config['databases'][$dbname]['host'] . ';dbname=' . $config['databases'][$dbname]['dbname'], $config['databases'][$dbname]['user'], $config['databases'][$dbname]['password']);
$get_blog = $bdd->prepare('SELECT blogs.id AS "blog_id", blogs.name AS "blog_name", slug, user_id, users.name AS "username" FROM blogs INNER JOIN users ON blogs.user_id = users.id WHERE blogs.active = "1" ORDER BY blogs.created_at DESC LIMIT 6');
$get_blog->execute();
$blogs = $get_blog->fetchAll(\PDO::FETCH_ASSOC);
$array_blogs = array();
foreach ($blogs as $blog) {
	$array_blogs["blog_id"][] = $blog["blog_id"];
	$array_blogs["blog_name"][] = $blog["blog_name"];
	$array_blogs["slug"][] = $blog["slug"];
	$array_blogs["username"][] = $blog["username"];
	$array_blogs["user_id"][] = $blog["user_id"];
}
echo json_encode($array_blogs);
?>