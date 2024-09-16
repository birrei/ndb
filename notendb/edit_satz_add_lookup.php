
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
<label><i>Typ:</i>  
    <?php                 
    $lookuptyp = new Lookuptype(); 
    $lookuptyp->Relation = 'satz'; 
    $lookuptyp->print_preselect($LookupTypeID); 
    ?>
  </label>
<input type="hidden" name="SatzID" value="<?php echo $_GET["SatzID"]; ?>"> 
</form>
<form action="edit_satz_list_lookups.php" method="get">
  <label>
     Besonderheit: 
         <?php 
          include_once("cl_lookup.php");         
          $lookup = new Lookup(); 
          $lookup->LookupTypeRelation='satz';
          if ($LookupTypeID!='') {  
            $lookup->print_select2($LookupTypeID, $_GET["SatzID"]); // XXX 
          } else {
            $lookup->print_select('',  $_GET["SatzID"]); 
          }
    ?>
   </label>    

<input class="btnSave" type="submit" value="Speichern">

<input type="hidden" name="SatzID" value="<?php echo $_GET["SatzID"]; ?>"> 
<input type="hidden" name="LookupTypeID" value="<?php echo $LookupTypeID; ?>">  
<input type="hidden" name="option" value="insert"> 

</form>

</p> 


<?php
include('foot_raw.php');

?>
