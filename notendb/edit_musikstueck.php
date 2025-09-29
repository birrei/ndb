<?php 
$PageTitle='Musikstück'; 
include_once('head.php');
include_once("classes/class.musikstueck.php");
include_once("classes/class.komponist.php");
include_once("classes/class.sammlung.php");
include_once("classes/class.gattung.php");
include_once("classes/class.epoche.php");
include_once("classes/class.materialtyp.php");
include_once("classes/class.htmlinfo.php");

$musikstueck = new Musikstueck();
$info= new HTML_Info(); 

$option=isset($_REQUEST["option"])?$_REQUEST["option"]:'edit';
$show_data=true; 


switch($option) {
  case 'edit': // über "Bearbeiten"-Link
    $musikstueck->ID=$_GET["ID"];
    $show_data = $musikstueck->load_row();     
    break; 

  case 'insert': 
    $musikstueck->SammlungID = $_GET["SammlungID"];
    $musikstueck->insert_row('');
    break; 
  
  case 'update': 
    $musikstueck->ID = $_POST["ID"];    
    $musikstueck->update_row($_POST["Nummer"]
          , $_POST["Name"]
          , $_POST["SammlungID"]
          , $_POST["KomponistID"]
          , $_POST["Opus"]
          , $_POST["GattungID"]
          , $_POST["Bearbeiter"]
          , $_POST["EpocheID"]
          , $_POST["Bemerkung"]
          , $_POST["MaterialtypID"]
          ); 
    break; 

  case 'copy': 
    $ID_ref=$_REQUEST["ID"]; 
    $musikstueck->ID=$ID_ref; 
    $musikstueck->copy();   
    $musikstueck->load_row();       
    $info->print_info_copy($musikstueck->Title, $ID_ref, $musikstueck->ID, 'edit_satz'); 
    break;     
    
  case 'delete_1': 
    $musikstueck->ID = $_REQUEST["ID"];  
    $musikstueck->load_row(); 
    if($musikstueck->is_deletable()) {
      $info->print_form_confirm(basename(__FILE__),$musikstueck->ID,'delete_2','Löschung', 
                      'Soll Musikstück ID: '.$musikstueck->ID.', Name: "'.$musikstueck->Name.'" wirklich gelöscht werden?');        
    }        
    break;      
  
  case 'delete_2': 
    $musikstueck->ID = $_POST["ID"];  
    $musikstueck->delete(); 
    $show_data=false; 
    break;   
      
  default: 
    $show_data=false;            

}


$info->print_screen_header($musikstueck->Title.' bearbeiten'); 

// Hier wird kein "Daten anzeigen" Button angezeigt. 
// Eine Übersicht von Musikstücken bezieht sich immer auf eine Sammlung. 

if (!$show_data) {goto pagefoot;}
  
echo '<p> 
<form action="edit_musikstueck.php?title=Musikstueck" method="post">

<table class="form-edit"> 
<tr>    
<label>
<td class="form-edit form-edit-col1">ID:</td>  
<td class="form-edit form-edit-col2">'.$musikstueck->ID.'</td>
</label>
</tr> 


<tr>    
<label>
<td class="form-edit form-edit-col1">Sammlung:</td>  
<td class="form-edit form-edit-col2">
'; 

$sammlung = new Sammlung();
$sammlung->print_select($musikstueck->SammlungID); 

echo ' <a href="edit_sammlung.php?ID='.$musikstueck->SammlungID.'&title=Sammlung&option=edit" tabindex="-1" class="form-link">Gehe zu Sammlung</a>'; 

echo '</tr></label>
<tr>    
<label>
<td class="form-edit form-edit-col1">Nummer:</td>  
<td class="form-edit form-edit-col2"><input type="text" name="Nummer" value="'.$musikstueck->Nummer.'" size="30" autofocus="autofocus" oninput="changeBackgroundColor(this)"></td>
</label>
</tr> 

<tr>    
  <label>
  <td class="form-edit form-edit-col1">Name:</td>  
  <td class="form-edit form-edit-col2"><input type="text" name="Name" value="'.htmlentities($musikstueck->Name).'" size="120" oninput="changeBackgroundColor(this)"> (max. 500 Zeichen)</td>
  </label>
</tr> 

<tr>    
<label>  
  <td class="form-edit form-edit-col1">Materialtyp:</td>  
  <td class="form-edit form-edit-col2">  
        '; 
        $materialtypen = new Materialtyp();
        $materialtypen->print_select($musikstueck->MaterialtypID); 

  echo ' </label>  &nbsp;
      '; 
      $info->print_link_edit($materialtypen->table_name, $musikstueck->MaterialtypID,$materialtypen->Title, true); 
      $info->print_link_table($materialtypen->table_name,'sortcol=Name',$materialtypen->Titles,true,'');    
      // $info->print_link_insert($materialtypen->table_name,$materialtypen->Title,true); 


echo '</td>
  </tr> 
<tr>    
<label>
<td class="form-edit form-edit-col1">Komponist:</td>  
<td class="form-edit form-edit-col2">    
'; 
  $komponisten = new Komponist();
  $komponisten->print_select($musikstueck->KomponistID); 

  echo  ' </label> &nbsp; '; 
  
  $info->print_link_edit($komponisten->table_name, $musikstueck->KomponistID, $komponisten->Title, true); 
  $info->print_link_table($komponisten->table_name,'sortcol=Nachname,Vorname',$komponisten->Titles,true,'');    
  $info->print_link_insert($komponisten->table_name,$komponisten->Title,true); 


echo '
</td>
</tr> 


