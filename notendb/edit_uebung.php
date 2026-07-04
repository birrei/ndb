
<?php 
$PageTitle='Übung'; 
include_once('head.php');
include_once("classes/class.htmlinfo.php");
include_once("classes/class.uebung.php");
include_once("classes/class.kalendertag.php");
include_once("classes/class.uebungtyp.php");
include_once("classes/class.schueler.php");
include_once("classes/class.bewertung.php");

$option=isset($_REQUEST["option"])?$_REQUEST["option"]:'edit';
$show_data=true; 

$uebung = new Uebung(); 
$info= new HTML_Info(); 


switch($option) {
  
  case 'edit': // über "Bearbeiten"-Link    
    $uebung->ID=$_REQUEST["ID"];
    $show_data = $uebung->load_row();   

    break; 

  case 'insert':

    $SchuelerID=isset($_REQUEST["SchuelerID"])?$_REQUEST["SchuelerID"]:'';

    if(empty($_REQUEST["SchuelerID"])) {
      // ggf. aus "Übersicht Übungen", falls Schüler-Filter nicht gesetzt 
      $info->print_user_error('Es wurde kein Schüler ausgewählt!');
      $show_data=false; 
      goto pagefoot;  
    }
    $SchuelerID=$_REQUEST["SchuelerID"];  
    $Datum=$_REQUEST["Datum"];  // immer gesetzt, kann ggf. aber leer sein 
    $uebung->insert_row($SchuelerID, $Datum); 
    $show_data = $uebung->load_row();  
    $Datum = $uebung->Datum;   

    break; 

  case 'update':  

    $uebung->ID =$_REQUEST["ID"]; 
    $uebung->load_row(); // bereits gespeicherte Werte zum Vergleich holen 
    $Datum_gespeichert = $uebung->Datum; 
    $Datum = $_REQUEST["Datum"]; 

    if(empty($Datum)) { 
      $info->print_user_error('Das Datum darf nicht leer sein!'); 
      $Datum = $Datum_gespeichert;
      // $update_mode=2; 
      // goto exec_update; 
    } 
  
   if(!empty($Datum)) { 

      $Datum_Date = new Datetime($Datum); 
      $Datum_DE = $Datum_Date->format('d.m.Y');   

      $kalender = new SchuelerKalender(); 
      $kalender -> SchuelerID = $_REQUEST["SchuelerID"]; 

      if (!$kalender->date_exists($Datum) ) {
        $info->print_user_error('Das Datum "'.$Datum_DE.'" ist kein gültiger Übungstag für den Schüler. 
                                      Das Datum wird auf den zuvor gespeicherten Wert zurückgesetzt.');            
        $Datum = $Datum_gespeichert;  
      }
    }

  $uebung->update_row(
      $_REQUEST["SchuelerID"],
      $Datum, 
      $_REQUEST["Name"], 
      $_REQUEST["Bemerkung"], 
      $_REQUEST["UebungtypID"], 
      $_REQUEST["Anzahl"], 
      $_REQUEST["SatzID"], 
      $_REQUEST["Reihenfolge"], 
      $_REQUEST["BewertungID"]
    ); 
    $show_data = $uebung->load_row(); 

    break; 

  case 'delete_1':        
    $uebung->ID = $_POST["ID"];  
    $uebung->load_row(); 
    if($uebung->is_deletable()) {
      $info->print_form_delete_confirm(basename(__FILE__), $uebung->Title, $uebung->ID, $uebung->Name);   
    }     
    break; 

  case 'delete_2':    
    $uebung->ID=$_REQUEST["ID"]; 
    $uebung->delete(); 
    $show_data=false; 
    break; 

  case 'copy': 
    unset($_GET); 
    $uebung = new Uebung();          
    $uebung->ID=$_REQUEST["ID"]; 
    $uebung->copy();   
    $uebung->load_row();   
    break; 
}

if (!$show_data) {goto pagefoot;}

$info->print_screen_header($uebung->Title.' bearbeiten'); 

$info->print_form_inline('delete_1',$uebung->ID,$uebung->Title, 'löschen'); 
$info->print_form_inline('copy',$uebung->ID,$uebung->Title, 'kopieren'); 


echo '<form action="edit_uebung.php" method="post">
  <table class="form-edit" width="100%"> 
  <tr>
    <td class="form-edit form-edit-col1">ID:</td>  
    <td class="form-edit form-edit-col2">'.$uebung->ID.'<br></td>
  </tr> '; 
  
echo '
  <tr>    
  <td class="form-edit form-edit-col1">Schüler Name:</td>  
  <td class="form-edit form-edit-col2"><b>'; 
    echo $uebung->SchuelerName; 
    echo '</b> &nbsp; &nbsp; '; 
    $info->print_link_edit('schueler', $uebung->SchuelerID, 'Schueler', true);    
   echo '
   </td>
    </tr> '; 

echo '<tr>    
    <label>
     <td class="form-edit form-edit-col1"><br>Datum:</td>   
     <td class="form-edit form-edit-col2">
        <br><input type="date" name="Datum" value="'.$uebung->Datum.'" oninput="changeBackgroundColor(this)" requested> 
         <a href="edit_kalender.php?Datum='.$uebung->Datum.'" target="_blank">Kalenderdatum öffnen</a> 
        </td>
     </label>    
  </tr> '; 


echo '
  <tr>    
    <label>
    <td class="form-edit form-edit-col1">Übung Reihenfolge:</td>  
    <td class="form-edit form-edit-col2">
    <input type="number" name="Reihenfolge" value="'.$uebung->Reihenfolge.'" oninput="changeBackgroundColor(this)"> 
      <i> (Reihenfolge innerhalb Schüler / Datum) </i> 
    </td>
 
    </label>
  </tr>     

'; 

echo '
  <tr>    
    <label>
    <td class="form-edit form-edit-col1">Übung Inhalt:</td>  
    <td class="form-edit form-edit-col2"><input type="text" name="Name" value="'.htmlentities($uebung->Name ?? '').'" size="100" autofocus="autofocus" oninput="changeBackgroundColor(this)"></td>
    </label>
  </tr>     

'; 

echo '
  <tr>    
  <label>  
  <td class="form-edit form-edit-col1">Uebung Typ:</td>  
  <td class="form-edit form-edit-col2">  
        ';  
        $typ=new UebungTyp(); 
        $typ->print_select($uebung->UebungtypID); 

echo ' </label>  
      '; 
      $info->print_link_edit($typ->table_name, $uebung->UebungtypID,$typ->Title, true); 
      $info->print_link_table($typ->table_name,'sortcol=Name',$typ->Titles,true,'');    
echo '</td>
    </tr>'; 


echo '
  <tr>    
    <td class="form-edit form-edit-col1">Anzahl: </td>  
      <td class="form-edit form-edit-col2"><input type="number" name="Anzahl" value="'.$uebung->Anzahl.'" oninput="changeBackgroundColor(this)"> 
      </td>
  </tr>  
  '; 

echo '
  <tr>    
    <label>  
    <td class="form-edit form-edit-col1">Satz:</td>  
    <td class="form-edit form-edit-col2">  '; 
    
        $schueler = new Schueler(); 
        $schueler->ID = $uebung->SchuelerID; 
        $schueler->print_select_saetze($uebung->SatzID); 
        echo ' </label> ';             
        $info->print_link_edit('satz',$uebung->SatzID,true);   

echo '</td>
      </tr>'; 


echo '
  <tr>    
  <label>  
  <td class="form-edit form-edit-col1">Bewertung:</td>  
  <td class="form-edit form-edit-col2">  
        ';  
        $bewertung=new Bewertung(); 
        $bewertung->print_select($uebung->BewertungID); 

echo ' </label>  
      '; 
      $info->print_link_edit($bewertung->table_name, $uebung->BewertungID,$bewertung->Title, true); 
      $info->print_link_table2('bewertungen'); 

echo '</td>
    </tr>'; 
    
    
      ?>
  <tr>    
    <label>
    <td class="form-edit form-edit-col1">Bemerkung:</td>  
    <td class="form-edit form-edit-col2">
      <textarea name="Bemerkung" rows=2 cols=100 oninput="changeBackgroundColor(this)"><?php echo htmlentities($uebung->Bemerkung ?? '') ;?></textarea> 
    </td>
    </label>
  </tr>    

  <tr> 
    <td class="form-edit form-edit-col1"></td> 
    <td class="form-edit form-edit-col2"><input class="btnSave" type="submit" name="senden" value="Speichern">  
    </td>
  </tr> 

  <tr> 
    <td class="form-edit form-edit-col1">
        <a href="edit_uebung_lookups.php?UebungID=<?php echo $uebung->ID; ?>" target="Info">Besonderheiten:</a>
      </td>  
    <td class="form-edit form-edit-col2">
    <iframe src="edit_uebung_lookups.php?UebungID=<?php echo $uebung->ID; ?>&source=iframe" height="200" id="subform1" name="Info" class="form-iframe-var2"></iframe>
  </td>
  </tr> 

  <input type="hidden" name="option" value="update">
  <input type="hidden" name="ID" value="<?php echo $uebung->ID; ?>">
  <input type="hidden" name="SchuelerID" value="<?php echo $uebung->SchuelerID; ?>">  
  <input type="hidden" name="SchuelerName" value="<?php echo $uebung->SchuelerName; ?>">  
        
  </form>

  </table> 

<?php 

pagefoot: 

include_once('foot.php');


?>
