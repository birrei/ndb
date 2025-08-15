
<?php 
$PageTitle='Satz'; 
include_once('head.php');
include_once('classes/class.satz.php');
include_once('classes/class.musikstueck.php');
include_once('classes/class.erprobt.php');
include_once('classes/class.schwierigkeitsgrad.php'); // XXX entfernen 
include_once("classes/class.htmlinfo.php");

$satz=new Satz(); 
$info= new HTML_Info(); 

$option=isset($_REQUEST["option"])?$_REQUEST["option"]:'edit';
$show_data=true; 

switch($option) {
  case 'edit': // über "Bearbeiten"-Link
    $satz->ID=$_GET["ID"];
    $show_data = $satz->load_row();     
    break;     

  case 'insert': 
    $satz->MusikstueckID=$_GET["MusikstueckID"]; 
    $satz->insert_row('',''); 
    break; 
  
  case 'update': 
    $satz->ID = $_POST["ID"];    
    $satz->update_row(
      $_POST["Name"]
        , $_POST["Nr"]
        , $_POST["MusikstueckID"]
        , $_POST["Tempobezeichnung"]
        , $_POST["Spieldauer"]
        , $_POST["Bemerkung"]
        , $_POST["Orchesterbesetzung"]                  
        ); 
        ;    
    break; 

  case 'copy': 
    $ID_ref=$_REQUEST["ID"]; 
    $satz->ID=$ID_ref; 
    $satz->copy();   
    $satz->load_row();       
    $info->print_info_copy($satz->Title, $ID_ref, $satz->ID, 'edit_satz'); 
    break; 

  case 'delete_1': 
    $satz->ID = $_REQUEST["ID"];  
    $satz->load_row();
    if($satz->is_deletable()) {
      $info->print_form_confirm(basename(__FILE__),$satz->ID,'delete_2','Löschung');        
    }         
    break;      
  
  case 'delete_2': 
    $satz->ID = $_POST["ID"];  
    $satz->delete(); 
    $show_data=false; 
    break;          

  default: 
    $show_data=false;           
  }


$info->print_screen_header($satz->Title.' bearbeiten'); 

if (!$show_data) {goto pagefoot;}

echo 
'<form action="edit_satz.php" method="post">

<table class="form-edit"> 
<tr>    
  <td class="form-edit form-edit-col1">ID:</td>  
  <td class="form-edit form-edit-col2">'.$satz->ID.'</td>
</tr> 

<tr>    
  <label>
  <td class="form-edit form-edit-col1">Musikstück:</td>  
  <td class="form-edit form-edit-col2">
  '; 
  $musikstueck=new Musikstueck(); 
  $musikstueck->ID=$satz->MusikstueckID; 
  $musikstueck->print_select($satz->MusikstueckID); 
  
  echo ' <a href="edit_musikstueck.php?ID='.$satz->MusikstueckID.'&title=Musikstück&option=edit" tabindex="-1" class="form-link">Gehe zu Musikstück</a>'; 
  echo '
  </td>  
  </label>
</tr>         

<tr>    
  <label>
  <td class="form-edit form-edit-col1">Nr:</td>  
  <td class="form-edit form-edit-col2"><input type="text" name="Nr" value="'.$satz->Nr.'" size="50" autofocus="autofocus" required oninput="changeBackgroundColor(this)"></td>
  </label>
