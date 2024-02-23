
<?php 
include('head_raw.php');
include("dbconnect_pdo.php");
include("snippets.php");

$table='musikstueck_besetzung'; 

$MusikstueckID=''; 
if (isset($_GET["MusikstueckID"])) {
  $MusikstueckID= $_GET["MusikstueckID"];
}
if (isset($_POST["MusikstueckID"])) {
  $MusikstueckID= $_POST["MusikstueckID"];
}

?> 

<form action="edit_musikstueck_add_besetzung.php" method="post">

<table class="eingabe"> 

   <tr>    
    <label>
    <td class="eingabe">Besetzung:</td>  
    <td class="eingabe">
        <!-- Auswahlliste Besetzung  --> 
        <?php 
              // $select = $db->query("SELECT ID, Name  FROM `besetzung` order by `Name`");
              $select = $db->prepare("SELECT ID, Name  FROM `besetzung` 
                                    WHERE ID NOT IN
                                      (SELECT DISTINCT BesetzungID 
                                      FROM musikstueck_besetzung 
                                      where MusikstueckID=:MusikstueckID 
                                      ) 
                                    order by `Name`");
              $select->bindParam(':MusikstueckID',$MusikstueckID, PDO::PARAM_INT); 
              $select->execute(); 
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
    $count_affected_rows= $insert->rowCount(); 
    echo get_html_user_action_info($table, 'insert', $count_affected_rows,$ID);  
    // echo get_html_editlink($table,$ID);
  }
  catch (PDOException $e) {
    echo get_html_user_error_info(); 
    echo get_html_error_info($insert, $e); 
  }

}
echo '<p> <a href="edit_musikstueck_list_besetzungen.php?MusikstueckID='.$MusikstueckID.'">[Besetzungen anzeigen]</a></p>'; 

include('foot_raw.php');

?>
