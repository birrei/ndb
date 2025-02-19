
<?php 
include('head.php');
include("cl_sammlung.php");
include("cl_verlag.php");
include("cl_standort.php");
include("cl_html_info.php");

$sammlung = new Sammlung();

$info= new HtmlInfo(); 

$show_data=false; 

if (isset($_REQUEST["option"])) {
  switch($_REQUEST["option"]) {
    case 'edit': // über "Bearbeiten"-Link
      $sammlung->ID=$_GET["ID"];
      if ($sammlung->load_row()) {
        $show_data=true;       
      }
      break; 

    case 'insert': 
      $sammlung->insert_row(''); 
      $show_data=true; 
      break; 
    
    case 'update': 
      $Erfasst=(isset($_POST["Erfasst"])?1:0); 
      $sammlung->ID = $_POST["ID"];    
      $sammlung->update_row(
        $_POST["Name"]
        , $_POST["VerlagID"]
        , $_POST["StandortID"]
        // , $_POST["Bestellnummer"]
        , $_POST["Bemerkung"]
        , $Erfasst
      ); 
      $show_data=true;           
      break; 

    case 'copy': 
      $ID_ref=$_REQUEST["ID"]; 
      $sammlung->ID=$ID_ref; 
      $sammlung->copy();   
      $sammlung->load_row();       
      $info->print_info_copy($sammlung->Title, $ID_ref, $sammlung->ID, 'edit_sammlung'); 
      $show_data=true; 
    break; 

    case 'delete_1': 
        $sammlung->ID = $_REQUEST["ID"];  
        $sammlung->load_row(); 

        $info->print_warning('Soll Sammlung ID: '.$sammlung->ID.', Name: "'.$sammlung->Name.'" wirklich gelöscht werden?'); 
        echo 
        '<p> <form action="edit_sammlung.php" method="post">
        <input type="hidden" name="ID" value="' . $sammlung->ID. '">
        <input type="hidden" name="option" value="delete_2">      
        <input type="hidden" name="title" value="Sammlung"> 
        <input type="submit" name="senden" value="Löschung bestätigen">             
        </form></p>
        '; 

        $show_data=true;      
        break;      
      
    case 'delete_2': 
      $sammlung->ID = $_POST["ID"];  
      $sammlung->delete(); 
      $info->print_info('Die Sammlung wurde gelöscht.'); 
      $show_data=false; 
      break;       

  }
}

$info->print_screen_header($sammlung->Title.' bearbeiten'); 
$info->print_link_table('v_sammlung', 'sortcol=ID&sortorder=DESC', $sammlung->Titles,false,'&show_filter'); 
$info->print_link_insert($sammlung->table_name, $sammlung->Title, false); 

if (!$show_data) {goto pagefoot;}


echo '
<form action="edit_sammlung.php" method="post">
<table class="form-edit"> 
<tr>    
<label>
<td class="form-edit form-edit-col1">ID:</td>  
<td class="form-edit form-edit-col2">'.$sammlung->ID.' 
    &nbsp; <label><input type="checkbox" name="Erfasst" '.($sammlung->Erfasst==1?'checked':'').'> Vollständig erfasst </label> 
</td>
</label>
  </tr> 
  '; 
echo '
  <tr>    
    <label>
    <td class="form-edit form-edit-col1">Name:</td>  
    <td class="form-edit form-edit-col2"><input type="text" name="Name" value="'.htmlentities($sammlung->Name).'" size="100" maxlength="100" required="required" autofocus="autofocus" oninput="changeBackgroundColor(this)"> (max. 100 Zeichen)</td>
    </label>
  </tr> 
  '; 
echo '   
  <tr>    
  <label>
  <td class="form-edit form-edit-col1">Verlag:</td>  
  <td class="form-edit form-edit-col2">
  
  <!-- Auswahlliste Verlag  -->         
        '; 
        $verlage = new Verlag();
        $verlage->print_select($sammlung->VerlagID); 

  echo ' </label>  &nbsp;
      '; 

  $info->print_link_edit($verlage->table_name, $sammlung->VerlagID,$verlage->Title, true); 
  $info->print_link_table($verlage->table_name,'sortcol=Name',$verlage->Titles,true,'');    
  $info->print_link_insert($verlage->table_name,$verlage->Title,true); 

