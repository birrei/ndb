
<?php 
include('head.php');
include("cl_gattung.php");
include("cl_html_info.php");

echo '<h2>Gattung bearbeiten</h2>'; 

$gattung = new Gattung();
$info= new HtmlInfo(); 

if (!isset($_GET["option"]) and isset($_GET["ID"]))  {
  // geöffnet über einen "Bearbeiten"-Link
  $gattung->ID=$_GET["ID"];
  $gattung->load_row();  
  $info->print_action_info($gattung->ID, 'view');    
}
if (isset($_GET["option"]) and $_GET["option"]=='insert') {
  // nach insert geladen   
  $gattung->insert_row($_GET["Name"]); 
  $gattung->load_row();  
  $info->print_action_info($gattung->ID, 'insert');     
}
if (isset($_POST["option"]) and $_POST["option"]=='edit') {
  // in akt. Datei nach dem editieren gespeichert 
  $gattung->ID = $_POST["ID"];    
  $gattung->update_row($_POST["Name"]); 
  $info->print_action_info($gattung->ID, 'update');     
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
<input type="hidden" name="title" value="Gattung">        
<input type="hidden" name="ID" value="' . $gattung->ID. '">

</form>
'; 

include('foot.php');

?>
