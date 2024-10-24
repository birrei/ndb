
<?php

include('head_raw.php');
include("cl_lookuptype.php");
include("cl_lookup.php");
include("cl_html_info.php");

// echo '<h2>Besonderheit bearbeiten</h2>'; // Unterformular im iframe  

$lookup = new Lookup();
$info= new HtmlInfo(); 

$show_data=false; 

if (isset($_REQUEST["option"])) {
  switch($_REQUEST["option"]) {
    case 'edit': // über "Bearbeiten"-Link
      $lookup->ID=$_GET["ID"];
      if ($lookup->load_row()) {
        $show_data=true;       
      }
      break; 

    case 'insert': 
      $lookup->LookupTypeID= $_GET["LookupTypeID"]; 
      $lookup->insert_row($_GET["Name"]);  
      $show_data=true; 
      break; 
    
    case 'update': 
      $lookup->ID = $_POST["ID"];    
      $lookup->update_row($_POST["Name"], $_POST["LookupTypeID"]); 
      $show_data=true;           
      break; 
  }
}

/** kein Screen-Header, da als Unterformular eingesetzt  */
if ($show_data) {
    
  echo '
  <form action="edit_lookup.php" method="post">
  <table class="form-edit"> 

    <tr>    
    <label>
    <td class="form-edit form-edit-col1">ID:</td>  
    <td class="form-edit form-edit-col2">'.$lookup->ID.'</td>
    </label>
      </tr> 
      <tr>    
        <label>
        <td class="form-edit form-edit-col1">Typ/Kategorie:
        </td>  
        <td class="form-edit form-edit-col2">    
              '; 
              $lookup_type = new Lookuptype();
              $lookup_type->print_select($lookup->LookupTypeID); 
              
              echo ' <a href="edit_lookup_type.php?ID='.$lookup->LookupTypeID.'&title=Typ&option=edit" tabindex="-1" class="form-link">Gehe zu Typ</a>'; 

        echo '
        </label>
      </td>
      </tr>
      
    <tr>    
      <label>
      <td class="form-edit form-edit-col1">Name:</td>  
      <td class="form-edit form-edit-col2"><input type="text" name="Name" value="'.$lookup->Name.'" size="45" maxlength="80" required="required" autofocus="autofocus" oninput="changeBackgroundColor(this)"></td>
      </label>
    </tr> 

    <tr> 
      <td class="form-edit form-edit-col1"></td> 
      <td class="form-edit form-edit-col2"><input class="btnSave" type="submit" name="senden" value="Speichern">

      </td>
    </tr> 

  </table> 
  <input type="hidden" name="option" value="update">  
  <input type="hidden" name="title" value="Besonderheit">       
  <input type="hidden" name="ID" value="' . $lookup->ID. '">

  </form>
  '; 
  $info->print_link_delete_row2($lookup->table_name, $lookup->ID, $lookup->Title, false); 
} 
else {
    $info->print_user_error(); 
}


include('foot_raw.php');

?>