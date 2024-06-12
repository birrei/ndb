
<?php 
include('head.php');
include("cl_verlag.php");
include("cl_html_info.php");

echo '<h2>Verlag bearbeiten</h2>'; 

$verlag = new Verlag();
$info= new HtmlInfo(); 

if (!isset($_GET["option"]) and isset($_GET["ID"]))  {
  // geöffnet über einen "Bearbeiten"-Link
  $verlag->ID=$_GET["ID"];
  $verlag->load_row();  
  $info->print_action_info($verlag->ID, 'view');    
}
if (isset($_GET["option"]) and $_GET["option"]=='insert') {
  // nach insert geladen   
  $verlag->insert_row($_GET["Name"]); 
  $info->print_action_info($verlag->ID, 'insert');     
}
if (isset($_POST["option"]) and $_POST["option"]=='edit') {
  // in akt. Datei nach dem editieren gespeichert 
  $verlag->ID = $_POST["ID"];    
  $verlag->update_row($_POST["Name"], $_POST["Bemerkung"]); 
  $info->print_action_info($verlag->ID, 'update');     
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
    <td class="eingabe"><input type="text" name="Name" value="'.$verlag->Name.'" size="45" maxlength="80" required="required" autofocus="autofocus" oninput="changeBackgroundColor(this)"></td>
    </label>
  </tr> 


  <tr>    
    <label>
    <td class="eingabe">Bemerkung:</td>  
    <td class="eingabe"><input type="text" name="Bemerkung" value="'.$verlag->Bemerkung.'" size="45" maxlength="80"  oninput="changeBackgroundColor(this)"></td>
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

include('foot.php');

?>
