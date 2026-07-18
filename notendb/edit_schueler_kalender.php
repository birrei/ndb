
<?php 
$PageTitle='Schüler Übungstag'; 
include_once('head.php');
include_once("classes/class.schueler.php");
include_once("classes/class.kalender.php");

$option=isset($_REQUEST["option"])?$_REQUEST["option"]:'edit';
$show_data=true; 

$uebungstag = new SchuelerKalendertag();
$info= new HTML_Info(); 

// print_r($_REQUEST); // test 

switch($option) {

  case 'edit': // über "Bearbeiten"-Link
    $uebungstag->ID=$_REQUEST["ID"];
    $show_data = $uebungstag->load_row(); 
    $Datum = $uebungstag->Datum_EN; 
    $Datum_DE = $uebungstag->Datum_DE; 
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
        $info->print_user_error('Fehler: Das Datum '.$Datum_DE.' existiert bereits an einem anderen Übungstag!');
        $Datum=$Datum_gespeichert_EN ;  
        $Datum_DE=$Datum_gespeichert_EN;  
        $update_mode=2; 
        goto exec_update; 
      }
    }

    exec_update: 
    switch($update_mode) {
      case 1: 
        $uebungstag->update_row($_POST["Datum"], $_POST["Bemerkung"]); 
      break; 
      case 2: 
        $uebungstag->update_row2($_POST["Bemerkung"]); 
      break;       
    }
    
    $uebungstag->load_row();   
           
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

$info->print_screen_header($uebungstag->Title.' bearbeiten'); 


if (!$show_data) {goto pagefoot;}

?>


<form action="edit_schueler_kalender.php" method="post">
<table class="form-edit"> 
  <tr>
    <td class="form-edit form-edit-col1">ID:</td>  
    <td class="form-edit form-edit-col2"><?php echo $uebungstag->ID; ?> <br></td>
  </tr> 
  <tr>    
  <label>
  <td class="form-edit form-edit-col1">Schüler:</td>  
  <td class="form-edit form-edit-col2"><b><?php echo $uebungstag->SchuelerName; ?> </b></td>
  </label>
    </tr> 

  <tr>    
  <label>
  <td class="form-edit form-edit-col1">Datum:</td>  
  <td class="form-edit form-edit-col2"> 
    <input type="date" name="Datum" value="<?php echo $Datum ; ?>" oninput="changeBackgroundColor(this)" requested> 
            <b> <?php echo $uebungstag->Wochentag; ?></b>
          </td>
  </label>
    </tr> 

  <tr>    
    <label>
    <td class="form-edit form-edit-col1">Info:</td>  
    <td class="form-edit form-edit-col2">

      <b>Schuljahr:</b> <?php echo $uebungstag->Schuljahr; ?>
          <?php echo $uebungstag->Ferien!=''?' / Ferien: '.$uebungstag->Ferien:''; ?>
          <?php echo $uebungstag->Feiertag!=''?' / Feiertag '.$uebungstag->Feiertag:''; ?>
  </td>
    </label>
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
<input type="hidden" name="SchuelerID" value="<?php echo $uebungstag->SchuelerID; ?>">


</form>

<?php 

if(!empty($Datum)) {

  ?>
<tr> 
  <td class="form-edit form-edit-col1">
    <a href="edit_schueler_kalender_uebungen.php?SchuelerID=<?php echo $uebungstag->SchuelerID.'&Datum='.$Datum; ?>" target="iframe_Uebungen">Übungen: </a>
    <p>
        <br><a href="edit_uebung.php?SchuelerID=<?php echo $uebungstag->SchuelerID.'&Datum='.$uebungstag->Datum_EN.'&option=insert"'; ?> target="_blank" class="form-link form-link-switch">Übung hinzufügen</a>
    </p>
  </td> 
  <td class="form-edit form-edit-col2">
      <iframe src="edit_schueler_kalender_uebungen.php?SchuelerID=<?php echo $uebungstag->SchuelerID.'&Datum='.$Datum; ?>&source=iframe" height="300" id="subform1" name="iframe_Uebungen" class="form-iframe-var1"></iframe>
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
