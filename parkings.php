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
  <form class="form-horizontal" action="parkings_control.php?id=<?php echo $_GET['id'] ?>" method="post">
    <fieldset>
      <div class="control-group">
        <label class="control-label" for="nom">Nom</label>
        <div class="controls">
          <input type="text" class="input-xlarge" id="nom" name="nom" value="<?php echo $park['nom'] ?>">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="adresse">Adresse</label>
        <div class="controls">
          <textarea class="input-xlarge" id="adresse" name="adresse" rows="3"><?php echo $park['adresse'] ?></textarea>
        </div>
      </div>
      <div class="form-actions">
        <button type="submit" class="btn btn-primary">Enregistrer</button>
        <a class="btn" href="parkings.php">Annuler</a>
        <?php if($id > 0): ?>
        <a class="btn btn-danger" onclick="return confirm('Voulez-vous vraiment supprimer ce parking ?');" href="parkings_control.php?delete=<?php echo $id; ?>">Supprimer</a>
        <?php endif; ?>
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
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $vSql ="SELECT * FROM park_Parking;";
      $vQuery=pg_query($vConn, $vSql);
      while ($park = pg_fetch_array($vQuery, null, PGSQL_ASSOC)) {
        echo '<tr>
          <td>'.$park['id'].'</td>
          <td>'.$park['nom'].'</td>
          <td>'.$park['adresse'].'</td>
          <td><a href="parkings.php?id='.$park['id'].'" class="btn">Modifier</a> <a href="configpark.php?id='.$park['id'].'" class="btn">Configurer</a></td>
        </tr>';
      }
      ?>
    </tbody>
  </table>
</div>

<?php
}
require("inc/footer.php");
