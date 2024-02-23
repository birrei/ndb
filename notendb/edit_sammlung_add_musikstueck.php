
<?php 
include('head_raw.php');
include("dbconnect_pdo.php");
include("snippets.php");
$table='musikstueck'; 

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
      <!-- input autofocus funktioniert nicht XXX -->     
    <td class="eingabe"><input type="text" name="Nummer" size="45" maxlength="80" autofocus="autofocus" required> </td>
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

if ("POST" == $_SERVER["REQUEST_METHOD"]) {

  $SammlungID=$_POST["SammlungID"];     
  $Nummer=$_POST["Nummer"]; 
  $Name=$_POST["Name"]; 

  $insert = $db->prepare("INSERT INTO `musikstueck` SET
    `Name`     = :Name,
    `SammlungID`     = :SammlungID,  
    `Nummer`     = :Nummer");

  $insert->bindValue(':SammlungID', $SammlungID);
  $insert->bindValue(':Nummer', $Nummer);
  $insert->bindValue(':Name', $Name);


  try {
    $insert->execute(); 
    $ID = $db->lastInsertId();
    $count_affected_rows= $insert->rowCount(); 
    echo get_html_user_action_info($table, 'insert', $count_affected_rows,$ID);  
    echo get_html_editlink($table,$ID, true);
  }
  catch (PDOException $e) {
    echo get_html_user_error_info(); 
    echo get_html_error_info($insert, $e); 
  }
 }
echo '<p> <a href="edit_sammlung_list_musikstuecke.php?SammlungID='.$SammlungID.'">[Musikstücke anzeigen]</a></p>'; 

include('foot_raw.php');

?>
