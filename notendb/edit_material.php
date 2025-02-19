
<?php 

include('head.php');
include("cl_material.php");
include("cl_materialtyp.php");
include("cl_sammlung.php");
include("cl_html_info.php");

$MaterialtypID=(isset($_REQUEST["MaterialtypID"])?$_REQUEST["MaterialtypID"]:''); 

$SammlungID=(isset($_REQUEST["SammlungID"])?$_REQUEST["SammlungID"]:''); 

$material = new Material();
$info= new HtmlInfo(); 

$show_data=false; 

if (isset($_REQUEST["option"])) {
  switch($_REQUEST["option"]) {
    case 'edit': // über "Bearbeiten"-Link
      $material->ID=$_GET["ID"];
      if ($material->load_row()) {
        $show_data=true;  
        $SammlungID=$material->SammlungID;      
      }
      break; 

    case 'insert': 

      $material->insert_row($MaterialtypID, $SammlungID);
      $show_data=true; 
      break; 
    
    case 'update': 
      $material->ID = $_POST["ID"];    
      $material->update_row(
          $_POST["MaterialtypID"]   
          , $_POST["Name"]        
          , $_POST["Bemerkung"]  
          // , $_POST["SammlungID"]    
          , $SammlungID        
          )
          ;
      $show_data=true;           
      break; 

    case 'delete_1': 
      $material->ID = $_REQUEST["ID"];  
      $material->load_row(); 
      
      if($material->is_deletable()) {

        $info->print_info('Soll Material ID: '.$material->ID.', Name: "'.$material->Name.'" wirklich gelöscht werden?'); 
        echo 
        '<p> <form action="edit_material.php" method="post">
        <input type="hidden" name="ID" value="' . $material->ID. '">
        <input type="hidden" name="option" value="delete_2">      
        <input type="hidden" name="title" value="Material"> 
        <input type="submit" name="senden" value="Löschung bestätigen">             
        </form></p>
        '; 
      } else {
        $info->print_warning($material->infotext); 
      }
      $show_data=true;      
      break; 
  
    case 'delete_2': 
      $material->ID = $_POST["ID"];  
      $material->delete(); 
      $info->print_info('Der Datensatz wurde gelöscht.'); 
      $show_data=false; 
      break; 

  }
}

$info->print_screen_header($material->Title.' bearbeiten'); 

$info->print_link_table('v_material', 'sortcol=Name&show_filter', $material->Titles,false);

if (!$show_data) {goto pagefoot;}


echo '</p>
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
        if ($SammlungID!='') {
          echo '   
              <tr>    
            <label>  
              <td class="form-edit form-edit-col1">Sammlung:</td>  
              <td class="form-edit form-edit-col2">  '; 
          $sammlung = new Sammlung();
          $sammlung->print_select($SammlungID); 


          echo ' </label>  &nbsp;
              </td>
              </tr> 
            '; 
            // XXX gehe zu Sammlung
        }
echo '
  <tr> 
    <td class="form-edit form-edit-col1"></td> 
    <td class="form-edit form-edit-col2"><input class="btnSave" type="submit" name="senden" value="Speichern">  
    </td>
  </tr> 
'; 

  ?>

  <tr> 

    <td class="form-edit form-edit-col1">Schüler:</td> 
  </td> 
  <td class="form-edit form-edit-col2">
    <iframe src="edit_material_schuelers.php?MaterialID=<?php echo $material->ID; ?>&source=iframe" height="300" id="subform1" name="Material" class="form-iframe-var2"></iframe>
  </td>
  </tr> 

  </table> 
  <input type="hidden" name="option" value="update"> 
  <input type="hidden" name="title" value="Material">          
  <input type="hidden" name="ID" value="<?php echo $material->ID; ?>">
  </form>
  <br>

<?php 



echo 
'<p> <form action="edit_material.php" method="post">
<input type="hidden" name="ID" value="' . $material->ID. '">
<input type="hidden" name="option" value="delete_1">      
<input type="hidden" name="title" value="Material"> 
<input type="submit" name="senden" value="Material löschen">             
</form></p>
'; 


   
// $info->print_link_delete_row2($material->table_name, $material->ID,'Material'); 

pagefoot: 

include('foot.php');


?>
