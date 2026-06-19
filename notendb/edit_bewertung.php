
<?php 
$PageTitle='Bewertung'; 
include_once('head.php');
include_once("classes/class.bewertung.php");
include_once("classes/class.htmlinfo.php");

$bewertung = new Bewertung();
$info= new HTML_Info(); 

$option=isset($_REQUEST["option"])?$_REQUEST["option"]:'edit';
$show_data=true; 

// echo 'option: '.$option; 

switch($option) {

  case 'edit': // über "Bearbeiten"-Link
    $bewertung->ID=$_GET["ID"];
    $show_data = $bewertung->load_row();     
    break; 

  case 'insert': 
    $bewertung->insert_row('');
    break; 
  
  case 'update': 
    $bewertung->ID = $_POST["ID"];    
    $bewertung->update_row($_POST["Name"]);           
    break; 

  case 'delete_1': 
    $bewertung->ID = $_REQUEST["ID"];  
    $bewertung->load_row(); 
    if($bewertung->is_deletable()) {
      $info->print_form_delete_confirm(basename(__FILE__), $bewertung->Title, $bewertung->ID, $bewertung->Name);   
    }  
    break; 

  case 'delete_2': 
    $bewertung->ID=$_REQUEST["ID"]; 
    $bewertung->delete(); 
    $show_data=false; 

  break; 

  default: 
    $show_data=false;    
    
}

$info->print_screen_header($bewertung->Title.' bearbeiten'); 
$info->print_link_table2('bewertungen'); 


if (!$show_data) {goto pagefoot;}
    
echo '
<form action="edit_bewertung.php" method="post">
<table class="form-edit"> 
    <tr>    
    <label>
    <td class="form-edit form-edit-col1">ID:</td>  
    <td class="form-edit form-edit-col2">'.$bewertung->ID.'</td>
    </label>
    </tr> 

    <tr>    
    <label>
    <td class="form-edit form-edit-col1">Name:</td>  
    <td class="form-edit form-edit-col2"><input type="text" name="Name" value="'.$bewertung->Name.'" size="45" maxlength="80" required="required" autofocus="autofocus" oninput="changeBackgroundColor(this)"></td>
    </label>
    </tr> 

    <tr> 
      <td class="form-edit form-edit-col1"></td> 
      <td class="form-edit form-edit-col2"><input class="btnSave" type="submit" name="senden" value="Speichern">
      </td>
    </tr> 

    <input type="hidden" name="option" value="update">        
    <input type="hidden" name="ID" value="'. $bewertung->ID. '">

    </form>

    <tr> 
      <td class="form-edit form-edit-col1"></td> 
      <td class="form-edit form-edit-col2"><br>
      '; 
      $info->print_form_inline('delete_1',$bewertung->ID,$bewertung->Title, 'löschen'); 
      echo '     
      </td>
    </tr> 
 </table>   
 '; 


pagefoot: 
include_once('foot.php');

?>
