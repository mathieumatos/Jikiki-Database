<?php

include "db.php";

session_start();

if (!isset($_SESSION["user_id"])) // If not logged in
{
    header("Location: ./index.php");
    die();
}

$db = db_connect();
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
	<link rel="stylesheet" type="text/css" media="screen" href="css/liste_annonces.css" />
</head>
<body>
	<button class="btn btn-danger fixed-top back" onclick="window.location = './menu.php';">Retour au menu</button>

	<div class="container">
		<div class="row">
			<div class="col">
<?php
// For each object
$result = db_request($db, "SELECT * FROM jikiki.objet_view WHERE vendeur_id = " . $_SESSION["user_id"] . ";");

while ($row = pg_fetch_row($result)) {
    include "liste_annonce_objet.php";
}
?>
			</div>
		</div>
	</div>
</body>
</html>