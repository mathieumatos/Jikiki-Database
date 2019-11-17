<?php

session_start();

include "db.php";

if (isset($_GET["new"]) && $_POST["password"] == $_POST["password_confirm"]) {
    $db = db_connect();
    $emplacement_id = pg_fetch_row(db_request($db, "INSERT INTO jikiki.emplacement (lat, lon)
		VALUES (" . $_POST["latitude"] . ", " . $_POST["longitude"] . ")
		RETURNING id;"))[0];

    $_SESSION["user_id"] = pg_fetch_row(db_request($db, "INSERT INTO jikiki.utilisateur (
			username, password, email, full_name, telephone, emplacement_id
		) VALUES ('"
        . $_POST["username"] . "','"
        . $_POST["password"] . "','"
        . $_POST["email"] . "','"
        . $_POST["full_name"] . "','"
        . $_POST["phone"] . "',"
        . $emplacement_id . ");"
    ))[0];

    header("Location: ./index.php");
    die();
} else if (isset($_GET["edit"])) {
    $db = db_connect();

    $emplacement_id = pg_fetch_row(db_request($db, "INSERT INTO jikiki.emplacement (lat, lon)
		VALUES (" . $_POST["latitude"] . ", " . $_POST["longitude"] . ")
		RETURNING id;"))[0];

    if ($_POST["password"] != "" && $_POST["password"] == $_POST["password_confirm"]) {
        $result = db_request($db, "UPDATE jikiki.utilisateur SET " .
            "username = '" . $_POST["username"] . "'," .
            "password = '" . $_POST["password"] . "'," .
            "email = '" . $_POST["email"] . "'," .
            "full_name = '" . $_POST["full_name"] . "'," .
            "telephone = '" . $_POST["phone"] . "'," .
            "emplacement_id = '" . $emplacement_id . "'" .
            "WHERE id = " . $_SESSION["user_id"] . ";");
    } else {
        $result = db_request($db, "UPDATE jikiki.utilisateur SET " .
            "username = '" . $_POST["username"] . "'," .
            "email = '" . $_POST["email"] . "'," .
            "full_name = '" . $_POST["full_name"] . "'," .
            "telephone = '" . $_POST["phone"] . "'," .
            "emplacement_id = '" . $emplacement_id . "'" .
            "WHERE id = " . $_SESSION["user_id"] . ";");
    }

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
</head>
<body>
	<button class="btn btn-danger fixed-top back" onclick="window.location = './menu.php';">Retour au menu</button>

	<div class="container">
<?php

if (isset($_SESSION["user_id"])) {
    include "profil_form_edit.php";
} else {
    include "profil_form_new.php";
}
?>
	</div>
</body>
</html>
