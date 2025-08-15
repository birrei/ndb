
<?php 
$PageTitle='Abfragetyp'; 
include_once('head.php');
include_once("classes/class.abfragetyp.php");
include_once("classes/class.htmlinfo.php");

$abfragetyp = new Abfragetyp();
$info= new HTML_Info(); 

$show_data=true; 
$option=isset($_REQUEST["option"])?$_REQUEST["option"]:'edit';


switch($option) {
  case 'edit': 
    $abfragetyp->ID=$_GET["ID"];
    $show_data = $abfragetyp->load_row(); 
    break; 

  case 'insert': 
    $abfragetyp->insert_row('');
    break; 
  
  case 'update': 
    $abfragetyp->ID = $_POST["ID"];    
    $abfragetyp->update_row($_POST["Name"]); 
    $show_data=true;           
    break; 

  case 'delete_1': 
    $abfragetyp->ID = $_POST["ID"];  
    $abfragetyp->load_row(); 
    $Name=$abfragetyp->Name; 
    if($abfragetyp->is_deletable()) {
      $info->print_form_confirm(basename(__FILE__),$abfragetyp->ID,'delete_2','Löschung');  
    }    
    break; 

  case 'delete_2': 
    $abfragetyp->ID=$_REQUEST["ID"]; 
    $abfragetyp->delete(); 
    $show_data=false; 
    break; 
    
  default: 
    $show_data=false; 

}


$info->print_screen_header($abfragetyp->Title.' bearbeiten'); 
$info->print_link_table($abfragetyp->table_name, 'sortcol=Name', $abfragetyp->Titles); 

if (!$show_data) {goto pagefoot;}
  
echo '
<form action="edit_abfragetyp.php" method="post">
<table class="form-edit"> 
  <tr>    
  <label>
  <td class="form-edit form-edit-col1">ID:</td>  
  <td class="form-edit form-edit-col2">'.$abfragetyp->ID.'</td>
  </label>
    </tr> 

  <tr>    
    <label>
    <td class="form-edit form-edit-col1">Name:</td>  
    <td class="form-edit form-edit-col2"><input type="text" name="Name" value="'.$abfragetyp->Name.'" size="45" maxlength="80" required="required" autofocus="autofocus" oninput="changeBackgroundColor(this)"></td>
    </label>
  </tr> 


  <tr> 
    <td class="form-edit form-edit-col1"></td> 
    <td class="form-edit form-edit-col2"><input class="btnSave" type="submit" name="senden" value="Speichern">

    </td>
  </tr> 


<input type="hidden" name="option" value="update"> 
<input type="hidden" name="title" value="Abfragetyp">          
<input type="hidden" name="ID" value="' . $abfragetyp->ID. '">

</form>


    <tr> 
      <td class="form-edit form-edit-col1"></td> 
      <td class="form-edit form-edit-col2">
      <br>'; 
      $info->print_form_inline('delete_1',$abfragetyp->ID,$abfragetyp->Title, 'löschen'); 
      echo '
      </td>
    </tr>

</table>       

'; 


pagefoot: 

include_once('foot.php');

?>
