
<?php 
include('head.php');
?> 

<h1>Verlag erfassen</h1> 

<form action="insert_verlag.php" method="post">

<table class="eingabe"> 
  <tr>    
    <label>
    <td class="eingabe">Name:</td>  
    <td class="eingabe"><input type="text" name="Name" size="45" maxlength="80" required="required" autofocus="autofocus"></td>
     </label>
   </tr> 


   <tr>    
    <label>
    <td class="eingabe">Bemerkung:</td>  
    <td class="eingabe"><input type="text" name="Bemerkung" size="45" maxlength="80" autofocus="autofocus"></td>
     </label>
   </tr> 


  <tr> 
    <td class="eingabe"></td> 
    <td class="eingabe"><input type="submit" value="Speichern"></td>
</tr>
</table> 

</form>

<?php
include_once('cl_verlag.php'); 
$verlag = new Verlag();
if ("POST" == $_SERVER["REQUEST_METHOD"]) {
  if ("POST" == $_SERVER["REQUEST_METHOD"]) {
    $verlag->insert_row($_POST["Name"],$_POST["Bemerkung"]); 
  }   
}
$verlag->print_table();   

include('foot.php');

?>