</tr> 

  <tr>    
    <label>
    <td class="form-edit form-edit-col1">Name:</td>  
    <td class="form-edit form-edit-col2"><input type="text" name="Name" value="'.htmlentities($satz->Name).'" size="100" oninput="changeBackgroundColor(this)"> (max. 100 Zeichen)</td>
    </label>
  </tr> 


  <tr>    
    <label>
    <td class="form-edit form-edit-col1">Tempobezeichnung:</td>  
    <td class="form-edit form-edit-col2"><input type="text" name="Tempobezeichnung" value="'.$satz->Tempobezeichnung.'" size="45" maxlength="80" oninput="changeBackgroundColor(this)"></td>
    </label>
  </tr> 



  <tr>    
    <label>
    <td class="form-edit form-edit-col1">Spieldauer:</td>  
    <td class="form-edit form-edit-col2">
    
    Minuten: <input type="text" id="input_minutes" size="10" oninput="set_seconds();changeBackgroundColor(this)">
    Sekunden: <input type="text" id="input_seconds" name="Spieldauer" value="'.$satz->Spieldauer.'" size="10" maxlength="80" onchange="changeBackgroundColor(this)"> 
      
      <script type="text/javascript">  
        function set_seconds() {
          var txt_min = document.getElementById("input_minutes").value;
          var sekunden = getSeconds(txt_min);
          document.getElementById("input_seconds").value=sekunden;         
        }
      </script> 
      </td>
      </label>
  </tr> 

  <tr>    
    <label>
    <td class="form-edit form-edit-col1">Orchesterbesetzung:</td>  
    <td class="form-edit form-edit-col2"><input type="text" name="Orchesterbesetzung" value="'.$satz->Orchesterbesetzung.'" size="120" oninput="changeBackgroundColor(this)"></td>
    </label>
  </tr> 

  <tr>    
  <label>
  <td class="form-edit form-edit-col1">Bemerkung:</td>  
  <td class="form-edit form-edit-col2">
  <textarea name="Bemerkung" rows=2 cols=100 maxlength="500" oninput="changeBackgroundColor(this)">'.htmlentities($satz->Bemerkung).'</textarea> (max. 500 Zeichen)
  </td>
  </label>
</tr>

  <tr> 
  <td class="form-edit form-edit-col1"></td> 
  <td class="form-edit form-edit-col2"><input class="btnSave" type="submit" name="update" value="Speichern">

  </td>
  </tr> 

  <input type="hidden" name="ID" value="' . $satz->ID . '">
  <input type="hidden" name="option" value="update"> 
  <input type="hidden" name="title" value="Satz">      

  </form>


  ';
  ?> 

  <tr> 
  <td class="form-edit form-edit-col1">Daten anzeigen: <br /> <br />
  <input type="radio" id="opt_Schwierigkeitsgrad" name="target_form" value="Schwierigkeitsgrad" onclick="changeIframeSrc('subform1', 'edit_satz_schwierigkeitsgrade.php?SatzID=<?php echo $satz->ID; ?>');" checked>
  <label for="opt_Schwierigkeitsgrad">Schwierigkeitsgrad</label><br>
  <input type="radio" id="opt_Besonderheiten" name="target_form" value="Besonderheiten" onclick="changeIframeSrc('subform1', 'edit_satz_lookups.php?SatzID=<?php echo $satz->ID; ?>');">
  <label for="opt_Besonderheiten">Besonderheiten</label><br>
  <input type="radio" id="opt_Erprobt" name="target_form" value="Erprobt" onclick="changeIframeSrc('subform1', 'edit_satz_erprobte.php?SatzID=<?php echo $satz->ID; ?>');">
  <label for="opt_Erprobt">Erprobt</label>
  <br/>
  <input type="radio" id="opt_Schueler" name="target_form" value="Schueler" onclick="changeIframeSrc('subform1', 'edit_satz_schuelers.php?SatzID=<?php echo $satz->ID; ?>');">
  <label for="opt_Schueler">Schüler</label>

  </td> 
  <td class="form-edit form-edit-col2">
    <iframe src="edit_satz_schwierigkeitsgrade.php?SatzID=<?php echo $satz->ID; ?>&source=iframe" height="300" id="subform1" name="Info" class="form-iframe-var2"></iframe>
  </td>
  </tr> 
  <?php 

echo '
<tr> 
  <td class="form-edit form-edit-col1"></td> 
  <td class="form-edit form-edit-col2"><br>
  '; 
  $info->print_form_inline('delete_1',$satz->ID,$satz->Title, 'löschen'); 
  $info->print_form_inline('copy',$satz->ID,$satz->Title, 'kopieren'); 

  echo '     
  </td>
</tr> 
</table> '; 

pagefoot: 
include_once('foot.php');

?>

