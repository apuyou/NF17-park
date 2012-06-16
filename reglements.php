<?php
require("inc/db.php");
require("inc/header.php");

if(isset($_GET['id'])){
	$new = ($_GET['id'] == 'new');
	$id = intval($_GET['id']);
	if($id > 0){
		$vSql ="SELECT * FROM park_Reglements WHERE ID = $id;";
		$vQuery=pg_query($vConn, $vSql);
		$park = pg_fetch_array($vQuery);
	}
	?>
	<div class="span12">
		<h1>Modifier un reglement</h1>
		<p></p>
		<form class="form-horizontal" action="reglements_control.php?id=<?php echo $_GET['id'] ?>" method="post">
			<fieldset>
				<div class="control-group">
					<label class="control-label" for="nom">Type</label>
					<div class="controls">
						<input type="text" class="input-xlarge" id="type" name="type" value="<?php echo $park['type'] ?>">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="montant">Montant</label>
					<div class="controls">
						<input class="input-xlarge" id="montant" name="montant" value="<?php echo $park['montant'] ?>">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="dateenregistrement">Date Enregistree</label>
					<div class="controls">
						<input class="input-xlarge" id="dateenregistrement" name="dateenregeistrement" value="<?php echo $park['dateenregistrement'] ?>">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="ticket">Ticket</label>
					<div class="controls">
						<input class="input-xlarge" id="ticket" name="ticket" value="<?php echo $park['ticket'] ?>">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="abonnement">Abonnement</label>
					<div class="controls">
						<input class="input-xlarge" id="abonnemeng" name="abonnement" value="<?php echo $park['abonnement'] ?>">
					</div>
				</div>
				<div class="form-actions">
					<button type="submit" class="btn btn-primary">Enregistrer</button>
					<a class="btn" href="reglements.php">Annuler</a>
					<?php if($id > 0): ?>
						<a class="btn btn-danger" onclick="return confirm('Voulez-vous vraiment supprimer cette reglement ?');" href="reglements_control.php?delete=<?php echo $id; ?>">Supprimer</a>
					<?php endif; ?>
				 </div>
			</fieldset>
		</form>
	</div> <!-- span12 -->
<?php 
}
else {
?>
	<div class="span12">
		<h1>Liste des reglements</h1>
		<table class="table table-striped">
			<thead>
				<tr>
					<th>ID</th>
					<th>Type</th>
					<th>Montant</th>
					<th>Date enregistre</th>
					<th>Ticket</th>
					<th>Abonnement</th>
				</tr>
			</thead>
			<tbody>
				<?php
			$vSql ="SELECT * FROM park_reglement;";
			$vQuery=pg_query($vConn, $vSql);
			while ($park = pg_fetch_array($vQuery, null, PGSQL_ASSOC)) {
				$abb_id = $park['abonnement'];
				echo '
				<tr>
					<td><a href="reglements.php?id='.$park['id'].'">'.$park['id'].'</a></td>
					<td>'.$park['type'].'</td>
					<td>'.$park['montant'].'</td>
					<td>'.$park['dateenregistrement'].'</td>
					<td>'.$park['ticket'].'</td>';
					$vSqlAbonne = "SELECT park_abonnement.id, park_personne.nom, park_personne.prenom,park_abonnement.type FROM park_abonnement INNER JOIN park_personne ON park_abonnement.abonne = park_personne.id WHERE park_abonnement.id = $abb_id;";
					$vQueryAbonne=pg_query($vConn, $vSqlAbonne);
					$abonne=pg_fetch_array($vQueryAbonne, null, PGSQL_ASSOC);
					// print_r($abonne);
					echo '<td><a href="abonnements.php?id='.$abonne['id'].'">'.$abonne['id'].', '.$abonne['prenom'].' '.$abonne['nom'].'</a></td>
				</tr>';
			}
								// echo '<td>'.$park['abonnement'].'</td>
			?>
		</tbody>
	</table>
</div>
<?php
}
require("inc/footer.php");
?>