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

if (isset($_POST['register'])) {
	$o = new UsersController();
	if ($o->create($_POST['username'], $_POST['password'], $_POST['email'])) {
		$o->connection($_POST['username'], $_POST['password']);
	}
	$error_sign_up = $o->getError();
}

if (isset($_POST['connection'])) {
	$o = new UsersController();
	$o->connection($_POST['log'], $_POST['password']);
	$error_sign_in = $o->getError();
}

$connected = UsersController::isConnected();
if (!$connected) {
	include './views/log.php';
} else {
	include './views/panel.php';
}