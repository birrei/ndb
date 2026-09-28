
<?php 
// Aktuell nicht verwendet, stattdessen edit_schueler_aufgabe.php 
$PageTitle='Aufgabe'; 
include_once('head.php');
include_once("classes/class.aufgabe.php");
include_once("classes/class.schueler.php");
include_once("classes/class.htmlinfo.php");

$aufgabe = new Aufgabe();
$info= new HTML_Info(); 

$option=isset($_REQUEST["option"])?$_REQUEST["option"]:'edit';
$show_data=true; 

$Erledigt=(isset($_POST["Erledigt"])?1:0); // POST nur verfügbar, wenn Checkbox aktiviert 

$Infotext=''; 

// print_r($_POST); 

switch($option) {
  case 'edit': // über "Bearbeiten"-Link
    $aufgabe->ID=$_GET["ID"];
    $show_data = $aufgabe->load_row(); 
    $Erledigt = $aufgabe->Erledigt;     
    break; 

  case 'insert': 
    $SchuelerID=(isset($_REQUEST["SchuelerID"])?$_REQUEST["SchuelerID"]:'');
    if($SchuelerID=='') {
      $Infotext='Es wurde kein Schüler ausgewählt!';       
      $show_data=false; 
      goto pagehead; 
    }

    $aufgabe->insert_row($_REQUEST["SchuelerID"], $_REQUEST["Datum"]); 
    break; 
  
  case 'update': 
    $aufgabe->ID = $_POST["ID"];  
    $aufgabe->update_row(
        $_POST["Datum"]
      , $_POST["Beschreibung"]
      , $Erledigt
      , $_POST["SchuelerID"]
    );  
    $Erledigt = $aufgabe->Erledigt;       

    break; 

  case 'delete_1': 
    $aufgabe->ID = $_REQUEST["ID"];  
    $aufgabe->load_row(); 
    $Erledigt = $aufgabe->Erledigt;       
    if($aufgabe->is_deletable()) {
      $info->print_form_delete_confirm(basename(__FILE__), $aufgabe->Title, $aufgabe->ID, $aufgabe->Beschreibung);   
    }     
    break; 

  case 'delete_2': 
    $aufgabe->ID=$_REQUEST["ID"]; 
    $aufgabe->delete(); 
    $show_data=false;  
    $Infotext='Die Aufgabe wurde gelöscht.';        
   
    break; 

  case 'copy': 
    // unset($_GET); ? XXXX 
    $aufgabe->ID=$_REQUEST["ID"]; 
    $aufgabe->copy();   
    $aufgabe->load_row();   
    $Erledigt = $aufgabe->Erledigt;   
    break;     

  default: 
    $show_data=false;       
  
}


pagehead: 

if (!$show_data) {
    $info->print_warning($Infotext); 
    goto pagefoot;
}

$info->print_screen_header($aufgabe->Title.' bearbeiten'); 
$info->print_link_table2('aufgaben'); 


echo '
<form action="edit_aufgabe.php" method="post">
<table class="form-edit"> 
  <tr>    
  <label>
  <td class="form-edit form-edit-col1">ID:</td>  
  <td class="form-edit form-edit-col2">'.$aufgabe->ID.'</td>
  </label>
    </tr> 

  <tr>    
    <label>
    <td class="form-edit form-edit-col1">Schüler:</td>  
    <td class="form-edit form-edit-col2">'; 
      $schueler = new Schueler(); 
      $SchuelerID = $aufgabe->SchuelerID; 
      $schueler->print_select2($SchuelerID);       
      $info->print_link_edit('schueler',$SchuelerID,true);   
      $info->print_link_table2('schueler', true);    
    
    echo '
    </td>
    </label>
  </tr> 

  <!-- Feld Name entfernt --> 

  <tr>    
    <label>
    <td class="form-edit form-edit-col1">Beschreibung:</td>
    <td class="form-edit form-edit-col2">
      <textarea name="Beschreibung" rows=3 cols=120 oninput="changeBackgroundColor(this)">'.htmlentities($aufgabe->Beschreibung).'</textarea> 
    
    </td>
    </label>
  </tr> 


  <tr>    
    <label>
    <td class="form-edit form-edit-col1">Datum:</td>  
    <td class="form-edit form-edit-col2">
      <input type="date" name="Datum" value="'.$aufgabe->Datum.'" oninput="changeBackgroundColor(this)" requested> 
    </td>
    </label>
  </tr> 

  <tr>    
    <label>
    <td class="form-edit form-edit-col1">Erledigt:</td>  
    <td class="form-edit form-edit-col2">
      <input type="checkbox" name="Erledigt" '.($Erledigt==1?'checked':'').'>
    </td>
    </label>
  </tr> 

  <tr> 
    <td class="form-edit form-edit-col1"></td> 
    <td class="form-edit form-edit-col2"><input class="btnSave" type="submit" name="senden" value="Speichern"></td>
  </tr> 

  <input type="hidden" name="option" value="update">        
  <input type="hidden" name="ID" value="' . $aufgabe->ID. '">

  </form>
  
  <tr> 
    <td class="form-edit form-edit-col1"></td> 
    <td class="form-edit form-edit-col2"><br>
    '; 
    $info->print_form_inline('delete_1',$aufgabe->ID,$aufgabe->Title, 'löschen'); 
    $info->print_form_inline('copy',$aufgabe->ID,$aufgabe->Title, 'kopieren'); 

    echo '     
    </td>
  </tr> 


  </table> 
  
  
  '; 


pagefoot: 
include_once('foot.php');

  // <tr>    
  //   <label>
  //   <td class="form-edit form-edit-col1">Bezeichnung:</td>  
  //   <td class="form-edit form-edit-col2"><input type="text" name="Name" value="'.$aufgabe->Name.'" size="45" maxlength="80" required="required" autofocus="autofocus" oninput="changeBackgroundColor(this)"> 
  //       </td>
  //   </label>
  // </tr> 
?>
