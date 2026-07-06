
<?php 
$PageTitle='Schuljahr bearbeiten'; 
include_once('head.php');
include_once("classes/class.schuljahr.php");
include_once("classes/class.schuljahr.php");
include_once("classes/class.htmlinfo.php");

$schuljahr = new Schuljahr();
$info= new HTML_Info(); 

$option=isset($_REQUEST["option"])?$_REQUEST["option"]:'edit';
$show_data=true; 

switch($option) {

  case 'edit': // über "Bearbeiten"-Link
    $schuljahr->ID=$_GET["ID"];
    $schuljahr->load_row(); 
    break; 

  case 'insert': 

    $schuljahr->insert_row();
    $show_data=true; 
    break; 
  
  case 'update': 
    $schuljahr->ID = $_POST["ID"];    
    $schuljahr->update_row(
                $_POST["Name"]
                , $_POST["Datum_Start"]
                , $_POST["Datum_Ende"] 
                ); 
    $show_data=true;           
    break; 

  case 'delete_1': 
    $schuljahr->ID = $_REQUEST["ID"];  
    $schuljahr->load_row(); 
    if($schuljahr->is_deletable()) {
      $info->print_form_delete_confirm(basename(__FILE__), $schuljahr->Title, $schuljahr->ID, $schuljahr->Name);   
    }          
    break; 

  case 'delete_2': 
    $schuljahr->ID=$_REQUEST["ID"]; 
    $schuljahr->delete(); 
    $show_data=false; 

    break; 
    
  default: 
    $show_data=false; 
       
}

$info->print_screen_header($schuljahr->Title.' bearbeiten'); 
$info->print_link_table2('schuljahre', true); 

if (!$show_data) {goto pagefoot;}
    
echo '
  <form action="edit_schuljahr.php" method="post">
  <table class="form-edit"> 
    <tr>    
    <label>
    <td class="form-edit form-edit-col1">ID:</td>  
    <td class="form-edit form-edit-col2">'.$schuljahr->ID.'</td>
    </label>
      </tr> 
    '; 



    echo '
    <tr>    
      <label>
      <td class="form-edit form-edit-col1">Name:</td>  
      <td class="form-edit form-edit-col2"><input type="text" name="Name" value="'.$schuljahr->Name.'" size="45" maxlength="80" required="required" autofocus="autofocus" oninput="changeBackgroundColor(this)"></td>
      </label>
    </tr> 
    
    <tr>    
      <label>
      <td class="form-edit form-edit-col1">Zeitraum von:</td>  
      <td class="form-edit form-edit-col2">
            <input type="date" name="Datum_Start" value="'.$schuljahr->Datum_Start.'" oninput="changeBackgroundColor(this)" requested>
        </td>
      </label>
    </tr> 
    <tr>    
      <label>
      <td class="form-edit form-edit-col1">Zeitraum bis:</td>  
      <td class="form-edit form-edit-col2">
            <input type="date" name="Datum_Ende" value="'.$schuljahr->Datum_Ende.'" oninput="changeBackgroundColor(this)" requested>
        </td>
      </label>
    </tr> 

    
    <tr> 
      <td class="form-edit form-edit-col1"></td> 
      <td class="form-edit form-edit-col2"><input class="btnSave" type="submit" name="senden" value="Speichern">

      </td>
    </tr> 


  <input type="hidden" name="option" value="update"> 
  <input type="hidden" name="ID" value="' . $schuljahr->ID. '">

  </form>

  
  <tr> 
    <td class="form-edit form-edit-col1"></td> 
    <td class="form-edit form-edit-col2"><br>
   '; 
    $info->print_form_inline('delete_1',$schuljahr->ID,$schuljahr->Title, 'löschen'); 

  echo '     
    </td>
  </tr> 


  </table> 
  
  
  '; 

pagefoot: 
include_once('foot.php');

?>
