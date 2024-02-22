
<?php 
// ALT, wegräumen 
include('head.php');
include("dbconnect_pdo.php");
include("snippets.php");


$MusikstueckID=''; 
if (isset($_GET["MusikstueckID"])) {
  $MusikstueckID= $_GET["MusikstueckID"];
}
if (isset($_POST["MusikstueckID"])) {
  $MusikstueckID= $_POST["MusikstueckID"];
}



?> 

<!-- Formular soll nur von edit_musikstueck.php aus abrufbar sein  --> 
<h1>Musikstück Besetzung(en) erfassen</h1> 
<p> Hinweis: nach dem Speichern eines neuen Datensatzes wird das Formular geleert. 
  Bei Bedarf können weitere Besetzungen erfasst werden. 
  Nach Zuordnung der Besetzung(en) kann das Fenster geschlossen werden. 
</p> 

<form action="insert_musikstueck_besetzung.php" method="post">

<table class="eingabe"> 

   <tr>    
    <label>
    <td class="eingabe">Besetzung:</td>  
    <td class="eingabe">
        <!-- Auswahlliste Besetzung  --> 
        <?php 
              $select = $db->query("SELECT ID, Name  FROM `besetzung` order by `Name`");
              $options = $select->fetchAll(PDO::FETCH_KEY_PAIR);            
              $html = get_html_select2($options, 'BesetzungID', '', true); // s. snippets.php
              echo $html;
        ?>
    </td>
    </label>
     <input type="hidden" name="MusikstueckID" value="<?php echo $MusikstueckID; ?>"> 
   <tr> 
    <td class="eingabe"></td> 
    <td class="eingabe"><input type="submit" value="Speichern"></td>
</tr>
</table> 


</form>

<?php

// Wurde das Formular abgesendet?
if ("POST" == $_SERVER["REQUEST_METHOD"]) {
  include("dbconnect_pdo.php"); // nur wenn benötigt     

  $MusikstueckID=$_POST["MusikstueckID"];           
  $BesetzungID=$_POST["BesetzungID"];           

  $insert = $db->prepare("INSERT INTO `musikstueck_besetzung` SET
    `MusikstueckID`     = :MusikstueckID,  
    `BesetzungID`     = :BesetzungID");

  $insert->bindValue(':MusikstueckID', $MusikstueckID);  
  $insert->bindValue(':BesetzungID', $BesetzungID);  

  try {
    $insert->execute(); 
    $ID = $db->lastInsertId();
    echo '<p>Der Datensatz wurde mit ID '.$id.' eingefuegt.'; 

    $ID = $db->lastInsertId();
    $count_affected_rows= $insert->rowCount(); 
    echo get_html_user_action_info($table, 'insert', $count_affected_rows,$ID);  
    echo get_html_editlink($table,$ID)

  }
  catch (PDOException $e) {
    echo '<p>Ein Fehler ist aufgetreten.<br />Evt. haben Sie versucht, eine gleiche Besetzung mehrfach zuzuordnen</p>';
    // echo '<p>'.$e->getMessage().'</p>';
    // echo '<p>debugDumpParams: '.$stmt->debugDumpParams(); 
  }

}
echo get_html_showtablelink('komponist'); 

include('foot.php');

?>
