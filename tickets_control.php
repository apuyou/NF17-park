<?php
require("inc/db.php");

if($_GET['id'] == 'new'){
	$parkid = intval($_POST['parking']);
	$entree = pg_escape_string($_POST['entree']);
	$sortie = pg_escape_string($_POST['sortie']);
	$vSql ="INSERT INTO park_ticket (parking, dateentree, datesortie) VALUES ($parkid, '$entree', '$sortie');";
	$date = pg_escape_string(date("Y-m-d"));
	pg_query($vConn, $vSql);
	$vSqlTick = "SELECT id FROM park_ticket ORDER BY id DESC LIMIT 1;";
	$vQuery= pg_query($vConn, $vSqlTick);
	$tick = pg_fetch_array($vQuery, null, PGSQL_ASSOC);
	$id = $tick['id'];
	$montant = pg_escape_string($_POST['montant']);
	$vSqlReglement = "INSERT INTO park_reglement (type, montant, dateenregistrement, ticket) VALUES ('ticket', '$montant', '$date', '$id');";
	pg_query($vConn, $vSqlReglement);
	header("Location: tickets.php");
}
elseif(intval($_GET['id']) > 0){
	$id = intval($_GET['id']);
	$parkid = intval($_POST['parking']);
	$entree = pg_escape_string($_POST['entree']);
	$sortie = pg_escape_string($_POST['sortie']);
	// $montant = pg_escape_string($_POST['montant']);
	$vSql ="UPDATE park_ticket SET parking=$parkid, dateentree='$entree', datesortie='$sortie' WHERE id=$id;";
	pg_query($vConn, $vSql);
	$vSqlReglement ="UPDATE park_reglement SET montant='$montant' WHERE ticket=$id;";
	pg_query($vConn, $vSqlReglement);
	header("Location: tickets.php");
}
elseif(intval($_GET['delete']) > 0){
	$id = intval($_GET['delete']);
	pg_query($vConn, "DELETE FROM park_ticket WHERE ID = $id;");
	
	$vSqlReglement = "DELETE FROM park_reglement WHERE ticket = $id;";
	pg_query($vConn, $vSqlReglement);
	header("Location: tickets.php");
}
?>
