
<?php 
include('head_raw.php');
include("dbconnect_pdo.php");
include("snippets.php");

$table='satz_strichart'; 

$SatzID=''; 
if (isset($_GET["SatzID"])) {
  $SatzID= $_GET["SatzID"];
}
if (isset($_POST["SatzID"])) {
  $SatzID= $_POST["SatzID"];
}
?> 

<form action="edit_satz_add_strichart.php" method="post">

<table class="eingabe"> 

   <tr>    
    <label>
    <td class="eingabe">Strichart:</td>  
    <td class="eingabe">
        <!-- Auswahlliste Strichart  --> 
        <?php 
              $select = $db->prepare("SELECT 
                              ID, 
                              Name  
                              FROM `strichart`
                              WHERE ID NOT IN (
                                    SELECT DISTINCT StrichartID 
                                    FROM satz_strichart
                                    WHERE SatzID=:SatzID
                              ) 
                              order by `Name`");
              $select->bindParam(':SatzID',$SatzID, PDO::PARAM_INT); 
              $select->execute();                 
              // $select = $db->query("SELECT ID, Name  FROM `strichart` order by `Name`");
              $options = $select->fetchAll(PDO::FETCH_KEY_PAIR);            
              $html = get_html_select2($options, 'StrichartID', '', true); // s. snippets.php
              echo $html;
        ?>
    </td>
    </label>

    <input type="hidden" name="SatzID" value="<?php echo $SatzID; ?>"> 
    

   <tr> 
    <td class="eingabe"></td> 
    <td class="eingabe"><input type="submit" value="Speichern"></td>
</tr>
</table> 
</form>

<?php

if ("POST" == $_SERVER["REQUEST_METHOD"]) {
  include("dbconnect_pdo.php"); // nur wenn benötigt     

  $SatzID=$_POST["SatzID"];           
  $StrichartID=$_POST["StrichartID"];           

  $insert = $db->prepare("INSERT INTO `satz_strichart` SET
                          `SatzID`     = :SatzID,  
                          `StrichartID`     = :StrichartID");

  $insert->bindValue(':SatzID', $SatzID);  
  $insert->bindValue(':StrichartID', $StrichartID);  

  try {
    $insert->execute(); 
    $ID = $db->lastInsertId();
    $count_affected_rows= $insert->rowCount(); 
    echo get_html_user_action_info($table, 'insert', $count_affected_rows,$ID);  
    // echo get_html_editlink($table,$ID);
  }
  catch (PDOException $e) {
    echo get_html_user_error_info(); 
    echo get_html_error_info($insert, $e); 
  }
}
echo '<p> <a href="edit_satz_list_stricharten.php?SatzID='.$SatzID.'">[Stricharten anzeigen]</a></p>'; 

include('foot_raw.php');

?>
