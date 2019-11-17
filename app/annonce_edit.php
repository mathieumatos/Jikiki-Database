<?php
$db = db_connect();
$result = db_request($db, "SELECT * FROM (
    SELECT * FROM jikiki.objet_view WHERE id = " . $_GET["object_id"] . ") AS l
    NATURAL JOIN (
        SELECT objet_id AS id, nom_attribut, val_attribut
          FROM jikiki.objet_attribut_view
    ) AS r;");
$row = pg_fetch_row($result);

echo '<form action="./annonce.php?edit=true&object_id=' . $_GET["object_id"] . '" method="POST">';
echo '	<div class="form-group">';
echo '		<label for="nom">Nom</label>';
echo '		<input type="text" name="nom" class="form-control" value="' . $row[1] . '" />';
echo '		<label for="photo">Photo</label>';
echo '		<input type="text" name="photo" class="form-control" value="' . $row[11] . '" />';
echo '		<label for="date_limite">Date limite</label>';
echo '		<input type="date" name="date_limite" class="form-control" value="' . $row[9] . '" />';
echo '		<label for="prix_vente">Prix de vente</label>';
echo '		<input type="number" name="prix_vente" min="0" class="form-control" value="' . $row[7] . '" />';
echo '		<label for="cout_horaire">Coût horaire</label>';
echo '		<input type="number" name="cout_horaire" min="0" class="form-control" value="' . $row[6] . '" />';
echo '		<label for="description">Description</label>';
echo '		<textarea class="form-control" name="description">' . $row[5] . '</textarea>';
echo '		<label for="temps_minimum_emprunt">Temps minimum d\'emprunt</label>';
echo '		<input type="number" name="temps_minimum_emprunt" min="0" class="form-control" value="' . $row[10] . '" />';
echo '		<label for="latitude">Latitude</label>';
echo '		<input type="number" name="latitude" min="-85" max="85" class="form-control" value="' . $row[12] . '" />';
echo '		<label for="longitude">Longitude</label>';
echo '		<input type="number" name="longitude" min="-180" max="180" class="form-control" value="' . $row[13] . '" />';
echo '	</div>';
?>
	<input type="submit" value="Sauvegarder changements" class="btn btn-success" />
</form>
