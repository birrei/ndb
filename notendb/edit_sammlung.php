
<?php 
include('head.php');
include("dbconnect_pdo.php"); 
include("snippets.php");

$table='sammlung'; 

echo '<h2>Sammlung bearbeiten</h2>'; 

if (isset($_GET["ID"])) {

  $select = $db->prepare("SELECT 
                        `ID`, 
                        `Name`, 
                        `VerlagID`, 
                        `Bestellnummer` , 
                        `Standort`, 
                        `Bemerkung`
            FROM `sammlung`
            WHERE `ID` = :ID");

  $select->bindParam(':ID', $_GET["ID"], PDO::PARAM_INT);
  $select->execute(); // Führt die Anweisung aus.
  $sammlung = $select->fetch();

  if ($select->rowCount() == 1) {
        echo '
        <form action="edit_sammlung.php" method="post">

        <table class="eingabe"> 
        <tr>    
        <label>
        <td class="eingabe">ID:</td>  
        <td class="eingabe">'.$sammlung["ID"].'</td>
        </label>
         </tr> 

          <tr>    
            <label>
            <td class="eingabe">Name:</td>  
            <td class="eingabe"><input type="text" name="Name" value="'.$sammlung["Name"].'" size="80" maxlength="80" required="required" autofocus="autofocus"></td>
            </label>
          </tr> 
          <tr>    
          <label>
          <td class="eingabe">Verlag:</td>  
          <td class="eingabe">
          <!-- Auswahlliste Verlag  -->         
          '; 

          $select = $db->query("SELECT DISTINCT `ID` as VerlagID, `Name` FROM `verlag` order by `Name`");
          $options = $select->fetchAll(PDO::FETCH_KEY_PAIR);
          
          $html = get_html_select2($options, 'VerlagID', $sammlung["VerlagID"]); // s. snippets.php
          echo $html.'</label></tr>' ;          

          echo '
          <tr>    
            <label>
            <td class="eingabe">Standort:</td>  
            <td class="eingabe"><input type="text" name="Standort" value="'.$sammlung["Standort"].'" size="45" maxlength="80"  autofocus="autofocus"></td>
            </label>
          </tr> 

          <tr>    
            <label>
            <td class="eingabe">Bestellnummer:</td>  
            <td class="eingabe"><input type="text" name="Bestellnummer" value="'.$sammlung["Bestellnummer"].'" size="45" maxlength="80" autofocus="autofocus"></td>
            </label>
          </tr> 

          <tr>    
            <label>
            <td class="eingabe">Bemerkung:</td>  
            <td class="eingabe"><input type="text" name="Bemerkung" value="'.$sammlung["Bemerkung"].'" size="45" maxlength="80" autofocus="autofocus"></td>
            </label>
          </tr> 

          <tr> 
            <td class="eingabe"></td> 
            <td class="eingabe"><input type="submit" name="senden" value="Speichern">     
            
          </td>
          </tr> 

              <input type="hidden" name="ID" value="' . $sammlung["ID"] . '">
              <input type="hidden" name="option" value="edit">      
              </form>

          <tr> 
              <td class="eingabe"> </td> 
              <td class="eingabe">
              <a href="insert_musikstueck.php?SammlungID='.$sammlung["ID"].'" target="_blank">[neues Musikstueck erfassen]</a><br> <br>
              <br>Musikstuecke:
              <br>  <br>  
              '; 
              $stmt = $db->prepare("SELECT `ID`
                                , `Name`
                                , `Nummer`
                                , m.Bearbeiter
                                , m.Epoche
                                , m.Verwendungszweck
                                , m.Gattung                                 
                          FROM `musikstueck` m 
                          WHERE `SammlungID` = :SammlungID
                          ORDER by Nummer "
                  );
              $stmt->bindParam(':SammlungID', $sammlung["ID"], PDO::PARAM_INT); 
              $stmt->execute(); 
              $html_table= get_html_table($stmt, 'musikstueck', true); // s. snippets.php
              echo $html_table;    
          echo '</td>
        </tr> 
        </table> 

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
      $update = $db->prepare("UPDATE `sammlung` 
                            SET
                            `Name`     = :Name,
                            `Standort`     = :Standort,   
                            `VerlagID`     = :VerlagID,                              
                            `Bestellnummer`     = :Bestellnummer,   
                            `Bemerkung` = :Bemerkung
                            WHERE `ID` = :ID"); 

      $update->bindParam(':ID', $_POST["ID"], PDO::PARAM_INT);
      $update->bindParam(':Name', $_POST["Name"]);
      $update->bindParam(':VerlagID', $_POST["VerlagID"], ( $_POST["VerlagID"]=='' ? PDO::PARAM_NULL : PDO::PARAM_INT));  
      $update->bindParam(':Standort', $_POST["Standort"]);  
      $update->bindParam(':Bestellnummer', $_POST["Bestellnummer"]);            
      $update->bindParam(':Bemerkung', $_POST["Bemerkung"]);

      if ($update->execute())
        {
          // $update->debugDumpParams(); 
          echo '<p>'.$update->rowCount().' Zeilen geändert. <a href="edit_sammlung.php?ID='.$_POST["ID"].'">Datensatz erneut bearbeiten</a> </p>';     
        }
        else {
          // print_r($update->errorInfo());
          echo '<p>Fehler! <br/>'.$update->errorInfo().'</p>';             
       }
     }

 
}


echo '<p> <a href="show_table.php?table='.$table.'&sortorder=desc">Tabelle anzeigen</a></p>'; 


include('foot.php');

?>
