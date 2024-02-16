
<?php 
include('head.php');
?> 

<h1>Komponist erfassen</h1> 

<form action="insert_komponist.php" method="post">

<table class="eingabe"> 
<tr>    
    <label>
    <td class="eingabe">Vorname:</td>  
    <td class="eingabe"><input type="text" name="Vorname" size="45" maxlength="80" required="required" autofocus="autofocus"></td>
     </label>
   </tr> 

<tr>    
    <label>
    <td class="eingabe">Nachname:</td>  
    <td class="eingabe"><input type="text" name="Nachname" size="45" maxlength="80" required="required" autofocus="autofocus"></td>
     </label>
   </tr> 

   <tr>    
    <label>
    <td class="eingabe">Geburtsjahr:</td>  
    <td class="eingabe"><input type="text" name="Geburtsjahr" size="10" maxlength="80" autofocus="autofocus"></td>
     </label>
   </tr> 

   <tr>    
    <label>
    <td class="eingabe">Sterbejahr:</td>  
    <td class="eingabe"><input type="text" name="Sterbejahr" size="10" maxlength="80" autofocus="autofocus"></td>
     </label>
   </tr> 

   <tr>    
    <label>
    <td class="eingabe">Bemerkung:</td>  
    <td class="eingabe"><input type="text" name="Bemerkung" size="80" maxlength="100" autofocus="autofocus"></td>
     </label>
   </tr> 


  <tr> 
    <td class="eingabe"></td> 
    <td class="eingabe"><input type="submit" value="Speichern"></td>
</tr>
</table> 

</form>

<?php

// Wurde das Formular abgesendet?
if ("POST" == $_SERVER["REQUEST_METHOD"]) {
 
  include("dbconnect_pdo.php"); 
  
  $Vorname=$_POST["Vorname"]; 
  $Nachname=$_POST["Nachname"]; 
  $Geburtsjahr=$_POST["Geburtsjahr"]; 
  $Sterbejahr=$_POST["Sterbejahr"];     
  $Bemerkung=$_POST["Bemerkung"];     

  $insert = $db->prepare("INSERT INTO `komponist` SET
                        `Vorname`     = :Vorname,
                        `Nachname`     = :Nachname,
                        `Geburtsjahr`     = :Geburtsjahr,
                        `Sterbejahr`     = :Sterbejahr,     
                        `Bemerkung`     = :Bemerkung"
  );

    $insert->bindParam(':Vorname', $Vorname);
    $insert->bindParam(':Nachname', $Nachname);
    $insert->bindParam(':Geburtsjahr', $Geburtsjahr);
    $insert->bindParam(':Sterbejahr', $Sterbejahr);
    $insert->bindParam(':Bemerkung', $Bemerkung);
    
    if ($insert->execute()) {
        $id = $db->lastInsertId();
        echo '<p>Der Datensatz wurde mit ID '.$id.' eingefuegt. <a href="edit_komponist.php?ID=' . $id . '">Datensatz bearbeiten</a></p>';
        echo '<p></p>';
        echo '<p><a href="show_table.php?table=komponist&sortcol=ID&sortorder=desc">Tabellendaten anzeigen</a></p>';     
 
    }
    else {
        echo '<p>Fehler! <br/>'.$insert->errorInfo().'</p>'; 

    }
}

include('foot.php');

?>
