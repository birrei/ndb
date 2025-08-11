
<?php 
$PageTitle='Besonderheit Typ'; 
include_once('head.php');
include_once("classes/class.lookuptype.php");
include_once("classes/class.htmlinfo.php");

$lookuptype = new Lookuptype();
$info= new HTML_Info(); 

$option=isset($_REQUEST["option"])?$_REQUEST["option"]:'edit';
$show_data=true; 

switch($option) {
  case 'edit': // über "Bearbeiten"-Link
    $lookuptype->ID=$_GET["ID"];
    $lookuptype->load_row(); 
    break; 

  case 'insert': 
    $lookuptype->insert_row('');
    $show_data=true; 
    break; 
  
  case 'update': 
    $lookuptype->ID = $_POST["ID"];    
    $lookuptype->update_row($_POST["Name"],$_POST["Relation"],$_POST["type_key"],$_POST["selsize"]); 
    if ($lookuptype->textWarning!='') {
      $info->print_user_error($lookuptype->textWarning); 
    }
    break; 

  case 'delete_1': 
    $lookuptype->ID = $_REQUEST["ID"];  
    $lookuptype->load_row(); 
    $info->print_form_confirm(basename(__FILE__),$lookuptype->ID,'delete_2','Löschung');  
    $show_data=true;      
    break; 

  case 'delete_2': 
    $lookuptype->ID=$_REQUEST["ID"]; 
    if($lookuptype->delete()) {
      $show_data=false; 
    } else  {
      $show_data=true; 
    }
    break; 
  default: 
    $show_data=false;      
}

$info->print_screen_header($lookuptype->Title.' bearbeiten'); 
$info->print_link_table('v_besonderheittypen', 'sortcol=Name', $lookuptype->Titles); 

if (!$show_data) {goto pagefoot;}

echo '
<form action="edit_lookup_type.php" method="post">
<table class="form-edit"> 
  <tr>    
  <label>
  <td class="form-edit form-edit-col1">ID:</td>  
  <td class="form-edit form-edit-col2">'.$lookuptype->ID.'</td>
  </label>
    </tr> 

  <tr>    
    <label>
    <td class="form-edit form-edit-col1">Name:</td>  
    <td class="form-edit form-edit-col2"><input type="text" name="Name" value="'.$lookuptype->Name.'" size="80" autofocus="autofocus"  oninput="changeBackgroundColor(this)" required>
    

    
    </td>
    </label>
  </tr> 
  
  <tr>    
    <label>
    <td class="form-edit form-edit-col1">Tabelle: </td>  
    <td class="form-edit form-edit-col2">

    <select name="Relation"  required="required" oninput="changeBackgroundColor(this)">
        <option value="satz"'.($lookuptype->Relation=='satz'?' selected':'').'>Satz</option>              
        <option value="sammlung"'.($lookuptype->Relation=='sammlung'?' selected':'').'>Sammlung</option>
        <!-- ohne Musikstück --> 
    </select>

    </td>
    </label>
  </tr> 

  <tr> 
    <td class="form-edit form-edit-col1">Besonderheiten:
      <p> <a href="edit_lookup_type_lookups.php?LookupTypeID='.$lookuptype->ID.'" target="Lookups" class="form-link">Aktualisieren</a></p>
    </td> 
    <td class="form-edit form-edit-col2">
    
      <iframe src="edit_lookup_type_lookups.php?LookupTypeID='.$lookuptype->ID.'&source=iframe" height="400" name="Lookups" class="form-iframe-var2"></iframe>

    </td>
  </tr> 

  <tr>    
    <td class="form-edit form-edit-col1">Suchfeld Größe:</td>  
    <td class="form-edit form-edit-col2"><input type="text" name="selsize" value="'.$lookuptype->selsize.'" size="10" maxlength="80" required="required" oninput="changeBackgroundColor(this)"> 
            <span class="form-infotext"> Anzahl Zeilen im Mehrfach-Auswahlfeld des Such-Formulars. </span>
    </td>

    </tr> 


  
  <tr>    
    <td class="form-edit form-edit-col1">Schlüssel:</td>  
    <td class="form-edit form-edit-col2"><input type="text" name="type_key" value="'.$lookuptype->type_key.'" size="50" maxlength="50" required="required" oninput="changeBackgroundColor(this)"> 
    <span class="form-infotext"> Max. 50 Zeichen. Eine Vorgabe wird automatisch erzeugt, Vergabe eines sprechenden Kurz-Namens ist sinnvoll. </span>
    </td>
  </tr> 


  <tr> 
    <td class="form-edit form-edit-col1"></td> 
    <td class="form-edit form-edit-col2"><input class="btnSave" type="submit" name="senden" value="Speichern">
    </td>
  </tr> 


  <input type="hidden" name="option" value="update">     
  <input type="hidden" name="title" value="Besonderheit Typ">    
  <input type="hidden" name="ID" value="' . $lookuptype->ID. '">

</form>

<tr> 
  <td class="form-edit form-edit-col1"></td> 
  <td class="form-edit form-edit-col2"><br>
  '; 
  $info->print_form_inline('delete_1',$lookuptype->ID,$lookuptype->Title, 'löschen'); 
  echo '     
  </td>
</tr> 

</table> 
'; 

pagefoot: 
include_once('foot.php');

?>
