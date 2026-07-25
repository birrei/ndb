
<?php 
$PageTitle='Schuljahr bearbeiten'; 
include_once('head.php');
include_once("classes/class.schuljahr.php");
include_once("classes/class.schuljahr.php");
include_once("classes/class.htmlinfo.php");

$schuljahr = new Schuljahr();
$info= new HTML_Info(); 

$option=isset($_REQUEST["option"])?$_REQUEST["option"]:'edit';

$show_data=true; 


switch($option) {

  case 'edit': // über "Bearbeiten"-Link
    if($_GET["ID"]=='') {
      $info->print_user_error('Es wurde kein Schuljahr ausgewählt!'); 
      goto pagefoot; 
    }
    $schuljahr->ID=$_GET["ID"];
    $schuljahr->load_row(); 
    break; 

  case 'insert': 

    $schuljahr->insert_row();
    $show_data=true; 
    break; 
  
  case 'update': 
    $schuljahr->ID = $_POST["ID"];   
    $Eingelesen=(isset($_POST["Eingelesen"])?1:0);      
    $schuljahr->update_row(
                $_POST["Name"]
                , $_POST["Datum_Start"]
                , $_POST["Datum_Ende"] 
                , $Eingelesen
                ); 
    $show_data=true;           
    break; 

  case 'delete_1': 
    $schuljahr->ID = $_REQUEST["ID"];  
    $schuljahr->load_row(); 
    if($schuljahr->is_deletable()) {
      $info->print_form_delete_confirm(basename(__FILE__), $schuljahr->Title, $schuljahr->ID, $schuljahr->Name);   
    }          
    break; 

  case 'delete_2': 
    $schuljahr->ID=$_REQUEST["ID"]; 
    $schuljahr->delete(); 
    $show_data=false; 

    break; 
    
  default: 
    $show_data=false; 
       
}

$info->print_screen_header($schuljahr->Title.' bearbeiten'); 
$info->print_link_table2('schuljahre', true); 

if (!$show_data) {goto pagefoot;}
    
echo '
  <form action="edit_schuljahr.php" method="post">
  <table class="form-edit"> 
    <tr>    
    <label>
    <td class="form-edit form-edit-col1">ID:</td>  
    <td class="form-edit form-edit-col2">'.$schuljahr->ID.'  
    
    
    </td>
    </label>
      </tr> 
    '; 



    echo '
    <tr>    
      <label>
      <td class="form-edit form-edit-col1">Name:</td>  
      <td class="form-edit form-edit-col2"><input type="text" name="Name" value="'.$schuljahr->Name.'" size="45" maxlength="80" required="required" autofocus="autofocus" oninput="changeBackgroundColor(this)"></td>
      </label>
    </tr> 
    
    <tr>    
      <label>
      <td class="form-edit form-edit-col1">Datum von:</td>  
      <td class="form-edit form-edit-col2">
            <input type="date" name="Datum_Start" value="'.$schuljahr->Datum_Start.'" oninput="changeBackgroundColor(this)" requested>
        </td>
      </label>
    </tr> 
    <tr>    
      <label>
      <td class="form-edit form-edit-col1">Datum bis:</td>  
      <td class="form-edit form-edit-col2">
            <input type="date" name="Datum_Ende" value="'.$schuljahr->Datum_Ende.'" oninput="changeBackgroundColor(this)" requested>
        </td>
      </label>
    </tr> 

    <tr>    
      <label>
      <td class="form-edit form-edit-col1">Eingelesen:</td>  
      <td class="form-edit form-edit-col2">
             <label><input type="checkbox" name="Eingelesen" '.($schuljahr->Eingelesen==1?'checked':'').'> Eingelesen </label> 
            &nbsp; <i>Aktivieren, wenn Ferien, Feiertage und Übungstage-Grundlage für das Schuljahr hinterlegt sind. </i> 
        </td>
      </label>
    </tr>     

    
    <tr> 
      <td class="form-edit form-edit-col1"></td> 
      <td class="form-edit form-edit-col2"><input class="btnSave" type="submit" name="senden" value="Speichern">

      </td>
    </tr> 


  '; 

  ?>
  <tr> 
    <td class="form-edit form-edit-col1">Daten anzeigen: <br /> <br />
                
      <input type="radio" id="Ferien" name="target_form" value="Ferien" onclick="changeIframeSrc('subform1', 'edit_schuljahr_ferien.php?SchuljahrID=<?php echo $schuljahr->ID; ?>');" checked>
        <label for="Ferien">Ferien</label><br>

      <input type="radio" id="Musikstuecke" name="target_form" value="Feiertage" onclick="changeIframeSrc('subform1', 'edit_schuljahr_feiertage.php?SchuljahrID=<?php echo $schuljahr->ID; ?>');">
        <label for="Feiertage">Feiertage</label><br>



    </td>
    <td class="form-edit form-edit-col2">

      <iframe src="edit_schuljahr_ferien.php?SchuljahrID=<?php echo $schuljahr->ID; ?>" height="450" name="subform1" id="subform1" class="form-iframe-var2"></iframe>
    </td>
  </tr> 

  <?php 


  echo '

  <input type="hidden" name="option" value="update"> 
  <input type="hidden" name="ID" value="' . $schuljahr->ID. '">

  </form>

  
  <tr> 
    <td class="form-edit form-edit-col1"></td> 
    <td class="form-edit form-edit-col2"><br>
   '; 
    $info->print_form_inline('delete_1',$schuljahr->ID,$schuljahr->Title, 'löschen'); 

    $info->print_link_overview('uebungstage_einlesen.php','SchuljahrID='.$schuljahr->ID, 'Übungstage einlesen'); 

  echo '     
    </td>
  </tr> 


  </table> 
  
  
  '; 

pagefoot: 
include_once('foot.php');

?>
