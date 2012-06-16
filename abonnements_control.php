<?php
session_start();
require("inc/db.php");
if($_GET['id'] == 'new'){
	$type = pg_escape_string($_POST['type']);
	$datesouscription = pg_escape_string($_POST['datesouscription']);
	$dateexpiration = pg_escape_string($_POST['dateexpiration']);
	$abonne = pg_escape_string($_POST['abonne']);
	$place = pg_escape_string($_POST['place']);
	$vSql ="INSERT INTO park_Abonnement (type, datesouscription, dateexpiration, abonne, place) VALUES ('$type', '$datesouscription', '$dateexpiration', '$abonne','$place');";
	pg_query($vConn, $vSql);
	header("Location: abonnements.php");
	$vSqlPark ="UPDATE park_Place SET utilise='t' WHERE id = $place;";
	pg_query($vConn, $vSqlPark);
}
elseif(intval($_GET['id']) > 0){
	$type = pg_escape_string($_POST['type']);
	$datesouscription = pg_escape_string($_POST['datesouscription']);
	$dateexpiration = pg_escape_string($_POST['dateexpiration']);
	$abonne = pg_escape_string($_POST['abonne']);
	$place = pg_escape_string($_POST['place']);
	$oldplace = pg_escape_string($_SESSION['oldplace']);
	$vSql ="UPDATE park_abonnement SET type='$type', datesouscription='$datesouscription', dateexpiration='$dateexpiration', abonne='$abonne', place='$place' WHERE ID=$id;";
	pg_query($vConn, $vSql);
	header("Location: abonnements.php");
	$vSqlPark ="UPDATE park_place SET utilise='f' WHERE id = $oldplace;";
	pg_query($vConn, $vSqlPark);
	$vSqlParkS = "UPDATE park_place SET utilise='t' WHERE id = $place;";
	pg_query($vConn, $vSqlParkS);
}
elseif(intval($_GET['delete']) > 0){
	$id = intval($_GET['delete']);
	$oldplace = pg_escape_string($_SESSION['oldplace']);
	pg_query($vConn, "DELETE FROM park_Abonnement WHERE ID = $id");
	header("Location: abonnements.php");
	$vSqlParkS = "UPDATE park_place SET utilise='f' WHERE id = $oldplace;";
	pg_query($vConn, $vSqlParkS);
}
?>
