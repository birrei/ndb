
<?php 
$PageTitle='Übung Typ'; 
include_once('head.php');;
include_once("classes/class.htmlinfo.php");
include_once("classes/class.uebungtyp.php");

$uebungtyp = new UebungTyp();   
$info= new HTML_Info(); 

$option=isset($_REQUEST["option"])?$_REQUEST["option"]:'edit';
$show_data=true; 

switch($option) {

  case 'insert': 
 
    $uebungtyp->insert_row('');
    $option='update'; 
    break; 

  case 'edit': // über "Bearbeiten"-Link       
    $uebungtyp->ID=$_REQUEST["ID"];
    $uebungtyp->load_row();  
    $option='update';     
    break; 
  
  case 'update':        
    $uebungtyp->ID=$_POST["ID"]; 
    $uebungtyp->update_row($_POST["Name"],$_POST["Einheit"]);  
    break; 

  case 'delete_1':        
    $uebungtyp->ID = $_REQUEST["ID"];  
    if($uebungtyp->is_deletable()) {
      $info->print_form_confirm(basename(__FILE__),$uebungtyp->ID,'delete_2','Löschung');    
    } else {
      $info->print_warning($uebungtyp->infotext); 
    }
    break; 

  case 'delete_2':        
    $uebungtyp->ID=$_REQUEST["ID"]; 
    $uebungtyp->delete(); 
    $info->print_info($uebungtyp->infotext); 
    $show_data=false; 
    break; 

  default: 
    $show_data=false;       
}


$info->print_screen_header($uebungtyp->Title.' bearbeiten'); 

$info->print_link_table('uebungtyp', 'sortcol=Name', $uebungtyp->Titles,false);

// $info->print_form_inline('copy',$uebungtyp->ID,$uebungtyp->Title, 'kopieren'); 


if (!$show_data) {goto pagefoot;}


echo '</p>
<form action="edit_uebungtyp.php" method="post">
<table class="form-edit" width="100%"> 
  <tr>    
    <label>
    <td class="form-edit form-edit-col1">ID:</td>  
    <td class="form-edit form-edit-col2">'.$uebungtyp->ID.'</td>
    </label>
  </tr> 

  <tr>    
    <label>
    <td class="form-edit form-edit-col1">Name:</td>  
    <td class="form-edit form-edit-col2"><input type="text" name="Name" value="'.htmlentities($uebungtyp->Name).'" size="40%" required="required" autofocus="autofocus" oninput="changeBackgroundColor(this)"></td>
    </label>
  </tr>    

  <tr>    
    <label>
    <td class="form-edit form-edit-col1">Einheit:</td>  
    <td class="form-edit form-edit-col2"><input type="text" name="Einheit" value="'.htmlentities($uebungtyp->Einheit).'" size="40%" required="required" autofocus="autofocus" oninput="changeBackgroundColor(this)"></td>
    </label>
  </tr>    

  <tr> 
      <td class="form-edit form-edit-col1"></td> 
      <td class="form-edit form-edit-col2"><input class="btnSave" type="submit" name="senden" value="Speichern">  
      </td>
    </tr> 
    

    <input type="hidden" name="option" value="update">       
    <input type="hidden" name="ID" value="' . $uebungtyp->ID. '">

  </form>


  
    <tr> 
      <td class="form-edit form-edit-col1"></td> 
      <td class="form-edit form-edit-col2"><br>
      '; 
      $info->print_form_inline('delete_1',$uebungtyp->ID,$uebungtyp->Title, 'löschen'); 
      echo '     
      </td>
    </tr> 
        
    </table>'; 



pagefoot: 

include_once('foot.php');


?>
