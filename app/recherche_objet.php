<div class="row rounded border border-secondary bg-light p-2 mb-3 obj">
	<div class="col-10">
		<div class="row">
			<div class="col-3 loc">
				<img src="<?php echo $row[11]; ?>" class="img-thumbnail" />
			</div>
			<div class="col-6">
				<div class="row m-2 font-weight-bold">
					<?php echo $row[1] ?>
				</div>
				<div class="row m-2">
					<?php echo $row[3] ?>
				</div>
				<div class="row m-2">
					<?php echo $row[5] ?>
				</div>
			</div>
			<div class="col-3">
				<div class="row m-2">
<?php
if ($row[9] == null) {
    echo $row[7] . "$";
} else {
    echo $row[6] . "$/h";
}
?>
				</div>
				<div class="row m-2">
				Temps minimum d'emprunt :
					<?php echo $row[10] ?> journée
				</div>
				<div class="row m-2">
				Emplacement :
					<?php echo $row[12] . ", " . $row[13] ?>
				</div>
			</div>
		</div>
		<div class="row">
<?php
$result2 = db_request($db, "SELECT * FROM jikiki.objet_attribut_view WHERE objet_id = " . $row[0] . ";");
while ($r = pg_fetch_row($result2)) {
    include "recherche_objet_attribut.php";
}
?>
		</div>
	</div>
	<div class="col-2 loc">
		<button class="btn btn-primary mx-auto loc-item" onclick="alert('Communiquer avec le propriétaire au : <?php echo $row[4]; ?>');">Contacter</button>
	</div>
</div>
