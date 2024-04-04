
<?php 


/******* obsolete ************ */
include('head_raw.php');
include("cl_musikstueck.php");

$musikstueck = new Musikstueck();
$musikstueck->SammlungID=$_GET["SammlungID"]; 
$default_nummer=$musikstueck->get_next_nummer(); 


// $SammlungID=''; 
// if (isset($_GET["SammlungID"])) {
//   $SammlungID= $_GET["SammlungID"];
// }
// if (isset($_POST["SammlungID"])) {
//   $SammlungID= $_POST["SammlungID"];
// }
?> 
<form action="edit_sammlung_list_musikstuecke.php" method="get">
<table class="eingabe"> 
  <tr>    
    <label>
    <td class="eingabe">Nummer:</td>    
    <td class="eingabe"><input type="text" name="Nummer" size="45" maxlength="80" autofocus="autofocus" value="<?php echo $default_nummer; ?>"> </td>
     </label>
   </tr>    

   <tr>    
    <label>
    <td class="eingabe">Name:</td>  
    <td class="eingabe"><input type="text" name="Name" size="45" maxlength="80"> 
     </label>
   </tr> 
    <input type="hidden" name="SammlungID" value="<?php echo $_GET["SammlungID"]; ?>"> 
  
   <tr> 
    <td class="eingabe"></td> 
    <td class="eingabe"><input type="submit" value="Speichern"></td>
</tr>
</table> 
<input type="hidden" name="option" value="insert">
</form>

<?php
// echo '<p> <a href="edit_sammlung_list_musikstuecke.php?SammlungID='.$SammlungID.'">[Erfassung beenden]</a></p>'; 


// if ("POST" == $_SERVER["REQUEST_METHOD"]) {
//   $Nummer=$_POST["Nummer"]; 
//   $Name=$_POST["Name"]; 
//   $musikstueck->insert_row($SammlungID, $Nummer, $Name); 
//   $ID=$musikstueck->ID; 

// }

// $musikstueck->print_table_from_sammlung($SammlungID);

include('foot_raw.php');

?>
