
<?php 
include('head_raw.php');
include("cl_satz.php");

$MusikstueckID=''; 
if (isset($_GET["MusikstueckID"])) {
  $MusikstueckID= $_GET["MusikstueckID"];
}
if (isset($_POST["MusikstueckID"])) {
  $MusikstueckID= $_POST["MusikstueckID"];
}

?> 

<form action="edit_musikstueck_add_satz.php" method="post">

<table class="eingabe"> 
  
    <tr>    
    <label>
    <td class="eingabe">Nr:</td>  
    <td class="eingabe"><input type="text" name="Nr" size="45" maxlength="80" autofocus="autofocus" value="1"> </td>
     </label>
   </tr>    

   <tr>    
    <label>
    <td class="eingabe">Name:</td>  
    <td class="eingabe"><input type="text" name="Name" size="45" maxlength="80"></td>
     </label>
   </tr> 
    <input type="hidden" name="MusikstueckID" value="<?php echo $MusikstueckID; ?>"> 
  
   <tr> 
    <td class="eingabe"></td> 
    <td class="eingabe"><input type="submit" value="Speichern"></td>
</tr>
</table> 
</form>
<?php
echo '<p> <a href="edit_musikstueck_list_saetze.php?MusikstueckID='.$MusikstueckID.'">[Erfassung beenden]</a></p>'; 

$satz = new Satz(); 
$satz->MusikstueckID=$MusikstueckID; 

if ("POST" == $_SERVER["REQUEST_METHOD"]) {
  $satz->insert_row($_POST["Nr"], $_POST["Name"]); 
}

$satz->print_table_from_musikstueck(); 


include('foot_raw.php');

?>
