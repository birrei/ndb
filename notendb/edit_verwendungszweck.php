
<?php 
include('head.php');
include("cl_verwendungszweck.php");
include("cl_html_info.php");

echo '<h2>Verwendungszweck bearbeiten</h2>'; 

$verwendungszweck = new verwendungszweck();

if (isset($_GET["ID"])) {
  $ID= $_GET["ID"];  
  $verwendungszweck->load_row($ID); 
}

if (isset($_POST["senden"])) {
  $ID= $_POST["ID"]; 
  if ($_POST["option"] == 'edit') { 
    $verwendungszweck->update_row($ID, $_POST["Name"]); 
  }
}

echo '
<form action="edit_verwendungszweck.php" method="post">
<table class="eingabe"> 
  <tr>    
  <label>
  <td class="eingabe">ID:</td>  
  <td class="eingabe">'.$verwendungszweck->ID.'</td>
  </label>
    </tr> 

  <tr>    
    <label>
    <td class="eingabe">Name:</td>  
    <td class="eingabe"><input type="text" name="Name" value="'.$verwendungszweck->Name.'" size="45" maxlength="80" required="required" autofocus="autofocus"></td>
    </label>
  </tr> 


  <tr> 
    <td class="eingabe"></td> 
    <td class="eingabe"><input type="submit" name="senden" value="Speichern">

    </td>
  </tr> 

</table> 
<input type="hidden" name="option" value="edit">        
<input type="hidden" name="ID" value="' . $verwendungszweck->ID. '">

</form>
'; 
if (isset($_POST["senden"])) {
  $ID= $_POST["ID"]; 
  if ($_POST["option"] == 'edit') { 
    $info= new HtmlInfo(); 
    $info->print_action_info($verwendungszweck->ID, 'update'); 
    $info->print_close_form_info(); 
   }
}

include('foot.php');

?>
