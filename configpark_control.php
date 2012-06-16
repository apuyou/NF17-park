<?php
require("inc/db.php");

if(isset($_GET['editetage'])){
  $new = ($_GET['editetage'] == 'new');
  $etage = pg_escape_string($_POST['etage']);
  $max = pg_escape_string($_POST['max']);
  $parking = intval($_GET['parking']);
  if($new){
    $vSql ="INSERT INTO park_etage (etage, maxnbplaces, parking) VALUES ('$etage', '$max', '$parking');";
    pg_query($vConn, $vSql);
    header("Location: configpark.php?id=$parking");
  }
  else {
    $etageid = intval($_GET['editetage']);
    $vSql ="UPDATE park_etage SET etage='$etage', maxnbplaces='$max', parking=$parking WHERE id = $etageid";
    pg_query($vConn, $vSql);
    header("Location: configpark.php?id=$parking&etage=$etageid");
  }
}
elseif(isset($_GET['deletage'])){
  $id = intval($_GET['deletage']);
  $parking = intval($_GET['parking']);
  pg_query("DELETE FROM park_place WHERE etage = $id");
  pg_query("DELETE FROM park_etage WHERE id = $id");
  header("Location: configpark.php?id=$parking");
}
elseif(isset($_GET['editplace'])){
  $new = ($_GET['editplace'] == 'new');
  $etage = intval($_POST['etage']);
  $type = pg_escape_string($_POST['type']);
  $numero = pg_escape_string($_POST['numero']);
  $parking = intval($_GET['parking']);
  if($new){
    $vSql ="INSERT INTO park_place (etage, local_id, type, utilise) VALUES ($etage, $numero, '$type', 'f');";
    pg_query($vConn, $vSql);
    header("Location: configpark.php?id=$parking&etage=$etage");
  }
  else {
    $placeid = intval($_GET['editplace']);
    $vSql ="UPDATE park_place SET etage=$etage, local_id='$numero', type='$type' WHERE id = $placeid;";
    pg_query($vConn, $vSql);
    header("Location: configpark.php?id=$parking&etage=$etage");
  }
}
elseif(isset($_GET['delplace'])){
  $id = intval($_GET['delplace']);
  $parking = intval($_GET['parking']);
  $etage = intval($_GET['etage']);
  pg_query("DELETE FROM park_place WHERE id = $id");
  header("Location: configpark.php?id=$parking&etage=$etage");
}
?>
