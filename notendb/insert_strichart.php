
<?php 
include('head.php');
?> 

<h1>Strichart erfassen</h1> 

<form action="insert_strichart.php" method="post">

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

include_once('cl_strichart.php'); 
$strichart = new strichart();
if ("POST" == $_SERVER["REQUEST_METHOD"]) {
    $strichart->insert_row($_POST["Name"]); 
}   

$strichart->print_table();   


include('foot.php');

?>
