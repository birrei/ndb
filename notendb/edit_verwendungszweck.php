
<?php 
include('head.php');
include("cl_verwendungszweck.php");
include("cl_html_info.php");

echo '<h2>Verwendungszweck bearbeiten</h2>'; 

$verwendungszweck = new Verwendungszweck();
$info= new HtmlInfo(); 

if (!isset($_GET["option"]) and isset($_GET["ID"]))  {
  // geöffnet über einen "Bearbeiten"-Link
  $verwendungszweck->ID=$_GET["ID"];
  $verwendungszweck->load_row();  
  $info->print_action_info($verwendungszweck->ID, 'view');    
}
if (isset($_GET["option"]) and $_GET["option"]=='insert') {
  // nach insert geladen   
  $verwendungszweck->insert_row(''); 
  $info->print_action_info($verwendungszweck->ID, 'insert');     
}
if (isset($_POST["option"]) and $_POST["option"]=='edit') {
  // in akt. Datei nach dem editieren gespeichert 
  $verwendungszweck->ID = $_POST["ID"];    
  $verwendungszweck->update_row($_POST["Name"]); 
  $info->print_action_info($verwendungszweck->ID, 'update');     
}

$info->print_link_show_table('verwendungszweck', 'sortcol=Name', 'Verwendungszwecke'); 

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
    <td class="eingabe"><input type="text" name="Name" value="'.$verwendungszweck->Name.'" size="45" maxlength="80" required="required" autofocus="autofocus" oninput="changeBackgroundColor(this)"></td>
    </label>
  </tr> 


  <tr> 
    <td class="eingabe"></td> 
    <td class="eingabe"><input type="submit" name="senden" value="Speichern">

    </td>
  </tr> 

</table> 
<input type="hidden" name="option" value="edit">        
<input type="hidden" name="ID" value="'. $verwendungszweck->ID. '">

</form>
'; 

$info->print_link_delete_row($verwendungszweck->table_name, $verwendungszweck->ID, $verwendungszweck->Title); 

include('foot.php');

?>
