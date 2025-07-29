
<?php 
include('head_raw.php');
include('classes/class.satz_erprobt.php');
include('classes/class.erprobt.php');
include("classes/class.satz.php"); 
include("cl_html_info.php"); 


$satzErprobt = new SatzErprobt();
// $satzErprobt->SatzID = $_GET["SatzID"]; 

$info= new HtmlInfo(); 

$show_data=false; 

if (isset($_REQUEST["option"])) {
  switch($_REQUEST["option"]) {
    case 'edit': // über "Bearbeiten"-Link
      $satzErprobt->ID=$_GET["ID"];
      if ($satzErprobt->load_row()) {
        $show_data=true;       
      }
      break; 

    case 'insert':       
      $satzErprobt->SatzID = $_GET["SatzID"];         
      // $satzErprobt->insert_row();
      break; 
    
    case 'update': 
      if ($_POST["ID"]=='') {
        $satzErprobt->SatzID = $_REQUEST["SatzID"];         
        $satzErprobt->insert_row();   
        $satzErprobt->update_row(
          $_POST["SatzID"],        
          $_POST["ErprobtID"],
          $_POST["Jahr"], 
          $_POST["Bemerkung"]
        );          

      } else {
        $satzErprobt->ID = $_REQUEST["ID"];  
        $satzErprobt->update_row(
          $_POST["SatzID"],        
          $_POST["ErprobtID"],
          $_POST["Jahr"], 
          $_POST["Bemerkung"]
        );         
      }         
      break; 
  }
}

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
<tr>
  <td class="eingabe2 eingabe2_1"> </td>
  <td class="eingabe2 eingabe2_2">
    <?php
      $info->print_link_backToList('edit_satz_erprobte.php?SatzID='.$satzErprobt->SatzID); 
    ?>
  </td>  
  <td class="eingabe2 eingabe2_3"></td>    
</tr>
</table>

 </table> 

 <input type="hidden" name="SatzID" value="<?php echo $satzErprobt->SatzID; ?>"> 
 <input type="hidden" name="ID" value="<?php echo $satzErprobt->ID; ?>">  
 <input type="hidden" name="option" value="update">

</form>



<?php 

include('foot_raw.php');

?>
