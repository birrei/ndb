
<?php 
$PageTitle='Schüler Übungstag'; 
include_once('head.php');
include_once("classes/class.schueler.php");
include_once("classes/class.kalender.php");

$uebungstag = new SchuelerKalendertag();
$info= new HTML_Info(); 

$option=isset($_REQUEST["option"])?$_REQUEST["option"]:'edit';
$show_data=true; 



switch($option) {
  case 'edit': // über "Bearbeiten"-Link
    $uebungstag->ID=$_GET["ID"];
    $uebungstag->load_row(); 
    break; 


  // case 'insert': // XXXX   
  //   $uebungstag->insert_row('');
  //   $show_data=true; 
  //   break; 
  
  case 'update': 
    $uebungstag->ID = $_POST["ID"];    
    $uebungstag->update_row($_POST["Bemerkung"], $_POST["Datum"]); 
    $show_data=true;           
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
// $info->print_link_table($uebungstag->table_name, 'sortcol=Name', $uebungstag->Titles); 


if (!$show_data) {goto pagefoot;}

?>


<form action="edit_schueler_kalender.php" method="post">
<table class="form-edit"> 

  <tr>    
  <label>
  <td class="form-edit form-edit-col1">Schüler:</td>  
  <td class="form-edit form-edit-col2"><b><?php echo $uebungstag->SchuelerName; ?> </b></td>
  </label>
    </tr> 

  <tr>    
  <label>
  <td class="form-edit form-edit-col1">Datum:</td>  
  <td class="form-edit form-edit-col2"> <input type="date" name="Datum" value="<?php echo $uebungstag->Datum_EN; ?>" oninput="changeBackgroundColor(this)" requested> 
            <b>Schuljahr:</b> <?php echo $uebungstag->Schuljahr; ?>
            <b>Wochentag:</b> <?php echo $uebungstag->Wochentag; ?>
            <b>Ferien:</b> <?php echo $uebungstag->Ferien; ?>
            <b>Feiertag:</b> <?php echo $uebungstag->Ferien; ?>
  
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

</form>


<tr> 
  <td class="form-edit form-edit-col1">
    <a href="edit_schueler_kalender_uebungen.php?SchuelerID=<?php echo $uebungstag->SchuelerID.'&Datum='.$uebungstag->Datum_EN; ?>" target="iframe_Uebungen">Übungen: </a>
    <p>
        <br><a href="edit_uebung.php?SchuelerID=<?php echo $uebungstag->SchuelerID.'&Datum='.$uebungstag->Datum_EN.'&option=insert"'; ?> target="_blank" class="form-link form-link-switch">Übung hinzufügen</a>
    </p>
  </td> 
  <td class="form-edit form-edit-col2">
      <iframe src="edit_schueler_kalender_uebungen.php?SchuelerID=<?php echo $uebungstag->SchuelerID.'&Datum='.$uebungstag->Datum_EN; ?>&source=iframe" height="300" id="subform1" name="iframe_Uebungen" class="form-iframe-var1"></iframe>
  </td>
</tr> 



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
