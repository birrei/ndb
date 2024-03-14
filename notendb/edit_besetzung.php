
<?php 
include('head.php');
include("cl_besetzung.php");
include("cl_html_info.php");

echo '<h2>Besetzung bearbeiten</h2>'; 

$besetzung = new Besetzung();

if (isset($_GET["ID"])) {
  $ID= $_GET["ID"];  
  $besetzung->load_row($ID); 
}

if (isset($_POST["senden"])) {
  $ID= $_POST["ID"]; 
  if ($_POST["option"] == 'edit') { 
    $besetzung->update_row($ID, $_POST["Name"]); 
  }
}

echo '
<form action="edit_besetzung.php" method="post">
<table class="eingabe"> 
  <tr>    
  <label>
  <td class="eingabe">ID:</td>  
  <td class="eingabe">'.$besetzung->ID.'</td>
  </label>
    </tr> 

  <tr>    
    <label>
    <td class="eingabe">Name:</td>  
    <td class="eingabe"><input type="text" name="Name" value="'.$besetzung->Name.'" size="45" maxlength="80" required="required" autofocus="autofocus"></td>
    </label>
  </tr> 


  <tr> 
    <td class="eingabe"></td> 
    <td class="eingabe"><input type="submit" name="senden" value="Speichern">

    </td>
  </tr> 

</table> 
<input type="hidden" name="option" value="edit">        
<input type="hidden" name="ID" value="' . $besetzung->ID. '">

</form>
'; 
if (isset($_POST["senden"])) {
  $ID= $_POST["ID"]; 
  if ($_POST["option"] == 'edit') { 
    $info= new HtmlInfo(); 
    $info->print_action_info($besetzung->ID, 'update'); 
    $info->print_close_form_info(); 
   }
}

include('foot.php');

?>
