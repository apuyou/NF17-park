<?php
require("inc/db.php");

if($_GET['id'] == 'new'){
	$nom = pg_escape_string($_POST['nom']);
	$prenom = pg_escape_string($_POST['prenom']);
	$dateNaissance = pg_escape_string($_POST['datenaissance']);
	$type = 'employe';
	$vSql ="INSERT INTO park_personne (nom, prenom, datenaissance, type) VALUES ('$nom', '$prenom', '$datenaissance', '$type');";
	pg_query($vConn, $vSql);
	$vSqlPers = "SELECT id FROM park_personne ORDER BY id DESC LIMIT 1;";
	$vQuery= pg_query($vConn, $vSqlPers);
	$pers = pg_fetch_array($vQuery, null, PGSQL_ASSOC);
	$pers_id = $pers['id'];
	$parking = $_POST['parking'];
	$poste = $_POST['poste'];
	$vSqlP = "INSERT INTO park_poste (parking, employe, occupation) VALUES ('$parking', '$pers_id', '$poste');";
	pg_query($vConn, $vSqlP);
	header("Location: employes.php");
	
}
elseif(intval($_GET['id']) > 0){
	$id = intval($_GET['id']);
	$nom = pg_escape_string($_POST['nom']);
	$prenom = pg_escape_string($_POST['prenom']);
	$dateNaissance = pg_escape_string($_POST['datenaissance']);
	$vSql ="UPDATE park_personne SET nom='$nom', prenom='$prenom', datenaissance='$datenaissance' WHERE ID=$id;";
	pg_query($vConn, $vSql);
	$parking = $_POST['parking'];
	$poste = $_POST['poste'];
	$vSqlP = "UPDATE park_poste SET parking='$parking', occupation='$poste' WHERE employe='$id';";
	pg_query($vConn, $vSqlP);
	header("Location: employes.php");
}
elseif(intval($_GET['delete']) > 0){
	$id = intval($_GET['delete']);
	pg_query($vConn, "DELETE FROM park_personne WHERE ID = $id;");
	pg_query($vConn, "DELETE FROM park_poste WHERE employe = $id;");
	header("Location: employes.php");
}
?>
