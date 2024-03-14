
<?php 
include("dbconnect_pdo.php"); 
include('head.php');
include('snippets.php'); 

$table='besetzung'; 

echo '<h2>Besetzung bearbeiten</h2>'; 

if (isset($_GET["ID"])) {

  $ID=$_GET["ID"]; 

  $select = $db->prepare("SELECT `ID`, `Name`
  FROM `besetzung`
  WHERE `ID` = :ID");

  $select->bindParam(':ID', $_GET["ID"], PDO::PARAM_INT);
  $select->execute(); // Führt die Anweisung aus.
  $besetzung = $select->fetch();
  if ($select->rowCount() == 1) {
    echo '
    <form action="edit_besetzung.php" method="post">

    <table class="eingabe"> 
      <tr>    
      <label>
      <td class="eingabe">ID:</td>  
      <td class="eingabe">'.$besetzung["ID"].'</td>
      </label>
        </tr> 

      <tr>    
        <label>
        <td class="eingabe">Name:</td>  
        <td class="eingabe"><input type="text" name="Name" value="'.$besetzung["Name"].'" size="45" maxlength="80" required="required" autofocus="autofocus"></td>
        </label>
      </tr> 

      <tr> 
        <td class="eingabe"></td> 
        <td class="eingabe"><input type="submit" name="senden" value="Speichern">

        </td>
      </tr> 

    </table> 
    <input type="hidden" name="option" value="edit">        
    <input type="hidden" name="ID" value="' . $besetzung["ID"] . '">

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
    $update = $db->prepare("UPDATE `besetzung` 
                          SET
                          `Name`     = :Name
                          WHERE `ID` = :ID"); 

    $update->bindParam(':ID', $_POST["ID"], PDO::PARAM_INT);
    $update->bindParam(':Name', $_POST["Name"]);

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
