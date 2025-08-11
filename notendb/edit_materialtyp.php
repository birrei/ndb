
<?php 
$PageTitle='Materialtyp'; 
include_once('head.php');
include_once("classes/class.materialtyp.php");
include_once("classes/class.htmlinfo.php");

$materialtyp = new Materialtyp();
$info= new HTML_Info(); 

$option=isset($_REQUEST["option"])?$_REQUEST["option"]:'edit';
$show_data=true; 

switch($option) {
  case 'edit': // über "Bearbeiten"-Link
    $materialtyp->ID=$_GET["ID"];
    // $materialtyp->load_row(); 
    $show_data = $materialtyp->load_row();     
    break; 

  case 'insert': 
    $materialtyp->insert_row('');
    break; 
  
  case 'update': 
    $materialtyp->ID = $_POST["ID"];    
    $materialtyp->update_row($_POST["Name"]);           
    break; 

  case 'delete_1': 
    $materialtyp->ID = $_REQUEST["ID"];  
    $materialtyp->load_row(); 
    $info->print_form_confirm(basename(__FILE__),$materialtyp->ID,'delete_2','Löschung');    
    break; 

  case 'delete_2': 
    $materialtyp->ID=$_REQUEST["ID"]; 
    if($materialtyp->delete()) {
      $show_data=false; 
    } else  {
      $show_data=true; 
    }
    break; 

    default: 
      $show_data=false; 
}



$info->print_screen_header($materialtyp->Title.' bearbeiten'); 
$info->print_link_table($materialtyp->table_name, 'sortcol=Name', $materialtyp->Titles); 

if (!$show_data) {goto pagefoot;}

echo '
<form action="edit_materialtyp.php" method="post">
<table class="form-edit"> 
  <tr>    
  <label>
  <td class="form-edit form-edit-col1">ID:</td>  
  <td class="form-edit form-edit-col2">'.$materialtyp->ID.'</td>
  </label>
    </tr> 

    <tr>    
    <label>
    <td class="form-edit form-edit-col1">Name:</td>  
    <td class="form-edit form-edit-col2"><input type="text" name="Name" value="'.$materialtyp->Name.'" size="45" maxlength="80" required="required" autofocus="autofocus" oninput="changeBackgroundColor(this)"></td>
    </label>
  </tr> 

  <tr> 
    <td class="form-edit form-edit-col1"></td> 
    <td class="form-edit form-edit-col2"><input class="btnSave" type="submit" name="senden" value="Speichern">

    </td>
  </tr> 



<input type="hidden" name="option" value="update">        
<input type="hidden" name="ID" value="' . $materialtyp->ID. '">

</form>


    
<tr> 
  <td class="form-edit form-edit-col1"></td> 
  <td class="form-edit form-edit-col2"><br>
  '; 
  $info->print_form_inline('delete_1',$materialtyp->ID,$materialtyp->Title, 'löschen'); 
  echo '     
  </td>
</tr> 

</table> 

  '; 
  $info->source= 'table'; 



pagefoot: 
include_once('foot.php');

?>
