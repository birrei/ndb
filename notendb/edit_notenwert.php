
<?php 
include('head.php');
include("cl_notenwert.php");
include("cl_html_info.php");

echo '<h2>Notenwert bearbeiten</h2>'; 

$notenwert = new Notenwert();
$info= new HtmlInfo(); 

if (isset($_GET["option"]) and $_GET["option"]=='insert') {
  $notenwert->insert_row($_GET["Name"]); 
}
if (isset($_POST["option"]) and $_POST["option"]=='edit') {
  $notenwert->ID = $_POST["ID"];    
  $notenwert->update_row($_POST["Name"]); 
}

echo '
<form action="edit_notenwert.php" method="post">
<table class="eingabe"> 
  <tr>    
  <label>
  <td class="eingabe">ID:</td>  
  <td class="eingabe">'.$notenwert->ID.'</td>
  </label>
    </tr> 

  <tr>    
    <label>
    <td class="eingabe">Name:</td>  
    <td class="eingabe"><input type="text" name="Name" value="'.$notenwert->Name.'" size="45" maxlength="80" required="required" autofocus="autofocus"></td>
    </label>
  </tr> 


  <tr> 
    <td class="eingabe"></td> 
    <td class="eingabe"><input type="submit" name="senden" value="Speichern">

    </td>
  </tr> 

</table> 
<input type="hidden" name="option" value="edit">        
<input type="hidden" name="ID" value="' . $notenwert->ID. '">

</form>
'; 
if (isset($_POST["senden"])) {
  $ID= $_POST["ID"]; 
  if ($_POST["option"] == 'edit') { 

    $info->print_action_info($notenwert->ID, 'update'); 
    $info->print_close_form_info(); 
   }
}

$info->print_table_link('notenwert'); 

include('foot.php');

?>
