
<?php 
include('head_raw.php');
include("dbconnect_pdo.php"); 
include("snippets.php");


if (isset($_GET["SammlungID"])) {
  // echo '<p>Musikstueck_ID: '.$_GET["SammlungID"];
  $query="SELECT ID, 
          Nummer, 
          Name       
        from musikstueck   
        WHERE SammlungID = :SammlungID 
        ORDER by Nummer"; 

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
// echo '<p> <a href="edit_sammlung_list_musikstuecke.php?SammlungID='.$_GET["SammlungID"].'">Musikstücke anzeigen</a></p>'; 
 
 

include('foot_raw.php');

?>
