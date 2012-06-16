<?php
require("inc/db.php");
require("inc/header.php");

if($_GET['id'] == 'new'){

?>
 <div class="span12">
  <h1>Cacul taux d'occupation par date</h1>
  <form class="form-horizontal" action="statistiques_control.php?id=<?php echo $_get['id']?> method="post">
    <fieldset>
      <div class="control-group">
        <label class="control-label" for="nom">Identifiant Parking</label>
        <div class="controls">
          <input type="text" class="input-xlarge" id="identifiant" name="identifiant" >
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="adresse">Date</label>
        <div class="controls">
          <input type="text" class="input-xlarge" id="date" name="date" >
        </div>
      </div>
      <div class="form-actions">
        <button type="submit" class="btn btn-primary">Calculer</button>
      </div>
    </fieldset>
  </form>
</div>

<?php
}
else {

?>
<div class="span12">
  <h1>Taux d'occupation:</h1>
 <?php echo $_GET['id'] ?>
</div>

<?php
} 
require("inc/footer.php");
?>
