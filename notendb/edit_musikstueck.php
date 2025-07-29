
<?php 
include('head.php');
include("classes/class.musikstueck.php");
include("classes/class.komponist.php");
include("classes/class.sammlung.php");
include("classes/class.gattung.php");
include("classes/class.epoche.php");
include('cl_html_info.php');

$show_data=false;       

$musikstueck = new Musikstueck();

$info= new HtmlInfo(); 

if (isset($_REQUEST["option"])) {
  switch($_REQUEST["option"]) {
    case 'edit': // über "Bearbeiten"-Link
      $musikstueck->ID=$_GET["ID"];
      if ($musikstueck->load_row()) {
        $show_data=true;       
      }
      break; 

    case 'insert': 
      $musikstueck->SammlungID = $_GET["SammlungID"];
      $musikstueck->insert_row('');
      $show_data=true; 
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
            );
      $show_data=true;           
      break; 

    case 'copy': 
      $ID_ref=$_REQUEST["ID"]; 
      $musikstueck->ID=$ID_ref; 
      $musikstueck->copy();   
      $musikstueck->load_row();       
      $info->print_info_copy($musikstueck->Title, $ID_ref, $musikstueck->ID, 'edit_satz'); 
      $show_data=true; 
      break;     
      
    case 'delete_1': 
      $musikstueck->ID = $_REQUEST["ID"];  
      $musikstueck->load_row(); 

      $info->print_warning('Soll Musikstück ID: '.$musikstueck->ID.', Name: "'.$musikstueck->Name.'" wirklich gelöscht werden?'); 
      echo 
      '<p> <form action="edit_musikstueck.php" method="post">
      <input type="hidden" name="ID" value="' . $musikstueck->ID. '">
      <input type="hidden" name="option" value="delete_2">      
      <input type="hidden" name="title" value="Musikstück"> 
      <input type="submit" name="senden" value="Löschung bestätigen">             
      </form></p>
      '; 

      $show_data=true;      
      break;      
    
    case 'delete_2': 
      $musikstueck->ID = $_POST["ID"];  
      $musikstueck->delete(); 
      $info->print_info('Der Musikstück wurde gelöscht.'); 
      $show_data=false; 
      break;          



  }
}

$info->print_screen_header($musikstueck->Title.' bearbeiten'); 

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

      <input type="radio" id="Besetzungen" name="target_form" value="Besetzungen" onclick="changeIframeSrc('subform1', 'edit_musikstueck_besetzungen.php?MusikstueckID=<?php echo $musikstueck->ID; ?>');">
      <label for="Besetzungen">Besetzungen</label><br>

      <input type="radio" id="Verwendungszwecke" name="target_form" value="Verwendungszwecke" onclick="changeIframeSrc('subform1', 'edit_musikstueck_verwendungszwecke.php?MusikstueckID=<?php echo $musikstueck->ID; ?>');">
      <label for="Verwendungszwecke">Verwendungszwecke</label><br>

      <p> 
      <a href="edit_satz.php?MusikstueckID=<?php echo $musikstueck->ID; ?>'&option=insert&title=Satz" target="_blank" class="form-link">Satz hinzufügen</a>
      </p>
    </td>
    <td class="form-edit form-edit-col2">
          <iframe src="edit_musikstueck_saetze.php?MusikstueckID=<?php echo $musikstueck->ID; ?>'" height="400" name="subform1" id="subform1" class="form-iframe-var2"></iframe>
    </td>
  </tr> 




  </table> 
    
  <?php 

  
  echo '<p> <form action="edit_musikstueck.php" method="post">
      <input type="hidden" name="ID" value="' . $musikstueck->ID. '">
      <input type="hidden" name="option" value="copy">      
      <input type="hidden" name="title" value="Musikstueck"> 
      <input type="submit" name="senden" value="Musikstück kopieren">             
  </form></p> '; 

  echo '<p> <form action="edit_musikstueck.php" method="post">
  <input type="hidden" name="ID" value="' . $musikstueck->ID. '">
  <input type="hidden" name="option" value="delete_1">      
  <input type="hidden" name="title" value="Musikstück"> 
  <input type="submit" name="senden" value="Musikstück löschen">             
  </form></p>
  '; 

  

pagefoot:


include('foot.php');

?>
