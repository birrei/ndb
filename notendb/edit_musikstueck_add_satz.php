
<?php 
include('head_raw.php');
include("dbconnect_pdo.php");
include("snippets.php");

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


    <tr>    
    <label>
    <td class="eingabe">Nr:</td>  
    <td class="eingabe"><input type="text" name="Nr" size="45" maxlength="80" autofocus="autofocus" required> </td>
     </label>
   </tr>    

   <tr>    
    <label>
    <td class="eingabe">Name:</td>  
    <td class="eingabe"><input type="text" name="Name" size="45" maxlength="80" autofocus="autofocus">  (falls vom Musikstück abweichend, sonst leer lassen)</td>
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

// Wurde das Formular abgesendet?
if ("POST" == $_SERVER["REQUEST_METHOD"]) {


  $MusikstueckID=$_POST["MusikstueckID"];     
  $Nr=$_POST["Nr"]; 
  $Name=$_POST["Name"]; 

  $insert = $db->prepare("INSERT INTO `satz` SET
    `Name`     = :Name,
    `MusikstueckID`     = :MusikstueckID,  
    `Nr`     = :Nr");

  $insert->bindValue(':MusikstueckID', $MusikstueckID);
  $insert->bindValue(':Nr', $Nr);
  $insert->bindValue(':Name', $Name);

  if ($insert->execute()) {
      $ID = $db->lastInsertId();
      echo '<p>Der Datensatz wurde mit ID '.$ID.' eingefuegt'; 
     // echo '<p><a href="edit_musikstueck_list_saetze.php?MusikstueckID='.$ID.'"><b>Bearbeitung fortsetzen</b></a></p>';
      }
  else {
      echo '<p>Fehler! <br/>'.$insert->errorInfo().'</p>'; 
      // print_r($insert->errorInfo());
      // XXX Nutzer-Info anzeigen 
  }
  
    

}
echo '<p> <a href="edit_musikstueck_list_saetze.php?MusikstueckID='.$MusikstueckID.'">[Sätze anzeigen]</a></p>'; 

include('foot_raw.php');

?>
