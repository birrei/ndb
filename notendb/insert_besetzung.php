
<?php 
include('head.php');
?> 

<h1>Besetzung erfassen</h1> 

<form action="insert_besetzung.php" method="post">

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

</form>

<?php

include_once('cl_besetzung.php'); 
$besetzung = new Besetzung();
if ("POST" == $_SERVER["REQUEST_METHOD"]) {
    $besetzung->insert_row($_POST["Name"]); 
}   

$besetzung->print_table();   


include('foot.php');

?>
