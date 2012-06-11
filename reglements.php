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
					<div class="control-group">
						<label class="control-label" for="dateenregistrement">Date Enregistree</label>
						<div class="controls">
							<input class="input-xlarge" id="dateenregistrement" name="dateenregeistrement" value="<?php echo $park['dateenregistrement'] ?>">
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
			</div>
		<?php
	}
else {
	?>
	<div class="span12">
		<h1>Liste des reglementss</h1>
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
			$vSql ="SELECT * FROM park_Reglement;";
			$vQuery=pg_query($vConn, $vSql);
			while ($park = pg_fetch_array($vQuery, null, PGSQL_ASSOC)) {
				echo '
				<tr>
					<td><a href="reglements.php?id='.$park['id'].'">'.$park['id'].'</a></td>
					<td>'.$park['type'].'</td>
					<td>'.$park['montant'].'</td>
					<td>'.$park['dateenregistrement'].'</td>
					<td>'.$park['ticket'].'</td>
					<td>'.$park['abonnement'].'</td>
				</tr>';
			}
			?>
		</tbody>
	</table>
	<div class="form-actions">
      <a href="reglements.php?id=new"><button type="button" class="btn btn-primary" >Rajouter</button></a>
    </div>
</div>
<?php
}
require("inc/footer.php");
