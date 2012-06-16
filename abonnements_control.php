<?php
session_start();
require("inc/db.php");
if($_GET['id'] == 'new') {
	$type = pg_escape_string($_POST['type']);
	$datesouscription = pg_escape_string($_POST['datesouscription']);
	$dateexpiration = pg_escape_string($_POST['dateexpiration']);
	$abonne = pg_escape_string($_POST['abonne']);
	$place = pg_escape_string($_POST['place']);
	$montant = pg_escape_string($_POST['montant']);
	$date = pg_escape_string(date("Y-m-d"));
	$vSql = "INSERT INTO park_abonnement (type, datesouscription, dateexpiration, abonne, place) VALUES ('$type', '$datesouscription', '$dateexpiration', '$abonne','$place');";
	pg_query($vConn, $vSql);
	$vSqlAbonne = "SELECT * FROM park_abonnement WHERE place='$place';";
	$vQuery= pg_query($vConn, $vSqlAbonne);
	$abb = pg_fetch_array($vQuery, null, PGSQL_ASSOC);
	$id = $abb['id'];
	$vSqlReglement = "INSERT INTO park_reglement (type, montant, dateenregistrement, abonnement) VALUES ('abb', '$montant', '$date', '$id');";
	pg_query($vConn, $vSqlReglement);
	$vSqlPark ="UPDATE park_place SET utilise='t' WHERE id = $place;";
	pg_query($vConn, $vSqlPark);
	header("Location: abonnements.php");
}
elseif(intval($_GET['id']) > 0) {
	$type = pg_escape_string($_POST['type']);
	$datesouscription = pg_escape_string($_POST['datesouscription']);
	$dateexpiration = pg_escape_string($_POST['dateexpiration']);
	$abonne = pg_escape_string($_POST['abonne']);
	$place = pg_escape_string($_POST['place']);
	$oldplace = pg_escape_string($_SESSION['oldplace']);
	$vSql ="UPDATE park_abonnement SET type='$type', datesouscription='$datesouscription', dateexpiration='$dateexpiration', abonne='$abonne', place='$place' WHERE ID=$id;";
	pg_query($vConn, $vSql);
	$vSqlReglement = "UPDATE park_reglement SET montant='$montant' WHERE abonnement = '$id';";
	pg_query($vConn, $vSqlReglement);
	$vSqlPark ="UPDATE park_place SET utilise='f' WHERE id = $oldplace;";
	pg_query($vConn, $vSqlPark);
	$vSqlParkS = "UPDATE park_place SET utilise='t' WHERE id = $place;";
	pg_query($vConn, $vSqlParkS);
	header("Location: abonnements.php");
}
elseif(intval($_GET['delete']) > 0) {
	$id = intval($_GET['delete']);
	$oldplace = pg_escape_string($_SESSION['oldplace']);
	$vSqlParkS = "UPDATE park_place SET utilise='f' WHERE id = $oldplace;";
	pg_query($vConn, $vSqlParkS);
	$vSqlReglement = "DELETE FROM park_reglement WHERE abonnement = $id;";
	pg_query($vConn, $vSqlReglement);
	$vSql = "DELETE FROM park_abonnement WHERE id = $id;";
	pg_query($vConn, $vSql);
	header("Location: abonnements.php");
}
?>
