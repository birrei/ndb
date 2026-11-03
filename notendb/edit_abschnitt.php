<?php 
include_once("classes/class.satz.php"); 
include_once("classes/class.abschnitt.php"); 
include_once("classes/class.htmlinfo.php"); 

// wird im Unterformular "Abschnitte" unter "Satz" geöffnet 

$option=$_REQUEST["option"]; 

$html= new HTML_Info(); 

$abschnitt = new Abschnitt(); 

switch($option) {

  case 'edit': // aus "edit_satz_abschnitte.php" > "Bearbeiten"
    
    $abschnitt->ID =  $_REQUEST["ID"]; 
    $abschnitt->load_row();  
    $SatzID=$abschnitt->SatzID; 

    break; 

  case 'update': 
    $abschnitt->ID =  $_REQUEST["ID"]; 
    $abschnitt->update_row(
        $_REQUEST["Name"], 
        $_REQUEST["Bemerkung"], 
        $_REQUEST["SatzID"] 
    ); 
    $abschnitt->load_row(); 
    header('Location: edit_satz_abschnitte.php?SatzID='.$abschnitt->SatzID);
    break; 

  case 'insert': // aus "edit_satz_abschnitte.php" > "Hinzufügen"
    $SatzID= $_REQUEST["SatzID"]; 
    $abschnitt->insert_row($SatzID); 
    $abschnitt->load_row(); 

    break;

  case "delete_1": 
    $abschnitt->ID =  $_REQUEST["ID"]; 
    $abschnitt->load_row(); 
    $option='delete_2'; 

    break; 

  case 'delete_2': 
    $abschnitt->ID =  $_REQUEST["ID"];  
    $abschnitt->load_row(); 
    $abschnitt->delete(); 
    header('Location: edit_satz_abschnitte.php?SatzID='.$abschnitt->SatzID);

    break;

  case 'copy': 
    unset($_GET); // XXXX 
    $abschnitt->ID=$_REQUEST["ID"]; 
    $abschnitt->copy();   
    $abschnitt->load_row();   
    break;     

}

include_once('head_raw.php'); // Postition hierher geändert, darf nicht vor header- Anweisung stehen 

if ($option=='delete_2') {
  if($abschnitt->is_deletable()) {
    $html->print_form_delete_confirm(basename(__FILE__), $abschnitt->Title, $abschnitt->ID, $abschnitt->Name);   
  } 

}
?> 
<form action="#" method="POST">
<table class="eingabe2">
<tr>    
  <td class="eingabe2 eingabe2_1">Name: </td>    
  <td class="eingabe2 eingabe2_2"><input type="text" name="Name" size="100" value="<?php echo $abschnitt->Name;  ?>" oninput="changeBackgroundColor(this)"></td>
  <td class="eingabe2 eingabe2_3"></td>  
</tr> 
<tr>    
  <td class="eingabe2 eingabe2_1">Bemerkung: </td>    
  <td class="eingabe2 eingabe2_2"><input type="text" name="Bemerkung" size="100" value="<?php echo $abschnitt->Bemerkung; ?>" oninput="changeBackgroundColor(this)"></td>
  <td class="eingabe2 eingabe2_3"></td>  
</tr> 

<tr>
  <td class="eingabe2 eingabe2_1"></td>
  <td class="eingabe2 eingabe2_2"><input class="btnSave" type="submit" value="Speichern"></td>  
  <td class="eingabe2 eingabe2_3"></td>    
</tr>

 <input type="hidden" name="ID" value="<?php echo $abschnitt->ID; ?>"> 
 <input type="hidden" name="SatzID" value="<?php echo $SatzID; ?>"> 
 <input type="hidden" name="option" value="update">

</form>

<tr>
  <td class="eingabe2 eingabe2_1"></td>
  <td class="eingabe2 eingabe2_2">

    <?php 
    $html->print_form_inline('delete_1',$abschnitt->ID,$abschnitt->Title, 'löschen'); 
    $html->print_form_inline('copy',$abschnitt->ID,$abschnitt->Title, 'kopieren'); 

    ?>

  </td>  
  <td class="eingabe2 eingabe2_3"></td>    
</tr>


</table>

<?php 

include_once('foot_raw.php');

?>
