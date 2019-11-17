<?php
$db = db_connect();
$result = db_request($db, "SELECT username, email, full_name, telephone, lat, lon
				FROM jikiki.utilisateur JOIN jikiki.emplacement ON (jikiki.utilisateur.emplacement_id = jikiki.emplacement.id)
				WHERE jikiki.utilisateur.id = " . $_SESSION["user_id"] . ";");
$row = pg_fetch_row($result);

echo '<form action="./profil.php?edit=true" method="POST">';
echo '	<div class="form-group">';
echo '		<label for="username">Nom d\'utilisateur</label>';
echo '		<input type="text" name="username" class="form-control" value="' . $row[0] . '" />';
echo '		<label for="password">Mot de passe</label>';
echo '		<input type="password" name="password" class="form-control" />';
echo '		<label for="password_confirm">Confirmation du mot de passe</label>';
echo '		<input type="password" name="password_confirm" class="form-control" />';
echo '		<label for="email">Adresse courriel</label>';
echo '		<input type="email" name="email" class="form-control" value="' . $row[1] . '"  />';
echo '		<label for="full_name">Nom complet</label>';
echo '		<input type="text" name="full_name" class="form-control" value="' . $row[2] . '"  />';
echo '		<label for="phone">Numéro de téléphone</label>';
echo '		<input type="tel" name="phone" class="form-control" value="' . $row[3] . '"  />';
echo '		<label for="latitude">Latitude</label>';
echo '		<input type="number" name="latitude" min="-85" max="85" step="0.000001" class="form-control" value="' . $row[4] . '"  />';
echo '		<label for="longitude">Longitude</label>';
echo '		<input type="number" name="longitude" min="-180" max="180" step="0.000001" class="form-control" value="' . $row[5] . '"  />';
echo '	</div>';
echo '	<input type="submit" value="Sauvegarder changements" class="btn btn-success" />';
echo '</form>';
