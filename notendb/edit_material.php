
<?php 
$PageTitle='Material'; 
include_once('head.php');
include_once("classes/class.material.php");
include_once("classes/class.materialtyp.php");
include_once("classes/class.sammlung.php");
include_once("classes/class.htmlinfo.php");

$MaterialtypID=(isset($_REQUEST["MaterialtypID"])?$_REQUEST["MaterialtypID"]:''); 

$SammlungID=(isset($_REQUEST["SammlungID"])?$_REQUEST["SammlungID"]:''); 

$material = new Material();
$info= new HTML_Info(); 

$option=isset($_REQUEST["option"])?$_REQUEST["option"]:'edit';
$show_data=true; 

switch($option) {
  case 'edit': // über "Bearbeiten"-Link
    $material->ID=$_GET["ID"];
    if ($material->load_row()) {
      $SammlungID=$material->SammlungID;      
    }
    break; 

  case 'insert': 
    $material->insert_row($MaterialtypID, $SammlungID);
    break; 
  
  case 'update': 
    $material->ID = $_POST["ID"];    
    $material->update_row(
        $MaterialtypID
        , $_POST["Name"]        
        , $_POST["Bemerkung"]  
        , $SammlungID        
        )
        ;
    $show_data=true;           
    break; 

  case 'delete_1': 
    $material->ID = $_REQUEST["ID"];  
    $material->load_row(); 
    if($material->is_deletable()) {
      $info->print_form_confirm(basename(__FILE__),$material->ID,'delete_2','Löschung', 
                      'Soll Material ID: '.$material->ID.', Name: "'.$material->Name.'" wirklich gelöscht werden?');        
    } 

    $show_data=true;      
    break; 

  case 'delete_2': 
    $material->ID = $_POST["ID"];  
    $material->delete(); 
    $show_data=false; 
    break; 

  case 'copy': 
    $ID_ref=$_REQUEST["ID"]; 
    $material->ID=$ID_ref; 
    $material->copy();   
    $material->load_row();
    $SammlungID = $material->SammlungID;        
    $info->print_info_copy($material->Title, $ID_ref, $material->ID, 'edit_material'); 
    $show_data=true; 
    break;       
  default: 
    $show_data=false;   
}

$info->print_screen_header($material->Title.' bearbeiten'); 

$info->print_link_table('v_material', 'sortcol=Name&show_filter', $material->Titles,false);

if (!$show_data) {goto pagefoot;}


echo '
<form action="edit_material.php" method="post">
<table class="form-edit" width="100%"> 
  <tr>    
  <label>
  <td class="form-edit form-edit-col1">ID:</td>  
  <td class="form-edit form-edit-col2">'.$material->ID.'</td>
  </label>
    </tr> 


  <tr>    
<label>  
  <td class="form-edit form-edit-col1">Materialtyp:</td>  
  <td class="form-edit form-edit-col2">  
        '; 
        $materialtypen = new Materialtyp();
        $materialtypen->print_select($material->MaterialtypID); 

  echo ' </label>  &nbsp;
      '; 

      $info->print_link_edit($materialtypen->table_name, $material->MaterialtypID,$materialtypen->Title, true); 
      $info->print_link_table($materialtypen->table_name,'sortcol=Name',$materialtypen->Titles,true,'');    
      $info->print_link_insert($materialtypen->table_name,$materialtypen->Title,true); 


echo '</td>
  </tr> 

  <tr>    
    <label>
    <td class="form-edit form-edit-col1">Name:</td>  
    <td class="form-edit form-edit-col2"><input type="text" name="Name" value="'.htmlentities($material->Name).'" size="100%" required="required" autofocus="autofocus" oninput="changeBackgroundColor(this)"></td>
    </label>
  </tr>     
  <tr>    
    <label>
    <td class="form-edit form-edit-col1">Bemerkung:</td>  
    <td class="form-edit form-edit-col2">
      <textarea name="Bemerkung" rows=2 cols=120 oninput="changeBackgroundColor(this)">'.htmlentities($material->Bemerkung).'</textarea> 
    </td>
    </label>
  </tr> 

  '; 

    echo '   
    <tr>    
    <label>  
    <td class="form-edit form-edit-col1">Sammlung:</td>  
    <td class="form-edit form-edit-col2">  '; 
    $sammlung = new Sammlung();
    $sammlung->print_select($SammlungID); 

    $info->print_link_edit($sammlung->table_name, $SammlungID,$sammlung->Title, true); 

    echo ' </label>  &nbsp;
        </td>
        </tr> 
      '; 

    echo '
      <tr> 
        <td class="form-edit form-edit-col1"></td> 
        <td class="form-edit form-edit-col2"><input class="btnSave" type="submit" name="senden" value="Speichern">  
        </td>
      </tr> '; 

  ?>

  <tr> 
    <td class="form-edit form-edit-col1">Daten anzeigen:<br><br>

    
      <input type="radio" id="Schwierigkeitsgrade" name="target_form" value="Schwierigkeitsgrade" onclick="changeIframeSrc('subform1', 'edit_material_schwierigkeitsgrade.php?MaterialID=<?php echo $material->ID; ?>');" checked>
      <label for="Schwierigkeitsgrade">Schwierigkeitsgrade</label><br>


      <input type="radio" id="Besonderheiten" name="target_form" value="Besonderheiten" onclick="changeIframeSrc('subform1', 'edit_material_lookups.php?MaterialID=<?php echo $material->ID; ?>');">
      <label for="Besonderheiten">Besonderheiten</label><br>

      <input type="radio" id="Schueler" name="target_form" value="Schueler" onclick="changeIframeSrc('subform1', 'edit_material_schuelers.php?MaterialID=<?php echo $material->ID; ?>');">
      <label for="Schueler">Schüler</label>    





  </td> 
  <td class="form-edit form-edit-col2">
    <iframe src="edit_material_schwierigkeitsgrade.php?MaterialID=<?php echo $material->ID; ?>&source=iframe" height="300" id="subform1" name="Material" class="form-iframe-var2"></iframe>
  </td>
  </tr> 


  <input type="hidden" name="option" value="update"> 
  <input type="hidden" name="title" value="Material">          
  <input type="hidden" name="ID" value="<?php echo $material->ID; ?>">
  </form>
  <br>

<?php 


echo 
'
  <tr> 
    <td class="form-edit form-edit-col1"></td> 
    <td class="form-edit form-edit-col2">
    <br>'; 
    $info->print_form_inline('delete_1',$material->ID,$material->Title, 'löschen'); 
    $info->print_form_inline('copy',$material->ID,$material->Title, 'kopieren'); 
    echo '
    </td>
  </tr>
  
  </table> 

';

// echo 
// '<p> <form action="edit_material.php" method="post">
// <input type="hidden" name="ID" value="' . $material->ID. '">
// <input type="hidden" name="option" value="copy">      
// <input type="hidden" name="title" value="Material"> 
// <input type="submit" name="senden" value="Material kopieren">             
// </form>
// </p>
// '; 



// echo 
// '<p> <form action="edit_material.php" method="post">
// <input type="hidden" name="ID" value="' . $material->ID. '">
// <input type="hidden" name="option" value="delete_1">      
// <input type="hidden" name="title" value="Material"> 
// <input type="submit" name="senden" value="Material löschen">             
// </form></p>
// '; 


   

pagefoot: 

include_once('foot.php');


?>
