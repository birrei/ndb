
<?php 
$PageTitle="Status"; 
include_once('head.php');
include_once("classes/class.status.php");
include_once("classes/class.htmlinfo.php");


$status = new Status();
$info= new HTML_Info(); 

$option=$_REQUEST["option"];

$show_data=true; 

$ID=null; 
$Name = ''; 

switch($option) {

  case 'insert': 

    $status->insert_row($Name);
    $ID=$status->ID; 
    break; 

  case 'edit': // über "Bearbeiten"-Link
    $status->ID=$_GET["ID"];
    $status->load_row(); 
    $ID = $status->ID; 
    $Name = $status->Name;     
    break; 
  
  case 'update': 
    $ID=$_POST["ID"]; 
    $Name=$_POST["Name"];     
    $status->ID = $ID;    
    $status->update_row($Name);
    $Name=$status->Name;        
    break; 

  case 'delete_1': 
    $ID=$_REQUEST["ID"]; 
    $status->ID = $ID;  
    $status->load_row(); 
    $Name=$status->Name; 
    
    if($status->is_deletable()) {
      $info->print_form_confirm('edit_status.php',$ID,'delete_2','Löschung'); 
    } else {
      $info->print_warning($status->infotext); 
    }
    $show_data=true;      
    break; 

  case 'delete_2': 
    $ID=$_REQUEST["ID"]; 
    $status->ID = $ID;  
    $status->delete(); 
    $info->print_info($status->infotext); 
    $show_data=false; 
    break; 
}

$info->print_screen_header($status->Title.' bearbeiten'); 

$info->print_link_table('status', 'sortcol=Name', $status->Titles,false);

if (!$show_data) {goto pagefoot;}

?>


<form action="#" method="post">
<table class="form-edit" width="100%"> 
  <tr>    
    <td class="form-edit form-edit-col1">ID:</td>  
    <td class="form-edit form-edit-col2"><?php echo $ID; ?></td>
  </tr> 
  <tr>    
    <label>
    <td class="form-edit form-edit-col1">Name:</td>  
    <td class="form-edit form-edit-col2"><input type="text" name="Name" value="<?php echo htmlentities($status->Name); ?>" size="100%" required="required" autofocus="autofocus" oninput="changeBackgroundColor(this)"></td>
    </label>
  </tr>     
  <tr> 
    <td class="form-edit form-edit-col1"></td> 
    <td class="form-edit form-edit-col2"><input class="btnSave" type="submit" name="senden" value="Speichern">  
    </td>
  </tr> 

  </table> 

  <input type="hidden" name="ID" value="<?php echo $ID; ?>">  
  <input type="hidden" name="option" value="update"> 

  </form>

  <p> 
  <form action="#" method="post">
  <input type="hidden" name="ID" value="<?php echo $ID; ?>">
  <input type="hidden" name="option" value="delete_1">      
  <input type="submit" name="senden" value="Status löschen">             
  </form>
  </p>

<?php 

pagefoot: 

include_once('foot.php');


?>
