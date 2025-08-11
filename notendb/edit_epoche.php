
<?php 
$PageTitle='Epoche'; 
include_once('head.php');
include_once("classes/class.epoche.php");
include_once("classes/class.htmlinfo.php");

$epoche = new Epoche();
$info= new HTML_Info(); 

$option=isset($_REQUEST["option"])?$_REQUEST["option"]:'edit';
$show_data=true; 

switch($option) {
  case 'edit': // über "Bearbeiten"-Link
    $epoche->ID=$_GET["ID"];
    $epoche->load_row(); 
    break; 

  case 'insert': 
    $epoche->insert_row('');
    $show_data=true; 
    break; 
  
  case 'update': 
    $epoche->ID = $_POST["ID"];    
    $epoche->update_row($_POST["Name"]); 
    $show_data=true;           
    break; 

  case 'delete_1': 
    $epoche->ID = $_REQUEST["ID"];  
    $epoche->load_row(); 
    $info->print_form_confirm(basename(__FILE__),$epoche->ID,'delete_2','Löschung');  
    $show_data=true;      
    break; 

  case 'delete_2': 
    $epoche->ID=$_REQUEST["ID"]; 
    if($epoche->delete()) {
      $show_data=false; 
    } else  {
      $show_data=true; 
    }
    break; 
    
  default: 
    $show_data=false; 
       
}

$info->print_screen_header($epoche->Title.' bearbeiten'); 
$info->print_link_table($epoche->table_name, 'sortcol=Name', $epoche->Titles); 

if (!$show_data) {goto pagefoot;}
    
  echo '
  <form action="edit_epoche.php" method="post">
  <table class="form-edit"> 
    <tr>    
    <label>
    <td class="form-edit form-edit-col1">ID:</td>  
    <td class="form-edit form-edit-col2">'.$epoche->ID.'</td>
    </label>
      </tr> 

    <tr>    
      <label>
      <td class="form-edit form-edit-col1">Name:</td>  
      <td class="form-edit form-edit-col2"><input type="text" name="Name" value="'.$epoche->Name.'" size="45" maxlength="80" required="required" autofocus="autofocus" oninput="changeBackgroundColor(this)"></td>
      </label>
    </tr> 


    <tr> 
      <td class="form-edit form-edit-col1"></td> 
      <td class="form-edit form-edit-col2"><input class="btnSave" type="submit" name="senden" value="Speichern">

      </td>
    </tr> 


  <input type="hidden" name="option" value="update"> 
  <input type="hidden" name="title" value="Epoche">          
  <input type="hidden" name="ID" value="' . $epoche->ID. '">

  </form>

  
  <tr> 
    <td class="form-edit form-edit-col1"></td> 
    <td class="form-edit form-edit-col2"><br>
   '; 
    $info->print_form_inline('delete_1',$epoche->ID,$epoche->Title, 'löschen'); 

  echo '     
    </td>
  </tr> 


  </table> 
  
  
  '; 

pagefoot: 
include_once('foot.php');

?>
