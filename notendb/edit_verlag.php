
<?php 
include("dbconnect_pdo.php"); 
include('head.php');
include('snippets.php'); 

$table='verlag'; 

echo '<h2>Verlag bearbeiten</h2>'; 

if (isset($_GET["ID"])) {

  $ID=$_GET["ID"]; 

  $select = $db->prepare("SELECT `ID`, `Name`, `Bemerkung` 
  FROM `verlag`
  WHERE `ID` = :ID");

  $select->bindParam(':ID', $_GET["ID"], PDO::PARAM_INT);
  $select->execute(); // Führt die Anweisung aus.
  $verlag = $select->fetch();
  if ($select->rowCount() == 1) {
    echo '
    <form action="edit_verlag.php" method="post">

    <table class="eingabe"> 
      <tr>    
      <label>
      <td class="eingabe">ID:</td>  
      <td class="eingabe">'.$verlag["ID"].'</td>
      </label>
        </tr> 

      <tr>    
        <label>
        <td class="eingabe">Name:</td>  
        <td class="eingabe"><input type="text" name="Name" value="'.$verlag["Name"].'" size="45" maxlength="80" required="required" autofocus="autofocus"></td>
        </label>
      </tr> 


      <tr>    
        <label>
        <td class="eingabe">Bemerkung:</td>  
        <td class="eingabe"><input type="text" name="Bemerkung" value="'.$verlag["Bemerkung"].'" size="45" maxlength="80" autofocus="autofocus"></td>
        </label>
      </tr> 

      <tr> 
        <td class="eingabe"></td> 
        <td class="eingabe"><input type="submit" name="senden" value="Speichern">

        </td>
      </tr> 

    </table> 
    <input type="hidden" name="option" value="edit">        
    <input type="hidden" name="ID" value="' . $verlag["ID"] . '">

    </form>
    '; 
  }
  else {
    echo '<p>Dieser Datensatz ist nicht vorhanden!</p>';
  }
}

if (isset($_POST["senden"])) {
  $ID=$_POST["ID"];   
  include("dbconnect_pdo.php");
  if ($_POST["option"] == 'edit') {
    $update = $db->prepare("UPDATE `verlag` 
                          SET
                          `Name`     = :Name,
                          `Bemerkung` = :Bemerkung
                          WHERE `ID` = :ID"); 

    $update->bindParam(':ID', $_POST["ID"], PDO::PARAM_INT);
    $update->bindParam(':Name', $_POST["Name"]);
    $update->bindParam(':Bemerkung', $_POST["Bemerkung"]);

    try {
      $update->execute(); 
      $count_affected_rows= $update->rowCount(); 
      echo get_html_user_action_info($table, 'update', $count_affected_rows,$ID);  
      echo get_html_editlink($table,$ID);
    }
    catch (PDOException $e) {
      echo get_html_user_error_info(); 
      echo get_html_error_info($update, $e); 
    }
  }
}

echo get_html_showtablelink($table); 

include('foot.php');

?>
