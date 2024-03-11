
<?php 
include('head.php');
include('snippets.php'); 
include("dbconnect_pdo.php");

$table='sammlung'; 



?> 

<h1>Sammlung erfassen</h1> 


<form action="insert_sammlung.php" method="post">

<table class="eingabe"> 

   <tr>    
    <label>
    <td class="eingabe">Verlag:<br> 

    </td>  
    <td class="eingabe">
        <!-- Auswahlliste Verlag  --> 
        <?php 
              $select = $db->query("SELECT DISTINCT `ID` as VerlagID, `Name` FROM `verlag` order by `Name`");
              $options = $select->fetchAll(PDO::FETCH_KEY_PAIR);
              $html = get_html_select2($options, 'VerlagID', '', true); // s. snippets.php
              echo $html;
        ?>
    </label>        

      <?php 
        echo get_html_insert_link2('verlag'); 
      ?>
        </td>

     </tr> 

     <tr>    
    <label>
    <td class="eingabe">Name:</td>  
    <td class="eingabe"><input type="text" name="Name" size="45" maxlength="80" required="required" autofocus="autofocus"></td>
     </label>
   </tr> 



  <tr> 
    <td class="eingabe"></td> 
    <td class="eingabe"><input type="submit" value="Speichern"></td>
</tr>
</table> 
</form>

  


<?php

$Name=''; 
$VerlagID=0; 
$Bestellnummer='';
$Standort='';
$Bemerkung='';

// Wurde das Formular abgesendet?
if ("POST" == $_SERVER["REQUEST_METHOD"]) {
  include("dbconnect_pdo.php"); // nur wenn benötigt     

  $Name=$_POST["Name"]; 
  $VerlagID=$_POST["VerlagID"];     
  // $Bestellnummer=$_POST["Bestellnummer"];
  // $Standort=$_POST["Standort"]; 
  // $Bemerkung=$_POST["Bemerkung"];     

  $insert = $db->prepare("INSERT INTO `sammlung` 
    SET
    `Name`     = :Name,
    `VerlagID`     = :VerlagID"  
  );

  $insert->bindValue(':Name', $Name);
  $insert->bindValue(':VerlagID', $VerlagID, ( $VerlagID=='' ? PDO::PARAM_NULL : PDO::PARAM_INT));

  try {
    $insert->execute(); 
    $ID = $db->lastInsertId();
    $count_affected_rows= $insert->rowCount(); 
    echo get_html_user_action_info($table, 'insert', $count_affected_rows,$ID);  
  }
  catch (PDOException $e) {
    echo get_html_user_error_info(); 
    echo get_html_error_info($insert, $e); 
  }

}

include('foot.php');

?>
