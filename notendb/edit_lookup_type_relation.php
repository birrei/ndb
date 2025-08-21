
<?php 

include_once('head_raw.php');
include_once("classes/class.relation.php");
include_once("classes/class.htmlinfo.php");
include_once('classes/class.lookuptype.php'); 

$info=new HTML_Info(); 
$LookuptypeID=$_GET["LookuptypeID"]; 

?> 

<form action="edit_lookup_type_relationen.php" method="get">

<table class="eingabe2">
<tr>
  <td class="eingabe2 eingabe2_1">Relation: </td>
  <td class="eingabe2 eingabe2_2">
    <?php 
      $relation = new Relation(); 
      $relation->print_select('','', 'LookuptypeID', $LookuptypeID); 
    ?>
</td>  
  <td class="eingabe2 eingabe2_3">
    <?php      
      // XXXX (nocht nicht vorhanden) $info->print_link_table('Relation','sortcol=Name','Relationen',true,'');       
    ?>
  </td>    
</tr>

<tr>
  <td class="eingabe2 eingabe2_1"> </td>
  <td class="eingabe2 eingabe2_2"> <input class="btnSave" type="submit" value="Speichern"></td>  
  <td class="eingabe2 eingabe2_3">
    <?php 
      // $info->option_linktext=1; 
      // $info->print_link_insert('Relation','Relation', true);  
      ?>
  </td>    
</tr>
</table>
<input type="hidden" name="option" value="insert"> 
<input type="hidden" name="LookuptypeID" value="<?php echo $LookuptypeID; ?>"> 


</form>





<?php

include_once('foot_raw.php');
?>
