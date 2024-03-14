
<?php 
include('head.php');
?> 
<h1>Komponist erfassen</h1> 

<form action="insert_komponist.php" method="post">
<table class="eingabe"> 
<tr>    
    <label>
    <td class="eingabe">Vorname:</td>  
    <td class="eingabe"><input type="text" name="Vorname" size="45" maxlength="80" required="required" autofocus="autofocus"></td>
     </label>
   </tr> 

<tr>    
    <label>
    <td class="eingabe">Nachname:</td>  
    <td class="eingabe"><input type="text" name="Nachname" size="45" maxlength="80" required="required" autofocus="autofocus"></td>
     </label>
   </tr> 

   <tr>    
    <label>
    <td class="eingabe">Geburtsjahr:</td>  
    <td class="eingabe"><input type="text" name="Geburtsjahr" size="10" maxlength="80" autofocus="autofocus"></td>
     </label>
   </tr> 

   <tr>    
    <label>
    <td class="eingabe">Sterbejahr:</td>  
    <td class="eingabe"><input type="text" name="Sterbejahr" size="10" maxlength="80" autofocus="autofocus"></td>
     </label>
   </tr> 

   <tr>    
    <label>
    <td class="eingabe">Bemerkung:</td>  
    <td class="eingabe"><input type="text" name="Bemerkung" size="80" maxlength="100" autofocus="autofocus"></td>
     </label>
   </tr> 


  <tr> 
    <td class="eingabe"></td> 
    <td class="eingabe"><input type="submit" value="Speichern"></td>
</tr>
</table> 

</form>

<?php

include_once('cl_komponist.php'); 
$komponist = new Komponist(); 

if ("POST" == $_SERVER["REQUEST_METHOD"]) {
  $komponist->insert_row(
     $_POST["Vorname"]
    , $_POST["Nachname"]
    , $_POST["Geburtsjahr"]
    , $_POST["Sterbejahr"]
    , $_POST["Bemerkung"]
    ); 
} 

$komponist->print_table();   
  
include('foot.php');

?>
