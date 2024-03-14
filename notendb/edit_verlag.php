
<?php 
include('head.php');
include("cl_verlag.php");
include("cl_html_info.php");

echo '<h2>Verlag bearbeiten</h2>'; 

$verlag = new Verlag();

if (isset($_GET["ID"])) {
  $ID= $_GET["ID"];  
  $verlag->load_row($ID); 
}

if (isset($_POST["senden"])) {
  $ID= $_POST["ID"]; 
  if ($_POST["option"] == 'edit') { 
    $verlag->update_row(
                      $ID
                      , $_POST["Name"]
                      , $_POST["Bemerkung"]                      
                    ); 
  }
}

echo '
<form action="edit_verlag.php" method="post">
<table class="eingabe"> 
  <tr>    
  <label>
  <td class="eingabe">ID:</td>  
  <td class="eingabe">'.$verlag->ID.'</td>
  </label>
    </tr> 

  <tr>    
    <label>
    <td class="eingabe">Name:</td>  
    <td class="eingabe"><input type="text" name="Name" value="'.$verlag->Name.'" size="45" maxlength="80" required="required" autofocus="autofocus"></td>
    </label>
  </tr> 


  <tr>    
    <label>
    <td class="eingabe">Bemerkung:</td>  
    <td class="eingabe"><input type="text" name="Bemerkung" value="'.$verlag->Bemerkung.'" size="45" maxlength="80" autofocus="autofocus"></td>
    </label>
  </tr> 

  <tr> 
    <td class="eingabe"></td> 
    <td class="eingabe"><input type="submit" name="senden" value="Speichern">

    </td>
  </tr> 

</table> 
<input type="hidden" name="option" value="edit">        
<input type="hidden" name="ID" value="' . $verlag->ID. '">

</form>
'; 
if (isset($_POST["senden"])) {
  $ID= $_POST["ID"]; 
  if ($_POST["option"] == 'edit') { 
    $info= new HtmlInfo(); 
    $info->print_action_info($verlag->ID, 'update'); 
    $info->print_close_form_info(); 
   }
}

include('foot.php');

?>
