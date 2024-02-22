
<?php 
include('head_raw.php');
include("dbconnect_pdo.php");
include("snippets.php");

$SatzID=''; 
if (isset($_GET["SatzID"])) {
  $SatzID= $_GET["SatzID"];
}
if (isset($_POST["SatzID"])) {
  $SatzID= $_POST["SatzID"];
}
?> 

<form action="edit_satz_add_strichart.php" method="post">

<table class="eingabe"> 

   <tr>    
    <label>
    <td class="eingabe">Strichart:</td>  
    <td class="eingabe">
        <!-- Auswahlliste Strichart  --> 
        <?php 
              $select = $db->query("SELECT ID, Name  FROM `strichart` order by `Name`");
              $options = $select->fetchAll(PDO::FETCH_KEY_PAIR);            
              $html = get_html_select2($options, 'StrichartID', '', true); // s. snippets.php
              echo $html;
        ?>
    </td>
    </label>

    <input type="hidden" name="SatzID" value="<?php echo $SatzID; ?>"> 
    

   <tr> 
    <td class="eingabe"></td> 
    <td class="eingabe"><input type="submit" value="Speichern"></td>
</tr>
</table> 
</form>

<?php

if ("POST" == $_SERVER["REQUEST_METHOD"]) {
  include("dbconnect_pdo.php"); // nur wenn benötigt     

  $SatzID=$_POST["SatzID"];           
  $StrichartID=$_POST["StrichartID"];           

  $insert = $db->prepare("INSERT INTO `satz_strichart` SET
                          `SatzID`     = :SatzID,  
                          `StrichartID`     = :StrichartID");

  $insert->bindValue(':SatzID', $SatzID);  
  $insert->bindValue(':StrichartID', $StrichartID);  

  try {
    $insert->execute(); 
    $id = $db->lastInsertId();
    echo '<p>Der Datensatz wurde mit ID '.$id.' eingefuegt.</p>'; 
  }
  catch (PDOException $e) {
    // echo '<p>Ein Fehler ist aufgetreten.<br />Evt. haben Sie versucht, eine gleiche Besetzung mehrfach zuzuordnen</p>';
    echo $e->getMessage();
    echo $insert->debugDumpParams(); 
  }
}
echo '<p> <a href="edit_satz_list_stricharten.php?SatzID='.$SatzID.'">[Stricharten anzeigen]</a></p>'; 

include('foot_raw.php');

?>
