<?php
if (!isset($_SESSION["id"]) || empty($_SESSION["id"])) {
	$user = '<li><a href="?page=connection">Sign in / Sign up</a></li>';
	$logout = "";
} else {
	$user = '<li><a href="?page=panel">Welcome ' . $_SESSION["name"] . '</a></li>';
	$logout = '<ul class="nav navbar-nav" id="logout"><li><a href="?logout=1&token=' . $_SESSION["token"] . '">' . $_SESSION["name"] . ' Logout</a></li></ul>';
}
$menu = '<nav class="navbar navbar-default">
<div class="navbar-header">
	<a class="navbar-brand" href="?page=home">My_Blog-Creator</a>
</div>
<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	<ul class="nav navbar-nav">
		<li><a href="?page=home">Home</a></li>
		' . $user . '
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
		' . $logout . '
</div>
</nav>';
?>