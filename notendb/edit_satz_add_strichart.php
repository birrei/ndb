
<?php 
include('head_raw.php');
?> 
<form action="edit_satz_list_stricharten.php" method="get">
<table class="eingabe"> 
<tr>    
  <label>
     <td class="eingabe">
         <?php 
          include_once("cl_strichart.php");         
          $stricharten = new Strichart(); 
          $stricharten->print_select('',  $_GET["SatzID"]); 
          ?>
     </td>
     </label>
      </tr>
     <input type="hidden" name="SatzID" value="<?php echo $_GET["SatzID"]; ?>"> 
    <tr> 
     <td class="eingabe"><input type="submit" value="Speichern"></td>
 </tr>
 </table> 
 <input type="hidden" name="option" value="insert"> 
 </form>

<?php

include('foot_raw.php');

?>
