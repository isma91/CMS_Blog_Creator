<?php
session_start();
if (!file_exists('config.php')) {
	header('Location: ./install/install.php');
}
require 'autoload.php';

use controllers\UsersController;


if (isset($_GET['logout'])) {
	if (isset($_SESSION['token']) && $_SESSION['token'] == $_GET['token']) {
		session_destroy();
		header('Location:./');
	}
}
/* inscription */
if (isset($_POST['register'])) {
	$o = new UsersController();
	if ($o->create($_POST["username"], $_POST["lastname"], $_POST["firstname"] , $_POST["email"], $_POST["password"], $_POST["confirm_password"], $_POST["email"])) {
		$o->connection($_POST['username'], $_POST['password']);
	}
	$error_sign_up = $o->getError();
}
/* login */
if (isset($_POST['connection'])) {
	$o = new UsersController();
	$o->connection($_POST['log'], $_POST['password']);
	$error_sign_in = $o->getError();
	header('Location: ./?page=panel');
}

$connected = UsersController::isConnected();
//if (!$connected) {
if (isset($_GET["page"])) {
	switch ($_GET["page"]) {
		case 'connection':
		include './views/menu.php';
		include './views/connect.php';
		break;
		case 'home':
		include './views/menu.php';
		include './views/home.php';
		break;
		case 'panel':
		if ($connected) {
			include './views/panel.php';
		} else {
			include './views/connect.php';
		}
		break;
		case 'blog':
		if (isset($_GET["slug"])) {
			include './views/menu.php';
			include './views/blog.php';
		} else {
			var_dump("expression");
		}
		break;
		default:
		include 'menu.php';
		include 'home.php';
		break;
	}
} else {
	include './views/menu.php';
	include './views/home.php';
}
/*if (isset($_GET['page']) && $_GET['page'] == 'connection') {
	include './views/connect.php';
} elseif ((isset($_GET['page']) && $_GET['page'] == 'home') || !isset($_GET['page'])) {
	include './views/home.php';
} elseif (isset($_GET['page']) && $_GET['page'] == 'panel' && $connected) {
	include './views/panel.php';
} else {
	include './views/home.php';
}*/
//}