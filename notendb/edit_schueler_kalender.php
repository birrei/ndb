
<?php 
$PageTitle='Schüler Übungstag'; 
include_once('head.php');
include_once("classes/class.schueler.php");
include_once("classes/class.kalender.php");

$schuelerdatum = new SchuelerKalendertag();
$info= new HTML_Info(); 

$option=isset($_REQUEST["option"])?$_REQUEST["option"]:'edit';
$show_data=true; 



switch($option) {
  case 'edit': // über "Bearbeiten"-Link
    $schuelerdatum->ID=$_GET["ID"];
    $schuelerdatum->load_row(); 
    break; 


  // case 'insert': // XXXX   
  //   $schuelerdatum->insert_row('');
  //   $show_data=true; 
  //   break; 
  
  case 'update': 
    $schuelerdatum->ID = $_POST["ID"];    
    $schuelerdatum->update_row($_POST["Bemerkung"]); 
    $show_data=true;           
    break; 

  case 'delete_1': 
    $schuelerdatum->ID = $_REQUEST["ID"];  
    $schuelerdatum->load_row(); 
    if($schuelerdatum->is_deletable()) {
      $info->print_form_delete_confirm(basename(__FILE__), $schuelerdatum->Title, $schuelerdatum->ID, $schuelerdatum->Datum_DE);   
    }     
    $show_data=true;      
    break; 

  case 'delete_2': 
    $schuelerdatum->ID=$_REQUEST["ID"]; 
    $schuelerdatum->delete(); 
    $show_data=false; 
    break; 
     
  default: 
    $show_data=false;   
}

$info->print_screen_header($schuelerdatum->Title.' bearbeiten'); 
// $info->print_link_table($schuelerdatum->table_name, 'sortcol=Name', $schuelerdatum->Titles); 


if (!$show_data) {goto pagefoot;}

?>


<form action="edit_schueler_kalender.php" method="post">
<table class="form-edit"> 

  <tr>    
  <label>
  <td class="form-edit form-edit-col1">Schüler:</td>  
  <td class="form-edit form-edit-col2"><b><?php echo $schuelerdatum->SchuelerName; ?> </b></td>
  </label>
    </tr> 

  <tr>    
  <label>
  <td class="form-edit form-edit-col1">Datum:</td>  
  <td class="form-edit form-edit-col2"><b><?php echo $schuelerdatum->Datum_DE; ?></b> </td>
  </label>
    </tr> 


    <tr>    
  <label>
  <td class="form-edit form-edit-col1">Schuljahr:</td>  
  <td class="form-edit form-edit-col2"><?php echo $schuelerdatum->Schuljahr; ?></td>
  </label>
    </tr> 

    <tr>    
  <label>
  <td class="form-edit form-edit-col1">Hinweise:</td>  
  <td class="form-edit form-edit-col2"><?php echo $schuelerdatum->Ferien.' '.$schuelerdatum->Feiertag; ?>
  </td>
  </label>
    </tr> 


  <tr>    
    <label>
    <td class="form-edit form-edit-col1">Bemerkung:</td>  
    <td class="form-edit form-edit-col2"><input type="text" name="Bemerkung" value="<?php echo $schuelerdatum->Bemerkung; ?>" size="100" maxleng="250" autofocus="autofocus" oninput="changeBackgroundColor(this)"></td>
    </label>
  </tr> 




  <tr> 
    <td class="form-edit form-edit-col1"></td> 
    <td class="form-edit form-edit-col2"><input class="btnSave" type="submit" name="senden" value="Speichern">

    </td>
  </tr> 


<input type="hidden" name="option" value="update">        
<input type="hidden" name="ID" value="<?php echo $schuelerdatum->ID; ?>">

</form>


<tr> 
  <td class="form-edit form-edit-col1">
    
<a href="edit_schueler_kalender_uebungen.php?SchuelerID=<?php echo $schuelerdatum->SchuelerID.'&Datum='.$schuelerdatum->Datum_EN; ?>" target="iframe_Uebungen">Übungen: </a>


    <p> 
<a href="edit_uebung.php?SchuelerID=<?php echo $schuelerdatum->SchuelerID.'&Datum='.$schuelerdatum->Datum_EN.'&option=insert2"'; ?> target="_blank" class="form-link form-link-switch">Übung hinzufügen</a>

        


</p>


  </td> 
  <td class="form-edit form-edit-col2">
  
      <iframe src="edit_schueler_kalender_uebungen.php?SchuelerID=<?php echo $schuelerdatum->SchuelerID.'&Datum='.$schuelerdatum->Datum_EN; ?>&source=iframe" height="300" id="subform1" name="iframe_Uebungen" class="form-iframe-var1"></iframe>


  </td>
</tr> 



<tr> 
  <td class="form-edit form-edit-col1"></td> 
  <td class="form-edit form-edit-col2"><br>
    <?php 
    $info->print_form_inline('delete_1',$schuelerdatum->ID,$schuelerdatum->Title, 'löschen'); 
    ?>      
  </td>
</tr> 


</table> 

<?php 

pagefoot: 
include_once('foot.php');

?>
