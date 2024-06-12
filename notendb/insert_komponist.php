
<?php 
include('head.php');
?> 
<h1>Komponist erfassen</h1> 

<form action="edit_komponist.php" method="get">
<table class="eingabe"> 
  <tr>    
    <label>
    <td class="eingabe">Vorname:</td>  
    <td class="eingabe"><input type="text" name="Vorname" size="45" maxlength="80" autofocus="autofocus"></td>
     </label>
   </tr> 

  <tr>    
    <label>
    <td class="eingabe">Nachname:</td>  
    <td class="eingabe"><input type="text" name="Nachname" size="45" maxlength="80" required="required" autofocus="autofocus" oninput="changeBackgroundColor(this)"></td>
     </label>
   </tr> 

  <tr> 
    <td class="eingabe"></td> 
    <td class="eingabe"><input type="submit" value="Speichern"></td>
  </tr>
</table> 
<input type="hidden" name="option" value="insert"> 
<input type="hidden" name="title" value="Komponist"> 
</form>
<hr />
<?php

include_once('cl_komponist.php'); 
$komponist = new Komponist(); 
$komponist->print_table();   

include('foot.php');

?>
