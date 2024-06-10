
<?php 
include('head.php');
include("cl_epoche.php");
include("cl_html_info.php");

echo '<h2>Epoche bearbeiten</h2>'; 

$epoche = new Epoche();
$info= new HtmlInfo(); 

if (!isset($_GET["option"]) and isset($_GET["ID"]))  {
  // geöffnet über einen "Bearbeiten"-Link
  $epoche->ID=$_GET["ID"];
  $epoche->load_row();  
  $info->print_action_info($epoche->ID, 'view');    
}
if (isset($_GET["option"]) and $_GET["option"]=='insert') {
  // nach insert geladen   
  $epoche->insert_row($_GET["Name"]); 
  $info->print_action_info($epoche->ID, 'insert');     
}
if (isset($_POST["option"]) and $_POST["option"]=='edit') {
  // in akt. Datei nach dem editieren gespeichert 
  $epoche->ID = $_POST["ID"];    
  $epoche->update_row($_POST["Name"]); 
  $info->print_action_info($epoche->ID, 'update');     
}



echo '
<form action="edit_epoche.php" method="post">
<table class="eingabe"> 
  <tr>    
  <label>
  <td class="eingabe">ID:</td>  
  <td class="eingabe">'.$epoche->ID.'</td>
  </label>
    </tr> 

  <tr>    
    <label>
    <td class="eingabe">Name:</td>  
    <td class="eingabe"><input type="text" name="Name" value="'.$epoche->Name.'" size="45" maxlength="80" required="required" autofocus="autofocus"></td>
    </label>
  </tr> 


  <tr> 
    <td class="eingabe"></td> 
    <td class="eingabe"><input type="submit" name="senden" value="Speichern">

    </td>
  </tr> 

</table> 
<input type="hidden" name="option" value="edit"> 
<input type="hidden" name="title" value="Epoche">          
<input type="hidden" name="ID" value="' . $epoche->ID. '">

</form>
'; 


include('foot.php');

?>
