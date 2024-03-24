
<?php 
include('head.php');
include("cl_epoche.php");
include("cl_html_info.php");

echo '<h2>Epoche bearbeiten</h2>'; 

$epoche = new Epoche();

if (isset($_GET["ID"])) {
  $epoche->ID = $_GET["ID"];  
  $epoche->load_row(); 
}

if (isset($_POST["senden"])) {
    $epoche->ID = $_POST["ID"];    
    $epoche->update_row($_POST["Name"]); 
}

echo '
<form action="edit_epoche.php" method="post">
<table class="eingabe"> 
  <tr>    
  <label>
  <td class="eingabe">ID:</td>  
  <td class="eingabe">'.$epoche->ID.'</td>
  </label>
    </tr> 

  <tr>    
    <label>
    <td class="eingabe">Name:</td>  
    <td class="eingabe"><input type="text" name="Name" value="'.$epoche->Name.'" size="45" maxlength="80" required="required" autofocus="autofocus"></td>
    </label>
  </tr> 


  <tr> 
    <td class="eingabe"></td> 
    <td class="eingabe"><input type="submit" name="senden" value="Speichern">

    </td>
  </tr> 

</table> 
<input type="hidden" name="option" value="edit">        
<input type="hidden" name="ID" value="' . $epoche->ID. '">

</form>
'; 
if (isset($_POST["senden"])) {
  $ID= $_POST["ID"]; 
  if ($_POST["option"] == 'edit') { 
    $info= new HtmlInfo(); 
    $info->print_action_info($epoche->ID, 'update'); 
    $info->print_close_form_info(); 
   }
}

include('foot.php');

?>
