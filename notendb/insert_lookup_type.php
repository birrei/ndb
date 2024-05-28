
<?php 
include('head.php');

include('cl_lookuptype.php');

?> 
<h1>Besonderheit Typ erfassen</h1> 




<form action="edit_lookup_type.php" method="get">
  <tr>    
    <label>
    <td class="eingabe">Name: </td>  
    <td class="eingabe"><input type="text" name="Name" size="50" required="required" autofocus="autofocus"></td>
     </label>
  </tr> 
  <tr> 
    <td class="eingabe"></td> 
    <td class="eingabe"><input type="submit" value="Speichern"></td>
  </tr>
</table> 
<input type="hidden" name="option" value="insert">
<input type="hidden" name="LookupTypeID" value="<?php echo $LookupTypeID; ?>">  
</form>
<hr />
<?php

$lookuptype=new Lookuptype(); 
$lookuptype->print_table();   


include('foot.php');

?>
