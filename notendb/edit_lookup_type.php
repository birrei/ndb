
<?php 
include('head.php');
include("cl_lookuptype.php");
include("cl_html_info.php");

$lookuptype = new Lookuptype();
$info= new HtmlInfo(); 

$show_data=false; 

if (isset($_REQUEST["option"])) {
  switch($_REQUEST["option"]) {
    case 'edit': // über "Bearbeiten"-Link
      $lookuptype->ID=$_GET["ID"];
      if ($lookuptype->load_row()) {
        $show_data=true;       
      }
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
      $show_data=true;           
      break; 
  }
}

$info->print_screen_header($lookuptype->Title.' bearbeiten'); 
// $info->print_link_table($lookuptype->table_name, 'sortcol=Name', $lookuptype->Titles); 
$info->print_link_table('v_besonderheittypen', 'sortcol=Name', $lookuptype->Titles); 


if ($show_data) {
    
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
      <td class="form-edit form-edit-col1">Relation: </td>  
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
      <td class="form-edit form-edit-col1">Konfig. Suche:</td>  
      <td class="form-edit form-edit-col2">
        
        Type Key: <input type="text" name="type_key" value="'.$lookuptype->type_key.'" size="12" maxlength="80" required="required" oninput="changeBackgroundColor(this)"> 
        Zeilen: <input type="text" name="selsize" value="'.$lookuptype->selsize.'" size="10" maxlength="80" required="required" oninput="changeBackgroundColor(this)"> 
        
      </td>
    </tr> 


    <tr> 
      <td class="form-edit form-edit-col1"></td> 
      <td class="form-edit form-edit-col2"><input class="btnSave" type="submit" name="senden" value="Speichern">
      </td>
    </tr> 
    </table> 

    <input type="hidden" name="option" value="update">     
    <input type="hidden" name="title" value="Besonderheit Typ">    
    <input type="hidden" name="ID" value="' . $lookuptype->ID. '">

  </form>
  '; 

  $info->print_link_delete_row2($lookuptype->table_name, $lookuptype->ID,$lookuptype->Title); 
} 
else {
    $info->print_user_error(); 
}

include('foot.php');

?>
