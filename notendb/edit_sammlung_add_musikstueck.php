
<?php 
include('head_raw.php');
include("cl_musikstueck.php");

$SammlungID=''; 
if (isset($_GET["SammlungID"])) {
  $SammlungID= $_GET["SammlungID"];
}
if (isset($_POST["SammlungID"])) {
  $SammlungID= $_POST["SammlungID"];
}
?> 
<form action="edit_sammlung_add_musikstueck.php" method="post">
<table class="eingabe"> 
  <tr>    
    <label>
    <td class="eingabe">Nummer:</td>    
    <td class="eingabe"><input type="text" name="Nummer" size="45" maxlength="80" autofocus="autofocus" value="1"> </td>
     </label>
   </tr>    

   <tr>    
    <label>
    <td class="eingabe">Name:</td>  
    <td class="eingabe"><input type="text" name="Name" size="45" maxlength="80"> 
     </label>
   </tr> 
    <input type="hidden" name="SammlungID" value="<?php echo $SammlungID; ?>"> 
  
   <tr> 
    <td class="eingabe"></td> 
    <td class="eingabe"><input type="submit" value="Speichern"></td>
</tr>
</table> 

</form>

<?php
echo '<p> <a href="edit_sammlung_list_musikstuecke.php?SammlungID='.$SammlungID.'">[Erfassung beenden]</a></p>'; 

$musikstueck = new Musikstueck();
  // $SammlungID=$_POST["SammlungID"]; 

if ("POST" == $_SERVER["REQUEST_METHOD"]) {
  $Nummer=$_POST["Nummer"]; 
  $Name=$_POST["Name"]; 
  $musikstueck->insert_row($SammlungID, $Nummer, $Name); 
  $ID=$musikstueck->ID; 

}

$musikstueck->print_table_from_sammlung($SammlungID);

include('foot_raw.php');

?>
