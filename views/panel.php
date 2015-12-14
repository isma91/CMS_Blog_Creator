<!DOCTYPE html>
<html>
<head>
	<title>Admin panel</title>
	<meta charset="utf-8">
</head>
<body>
	<p>Bienvenue <?= $_SESSION['name'] ?>.</p>
	<a href="?logout=1&amp;token=<?= $_SESSION['token'] ?>">Déconnexion</a>
	
</body>
</html>