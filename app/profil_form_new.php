<form action="./profil.php?new=true" method="POST">
	<div class="form-group">
		<label for="username">Nom d'utilisateur</label>
		<input type="text" name="username" class="form-control" />
		<label for="password">Mot de passe</label>
		<input type="password" name="password" class="form-control" />
		<label for="password_confirm">Confirmation du mot de passe</label>
		<input type="password" name="password_confirm" class="form-control" />
		<label for="email">Adresse courriel</label>
		<input type="email" name="email" class="form-control" />
		<label for="full_name">Nom complet</label>
		<input type="text" name="full_name" class="form-control" />
		<label for="phone">Numéro de téléphone</label>
		<input type="tel" name="phone" class="form-control" />
		<label for="latitude">Latitude</label>
		<input type="number" name="latitude" min="-85" max="85" step="0.000001" class="form-control" />
		<label for="longitude">Longitude</label>
		<input type="number" name="longitude" min="-180" max="180" step="0.000001" class="form-control" />
	</div>
	<input type="submit" value="Sauvegarder changements" class="btn btn-success" />
</form>
