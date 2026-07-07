
<?php 
$PageTitle='Feiertag'; 
include_once('head.php');
include_once("classes/class.feiertag.php");
include_once("classes/class.schuljahr.php");
include_once("classes/class.htmlinfo.php");

$feiertag = new Feiertag();
$info= new HTML_Info(); 

$option=isset($_REQUEST["option"])?$_REQUEST["option"]:'edit';
$show_data=true; 

switch($option) {

  case 'edit': // über "Bearbeiten"-Link
    $feiertag->ID=$_GET["ID"];
    $feiertag->load_row(); 
    break; 

  case 'insert': 

    $SchuljahrID=isset($_REQUEST["SchuljahrID"])?$_REQUEST["SchuljahrID"]:'';

    if(empty($_REQUEST["SchuljahrID"])) {
      $info->print_user_error('Es wurde kein Schuljahr ausgewählt!');
      $show_data=false; 
      goto pagefoot;  
    }    
    $feiertag->insert_row($SchuljahrID);
    $show_data=true; 
    break; 
  
  case 'update': 
    // XXXX Prüfung, ob Datumgrenzen innerhalb Schuljahr liegen 
    $feiertag->ID = $_POST["ID"];    
    $feiertag->update_row(
                $_POST["Name"]
                , $_POST["Datum"] 
                , $_POST["Bundesland"] 
                , $_POST["SchuljahrID"]
                ); 
    $show_data=true;           
    break; 

  case 'delete_1': 
    $feiertag->ID = $_REQUEST["ID"];  
    $feiertag->load_row(); 
    if($feiertag->is_deletable()) {
      $info->print_form_delete_confirm(basename(__FILE__), $feiertag->Title, $feiertag->ID, $feiertag->Name);   
    }          
    break; 

  case 'delete_2': 
    $feiertag->ID=$_REQUEST["ID"]; 
    $feiertag->delete(); 
    $show_data=false; 

    break; 
    
  default: 
    $show_data=false; 
       
}

$info->print_screen_header($feiertag->Title.' bearbeiten'); 

if (!$show_data) {goto pagefoot;}
    
echo '
  <form action="edit_feiertag.php" method="post">
  <table class="form-edit"> 
    <tr>    
    <label>
    <td class="form-edit form-edit-col1">ID:</td>  
    <td class="form-edit form-edit-col2">'.$feiertag->ID.'</td>
    </label>
      </tr> 
    '; 

    echo '
      <tr>    
      <label>  
      <td class="form-edit form-edit-col1">Schuljahr:</td>  
      <td class="form-edit form-edit-col2">  
            ';  
            $schuljahr=new Schuljahr(); 
            $schuljahr->print_select($feiertag->SchuljahrID); 

    echo ' </label>  
          '; 
          // $info->print_link_table2('schuljahre', true);    
    echo '</td>
        </tr>'; 


    echo '
    <tr>    
      <label>
      <td class="form-edit form-edit-col1">Name:</td>  
      <td class="form-edit form-edit-col2"><input type="text" name="Name" value="'.$feiertag->Name.'" size="45" maxlength="80" required="required" autofocus="autofocus" oninput="changeBackgroundColor(this)"></td>
      </label>
    </tr> 
    
    <tr>    
      <label>
      <td class="form-edit form-edit-col1">Datum:</td>  
      <td class="form-edit form-edit-col2">
            <input type="date" name="Datum" value="'.$feiertag->Datum.'" oninput="changeBackgroundColor(this)" requested>
        </td>
      </label>
    </tr> 

    <tr>    
      <label>
      <td class="form-edit form-edit-col1">Bundesland:</td>  
      <td class="form-edit form-edit-col2"><input type="text" name="Bundesland" value="'.$feiertag->Bundesland.'" size="45" maxlength="80" readonly></td>
      </label>
    </tr> 
    
    <tr> 
      <td class="form-edit form-edit-col1"></td> 
      <td class="form-edit form-edit-col2"><input class="btnSave" type="submit" name="senden" value="Speichern">

      </td>
    </tr> 


  <input type="hidden" name="option" value="update"> 
  <input type="hidden" name="ID" value="' . $feiertag->ID. '">

  </form>

  
  <tr> 
    <td class="form-edit form-edit-col1"></td> 
    <td class="form-edit form-edit-col2"><br>
   '; 
    $info->print_form_inline('delete_1',$feiertag->ID,$feiertag->Title, 'löschen'); 

  echo '     
    </td>
  </tr> 


  </table> 
  
  
  '; 

pagefoot: 
include_once('foot.php');

?>
