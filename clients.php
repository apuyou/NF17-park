<?php
require("inc/db.php");
require("inc/header.php");

if(isset($_GET['id'])){
	$new = ($_GET['id'] == 'new');
	$id = intval($_GET['id']);
	if($id > 0){
		$vSql ="SELECT * FROM park_Personne WHERE ID = $id;";
		$vQuery=pg_query($vConn, $vSql);
		$park = pg_fetch_array($vQuery);
	}
	?>
	<div class="span12">
		<h1>Modifier un client</h1>
		<p></p>
		<form class="form-horizontal" action="clients_control.php?id=<?php echo $_GET['id'] ?>" method="post">
			<fieldset>
				<div class="control-group">
					<label class="control-label" for="nom">Nom</label>
					<div class="controls">
						<input type="text" class="input-xlarge" id="nom" name="nom" value="<?php echo $park['nom'] ?>">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="prenom">Prénom</label>
					<div class="controls">
						<input class="input-xlarge" id="prenom" name="prenom" value="<?php echo $park['prenom'] ?>">
					</div>
					<div class="control-group">
						<label class="control-label" for="datenaissance">Date Naissance</label>
						<div class="controls">
							<input class="input-xlarge" id="datenaissance" name="datenaissance" value="<?php echo $park['datenaissance'] ?>">
						</div>
						<div class="control-group">
							<label class="control-label" for="type">Type</label>
							<div class="controls">
								<input class="input-xlarge" id="type" name="type" value="<?php echo $park['type'] ?>">
							</div>
						</div>
						<div class="form-actions">
							<button type="submit" class="btn btn-primary">Enregistrer</button>
							<a class="btn" href="clients.php">Annuler</a>
							<button type="submit" class="btn btn-primary">Enregistrer</button>
						</div>
					</fieldset>
				</form>
			</div>
		<?php
	}
else {
	?>
	<div class="span12">
		<h1>Liste des clients</h1>
		<table class="table table-striped">
			<thead>
				<tr>
					<th>ID</th>
					<th>Nom</th>
					<th>Prénom</th>
					<th>Date de naissance</th>
					<th>Type</th>
				</tr>
			</thead>
			<tbody>
				<?php
			$vSql ="SELECT * FROM park_Personne WHERE type='abonne';";
			$vQuery=pg_query($vConn, $vSql);
			while ($park = pg_fetch_array($vQuery, null, PGSQL_ASSOC)) {
				echo '
				<tr>
					<td>'.$park['id'].'</td>
					<td><a href="clients.php?id='.$park['id'].'">'.$park['nom'].'</a></td>
					<td>'.$park['prenom'].'</td>
					<td>'.$park['datenaissance'].'</td>
					<td>'.$park['type'].'</td>
				</tr>';
			}
			?>
		</tbody>
	</table>
	<div class="form-actions">
      <a href="clients.php?id=new"><button type="button" class="btn btn-primary" >Rajouter</button></a>
    </div>
</div>
<?php
}
require("inc/footer.php");
