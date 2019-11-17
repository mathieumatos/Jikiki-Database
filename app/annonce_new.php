<form action="./annonce.php?new=true<?php echo "&category_id=" . $_GET["category_id"]; ?>" method="POST">
	<div class="form-group">
		<label for="nom">Nom</label>
		<input type="text" name="nom" class="form-control" />

		<label for="photo">Photo</label>
		<input type="text" name="photo" class="form-control" />

		<label for="date_limite">Date limite</label>
		<input type="date" name="date_limite" class="form-control" />

		<label for="prix_vente">Prix de vente</label>
		<input type="number" name="prix_vente" min="0" class="form-control" />

		<label for="cout_horaire">Coût horaire</label>
		<input type="number" name="cout_horaire" min="0" class="form-control" />

		<label for="description">Description</label>
		<textarea class="form-control" name="description"></textarea>

		<label for="temps_minimum_emprunt">Temps minimum d'emprunt</label>
		<input type="number" name="temps_minimum_emprunt" min="0" class="form-control" />

		<label for="latitude">Latitude</label>
		<input type="number" name="latitude" min="-85" max="85" class="form-control" />

		<label for="longitude">Longitude</label>
		<input type="number" name="longitude" min="-180" max="180" class="form-control" />
	</div>
	<input type="submit" value="Sauvegarder changements" class="btn btn-success" />
</form>