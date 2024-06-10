
<?php 
include('head.php');
include("cl_uebung.php");
include("cl_html_info.php");

echo '<h2>Uebung bearbeiten</h2>'; 

$uebung = new Uebung();
$info= new HtmlInfo(); 

if (!isset($_GET["option"]) and isset($_GET["ID"]))  {
  // geöffnet über einen "Bearbeiten"-Link
  $uebung->ID=$_GET["ID"];
  $uebung->load_row();  
  $info->print_action_info($uebung->ID, 'view');    
}
if (isset($_GET["option"]) and $_GET["option"]=='insert') {
  // nach insert geladen   
  $uebung->insert_row($_GET["Name"]); 
  $info->print_action_info($uebung->ID, 'insert');     
}
if (isset($_POST["option"]) and $_POST["option"]=='edit') {
  // in akt. Datei nach dem editieren gespeichert 
  $uebung->ID = $_POST["ID"];    
  $uebung->update_row($_POST["Name"]); 
  $info->print_action_info($uebung->ID, 'update');     
}

echo '
<form action="edit_uebung.php" method="post">
<table class="eingabe"> 
  <tr>    
  <label>
  <td class="eingabe">ID:</td>  
  <td class="eingabe">'.$uebung->ID.'</td>
  </label>
    </tr> 

  <tr>    
    <label>
    <td class="eingabe">Name:</td>  
    <td class="eingabe"><input type="text" name="Name" value="'.$uebung->Name.'" size="45" maxlength="80" required="required" autofocus="autofocus"></td>
    </label>
  </tr> 


  <tr> 
    <td class="eingabe"></td> 
    <td class="eingabe"><input type="submit" name="senden" value="Speichern">

    </td>
  </tr> 

</table> 
<input type="hidden" name="option" value="edit">        
<input type="hidden" name="ID" value="' . $uebung->ID. '">

</form>
'; 

include('foot.php');

?>
