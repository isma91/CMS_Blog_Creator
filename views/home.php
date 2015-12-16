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
	<script src="media/js/home.js"></script>
</head>
<body>
	<div class="container">
		<nav class="navbar navbar-default">
			<div class="navbar-header">
				<a class="navbar-brand" href="?page=home">My_Blog-Creator</a>
			</div>
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					<li class="active"><a href="?page=home">Home</a></li>
					<li><a href="?page=connection">Sign in / Sign up</a></li>
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
		<div id="last_six_blogs">
		</div>
	</div>
</body>
</html>