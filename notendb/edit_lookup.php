
<?php

$source=(isset($_REQUEST["source"])?$_REQUEST["source"]:'table'); 

if ($source=='iframe')  {
  include('head_raw.php');
} else {
  include('head.php');
}

include("classes/class.lookuptype.php");
include("classes/class.lookup.php");
include("cl_html_info.php");

$LookupTypeID=(isset($_REQUEST["LookupTypeID"])?$_REQUEST["LookupTypeID"]:''); 

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
      $lookup->insert_row($LookupTypeID);  
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

if ($source=='table') {
  $info->print_screen_header($lookup->Title.' bearbeiten'); 
}


if ($show_data) {
  if ($source=='table') {
    $info->print_link_table('v_besonderheiten', 'sortcol=Name', $lookup->Titles,false);
  }

  
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
      <td class="form-edit form-edit-col1">Name:</td>  
      <td class="form-edit form-edit-col2"><input type="text" name="Name" value="'.$lookup->Name.'" size="45" maxlength="80" required="required" autofocus="autofocus" oninput="changeBackgroundColor(this)"></td>
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
              
              // XXX löschen: echo ' <a href="edit_lookup_type.php?ID='.$lookup->LookupTypeID.'&title=Typ&option=edit" tabindex="-1" class="form-link">Gehe zu Typ</a>'; 

        echo '
        </label>  &nbsp;';


        if ($source=='table') {
          $info->print_link_edit($lookup_type->table_name, $lookup->LookupTypeID,$lookup_type->Title, true); 
          // $info->print_link_table($lookup_type->table_name,'sortcol=Name',$lookup_type->Titles,true,'');  
          $info->print_link_table('v_besonderheiten','sortcol=Name',$lookup_type->Titles,true,'');    
          $info->print_link_insert($lookup_type->table_name,$lookup_type->Title,true); 
        }


        echo  '

      </td>
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
  <input type="hidden" name="source" value="'.$source.'">
  </form>
  '; 
  $info->source=$source; 
  $info->print_link_delete_row2($lookup->table_name, $lookup->ID, $lookup->Title, false); 
} 
else {
    $info->print_user_error(); 
}


include('foot_raw.php');

?>