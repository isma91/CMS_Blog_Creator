<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="description" content="Créer votre blog facilement !!" />
	<title>My_Blog-Creator intallation</title>
	<link media="all" type="text/css" rel="stylesheet" href="../media/css/bootstrap.min.css" />
	<link media="all" type="text/css" rel="stylesheet" href="../media/css/bootstrap-theme.min.css" />
	<link media="all" type="text/css" rel="stylesheet" href="../media/css/mui.min.css" />
	<link media="all" type="text/css" rel="stylesheet" href="style.css" />
	<script src="../media/js/jquery-2.1.4.min.js"></script>
	<script src="install.js"></script>
</head>
<body>
	<div class="container">
	<div id="event"></div>
		<div class="jumbotron install">
			Welcome to My_Blog-Creator installation !!
			<br/>
			<button class="mui-btn toggle_install">
				Next Step
				<span class="glyphicon glyphicon-circle-arrow-right"></span>
			</button>
		</div>
		<div class="loader"></div>
		<div class="jumbotron form_install">
			<div class="div_form_install">
				<h2>Your Profile</h2>
				<div class="mui-textfield input_install floated_left">
					<input id="last_name" type="text">
					<label>Last Name</label>
				</div>
				<div class="mui-textfield input_install floated_right">
					<input id="first_name" type="text">
					<label>First Name</label>
				</div>
				<div class="mui-textfield input_install_full floated_left">
					<input id="pseudo" type="text">
					<label>Pseudo</label>
				</div>
				<div class="mui-textfield input_install floated_left">
					<input id="password" type="password">
					<label id="label_password">Password<span id="span_label_password"></span></label>
				</div>
				<div class="mui-textfield input_install floated_right">
					<input id="confirm_password" type="password">
					<label>Confirm Password<span id="span_label_confirm_password"></span></label>
				</div>
				<div class="mui-textfield input_install_full floated_left">
					<input id="email" type="text">
					<label>Email<span id="span_label_email"></span></label>
				</div>
			</div>
			<button class="mui-btn next_step_install" disabled>
				Next Step
				<span class="glyphicon glyphicon-circle-arrow-right"></span>
			</button>
		</div>
		<div class="jumbotron db_install">
			<div class="db_install">
				<h2>Database installation</h2>
				<div class="mui-textfield input_install_full">
					<input id="host" type="text" value="localhost">
					<label>Host</label>
				</div>
				<div class="mui-textfield input_install_full">
					<input id="username" type="text" value="root">
					<label>Username</label>
				</div>
				<div class="mui-textfield input_install_full">
					<input id="db_password" type="password">
					<label>Password</label>
				</div>
				<div class="mui-textfield input_install">
					<input id="db_name" type="text" value="my_blog-creator">
					<label>Database Name</label>
				</div>
				<button class="mui-btn floated_left" id="create_database">
				Create database
				<span class="glyphicon glyphicon-plus"></span>
			</button>
				<button class="mui-btn floated_left" id="check_database">
				Try connection
				<span class="glyphicon glyphicon-search"></span>
			</button>
				<button class="mui-btn floated_right" id="finish_install" disabled>
				Finish install
				<span class="glyphicon glyphicon-ok"></span>
			</button>
			</div>
		</div>
	</div>
</body>
</html>