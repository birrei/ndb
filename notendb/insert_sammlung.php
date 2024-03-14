
<?php 
include('head.php');
include("cl_sammlung.php");
?> 

<h1>Sammlung erfassen</h1> 
<form action="insert_sammlung.php" method="post">

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

$sammlung=new Sammlung(); 
if ("POST" == $_SERVER["REQUEST_METHOD"]) {
  $Name=$_POST["Name"]; 
  $sammlung->insert_row($Name); 
  $ID=$sammlung->ID;  

}
$sammlung->print_table();


include('foot.php');

?>
