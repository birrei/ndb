
<?php 
include('head.php');
?> 

<h1>Epoche erfassen</h1> 

<form action="edit_epoche.php" method="get">

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
<input type="hidden" name="title" value="Epoche"> 
</form>
<hr />
<?php
include_once('cl_epoche.php'); 
$epoche = new Epoche();
$epoche->print_table();   

include('foot.php');

?>
