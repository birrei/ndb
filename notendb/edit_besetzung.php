
<?php 
include('head.php');
include("cl_besetzung.php");
include("cl_html_info.php");

echo '<h2>Besetzung bearbeiten</h2>'; 

$besetzung = new Besetzung();;
$info= new HtmlInfo(); 

if (!isset($_GET["option"]) and isset($_GET["ID"]))  {
  // geöffnet über einen "Bearbeiten"-Link
  $besetzung->ID=$_GET["ID"];
  $besetzung->load_row();  
  $info->print_action_info($besetzung->ID, 'view');    
}
if (isset($_GET["option"]) and $_GET["option"]=='insert') {
  // nach insert geladen   
  $besetzung->insert_row($_GET["Name"]); 
  $besetzung->load_row();  
  $info->print_action_info($besetzung->ID, 'insert');     
}
if (isset($_POST["option"]) and $_POST["option"]=='edit') {
  // in akt. Datei nach dem editieren gespeichert 
  $besetzung->ID = $_POST["ID"];    
  $besetzung->update_row($_POST["Name"]); 
  $info->print_action_info($besetzung->ID, 'update');     
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
    <td class="eingabe"><input type="text" name="Name" value="'.$besetzung->Name.'" size="100" maxlength="80" required="required" autofocus="autofocus"></td>
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

include('foot.php');

?>
