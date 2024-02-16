
<?php 
include('head_raw.php');
include("dbconnect_pdo.php"); 
include("snippets.php");

if (isset($_GET["MusikstueckID"])) {
  // echo '<p>Musikstueck_ID: '.$_GET["MusikstueckID"];
  $query="SELECT b.ID
              , b.Name                              
        FROM `musikstueck` m 
          inner join musikstueck_besetzung mb 
            on m.ID=mb.MusikstueckID          
          inner join besetzung b
            on b.ID=mb.BesetzungID  
        WHERE mb.MusikstueckID = :MusikstueckID 
        ORDER by b.Name"; 

 // echo $query; 
  
  $stmt = $db->prepare($query); // statement-Objekt 
  $stmt->bindParam(':MusikstueckID', $_GET["MusikstueckID"], PDO::PARAM_INT); 

  try {
    $stmt->execute(); 
    $html_table= get_html_table($stmt); // s. snippets.php
    echo $html_table;  
  }
  catch (PDOException $e) {
    echo '<p>Ein Fehler ist aufgetreten.</p>';
    // echo '<p>'.$e->getMessage().'</p>';
    // echo '<p>debugDumpParams: '.$stmt->debugDumpParams(); 
  }

}
include('foot_raw.php');

?>
