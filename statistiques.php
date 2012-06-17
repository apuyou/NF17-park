<?php
require("inc/db.php");
require("inc/header.php");
?>
<div class="span12">
  <h1>Statistiques</h1>

  <h2>Chiffres clés</h2>
  <?php
    $vSql = "SELECT SUM(count.c) Total, ROUND(AVG(count.c),2) Avg, SUM(counthandicap.c) Handicap, ROUND(SUM(counthandicap.c)/SUM(count.c)*100,2) AS PHandicap
      FROM (SELECT pe.parking, COUNT(pp.id) c FROM park_place pp
      INNER JOIN park_etage pe ON pe.id = pp.etage
      GROUP BY pe.parking) count
      INNER JOIN (SELECT pe.parking, COUNT(pp.id) c FROM park_place pp
      INNER JOIN park_etage pe ON pe.id = pp.etage
      WHERE pp.type = 'handicap'
      GROUP BY pe.parking) counthandicap ON counthandicap.parking = count.parking;";
    $vQuery = pg_query($vConn, $vSql);
    $stats1 = pg_fetch_array($vQuery);
  ?>
  <p>Ces données sont calculées sur l'ensemble des parkings et avec toutes les données présentes dans le système.</p>
  <ul>
    <li>Nombre de places handicapés : <?php echo $stats1['handicap'] ?> (<?php echo $stats1['phandicap'] ?> %)</li>
    <li>Nombre de places total : <?php echo $stats1['total'] ?></li>
    <li>Nombre moyen de places par parking : <?php echo $stats1['avg'] ?></li>
  </ul>
  
  <h2>Taux d'occupation à un moment donné</h2>
  <form class="well form-inline" method="post" action="statistiques.php">
    <select name="parking">
    <?php
    $vSql = "SELECT id, nom FROM park_parking;";
    $vQuery = pg_query($vConn, $vSql);
    while($park = pg_fetch_array($vQuery)){
      echo '<option value="'.$park['id'].'"';
      if($park['id'] == $_POST['parking'])
              echo ' selected="selected"';
      echo '>'.$park['nom'].'</option>';
    }
    ?>
    </select>
    <input type="text" name="date" value="<?php echo $_POST['date'] ?>" placeholder="Date/heure" />
    <button type="submit" class="btn" name="occupation">Calculer !</button>
  </form>
  <?php
  if(isset($_POST['occupation'])):
    $parkid = intval($_POST['parking']);
    $date = pg_escape_string($_POST['date']);
    $vSql = "SELECT COUNT(pp.id) AS TotalPlaces, COUNT(pa.ID) AS PlacesAbonnes FROM park_place pp
      LEFT JOIN park_abonnement pa ON pa.place = pp.id AND pa.datesouscription < '$date' AND pa.dateexpiration > '$date'
      INNER JOIN park_etage pe ON pe.id = pp.etage
      WHERE pe.parking = $parkid";
    $vQuery = pg_query($vConn, $vSql);
    $stats1 = pg_fetch_array($vQuery);
    
    $vSql = "SELECT COUNT(id) AS NbTickets FROM park_ticket WHERE dateentree < '$date' AND datesortie > '$date'";
    $vQuery = pg_query($vConn, $vSql);
    $stats2 = pg_fetch_array($vQuery);
    
    if($stats1['totalplaces'] > 0)
      $txOccupation = round(($stats1['placesabonnes']+$stats2['nbtickets'])/$stats1['totalplaces']*100, 2);
    else
      $txOccupation = 0;
  ?>
  <ul>
    <li>Total de places disponibles : <?php echo $stats1['totalplaces'] ?></li>
    <li>Places abonnés réservées : <?php echo $stats1['placesabonnes'] ?></li>
    <li>Nombre de tickets actifs : <?php echo $stats2['nbtickets'] ?></li>
    <li><b>Taux d'occupation : <?php echo $txOccupation ?> %</b></li>
  </ul>
  <?php endif; ?>
  
  <h2>CA annuel</h2>
  <form class="well form-inline" method="post" action="statistiques.php">
    Année sur laquelle il faut calculer le CA :
    <input type="text" name="annee" value="<?php echo $_POST['annee'] ?>" />
    <button type="submit" name="ca" class="btn">Calculer !</button>    
  </form>
  <?php
  if(isset($_POST['ca'])):
    $annee = pg_escape_string($_POST['annee']);
    $vSql = "SELECT type, SUM(montant) FROM park_reglement
      WHERE EXTRACT(YEAR FROM dateenregistrement) = $annee
      GROUP BY type";
    $vQuery = pg_query($vConn, $vSql);
    $ca = array();
    while($line = pg_fetch_array($vQuery)){
      $ca[$line['type']] = $line['sum'];
    }
    $total = $ca['abb'] + $ca['ticket'];
  ?>
  <ul>
    <li>CA abonnements: <?php echo number_format($ca['abb'], 2, ',', ' ') ?> €</li>
    <li>CA tickets : <?php echo number_format($ca['ticket'], 2, ',', ' ') ?> €</li>
    <li><b>CA total : <?php echo number_format($total, 2, ',', ' ') ?> €</b></li>
  </ul>
  <?php endif; ?>
  
</div>

<?php
require("inc/footer.php");
?>
