
<?php 
$PageTitle='Ferieneintrag'; 
include_once('head.php');
include_once("classes/class.ferien.php");
include_once("classes/class.schuljahr.php");
include_once("classes/class.htmlinfo.php");

$ferien = new Ferien();
$info= new HTML_Info(); 

$option=isset($_REQUEST["option"])?$_REQUEST["option"]:'edit';
$show_data=true; 

switch($option) {

  case 'edit': // über "Bearbeiten"-Link
    $ferien->ID=$_GET["ID"];
    $ferien->load_row(); 
    break; 

  case 'insert': 

    $SchuljahrID=isset($_REQUEST["SchuljahrID"])?$_REQUEST["SchuljahrID"]:'';

    if(empty($_REQUEST["SchuljahrID"])) {
      $info->print_user_error('Es wurde kein Schuljahr ausgewählt!');
      $show_data=false; 
      goto pagefoot;  
    }    
    $ferien->insert_row($SchuljahrID);
    $show_data=true; 
    break; 
  
  case 'update': 
    // XXXX Prüfung, ob Datumgrenzen innerhalb Schuljahr liegen 
    $ferien->ID = $_POST["ID"];    
    $ferien->update_row(
                $_POST["Name"]
                , $_POST["Datum_Start"]
                , $_POST["Datum_Ende"] 
                , $_POST["Bundesland"] 
                , $_POST["SchuljahrID"]
                ); 
    $show_data=true;           
    break; 

  case 'delete_1': 
    $ferien->ID = $_REQUEST["ID"];  
    $ferien->load_row(); 
    if($ferien->is_deletable()) {
      $info->print_form_delete_confirm(basename(__FILE__), $ferien->Title, $ferien->ID, $ferien->Name);   
    }          
    break; 

  case 'delete_2': 
    $ferien->ID=$_REQUEST["ID"]; 
    $ferien->delete(); 
    $show_data=false; 

    break; 
    
  default: 
    $show_data=false; 
       
}

$info->print_screen_header($ferien->Title.' bearbeiten'); 
$info->print_link_table($ferien->table_name, 'sortcol=Name', $ferien->Titles); 

if (!$show_data) {goto pagefoot;}
    
echo '
  <form action="edit_ferien.php" method="post">
  <table class="form-edit"> 
    <tr>    
    <label>
    <td class="form-edit form-edit-col1">ID:</td>  
    <td class="form-edit form-edit-col2">'.$ferien->ID.'</td>
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
            $schuljahr->print_select($ferien->SchuljahrID); 

    echo ' </label>  
          '; 
          // $info->print_link_edit($typ->table_name, $uebung->UebungtypID,$typ->Title, true); XXXX 
          $info->print_link_table2('schuljahre', true);    
    echo '</td>
        </tr>'; 


    echo '
    <tr>    
      <label>
      <td class="form-edit form-edit-col1">Name:</td>  
      <td class="form-edit form-edit-col2"><input type="text" name="Name" value="'.$ferien->Name.'" size="45" maxlength="80" required="required" autofocus="autofocus" oninput="changeBackgroundColor(this)"></td>
      </label>
    </tr> 
    
    <tr>    
      <label>
      <td class="form-edit form-edit-col1">Zeitraum von:</td>  
      <td class="form-edit form-edit-col2">
            <input type="date" name="Datum_Start" value="'.$ferien->Datum_Start.'" oninput="changeBackgroundColor(this)" requested>
        </td>
      </label>
    </tr> 
    <tr>    
      <label>
      <td class="form-edit form-edit-col1">Zeitraum bis:</td>  
      <td class="form-edit form-edit-col2">
            <input type="date" name="Datum_Ende" value="'.$ferien->Datum_Ende.'" oninput="changeBackgroundColor(this)" requested>
        </td>
      </label>
    </tr> 

    <tr>    
      <label>
      <td class="form-edit form-edit-col1">Bundesland:</td>  
      <td class="form-edit form-edit-col2"><input type="text" name="Bundesland" value="'.$ferien->Bundesland.'" size="45" maxlength="80" readonly></td>
      </label>
    </tr> 
    
    <tr> 
      <td class="form-edit form-edit-col1"></td> 
      <td class="form-edit form-edit-col2"><input class="btnSave" type="submit" name="senden" value="Speichern">

      </td>
    </tr> 


  <input type="hidden" name="option" value="update"> 
  <input type="hidden" name="ID" value="' . $ferien->ID. '">

  </form>

  
  <tr> 
    <td class="form-edit form-edit-col1"></td> 
    <td class="form-edit form-edit-col2"><br>
   '; 
    $info->print_form_inline('delete_1',$ferien->ID,$ferien->Title, 'löschen'); 

  echo '     
    </td>
  </tr> 


  </table> 
  
  
  '; 

pagefoot: 
include_once('foot.php');

?>
