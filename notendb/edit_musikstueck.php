
<?php 
include('head.php');
include("dbconnect_pdo.php"); 
include("snippets.php");

$table='musikstueck'; 

$ID=''; 
if (isset($_GET["ID"])) {
  $ID= $_GET["ID"];
}
if (isset($_POST["ID"])) {
  $ID= $_POST["ID"];
}

echo '<h2>Musikstück bearbeiten</h2>'; 

if (isset($_GET["ID"])) {

  $select = $db->prepare("SELECT 
                        `ID`
                        ,`Name`                       
                        ,`Opus`
                        ,`SammlungID`
                        ,`Nummer`
                        ,`KomponistID`
                        ,`Bearbeiter`
                        ,`Epoche`
                        ,`Verwendungszweck`
                        ,`Gattung`
                        ,`JahrAuffuehrung`
            FROM `musikstueck`
            WHERE `ID` = :ID");

  $select->bindParam(':ID', $_GET["ID"], PDO::PARAM_INT);
  $select->execute(); // Führt die Anweisung aus.
  $musikstueck = $select->fetch();

  if ($select->rowCount() == 1) {
        echo '
        <form action="edit_musikstueck.php" method="post">

        <table class="eingabe"> 
        <tr>    
        <label>
        <td class="eingabe">ID:</td>  
        <td class="eingabe">'.$musikstueck["ID"].'</td>
        </label>
         </tr> 

         <tr>    
         <label>
         <td class="eingabe">Nummer:</td>  
         <td class="eingabe"><input type="text" name="Nummer" value="'.$musikstueck["Nummer"].'" size="45" maxlength="80"  autofocus="autofocus"></td>
         </label>
       </tr> 

          <tr>    
            <label>
            <td class="eingabe">Name:</td>  
            <td class="eingabe"><input type="text" name="Name" value="'.$musikstueck["Name"].'" size="45" maxlength="80" required="required" autofocus="autofocus"></td>
            </label>
          </tr> 
          <tr>    
          <label>
          <td class="eingabe">Komponist:</td>  
          <td class="eingabe">
          <!-- Auswahlliste Komponist  -->         
          '; 
           $select = $db->query("SELECT DISTINCT `ID` as KomponistID, CONCAT(`Nachname`, ', ', `Vorname`) as Name FROM `komponist` order by `Nachname`");
          $options = $select->fetchAll(PDO::FETCH_KEY_PAIR);            
          $html = get_html_select2($options, 'KomponistID', $musikstueck["KomponistID"], true); // s. snippets.php
          echo $html.' </label>        
              <a href="insert_komponist.php" target="_blank">[Komponist erfassen]</a>  </td></tr>';

          echo  '<tr>    
          <label>
          <td class="eingabe">Sammlung:</td>  
          <td class="eingabe">
          <!-- Auswahlliste Sammlung (Vorgabe von Übergabe-Parameter oder von letzter Erfassung) -->         
          '; 
          $select = $db->query("SELECT DISTINCT `ID` as SammlungID, `Name` FROM `sammlung` order by `Name`");
          $options = $select->fetchAll(PDO::FETCH_KEY_PAIR);        
          $html = get_html_select2($options, 'SammlungID', $musikstueck["SammlungID"], true); // s. snippets.php
          echo $html.' </label></tr>';
          
          echo '



          <tr>    
            <label>
            <td class="eingabe">Opus:</td>  
            <td class="eingabe"><input type="text" name="Opus" value="'.$musikstueck["Opus"].'" size="45" maxlength="80" autofocus="autofocus"></td>
            </label>
          </tr> 

          <tr>    
            <label>
            <td class="eingabe">Bearbeiter:</td>  
            <td class="eingabe"><input type="text" name="Bearbeiter" value="'.$musikstueck["Bearbeiter"].'" size="45" maxlength="80" autofocus="autofocus"></td>
            </label>
          </tr> 

          <tr>    
            <label>
            <td class="eingabe">Epoche:</td>  
            <td class="eingabe"><input type="text" name="Epoche" value="'.$musikstueck["Epoche"].'" size="45" maxlength="80" autofocus="autofocus"></td>
            </label>
          </tr> 
          <tr>    
          <label>
          <td class="eingabe">Verwendungszweck:</td>  
          <td class="eingabe"><input type="text" name="Verwendungszweck" value="'.$musikstueck["Verwendungszweck"].'" size="45" maxlength="80" autofocus="autofocus"></td>
          </label>
        </tr> 
          <tr>    
          <label>
          <td class="eingabe">Gattung:</td>  
          <td class="eingabe"><input type="text" name="Gattung" value="'.$musikstueck["Gattung"].'" size="45" maxlength="80" autofocus="autofocus"></td>
          </label>
        </tr> 

        </tr> 

         <tr>    
          <label>
          <td class="eingabe">Aufführungsjahre:</td>  
          <td class="eingabe"><input type="text" name="JahrAuffuehrung" value="'.$musikstueck["JahrAuffuehrung"].'" size="45" maxlength="80" autofocus="autofocus"></td>
          </label>
        </tr>         
        
        <tr> 
            <td class="eingabe"></td> 
            <td class="eingabe"><input type="submit" name="senden" value="Speichern">
          </td>
          </tr> 

              <input type="hidden" name="ID" value="' . $musikstueck["ID"] . '">
              <input type="hidden" name="option" value="edit">      

              </form>

 

            <tr> 
              <td class="eingabe">Besetzung(en):</td> 
              <td class="eingabe"><iframe src="edit_musikstueck_list_besetzungen.php?MusikstueckID='.$musikstueck["ID"].'" width="1000" height="200" name="Besetzungen"></iframe>
            </td>
            </tr> 
  
            <tr> 
              <td class="eingabe">Sätze:<br>(Anzeige ausgewählte Felder)</td> 
              <td class="eingabe"><iframe src="edit_musikstueck_list_saetze.php?MusikstueckID='.$musikstueck["ID"].'" width="1000" height="400" name="Saetze"></iframe>
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
  if ($_POST["option"] == 'edit') {
      $update = $db->prepare("UPDATE `musikstueck` 
                            SET
                            `Name`     = :Name,
                            `SammlungID`     = :SammlungID,   
                            `KomponistID`     = :KomponistID,                              
                            `Nummer`     = :Nummer,   
                            `Opus`     = :Opus,   
                            `Gattung`     = :Gattung,                               
                            `Bearbeiter`     = :Bearbeiter,   
                            `Epoche`     = :Epoche,   
                            `Verwendungszweck`     = :Verwendungszweck,   
                            `JahrAuffuehrung` = :JahrAuffuehrung
                            WHERE `ID` = :ID"); 

      $update->bindParam(':ID', $_POST["ID"], PDO::PARAM_INT);
      $update->bindParam(':Name', $_POST["Name"]);

      $update->bindParam(':SammlungID', $_POST["SammlungID"], ( $_POST["SammlungID"]=='' ? PDO::PARAM_NULL : PDO::PARAM_INT)); 
      $update->bindParam(':KomponistID', $_POST["KomponistID"], ( $_POST["KomponistID"]=='' ? PDO::PARAM_NULL : PDO::PARAM_INT));  

      $update->bindParam(':Nummer', $_POST["Nummer"]);  
      $update->bindParam(':Opus', $_POST["Opus"]); 
      $update->bindParam(':Gattung', $_POST["Gattung"]);       

      $update->bindParam(':Bearbeiter', $_POST["Bearbeiter"]);            
      $update->bindParam(':Epoche', $_POST["Epoche"]);

      $update->bindParam(':Verwendungszweck', $_POST["Verwendungszweck"]);            
      $update->bindParam(':JahrAuffuehrung', $_POST["JahrAuffuehrung"]);

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
