
<?php 
include('head_raw.php');

$SatzID= $_GET["SatzID"];

?> 
<form action="edit_satz_list_notenwerte.php" method="get">
<table class="eingabe"> 
<tr>    
  <label>
  <td class="eingabe">Notenwert:</td>  
     <td class="eingabe">
         <?php 
          include_once("cl_notenwert.php");         
          $notenwerte = new Notenwert(); 
          $notenwerte->print_select(); 
    ?>
   </label>    
  </td>
</tr>
<tr> 
  <td class="eingabe"></td> 
  <td class="eingabe"><input type="submit" value="Speichern"></td>
 </tr>
 </table> 
 <input type="hidden" name="SatzID" value="<?php echo $SatzID; ?>"> 
 <input type="hidden" name="option" value="insert"> 
 </form>

<?php
include('foot_raw.php');

?>
