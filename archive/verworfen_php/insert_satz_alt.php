<?php 
include('head.php');
include("snippets.php");

/* 
Formular wird nur aus "Musikstück bearbeiten" heraus geöffnet, kein Einstiegslink auf Startseite 
*/
$MusikstueckID=''; 
if (isset($_GET["MusikstueckID"])) {
  $MusikstueckID= $_GET["MusikstueckID"];
}
if (isset($_POST["MusikstueckID"])) {
  $MusikstueckID= $_POST["MusikstueckID"];
}

?> 
<h1>Satz erfassen</h1> 
<form action="insert_satz.php" method="post">

<table class="eingabe"> 
  <tr>    
    <label>
    <td class="eingabe">Name:</td>  
    <td class="eingabe"><input type="text" name="Name" size="45" maxlength="80" autofocus="autofocus">  (falls vom Musikstück abweichend, sonst leer lassen)</td>
     </label>
   </tr> 
   <tr>    
    <label>
    <td class="eingabe">Nr:</td>  
    <td class="eingabe"><input type="text" name="Nr" size="45" maxlength="80" autofocus="autofocus" required> </td>
     </label>
   </tr>    

   <tr>    
    <label>
    <td class="eingabe">Musikstueck:</td>  
    <td class="eingabe">
        <!-- Auswahlliste Musikstueck (ohne echte Auswahl, es wird nur das vorbelegte Musikstüeck angezeigt ) --> 
        <?php 
              include("dbconnect_pdo.php");
              // $select = $db->query("SELECT DISTINCT `ID` as MusikstueckID, `Name` FROM `Musikstueck` order by `Name`");
              $select = $db->query("SELECT DISTINCT `ID` as MusikstueckID, `Name` FROM `Musikstueck` WHERE ID=".$MusikstueckID);
              $options = $select->fetchAll(PDO::FETCH_KEY_PAIR);
              $html = get_html_select2($options, 'MusikstueckID', $MusikstueckID, true); // s. snippets.php
              echo $html;
        ?>
    </td>
    </label>
     </tr> 

  <tr>    
    <label>
    <td class="eingabe">Tonart:</td>  
    <td class="eingabe"><input type="text" name="Tonart" size="45" maxlength="80" autofocus="autofocus"></td>
     </label>
   </tr> 

   <tr>    
    <label>
    <td class="eingabe">Taktart:</td>  
    <td class="eingabe"><input type="text" name="Taktart" size="45" maxlength="80" autofocus="autofocus"></td>
     </label>
   </tr> 


   <tr>    
    <label>
    <td class="eingabe">Tempobezeichnung:</td>  
    <td class="eingabe"><input type="text" name="Tempobezeichnung" size="45" maxlength="80" autofocus="autofocus"></td>
     </label>
   </tr> 


   <tr>    
    <label>
    <td class="eingabe">Spieldauer:</td>  
    <td class="eingabe"><input type="text" name="Spieldauer" size="45" maxlength="80" autofocus="autofocus"></td>
     </label>
   </tr> 

   <tr>    
    <label>
    <td class="eingabe">Schwierigkeitsgrad:</td>  
    <td class="eingabe"><input type="text" name="Schwierigkeitsgrad" size="45" maxlength="80" autofocus="autofocus"></td>
     </label>
   </tr> 




   <tr>    
    <label>
    <td class="eingabe">Lagen:</td>  
    <td class="eingabe"><input type="text" name="Lagen" size="45" maxlength="80" autofocus="autofocus"></td>
     </label>
   </tr>    

   <tr>    
    <label>
    <td class="eingabe">Stricharten:</td>  
    <td class="eingabe"><input type="text" name="Stricharten" size="45" maxlength="80" autofocus="autofocus"></td>
     </label>
   </tr>   

   <tr>    
    <label>
    <td class="eingabe">Notenwerte:</td>  
    <td class="eingabe"><input type="text" name="Notenwerte" size="45" maxlength="80" autofocus="autofocus"></td>
     </label>
   </tr>   
     
   <tr>    
    <label>
    <td class="eingabe">Erprobt:</td>  
    <td class="eingabe"><input type="text" name="Erprobt" size="45" maxlength="80" autofocus="autofocus"></td>
     </label>
   </tr>   

   <tr>    
    <label>
    <td class="eingabe">Bemerkung:</td>  
    <td class="eingabe"><input type="text" name="Bemerkung" size="100" maxlength="100" autofocus="autofocus"></td>
     </label>
   </tr> 


  <tr> 
    <td class="eingabe"></td> 
    <td class="eingabe"><input type="submit" value="Speichern"></td>
