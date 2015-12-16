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
		default:
		include './views/menu.php';
		include './views/home.php';
		break;
	}
} else {
	if (isset($_GET["blog"])) {
		include './views/menu.php';
		include './views/blog.php';
	} else {
		include './views/menu.php';
		include './views/home.php';
	}
}