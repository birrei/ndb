
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
     <td class="eingabe">Vorauswahl Typ: 
      <?php 
                  
      $lookuptyp = new Lookuptype(); 
      $lookuptyp->print_preselect($LookupTypeID); 

      ?>
      </td>
   </label>
   </tr>
    <input type="hidden" name="SatzID" value="<?php echo $_GET["SatzID"]; ?>"> 
</form>

<form action="edit_satz_list_lookups.php" method="get">
<table class="eingabe"> 
<tr>    
  <label>
     <td class="eingabe">
         <?php 
          include_once("cl_lookup.php");         
          $lookup = new Lookup(); 
          if ($LookupTypeID!='') {
            $lookup->print_select2($LookupTypeID, 'satz', $_GET["SatzID"]); 
          }
    ?>
   </label>    
  </td>
</tr>

<tr> 
  <td class="eingabe"><input type="submit" value="Speichern"></td>
 </tr>
 </table> 
 <input type="hidden" name="SatzID" value="<?php echo $_GET["SatzID"]; ?>"> 
 <input type="hidden" name="LookupTypeID" value="<?php echo $LookupTypeID; ?>">  
 <input type="hidden" name="option" value="insert"> 
 </form>

<?php
include('foot_raw.php');

?>
