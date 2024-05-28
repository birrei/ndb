
<?php 
include('head.php');
include("cl_lookuptype.php");
include("cl_html_info.php");

echo '<h2>Besonderheit Typ bearbeiten</h2>'; 

$lookuptype = new Lookuptype();
$info= new HtmlInfo(); 

if (!isset($_GET["option"]) and isset($_GET["ID"]))  {
  // geöffnet über einen "Bearbeiten"-Link
  $lookuptype->ID=$_GET["ID"];
  $lookuptype->load_row();  
  $info->print_action_info($lookuptype->ID, 'view');    
}
if (isset($_GET["option"]) and $_GET["option"]=='insert') {
  // nach insert geladen   
  $lookuptype->insert_row($_GET["Name"]); 
  $lookuptype->load_row();  
  $info->print_action_info($lookuptype->ID, 'insert');     
}
if (isset($_POST["option"]) and $_POST["option"]=='edit') {
  // in akt. Datei nach dem editieren gespeichert 
  $lookuptype->ID = $_POST["ID"];    
  $lookuptype->update_row($_POST["Name"],$_POST["Relation"],$_POST["type_key"] ); 
  $info->print_action_info($lookuptype->ID, 'update');     
}

echo '
<form action="edit_lookup_type.php" method="post">
<table class="eingabe"> 
  <tr>    
  <label>
  <td class="eingabe">ID:</td>  
  <td class="eingabe">'.$lookuptype->ID.'</td>
  </label>
    </tr> 

  <tr>    
    <label>
    <td class="eingabe">Name:</td>  
    <td class="eingabe"><input type="text" name="Name" value="'.$lookuptype->Name.'" size="80" required="required" autofocus="autofocus"></td>
    </label>
  </tr> 

  <tr>    
    <label>
    <td class="eingabe">Relation:</td>  
    <td class="eingabe"><input type="text" name="Relation" value="'.$lookuptype->Relation.'" size="45" maxlength="80" required="required"></td>
    </label>
  </tr> 

  <tr>    
    <label>
    <td class="eingabe">Type Key:</td>  
    <td class="eingabe"><input type="text" name="type_key" value="'.$lookuptype->type_key.'" size="45" maxlength="80" required="required"></td>
    </label>
  </tr> 

  <tr> 
    <td class="eingabe"></td> 
    <td class="eingabe"><input type="submit" name="senden" value="Speichern">

    </td>
  </tr> 

</table> 
<input type="hidden" name="option" value="edit">        
<input type="hidden" name="ID" value="' . $lookuptype->ID. '">

</form>
'; 

include('foot.php');

?>
