
<?php 
include('head.php');
include("cl_strichart.php");
include("cl_html_info.php");

echo '<h2>Strichart bearbeiten</h2>'; 

$strichart = new Strichart();
$info= new HtmlInfo(); 

if (!isset($_GET["option"]) and isset($_GET["ID"]))  {
  // geöffnet über einen "Bearbeiten"-Link
  $strichart->ID=$_GET["ID"];
  $strichart->load_row();  
  $info->print_action_info($strichart->ID, 'view');    
}
if (isset($_GET["option"]) and $_GET["option"]=='insert') {
  // nach insert geladen   
  $strichart->insert_row($_GET["Name"]); 
  $strichart->load_row();  
  $info->print_action_info($strichart->ID, 'insert');     
}
if (isset($_POST["option"]) and $_POST["option"]=='edit') {
  // in akt. Datei nach dem editieren gespeichert 
  $strichart->ID = $_POST["ID"];    
  $strichart->update_row($_POST["Name"]); 
  $info->print_action_info($strichart->ID, 'update');     
}

echo '
<form action="edit_strichart.php" method="post">
<table class="eingabe"> 
  <tr>    
  <label>
  <td class="eingabe">ID:</td>  
  <td class="eingabe">'.$strichart->ID.'</td>
  </label>
    </tr> 

  <tr>    
    <label>
    <td class="eingabe">Name:</td>  
    <td class="eingabe"><input type="text" name="Name" value="'.$strichart->Name.'" size="45" maxlength="80" required="required" autofocus="autofocus"></td>
    </label>
  </tr> 


  <tr> 
    <td class="eingabe"></td> 
    <td class="eingabe"><input type="submit" name="senden" value="Speichern">

    </td>
  </tr> 

</table> 
<input type="hidden" name="option" value="edit">        
<input type="hidden" name="ID" value="' . $strichart->ID. '">

</form>
'; 

include('foot.php');

?>
