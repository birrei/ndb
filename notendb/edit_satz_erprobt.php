<?php 
include_once('classes/class.satz_erprobt.php');
include_once('classes/class.erprobt.php');
include_once("classes/class.satz.php"); 
include_once("classes/class.htmlinfo.php"); 

$satzErprobt = new SatzErprobt();

$info= new HTML_Info(); 

$option=isset($_REQUEST["option"])?$_REQUEST["option"]:'edit';

$show_data=true; 

switch($option) {
  case 'edit': // über "Bearbeiten"-Link
    $satzErprobt->ID=$_GET["ID"];
    $satzErprobt->load_row(); 
    break; 

  case 'insert':       
    $satzErprobt->SatzID = $_GET["SatzID"];         
    break; 
  
  case 'update': 
    $satzErprobt->ID = $_POST["ID"];
    $satzErprobt->SatzID = $_REQUEST["SatzID"];         
    $satzErprobt->update_row(
      $_POST["SatzID"],        
      $_POST["ErprobtID"],
      $_POST["Jahr"], 
      $_POST["Bemerkung"]
    );    
    header('Location: edit_satz_erprobte.php?SatzID='.$satzErprobt->SatzID );
    exit;      
    break; 

  case 'delete_1': 
    $satzErprobt->ID = $_REQUEST["ID"];  
    $satzErprobt->load_row(); 
    $info->print_form_delete_confirm(basename(__FILE__), 'Erprobt-Eintrag', $satzErprobt->ID, '');   
    $show_data=true;      
    break; 

  case 'delete_2': 
    $satzErprobt->ID=$_REQUEST["ID"];
    $satzErprobt->load_row();      
    $satzErprobt->delete(); 
    header('Location: edit_satz_erprobte.php?SatzID='.$satzErprobt->SatzID );
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
  <td class="eingabe2 eingabe2_1">Erprobt:  </td>
  <td class="eingabe2 eingabe2_2">
    <?php 
      $erprobt = new Erprobt(); 
      $erprobt ->print_select($satzErprobt->ErprobtID); 
      ?>
  </td>  
  <td class="eingabe2 eingabe2_3">
    <?php 
      // $info->option_linktext=1; 
      $info->print_link_table('erprobt','sortcol=Name','Erprobt-Attribute',true,'');  
    ?>
  </td>    
</tr>


<tr>
  <td class="eingabe2 eingabe2_1">Jahr: </td>
  <td class="eingabe2 eingabe2_2">
    <input type="text" name="Jahr" value="<?php echo $satzErprobt->Jahr; ?>" size="10" oninput="changeBackgroundColor(this)">
  </td>  
  <td class="eingabe2 eingabe2_3"></td>    
</tr>


<tr>
  <td class="eingabe2 eingabe2_1">Bemerkung:</td>
  <td class="eingabe2 eingabe2_2">
    <input type="text" name="Bemerkung" value="<?php echo htmlentities($satzErprobt->Bemerkung); ?>" size="70" oninput="changeBackgroundColor(this)">
  </td>  
  <td class="eingabe2 eingabe2_3"></td>    
</tr>
<tr>
  <td class="eingabe2 eingabe2_1"> 
  </td>
  <td class="eingabe2 eingabe2_2"><input class="btnSave" type="submit" value="Speichern"></td>  
  <td class="eingabe2 eingabe2_3"></td>    
</tr>

 <input type="hidden" name="SatzID" value="<?php echo $satzErprobt->SatzID; ?>"> 
 <input type="hidden" name="ID" value="<?php echo $satzErprobt->ID; ?>">  
 <input type="hidden" name="option" value="update">

</form>

<tr> 
  <td class="eingabe2 eingabe2_1">
  </td>
  <td class="eingabe2 eingabe2_2">
      <?php
        $info->print_form_inline('delete_1',$satzErprobt->ID,'Erprobt-Eintrag', 'löschen'); 
      ?>
  </td>
  </tr>

</table>



<?php 
pagefoot: 
include_once('foot_raw.php');
?>
