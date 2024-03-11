
<?php 
include('head_raw.php');
include("dbconnect_pdo.php"); 
include("snippets.php");


if (isset($_GET["SammlungID"])) {
  // echo '<p>Musikstueck_ID: '.$_GET["SammlungID"];
  $query="SELECT m.ID, 
          m.Nummer, 
          m.Name, 
          CONCAT(COALESCE(k.Vorname, '') , ' ', COALESCE(k.Nachname, '')) as Komponist           
        from musikstueck m
        left join komponist k
          on m.KomponistID = k.ID  
        WHERE m.SammlungID = :SammlungID 
        ORDER by m.Nummer"; 

 // echo $query; 
  
  $stmt = $db->prepare($query); // statement-Objekt 
  $stmt->bindParam(':SammlungID', $_GET["SammlungID"], PDO::PARAM_INT); 

  try {
    $stmt->execute(); 
    $html_table= get_html_table($stmt, 'musikstueck', true); // s. snippets.php
    echo $html_table;  
  }
  catch (PDOException $e) {
    echo '<p>Ein Fehler ist aufgetreten.</p>';
    // echo '<p>'.$e->getMessage().'</p>';
    // echo '<p>'.$stmt->debugDumpParams(); 
    }
}
else {
      echo '<p>Keine Sätze vorhanden</p>'; 
}
echo '<p> <a href="edit_sammlung_add_musikstueck.php?SammlungID='.$_GET["SammlungID"].'">Musikstück hinzufügen</a></p>'; 
echo '<p> <a href="edit_sammlung_list_musikstuecke.php?SammlungID='.$_GET["SammlungID"].'">Aktualisieren</a></p>'; 
 
 

include('foot_raw.php');

?>
