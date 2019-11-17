<?php

session_start();

include "db.php";

if (!isset($_SESSION["user_id"])) // If not logged in
{
    header("Location: ./index.php");
    die();
}

if (isset($_GET["new"])) {
    $db = db_connect();
    $emplacement_id = pg_fetch_row(db_request($db, "INSERT INTO jikiki.emplacement (lat, lon)
		VALUES (" . $_POST["latitude"] . ", " . $_POST["longitude"] . ")
		RETURNING id;"))[0];

    $object_id = pg_fetch_row(db_request($db, "INSERT INTO jikiki.objet (
		nom, date_publication, date_limite, prix_vente,	cout_horaire, description,
		temps_min_emprunt, emplacement_id, categorie_id, proprietaire_id
	) VALUES (
		'" . $_POST["nom"] . "',
		now(),
		'" . $_POST["date_limite"] . "',
		" . $_POST["prix_vente"] . ",
		" . $_POST["cout_horaire"] . ",
		'" . $_POST["description"] . "',
		" . $_POST["temps_minimum_emprunt"] . ",
		" . $emplacement_id . ",
		" . $_GET["category_id"] . ",
		" . $_SESSION["user_id"] . "
	) RETURNING id;"))[0];

    db_request($db, "INSERT INTO jikiki.photo (chemin, objet_id) VALUES ('" . $_POST["photo"] . "', " . $object_id . ")");

    header("Location: ./menu.php");
    die();
} else if (isset($_GET["edit"])) {
    $db = db_connect();

    $emplacement_id = pg_fetch_row(db_request($db, "INSERT INTO jikiki.emplacement (lat, lon)
		VALUES (" . $_POST["latitude"] . ", " . $_POST["longitude"] . ")
		RETURNING id;"))[0];

    $result = db_request($db, "UPDATE jikiki.objet SET " .
        "nom = '" . $_POST["nom"] . "'," .
        "date_limite = '" . $_POST["date_limite"] . "'," .
        "prix_vente = '" . $_POST["prix_vente"] . "'," .
        "cout_horaire = '" . $_POST["cout_horaire"] . "'," .
        "description = '" . $_POST["description"] . "'," .
        "temps_min_emprunt = '" . $_POST["temps_minimum_emprunt"] . "'," .
        "emplacement_id = '" . $emplacement_id . "'" .
        "WHERE id = " . $_GET["object_id"] . ";");

    header("Location: ./menu.php");
    die();
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
	<link rel="stylesheet" type="text/css" media="screen" href="css/annonce.css" />
</head>
<body>
	<button class="btn btn-danger fixed-top back" onclick="window.location = './menu.php';">Retour au menu</button>

	<div class="container">
<?php
if (isset($_GET["object_id"])) {
    include "annonce_edit.php";
} else if (isset($_GET["category_id"])) {
    include "annonce_new.php";
} else {
    die("ERREUR");
}
?>
	</div>
</body>
</html>
