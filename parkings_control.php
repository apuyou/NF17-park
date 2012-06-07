<?php
require("inc/db.php");

if($_GET['id'] == 'new'){
  $nom = pg_escape_string($_POST['nom']);
  $adresse = pg_escape_string($_POST['adresse']);
  $vSql ="INSERT INTO park_Parking (nom, adresse) VALUES ('$nom', '$adresse');";
  pg_query($vConn, $vSql);
  header("Location: parkings.php");
}
elseif(intval($_GET['id']) > 0){
  $id = intval($_GET['id']);
  $nom = pg_escape_string($_POST['nom']);
  $adresse = pg_escape_string($_POST['adresse']);
  $vSql ="UPDATE park_Parking SET nom='$nom', adresse='$adresse' WHERE ID=$id;";
  pg_query($vConn, $vSql);
  header("Location: parkings.php");
}
elseif(intval($_GET['delete']) > 0){
  $id = intval($_GET['delete']);
  pg_query($vConn, "DELETE FROM park_Parking WHERE ID = $id");
  header("Location: parkings.php");
}
?>
