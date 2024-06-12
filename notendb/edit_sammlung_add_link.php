
<?php 
include('head_raw.php');
include('cl_linktype.php');
include("cl_link.php"); 
include("cl_html_info.php"); 

/* Datei bei erstem Aufruf  über Link "Hinzufügen" aus edit_sammlung_list_links.php */
$SammlungID=$_REQUEST["SammlungID"]; 

$ID='';
$Bezeichnung=''; 
$URL=''; 
$LinktypeID=''; 
$next_option='insert'; 

if (isset($_REQUEST["option"])) {
  if ($_REQUEST["option"]=='insert') {
    // Quelle: dieses Formular, _POST 

    $link=new Link();     
    $link->SammlungID = $_GET["SammlungID"];    
    $link->insert_row(
      $_POST["LinktypeID"],
      $_POST["Bezeichnung"], 
      $_POST["URL"]
    ); 
    $ID=$link->ID; 
    $LinktypeID = $link->LinktypeID; 
    $Bezeichnung = $link->Bezeichnung; 
    $URL = $link->URL; 
    $next_option='update';     

    // $info= new HtmlInfo(); 
    // $info->print_action_info($link->ID, 'insert');     
  }
  if ($_REQUEST["option"]=='edit') {
    // Quelle: edit_sammlung_list_links.php > Tabelle > "Bearbeiten"
     
    $link=new Link();  
    $link->ID=$_GET["ID"]; 
    $link->load_row(); 
    $ID=$link->ID; 
    $LinktypeID = $link->LinktypeID; 
    $Bezeichnung = $link->Bezeichnung; 
    $URL = $link->URL; 
    $next_option='update';     
  }
  if ($_REQUEST["option"]=='update') {
    // Quelle: dieses Formular, _POST
    // echo $_POST["ID"];
    $link=new Link();     
    $link->ID = $_POST["ID"];    
    $link->update_row(
      $_POST["LinktypeID"],
      $_POST["Bezeichnung"], 
      $_POST["URL"]
    ); 
    $ID=$link->ID; 
    $SammlungID= $link->SammlungID; 
    $LinktypeID = $link->LinktypeID; 
    $Bezeichnung = $link->Bezeichnung; 
    $URL = $link->URL; 
    $next_option='update';     

    
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
      $linktyp->print_select($LinktypeID); 
      ?>
      </td>
   </label>
  </tr>


  <tr>    
  <label>
  <td class="eingabe">Bezeichnung:</td>  
  <td class="eingabe"><input type="text" name="Bezeichnung" value="<?php echo htmlentities($Bezeichnung); ?>" size="100" required="required" oninput="changeBackgroundColor(this)"></td>
  </label>
  </tr> 

  <tr>    
  <label>
  <td class="eingabe">URL:</td>  
  <td class="eingabe"><input type="text" name="URL" value="<?php echo $URL; ?>" size="150" required="required" oninput="changeBackgroundColor(this)"></td>
  </label>
  </tr> 

  <tr> 
  <td class="eingabe"><input type="submit" value="Speichern"></td>
  <td class="eingabe"><a href="edit_sammlung_list_links.php?SammlungID=<?php echo $SammlungID; ?>">Liste anzeigen</a></td>
  </tr>
 </table> 

 <input type="hidden" name="SammlungID" value="<?php echo $SammlungID; ?>"> 
 <input type="hidden" name="ID" value="<?php echo $ID; ?>">  
 <input type="hidden" name="option" value="<?php echo $next_option; ?>">

</form>

<?php 
if (isset($_REQUEST["option"])) {
  if (in_array($_REQUEST["option"], array('insert','update'))) {
    $info= new HtmlInfo(); 
    $info->print_action_info($ID, $_REQUEST["option"]); 
  }
}
include('foot_raw.php');

?>
