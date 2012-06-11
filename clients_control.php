<?php
require("inc/db.php");

if($_GET['id'] == 'new'){
	$nom = pg_escape_string($_POST['nom']);
	$prenom = pg_escape_string($_POST['prenom']);
	$dateNaissance = pg_escape_string($_POST['datenaissance']);
	$type = 'abonne';
	$vSql ="INSERT INTO park_Personne (nom, prenom, datenaissance, type) VALUES ('$nom', '$prenom', '$datenaissance', '$type');";
	pg_query($vConn, $vSql);
	header("Location: clients.php");
}
elseif(intval($_GET['id']) > 0){
	$id = intval($_GET['id']);
	$nom = pg_escape_string($_POST['nom']);
	$prenom = pg_escape_string($_POST['prenom']);
	$dateNaissance = pg_escape_string($_POST['datenaissance']);
	$type = pg_escape_string($_POST['type']);
	$vSql ="UPDATE park_Personne SET nom='$nom', prenom='$prenom', datenaissance='$datenaissance', type='$type' WHERE ID=$id;";
	pg_query($vConn, $vSql);
	header("Location: clients.php");
}
elseif(intval($_GET['delete']) > 0){
  $id = intval($_GET['delete']);
  pg_query($vConn, "DELETE FROM park_Personne WHERE ID = $id");
  header("Location: clients.php");
}
?>
