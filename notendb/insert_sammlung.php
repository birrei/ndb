
<?php 
include('head.php');
?> 

<h1>Sammlung erfassen</h1> 

<form action="insert_sammlung.php" method="post">

<table class="eingabe"> 
  <tr>    
    <label>
    <td class="eingabe">Name:</td>  
    <td class="eingabe"><input type="text" name="Name" size="45" maxlength="80" required="required" autofocus="autofocus"></td>
     </label>
   </tr> 

   <tr>    
    <label>
    <td class="eingabe">Verlag:</td>  
    <td class="eingabe">
        <!-- Auswahlliste Verlag  --> 
        <?php 
              include("dbconnect_pdo.php");
              include("snippets.php");

              $select = $db->query("SELECT DISTINCT `ID` as VerlagID, `Name` FROM `verlag` order by `Name`");
              $options = $select->fetchAll(PDO::FETCH_KEY_PAIR);
              
              $html = get_html_select2($options, 'VerlagID', '', true); // s. snippets.php
              echo $html;
        ?>
    </td>
    </label>
     </tr> 

    
   <tr>    
    <label>
    <td class="eingabe">Standort:</td>  
    <td class="eingabe"><input type="text" name="Standort" size="45" maxlength="80" autofocus="autofocus"></td>
     </label>
   </tr> 

   <tr>    
    <label>
    <td class="eingabe">Bestellnummer:</td>  
    <td class="eingabe"><input type="text" name="Bestellnummer" size="45" maxlength="80" autofocus="autofocus"></td>
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
    <td class="eingabe"><input type="submit" value="Speichern"></td>
</tr>
</table> 

</form>

<?php

$Name=''; 
$VerlagID=0; 
$Bestellnummer='';
$Standort='';
$Bemerkung='';

// Wurde das Formular abgesendet?
if ("POST" == $_SERVER["REQUEST_METHOD"]) {
  include("dbconnect_pdo.php"); // nur wenn benötigt     

  $Name=$_POST["Name"]; 
  $VerlagID=$_POST["VerlagID"];     
  $Bestellnummer=$_POST["Bestellnummer"];
  $Standort=$_POST["Standort"]; 
  $Bemerkung=$_POST["Bemerkung"];     

  $insert = $db->prepare("INSERT INTO `sammlung` 
    SET
    `Name`     = :Name,
    `VerlagID`     = :VerlagID,  
    `Bestellnummer`     = :Bestellnummer,  
    `Standort`     = :Standort,  
    `Bemerkung`     = :Bemerkung"
  );

  $insert->bindValue(':Name', $Name);
  $insert->bindValue(':VerlagID', $VerlagID, ( $VerlagID=='' ? PDO::PARAM_NULL : PDO::PARAM_INT));   
  $insert->bindValue(':Bestellnummer', $Bestellnummer);        
  $insert->bindValue(':Standort', $Standort);         
  $insert->bindValue(':Bemerkung', $Bemerkung);
  
  if ($insert->execute()) {
      $id = $db->lastInsertId();
      echo '<p>Der Datensatz wurde mit ID '.$id.' eingefuegt. <a href="edit_sammlung.php?ID=' . $id . '">Datensatz bearbeiten</a></p>';
      echo '<p><a href="show_table.php?table=sammlung&&sortcol=ID&sortorder=desc">Tabellendaten anzeigen</a></p>';     
  }
  else {
      echo '<p>Fehler! <br/>'.$insert->errorInfo().'</p>'; 
      // print_r($insert->errorInfo());
      // XXX Nutzer-Info anzeigen 
  }
}

include('foot.php');

?>
