
<?php 
include('head.php');
?> 

<h1>Standort erfassen</h1> 

<form action="insert_standort.php" method="post">

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

include_once('cl_standort.php'); 
$standort = new Standort();
if ("POST" == $_SERVER["REQUEST_METHOD"]) {
    $standort->insert_row($_POST["Name"]); 
}   

$standort->print_table();   


include('foot.php');

?>
