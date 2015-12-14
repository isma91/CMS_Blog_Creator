<?php
session_start();
require 'autoload.php';

use controllers\UsersController;

if (isset($_POST['register'])) {
	$o = new UsersController();
	$o->create($_POST['username'], $_POST['password'], $_POST['email']);
	$error = $o->getError();
}
?>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="style.css">
	<meta charset="utf-8">
</head>
<body>
	<div class="container">
		<form action="#" method="post" class="log form-horizontal">
			<h2>Create your account</h2>
			<div class="form-group">
				<div class="col-xs-10">

					<div class="input-group">
						<span class="input-group-addon" id="icon-amount"><span class="glyphicon glyphicon-user"></span></span>
						<input type="text" name="username" id="username" placeholder="Username" class="form-control input-text" required>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="col-xs-10">
				
					<div class="input-group">
						<span class="input-group-addon" id="icon-amount"><span class="glyphicon glyphicon-envelope"></span></span>
						<input type="email" name="email" id="email" placeholder="Email" class="form-control input-text" required>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="col-xs-10">
			
					<div class="input-group">
						<span class="input-group-addon" id="icon-amount"><span class="glyphicon glyphicon-envelope"></span></span>
						<input type="password" name="password" placeholder="Password" class="form-control input-text" required>
					</div>
				</div>
			</div>
			<input type="submit" name="register">
			<?= (isset($error)) ? "<p>" . $error . "</p>" : ""; ?>
		</form>
	</div>
</body>
</html>