echo '
  </tr>

  <tr>    
  <label>
  <td class="form-edit form-edit-col1">Standort:</td>  
  <td class="form-edit form-edit-col2">   
        '; 
        $standorte = new Standort();
        $standorte->print_select($sammlung->StandortID); 

  echo '</label>  &nbsp;';

  $info->print_link_edit($standorte->table_name, $sammlung->StandortID,$standorte->Title, true); 
  $info->print_link_table($standorte->table_name,'sortcol=Name',$standorte->Titles,true,'');    
  $info->print_link_insert($standorte->table_name,$standorte->Title,true); 

  echo '
  </tr>

  <tr>    
    <label>
    <td class="form-edit form-edit-col1">Bemerkung:</td>
    <td class="form-edit form-edit-col2">
    <textarea name="Bemerkung" rows=2 cols=120 oninput="changeBackgroundColor(this)">'.htmlentities($sammlung->Bemerkung).'</textarea> 
    
    </td>
    </label>
  </tr> 

  <tr> 
    <td class="form-edit form-edit-col1"></td> 
    <td class="form-edit form-edit-col2">
      <input class="btnSave" type="submit" name="senden" value="Speichern">     
    
  </td>

  </tr> 
      <input type="hidden" name="ID" value="' . $sammlung->ID. '">
      <input type="hidden" name="option" value="update">      
      <input type="hidden" name="title" value="Sammlung"> 
  </form>

    <tr> 
      <td class="form-edit form-edit-col1">Musikstücke:
      <p> <a href="edit_musikstueck.php?SammlungID='.$sammlung->ID.'&option=insert&title=Musikstück" target="_blank" class="form-link form-link-switch" onfocus="linkStyleFocus(this)">Musikstück hinzufügen</a></p>
      <p> <a href="edit_sammlung_musikstuecke.php?SammlungID='.$sammlung->ID.'" target="musikstuecke" class="form-link form-link-switch">Aktualisieren - &gt;</a></p>
      </td> 
      <td class="form-edit form-edit-col2">
          <iframe src="edit_sammlung_musikstuecke.php?SammlungID='.$sammlung->ID.'"  height="150" name="musikstuecke" class="form-iframe-var2"></iframe>
    </td>
    </tr> 

    <tr> 
      <td class="form-edit form-edit-col1">Materialien:
      <p> <a href="edit_material.php?SammlungID='.$sammlung->ID.'&option=insert&title=Material" target="_blank" class="form-link form-link-switch" onfocus="linkStyleFocus(this)">Material hinzufügen</a></p>
      <p> <a href="edit_sammlung_materials.php?SammlungID='.$sammlung->ID.'" target="material" class="form-link form-link-switch">Aktualisieren - &gt;</a></p>
      </td> 
      <td class="form-edit form-edit-col2">
          <iframe src="edit_sammlung_materials.php?SammlungID='.$sammlung->ID.'"  height="150" name="material" class="form-iframe-var2"></iframe>
    </td>
    </tr> 
  ';

  ?>
  
  <tr> 
    <td class="form-edit form-edit-col1">Daten anzeigen: <br /> <br />
      <input type="radio" id="Besonderheiten" name="target_form" value="Besonderheiten" onclick="changeIframeSrc('subform1', 'edit_sammlung_lookups.php?SammlungID=<?php echo $sammlung->ID; ?>');" checked>
      <label for="Besonderheiten">Besonderheiten</label><br>
      <input type="radio" id="Links" name="target_form" value="Links" onclick="changeIframeSrc('subform1', 'edit_sammlung_links.php?SammlungID=<?php echo $sammlung->ID; ?>');">
      <label for="Links">Links</label>
    </td>
    <td class="form-edit form-edit-col2">
          <iframe src="edit_sammlung_lookups.php?SammlungID=<?php echo $sammlung->ID; ?>" height="200" name="subform1" id="subform1" class="form-iframe-var2"></iframe>
    </td>
    </tr> 

    
  <?php 
  echo 
  '      
  </table>



  '; 
 

    echo '<p> <form action="edit_sammlung.php" method="post">
          <input type="hidden" name="ID" value="' . $sammlung->ID. '">
          <input type="hidden" name="option" value="copy">      
          <input type="hidden" name="title" value="Sammlung"> 
          <input type="submit" name="senden" value="Sammlung kopieren">             
      </form></p>
    '; 



    echo 
    '<p> <form action="edit_sammlung.php" method="post">
    <input type="hidden" name="ID" value="' . $sammlung->ID. '">
    <input type="hidden" name="option" value="delete_1">      
    <input type="hidden" name="title" value="Sammlung"> 
    <input type="submit" name="senden" value="Sammlung löschen">             
    </form></p>
    '; 
    
    


  echo '<p><a href=dataclearing.php?SammlungID='.$sammlung->ID.' target="_blank">Sammel-Updates</a><p>'; 



pagefoot: 

include('foot.php');

?>
