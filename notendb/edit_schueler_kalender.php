<?php 
$PageTitle='Schüler Übungstag'; 
include_once('head.php');
include_once("classes/class.schueler.php");
include_once("classes/class.kalender.php");
include_once("classes/class.kalendertag.php"); // Schüler Kalendertag, aka "Übungstag" 
include_once("classes/class.schuljahr.php");

// print_r($_REQUEST); // test 

$option=isset($_REQUEST["option"])?$_REQUEST["option"]:'edit';
$Berechnen=(isset($_POST["Berechnen"])?1:0); 
$show_data=true; 

$uebungstag = new SchuelerKalendertag();
$info= new HTML_Info(); 

switch($option) {

  case 'edit': 

    if(isset($_REQUEST["ID"]))  {
      $uebungstag->ID=$_REQUEST["ID"];  
    }
    if(isset($_REQUEST["SchuelerID"]) & isset($_REQUEST["Datum"]))  {
      if(empty($_REQUEST["Datum"]) OR $_REQUEST["Datum"]=='0000-00-00' ) {
          $info->print_user_error('Es wurde kein Datum ausgewählt!');
          $show_data=false; 
          goto pagefoot;  
      }
      $ID=$uebungstag->getID($_REQUEST["SchuelerID"], $_REQUEST["Datum"]); 
      if (empty($ID)) {
          $info->print_user_error('Das Datum existiert nicht!'); // sollte eigentlich nicht vorkommen 
          $show_data=false; 
          goto pagefoot;          
      }
      $uebungstag->ID = $ID; 
    }
    $show_data = $uebungstag->load_row(); 
    $Datum = $uebungstag->Datum_EN; 
    $Datum_DE = $uebungstag->Datum_DE;   
    $Berechnen = $uebungstag->Berechnen; 
        
    break; 

case 'insert': 

  if(empty($_REQUEST["SchuelerID"])) {
      $info->print_user_error('Es wurde kein Schüler ausgewählt!');
      $show_data=false; 
      goto pagefoot;  
    }

    $uebungstag->insert_row($_REQUEST["SchuelerID"]); 
    $uebungstag->load_row();    
    $Datum = $uebungstag->Datum_EN;   
    $Datum_DE = $uebungstag->Datum_DE;     
    $Berechnen = $uebungstag->Berechnen; 

    break; 
  
  case 'update': 

    $uebungstag->ID = $_REQUEST["ID"];  
    $uebungstag->load_row(); // bereits gespeicherte Werte zum Vergleich holen 
    
    $Datum_gespeichert_DE = $uebungstag->Datum_DE; 
    $Datum_gespeichert_EN = $uebungstag->Datum_EN; 

    $Datum = $_REQUEST["Datum"]; // 

    $update_mode=1; // 1 Datum + Bemerkung speichern, 2 nur Bemerkung speichern, Datum bleibt leer 

    if(empty($Datum)) { 
      $info->print_user_error('Das Datum darf nicht leer sein!'); 
      $Datum = $Datum_gespeichert_EN!=''?$Datum_gespeichert_EN:'';
      $update_mode=2; 
      goto exec_update; 
    } 
  
    if(!empty($Datum)) {

      $Datum_Date = new Datetime($Datum); 
      $Datum_DE = $Datum_Date->format('d.m.Y');   

      /** existiert das in Form gesetzte Datum bereits an einer anderen schueler_kalender.ID ?  */
      $datum_vorhanden = $uebungstag->date_exists($Datum); 
      if($datum_vorhanden) {
        $info->print_user_error('Fehler: Ein Übungstag mit dem Datum '.$Datum_DE.' existiert bereits.');
        $Datum=$Datum_gespeichert_EN ;  
        $Datum_DE=$Datum_gespeichert_DE;  
        $update_mode=2; 
        goto exec_update; 
      }

    }

    exec_update: 
    switch($update_mode) {
      case 1: 
        $uebungstag->update_row($_POST["Datum"], $_POST["Bemerkung"], $Berechnen); 
      break; 
      case 2: 
        $uebungstag->update_row2($_POST["Bemerkung"], $Berechnen); 
      break;       
    }
    
    $uebungstag->load_row();   
    $Berechnen=$uebungstag->Berechnen; 

           
    break; 

  case 'delete_1': 
    $uebungstag->ID = $_REQUEST["ID"];  
    $uebungstag->load_row(); 
    if($uebungstag->is_deletable()) {
      $info->print_form_delete_confirm(basename(__FILE__), $uebungstag->Title, $uebungstag->ID, $uebungstag->Datum_DE);   
    }     
    $show_data=true;      
    break; 

  case 'delete_2': 
    $uebungstag->ID=$_REQUEST["ID"]; 
    $uebungstag->delete(); 
    $show_data=false; 
    break; 
     
  default: 
    $show_data=false;   
}

