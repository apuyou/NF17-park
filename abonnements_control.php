<?php
require("inc/db.php");

if($_GET['id'] == 'new'){
	$nom = pg_escape_string($_POST['type']);
	$prenom = pg_escape_string($_POST['datesouscription']);
	$dateNaissance = pg_escape_string($_POST['dateexpiration']);
	$abonne = pg_escape_string($_POST['abonne']);
	$place = pg_escape_string($_POST['place']);
	$vSql ="INSERT INTO park_Abonnement (type, datesouscription, dateexpiration, abonne, place) VALUES ('$type', '$datesouscription', '$dateexpiration', '$abonne','$place');";
	pg_query($vConn, $vSql);
	header("Location: abonnements.php");
}
elseif(intval($_GET['id']) > 0){
	$nom = pg_escape_string($_POST['type']);
	$prenom = pg_escape_string($_POST['datesouscription']);
	$dateNaissance = pg_escape_string($_POST['dateexpiration']);
	$abonne = pg_escape_string($_POST['abonne']);
	$place = pg_escape_string($_POST['place']);
	$vSql ="UPDATE park_Abonnement SET type='$type', datesouscription='$datesouscription', dateexpiration='$dateexpiration', abonne='$abnne', place='$place' WHERE ID=$id;";
	pg_query($vConn, $vSql);
	header("Location: abonnements.php");
}
elseif(intval($_GET['delete']) > 0){
  $id = intval($_GET['delete']);
  pg_query($vConn, "DELETE FROM park_Abonnement WHERE ID = $id");
  header("Location: abonnements.php");
}
?>
