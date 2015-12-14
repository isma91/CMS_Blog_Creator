<html>
<head>
	<title>Register</title>
	<link rel="stylesheet" type="text/css" href="media/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="media/css/style.css">
	<meta charset="utf-8">
</head>
<body>
	<div class="container">
		<div id="register" style="<?= (isset($error_sign_in)) ? 'display:none;' : 'display:block;' ?>">
			<form action="#" method="post" class="log form-horizontal">
				<h2>Sign up <small><a href="#" onclick="showSignIn()">Have an account ?</a></small></h2>
				<div class="form-group">
					<div class="col-xs-10">
						<div class="input-group">
							<span class="input-group-addon" id="base-username">Username</span>
							<input type="text" name="username" id="username" placeholder="Username" class="form-control input-text" aria-describedby="base-username" required>
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="col-xs-10">
						<div class="input-group">
							<span class="input-group-addon" id="base-email">Email</span>
							<input type="email" name="email" id="email" placeholder="Email" class="form-control input-text" aria-describedby="base-email" required>
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="col-xs-10">
						<div class="input-group">
							<span class="input-group-addon" id="base-password">Password</span>
							<input type="password" name="password" placeholder="Password" class="form-control input-text" aria-describedby="base-password" required>
						</div>
					</div>
				</div>
				<input type="submit" name="register" class="btn btn-default dropdown-toggle">
				<?= (isset($error_sign_up)) ? "<p>" . $error_sign_up . "</p>" : ""; ?>
			</form>
		</div>
		<div id="connection" style="<?= (isset($error_sign_in)) ? 'display:block;' : 'display:none;' ?>">
			<form action="#" method="post" class="log form-horizontal">
				<h2>Sign in <small><a href="#" onclick="showSignUp()">Haven't an account ?</a></small></h2>
				<div class="form-group">
					<div class="col-xs-10">
						<div class="input-group">
							<span class="input-group-addon" id="base-log">Login</span>
							<input type="text" name="log" id="log" placeholder="Email or username" class="form-control input-text" aria-describedby="base-log" required>
						</div>
					</div>
				</div>

				<div class="form-group">
					<div class="col-xs-10">
						<div class="input-group">
							<span class="input-group-addon" id="base-password">Password</span>
							<input type="password" name="password" placeholder="Password" class="form-control input-text" aria-describedby="base-password" required>
						</div>
					</div>
				</div>
				<input type="submit" name="connection" class="btn btn-default dropdown-toggle">
				<?= (isset($error_sign_in)) ? "<p>" . $error_sign_in . "</p>" : ""; ?>
			</form>
		</div>
	</div>
	<script type="text/javascript" src="media/js/script.js"></script>
</body>
</html>