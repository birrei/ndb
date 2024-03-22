
<?php 
include('head.php');
include("cl_gattung.php");
include("cl_html_info.php");

echo '<h2>Gattung bearbeiten</h2>'; 

$gattung = new Gattung();

if (isset($_GET["ID"])) {
  $gattung->ID = $_GET["ID"];  
  $gattung->load_row(); 
}

if (isset($_POST["senden"])) {
    $gattung->ID = $_POST["ID"];    
    $gattung->update_row($_POST["Name"]); 
}

echo '
<form action="edit_gattung.php" method="post">
<table class="eingabe"> 
  <tr>    
  <label>
  <td class="eingabe">ID:</td>  
  <td class="eingabe">'.$gattung->ID.'</td>
  </label>
    </tr> 

  <tr>    
    <label>
    <td class="eingabe">Name:</td>  
    <td class="eingabe"><input type="text" name="Name" value="'.$gattung->Name.'" size="45" maxlength="80" required="required" autofocus="autofocus"></td>
    </label>
  </tr> 


  <tr> 
    <td class="eingabe"></td> 
    <td class="eingabe"><input type="submit" name="senden" value="Speichern">

    </td>
  </tr> 

</table> 
<input type="hidden" name="option" value="edit">        
<input type="hidden" name="ID" value="' . $gattung->ID. '">

</form>
'; 
if (isset($_POST["senden"])) {
  $ID= $_POST["ID"]; 
  if ($_POST["option"] == 'edit') { 
    $info= new HtmlInfo(); 
    $info->print_action_info($gattung->ID, 'update'); 
    $info->print_close_form_info(); 
   }
}

include('foot.php');

?>
