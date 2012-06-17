<?php
require("inc/db.php");
require("inc/header.php");

$vSql = "SELECT COUNT(DISTINCT pp.id) AS occupe FROM park_place pp, park_ticket pt WHERE utilise = 't' OR datesortie IS NULL;";
$vQuery = pg_query($vConn, $vSql);
$stat = pg_fetch_array($vQuery);
?>

<div class="hero-unit">
  <h1>Bienvenue !</h1>
  <p>Il y a actuellement <?php echo $stat['occupe'] ?> places occupées dans vos parkings.</p>
  <p><a class="btn btn-primary btn-large" href="statistiques.php">Toutes les statistiques &raquo;</a></p>
</div>

<?php
require("inc/footer.php");
