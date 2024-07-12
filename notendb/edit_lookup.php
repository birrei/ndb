
<?php 
include('head_raw.php');
include("cl_lookuptype.php");
include("cl_lookup.php");
include("cl_html_info.php");

echo '<h2>Besonderheit bearbeiten</h2>'; 

$lookup = new Lookup();
$info= new HtmlInfo(); 

if (!isset($_GET["option"]) and isset($_GET["ID"]))  {
  // geöffnet über einen "Bearbeiten"-Link
  $lookup->ID=$_GET["ID"];
  $lookup->load_row();  
  $info->print_action_info($lookup->ID, 'view');    
}
if (isset($_GET["option"]) and $_GET["option"]=='insert') {
  // über insert_lookup  
  $lookup->LookupTypeID= $_GET["LookupTypeID"]; 
  $lookup->insert_row($_GET["Name"]);  
  $info->print_action_info($lookup->ID, 'insert');     
}
if (isset($_POST["option"]) and $_POST["option"]=='edit') {
  // in akt. Datei nach dem editieren gespeichert 
  $lookup->ID = $_POST["ID"];    
  $lookup->update_row($_POST["Name"], $_POST["LookupTypeID"]); 
  $info->print_action_info($lookup->ID, 'update');     
}

// $info->print_link_show_table('v_lookup', 'sortcol=Name,LookupType', 'Besonderheiten'); 



echo '
<form action="edit_lookup.php" method="post">
<table class="eingabe"> 
  <tr>    
  <label>
  <td class="eingabe">ID:</td>  
  <td class="eingabe">'.$lookup->ID.'</td>
  </label>
    </tr> 


    <tr>    
    <label>
    <td class="eingabe">Typ/Kategorie:
    
    </td>  
    <td class="eingabe">    
          '; 
          $lookup_type = new Lookuptype();
          $lookup_type->print_select($lookup->LookupTypeID); 

    echo '
    </label>
  </td>
    </tr>

    
  <tr>    
    <label>
    <td class="eingabe">Name:</td>  
    <td class="eingabe"><input type="text" name="Name" value="'.$lookup->Name.'" size="45" maxlength="80" required="required" autofocus="autofocus" oninput="changeBackgroundColor(this)"></td>
    </label>
  </tr> 


  <tr> 
    <td class="eingabe"></td> 
    <td class="eingabe"><input type="submit" name="senden" value="Speichern">

    </td>
  </tr> 

</table> 
<input type="hidden" name="option" value="edit">  
<input type="hidden" name="title" value="Besonderheit">       
<input type="hidden" name="ID" value="' . $lookup->ID. '">

</form>


<p>
<a href="delete_lookup.php?ID=' . $lookup->ID . '&title=Besonderheit löschen">Besonderheit löschen</a>
</p>

'; 

include('foot_raw.php');

?>
