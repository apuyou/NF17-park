<?php
require("inc/db.php");

if($_GET['id'] == 'new'){
	$type = pg_escape_string($_POST['type']);
	$montant = pg_escape_string($_POST['montant']);
	$dateenregistrement = pg_escape_string($_POST['dateenregistrement']);
	$ticket = pg_escape_string($_POST['ticket']);
	$abonnement = pg_escape_string($_POST['abonnement']);
	$vSql ="INSERT INTO park_Reglement (type, montant, dateenregistrement, ticket, abonnement) VALUES ('$type', '$montant', '$dateenregistrement', '$ticket, $abonnement');";
	pg_query($vConn, $vSql);
	header("Location: reglements.php");
}
elseif(intval($_GET['id']) > 0){
	$id = intval($_GET['id']);
	$type = pg_escape_string($_POST['type']);
	$montant = pg_escape_string($_POST['montant']);
	$dateenregistrement = pg_escape_string($_POST['dateenregistrement']);
	$ticket = pg_escape_string($_POST['ticket']);
	$abonnement = pg_escape_string($_POST['abonnement']);
	$vSql ="UPDATE park_Reglement SET type='$type', montant='$montant', dateenregistrement='$dateenregistrement', ticket='$ticket', abonnement='$abonnement' WHERE ID=$id;";
	pg_query($vConn, $vSql);
	header("Location: reglements.php");
}
elseif(intval($_GET['delete']) > 0){
  $id = intval($_GET['delete']);
  pg_query($vConn, "DELETE FROM park_Reglement WHERE ID = $id");
  header("Location: reglements.php");
}
?>
