<?php
session_start();
$config = require_once "./config.php";
if ($config["install"] === false) {
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
}

$connected = UsersController::isConnected();
if (!$connected) {
	if ($_GET['page'] == 'connection' && isset($_GET['page'])) {
		include './views/connect.php';
	} elseif (($_GET['page'] == 'home' && isset($_GET['page'])) || !isset($_GET['page'])) {
		include './views/home.php';
	} else {
		include './views/home.php';
	}
} else {
	include './views/panel.php';
}