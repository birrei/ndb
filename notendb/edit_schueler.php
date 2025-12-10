
<?php 
$PageTitle='Schüler'; 
include_once('head.php');
include_once("classes/class.schueler.php");
include_once("classes/class.htmlinfo.php");

$schueler = new Schueler();
$info= new HTML_Info(); 

$option=isset($_REQUEST["option"])?$_REQUEST["option"]:'edit';
$show_data=true; 

switch($option) {
  case 'edit': // über "Bearbeiten"-Link
    $schueler->ID=$_GET["ID"];
    $show_data = $schueler->load_row();  
    break; 

  case 'insert': 
    $schueler->insert_row('');
    break; 
  
  case 'update': 
    $Aktiv=(isset($_POST["Aktiv"])?1:0);       
    $schueler->ID = $_POST["ID"];    
    $schueler->update_row($_POST["Name"],$_POST["Bemerkung"], $Aktiv);        
    break; 

  case 'delete_1': 
    $schueler->ID = $_REQUEST["ID"];  
    $schueler->load_row(); 
    if($schueler->is_deletable()) {
      $info->print_form_delete_confirm(basename(__FILE__), $schueler->Title, $schueler->ID, $schueler->Name);   
    }      
    break;      
  
  case 'delete_2': 
    $schueler->ID = $_POST["ID"];  
    $schueler->delete(); 
    $show_data=false;     
    break;          

  case 'copy': 
    $ID_ref=$_REQUEST["ID"]; 
    $schueler->ID=$ID_ref; 
    $schueler->copy();   
    $schueler->load_row();       
    $info->print_info_copy($schueler->Title, $ID_ref, $schueler->ID, 'edit_schueler'); 
    break;          

  default: 
    $show_data=false;     

}

$info->print_screen_header($schueler->Title.' bearbeiten'); 
$info->print_link_table('v_schueler', 'sortcol=Name', $schueler->Titles); 

if (!$show_data) {goto pagefoot;}
  
echo '
<form action="edit_schueler.php" method="post">
<table class="form-edit"> 
  <tr>    
  <label>
  <td class="form-edit form-edit-col1">ID:</td>  
  <td class="form-edit form-edit-col2">'.$schueler->ID.'
      &nbsp; <label><input type="checkbox" name="Aktiv" '.($schueler->Aktiv==1?'checked':'').'>Aktiv</label> 
  </td>
  </label>
    </tr> 

  <tr>    
    <label>
    <td class="form-edit form-edit-col1">Name:</td>  
    <td class="form-edit form-edit-col2"><input type="text" name="Name" value="'.$schueler->Name.'" size="80" autofocus="autofocus" oninput="changeBackgroundColor(this)"required></td>
    </label>
  </tr> 

  <tr>    
    <label>
    <td class="form-edit form-edit-col1">Bemerkung:</td>  
    <td class="form-edit form-edit-col2">

    <textarea name="Bemerkung" rows=2 cols=120 oninput="changeBackgroundColor(this)">'.htmlentities($schueler->Bemerkung).'</textarea> 

    </td>    
    </label>
  </tr> 

  <tr> 
    <td class="form-edit form-edit-col1"></td> 
    <td class="form-edit form-edit-col2"><input class="btnSave" type="submit" name="senden" value="Speichern">
    </td>
  </tr> 

  <input type="hidden" name="option" value="update">     
  <input type="hidden" name="title" value="Schüler">    
  <input type="hidden" name="ID" value="' . $schueler->ID. '">

</form>

';
?> 

