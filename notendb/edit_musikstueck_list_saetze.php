
<?php 
include('head_raw.php');
include("dbconnect_pdo.php"); 
include("snippets.php");


if (isset($_GET["MusikstueckID"])) {
  // echo '<p>Musikstueck_ID: '.$_GET["MusikstueckID"];
  $query="SELECT ID, 
          Nr, 
          Name,  
          Tonart,
          Taktart,
          Tempobezeichnung,
          Spieldauer,
          Schwierigkeitsgrad         
        from satz   
        WHERE MusikstueckID = :MusikstueckID 
        ORDER by Nr"; 

 // echo $query; 
  
  $stmt = $db->prepare($query); // statement-Objekt 
  $stmt->bindParam(':MusikstueckID', $_GET["MusikstueckID"], PDO::PARAM_INT); 

  try {
    $stmt->execute(); 
    $html_table= get_html_table($stmt, 'satz', true); // s. snippets.php
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
echo '<p> <a href="edit_musikstueck_add_satz.php?MusikstueckID='.$_GET["MusikstueckID"].'">Satz hinzufügen</a></p>'; 
// echo '<p> <a href="edit_musikstueck_list_saetze.php?MusikstueckID='.$_GET["MusikstueckID"].'">Sätze anzeigen</a></p>'; 
 
 

include('foot_raw.php');

?>
