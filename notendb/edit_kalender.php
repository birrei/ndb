
<?php 
$PageTitle='Kalender Datum'; 
include_once('head.php');
include_once("classes/class.kalender.php");
include_once("classes/class.htmlinfo.php");

$kalender = new Kalender();
$info= new HTML_Info(); 

$option=isset($_REQUEST["option"])?$_REQUEST["option"]:'edit';
$show_data=true; 


switch($option) {
  case 'edit':
    if(isset($_REQUEST["ID"])) {
      $kalender->ID=$_GET["ID"];
    } elseif(isset($_REQUEST["Datum"])) {
      $kalender->ID = $kalender->getID($_REQUEST["Datum"]); 
    }
    $show_data = $kalender->load_row();  
    break; 

  case 'update': 
    $Unterricht_Geplant=(isset($_POST["Unterricht_Geplant"])?1:0); 
    $kalender->ID = $_POST["ID"];    
    $kalender->update_row($Unterricht_Geplant);           
    break; 


  default: 
    $show_data=false;       
  
}

$info->print_screen_header($kalender->Title.' bearbeiten'); 

if (!$show_data) {goto pagefoot;}

echo '
<form action="edit_kalender.php" method="post">
<table class="form-edit"> 

  <tr>    
    <label>
    <td class="form-edit form-edit-col1">Datum:</td>  
    <td class="form-edit form-edit-col2"><input type="text" name="Name" value="'.$kalender->Name.'" size="45" maxlength="80" readonly></td>
    </label>
  </tr> 
    
  <tr>    
    <label>
    <td class="form-edit form-edit-col1">Unterricht geplant:</td>  
    <td class="form-edit form-edit-col2"><input type="checkbox" name="Unterricht_Geplant" '.($kalender->Unterricht_Geplant==1?'checked':'').'></td>
    </label>
  </tr> 


  <tr> 
    <td class="form-edit form-edit-col1"></td> 
    <td class="form-edit form-edit-col2"><input class="btnSave" type="submit" name="senden" value="Speichern">

    </td>
  </tr> 

  <input type="hidden" name="option" value="update">        
  <input type="hidden" name="ID" value="' . $kalender->ID. '">

  </form>


  </table> 
  
  
  '; 

pagefoot: 
include_once('foot.php');

?>
