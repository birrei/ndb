
<?php 
include('head.php');
include("cl_erprobt.php");
include("cl_html_info.php");

echo '<h2>Erprobt-Eintrag bearbeiten</h2>'; 

$erprobt=new Erprobt(); 
$info= new HtmlInfo(); 

if (!isset($_GET["option"]) and isset($_GET["ID"]))  {
  // geöffnet über einen "Bearbeiten"-Link
  $erprobt->ID=$_GET["ID"];
  $erprobt->load_row();  
  $info->print_action_info($erprobt->ID, 'view');    
}
if (isset($_GET["option"]) and $_GET["option"]=='insert') {
  // nach insert geladen   
  $erprobt->insert_row($_GET["Name"]); 
  $erprobt->load_row();  
  $info->print_action_info($erprobt->ID, 'insert');     
}
if (isset($_POST["option"]) and $_POST["option"]=='edit') {
  // in akt. Datei nach dem editieren gespeichert 
  $erprobt->ID = $_POST["ID"];    
  $erprobt->update_row($_POST["Name"]); 
  $info->print_action_info($erprobt->ID, 'update');     
}

echo '
<form action="edit_erprobt.php" method="post">
<table class="eingabe"> 
  <tr>    
  <label>
  <td class="eingabe">ID:</td>  
  <td class="eingabe">'.$erprobt->ID.'</td>
  </label>
    </tr> 

  <tr>    
    <label>
    <td class="eingabe">Name:</td>  
    <td class="eingabe"><input type="text" name="Name" value="'.$erprobt->Name.'" size="45" maxlength="80" required="required" autofocus="autofocus"></td>
    </label>
  </tr> 


  <tr> 
    <td class="eingabe"></td> 
    <td class="eingabe"><input type="submit" name="senden" value="Speichern">

    </td>
  </tr> 

</table> 
<input type="hidden" name="option" value="edit">  
<input type="hidden" name="title" value="Erprobt">        
<input type="hidden" name="ID" value="' . $erprobt->ID. '">

</form>
'; 

include('foot.php');

?>
