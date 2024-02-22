
<?php 
include('head_raw.php');
include("dbconnect_pdo.php"); 
include("snippets.php");


if (isset($_GET["SatzID"])) {
  // echo '<p>Musikstueck_ID: '.$_GET["SatzID"];
  $query="SELECT sa.ID
              , sa.Name                              
        FROM satz_strichart ssa         
          inner join strichart sa
            on ssa.StrichartID=sa.ID   
        WHERE ssa.SatzID = :SatzID 
        ORDER by sa.Name"; 

 // echo $query; 
  
  $stmt = $db->prepare($query); // statement-Objekt 
  $stmt->bindParam(':SatzID', $_GET["SatzID"], PDO::PARAM_INT); 

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
  echo '<p> <a href="edit_satz_add_strichart.php?SatzID='.$_GET["SatzID"].'">[Strichart ergänzen]</a></p>'; 

}
include('foot_raw.php');

?>
