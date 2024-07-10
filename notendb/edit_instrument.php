
<?php 
include('head.php');
include("cl_instrument.php");
include("cl_html_info.php");

echo '<h2>Instrument bearbeiten</h2>'; 

$instrument = new Instrument();
$info= new HtmlInfo(); 

if (!isset($_GET["option"]) and isset($_GET["ID"]))  {
  // geöffnet über einen "Bearbeiten"-Link
  $instrument->ID=$_GET["ID"];
  $instrument->load_row();  
  $info->print_action_info($instrument->ID, 'view');    
}
if (isset($_GET["option"]) and $_GET["option"]=='insert') {
  // nach insert geladen   
  $instrument->insert_row(''); 
  $info->print_action_info($instrument->ID, 'insert');     
}
if (isset($_POST["option"]) and $_POST["option"]=='edit') {
  // in akt. Datei nach dem editieren gespeichert 
  $instrument->ID = $_POST["ID"];    
  $instrument->update_row($_POST["Name"]); 
  $info->print_action_info($instrument->ID, 'update');     
}

$info->print_link_show_table('instrument', 'sortcol=Name', 'Instrumente'); 


echo '
<form action="edit_instrument.php" method="post">
<table class="eingabe"> 
  <tr>    
  <label>
  <td class="eingabe">ID:</td>  
  <td class="eingabe">'.$instrument->ID.'</td>
  </label>
    </tr> 

  <tr>    
    <label>
    <td class="eingabe">Name:</td>  
    <td class="eingabe"><input type="text" name="Name" value="'.$instrument->Name.'" size="45" maxlength="80" required="required" autofocus="autofocus" oninput="changeBackgroundColor(this)"></td>
    </label>
  </tr> 


  <tr> 
    <td class="eingabe"></td> 
    <td class="eingabe"><input type="submit" name="senden" value="Speichern">

    </td>
  </tr> 

</table> 
<input type="hidden" name="option" value="edit">        
<input type="hidden" name="ID" value="' . $instrument->ID. '">

</form>
'; 

include('foot.php');

?>
