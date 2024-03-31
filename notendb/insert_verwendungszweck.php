
<?php 
include('head.php');
?> 

<h1>Verwendungszweck erfassen</h1> 

<form action="edit_verwendungszweck.php" method="get">

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
</form>

<?php

include_once('cl_verwendungszweck.php'); 
$verwendungszweck = new verwendungszweck();
$verwendungszweck->print_table();   

include('foot.php');

?>
