<?php
require("inc/db.php");

if($_GET['id'] == 'new'){
	$nom = pg_escape_string($_POST['nom']);
	$prenom = pg_escape_string($_POST['prenom']);
	$dateNaissance = pg_escape_string($_POST['datenaissance']);
	$type = 'employe';
	$vSql ="INSERT INTO park_personne (nom, prenom, datenaissance, type) VALUES ('$nom', '$prenom', '$datenaissance', '$type');";
	pg_query($vConn, $vSql);
	header("Location: employes.php");
}
elseif(intval($_GET['id']) > 0){
	$id = intval($_GET['id']);
	$nom = pg_escape_string($_POST['nom']);
	$prenom = pg_escape_string($_POST['prenom']);
	$dateNaissance = pg_escape_string($_POST['datenaissance']);
	$vSql ="UPDATE park_personne SET nom='$nom', prenom='$prenom', datenaissance='$datenaissance' WHERE ID=$id;";
	pg_query($vConn, $vSql);
	header("Location: employes.php");
}
elseif(intval($_GET['delete']) > 0){
  $id = intval($_GET['delete']);
  pg_query($vConn, "DELETE FROM park_personne WHERE ID = $id");
  header("Location: employes.php");
}
?>
