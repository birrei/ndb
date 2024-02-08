
<?php 
include('head.php');

if (isset($_GET["ID"])) {

  include("dbconnect_pdo.php"); // nur wenn benötigt 

  $select = $db->prepare("SELECT `ID`, `Name`, `Bemerkung` 
  FROM `verlag`
  WHERE `ID` = :ID");

  // Der Platzhalter wird mit $select->bindParam() durch den Inhalt der GET-Variablen maskiert.
  $select->bindParam(':id', $_GET["ID"], PDO::PARAM_INT);
  $select->execute(); // Führt die Anweisung aus.
  $verlag = $select->fetch();
  if ($select->rowCount() == 1) {
  
  
  }


}


?> 

<h1>Verlag bearbeiten</h1> 

<form action="edit_verlag.php" method="post">

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
    <td class="eingabe"><input type="submit" value="Eintragen"></td>
</table> 

</form>

<?php

$Name=''; 
$Bemerkung='';

// Wurde das Formular abgesendet?
if ("POST" == $_SERVER["REQUEST_METHOD"]) {
    
    $Name=$_POST["Name"]; 
    $Bemerkung=$_POST["Bemerkung"]; 

    include("dbconnect_pdo.php"); // nur wenn benötigt 

    $insert = $db->prepare("INSERT INTO `verlag` SET
     `Name`     = :Name,
     `Bemerkung`     = :Bemerkung"
    );

    $insert->bindValue(':Name', $Name);
    $insert->bindValue(':Bemerkung', $Bemerkung);
    
    if ($insert->execute()) {
        $id = $db->lastInsertId();
        echo '<p>Der Datensatz wurde mit ID '.$id.' eingefuegt.</p>';
        echo '<p><a href="bearbeiten.php?ID=' . $id . '">Datensatz bearbeiten</a></p>';
        echo '<p><a href="show_table.php?table=verlag&&sortcol=ID&sortorder=desc" target="_blank">Tabellendaten anzeigen</a> (neues Fenster)</p>';     
 
    }
    else {
        print_r($insert->errorInfo());
    }
}

include('foot.php');

?>
