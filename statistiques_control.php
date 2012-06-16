<?php
require("inc/db.php");

//if($_GET['id'] == 'new'){


  $identifiant = intval($_POST['identifiant']);
  $date = pg_escape_string($_POST['date']);
  
  $vSql1 =" SELECT COUNT(T.*)  
			FROM park_parking P, park_ticket T 
			WHERE P.id=$identifiant 
			AND to_date($date,'YYYYMMDD') date(T.dateentree) AND date(T.datesortie)
			AND T.parking=P.id;";
  $vSql2 =" SELECT COUNT(A.*) 
			FROM park_parking P, park_etage E,  park_place L, park_abonnement A 
			WHERE P.id=$identifiant 
			AND $date BETWEEN A.datesouscription AND A.dateexpiration
			AND A.place=L.id
			AND L.etage=1
			AND L.etage=E.numero
			and E.parking=P.id;";
  $vResult1=pg_query($vConn, $vSql1);
  $vResult2=pg_query($vConn, $vSql2);
		$n= pg_fetch_row($vResult1);
		$n1= pg_fetch_row($vResult2);
         $res=$n[1]+$n1[1];
  
  //header("Location:statistiques.php?id=$res"); 
//}

?>
