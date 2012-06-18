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
			$vSql ="SELECT * FROM park_reglement;";
			$vQuery=pg_query($vConn, $vSql);
			while ($park = pg_fetch_array($vQuery, null, PGSQL_ASSOC)) {
				if (strcmp($park['type'], 'abb') == 0):
					$type = 'Abonnement '.$abonne['type'];
                                        $abb_id = $park['abonnement'];
                                        $vSqlAbonne = "SELECT park_abonnement.id, park_personne.nom, park_personne.prenom,park_abonnement.type FROM park_abonnement INNER JOIN park_personne ON park_abonnement.abonne = park_personne.id WHERE park_abonnement.id = $abb_id;"; 
                                        $vQueryAbonne=pg_query($vConn, $vSqlAbonne);
                                        $abonne=pg_fetch_array($vQueryAbonne, null, PGSQL_ASSOC);
                                elseif (strcmp($park['type'], 'ticket') == 0):
					$type = 'Ticket';
               				$tick_id = $park['ticket'];
                                        $vSqlTick = "SELECT park_ticket.id, park_parking.nom FROM park_ticket INNER JOIN park_parking ON park_ticket.parking = park_parking.id WHERE park_ticket.id = $tick_id;";
                                        $vQueryTick=pg_query($vConn, $vSqlTick);
                                        $tick=pg_fetch_array($vQueryTick, null, PGSQL_ASSOC);

				endif;
				echo '
				<tr>
					<td>'.$park['id'].'</td>
					<td>'.$type.'</td>
					<td>'.$park['montant'].' €</td>
					<td>'.$park['dateenregistrement'].'</td>
					<td>';
					if (strcmp($park['type'], 'ticket') == 0):
						echo '<a href="tickets.php?id='.$tick['id'].'" class="btn">'.$tick['id'].', à '.$tick['nom'].'</a>';
					endif;
					echo '</td>
					<td>';
					if (strcmp($park['type'], 'abb') == 0):
						echo '<a href="abonnements.php?id='.$abonne['id'].'" class="btn">'.$abonne['id'].', '.$abonne['prenom'].' '.$abonne['nom'].'</a>';
					endif;
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