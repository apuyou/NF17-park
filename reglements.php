<?php
require("inc/db.php");
require("inc/header.php");
?>
	<div class="span12">
		<h1>Liste des règlements</h1>
		<table class="table table-striped">
			<thead>
				<tr>
					<th>ID</th>
					<th>Type</th>
					<th>Montant</th>
					<th>Date d'enregistrement</th>
					<th>Ticket</th>
					<th>Abonnement</th>
				</tr>
			</thead>
			<tbody>
				<?php
			$vSql ="SELECT pr.type, pr.id, ppe.nom, ppe.prenom, pa.type AS typeabo, pt.id AS tickid, pa.id AS aboid, pr.montant, pr.dateenregistrement, ppa.nom AS parking FROM park_reglement pr
			LEFT JOIN park_abonnement pa ON pa.ID = pr.abonnement
			LEFT JOIN park_personne ppe ON ppe.id = pa.abonne
			LEFT JOIN park_ticket pt ON pt.id = pr.ticket
			LEFT JOIN park_parking ppa ON ppa.id = pt.parking
			;";
			$vQuery=pg_query($vConn, $vSql);
			while ($park = pg_fetch_array($vQuery, null, PGSQL_ASSOC)) {
			  if($park['type'] == 'abb') $type = 'Abonnement';
			  elseif($park['type'] == 'ticket') $type = 'Ticket';
				echo '
				<tr>
					<td>'.$park['id'].'</td>
					<td>'.$type.' '.$park['typeabo'].'</td>
					<td>'.$park['montant'].' €</td>
					<td>'.$park['dateenregistrement'].'</td>
					<td>';
					if ($park['type'] == 'ticket')
						echo '<a href="tickets.php?id='.$park['tickid'].'" class="btn">'.$park['tickid'].', à '.$park['parking'].'</a>';
					echo '</td>
					<td>';
					if ($park['type'] == 'abb')
						echo '<a href="abonnements.php?id='.$park['aboid'].'" class="btn">'.$park['aboid'].', '.$park['prenom'].' '.$park['nom'].'</a>';
					echo '
					</td>
				</tr>';
			}
			?>
		</tbody>
	</table>
</div>
<?php
require("inc/footer.php");
?>