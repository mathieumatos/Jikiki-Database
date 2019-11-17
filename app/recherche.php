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
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
	 crossorigin="anonymous" />
	<link rel="stylesheet" type="text/css" media="screen" href="css/main.css" />
	<link rel="stylesheet" type="text/css" media="screen" href="css/recherche.css" />
	<script src="js/recherche.js"></script>
</head>
<body>
	<button class="btn btn-danger fixed-top back" onclick="window.location = './menu.php';">Retour au menu</button>

	<div class="container">
		<div class="row mb-5">
			<div class="col">
				<div class="input-group mb-3">
					<input type="text" class="form-control" id="search" placeholder="Recherche" aria-label="Recipient's username"/>
					<div class="input-group-append">
						<button class="btn btn-outline-secondary"type="button" onclick="update();">Chercher</button>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col">
<?php
// For each attribute
$result = db_request($db, "SELECT id, nom FROM jikiki.attribut;");
$rows = array();
while ($row = pg_fetch_row($result)) {
    array_push($rows, $row);
}
foreach ($rows as $row) {
    include "recherche_attribut.php";
}
?>
			</div>
			<div class="col-9">
<?php
// For each object
$result = db_request($db, "SELECT * FROM (
    SELECT * FROM jikiki.objet_view WHERE
        pub_date <= now() AND
        lim_date >= now()) AS l
    NATURAL JOIN (
        SELECT objet_id AS id, nom_attribut, val_attribut
          FROM jikiki.objet_attribut_view
    ) AS r;
");

while ($row = pg_fetch_row($result)) {
    include "recherche_objet.php";
}
?>
			</div>
		</div>
	</div>
</body>
</html>
