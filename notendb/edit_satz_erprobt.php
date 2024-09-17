
<?php 
include('head_raw.php');
include('cl_satz_erprobt.php');
include('cl_erprobt.php');
include("cl_satz.php"); 
include("cl_html_info.php"); 

$satz = new Satz();
$satzErprobt = new SatzErprobt();
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
      $satzErprobt->insert_row();
      $show_data=true; 
      break; 
    
    case 'update': 
      $satzErprobt->ID = $_POST["ID"];    
      $satzErprobt->update_row(
        $_POST["SatzID"],        
        $_POST["ErprobtID"],
        $_POST["Jahr"], 
        $_POST["Bemerkung"]
      ); 

      $show_data=false; // statt Formular Liste anzeigen           
      break; 
  }
}

?> 

<form action="" method="post">
<table class="eingabe"> 
<tr>    
  <label>
     <td class="eingabe">Erprobt: </td>
     <td class="eingabe">
      <?php 
      $erprobt = new Erprobt(); 
      $erprobt ->print_select($satzErprobt->ErprobtID); 
      ?>
      Jahr: 
      <input type="text" name="Jahr" value="<?php echo $satzErprobt->Jahr; ?>" size="10" oninput="changeBackgroundColor(this)"></td>
  
      <?php
      // XXX 
      // $info->print_satzErprobt_edit($satzErprobttyp->table_name, $satzErprobt->LinktypeID, $satzErprobttyp->Title, true, ' | '); 
      // $info->print_satzErprobt_table($satzErprobttyp->table_name,'sortcol=Name',$satzErprobttyp->Titles,true,'',' | ');    
      // $info->print_satzErprobt_insert($satzErprobttyp->table_name,$satzErprobttyp->Title,true);        
      ?>
      </td>
   </label>
  </tr>

  <tr>    
  <label>
  <td class="eingabe">Bemerkung:</td>  
  <td class="eingabe"><input type="text" name="Bemerkung" value="<?php echo htmlentities($satzErprobt->Bemerkung); ?>" size="70" oninput="changeBackgroundColor(this)"></td>
  </label>
  </tr> 

  <tr>
  <td class="eingabe"></td>
  <td class="eingabe"><input class="btnSave" type="submit" value="Speichern"></td>  
</tr>
  
  <tr> 
  <td class="eingabe"></td>
  <td class="eingabe">
      <a href="edit_satz_erprobte.php?SatzID=<?php echo $satzErprobt->SatzID; ?>" class="form-link">Zurück zur Tabelle</a>     
      <?php 


      // XXX $info->print_satzErprobt_delete_row($satzErprobt->table_name, $satzErprobt->ID, $satzErprobt->Title, false); 
      $info->option_linktext=1; 
      $info->print_link_table('erprobt','sortcol=Name','Erprobt-Attribute',true,'');  

      ?>

  </td>
  </tr>


  <tr>
  <td class="eingabe">
<?php

$info->print_link_delete_row2($satzErprobt->table_name, $satzErprobt->ID, '', false); 

?>

  </td>
  <td class="eingabe"></td>  
</tr>


 </table> 

 <input type="hidden" name="SatzID" value="<?php echo $satzErprobt->SatzID; ?>"> 
 <input type="hidden" name="ID" value="<?php echo $satzErprobt->ID; ?>">  
 <input type="hidden" name="option" value="update">

</form>

<?php 

include('foot_raw.php');

?>
