<?php
session_start();
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
					<label class="control-label" for ="type">Type</label>
					<div class="controls">
						<?php
						$vSqlAb = "SELECT type FROM park_abonnement WHERE id = $id;";
						$vQueryAb=pg_query($vConn,$vSqlAb);
						$abb=pg_fetch_array($vQueryAb);
						echo '<input type="radio" name="type" value="mensuel" ';
						if (strcmp($abb['type'], 'mensuel') == 0):
							echo ' checked';
						endif;
						echo '> Mensuel </input>';
						echo '<input type="radio" name="type" value="annuel"';
						if (strcmp($abb['type'], 'annuel') == 0):
							echo ' checked';
						endif;
						echo '> Annuel</input>';
						?>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="montant">Montant</label>
					<div class="controls">
						<?php
						$vSqlReglement = "SELECT montant FROM park_reglement WHERE abonnement=$id;";
						$vQueryReglement = pg_query($vConn, $vSqlReglement);
						$regl = pg_fetch_array($vQueryReglement);
						?>
						<input class="input-xlarge" id="montant" name="montant" value="<?php echo $regl['montant'] ?>">
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
					<label class="control-label">Abonné</label>
					<div class="controls">
						<select name="abonne" class="btn dropdown-toggle" data-toggle="abonne">
							<?php
							$vSql = "SELECT id, prenom, nom FROM park_vabonne;";
							$vQuery=pg_query($vConn, $vSql);
							while ($abonne = pg_fetch_array($vQuery, null, PGSQL_ASSOC)) {
								echo '<option value ='.$abonne['id'];
								if ($abonne['id'] == $park['abonne']):
									echo ' selected="selected"';
								endif;
								echo '>'.$abonne['prenom'].' '.$abonne['nom'].'</option>';
							}?>
						</select>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">Place</label>
					<div class="controls">
						<select name="place" class="btn dropdown-toggle" data-toggle="place">
							<?php
							$vSql = "SELECT park_place.id, park_place.local_id, park_place.etage, park_place.utilise, park_place.type, park_etage.etage, park_parking.nom FROM (park_place INNER JOIN park_etage ON park_place.etage = park_etage.id) INNER JOIN park_parking ON park_etage.parking = park_parking.id ORDER BY park_parking.nom, park_etage.etage, park_place.local_id;";
							$vQuery=pg_query($vConn, $vSql);
							while ($place = pg_fetch_array($vQuery, null, PGSQL_ASSOC)) {
								if ($place['id'] == $park['place']):
									$_SESSION['oldplace'] = $place['id'];
									echo '<option value='.$place['id'].' selected="selected">** Place '.$place['local_id'].', étage '.$place['etage'].', '.$place['nom'].' **';
								elseif ($place['utilise'] == 't'): {
									echo '';
								}
								else:
									echo '<option value='.$place['id'].'>Place '.$place['local_id'].', étage '.$place['etage'].', '.$place['nom'];
									if (strcmp($place['type'], 'handicap') == 0):
										echo ' (handicap)';
									endif;
								endif;
							}
							?>
						</select>
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
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
			<?php
			$vSql ="SELECT * FROM park_abonnement;";
			$vQuery=pg_query($vConn, $vSql);
			while ($park = pg_fetch_array($vQuery, null, PGSQL_ASSOC)) {
				$abb_id = $park['abonne'];
				$place_id = $park['place'];
				$vSqlNom="SELECT nom, prenom FROM park_personne WHERE id = $abb_id;";
				$vQueryS=pg_query($vConn, $vSqlNom);
				$abonneS = pg_fetch_array($vQueryS, null, PGSQL_ASSOC);
				$vSql = "SELECT park_place.id, park_place.local_id, park_place.etage, park_etage.etage, park_parking.nom FROM (park_place INNER JOIN park_etage ON park_place.etage = park_etage.id) INNER JOIN park_parking ON park_etage.parking = park_parking.id WHERE park_place.id = $place_id;";
				$vQueryP=pg_query($vConn, $vSql);
				$place = pg_fetch_array($vQueryP, null, PGSQL_ASSOC);
				echo '
				<tr>
					<td>'.$park['id'].'</td>
					<td>'.$park['type'].'</td>
					<td>'.$park['datesouscription'].'</td>
					<td>'.$park['dateexpiration'].'</td>
					<td>'.$abonneS['prenom'].' '.$abonneS['nom'].'</td>
					<td>Place '.$place['local_id'].', étage '.$place['etage'].', '.$place['nom'].'</td>
					<td><a href="abonnements.php?id='.$park['id'].'" class="btn">Modifier</a></td>
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
