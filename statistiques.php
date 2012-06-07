<<<<<<< HEAD
asdasda
=======
<?php
require("inc/db.php");
require("inc/header.php");
?>
<div class="span12">
  <h1>Liste des trucs</h1>
  <table class="table table-striped">
    <thead>
      <tr>
        <th>ID</th>
        <th>Nom</th>
        <th>Adresse</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $vSql ="SELECT * FROM park_Parking;";
      $vQuery = pg_query($vConn, $vSql);
      while ($park = pg_fetch_array($vQuery, null, PGSQL_ASSOC)) {
        echo '<tr>
          <td>'.$park['id'].'</td>
          <td><a href="parkings.php?id='.$park['id'].'">'.$park['nom'].'</a></td>
          <td>'.$park['adresse'].'</td>
        </tr>';
      }
      ?>
    </tbody>
  </table>
</div>

<?php
require("inc/footer.php");
>>>>>>> bb89a10c02b5c832105734252c321654ab5cd84d
