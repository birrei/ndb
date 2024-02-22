
<?php 
include('head.php');
include('snippets.php'); 
?> 

<h1>Verlag erfassen</h1> 

<form action="insert_verlag.php" method="post">

<table class="eingabe"> 
  <tr>    
    <label>
    <td class="eingabe">Name:</td>  
    <td class="eingabe"><input type="text" name="Name" size="45" maxlength="80" required="required" autofocus="autofocus"></td>
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

$ID=''; 
$Name=''; 
$Bemerkung='';

// Wurde das Formular abgesendet?
if ("POST" == $_SERVER["REQUEST_METHOD"]) {
    
    $Name=$_POST["Name"]; 
    $Bemerkung=$_POST["Bemerkung"]; 

    include("dbconnect_pdo.php"); // nur wenn benötigt 

    $insert = $db->prepare("INSERT INTO `verlag` SET
     `Name`     = :Name,
     `Bemerkung`     = :Bemerkung"
    );

    $insert->bindValue(':Name', $Name);
    $insert->bindValue(':Bemerkung', $Bemerkung);
    
    if ($insert->execute()) {
        $ID = $db->lastInsertId();
        echo '<p>Der Datensatz wurde mit ID '.$ID.' eingefuegt. <a href="edit_verlag.php?ID='.$ID.'">Datensatz bearbeiten</a></p>';
        // echo '<p><a href="show_table2.php?table=verlag">Tabellendaten anzeigen</a></p>';

 
    }
    else {
        echo '<p>Fehler! <br/>'.$insert->errorInfo().'</p>'; 
        // print_r($insert->errorInfo());
        // XXX Nutzer-Info anzeigen 
    }
}

echo get_html_showtablelink('verlag'); 
  

include('foot.php');

?>
