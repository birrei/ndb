
<?php 
include('head_raw.php');
include("dbconnect_pdo.php"); 
include("snippets.php");

if (isset($_GET["MusikstueckID"])) {
  // echo '<p>Musikstueck_ID: '.$_GET["MusikstueckID"];
  $MusikstueckID=$_GET["MusikstueckID"]; 
  $query="SELECT b.ID
              , b.Name                              
        FROM `musikstueck` m 
          inner join musikstueck_verwendungszweck mb 
            on m.ID=mb.MusikstueckID          
          inner join verwendungszweck b
            on b.ID=mb.VerwendungszweckID  
        WHERE mb.MusikstueckID = :MusikstueckID 
        ORDER by b.Name"; 

 // echo $query; 
  
  $stmt = $db->prepare($query); // statement-Objekt 
  $stmt->bindParam(':MusikstueckID', $MusikstueckID, PDO::PARAM_INT); 

  try {
    $stmt->execute(); 
    $html_table= get_html_table($stmt); // s. snippets.php
    echo $html_table;  
  }
  catch (PDOException $e) {
    echo '<p>Ein Fehler ist aufgetreten.</p>';
  }
  echo '<p> <a href="edit_musikstueck_add_verwendungszweck.php?MusikstueckID='.$MusikstueckID.'">[Verwendungszweck hinzufügen]</a></p>'; 

}
include('foot_raw.php');

?>