<tr> 
  <td class="form-edit form-edit-col1"> Daten erfassen / ansehen: <br /> 

  <input type="radio" id="opt_Uebung" name="target_form" value="Uebungen" onclick="changeIframeSrc('subform1', 'edit_schueler_uebungen.php?SchuelerID=<?php echo $schueler->ID; ?>');" checked>
  <label for="opt_Uebung">Übungen</label><br>

  <input type="radio" id="opt_Schwierigkeitsgrad" name="target_form" value="Schwierigkeitsgrad" onclick="changeIframeSrc('subform1', 'edit_schueler_schwierigkeitsgrade.php?SchuelerID=<?php echo $schueler->ID; ?>');">
  <label for="opt_Schwierigkeitsgrad">Instrumente, Schwierigkeitsgrade</label><br>

  <input type="radio" id="opt_Saetze" name="target_form" value="Saetze" onclick="changeIframeSrc('subform1', 'edit_schueler_saetze.php?SchuelerID=<?php echo $schueler->ID; ?>');">
  <label for="opt_Saetze">Verknüpfte Noten</label><br>

<p> 
<a href="edit_uebung.php?SchuelerID=<?php echo $schueler->ID; ?>&option=insert" target="_blank" class="form-link form-link-switch">Übung hinzufügen</a>
</p>

<p>Übersichten:<br /> 
  
<!-- Auswertung 1: Übungen Typ/Jahr/Monat/ -->
  <input type="radio" id="opt_Auswertung1" name="target_form" value="Uebungen" onclick="changeIframeSrc('subform1', 'edit_schueler_auswertung.php?AuswertungNr=1&SchuelerID=<?php echo $schueler->ID; ?>');">
  <label for="opt_Auswertung1">Auswertung Übungen / Typ</label><br>

<!-- Auswertung 2: Übungen Besonderheit/Jahr/Monat/ -->
  <input type="radio" id="opt_Auswertung2" name="target_form" value="Uebungen" onclick="changeIframeSrc('subform1', 'edit_schueler_auswertung.php?AuswertungNr=2&SchuelerID=<?php echo $schueler->ID; ?>');">
  <label for="opt_Auswertung2">Auswertung Übungen / Besonderheit</label><br>

<!-- Auswertung 3: Übungen Satz/Jahr/Monat/ -->
  <input type="radio" id="opt_Auswertung3" name="target_form" value="Uebungen" onclick="changeIframeSrc('subform1', 'edit_schueler_auswertung.php?AuswertungNr=3&SchuelerID=<?php echo $schueler->ID; ?>');">
  <label for="opt_Auswertung3">Auswertung Übungen / Noten</label><br>  

  <input type="radio" id="opt_Saetze_Lookups" name="target_form" value="Saetze_Lookups" onclick="changeIframeSrc('subform1', 'edit_schueler_saetze_lookups.php?SchuelerID=<?php echo $schueler->ID; ?>');">
  <label for="opt_Saetze_Lookups">Verknüpfte Noten + Besonderheiten</label><br>

  <input type="radio" id="opt_Lookups" name="target_form" value="Lookups" onclick="changeIframeSrc('subform1', 'edit_schueler_lookups.php?SchuelerID=<?php echo $schueler->ID; ?>');">
  <label for="opt_Lookups">Besonderheiten aus verknüpften Noten</label><br>

  </p>

  </td> 
  <td class="form-edit form-edit-col2">
    <iframe src="edit_schueler_uebungen.php?SchuelerID=<?php echo $schueler->ID; ?>&source=iframe" height="300" id="subform1" name="Info" class="form-iframe-var2"></iframe>
  </td>
</tr> 
<?php 
echo '
  <tr> 
    <td class="form-edit form-edit-col1"></td> 
    <td class="form-edit form-edit-col2"><br>
    '; 
    $info->print_form_inline('delete_1',$schueler->ID,$schueler->Title, 'löschen'); 
    $info->print_form_inline('copy',$schueler->ID,$schueler->Title, 'kopieren');   
    $info->print_link_overview('edit_schueler_uebersicht_zuordnung.php','ID='.$schueler->ID, 'Notenmaterial Schnellzuordnung'); 
    echo '     
    </td>
  </tr> 
</table>  '
; 

pagefoot: 

include_once('foot.php');

?>
