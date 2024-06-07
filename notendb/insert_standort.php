
<?php 
include('head.php');
?> 

<h1>Standort erfassen</h1> 

<form action="edit_standort.php" method="get">

<table class="eingabe"> 
  <tr>    
    <label>
    <td class="eingabe">Name:</td>  
    <td class="eingabe"><input type="text" name="Name" size="45" maxlength="80" required="required" autofocus="autofocus"></td>
     </label>
   </tr> 

  <tr> 
    <td class="eingabe"></td> 
    <td class="eingabe"><input type="submit" value="Speichern"></td>
</tr>
</table> 
<input type="hidden" name="option" value="insert"> 
<input type="hidden" name="title" value="Standort"> 
</form>
<hr />
<?php

include_once('cl_standort.php'); 
$standort = new Standort();
$standort->print_table();   

include('foot.php');
?>
