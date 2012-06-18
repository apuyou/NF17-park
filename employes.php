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
		<h1>Éditer un employé</h1>
		<p></p>
		<form class="form-horizontal" action="employes_control.php?id=<?php echo $_GET['id'] ?>" method="post">
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
				</div>
				<div class="control-group">
					<label class="control-label" for="datenaissance">Date de naissance</label>
					<div class="controls">
						<input class="input-xlarge" id="datenaissance" name="datenaissance" value="<?php echo $park['datenaissance'] ?>">
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label">Parking</label>
					<div class="controls">
						<select name="parking" class="btn dropdown-toggle" data-toggle="parking">
							<?php
							$vSqlP = "SELECT * FROM park_parking;";
							$vQueryP=pg_query($vConn, $vSqlP);
							while ($parking = pg_fetch_array($vQueryP, null, PGSQL_ASSOC)) {
								echo '<option value ='.$parking['id'];
								if ($parking['id'] == $park['parking']):
									echo ' selected="selected"';
								endif;
								echo '>'.$parking['nom'].'</option>';
							}?>
						</select>
					</div>
				</div>
				<div class="control-group">
					<?php
					if($park['id']> 0):
						$emp_id = $park['id'];
						$vSqlE = "SELECT occupation FROM park_poste WHERE employe = $emp_id;";
						$vQueryE = pg_query($vConn, $vSqlE);
						$poste_arr = pg_fetch_array($vQueryE, null, PGSQL_ASSOC);
						$poste = $poste_arr['occupation'];
					endif;
					?>
					<label class="control-label" for="poste">Poste</label>
					<div class="controls">
						<input class="input-xlarge" id="poste" name="poste" value="<?php echo $poste ?>">
					</div>
				</div>
				<div class="form-actions">
					<button type="submit" class="btn btn-primary">Enregistrer</button>
					<a class="btn" href="employes.php">Annuler</a>
					<?php if($id > 0): ?>
						<a class="btn btn-danger" onclick="return confirm('Voulez-vous vraiment supprimer cette client ?');" href="employes_control.php?delete=<?php echo $id; ?>">Supprimer</a>
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
		<h1>Liste des employés</h1>
		<table class="table table-striped">
			<thead>
				<tr>
					<th>ID</th>
					<th>Nom</th>
					<th>Prénom</th>
					<th>Date de naissance</th>
					<th>Poste</th>
					<th>Lieu de travail</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php
			$vSql ="SELECT * FROM park_vEmploye;";
			$vQuery=pg_query($vConn, $vSql);
			while ($park = pg_fetch_array($vQuery, null, PGSQL_ASSOC)) {
				$emp_id = $park['id'];
				$vSqlP = "SELECT park_poste.occupation, park_parking.nom FROM park_poste INNER JOIN park_parking ON park_poste.parking = park_parking.id WHERE park_poste.employe=$emp_id;";
				$vQueryP = pg_query($vConn, $vSqlP);
				$poste = pg_fetch_array($vQueryP, null, PGSQL_ASSOC);
				echo '
				<tr>
					<td>'.$park['id'].'</td>
					<td>'.$park['nom'].'</td>
					<td>'.$park['prenom'].'</td>
					<td>'.$park['datenaissance'].'</td>
					<td>'.$poste['occupation'].'</td>
					<td>'.$poste['nom'].'</td>
					<td><a href="employes.php?id='.$park['id'].'" class="btn">Modifier</a></td>
				</tr>';
			}
			?>
		</tbody>
	</table>
	<div class="form-actions">
      <a href="employes.php?id=new"><button type="button" class="btn btn-primary" >Rajouter</button></a>
    </div>
</div>
<?php
}
require("inc/footer.php");
