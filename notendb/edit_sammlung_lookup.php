
<?php 
include('head_raw.php');
include('cl_lookuptype.php');

$LookupTypeID=''; 

if (isset($_POST["LookupTypeID"])) {
  $LookupTypeID= $_POST["LookupTypeID"]; 
}
?> 
<!-- 2 Formulare: Die Auswahl im ersten Formular bewirkt das Neu-Laden der Seite --> 
 <p> 
<form action="" method="post" style="float:left">
<label><i>Typ: &nbsp;</i>  
  <?php               
  $lookuptyp = new Lookuptype(); 
  $lookuptyp->Relation = 'sammlung'; 
  $lookuptyp->print_preselect($LookupTypeID); 
  ?>
</label>
<input type="hidden" name="SammlungID" value="<?php echo $_GET["SammlungID"]; ?>"> 
</form>

<form action="edit_sammlung_lookups.php" method="get">
<label>&nbsp;Besonderzeit:
<?php 
  include_once("cl_lookup.php");         
  $lookup = new Lookup(); 
  $lookup->LookupTypeRelation='sammlung';
  if ($LookupTypeID!='') {
    $lookup->print_select2($LookupTypeID,$_GET["SammlungID"]); 
  } else {
    $lookup->print_select('',  $_GET["SammlungID"]); 
  }
?>
</label>    
<input class="btnSave" type="submit" value="Speichern">
<input type="hidden" name="SammlungID" value="<?php echo $_GET["SammlungID"]; ?>"> 
<input type="hidden" name="LookupTypeID" value="<?php echo $LookupTypeID; ?>">  
<input type="hidden" name="option" value="insert"> 
</form>
</p> 
<?php
include('foot_raw.php');

?>
