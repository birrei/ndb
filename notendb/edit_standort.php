
<?php 
include('head.php');
include("cl_standort.php");
include("cl_html_info.php");

echo '<h2>Standort bearbeiten</h2>'; 

$standort = new Standort();

if (isset($_GET["ID"])) {
  $standort->ID = $_GET["ID"];  
  $standort->load_row(); 
}

if (isset($_POST["senden"])) {
    $standort->ID = $_POST["ID"];    
    $standort->update_row($_POST["Name"]); 
}

echo '
<form action="edit_standort.php" method="post">
<table class="eingabe"> 
  <tr>    
  <label>
  <td class="eingabe">ID:</td>  
  <td class="eingabe">'.$standort->ID.'</td>
  </label>
    </tr> 

  <tr>    
    <label>
    <td class="eingabe">Name:</td>  
    <td class="eingabe"><input type="text" name="Name" value="'.$standort->Name.'" size="45" maxlength="80" required="required" autofocus="autofocus"></td>
    </label>
  </tr> 


  <tr> 
    <td class="eingabe"></td> 
    <td class="eingabe"><input type="submit" name="senden" value="Speichern">

    </td>
  </tr> 

</table> 
<input type="hidden" name="option" value="edit">        
<input type="hidden" name="ID" value="' . $standort->ID. '">

</form>
'; 
if (isset($_POST["senden"])) {
  $ID= $_POST["ID"]; 
  if ($_POST["option"] == 'edit') { 
    $info= new HtmlInfo(); 
    $info->print_action_info($standort->ID, 'update'); 
    $info->print_close_form_info(); 
   }
}

include('foot.php');

?>
