<?php
include "db.php";

session_start();

if (!isset($_SESSION["user_id"])) // If not logged in
{
    if (!isset($_POST["username"]) || !isset($_POST["password"])) { // If invalid login format
        header("Location: ./index.php?failed=true");
        die();
    }
    $db = db_connect();
    $result = db_request($db, "SELECT id FROM jikiki.utilisateur WHERE username='" . $_POST["username"] . "' AND password='" . $_POST["password"] . "';");
    db_close($db);
    if (!($row = pg_fetch_row($result))) { // If invalid login
        header("Location: ./index.php?failed=true");
        die();
    }

    // Successfull login
    $_SESSION["user_id"] = $row[0];
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
		<link rel="stylesheet" type="text/css" media="screen" href="css/menu.css" />
	</head>
	<body>
		<div class="modal" tabindex="-1" role="dialog" id="popup">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-body">
						<form action="./annonce.php" method="GET">
							<select name="category_id" class="form-control">
<?php
$db = db_connect();
$result = db_request($db, "SELECT * FROM jikiki.categorie;");
while ($row = pg_fetch_row($result)) {
    echo '<option value="' . $row[0] . '">' . $row[1] . '</option>';
}
?>
							</select>
							<input type="submit" class="btn btn-primary" value="Créer l'annonce" />
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
						</form>
					</div>
				</div>
			</div>
		</div>

		<div class="container">
			<form action="./menu.php" method="POST" class="d-flex flex-wrap">
				<input type="submit" value="Chercher" formaction="./recherche.php" class="btn btn-primary btn-lg" />
				<input type="submit" value="Voir mes annonces" formaction="./liste_annonces.php" class="btn btn-primary btn-lg" />
				<input type="button" value="Créer une annonce" data-toggle="modal" data-target="#popup" class="btn btn-primary btn-lg" />
				<input type="submit" value="Mon profil" formaction="./profil.php" class="btn btn-primary btn-lg" />
				<input type="submit" value="Déconnexion" formaction="./index.php" class="btn btn-danger btn-lg" />
			</form>
		</div>

		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	</body>
</html>
