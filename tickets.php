<?php
require("inc/db.php");
require("inc/header.php");

if(isset($_GET['id'])){
	$new = ($_GET['id'] == 'new');
	$id = intval($_GET['id']);
	if($id > 0){
		$vSql ="SELECT pt.id, pp.id AS parkid, pt.dateentree, pt.datesortie FROM park_ticket pt
			LEFT JOIN park_parking pp ON pp.id = pt.parking
			WHERE pt.id = $id
			ORDER BY pt.dateentree DESC, pt.datesortie DESC;";
		$vQuery=pg_query($vConn, $vSql);
		$tick = pg_fetch_array($vQuery);
	}
?>
	<div class="span12">
		<h1>Modifier un ticket</h1>
		<p></p>
		<form class="form-horizontal" action="tickets_control.php?id=<?php echo $_GET['id'] ?>" method="post">
			<fieldset>
				<div class="control-group">
					<label class="control-label" for="parking">Parking</label>
					<div class="controls">
						<select class="input-xlarge" id="parking" name="parking">
						<?php
					$vSql = "SELECT id, nom FROM park_parking;";
					$vQuery = pg_query($vConn, $vSql);
					while($park = pg_fetch_array($vQuery)){
						echo '<option value="'.$park['id'].'"';
						if($park['id'] == $tick['parkid'])
							echo ' selected="selected"';
						echo '>'.$park['nom'].'</option>';
					} 
					?>
				</select>
			</div>
		</div>  
		<div class="control-group">
			<label class="control-label" for="entree">Date entrée</label>
			<div class="controls">
				<input type="text" class="input-xlarge" id="entree" name="entree" value="<?php echo $tick['dateentree'] ?>">
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="sortie">Date sortie</label>
			<div class="controls">
				<input type="text" class="input-xlarge" id="sortie" name="sortie" value="<?php echo $tick['datesortie'] ?>">
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="sortie">Montant</label>
			<div class="controls">
			<?php
			$vSqlReglement = "SELECT montant FROM park_reglement WHERE ticket=$id;";
			$vQueryReglement = pg_query($vConn, $vSqlReglement);
			$regl = pg_fetch_array($vQueryReglement);
			?>
			<input type="text" class="input-xlarge" id="montant" name="montant" value="<?php echo $regl['montant'] ?>">
		</div>
	</div>
	<div class="form-actions">
		<button type="submit" class="btn btn-primary">Enregistrer</button>
		<a class="btn" href="tickets.php">Annuler</a>
		<?php if($id > 0): ?>
			<a class="btn btn-danger" onclick="return confirm('Voulez-vous vraiment supprimer ce ticket ?');" href="tickets_control.php?delete=<?php echo $id; ?>">Supprimer</a>
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
		<h1>Tickets de paiement</h1>
		<table class="table table-striped">
			<thead>
				<tr>
					<th>ID</th>
					<th>Parking</th>
					<th>Entrée</th>
					<th>Sortie</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php
			$vSql ="SELECT pt.id, pp.nom AS parking, pt.dateentree, pt.datesortie FROM park_ticket pt
				LEFT JOIN park_parking pp ON pp.id = pt.parking
				ORDER BY pt.dateentree DESC, pt.datesortie DESC;";
			$vQuery=pg_query($vConn, $vSql);
			while ($tick = pg_fetch_array($vQuery, null, PGSQL_ASSOC)) {
				echo '<tr>
					<td>'.$tick['id'].'</td>
					<td>'.$tick['parking'].'</td>
					<td>'.$tick['dateentree'].'</td>
					<td>'.$tick['datesortie'].'</td>
					<td><a href="tickets.php?id='.$tick['id'].'" class="btn">Modifier</a>
					</tr>';
			}
			?>
			<tr>
				<td colspan="5">
					<a href="tickets.php?id=new" class="btn btn-primary">Ajouter un ticket</a>
				</td>
			</tbody>
		</table>
	</div>

	<?php
}
require("inc/footer.php");
