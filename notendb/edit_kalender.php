
<?php 
$PageTitle='Kalender Datum'; 
include_once('head.php');
include_once("classes/class.kalender.php");
include_once("classes/class.kalendertag.php");
include_once("classes/class.htmlinfo.php");

$kalender = new Kalender();
$kalendertag = new Kalendertag();
$info= new HTML_Info(); 

$option=isset($_REQUEST["option"])?$_REQUEST["option"]:'edit';
$show_data=true; 
$fehler=''; 


switch($option) {
  case 'edit':
    $ID=isset($_REQUEST["ID"])?$_REQUEST["ID"]:'';     
    $Datum=isset($_REQUEST["Datum"])?$_REQUEST["Datum"]:'';

    if($Datum=='' & $ID=='') {
      $fehler='Kein Datum ausgewählt!';  
      $info->print_user_error($fehler); 
      goto pagefoot;
    }  

    if($ID!='') {
      $kalendertag->ID=$_GET["ID"];
    } elseif($Datum!='') {
      $kalendertag->ID = $kalender->getID($_REQUEST["Datum"]); 
    }
    $show_data = $kalendertag->load_row();  
    break; 

  case 'update': 
    $Unterricht_Geplant=(isset($_POST["Unterricht_Geplant"])?1:0); 
    $Unterricht_Protokolliert=(isset($_POST["Unterricht_Protokolliert"])?1:0); 
    $kalendertag->ID = $_POST["ID"];    
    $kalendertag->update($Unterricht_Geplant, $Unterricht_Protokolliert);           
    break; 

  default: 
    $show_data=false;       
  
}

$info->print_screen_header($kalender->Title.' bearbeiten'); 

if (!$show_data) {goto pagefoot;}

echo '
<form action="edit_kalender.php" method="post">
<table class="form-edit"> 

  <tr>    
    <label>
    <td class="form-edit form-edit-col1">Datum:</td>  
    <td class="form-edit form-edit-col2"><b>'.$kalendertag->Datum_DE.'</b></td>
    </label>
  </tr> 
  <tr>    
    <label>
    <td class="form-edit form-edit-col1">Wochentag:</td>  
    <td class="form-edit form-edit-col2">'.$kalendertag->Wochentag_Name.'</td>
    </label>
  </tr>     
  <tr>    
    <label>
    <td class="form-edit form-edit-col1">Kalenderwoche:</td>  
    <td class="form-edit form-edit-col2">'.$kalendertag->Kalenderwoche.'</td>
    </label>
  </tr>     
  <tr>    
    <label>
    <td class="form-edit form-edit-col1">Schuljahr:</td>  
    <td class="form-edit form-edit-col2">'.$kalendertag->Schuljahr.'</td>
    </label>
  </tr>      
  <tr>    
    <label>
    <td class="form-edit form-edit-col1">Feiertag:</td>  
    <td class="form-edit form-edit-col2">'.$kalendertag->Feiertag.'</td>
    </label>
  </tr>     
  <tr>    
    <label>
    <td class="form-edit form-edit-col1">Ferien:</td>  
    <td class="form-edit form-edit-col2">'.$kalendertag->Ferien.'</td>
    </label>
  </tr>     
  <tr>    
    <label>
    <td class="form-edit form-edit-col1">Unterricht geplant:</td>  
    <td class="form-edit form-edit-col2"><input type="checkbox" name="Unterricht_Geplant" '.($kalendertag->Unterricht_Geplant==1?'checked':'').'></td>
    </label>
  </tr> 

  <tr>    
    <label>
    <td class="form-edit form-edit-col1">Unterricht protokolliert:</td>  
    <td class="form-edit form-edit-col2"><input type="checkbox" name="Unterricht_Protokolliert" '.($kalendertag->Unterricht_Protokolliert==1?'checked':'').'></td>
    </label>
  </tr> 


  <tr> 
    <td class="form-edit form-edit-col1"></td> 
    <td class="form-edit form-edit-col2"><input class="btnSave" type="submit" name="senden" value="Speichern">

    </td>
  </tr> 

  <input type="hidden" name="option" value="update">        
  <input type="hidden" name="ID" value="' . $kalendertag->ID. '">

  </form>


  </table> 
  
  
  '; 

pagefoot: 
include_once('foot.php');

?>
