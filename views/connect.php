<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="description" content="Créer votre blog facilement !!" />
	<title>My_Blog-Creator</title>
	<link media="all" type="text/css" rel="stylesheet" href="media/css/bootstrap.min.css" />
	<link media="all" type="text/css" rel="stylesheet" href="media/css/bootstrap-theme.min.css" />
	<link media="all" type="text/css" rel="stylesheet" href="media/css/mui.min.css" />
	<link media="all" type="text/css" rel="stylesheet" href="media/css/style.css" />
	<script src="media/js/jquery-2.1.4.min.js"></script>
	<script src="media/js/connect.js"></script>
</head>
<body>
	<div class="container">
		<nav class="navbar navbar-default">
			<div class="navbar-header">
				<a class="navbar-brand" href="?page=home">My_Blog-Creator</a>
			</div>
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					<li><a href="?page=home">Home</a></li>
					<li class="active"><a href="?page=connection">Sign in / Sign up</a></li>
				</ul>
				<div class="col-sm-3 col-md-3 pull-right">
					<form class="navbar-form">
						<div class="input-group">
							<input type="text" class="form-control" placeholder="Search" name="q">
							<div class="input-group-btn">
								<button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
							</div>
						</div>
					</form>
				</div>        
			</div>
		</nav>
		<div class="jumbotron form_sign_in">
			<h2>Sign In</h2>
			<form action="#" method="POST">
				<div class="mui-textfield">
					<input type="text" name="log" required>
					<label>Email or Username</label>
				</div>
				<div class="mui-textfield">
					<input type="password" name="password" required>
					<label>Password</label>
				</div>
				<input type="submit" name="connection" class="mui-btn" value="Sign In" />
			</form>
			<?php if (isset($error_sign_in)) {
				echo "<p>" . $error_sign_in . "</p>";
			}
			?>
		</div>
		<div class="jumbotron form_sign_up">
			<h2>Sing Up</h2>
			<form action="#" method="POST">
				<div class="mui-textfield">
					<input type="text" name="username" required>
					<label>Username</label>
				</div>
				<div class="mui-textfield">
					<input type="text" name="firstname" required>
					<label>First name</label>
				</div>
				<div class="mui-textfield">
					<input type="text" name="lastname" required>
					<label>Last name</label>
				</div>
				<div class="mui-textfield">
					<input type="email" name="email" required>
					<label>Email</label>
				</div>
				<div class="mui-textfield">
					<input type="password" name="password" id="password" required>
					<label id="label_password">Password<span id="span_label_password"></span></label>
				</div>
				<div class="mui-textfield">
					<input type="password" name="confirm_password" id="confirm_password" required>
					<label>Confirm Password<span id="span_label_confirm_password"></span></label>
				</div>
				<input type="submit" name="register" class="mui-btn" value="Sign Up" />
			</form>
			<?php if (isset($error_sign_up)) {
				echo "<p>" . $error_sign_up . "</p>";
			}
			?>
		</div>
	</div>
</body>
</html>