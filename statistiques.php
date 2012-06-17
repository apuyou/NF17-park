<?php
require("inc/db.php");
require("inc/header.php");
?>
<div class="span12">
  <h1>Statistiques</h1>

  <h2>Chiffres clés</h2>
  nombre de places handicapés (%)
  nombre de places total/moyen par parking
  
  
  <h2>Taux d'occupation</h2>
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
    <input type="text" name="date" value="<?php echo $_POST['date'] ?>" placeholder="Date" />
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
    
    $txOccupation = round(($stats1['placesabonnes']+$stats2['nbtickets'])/$stats1['totalplaces']*100, 2);
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
    <input type="text" name="ca" value="<?php echo $_POST['ca'] ?>" />
    <button type="submit" class="btn">Calculer !</button>    
  </form>
</div>

<?php
require("inc/footer.php");
?>
