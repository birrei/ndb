
<?php 
include('head.php');
include_once("classes/class.abfrage.php");
include_once("classes/class.abfragetyp.php");
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
      $abfrage->update_row(
            $_POST["Name"]
          , $_POST["Beschreibung"]   
          , $_POST["AbfragetypID"]   
          )
          ;
      $show_data=true;           
      break; 
  }
}

$info->print_screen_header($abfrage->Title.' bearbeiten'); 

if ($show_data) {
  echo '<a href="show_abfrage.php?ID='.$abfrage->ID.'&title=Abfrage&Name='.$abfrage->Name.'" class="form-link">Ergebnis anzeigen</a>'; 
  $info->print_link_edit2($abfrage->table_name, $abfrage->ID,'Abfrage-Text',false);  
  $info->print_link_table('v_abfrage', 'sortcol=Name&add_link_show&show_filter', $abfrage->Titles,false);
  echo '</p>
  <form action="edit_abfrage.php" method="post">
  <table class="form-edit" width="100%"> 
    <tr>    
    <label>
    <td class="form-edit form-edit-col1">ID:</td>  
    <td class="form-edit form-edit-col2">'.$abfrage->ID.'</td>
    </label>
      </tr> 


    <tr>    
    <label>
    <td class="form-edit form-edit-col1">Abfragetyp:</td>  
    <td class="form-edit form-edit-col2">     
          '; 
          $abfragtypen = new Abfragetyp();
          $abfragtypen->print_select($abfrage->AbfragetypID); 

    echo ' </label>  &nbsp;
       '; 

    $info->print_link_edit($abfragtypen->table_name, $abfrage->AbfragetypID,$abfragtypen->Title, true); 
    $info->print_link_table($abfragtypen->table_name,'sortcol=Name',$abfragtypen->Titles,true,'');    
    $info->print_link_insert($abfragtypen->table_name,$abfragtypen->Title,true); 

  echo '
    </tr>

    <tr>    
      <label>
      <td class="form-edit form-edit-col1">Name:</td>  
      <td class="form-edit form-edit-col2"><input type="text" name="Name" value="'.htmlentities($abfrage->Name).'" size="100%" required="required" autofocus="autofocus" oninput="changeBackgroundColor(this)"></td>
      </label>
    </tr>     
    <tr>    
      <label>
      <td class="form-edit form-edit-col1">Beschreibung:</td>  
      <td class="form-edit form-edit-col2">
      <textarea name="Beschreibung" rows=5 cols=120 oninput="changeBackgroundColor(this)">'.htmlentities($abfrage->Beschreibung).'</textarea> (max. 250 Zeichen)  
      </td>
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

  $info->print_link_delete_row2($abfrage->table_name, $abfrage->ID,'Abfrage'); 

} 
else {
    $info->print_user_error(); 
}

include('foot.php');

?>
