<div class="border p-1 mb-3">
	<div class="font-weight-bold text-center mb-1">
		<?php echo $row[1] ?>
	</div>
<?php
// For each attribute value possible
$result = db_request($db, "SELECT DISTINCT valeur FROM jikiki.valeurattribut WHERE attribut_id = " . $row[0] . ";");
while ($r = pg_fetch_row($result)) {
    include "recherche_valeurattribut.php";
}
?>
</div>