</tr>
</table> 

</form>

<?php

$MusikstueckID=''; 
$Nr=''; 
$Name=''; 

$Tonart=''; 
$Taktart=''; 
$Tempobezeichnung=''; 
$Spieldauer='';

$Schwierigkeitsgrad='';
$Stricharten='';
$Notenwerte='';
$Lagen='';

$Erprobt='';
$Bemerkung='';

if ("POST" == $_SERVER["REQUEST_METHOD"]) {
    $MusikstueckID=$_POST["MusikstueckID"];     
    $Nr=$_POST["Nr"]; 
    $Name=$_POST["Name"]; 
    
    $Tonart=$_POST["Tonart"]; 
    $Taktart=$_POST["Taktart"]; 
    $Tempobezeichnung=$_POST["Tempobezeichnung"]; 
    $Spieldauer=$_POST["Spieldauer"];

    $Schwierigkeitsgrad=$_POST["Schwierigkeitsgrad"];
    $Stricharten=$_POST["Stricharten"];
    $Lagen=$_POST["Lagen"];    
    $Notenwerte=$_POST["Notenwerte"];

    $Erprobt=$_POST["Erprobt"];
    $Bemerkung=$_POST["Bemerkung"]; 

    include("dbconnect_pdo.php"); // nur wenn benötigt 

    $insert = $db->prepare("INSERT INTO `satz` SET
     `Name`     = :Name,
     `MusikstueckID`     = :MusikstueckID,  
     `Nr`     = :Nr,    

     `Tonart`     = :Tonart,    
     `Taktart`     = :Taktart,    
     `Tempobezeichnung`     = :Tempobezeichnung,    
     `Spieldauer`     = :Spieldauer,    

     `Schwierigkeitsgrad`     = :Schwierigkeitsgrad,    
     `Lagen`     = :Lagen,    
     `Stricharten`     = :Stricharten,    
     `Notenwerte`     = :Notenwerte,    

     `Erprobt`     = :Erprobt,    
     `Bemerkung`     = :Bemerkung"
    );

    $insert->bindValue(':MusikstueckID', $MusikstueckID);
    $insert->bindValue(':Nr', $Nr);
    $insert->bindValue(':Name', $Name);

    $insert->bindValue(':Tonart', $Tonart);
    $insert->bindValue(':Taktart', $Taktart);
    $insert->bindValue(':Tempobezeichnung', $Tempobezeichnung);
    $insert->bindValue(':Spieldauer', $Spieldauer);

    $insert->bindValue(':Schwierigkeitsgrad', $Schwierigkeitsgrad);
    $insert->bindValue(':Lagen', $Lagen);
    $insert->bindValue(':Stricharten', $Stricharten);
    $insert->bindValue(':Notenwerte', $Notenwerte);

    $insert->bindValue(':Erprobt', $Erprobt);    
    $insert->bindValue(':Bemerkung', $Bemerkung);
    


    
    if ($insert->execute()) {
        $ID = $db->lastInsertId();
        echo '<p>Der Datensatz wurde mit ID '.$ID.' eingefuegt. <a href="edit_satz.php?ID='.$ID.'"><b>Bearbeitung fortsetzen</b></a></p>';
        echo '<p><a href="show_table.php?table=satz&sortcol=ID&sortorder=desc">Tabellendaten anzeigen</a></p>';
 
    }
    else {
        echo '<p>Fehler! <br/>'.$insert->errorInfo().'</p>'; 
        // print_r($insert->errorInfo());
        // XXX Nutzer-Info anzeigen 
    }
}

include('foot.php');

?>
