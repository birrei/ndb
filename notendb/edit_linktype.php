
<?php 
$PageTitle='Linktyp'; 
include_once('head.php');
include_once("classes/class.linktype.php");
include_once("classes/class.htmlinfo.php");

$linktype = new Linktype();
$info= new HTML_Info(); 

$option=isset($_REQUEST["option"])?$_REQUEST["option"]:'edit';
$show_data=true; 

switch($option) {
  case 'edit': // über "Bearbeiten"-Link
    $linktype->ID=$_GET["ID"];
    $linktype->load_row(); 
    break; 

  case 'insert': 
    $linktype->insert_row('');
    $show_data=true; 
    break; 
  
  case 'update': 
    $linktype->ID = $_POST["ID"];    
    $linktype->update_row($_POST["Name"]); 
    $show_data=true;           
    break; 

  case 'delete_1': 
    $linktype->ID = $_REQUEST["ID"];  
    $linktype->load_row(); 
    $info->print_form_confirm(basename(__FILE__),$linktype->ID,'delete_2','Löschung');  
    $show_data=true;      
    break; 

  case 'delete_2': 
    $linktype->ID=$_REQUEST["ID"]; 
    if($linktype->delete()) {
      $show_data=false; 
    } else  {
      $show_data=true; 
    }
    break; 
    
  default: 
    $show_data=false;      
}






// if (isset($_REQUEST["option"])) {
//   switch($_REQUEST["option"]) {
//     case 'edit': // geöffnet über einen "Bearbeiten"-Link
//       $linktype->ID=$_GET["ID"]; 
//       if ($linktype->load_row()) {
//         $show_data=true;       
//       }      
//       break; 

//     case 'insert': 
//       $linktype->insert_row(''); 
//       $show_data=true; 
//       break; 
    
//     case 'update': 
//       $linktype->ID = $_POST["ID"];    
//       $linktype->update_row($_POST["Name"]); 
//       $show_data=true;          
//       break; 
//   }

// }

$info->print_screen_header($linktype->Title.' bearbeiten'); 
$info->print_link_table($linktype->table_name, 'sortcol=Name', $linktype->Titles); 

if (!$show_data) {goto pagefoot;}

echo '<p> 
<form action="edit_linktype.php" method="post">
<table class="form-edit"> 
  <tr>    
  <label>
  <td class="form-edit form-edit-col1">ID:</td>  
  <td class="form-edit form-edit-col2">'.$linktype->ID.'</td>
  </label>
    </tr> 

  <tr>    
    <label>
    <td class="form-edit form-edit-col1">Name:</td>  
    <td class="form-edit form-edit-col2"><input type="text" name="Name" value="'.$linktype->Name.'" size="45" maxlength="80" required="required" autofocus="autofocus" oninput="changeBackgroundColor(this)"></td>
    </label>
  </tr> 


  <tr> 
    <td class="form-edit form-edit-col1"></td> 
    <td class="form-edit form-edit-col2"><input class="btnSave" type="submit" name="senden" value="Speichern">

    </td>
  </tr> 


<input type="hidden" name="option" value="update">        
<input type="hidden" name="ID" value="' . $linktype->ID. '">

</form>

<tr> 
  <td class="form-edit form-edit-col1"></td> 
  <td class="form-edit form-edit-col2"><br>
  '; 
  $info->print_form_inline('delete_1',$linktype->ID,$linktype->Title, 'löschen'); 
  echo '     
  </td>
</tr> 

</table> 

</p> 

'; 



pagefoot: 
include_once('foot.php');


?>
