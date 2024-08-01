
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
      $lookuptype->update_row($_POST["Name"],$_POST["Relation"],$_POST["type_key"] ); 
      $show_data=true;           
      break; 
  }
}

$info->print_screen_header($lookuptype->Title.' bearbeiten', ' | '); 
$info->print_link_table($lookuptype->table_name, 'sortcol=Name', $lookuptype->Titles); 


if ($show_data) {
    
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
      <td class="eingabe"><input type="text" name="Name" value="'.$lookuptype->Name.'" size="80"autofocus="autofocus"></td>
      </label>
    </tr> 

    <tr>    
      <label>
      <td class="eingabe">Relation:</td>  
      <td class="eingabe">
      
      <select name="Relation"  required="required" oninput="changeBackgroundColor(this)">
          <option value=""></option>      
          <option value="sammlung"'.($lookuptype->Relation=='sammlung'?' selected':'').'>Sammlung</option>
          <option value="musikstueck"'.($lookuptype->Relation=='musikstueck'?' selected':'').'>Musikstück</option>
          <option value="satz"'.($lookuptype->Relation=='satz'?' selected':'').'>Satz</option>
      </select>

      </td>
      </label>
    </tr> 

    <tr>    
      <label>
      <td class="eingabe">Type Key:</td>  
      <td class="eingabe"><input type="text" name="type_key" value="'.$lookuptype->type_key.'" size="45" maxlength="80" required="required" oninput="changeBackgroundColor(this)"> (technischer eindeutiger Schlüssel, Begriff frei wählbar XXX)
      </td>
      </label>
    </tr> 

    <tr> 
      <td class="eingabe"></td> 
      <td class="eingabe"><input type="submit" name="senden" value="Speichern">
      </td>
    </tr> 


    <input type="hidden" name="option" value="update">     
    <input type="hidden" name="title" value="Besonderheit Typ">    
    <input type="hidden" name="ID" value="' . $lookuptype->ID. '">


    <tr> 
      <td class="eingabe">Besonderheiten:
      
        <p> <a href="edit_lookup_type_add_lookup.php?LookupTypeID='.$lookuptype->ID.'" target="Lookups">Besonderheit hinzufügen</a></p>
        <p> <a href="edit_lookup_type_list_lookups.php?LookupTypeID='.$lookuptype->ID.'" target="Lookups">Aktualisieren</a></p>
        

      </td> 
      <td class="eingabe">
      
      <iframe src="edit_lookup_type_list_lookups.php?LookupTypeID='.$lookuptype->ID.'" width="70%" height="400" name="Lookups"></iframe>

      </td>
    </tr> 

  </table> 
  </form>
  '; 

  $info->print_link_delete_row($lookuptype->table_name, $lookuptype->ID,$lookuptype->Title); 
} 
else {
    $info->print_user_error(); 
}

include('foot.php');

?>
