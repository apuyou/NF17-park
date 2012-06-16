<?php
require("inc/db.php");

if($_GET['id'] == 'new'){
  $parkid = intval($_POST['parking']);
  $entree = pg_escape_string($_POST['entree']);
  $sortie = pg_escape_string($_POST['sortie']);
  $vSql ="INSERT INTO park_ticket (parking, dateentree, datesortie) VALUES ($parkid, '$entree', '$sortie');";
  pg_query($vConn, $vSql);
  header("Location: tickets.php");
}
elseif(intval($_GET['id']) > 0){
  $id = intval($_GET['id']);
  $parkid = intval($_POST['parking']);
  $entree = pg_escape_string($_POST['entree']);
  $sortie = pg_escape_string($_POST['sortie']);
  $vSql ="UPDATE park_ticket SET parking=$parkid, dateentree='$entree', datesortie='$sortie' WHERE id=$id;";
  pg_query($vConn, $vSql);
  header("Location: tickets.php");
}
elseif(intval($_GET['delete']) > 0){
  $id = intval($_GET['delete']);
  pg_query($vConn, "DELETE FROM park_ticket WHERE ID = $id");
  header("Location: tickets.php");
}
?>
