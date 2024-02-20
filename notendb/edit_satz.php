
<?php 
include('head.php');
include("dbconnect_pdo.php"); 
include("snippets.php");

$table='satz'; 

$ID=''; 
if (isset($_GET["ID"])) {
  $ID= $_GET["ID"];
}
if (isset($_POST["ID"])) {
  $ID= $_POST["ID"];
}

echo '<h2>Satz bearbeiten</h2>'; 

if (isset($_GET["ID"])) {

  $select = $db->prepare("SELECT 
                `ID`
                ,`Name`
                ,`Nr`
                ,`MusikstueckID`
                ,`Tonart`
                ,`Taktart`
                ,`Tempobezeichnung`
                ,`Spieldauer`
                ,`Schwierigkeitsgrad`
                ,`Lagen`
                ,`Stricharten`
                ,`Notenwerte`
                ,`Erprobt`
                ,`Bemerkung`
            FROM `satz`
            WHERE `ID` = :ID");

  $select->bindParam(':ID', $_GET["ID"], PDO::PARAM_INT);
  $select->execute(); // Führt die Anweisung aus.
  $satz = $select->fetch();

  if ($select->rowCount() == 1) {
        echo '
        <form action="edit_satz.php" method="post">

        <table class="eingabe"> 
        <tr>    
        <label>
        <td class="eingabe">ID:</td>  
        <td class="eingabe">'.$satz["ID"].'</td>
        </label>
         </tr> 

          <tr>    
            <label>
            <td class="eingabe">Name:</td>  
            <td class="eingabe"><input type="text" name="Name" value="'.$satz["Name"].'" size="45" maxlength="80" required="required" autofocus="autofocus"></td>
            </label>
          </tr> 

          <tr>    
          <label>
          <td class="eingabe">Sammlung:</td>  
          <td class="eingabe">
          '; 

          /* Auswahlliste Musikstueck (ohne echte Auswahl, es wird nur das vorbelegte Musikstüeck angezeigt )  */
          $select = $db->query("SELECT DISTINCT `ID` as MusikstueckID, `Name` FROM `musikstueck` WHERE ID=".$satz["MusikstueckID"]);
          $options = $select->fetchAll(PDO::FETCH_KEY_PAIR);
          $html = get_html_select2($options, 'MusikstueckID', $satz["MusikstueckID"], true); // s. snippets.php
          echo $html.' </label></tr>';
    
          
          echo '
          <tr>    
            <label>
            <td class="eingabe">Nr:</td>  
            <td class="eingabe"><input type="text" name="Nr" value="'.$satz["Nr"].'" size="45" maxlength="80"  autofocus="autofocus"></td>
            </label>
          </tr> 

          <tr>    
            <label>
            <td class="eingabe">Tonart:</td>  
            <td class="eingabe"><input type="text" name="Tonart" value="'.$satz["Tonart"].'" size="45" maxlength="80" autofocus="autofocus"></td>
            </label>
          </tr> 



          <tr>    
            <label>
            <td class="eingabe">Taktart:</td>  
            <td class="eingabe"><input type="text" name="Taktart" value="'.$satz["Taktart"].'" size="45" maxlength="80" autofocus="autofocus"></td>
            </label>
          </tr> 

          <tr>    
            <label>
            <td class="eingabe">Tempobezeichnung:</td>  
            <td class="eingabe"><input type="text" name="Tempobezeichnung" value="'.$satz["Tempobezeichnung"].'" size="45" maxlength="80" autofocus="autofocus"></td>
            </label>
          </tr> 

          <tr>    
            <label>
            <td class="eingabe">Spieldauer:</td>  
            <td class="eingabe"><input type="text" name="Spieldauer" value="'.$satz["Spieldauer"].'" size="45" maxlength="80" autofocus="autofocus"></td>
            </label>
          </tr> 



          <tr>    
            <label>
            <td class="eingabe">Schwierigkeitsgrad:</td>  
            <td class="eingabe"><input type="text" name="Schwierigkeitsgrad" value="'.$satz["Schwierigkeitsgrad"].'" size="45" maxlength="80" autofocus="autofocus"></td>
            </label>
          </tr> 

          <tr>    
            <label>
            <td class="eingabe">Lagen:</td>  
            <td class="eingabe"><input type="text" name="Lagen" value="'.$satz["Lagen"].'" size="45" maxlength="80" autofocus="autofocus"></td>
            </label>
          </tr> 

          <tr>    
            <label>
            <td class="eingabe">Stricharten:</td>  
            <td class="eingabe"><input type="text" name="Stricharten" value="'.$satz["Stricharten"].'" size="45" maxlength="80" autofocus="autofocus"></td>
            </label>
          </tr> 

          <tr>    
            <label>
            <td class="eingabe">Notenwerte:</td>  
            <td class="eingabe"><input type="text" name="Notenwerte" value="'.$satz["Notenwerte"].'" size="45" maxlength="80" autofocus="autofocus"></td>
            </label>
          </tr> 

    

          <tr>    
            <label>
            <td class="eingabe">Erprobt:</td>  
            <td class="eingabe"><input type="text" name="Erprobt" value="'.$satz["Erprobt"].'" size="45" maxlength="80" autofocus="autofocus"></td>
            </label>
          </tr> 


          <tr>    
            <label>
            <td class="eingabe">Bemerkung:</td>  
            <td class="eingabe"><input type="text" name="Bemerkung" value="'.$satz["Bemerkung"].'" size="45" maxlength="80" autofocus="autofocus"></td>
            </label>
          </tr> 



            <tr> 
            <td class="eingabe"></td> 
            <td class="eingabe"><input type="submit" name="senden" value="Speichern">
     
          </td>
          </tr> 

              <input type="hidden" name="ID" value="' . $satz["ID"] . '">
              <input type="hidden" name="option" value="edit">      

              </form>

        
           

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
      $update = $db->prepare("UPDATE `satz` 
                            SET
                            Name=:Name, 
                            Nr=:Nr, 
                            MusikstueckID=:MusikstueckID, 
                            Tonart=:Tonart, 
                            Taktart=:Taktart, 
                            Tempobezeichnung=:Tempobezeichnung, 
                            Spieldauer=:Spieldauer, 
                            Schwierigkeitsgrad=:Schwierigkeitsgrad, 
                            Lagen=:Lagen, 
                            Stricharten=:Stricharten, 
                            Notenwerte=:Notenwerte, 
                            Erprobt=:Erprobt, 
                            Bemerkung=:Bemerkung
                            WHERE `ID` = :ID"); 

      $update->bindParam(':ID', $_POST["ID"]);
      $update->bindParam(':Name', $_POST["Name"]);
      $update->bindParam(':Nr', $_POST["Nr"]);
      $update->bindParam(':MusikstueckID', $_POST["MusikstueckID"]);
      $update->bindParam(':Tonart', $_POST["Tonart"]);
      $update->bindParam(':Taktart', $_POST["Taktart"]);
      $update->bindParam(':Tempobezeichnung', $_POST["Tempobezeichnung"]);
      $update->bindParam(':Spieldauer', $_POST["Spieldauer"]);
      $update->bindParam(':Schwierigkeitsgrad', $_POST["Schwierigkeitsgrad"]);
      $update->bindParam(':Lagen', $_POST["Lagen"]);
      $update->bindParam(':Stricharten', $_POST["Stricharten"]);
      $update->bindParam(':Notenwerte', $_POST["Notenwerte"]);
      $update->bindParam(':Erprobt', $_POST["Erprobt"]);
      $update->bindParam(':Bemerkung', $_POST["Bemerkung"]);


      if ($update->execute())
        {
          // $update->debugDumpParams(); 
          echo '<p>'.$update->rowCount().' Zeilen geändert. <a href="edit_satz.php?ID='.$_POST["ID"].'">Datensatz erneut bearbeiten</a></p>';     
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
