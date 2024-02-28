
<?php 
include('head.php');
include('snippets.php'); 
$table='verwendungszweck'; 
?> 

<h1>Verwendungszweck erfassen</h1> 

<form action="insert_verwendungszweck.php" method="post">

<table class="eingabe"> 
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

$ID=''; 
$Name=''; 
$Bemerkung='';

if ("POST" == $_SERVER["REQUEST_METHOD"]) {
  include("dbconnect_pdo.php"); // nur wenn benötigt 
  
  $Name=$_POST["Name"]; 

  $insert = $db->prepare("INSERT INTO `verwendungszweck` SET
    `Name`     = :Name"
  );

  $insert->bindValue(':Name', $Name);

  try {
    $insert->execute(); 
    $ID = $db->lastInsertId();
    $count_affected_rows= $insert->rowCount(); 
    echo get_html_user_action_info($table, 'insert', $count_affected_rows,$ID);  
    echo get_html_editlink($table,$ID);
  }
  catch (PDOException $e) {
    echo get_html_user_error_info(); 
    echo get_html_error_info($insert, $e); 
  }

}

echo get_html_showtablelink($table); 

include('foot.php');

?>
