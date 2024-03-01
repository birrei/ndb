
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
          echo $html.' </label></tr>';

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
            <td class="eingabe">Nummer:</td>  
            <td class="eingabe"><input type="text" name="Nummer" value="'.$musikstueck["Nummer"].'" size="45" maxlength="80"  autofocus="autofocus"></td>
            </label>
          </tr> 


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
              <td class="eingabe">Besetzung(en):
               <br> <a href="insert_musikstueck_besetzung.php?MusikstueckID='.$musikstueck["ID"].'" target="_blank">[Besetzung hinzufügen]</a> 
             </td> 
              <td class="eingabe">

              '; 
              $stmt = $db->prepare("SELECT b.ID
                                , b.Name                              
                          FROM `musikstueck` m 
                                inner join musikstueck_besetzung mb 
                                  on m.ID=mb.MusikstueckID          
                                inner join besetzung b
                                  on b.ID=mb.BesetzungID  
                          WHERE mb.MusikstueckID = :ID
                          ORDER by b.Name "
                  );
              $stmt->bindParam(':ID', $musikstueck["ID"], PDO::PARAM_INT); 

              // $stmt->errorInfo();
              try {
                $stmt->execute(); 
                $html_table= get_html_table($stmt); // s. snippets.php
                echo $html_table;  
              }
              catch (PDOException $e) {
                echo '<p>Ein Fehler ist aufgetreten.</p>';
                // echo '<p>'.$e->getMessage().'</p>';
                // echo '<p>debugDumpParams: '.$stmt->debugDumpParams(); 
              }

          echo '
  
          </td>
        </tr>    
        
        
        <tr> 
        <td class="eingabe">Sätze:</td> 
        <td class="eingabe">

        '; 
        $stmt = $db->prepare("SELECT 
                          ID, 
                          Nr, 
                          Name, 
                          Tonart,
                          Taktart,
                          Tempobezeichnung,
                          Spieldauer,
                          Schwierigkeitsgrad,
                          Lagen,
                          Stricharten,
                          Notenwerte,
                          Erprobt, 
                          Bemerkung
                    from satz 
                    WHERE MusikstueckID = :ID
                    ORDER by Nr "
            );
        $stmt->bindParam(':ID', $musikstueck["ID"], PDO::PARAM_INT); 

        // $stmt->errorInfo();
        try {
          $stmt->execute(); 
          $html_table= get_html_table($stmt, 'satz', true); // s. snippets.php
          echo $html_table;  
        }
        catch (PDOException $e) {
          echo '<p>Ein Fehler ist aufgetreten.</p>';
          echo '<p>'.$e->getMessage().'</p>';
         // echo '<p>debugDumpParams: '.$stmt->debugDumpParams(); 
        }

    echo '
    <br> <a href="insert_satz.php?MusikstueckID='.$musikstueck["ID"].'" target="_blank">[Satz hinzufügen]</a> 
         
    </td>
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

      // $update->debugDumpParams(); 

      if ($update->execute())
        {
          // $update->debugDumpParams(); 
          echo '<p>'.$update->rowCount().' Zeilen geändert. <a href="edit_musikstueck.php?ID='.$_POST["ID"].'">Datensatz erneut bearbeiten</a></p>';     
        }
        else {
          // print_r($update->errorInfo());
          echo '<p>Fehler! <br/>'.$update->errorInfo().'</p>';             
       }
     }

    // if ($_POST["option"] == 'delete')
    //   {
    //     // Datensatz löschen      
    //     $delete = $db->prepare("delete from `sammlung` where `ID`=:ID");  
        
    //     try {
    //       $delete->execute([':ID' => $_POST["ID"]]); 
    //       echo '<p>Der Datensatz wurde gelöscht.</p>';
    //     }
    //     catch (PDOException $e) {
    //       echo '<p>Der Datensatz konnte nicht gelöscht werden.<br />'.$e->getMessage().'</p>';
    //     }
    //   }
   
}


echo '<p> <a href="show_table2.php?table='.$table.'&sortorder=desc">Tabelle anzeigen</a></p>'; 


include('foot.php');

?>
