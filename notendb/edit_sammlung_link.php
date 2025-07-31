
<?php 
include_once('head_raw.php');
include_once('classes/class.linktype.php');
include_once("classes/class.link.php"); 
include_once("classes/class.htmlinfo.php"); 

$link = new Link();
$info= new HTML_Info(); 

$show_data=false; 


if (isset($_REQUEST["option"])) {
  switch($_REQUEST["option"]) {
    case 'edit': // über "Bearbeiten"-Link
      $link->ID=$_GET["ID"];
      $link->load_row(); 
      if ($link->load_row()) {
        $show_data=true;       
      }
      break; 

    case 'insert': 
      $link->SammlungID = $_GET["SammlungID"];         
      // $link->insert_row();
      $show_data=true; 
      break; 
    
    case 'update': 
      // $link=new Link();     
      $link->ID = $_POST["ID"];
      $link->SammlungID = $_POST["SammlungID"];          
      $link->update_row(
        $_POST["LinktypeID"],
        $_POST["Bezeichnung"], 
        $_POST["URL"]
      ); 

      $show_data=false; // statt Formular Liste anzeigen           
      break; 
  }
}

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
      $info->print_link_insert($linktyp->table_name,$linktyp->Title,true);        
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



  <tr>    
  <td class="eingabe2 eingabe2_1"></td>  
  <td class="eingabe2 eingabe2_2">
    <?php 

    $info->print_link_backToList('edit_sammlung_links.php?SammlungID='.$link->SammlungID);         
    ?>
    </td>
  </label>
  </tr> 



 </table> 

 <input type="hidden" name="SammlungID" value="<?php echo $link->SammlungID; ?>"> 
 <input type="hidden" name="ID" value="<?php echo $link->ID; ?>">  
 <input type="hidden" name="option" value="update">

</form>


<?php 



include_once('foot_raw.php');

?>
