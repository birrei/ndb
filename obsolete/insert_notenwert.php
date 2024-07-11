
<?php 
include('head.php');
?> 
<h1>Notenwert erfassen</h1> 
<form action="edit_notenwert.php" method="get">
<table class="eingabe"> 
  <tr>    
    <label>
    <td class="eingabe">Name:</td>  
    <td class="eingabe"><input type="text" name="Name" size="45" maxlength="80" required="required" autofocus="autofocus" oninput="changeBackgroundColor(this)"></td>
     </label>
  </tr> 
  <tr> 
    <td class="eingabe"></td> 
    <td class="eingabe"><input type="submit" value="Speichern"></td>
  </tr>
</table> 
<input type="hidden" name="option" value="insert">
<input type="hidden" name="title" value="Notenwert"> 
</form>
<hr />
<?php
include_once('cl_notenwert.php');
$notenwert=new Notenwert(); 
$notenwert->print_table();   


include('foot.php');

?>