<tr>    
  <label>
  <td class="form-edit form-edit-col1">Bearbeiter:</td>  
  <td class="form-edit form-edit-col2">
  <input type="text" name="Bearbeiter" value="'.$musikstueck->Bearbeiter.'" size="45" maxlength="80" oninput="changeBackgroundColor(this)">
  Opus: <input type="text" name="Opus" value="'.$musikstueck->Opus.'" size="45" maxlength="80" oninput="changeBackgroundColor(this)">
  </td>
  </label>
</tr> 

<tr>    
<label>
  <td class="form-edit form-edit-col1">Epoche:
  
  </td>  
  <td class="form-edit form-edit-col2">    
  '; 
    $epochen = new Epoche();
    $epochen->print_select($musikstueck->EpocheID); 

      echo  ' </label>  &nbsp; ';
      
      $info->print_link_edit($epochen->table_name, $musikstueck->EpocheID, $epochen->Title, true); 
      $info->print_link_table($epochen->table_name,'sortcol=Name',$epochen->Titles,true,'');    
      $info->print_link_insert($epochen->table_name,$epochen->Title,true); 
    
      echo '
  </td>
  </tr> 

  <tr>    
  <label>
  <td class="form-edit form-edit-col1">Gattung:</td>  
  <td class="form-edit form-edit-col2">    
  '; 
    $gattungen = new Gattung();
    $gattungen->print_select($musikstueck->GattungID); 

    echo  '  </label>&nbsp; '; 
    
    $info->print_link_edit($gattungen->table_name, $musikstueck->GattungID, $gattungen->Title, true); 
    $info->print_link_table($gattungen->table_name,'sortcol=Name',$gattungen->Titles,true,'');    
    $info->print_link_insert($gattungen->table_name,$gattungen->Title,true); 
      
    echo '
  </td>
</tr> 


  <tr>    
  <label>
  <td class="form-edit form-edit-col1">Bemerkung:</td>  
  <td class="form-edit form-edit-col2">
  <textarea name="Bemerkung" rows=2 cols=100 maxlength="500" oninput="changeBackgroundColor(this)">'.htmlentities($musikstueck->Bemerkung).'</textarea> (max. 500 Zeichen)
  </td>
  </label>
</tr>

<tr> 
  <td class="form-edit form-edit-col1"></td> 
  <td class="form-edit form-edit-col2"><input class="btnSave" type="submit" name="senden" value="Speichern">
</td>
</tr> 
    <input type="hidden" name="ID" value="' . $musikstueck->ID. '">
    <input type="hidden" name="option" value="update">      
    <input type="hidden" name="title" value="Musikstueck">  
  </form>
  ';
  ?>
  <tr> 
    <td class="form-edit form-edit-col1">Daten anzeigen: <br /> <br />
    
      <input type="radio" id="Saetze" name="target_form" value="Saetze" onclick="changeIframeSrc('subform1', 'edit_musikstueck_saetze.php?MusikstueckID=<?php echo $musikstueck->ID; ?>');" checked>
      <label for="Saetze">Sätze</label><br>

      <input type="radio" id="Saetze_Schueler" name="target_form" value="Saetze_Schueler" onclick="changeIframeSrc('subform1', 'edit_musikstueck_saetze_schueler.php?MusikstueckID=<?php echo $musikstueck->ID; ?>');">
      <label for="Saetze_Schueler">Sätze + Schüler</label><br>

      <input type="radio" id="Besetzungen" name="target_form" value="Besetzungen" onclick="changeIframeSrc('subform1', 'edit_musikstueck_besetzungen.php?MusikstueckID=<?php echo $musikstueck->ID; ?>');">
      <label for="Besetzungen">Besetzungen</label><br>

      <input type="radio" id="Verwendungszwecke" name="target_form" value="Verwendungszwecke" onclick="changeIframeSrc('subform1', 'edit_musikstueck_verwendungszwecke.php?MusikstueckID=<?php echo $musikstueck->ID; ?>');">
      <label for="Verwendungszwecke">Verwendungszwecke</label><br>

      <input type="radio" id="Besonderheiten" name="target_form" value="Besonderheiten" onclick="changeIframeSrc('subform1', 'edit_musikstueck_lookups.php?MusikstueckID=<?php echo $musikstueck->ID; ?>');">
      <label for="Besonderheiten">Besonderheiten</label><br>


      <p> 
      <a href="edit_satz.php?MusikstueckID=<?php echo $musikstueck->ID; ?>'&option=insert&title=Satz" target="_blank" class="form-link">Satz hinzufügen</a>
      </p>
    </td>
    <td class="form-edit form-edit-col2">
          <iframe src="edit_musikstueck_saetze.php?MusikstueckID=<?php echo $musikstueck->ID; ?>'" height="400" name="subform1" id="subform1" class="form-iframe-var2"></iframe>
    </td>
  </tr> 
 
  <?php 

  echo '
  <tr> 
    <td class="form-edit form-edit-col1"></td> 
    <td class="form-edit form-edit-col2"><br>
    '; 
    $info->print_form_inline('delete_1',$musikstueck->ID,$musikstueck->Title, 'löschen'); 
    $info->print_form_inline('copy',$musikstueck->ID,$musikstueck->Title, 'kopieren');    
    
  echo '<p>

    <a href=edit_musikstueck_saetze_uebersicht.php?MusikstueckID='.$musikstueck->ID.' target="_blank">Sätze sortieren</a> 

    <p> 
    </td>
  </tr> 



  </table> 
'; 


  

pagefoot:


include_once('foot.php');

?>
