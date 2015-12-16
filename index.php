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
}

$connected = UsersController::isConnected();
//if (!$connected) {
	if (isset($_GET['page']) && $_GET['page'] == 'connection') {
		include './views/connect.php';
	} elseif ((isset($_GET['page']) && $_GET['page'] == 'home') || !isset($_GET['page'])) {
		include './views/home.php';
	} elseif (isset($_GET['page']) && $_GET['page'] == 'panel' && $connected) {
		include './views/panel.php';
	} else {
		include './views/home.php';
	}
//}