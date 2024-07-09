
<?php 
include('head.php');
include("cl_standort.php");
include("cl_html_info.php");

echo '<h2>Standort bearbeiten</h2>'; 

$standort = new Standort();
$info= new HtmlInfo(); 

if (!isset($_GET["option"]) and isset($_GET["ID"]))  {
  // geöffnet über einen "Bearbeiten"-Link
  $standort->ID=$_GET["ID"];
  $standort->load_row();  
  $info->print_action_info($standort->ID, 'view');    
}
if (isset($_GET["option"]) and $_GET["option"]=='insert') {
  // nach insert geladen   
  $standort->insert_row(''); 
  $info->print_action_info($standort->ID, 'insert');     
}
if (isset($_POST["option"]) and $_POST["option"]=='edit') {
  // in akt. Datei nach dem editieren gespeichert 
  $standort->ID = $_POST["ID"];    
  $standort->update_row($_POST["Name"]); 
  $info->print_action_info($standort->ID, 'update');     
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
    <td class="eingabe"><input type="text" name="Name" value="'.$standort->Name.'" size="45" maxlength="80" required="required" autofocus="autofocus" oninput="changeBackgroundColor(this)"></td>
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

include('foot.php');

?>
