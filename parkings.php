<?php
require("inc/db.php");
require("inc/header.php");

if(isset($_GET['id'])){
  $new = ($_GET['id'] == 'new');
  $id = intval($_GET['id']);
  if($id > 0){
    $vSql ="SELECT * FROM park_Parking WHERE ID = $id;";
    $vQuery=pg_query($vConn, $vSql);
    $park = pg_fetch_array($vQuery);
  }
?>
  <div class="span12">
  <h1>Modifier un parking</h1>
  <p></p>
  <form class="form-horizontal" action="parkings.php?id=<?php echo $id ?>">
    <fieldset>
      <div class="control-group">
        <label class="control-label" for="input01">Nom</label>
        <div class="controls">
          <input type="text" class="input-xlarge" id="input01" value="<?php echo $park['nom'] ?>">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="textarea">Adresse</label>
        <div class="controls">
          <textarea class="input-xlarge" id="textarea" rows="3"><?php echo $park['adresse'] ?></textarea>
        </div>
      </div>
      <div class="form-actions">
        <button type="submit" class="btn btn-primary">Enregistrer</button>
        <a class="btn" href="parkings.php">Annuler</a>
      </div>
    </fieldset>
  </form>
</div>

<?php
}
else {
?>


<div class="span12">
  <h1>Liste des parkings</h1>
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
      $vQuery=pg_query($vConn, $vSql);
      while ($park = pg_fetch_array($vQuery, null, PGSQL_ASSOC)) {
        echo '<tr>
          <td><a href="parkings.php?id='.$park['id'].'">'.$park['id'].'</td>
          <td>'.$park['nom'].'</td>
          <td>'.$park['adresse'].'</td>
        </tr>';
      }
      ?>
    </tbody>
  </table>
</div>

<?php
}
require("inc/footer.php");
