
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
              <td class="eingabe">Musikstücke:</td> 
              <td class="eingabe"><iframe src="edit_sammlung_list_musikstuecke.php?SammlungID='.$sammlung["ID"].'" width="500" height="200" name="Besetzungen"></iframe>
            </td>
            </tr> 

   
        </table> 

        '; 

  }
  else {
    echo '<p>Dieser Datensatz ist nicht vorhanden!</p>';
  }
}

if (isset($_POST["senden"])) {
  include("dbconnect_pdo.php");
  $ID=$_POST["ID"]; 
  if ($_POST["option"] == 'edit') {
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

      try {
        $update->execute(); 
        $count_affected_rows= $update->rowCount(); 
        echo get_html_user_action_info($table, 'update', $count_affected_rows,$ID);  
        echo get_html_editlink($table,$ID);
      }
      catch (PDOException $e) {
        echo get_html_user_error_info(); 
        echo get_html_error_info($update, $e); 
      }
    }
}

echo get_html_showtablelink($table); 

include('foot.php');

?>
