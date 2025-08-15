
<?php 
$PageTitle='Komponist'; 
include_once('head.php');
include_once("classes/class.komponist.php");
include_once("classes/class.htmlinfo.php");

$komponist = new Komponist();
$info= new HTML_Info(); 

$option=isset($_REQUEST["option"])?$_REQUEST["option"]:'edit';
$show_data=true; 

switch($option) {
  case 'edit': // über "Bearbeiten"-Link
    $komponist->ID=$_GET["ID"];
    $komponist->load_row(); 
    break; 

  case 'insert': 
    $komponist->insert_row('', ''); 
    $show_data=true; 
    break; 
  
  case 'update': 
      $komponist->ID = $_POST["ID"];    
      $komponist->update_row(
        $_POST["Vorname"]
        , $_POST["Nachname"]
        , $_POST["Geburtsjahr"]
        , $_POST["Sterbejahr"]
        , $_POST["Bemerkung"]   
      ); 
          
    break; 

  case 'delete_1': 
    $komponist->ID = $_REQUEST["ID"];  
    $komponist->load_row(); 
    if($komponist->is_deletable()) {
      $info->print_form_confirm(basename(__FILE__),$komponist->ID,'delete_2','Löschung');  
    }       
    $show_data=true;      
    break; 

  case 'delete_2': 
    $komponist->ID=$_REQUEST["ID"]; 
    $komponist->delete(); 
    $show_data=false; 
    break; 
    
  default: 
    $show_data=false;    
}

$info->print_screen_header($komponist->Title.' bearbeiten'); 
$info->print_link_table($komponist->table_name, 'sortcol=Nachname,Vorname', $komponist->Titles); 

if (!$show_data) {goto pagefoot;}

echo '<form action="edit_komponist.php" method="post">

<table class="form-edit"> 
<tr>    
<label>
<td class="form-edit form-edit-col1">ID:</td>  
<td class="form-edit form-edit-col2">'.$komponist->ID.'</td>
</label>
  </tr> 

  <tr>    
    <label>
    <td class="form-edit form-edit-col1">Vorname:</td>  
    <td class="form-edit form-edit-col2"><input type="text" name="Vorname" value="'.$komponist->Vorname.'" size="45" maxlength="80" autofocus="autofocus" oninput="changeBackgroundColor(this)"></td>
    </label>
  </tr> 

  <tr>    
    <label>
    <td class="form-edit form-edit-col1">Nachname:</td>  
    <td class="form-edit form-edit-col2"><input type="text" name="Nachname" value="'.$komponist->Nachname.'" size="45" maxlength="80" required="required" oninput="changeBackgroundColor(this)"></td>
    </label>
  </tr> 

  <tr>    
  <label>
  <td class="form-edit form-edit-col1">Geburtsjahr:</td>  
  <td class="form-edit form-edit-col2"><input type="text" name="Geburtsjahr" value="'.$komponist->Geburtsjahr.'" size="10" maxlength="80" oninput="changeBackgroundColor(this)"></td>
  </label>
</tr> 
<tr>    
  <label>
  <td class="form-edit form-edit-col1">Sterbejahr:</td>  
  <td class="form-edit form-edit-col2"><input type="text" name="Sterbejahr" value="'.$komponist->Sterbejahr.'" size="10" maxlength="80" oninput="changeBackgroundColor(this)"></td>
  </label>
</tr> 

  <tr>    
    <label>
    <td class="form-edit form-edit-col1">Bemerkung:</td>  
    <td class="form-edit form-edit-col2"><input type="text" name="Bemerkung" value="'.$komponist->Bemerkung.'" size="80" maxlength="80" oninput="changeBackgroundColor(this)"></td>
    </label>
  </tr> 

  <tr> 
    <td class="form-edit form-edit-col2"></td> 
    <input type="hidden" name="option" value="update">      
    <input type="hidden" name="title" value="Komponist"> 
    <td class="form-edit form-edit-col2"><input class="btnSave" type="submit" name="senden" value="Speichern">  
    </td>
  </tr> 


  <input type="hidden" name="ID" value="' . $komponist->ID. '">

  </form>
  
<tr> 
  <td class="form-edit form-edit-col1"></td> 
  <td class="form-edit form-edit-col2"><br>
  '; 
  $info->print_form_inline('delete_1',$komponist->ID,$komponist->Title, 'löschen'); 
  echo '     
  </td>
</tr> 


</table> 


  '; 





pagefoot: 
include_once('foot.php');

?>
