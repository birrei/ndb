
<?php 
include_once('head_raw.php');
include_once("classes/class.htmlinfo.php"); 
$info = new HTML_Info(); 

?> 

<form action="edit_material_schwierigkeitsgrade.php" method="get">

<table class="eingabe2">
<tr>
  <td class="eingabe2 eingabe2_1">Instrument:</td>
  <td class="eingabe2 eingabe2_2">
      <?php 
          include_once("classes/class.instrument.php");         
          $instrument = new Instrument(); 
          $instrument->Parent='Material'; 
          $instrument->print_select('',  $_GET["MaterialID"]); 
       ?>  
  </td>  
  <td class="eingabe2 eingabe2_3">
      <?php
            // $info->option_linktext=1; 
            $info->print_link_table('instrument','sortcol=Name','Instrumente',true,''); 
      ?>
  </td>    
</tr>
<tr>
  <td class="eingabe2 eingabe2_1">Schwierigkeitsgrad: </td>
  <td class="eingabe2 eingabe2_2">        
      <?php 
          include_once("classes/class.schwierigkeitsgrad.php");         
          $schwierigkeitsgrad = new Schwierigkeitsgrad(); 
          // $schwierigkeitsgrad->print_select( '',  $_GET["MaterialID"]); 
          $schwierigkeitsgrad->print_select( ''); 
      ?>
  </td>  
  <td class="eingabe2 eingabe2_3">
      <?php
       $info->print_link_table('schwierigkeitsgrad','sortcol=Name','Schwierigkeitsgrade',true,''); 
      ?>
  </td>    
</tr>


<tr>
  <td class="eingabe2 eingabe2_1"> </td>
  <td class="eingabe2 eingabe2_2"><input class="btnSave" type="submit" value="Speichern"></td>  
  <td class="eingabe2 eingabe2_3"></td>    
</tr>


<tr>
  <td class="eingabe2 eingabe2_1"> </td>
  <td class="eingabe2 eingabe2_2">
      <?php 
      $info->print_link_reload(); 
      ?>
  </td>  
  <td class="eingabe2 eingabe2_3"></td>    
</tr>

<tr>
  <td class="eingabe2 eingabe2_1"> </td>
  <td class="eingabe2 eingabe2_2">
      <?php 
      $info->print_link_backToList('edit_material_schwierigkeitsgrade.php?MaterialID='.$_GET["MaterialID"], 'zurück zu Liste'); 
      ?>
  </td>  
  <td class="eingabe2 eingabe2_3"></td>    
</tr>


 <input type="hidden" name="MaterialID" value="<?php echo $_GET["MaterialID"]; ?>"> 
 <input type="hidden" name="option" value="insert"> 


</table>

 </form>

<?php

include_once('foot_raw.php');

?>
