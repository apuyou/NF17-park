<?php
require("inc/db.php");
require("inc/header.php");

if(isset($_GET['id'])){
	$new = ($_GET['id'] == 'new');
	$id = intval($_GET['id']);
	if($id > 0){
		$vSql ="SELECT * FROM park_Abonnement WHERE ID = $id;";
		$vQuery=pg_query($vConn, $vSql);
		$park = pg_fetch_array($vQuery);
	}
	?>
	<div class="span12">
		<h1>Modifier un abonnement</h1>
		<p></p>
		<form class="form-horizontal" action="abonnements_control.php?id=<?php echo $_GET['id'] ?>" method="post">
			<fieldset>
				<div class="control-group">
					<label class="control-label" for="type">Type</label>
					<div class="controls">
						<input type="text" class="input-xlarge" id="type" name="type" value="<?php echo $park['type'] ?>">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="datesouscription">Date souscription</label>
					<div class="controls">
						<input class="input-xlarge" id="datesouscription" name="datesouscription" value="<?php echo $park['datesouscription'] ?>">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="dateexpiration">Date Expiration</label>
					<div class="controls">
						<input class="input-xlarge" id="dateexpiration" name="dateexpiration" value="<?php echo $park['dateexpiration'] ?>">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="abonne">Abonné</label>
					<div class="controls">
						<input class="input-xlarge" id="abonne" name="abonne" value="<?php echo $park['abonne'] ?>">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">Abonne2</label>
					<div class="controls">
						<select name="dropdown" class="btn dropdown-toggle" data-toggle="dropdown">
							<?php
							$vSql = "SELECT * FROM park_vabonne;";
							$vQuery=pg_query($vConn, $vSql);
							
							while ($abonne = pg_fetch_array($vQuery, null, PGSQL_ASSOC)) {
								echo '<option value ='.$abonne['id'].'>'.$abonne['prenom'].' '.$abonne['nom'].'</option>';
							}?>
						</select>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="place">Place</label>
					<div class="controls">
						<input class="input-xlarge" id="place" name="place" value="<?php echo $park['place'] ?>">
					</div>
				</div>

				<div class="form-actions">
					<button type="submit" class="btn btn-primary">Enregistrer</button>
					<a class="btn" href="abonnements.php">Annuler</a>
					<?php if($id > 0): ?>
						<a class="btn btn-danger" onclick="return confirm('Voulez-vous vraiment supprimer cette client ?');" href="abonnements_control.php?delete=<?php echo $id; ?>">Supprimer</a>
					<?php endif; ?>
				</div>
					</fieldset>
				</form>
			</div>
		<?php
	}
else {
	?>
	<div class="span12">
		<h1>Liste des abonnements</h1>
		<table class="table table-striped">
			<thead>
				<tr>
					<th>ID</th>
					<th>Type</th>
					<th>Date Souscription</th>
					<th>Date Expiration</th>
					<th>Abonné</th>
					<th>Place</th>
				</tr>
			</thead>
			<tbody>
			<?php
			$vSql ="SELECT * FROM park_Abonnement;";
			$vQuery=pg_query($vConn, $vSql);
			while ($park = pg_fetch_array($vQuery, null, PGSQL_ASSOC)) {
				echo '
				<tr>
					<td><a href="abonnements.php?id='.$park['id'].'">'.$park['id'].'</a></td>
					<td>'.$park['type'].'</td>
					<td>'.$park['datesouscription'].'</td>
					<td>'.$park['dateexpiration'].'</td>
					<td>'.$park['abonne'].'</td>
					<td>'.$park['place'].'</td>
				</tr>';
			}
			?>
		</tbody>
	</table>
	<div class="form-actions">
      <a href="abonnements.php?id=new"><button type="button" class="btn btn-primary" >Rajouter</button></a>
    </div>
</div>
<?php
}
require("inc/footer.php");
