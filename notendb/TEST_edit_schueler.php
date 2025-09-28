<!-- Test Radio-Buttons als Link
-> verworfen.  
-->
<?php 
$PageTitle='Schüler'; 
include_once('head.php');
include_once("classes/class.schueler.php");
include_once("classes/class.htmlinfo.php");

echo $_REQUEST["target_form"]; 

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
      $info->print_form_confirm(basename(__FILE__),$schueler->ID,'delete_2','Löschung');        
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
<form action="#" method="post">
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


';
?> 

<!-- XXXTEST 
 
https://gemini.google.com/app/7497d6be15e23608

-->
<style>

/* 1. Radio-Button ausblenden und Zugänglichkeit beibehalten */
input[type="radio"] {
  /* Setzt die Standard-Darstellung zurück */
  -webkit-appearance: none;
  -moz-appearance: none;
  appearance: none;
  /* Optionale Methode, um es nicht-invasiv auszublenden */
  position: absolute;
  opacity: 0;
  width: 0;
  height: 0;
  /* Wichtig für die korrekte Positionierung und Klickbarkeit des Labels */
  z-index: -1;
}

/* 2. Label als Link stylen */
.radio-link-group label {
  display: inline-block; /* Oder block, je nach gewünschtem Layout */
  padding: 5px 10px;
  margin-right: 10px;
  cursor: pointer;
  color: #007bff; /* Typische Link-Farbe */
  text-decoration: underline; /* Typische Link-Unterstreichung */
  /* Fügt einen Link-ähnlichen Hover-Effekt hinzu */
  transition: color 0.2s, text-decoration 0.2s;
}

.radio-link-group label:hover {
  color: #0056b3; /* Dunklere Farbe beim Hover, wie bei Links */
}

/* 3. Stil des Labels, wenn der Radio-Button ausgewählt ist */
input[type="radio"]:checked + label {
  color: #555; /* Andere Farbe für den ausgewählten Zustand */
  text-decoration: none; /* Keine Unterstreichung, um den 'aktiven' Zustand hervorzuheben */
  font-weight: bold;
  cursor: default; /* Zeigt an, dass keine Aktion beim erneuten Klicken erfolgt */
}

/* Optional: Fügt eine Fokus-Kennzeichnung für Zugänglichkeit hinzu */
input[type="radio"]:focus + label {
  outline: 2px solid orange; /* Visuelle Kennzeichnung beim Fokussieren */
  outline-offset: 2px;
}
  </style>



<tr> 
  <td class="form-edit form-edit-col1">Daten anzeigen: <br /> <br />

  <p> <input type="radio" id="opt_Uebung" name="target_form" value="Uebungen" onclick="changeIframeSrc('subform1', 'edit_schueler_uebungen.php?SchuelerID=<?php echo $schueler->ID; ?>');" checked>
  <label for="opt_Uebung">Übungen</label></p> 

  <p><input type="radio" id="opt_Schwierigkeitsgrad" name="target_form" value="Schwierigkeitsgrad" onclick="changeIframeSrc('subform1', 'edit_schueler_schwierigkeitsgrade.php?SchuelerID=<?php echo $schueler->ID; ?>');">
  <label for="opt_Schwierigkeitsgrad">Instrumente / Schwierigkeitsgrade</label></p>

  <p><input type="radio" id="opt_Saetze" name="target_form" value="Saetze" onclick="changeIframeSrc('subform1', 'edit_schueler_saetze.php?SchuelerID=<?php echo $schueler->ID; ?>');">
  <label for="opt_Saetze">Verknüpfte Noten</label></p>

<!-- Auswertung 1: Übungen Typ/Jahr/Monat/ -->
  <p><input type="radio" id="opt_Auswertung1" name="target_form" value="Uebungen Auswertung" onclick="changeIframeSrc('subform1', 'edit_schueler_auswertung1.php?SchuelerID=<?php echo $schueler->ID; ?>');">
  <label for="opt_Auswertung1">Auswertung Übungen</label></p>


  <p> 
  <a href="edit_uebung.php?SchuelerID=<?php echo $schueler->ID; ?>&option=insert" target="_blank" class="form-link form-link-switch">Übung hinzufügen</a>
  </p>

  </td> 
  <td class="form-edit form-edit-col2">
    <iframe src="edit_schueler_uebungen.php?SchuelerID=<?php echo $schueler->ID; ?>&source=iframe" height="300" id="subform1" name="Info" class="form-iframe-var2"></iframe>
  </td>
</tr> 
<?php 
echo '
</form>
  <tr> 
    <td class="form-edit form-edit-col1"></td> 
    <td class="form-edit form-edit-col2"><br>
    '; 
    $info->print_form_inline('delete_1',$schueler->ID,$schueler->Title, 'löschen'); 
    $info->print_form_inline('copy',$schueler->ID,$schueler->Title, 'kopieren');   
    echo '     
    </td>
  </tr> 
</table>  


'
; 

pagefoot: 

include_once('foot.php');

?>
