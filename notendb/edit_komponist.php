
<?php 
include('head.php');

$table='komponist'; 

echo '<h2>Komponist bearbeiten</h2>'; 

if (isset($_GET["ID"])) {

  include("dbconnect_pdo.php"); 

  $select = $db->prepare("SELECT `ID`, `Vorname`, `Nachname`, `Geburtsjahr`, `Sterbejahr`, `Bemerkung` 
  FROM `komponist`
  WHERE `ID` = :ID");
  $select->bindParam(':ID', $_GET["ID"], PDO::PARAM_INT);
  $select->execute(); // Führt die Anweisung aus.
  $komponist = $select->fetch();
  if ($select->rowCount() == 1) {

        echo '
        <form action="edit_komponist.php" method="post">

        <table class="eingabe"> 
        <tr>    
        <label>
        <td class="eingabe">ID:</td>  
        <td class="eingabe">'.$komponist["ID"].'</td>
        </label>
         </tr> 

          <tr>    
            <label>
            <td class="eingabe">Vorname:</td>  
            <td class="eingabe"><input type="text" name="Vorname" value="'.$komponist["Vorname"].'" size="45" maxlength="80" required="required" autofocus="autofocus"></td>
            </label>
          </tr> 

          <tr>    
            <label>
            <td class="eingabe">Nachname:</td>  
            <td class="eingabe"><input type="text" name="Nachname" value="'.$komponist["Nachname"].'" size="45" maxlength="80" required="required" autofocus="autofocus"></td>
            </label>
          </tr> 

          <tr>    
          <label>
          <td class="eingabe">Geburtsjahr:</td>  
          <td class="eingabe"><input type="text" name="Geburtsjahr" value="'.$komponist["Geburtsjahr"].'" size="10" maxlength="80" autofocus="autofocus"></td>
          </label>
        </tr> 
        <tr>    
        <label>
        <td class="eingabe">Sterbejahr:</td>  
        <td class="eingabe"><input type="text" name="Sterbejahr" value="'.$komponist["Sterbejahr"].'" size="10" maxlength="80" autofocus="autofocus"></td>
        </label>
      </tr> 

          <tr>    
            <label>
            <td class="eingabe">Bemerkung:</td>  
            <td class="eingabe"><input type="text" name="Bemerkung" value="'.$komponist["Bemerkung"].'" size="80" maxlength="80" autofocus="autofocus"></td>
            </label>
          </tr> 

          <tr> 
            <td class="eingabe"></td> 
            <input type="hidden" name="option" value="edit">      
            <td class="eingabe"><input type="submit" name="senden" value="Speichern">
     
            
            </td>
          </tr> 

        </table> 
        <input type="hidden" name="ID" value="' . $komponist["ID"] . '">

    
        </form>
        '; 
  }
  else {
    echo '<p>Dieser Datensatz ist nicht vorhanden!</p>';
  }
}

// Nach Absenden des Formulars 
if (isset($_POST["senden"])) {
  include("dbconnect_pdo.php");
  if ($_POST["option"] == 'edit') 
    {
      // Datensatz ändern     
      $update = $db->prepare("UPDATE `komponist` 
                            SET
                            `Vorname`     = :Vorname,
                            `Nachname`     = :Nachname,
                            `Geburtsjahr`     = :Geburtsjahr,
                            `Sterbejahr`     = :Sterbejahr,
                            `Bemerkung` = :Bemerkung
                            WHERE `ID` = :ID"); 

      // echo '<p>ID: '. $_POST["ID"].'</p>';                
      // echo '<p>Name: '. $_POST["Name"].'</p>';  
      // echo '<p>Bemerkung: '. $_POST["Bemerkung"].'</p>';  

      $update->bindParam(':ID', $_POST["ID"], PDO::PARAM_INT);
      $update->bindParam(':Vorname', $_POST["Vorname"]);
      $update->bindParam(':Nachname', $_POST["Nachname"]);
      $update->bindParam(':Geburtsjahr', $_POST["Geburtsjahr"]);
      $update->bindParam(':Sterbejahr', $_POST["Sterbejahr"]);
      $update->bindParam(':Bemerkung', $_POST["Bemerkung"]);

      if ($update->execute())
        {
          // $update->debugDumpParams(); 
          echo '<p>'.$update->rowCount().' Zeilen geändert. <a href="edit_komponist.php?ID='.$_POST["ID"].'">Datensatz erneut bearbeiten</a> </p>';     
        }
        else {
          // print_r($update->errorInfo());
          echo '<p>Fehler! <br/>'.$update->errorInfo().'</p>';             
       }
     }

    // if ($_POST["option"] == 'delete')
    //   {
    //     // Datensatz löschen      
    //     $delete = $db->prepare("delete from `komponist` where `ID`=:ID");  
        
    //     try {
    //       $delete->execute([':ID' => $_POST["ID"]]); 
    //       echo '<p>Der Datensatz wurde gelöscht.</p>';
    //     }
    //     catch (PDOException $e) {
    //       echo '<p>Der Datensatz konnte nicht gelöscht werden:<br />'.$e->getMessage().'</p>';
    //     }
    //   }
}

echo '<p><a href="show_table.php?table='.$table.'&sortorder=desc">Tabelle anzeigen</a></p>'; 

include('foot.php');

?>
