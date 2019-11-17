<?php

session_start();

// Always disconnect when on this page
if (isset($_SESSION["user_id"])) {
    unset($_SESSION["user_id"]);
}

?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>Jikiki</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous" />
		<link rel="stylesheet" type="text/css" media="screen" href="css/main.css" />
		<link rel="stylesheet" type="text/css" media="screen" href="css/index.css" />
	</head>
	<body>
		<img src="./img/jikiki.png" alt="Jikiki logo" class="img-fluid mx-auto d-block">
		<div class="container">
			<form action="./menu.php" method="POST">
				<div class="form-group">
					<label for="username">Nom d'utilisateur</label>
					<input type="text" name="username" class="form-control" />
					<label for="password">Mot de passe</label>
					<input type="password" name="password" class="form-control"/>
<?php
if (isset($_GET["failed"])) {
    echo '<small class="form-text text-danger">Wrong password.</small>';
}
?>
				</div>
				<input type="submit" value="Connexion" class="btn btn-success" />
				<input type="submit" value="Nouveau Compte" formaction="./profil.php" class="btn btn-primary" />
			</form>
		</div>
	</body>
</html>
