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
<h1>Sätze zum Musikstück erfassen</h1> 

<form action="insert_satz.php" method="post">

<table class="eingabe"> 
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
    <td class="eingabe">Nr:</td>  
    <td class="eingabe"><input type="text" name="Nr" size="45" maxlength="80" autofocus="autofocus" required> </td>
     </label>
   </tr>    

   <tr>    
    <label>
    <td class="eingabe">Name:</td>  
    <td class="eingabe"><input type="text" name="Name" size="45" maxlength="80" autofocus="autofocus">  (falls vom Musikstück abweichend, sonst leer lassen)</td>
     </label>
   </tr> 




  <tr> 
    <td class="eingabe"></td> 
    <td class="eingabe"><input type="submit" value="Speichern"></td>
</tr>

</form>


</table> 



<?php

if ("POST" == $_SERVER["REQUEST_METHOD"]) {

  include("dbconnect_pdo.php"); // nur wenn benötigt 

  $MusikstueckID=$_POST["MusikstueckID"];     
  $Nr=$_POST["Nr"]; 
  $Name=$_POST["Name"]; 


    $insert = $db->prepare("INSERT INTO `satz` SET
     `Name`     = :Name,
     `MusikstueckID`     = :MusikstueckID,  
     `Nr`     = :Nr");

    $insert->bindValue(':MusikstueckID', $MusikstueckID);
    $insert->bindValue(':Nr', $Nr);
    $insert->bindValue(':Name', $Name);

    if ($insert->execute()) {
        $ID = $db->lastInsertId();
        echo '<p>Der Datensatz wurde mit ID '.$ID.' eingefuegt. <a href="edit_satz.php?ID='.$ID.'"><b>Bearbeitung fortsetzen</b></a></p>';
        // echo '<p><a href="show_table.php?table=satz&sortcol=ID&sortorder=desc">Tabellendaten anzeigen</a></p>';
    }
    else {
        echo '<p>Fehler! <br/>'.$insert->errorInfo().'</p>'; 
        // print_r($insert->errorInfo());
        // XXX Nutzer-Info anzeigen 
    }
}
// echo '<p>Sätze zum Musikstück ID '.$MusikstueckID . ':</p>';

// $stmt = $db->prepare("SELECT 
//               ID, 
//               Nr, 
//               Name
//               from satz 
//               WHERE MusikstueckID = :ID
//               ORDER by Nr "
// );
// $stmt->bindParam(':ID', $MusikstueckID, PDO::PARAM_INT); 

// // $stmt->errorInfo();
// try {
//     $stmt->execute(); 
//     $html_table= get_html_table($stmt); // s. snippets.php
//     echo $html_table;  
// }
//     catch (PDOException $e) {
//     echo '<p>Ein Fehler ist aufgetreten.</p>';
//     echo '<p>'.$e->getMessage().'</p>';
// // echo '<p>debugDumpParams: '.$stmt->debugDumpParams(); 
// }


include('foot.php');

?>
