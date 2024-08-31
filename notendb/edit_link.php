
<?php 
include('head_raw.php');
include('cl_linktype.php');
include("cl_link.php"); 
include("cl_html_info.php"); 

/* Datei bei erstem Aufruf  über Link "Hinzufügen" aus edit_sammlung_list_links.php */
// $SammlungID=$_REQUEST["SammlungID"]; 

// $ID='';
// $Bezeichnung=''; 
// $URL=''; 
// $LinktypeID=''; 
// $next_option='insert';

$link = new Link();
$info= new HtmlInfo(); 

$show_data=false; 


if (isset($_REQUEST["option"])) {
  switch($_REQUEST["option"]) {
    case 'edit': // über "Bearbeiten"-Link
      $link->ID=$_GET["ID"];
      if ($link->load_row()) {
        $show_data=true;       
      }
      break; 

    case 'insert': 
      $link->SammlungID = $_GET["SammlungID"];         
      $link->insert_row();
      $show_data=true; 
      break; 
    
    case 'update': 
      $link->ID = $_POST["ID"];    
      $link=new Link();     
      $link->ID = $_POST["ID"];    
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
<table class="eingabe"> 
<tr>    
  <label>
     <td class="eingabe">Typ: </td>
     <td class="eingabe">
      <?php 
      $linktyp = new Linktype(); 
      $linktyp->print_select($link->LinktypeID); 
      ?>

      <?php
      $info->print_link_edit($linktyp->table_name, $link->LinktypeID, $linktyp->Title, true, ' | '); 
      $info->print_link_table($linktyp->table_name,'sortcol=Name',$linktyp->Titles,true,'',' | ');    
      $info->print_link_insert($linktyp->table_name,$linktyp->Title,true);        
      ?>
      </td>
   </label>
  </tr>

  <tr>    
  <label>
  <td class="eingabe">Bezeichnung:</td>  
  <td class="eingabe"><input type="text" name="Bezeichnung" value="<?php echo htmlentities($link->Bezeichnung); ?>" size="100" required="required" oninput="changeBackgroundColor(this)"></td>
  </label>
  </tr> 

  <tr>    
  <label>
  <td class="eingabe">URL:</td>  
  <td class="eingabe"><input type="text" name="URL" value="<?php echo $link->URL; ?>" size="100" required="required" oninput="changeBackgroundColor(this)"></td>
  </label>
  </tr> 

  <tr> 
  <td class="eingabe"><input type="submit" value="Speichern"></td>
  <td class="eingabe">
  <a href="edit_sammlung_list_links.php?SammlungID=<?php echo $link->SammlungID; ?>">Liste anzeigen</a> | 
  <?php 
  $info->print_link_delete_row($link->table_name, $link->ID, $link->Title, false); 
  ?>

  </td>
  </tr>
 </table> 

 <input type="hidden" name="SammlungID" value="<?php echo $link->SammlungID; ?>"> 
 <input type="hidden" name="ID" value="<?php echo $link->ID; ?>">  
 <input type="hidden" name="option" value="update">

</form>

<?php 



include('foot_raw.php');

?>
