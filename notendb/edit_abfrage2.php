
<?php 
include('head.php');
include_once("classes/class.abfrage.php");
include_once("classes/class.htmlinfo.php");


$abfrage = new Abfrage();
$info= new HTML_Info(); 

$show_data=false; 

if (isset($_REQUEST["option"])) {
  switch($_REQUEST["option"]) {
    case 'edit': // über "Bearbeiten"-Link
      $abfrage->ID=$_GET["ID"];
      if ($abfrage->load_row()) {
        $show_data=true;       
      }
      break; 

    case 'insert': 
      $abfrage->insert_row('');
      $show_data=true; 
      break; 
    
    case 'update': 
      $abfrage->ID = $_POST["ID"];    
      $abfrage->update_row2(
           $_POST["Abfrage"]      
          , $_POST["Tabelle"]      
          )
          ;
      $show_data=true;           
      break; 
  }
}

$info->print_screen_header($abfrage->Title.'-Text bearbeiten'); 
// $info->print_link_table('v_abfrage', 'sortcol=Name', $abfrage->Titles,true); 
// echo '<a href="show_table2.php?table=v_abfrage&sortcol=ID&sortorder=DESC&title=Abfragen&add_link_show" target="_blank">Übersicht Abfragen</a>'; 
$info->print_link_table('v_abfrage', 'sortcol=Name&add_link_show&show_filter', $abfrage->Titles,true);

if ($show_data) {

  echo '<a href="show_abfrage.php?ID='.$abfrage->ID.'&title=Abfrage&Name='.$abfrage->Name.'" class="form-link">Ergebnis anzeigen</a>'; 
 
  // $info->print_link_edit($abfrage->table_name, $abfrage->ID,'Abfrage',false);

  echo '<a href="edit_abfrage.php?ID='.$abfrage->ID.'&title=Abfrage&option=edit" tabindex="-1" class="form-link">Abfrage-Beschreibung bearbeiten</a>'; 

   echo '  </p> 
   <form action="edit_abfrage2.php" method="post">
  <table class="form-edit" width="100%"> 

    <tr>    
    <label>
    <td class="form-edit form-edit-col1">ID:</td>  
    <td class="form-edit form-edit-col2">'.$abfrage->ID.'</td>
    </label>
      </tr> 


      <tr>    
      <label>
      <td class="form-edit form-edit-col1">Name:</td>  
      <td class="form-edit form-edit-col2">'.$abfrage->Name.'</td>
      </label>
        </tr> 
  

    <tr>    
        <label>
        <td class="form-edit form-edit-col1">SQL:</td>  
        <td class="form-edit form-edit-col2">
        <textarea name="Abfrage" rows=15 cols=120 oninput="changeBackgroundColor(this)">'.htmlentities($abfrage->Abfrage).'</textarea> (max. 10000 Zeichen)
        </td>
        </label>
      </tr> 

    <tr>    
      <label>
      <td class="form-edit form-edit-col1">Tabelle für Bearbeitung:</td>  
      <td class="form-edit form-edit-col2"><input type="text" name="Tabelle" value="'.$abfrage->Tabelle.'" size="45" maxlength="80" autofocus="autofocus" oninput="changeBackgroundColor(this)"></td>
      </label>
    </tr> 

    <tr> 
      <td class="form-edit form-edit-col1"></td> 
      <td class="form-edit form-edit-col2"><input class="btnSave" type="submit" name="senden" value="Speichern">  
      </td>
    </tr> 

  </table> 
  <input type="hidden" name="option" value="update"> 
  <input type="hidden" name="title" value="Abfrage">          
  <input type="hidden" name="ID" value="' . $abfrage->ID. '">

  </form>'; 


} 
else {
    $info->print_user_error(); 
}

include('foot.php');

?>
