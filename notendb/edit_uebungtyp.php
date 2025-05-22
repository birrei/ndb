
<?php 
$PageTitle='Übung Typ'; 
include('head.php');;
include_once("classes/class.htmlinfo.php");
include_once("classes/class.uebungtyp.php");

$info= new HTML_Info(); 
$option=$_REQUEST["option"];
$show_data=true; 


switch($option) {

  case 'insert': 
    $uebungtyp = new UebungTyp();    
    $uebungtyp->insert_row('');
    $option='update'; 
    break; 

  case 'edit': // über "Bearbeiten"-Link
    $uebungtyp = new UebungTyp();       
    $uebungtyp->ID=$_REQUEST["ID"];
    $uebungtyp->load_row();  
    $option='update';     
    break; 
  
  case 'update': 
    $uebungtyp = new UebungTyp();       
    $uebungtyp->ID=$_POST["ID"]; 
    $uebungtyp->update_row($_POST["Name"],$_POST["Einheit"]);  
    break; 

  case 'delete_1': 
    $uebungtyp = new UebungTyp();       
    $uebungtyp->ID = $_REQUEST["ID"];  
    $uebungtyp->load_row(); 
    $Name=$uebungtyp->Name; 
    $info->print_form_confirm('edit_uebungtyp.php',$uebungtyp->ID,'delete_2','Löschung'); 
    $show_data=true;      
    break; 

  case 'delete_2': 
    $uebungtyp = new UebungTyp();       
    $uebungtyp->ID=$_REQUEST["ID"]; 
    $uebungtyp->delete(); 
    $info->print_info($uebungtyp->infotext); 
    $show_data=false; 
    break; 
}


$info->print_screen_header($uebungtyp->Title.' bearbeiten'); 

$info->print_link_table('uebungtyp', 'sortcol=Name', $uebungtyp->Titles,false);

$info->print_form_inline('delete_1',$uebungtyp->ID,$uebungtyp->Title, 'löschen'); 

// $info->print_form_inline('copy',$uebungtyp->ID,$uebungtyp->Title, 'kopieren'); 


if (!$show_data) {goto pagefoot;}


echo '</p>
<form action="edit_uebungtyp.php" method="post">
<table class="form-edit" width="100%"> 
  <tr>    
    <label>
    <td class="form-edit form-edit-col1">ID:</td>  
    <td class="form-edit form-edit-col2">'.$uebungtyp->ID.'</td>
    </label>
  </tr> 

  <tr>    
    <label>
    <td class="form-edit form-edit-col1">Name:</td>  
    <td class="form-edit form-edit-col2"><input type="text" name="Name" value="'.htmlentities($uebungtyp->Name).'" size="40%" required="required" autofocus="autofocus" oninput="changeBackgroundColor(this)"></td>
    </label>
  </tr>    

  <tr>    
    <label>
    <td class="form-edit form-edit-col1">Einheit:</td>  
    <td class="form-edit form-edit-col2"><input type="text" name="Einheit" value="'.htmlentities($uebungtyp->Einheit).'" size="40%" required="required" autofocus="autofocus" oninput="changeBackgroundColor(this)"></td>
    </label>
  </tr>    

  <tr> 
      <td class="form-edit form-edit-col1"></td> 
      <td class="form-edit form-edit-col2"><input class="btnSave" type="submit" name="senden" value="Speichern">  
      </td>
    </tr> '; 

  ?>

  </table> 
  <input type="hidden" name="option" value="<?php echo $option; ?>"> 
  <input type="hidden" name="ID" value="<?php echo $uebungtyp->ID; ?>">
  </form>
  <br>

<?php 


   
// $info->print_link_delete_row2($uebungtyp->table_name, $uebungtyp->ID,'Uebung'); 

pagefoot: 

include('foot.php');


?>
