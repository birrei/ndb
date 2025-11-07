<?php 
include_once('classes/class.linktype.php');
include_once("classes/class.link.php"); 
include_once("classes/class.htmlinfo.php"); 

$link = new Link();
$info= new HTML_Info(); 

$show_data=true; 

$option=isset($_REQUEST["option"])?$_REQUEST["option"]:'edit';

switch($option) {
  case 'edit': // über "Bearbeiten"-Link
    $link->ID=$_GET["ID"];
    $link->load_row(); 
    break; 

  case 'insert': 
    $link->SammlungID = $_GET["SammlungID"];         
    $show_data=true; 
    break; 
  
  case 'update': 
    $link->ID = $_POST["ID"];
    $link->SammlungID = $_POST["SammlungID"];          
    $link->update_row(
      $_POST["LinktypeID"],
      $_POST["Bezeichnung"], 
      $_POST["URL"]
    ); 
    header('Location: edit_sammlung_links.php?SammlungID='.$link->SammlungID );
    exit;     
    break; 


  case 'delete_1': 
    $link->ID = $_REQUEST["ID"];  
    $link->load_row(); 
    if($link->is_deletable()) {
      $info->print_form_delete_confirm(basename(__FILE__), $link->Title, $link->ID, $link->Bezeichnung);   
    }       
    $show_data=true;      
    break; 

  case 'delete_2': 
    $link->ID=$_REQUEST["ID"]; 
    $link->delete(); 
    header('Location: edit_sammlung_links.php?SammlungID='.$link->SammlungID );
    exit;     
    break; 
    
  default: 
    $show_data=false;    

}

include_once('head_raw.php');

if (!$show_data) {goto pagefoot;}

?> 
<form action="" method="post">
<table class="eingabe2"> 
 
<tr>    
  <label>
     <td class="eingabe2 eingabe2_1">Typ: </td>
     <td class="eingabe2 eingabe2_2">
      <?php 
      $linktyp = new Linktype(); 
      $linktyp->print_select($link->LinktypeID); 
      ?>
      <?php
      $info->print_link_edit($linktyp->table_name, $link->LinktypeID, $linktyp->Title, true); 
      $info->print_link_table($linktyp->table_name,'sortcol=Name',$linktyp->Titles,true,'');    
      ?>
      </td>
   </label>
  </tr>

  <tr>    
  <label>
  <td class="eingabe2 eingabe2_1">Bezeichnung:</td>  
  <td class="eingabe2 eingabe2_2"><input type="text" name="Bezeichnung" value="<?php echo htmlentities($link->Bezeichnung); ?>" size="70" required="required" oninput="changeBackgroundColor(this)"></td>
  </label>
  </tr> 

  <tr>    
  <label>
  <td class="eingabe2 eingabe2_1">URL:</td>  
  <td class="eingabe2 eingabe2_2">
      <input type="text" name="URL" value="<?php echo $link->URL; ?>" size="70" required="required" oninput="changeBackgroundColor(this)">
    </td>
  </label>
  </tr> 

  <tr> 
  <td class="eingabe2 eingabe2_1">
  </td>
  <td class="eingabe2 eingabe2_2">
  <input class="btnSave" type="submit" value="Speichern">
  </td>
  </tr>

  
 <input type="hidden" name="SammlungID" value="<?php echo $link->SammlungID; ?>"> 
 <input type="hidden" name="ID" value="<?php echo $link->ID; ?>">  
 <input type="hidden" name="option" value="update">

 </form>


  <tr> 
  <td class="eingabe2 eingabe2_1">
  </td>
  <td class="eingabe2 eingabe2_2">
      <?php
        $info->print_form_inline('delete_1',$link->ID,$link->Title, 'löschen'); 
      ?>
  </td>
  </tr>



 </table> 


<?php 


pagefoot:
include_once('foot_raw.php');

?>
