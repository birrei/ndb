
<?php 
include('head.php');
include("dbconnect_pdo.php");
include("snippets.php");

$SammlungID=''; 
if (isset($_GET["SammlungID"])) {
  $SammlungID= $_GET["SammlungID"];
}
if (isset($_POST["SammlungID"])) {
  $SammlungID= $_POST["SammlungID"];
}

?> 

<h1>Musikstück erfassen (Start) </h1> 

<form action="insert_musikstueck.php" method="post">

<table class="eingabe"> 
  <tr>    
    <label>
    <td class="eingabe">Name:</td>  
    <td class="eingabe"><input type="text" name="Name" size="45" maxlength="80" required="required" autofocus="autofocus"></td>
     </label>
   </tr> 

   <tr>    
    <label>
    <td class="eingabe">Komponist:</td>  
    <td class="eingabe">
        <!-- Auswahlliste Komponist  --> 
        <?php 
              $select = $db->query("SELECT DISTINCT `ID` as KomponistID, CONCAT(`Nachname`, ', ', `Vorname`) as Name FROM `komponist` order by `Nachname`");
              $options = $select->fetchAll(PDO::FETCH_KEY_PAIR);            
              $html = get_html_select2($options, 'KomponistID', '', true); // s. snippets.php
              echo $html;
        ?>
    </td>
    </label>
     </tr> 
     <tr>    
    <label>
    <td class="eingabe">Sammlung:</td>  
    <td class="eingabe">
        <!-- Auswahlliste Sammlung. Falls Seite aus  edit_sammlung.php heraus aufgerufen wird, soll SammlungID vorbelegt ein  --> 
        <?php 
              $select = $db->query("SELECT DISTINCT `ID` as SammlungID, `Name` FROM `sammlung` order by `Name`");
              $options = $select->fetchAll(PDO::FETCH_KEY_PAIR);        
              $html = get_html_select2($options, 'SammlungID', $SammlungID, true); // s. snippets.php
              echo $html;
        ?>
    </td>
    </label>
     </tr> 
    
   <tr>    
    <label>
    <td class="eingabe">Nummer:</td>  
    <td class="eingabe"><input type="text" name="Nummer" size="45" maxlength="80" autofocus="autofocus"></td>
     </label>
   </tr> 

   <tr>    
    <label>
    <td class="eingabe">Opus:</td>  
    <td class="eingabe"><input type="text" name="Opus" size="45" maxlength="80" autofocus="autofocus"></td>
     </label>
   </tr> 
 
   <tr>    
    <label>
    <td class="eingabe">Bearbeiter:</td>  
    <td class="eingabe"><input type="text" name="Bearbeiter" size="45" maxlength="80" autofocus="autofocus"></td>
     </label>
   </tr> 

   <tr>    
    <label>
    <td class="eingabe">Epoche:</td>  
    <td class="eingabe"><input type="text" name="Epoche" size="45" maxlength="80" autofocus="autofocus"></td>
     </label>
   </tr> 
   <tr>    
    <label>
    <td class="eingabe">Verwendungszweck:</td>  
    <td class="eingabe"><input type="text" name="Verwendungszweck" size="45" maxlength="80" autofocus="autofocus"></td>
     </label>
   </tr> 
   <tr>    
    <label>
    <td class="eingabe">Gattung:</td>  
    <td class="eingabe"><input type="text" name="Gattung" size="45" maxlength="80" autofocus="autofocus"></td>
     </label>
   </tr> 

   <tr>    
    <label>
    <td class="eingabe">Aufführungsjahre:</td>  
    <td class="eingabe"><input type="text" name="JahrAuffuehrung" size="45" maxlength="80" autofocus="autofocus"></td>
     </label>
   </tr> 

   <tr> 
    <td class="eingabe"></td> 
    <td class="eingabe"><input type="submit" value="Speichern"></td>
</tr>
</table> 

<p> Hinweis: nach dem Speichern des neuen Datensatzes werden die Formularfelder geleert
   bei Bedarf kann der nächste Datensatz erfasst werden </p> 

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
  $KomponistID=$_POST["KomponistID"]; 
  $SammlungID=$_POST["SammlungID"];           
  $Nummer=$_POST["Nummer"];
  $Opus=$_POST["Opus"]; 
  $Bearbeiter=$_POST["Bearbeiter"];   
  $Verwendungszweck=$_POST["Verwendungszweck"];  
  $Epoche=$_POST["Epoche"];      
  $Gattung=$_POST["Gattung"]; 
  $JahrAuffuehrung=$_POST["JahrAuffuehrung"];   


  $insert = $db->prepare("INSERT INTO `musikstueck` 
    SET
    `Name`     = :Name,
    `KomponistID`     = :KomponistID,  
    `SammlungID`     = :SammlungID,  
    `Nummer`     = :Nummer,  
    `Opus`     = :Opus,  
    `Bearbeiter`     = :Bearbeiter, 
    `Verwendungszweck`     = :Verwendungszweck, 
    `Epoche`     = :Epoche, 
    `Gattung`     = :Gattung, 
    `JahrAuffuehrung`     = :JahrAuffuehrung");

  $insert->bindValue(':Name', $Name);
  $insert->bindValue(':KomponistID', $KomponistID, ( $KomponistID=='' ? PDO::PARAM_NULL : PDO::PARAM_INT));  
  $insert->bindValue(':SammlungID', $SammlungID, ( $SammlungID=='' ? PDO::PARAM_NULL : PDO::PARAM_INT)); 
  $insert->bindValue(':Nummer', $Nummer);        
  $insert->bindValue(':Opus', $Opus);         
  $insert->bindValue(':Bearbeiter', $Bearbeiter);
  $insert->bindValue(':Verwendungszweck', $Verwendungszweck);
  $insert->bindValue(':Epoche', $Epoche);
  $insert->bindValue(':Gattung', $Gattung);
  $insert->bindValue(':JahrAuffuehrung', $JahrAuffuehrung);

  if ($insert->execute()) {
      $id = $db->lastInsertId();
      echo '<p>Der Datensatz wurde mit ID '.$id.' eingefuegt. <a href="edit_musikstueck.php?ID=' . $id . '"><b>Bearbeitung fortsetzen</b></a></p>';
  }
  else {
      echo '<p>Fehler! <br/>'.$insert->errorInfo().'</p>'; 
      // print_r($insert->errorInfo());
      // XXX Nutzer-Info anzeigen 
  }
}
echo get_html_showtablelink('musikstueck'); 
include('foot.php');

?>
