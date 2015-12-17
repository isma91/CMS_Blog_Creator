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
if (isset($_POST['register'])) {
	$o = new UsersController();
	if ($o->create($_POST["username"], $_POST["lastname"], $_POST["firstname"] , $_POST["email"], $_POST["password"], $_POST["confirm_password"], $_POST["email"])) {
		$o->connection($_POST['username'], $_POST['password']);
	}
	$error_sign_up = $o->getError();
}
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
			if (isset($_GET["blog"]) && $_GET["blog"] === "edit") {
				include './views/menu.php';
				include './views/edit.php';
			} elseif (isset($_GET["blog"]) && $_GET["blog"] === "post") {
				include './views/menu.php';
				include './views/panel_post.php';
			} elseif (isset($_GET["post"]) && $_GET["post"] === "edit") {
				include './views/menu.php';
				include './views/panel_post_edit.php';
			} elseif (isset($_GET["post"]) && $_GET["post"] === "create") {
				include './views/menu.php';
				include './views/panel_post_create.php';
			} else {
				include './views/menu.php';
				include './views/panel.php';
			}
		} else {
			include './views/menu.php';
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
		if (!isset($_GET["post"])) {
			include './views/menu.php';
			include './views/blog.php';
		} else {
			include './views/menu.php';
			include './views/post.php';
		}
	} else {
		include './views/menu.php';
		include './views/home.php';
	}
}