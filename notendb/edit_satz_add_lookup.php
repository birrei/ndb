
<?php 
include('head_raw.php');
?> 
<form action="edit_satz_list_lookups.php" method="get">
<table class="eingabe"> 
<tr>    
  <label>
     <td class="eingabe">
         <?php 
          include_once("cl_lookup.php");         
          $lookup = new Lookup(); 
          $lookup->print_select('',  $_GET["SatzID"]); 
    ?>
   </label>    
  </td>
</tr>
<tr> 
  <td class="eingabe"><input type="submit" value="Speichern"></td>
 </tr>
 </table> 
 <input type="hidden" name="SatzID" value="<?php echo $_GET["SatzID"]; ?>"> 
 <input type="hidden" name="option" value="insert"> 
 </form>

<?php
include('foot_raw.php');

?>
