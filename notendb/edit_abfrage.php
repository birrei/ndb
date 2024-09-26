
<?php 
include('head.php');
include("cl_abfrage.php");
include("cl_abfragetyp.php");
include("cl_html_info.php");

$abfrage = new Abfrage();
$info= new HtmlInfo(); 

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
$info->print_link_table('v_abfrage', 'sortcol=Name&add_link_show&show_filter', $abfrage->Titles,false);

if ($show_data) {
  echo '<a href="show_abfrage.php?ID='.$abfrage->ID.'&title=Abfrage&Name='.$abfrage->Name.'" class="form-link">Ergebnis anzeigen</a>'; 
  $info->print_link_edit2($abfrage->table_name, $abfrage->ID,'Abfrage-Text',false);  
  echo '</p>
  <form action="edit_abfrage.php" method="post">
  <table class="eingabe" width="100%"> 
    <tr>    
    <label>
    <td class="eingabe">ID:</td>  
    <td class="eingabe">'.$abfrage->ID.'</td>
    </label>
      </tr> 


    <tr>    
    <label>
    <td class="eingabe"><b>Abfragetyp:</b></td>  
    <td class="eingabe">     
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
      <td class="eingabe">Name:</td>  
      <td class="eingabe"><input type="text" name="Name" value="'.htmlentities($abfrage->Name).'" size="100%" required="required" autofocus="autofocus" oninput="changeBackgroundColor(this)"></td>
      </label>
    </tr>     
    <tr>    
      <label>
      <td class="eingabe">Beschreibung:</td>  
      <td class="eingabe">
      <textarea name="Beschreibung" rows=5 cols=120 oninput="changeBackgroundColor(this)">'.htmlentities($abfrage->Beschreibung).'</textarea> (max. 250 Zeichen)  
      </td>
      </label>
    </tr> 
   
    <tr> 
      <td class="eingabe"></td> 
      <td class="eingabe"><input class="btnSave" type="submit" name="senden" value="Speichern">  
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
