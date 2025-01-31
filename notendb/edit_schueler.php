
<?php 
include('head.php');
include("cl_schueler.php");
include("cl_html_info.php");

$schueler = new Schueler();
$info= new HtmlInfo(); 

$show_data=false; 

if (isset($_REQUEST["option"])) {
  switch($_REQUEST["option"]) {
    case 'edit': // über "Bearbeiten"-Link
      $schueler->ID=$_GET["ID"];
      if ($schueler->load_row()) {
        $show_data=true;       
      }
      break; 

    case 'insert': 
      $schueler->insert_row('');
      $show_data=true; 
      break; 
    
    case 'update': 
      $schueler->ID = $_POST["ID"];    
      $schueler->update_row($_POST["Name"],$_POST["Bemerkung"]); 
      $show_data=true;           
      break; 
  }
}

$info->print_screen_header($schueler->Title.' bearbeiten'); 
$info->print_link_table($schueler->table_name, 'sortcol=Name', $schueler->Titles); 


if ($show_data) {
    
  echo '
  <form action="edit_schueler.php" method="post">
  <table class="form-edit"> 
    <tr>    
    <label>
    <td class="form-edit form-edit-col1">ID:</td>  
    <td class="form-edit form-edit-col2">'.$schueler->ID.'</td>
    </label>
      </tr> 

    <tr>    
      <label>
      <td class="form-edit form-edit-col1">Name:</td>  
      <td class="form-edit form-edit-col2"><input type="text" name="Name" value="'.$schueler->Name.'" size="80" autofocus="autofocus" oninput="changeBackgroundColor(this)"required></td>
      </label>
    </tr> 

    <tr>    
      <label>
      <td class="form-edit form-edit-col1">Bemerkung:</td>  
      <td class="form-edit form-edit-col2">

      <textarea name="Bemerkung" rows=2 cols=120 oninput="changeBackgroundColor(this)">'.htmlentities($schueler->Bemerkung).'</textarea> 


      </td>
      
      </label>
    </tr> 

    <tr> 
      <td class="form-edit form-edit-col1"></td> 
      <td class="form-edit form-edit-col2"><input class="btnSave" type="submit" name="senden" value="Speichern">
      </td>
    </tr> 

    <input type="hidden" name="option" value="update">     
    <input type="hidden" name="title" value="Schüler">    
    <input type="hidden" name="ID" value="' . $schueler->ID. '">

  </form>

  ';
  ?> 

  <tr> 
  <td class="form-edit form-edit-col1">Daten anzeigen: <br /> <br />

  <input type="radio" id="opt_Schwierigkeitsgrad" name="target_form" value="Schwierigkeitsgrad" onclick="changeIframeSrc('subform1', 'edit_schueler_schwierigkeitsgrade.php?SchuelerID=<?php echo $schueler->ID; ?>');" checked>
  <label for="opt_Schwierigkeitsgrad">Instrumente / Schwierigkeitsgrade</label><br>

  <input type="radio" id="opt_Saetze" name="target_form" value="Saetze" onclick="changeIframeSrc('subform1', 'edit_schueler_saetze.php?SchuelerID=<?php echo $schueler->ID; ?>');">
  <label for="opt_Saetze">Verknüpfte Noten</label><br>
  
  <input type="radio" id="opt_Material" name="target_form" value="Material" onclick="changeIframeSrc('subform1', 'edit_schueler_materials.php?SchuelerID=<?php echo $schueler->ID; ?>');">
  <label for="opt_Material">Verknüpfte Materialien</label><br>



  </td> 
  <td class="form-edit form-edit-col2">
    <iframe src="edit_schueler_schwierigkeitsgrade.php?SchuelerID=<?php echo $schueler->ID; ?>&source=iframe" height="300" id="subform1" name="Info" class="form-iframe-var2"></iframe>
  </td>
  </tr> 


  </table> 

  <?php 

  $info->print_link_delete_row2($schueler->table_name, $schueler->ID, $schueler->Title, false); 

} 
else {
  $info->print_user_error(); 
}


include('foot.php');

?>
