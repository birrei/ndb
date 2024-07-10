
<?php 
include('head.php');
include("cl_schwierigkeitsgrad.php");
include("cl_html_info.php");

echo '<h2>Schwierigkeitsgrad-Eintrag bearbeiten</h2>'; 

$schwierigkeitsgrad=new Schwierigkeitsgrad(); 
$info= new HtmlInfo(); 

if (!isset($_GET["option"]) and isset($_GET["ID"]))  {
  // geöffnet über einen "Bearbeiten"-Link
  $schwierigkeitsgrad->ID=$_GET["ID"];
  $schwierigkeitsgrad->load_row();  
  $info->print_action_info($schwierigkeitsgrad->ID, 'view');    
}
if (isset($_GET["option"]) and $_GET["option"]=='insert') {
  // nach insert geladen   
  $schwierigkeitsgrad->insert_row(''); 
  $info->print_action_info($schwierigkeitsgrad->ID, 'insert');     
}
if (isset($_POST["option"]) and $_POST["option"]=='edit') {
  // in akt. Datei nach dem editieren gespeichert 
  $schwierigkeitsgrad->ID = $_POST["ID"];    
  $schwierigkeitsgrad->update_row($_POST["Name"]); 
  $info->print_action_info($schwierigkeitsgrad->ID, 'update');     
}

$info->print_link_show_table('schwierigkeitsgrad', 'sortcol=Name', 'Schwierigkeitsgrade'); 

echo '
<form action="edit_schwierigkeitsgrad.php" method="post">
<table class="eingabe"> 
  <tr>    
  <label>
  <td class="eingabe">ID:</td>  
  <td class="eingabe">'.$schwierigkeitsgrad->ID.'</td>
  </label>
    </tr> 

  <tr>    
    <label>
    <td class="eingabe">Name:</td>  
    <td class="eingabe"><input type="text" name="Name" value="'.$schwierigkeitsgrad->Name.'" size="45" maxlength="80" required="required" autofocus="autofocus" oninput="changeBackgroundColor(this)"></td>
    </label>
  </tr> 


  <tr> 
    <td class="eingabe"></td> 
    <td class="eingabe"><input type="submit" name="senden" value="Speichern">

    </td>
  </tr> 

</table> 
<input type="hidden" name="option" value="edit">        
<input type="hidden" name="ID" value="' . $schwierigkeitsgrad->ID. '">
<input type="hidden" name="title" value="Schwierigkeitsgrad"> 

</form>
'; 

include('foot.php');

?>
