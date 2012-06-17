<?php
require("inc/db.php");
require("inc/header.php");

if(isset($_GET['etageid'])){
  $new = ($_GET['etageid'] == 'new');
  $id = intval($_GET['etageid']);
  $myetage = intval($_GET['etage']);
  if($id > 0){
    $vSql ="SELECT pe.id, pe.etage, COUNT(ppl.id) AS places, pe.maxnbplaces, pp.ID AS parking FROM park_etage pe
      LEFT JOIN park_place ppl ON ppl.etage = pe.id
      LEFT JOIN park_parking pp ON pp.id = pe.parking
      WHERE pe.id = $id
      GROUP BY pe.id, pe.etage, pe.maxnbplaces, pp.id
      ORDER BY pe.etage ASC";
    $vQuery=pg_query($vConn, $vSql);
    $etage = pg_fetch_array($vQuery);
  }
  if($new)
    $parking = $_GET['parking'];
  else
    $parking = $etage['parking'];
?>
<h2>Éditer un étage</h2>
  <form class="form-inline" action="configpark_control.php?editetage=<?php echo $_GET['etageid'] ?>&parking=<?php echo $parking ?>" method="post">
    <fieldset>
      <div class="control-group">
        <label class="control-label" for="etage">Étage</label>
        <div class="controls">
          <input type="text" class="input-xlarge" id="etage" name="etage" value="<?php echo $etage['etage'] ?>">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="max">Nombre max de places</label>
        <div class="controls">
          <input type="text" class="input-xlarge" id="max" name="max" value="<?php echo $etage['maxnbplaces'] ?>">
        </div>
      </div>
      <div class="form-actions">
        <button type="submit" class="btn btn-primary">Enregistrer</button>
        <a class="btn" href="configpark.php?id=<?php echo $parking ?>">Annuler</a>
        <?php if(!$new): ?>
        <a class="btn btn-danger" onclick="return confirm('Voulez-vous vraiment supprimer définitivement cet étage et toutes ses places ?');" href="configpark_control.php?deletage=<?php echo $id; ?>&parking=<?php echo $parking ?>">Supprimer</a>
        <?php endif ?>
      </div>
    </fieldset>
  </form>
<?php
}
elseif(isset($_GET['placeid'])){
  $new = ($_GET['placeid'] == 'new');
  $id = intval($_GET['placeid']);
  $myetage = intval($_GET['etage']);
  if($id > 0){
    $vSql ="SELECT pp.nom, pe.id AS etage, pe.id AS etage, ppl.local_id AS numero, COUNT(ppl.id) AS places, pe.maxnbplaces, pp.id AS parking FROM park_place ppl
      LEFT JOIN park_etage pe ON ppl.etage = pe.id
      LEFT JOIN park_parking pp ON pp.id = pe.parking
      WHERE ppl.id = $id
      GROUP BY pe.id, pe.etage, pe.maxnbplaces, pp.nom, pp.id, ppl.local_id
      ORDER BY pe.etage ASC";
    $vQuery=pg_query($vConn, $vSql);
    $place = pg_fetch_array($vQuery);
  } 
  if($new){
    $parking = $_GET['parking'];
    $etage = $_GET['etage'];
  }
  else {
    $parking = $place['parking'];
    $etage = $place['etage'];
  }
?>
<h2>Éditer une place</h2>
    <form class="form-inline" action="configpark_control.php?editplace=<?php echo $_GET['placeid'] ?>&parking=<?php echo $parking ?>" method="post">
      <fieldset>
        <div class="control-group">
          <label class="control-label" for="etage">Étage</label>
          <div class="controls">
            <select class="input-xlarge" id="etage" name="etage">
<?php
$vSql = "SELECT id, etage FROM park_etage WHERE parking = $parking";
$vQuery = pg_query($vConn, $vSql);
while($et = pg_fetch_array($vQuery)){
  echo '<option value="'.$et['id'].'"';
  if($et['id'] == $etage)
    echo ' selected="selected"';
  echo '>'.$et['etage'].'</option>';
} 
?>
            </select>
          </div>
        </div>
        <div class="control-group">
          <label class="control-label" for="numero">Numéro</label>
          <div class="controls">
            <input type="text" class="input-xlarge" id="numero" name="numero" value="<?php echo $place['numero'] ?>">
          </div>
        </div>
        <div class="control-group">
          <label class="control-label" for="type">Type</label>
          <div class="controls">
            <select class="input-xlarge" id="type" name="type">
              <option value="normal"<?php if($place['type'] == "normal") echo ' selected="selected"'; ?>>Normal</option>
              <option value="handicap"<?php if($place['type'] == "handicap") echo ' selected="selected"'; ?>>Handicapé</option>
            </select>
          </div>
        </div>
        <div class="form-actions">
          <button type="submit" class="btn btn-primary">Enregistrer</button>
          <a class="btn" href="configpark.php?id=<?php echo $parking ?>&etage=<?php echo $etage ?>">Annuler</a>
          <?php if(!$new): ?>
          <a class="btn btn-danger" onclick="return confirm('Voulez-vous vraiment supprimer définitivement cette place ?');" href="configpark_control.php?delplace=<?php echo $id; ?>&parking=<?php echo $parking ?>&etage=<?php echo $etage ?>">Supprimer</a>
          <?php endif ?>
        </div>
      </fieldset>
    </form>
<?php
}
else {
  if(isset($_GET['id'])){
    $new = ($_GET['id'] == 'new');
    $id = intval($_GET['id']);
    if($id > 0){
      $vSql ="SELECT * FROM park_parking WHERE ID = $id;";
      $vQuery=pg_query($vConn, $vSql);
      $park = pg_fetch_array($vQuery);
    }
  ?>
    <div>
      <h1>Configuration de : <?php echo $park['nom'] ?></h1>
      <p></p>
      <h2>Étages</h2>
      <table class="table table-striped">
        <thead>
          <tr>
            <th>Étage</th>
            <th>Places déclarées</th>
            <th>Nombre max de places</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $vSql ="SELECT pe.id, pe.etage, COUNT(ppl.id) AS places, pe.maxnbplaces FROM park_etage pe
            LEFT JOIN park_place ppl ON ppl.etage = pe.id
            WHERE pe.parking = $id
            GROUP BY pe.id, pe.etage, pe.maxnbplaces
            ORDER BY pe.etage ASC";
          $vQuery=pg_query($vConn, $vSql);

          while ($etage = pg_fetch_array($vQuery, null, PGSQL_ASSOC)) {
            echo '<tr>
              <td><a class="btn" href="configpark.php?id='.$id.'&etage='.$etage['id'].'">'.$etage['etage'].'</a></td>
              <td>'.$etage['places'].'</td>
              <td>'.$etage['maxnbplaces'].'</td>
              <td><a class="btn" href="configpark.php?etageid='.$etage['id'].'">Modifier</a></td>
            </tr>';
            if(!empty($_GET['etage']) && $_GET['etage'] == $etage['id']) $myetage = $etage;
          }
          ?>
          <tr>
            <td colspan="4">
              <a href="configpark.php?etageid=new&parking=<?php echo $id ?>" class="btn btn-primary">Ajouter un étage</a>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <?php if(!empty($_GET['etage'])): ?>
      <h2>Places de l'étage <?php echo $myetage['etage'] ?></h2>
      <table class="table table-striped">
        <thead>
          <tr>
            <th>Numéro</th>
            <th>Type</th>
            <th>Utilisé ?</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $etage = intval($_GET['etage']);
          $vSql ="SELECT ppl.id, ppl.type, (CASE WHEN ppl.utilise THEN 'Oui' ELSE 'Non' END) AS utilise, ppl.local_id AS numero FROM park_place ppl
            WHERE ppl.etage = $etage
            ORDER BY ppl.local_id";
          $vQuery=pg_query($vConn, $vSql);

          while ($place = pg_fetch_array($vQuery, null, PGSQL_ASSOC)) {
            echo '<tr>
              <td>'.$place['numero'].'</td>
              <td>'.$place['type'].'</td>
              <td>'.$place['utilise'].'</td>
              <td><a class="btn" href="configpark.php?placeid='.$place['id'].'">Modifier</a></td>
            </tr>';
          }
          ?>
          <tr>
            <td colspan="4">
              <?php if($myetage['places'] < $myetage['maxnbplaces']): ?>
              <a href="configpark.php?placeid=new&parking=<?php echo $id ?>&etage=<?php echo $myetage['id'] ?>" class="btn btn-primary">Ajouter une place</a>
              <?php else: ?>
              Cet étage est complet !
              <?php endif ?>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <?php endif; ?>

  <?php
  }
  else {
    echo "<script>window.location='parkings.php';</script>";
  }
}
require("inc/footer.php");