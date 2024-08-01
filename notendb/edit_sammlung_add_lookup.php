
<?php 
include('head_raw.php');
include('cl_lookuptype.php');

$LookupTypeID=''; 

if (isset($_POST["LookupTypeID"])) {
  $LookupTypeID= $_POST["LookupTypeID"]; 
}
?> 

<form action="" method="post">
<table class="eingabe">
<tr>    
  <label>
     <td class="eingabe"><i>Vorauswahl / Filter Typ:</i>  
      <?php 
                  
      $lookuptyp = new Lookuptype(); 
      $lookuptyp->Relation = 'sammlung'; 
      $lookuptyp->print_preselect($LookupTypeID); 

      ?>
      </td>
   </label>
   </tr>
    <input type="hidden" name="SammlungID" value="<?php echo $_GET["SammlungID"]; ?>"> 
</form>

<form action="edit_sammlung_list_lookups.php" method="get">
<table class="eingabe"> 
<tr>    
  <label>
     <td class="eingabe">Attribut: 
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
  </td>
</tr>

<tr> 
  <td class="eingabe"><input type="submit" value="Speichern"></td>
 </tr>
 </table> 
 <input type="hidden" name="SammlungID" value="<?php echo $_GET["SammlungID"]; ?>"> 
 <input type="hidden" name="LookupTypeID" value="<?php echo $LookupTypeID; ?>">  
 <input type="hidden" name="option" value="insert"> 
 </form>

<?php
include('foot_raw.php');

?>