// print_r(get_object_vars($uebungstag)); // test 

$info->print_screen_header_with_help_link($uebungstag->Title.' bearbeiten'); 
$info->print_link_hilfe_erfassung('uebungstag'); 

if (!$show_data) {goto pagefoot;}




?>


<form action="edit_schueler_kalender.php" method="post">
<table class="form-edit"> 
  <tr>
    <td class="form-edit form-edit-col1">ID:</td>  
    <td class="form-edit form-edit-col2">
        <?php echo $uebungstag->ID; ?> &nbsp; <label><input type="checkbox" name="Berechnen" <?php echo ($Berechnen==1?'checked':''); ?>>Berechnen</label>   
        <br><br>
  </td>
  </tr> 
  <tr>    
  <label>
  <td class="form-edit form-edit-col1">Schüler:</td>  
  <td class="form-edit form-edit-col2"><b><?php echo $uebungstag->SchuelerName; ?> &nbsp; &nbsp; </b> 
      <?php $info->print_link_edit('schueler', $uebungstag->SchuelerID);  ?>
      <br><br>
    </td>
  </label>
    </tr> 

  <tr>    
    <label>
    <td class="form-edit form-edit-col1">Datum:</td>  
    <td class="form-edit form-edit-col2"> 
    <input type="date" name="Datum" value="<?php echo $Datum ; ?>" oninput="changeBackgroundColor(this)" requested> 
     </label>
       <a href="edit_kalender.php?Datum=<?php echo $Datum ; ?>" target="_blank"  class="form-link">Kalenderdatum bearbeiten</a>  
            Wochentag: <?php echo $uebungstag->Wochentag; ?> / 
            Schuljahr: <?php echo $uebungstag->Schuljahr; ?>
            <?php echo $uebungstag->Ferien!=''?' / Ferien: '.$uebungstag->Ferien:''; ?>
            <?php echo $uebungstag->Feiertag!=''?' / Feiertag '.$uebungstag->Feiertag:''; ?>  
    
          </td>
  </tr> 

  <tr>    
    <label>
    <td class="form-edit form-edit-col1">Bemerkung:</td>  
    <td class="form-edit form-edit-col2"><input type="text" name="Bemerkung" value="<?php echo $uebungstag->Bemerkung; ?>" size="100" maxleng="250" autofocus="autofocus" oninput="changeBackgroundColor(this)"></td>
    </label>
  </tr> 

  <tr> 
    <td class="form-edit form-edit-col1"></td> 
    <td class="form-edit form-edit-col2"><input class="btnSave" type="submit" name="senden" value="Speichern">

    </td>
  </tr> 


<input type="hidden" name="option" value="update">        
<input type="hidden" name="ID" value="<?php echo $uebungstag->ID; ?>">


</form>

<?php 

if(!empty($Datum)) {
  // XXXX ändern. 
  ?>
<tr> 
  <td class="form-edit form-edit-col1">
    <a href="edit_schueler_kalender_uebungen.php?SchuelerID=<?php echo $uebungstag->SchuelerID.'&Datum='.$Datum; ?>" target="iframe_Uebungen">Übungen: </a>
    <p>
        <br><a href="edit_uebung.php?SchuelerID=<?php echo $uebungstag->SchuelerID.'&Datum='.$uebungstag->Datum_EN.'&option=insert"'; ?> target="_blank" class="form-link form-link-switch">Übung hinzufügen</a>
        <br>
        <br><a href="edit_schueler_kalender_uebungen.php?SchuelerID=<?php echo $uebungstag->SchuelerID.'&Datum='.$Datum.'&option=insert_uebung_default'; ?>" target="iframe_Uebungen" class="form-link form-link-switch">Übung ohne Doku</a>

  </p>
  </td> 
  <td class="form-edit form-edit-col2">
      <iframe src="edit_schueler_kalender_uebungen.php?SchuelerID=<?php echo $uebungstag->SchuelerID.'&Datum='.$Datum; ?>&source=iframe" height="300" id="subform1" name="iframe_Uebungen" class="form-iframe-var1"></iframe>
  </td>
</tr> 
  <tr>
    <td class="form-edit form-edit-col1"><br>Entstehung:</td>  
    <td class="form-edit form-edit-col2"> 
        <?php 
        $typeInfo = $uebungstag->Eingelesen==1?'Eingelesener Übungstag':'Manuell angelegter Übungstag'; 
        $info->print_info($typeInfo); 
        ?>

  </td>
  </tr> 


  <?php 


}

?>




<tr> 
  <td class="form-edit form-edit-col1"></td> 
  <td class="form-edit form-edit-col2"><br>
    <?php 
    $info->print_form_inline('delete_1',$uebungstag->ID,$uebungstag->Title, 'löschen'); 
    ?>  
    
    
  </td>
</tr> 


</table> 

<?php 

pagefoot: 
include_once('foot.php');

?>
