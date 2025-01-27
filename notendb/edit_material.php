
<?php 

$source=(isset($_REQUEST["source"])?$_REQUEST["source"]:'table'); 

if ($source=='iframe')  {
  include('head_raw.php');
} else {
  include('head.php');
}

include("cl_material.php");
include("cl_materialtyp.php");
include("cl_html_info.php");

$MaterialtypID=(isset($_REQUEST["MaterialtypID"])?$_REQUEST["MaterialtypID"]:''); 

$material = new Material();
$info= new HtmlInfo(); 

$show_data=false; 

if (isset($_REQUEST["option"])) {
  switch($_REQUEST["option"]) {
    case 'edit': // über "Bearbeiten"-Link
      $material->ID=$_GET["ID"];
      if ($material->load_row()) {
        $show_data=true;       
      }
      break; 

    case 'insert': 
      $material->insert_row($MaterialtypID);
      $show_data=true; 
      break; 
    
    case 'update': 
      $material->ID = $_POST["ID"];    
      $material->update_row(
          $_POST["MaterialtypID"]   
          , $_POST["Name"]        
          , $_POST["Bemerkung"]  )
          ;
      $show_data=true;           
      break; 
  }
}

if ($source=='table') {
  $info->print_screen_header($material->Title.' bearbeiten'); 
}


if ($show_data) {
  
  if ($source=='table') {
    $info->print_link_table('v_material', 'sortcol=Name', $material->Titles,false);
  }


  echo '</p>
  <form action="edit_material.php" method="post">
  <table class="form-edit" width="100%"> 
    <tr>    
    <label>
    <td class="form-edit form-edit-col1">ID:</td>  
    <td class="form-edit form-edit-col2">'.$material->ID.'</td>
    </label>
      </tr> 


    <tr>    
    <label>
    <td class="form-edit form-edit-col1">Materialtyp:</td>  
    <td class="form-edit form-edit-col2">     
          '; 
          $materialtypen = new Materialtyp();
          $materialtypen->print_select($material->MaterialtypID); 

    echo ' </label>  &nbsp;
       '; 

       if ($source=='table') {
          $info->print_link_edit($materialtypen->table_name, $material->MaterialtypID,$materialtypen->Title, true); 
          $info->print_link_table($materialtypen->table_name,'sortcol=Name',$materialtypen->Titles,true,'');    
          $info->print_link_insert($materialtypen->table_name,$materialtypen->Title,true); 
        }

  echo '</td>
    </tr> 

    <tr>    
      <label>
      <td class="form-edit form-edit-col1">Name:</td>  
      <td class="form-edit form-edit-col2"><input type="text" name="Name" value="'.htmlentities($material->Name).'" size="100%" required="required" autofocus="autofocus" oninput="changeBackgroundColor(this)"></td>
      </label>
    </tr>     
    <tr>    
      <label>
      <td class="form-edit form-edit-col1">Bemerkung:</td>  
      <td class="form-edit form-edit-col2">
 <input type="text" name="Bemerkung" value="'.htmlentities($material->Bemerkung).'" size="100%" oninput="changeBackgroundColor(this)"></td>
   
     
      </td>
      </label>
    </tr> 
   
    <tr> 
      <td class="form-edit form-edit-col1"></td> 
      <td class="form-edit form-edit-col2"><input class="btnSave" type="submit" name="senden" value="Speichern">  
      </td>
    </tr> 
    
  </table> 
  <input type="hidden" name="option" value="update"> 
  <input type="hidden" name="title" value="Material">          
  <input type="hidden" name="ID" value="' . $material->ID. '">
  <input type="hidden" name="source" value="'.$source.'">
  </form>
  <br>

  '; 

  $info->source=$source; 
  $info->print_link_delete_row2($material->table_name, $material->ID,'Material'); 


} 
else {
    $info->print_user_error(); 
}



if ($source=='iframe')  {
  include('foot_raw.php');
} else {
  include('foot.php');
}

?>
