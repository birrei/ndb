
<?php 
include_once('head_raw.php');
include_once("classes/class.htmlinfo.php"); 
include_once("classes/class.aufgabe.php");
include_once("classes/class.schueler.php");


$aufgabe = new Aufgabe();
$info= new HTML_Info(); 

$option=isset($_REQUEST["option"])?$_REQUEST["option"]:'edit';
$show_data=true; 

$Erledigt=(isset($_POST["Erledigt"])?1:0); // POST nur verfügbar, wenn Checkbox aktiviert 

switch($option) {
  case 'edit': // über "Bearbeiten"-Link
      $aufgabe->ID=$_GET["ID"];
      $show_data = $aufgabe->load_row(); 
      $Erledigt = $aufgabe->Erledigt;    
      $option='update';  
      break; 

  case 'insert': 
      $date_current = date('Y-m-d'); 
      $aufgabe->insert_row($_GET["SchuelerID"], $date_current); 
      $option='update';        
      break; 
  
  case 'delete_1': 
      $aufgabe->ID = $_REQUEST["ID"];  
      $aufgabe->load_row(); 
      $Erledigt = $aufgabe->Erledigt;       
      if($aufgabe->is_deletable()) {
      $info->print_form_delete_confirm2('edit_schueler_aufgaben.php'
                                      , $aufgabe->Title
                                      , $aufgabe->ID
                                      , $aufgabe->Beschreibung
                                      ,'SchuelerID'
                                      , $aufgabe->SchuelerID     
      );   
      // $info->print_form_delete_confirm(basename(__FILE__), $aufgabe->Title, $aufgabe->ID, $aufgabe->Beschreibung);   
      }     
      break; 

  case 'copy': 
    unset($_GET); // XXXX 
    $aufgabe->ID=$_REQUEST["ID"]; 
    $aufgabe->copy();   
    $aufgabe->load_row();   
    $Erledigt = $aufgabe->Erledigt;   
    break;     

  default: 
      $show_data=false;       
}


?> 

<form action="edit_schueler_aufgaben.php" method="get">

<table class="eingabe2">

  <tr>    
    <label>
    <td class="form-edit form-edit-col1">ID:</td>  
    <td class="form-edit form-edit-col2"><?php echo $aufgabe->ID; ?></td>
    </label>
  </tr> 


  <tr>    
    <label>
    <td class="form-edit form-edit-col1">Beschreibung:</td>
    <td class="form-edit form-edit-col2">
      <textarea name="Beschreibung" rows=3 cols=120 oninput="changeBackgroundColor(this)"><?php echo htmlentities($aufgabe->Beschreibung); ?></textarea> 
    
    </td>
    </label>
  </tr> 


  <tr>    
    <label>
    <td class="form-edit form-edit-col1">Datum:</td>  
    <td class="form-edit form-edit-col2">
      <input type="date" name="Datum" value="<?php echo $aufgabe->Datum;  ?>" oninput="changeBackgroundColor(this)" requested> 
    </td>
    </label>
  </tr> 

  <tr>    
    <label>
    <td class="form-edit form-edit-col1">Erledigt:</td>  
    <td class="form-edit form-edit-col2">
      <input type="checkbox" name="Erledigt" <?php echo ($Erledigt==1?'checked':''); ?>>
    </td>
    </label>
  </tr> 

  <tr> 
    <td class="form-edit form-edit-col1"></td> 
    <td class="form-edit form-edit-col2"><input class="btnSave" type="submit" name="senden" value="Speichern"></td>
  </tr> 

  <input type="hidden" name="option" value="<?php echo $option; ?>">        
  <input type="hidden" name="ID" value="<?php echo $aufgabe->ID; ?>">
  <input type="hidden" name="SchuelerID" value="<?php echo $aufgabe->SchuelerID; ?>"> 
 
 </form>

  <tr> 
    <td class="form-edit form-edit-col1"></td> 
    <td class="form-edit form-edit-col2"><br>
      <?php 
      $info->print_form_inline('delete_1',$aufgabe->ID,$aufgabe->Title, 'löschen');
       $info->print_form_inline('copy',$aufgabe->ID,$aufgabe->Title, 'kopieren');            
      ?>     
    </td>
  </tr> 


</table>



<?php

include_once('foot_raw.php');

?>
