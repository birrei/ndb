
<?php 
include_once('head_raw.php');
include_once("classes/class.htmlinfo.php");
include_once("classes/class.standort.php");

$info=new HTML_Info(); 
?> 

<form action="edit_sammlung_standorte.php" method="get">
<table class="eingabe2">
<tr>
  <td class="eingabe2 eingabe2_1">Standort: </td>
  <td class="eingabe2 eingabe2_2">
    <?php 
      $standort = new Standort(); 
      $standort->print_select('','', $_GET["SammlungID"]); 
    ?>
</td>  
  <td class="eingabe2 eingabe2_3">
    <?php      
      $info->print_link_table('standort','sortcol=Name','Standorte',true,'');       
    ?>
  </td>    
</tr>

<tr>
  <td class="eingabe2 eingabe2_1"> </td>
  <td class="eingabe2 eingabe2_2"> <input class="btnSave" type="submit" value="Speichern"></td>  
  <td class="eingabe2 eingabe2_3"> </td>    
</tr>

</table>

<input type="hidden" name="option" value="insert"> 
<input type="hidden" name="SammlungID" value="<?php echo $_GET["SammlungID"]; ?>"> 


</form>





<?php

include_once('foot_raw.php');
?>
