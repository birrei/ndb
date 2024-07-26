
<?php 
include('head.php');
include("cl_sammlung.php");
include("cl_verlag.php");
include("cl_standort.php");
include("cl_html_info.php");


$sammlung = new Sammlung();
$info= new HtmlInfo(); 

$info->print_screen_header('Sammlung bearbeiten'); 
echo ' | '; 
$info->print_link_show_table('v_sammlung', 'sortcol=ID&sortorder=DESC', 'Sammlungen'); 
echo ' | '; 
$info->print_link_insert($sammlung->table_name, 'Neue '.$sammlung->Title); 

$show_data=false; 


if (isset($_REQUEST["option"])) {
  switch($_REQUEST["option"]) {
    case 'open': // über "Bearbeiten"-Link
      $sammlung->ID=$_GET["ID"];
      if ($sammlung->load_row()) {
        $show_data=true;       
      }
      break; 

    case 'insert': 
      $sammlung->insert_row(''); 
      $show_data=true; 
      break; 
    
    case 'update': 
      $sammlung->ID = $_POST["ID"];    
      $sammlung->update_row(
        $_POST["Name"]
        , $_POST["VerlagID"]
        , $_POST["StandortID"]
        , $_POST["Bestellnummer"]
        , $_POST["Bemerkung"]
      ); 
      $show_data=true;           
      break; 
  }
}

if ($show_data) {
  echo '<p> 
  <form action="edit_sammlung.php" method="post">
  <table class="eingabe"> 
  <tr>    
  <label>
  <td class="eingabe"><b>ID:</b></td>  
  <td class="eingabe">'.$sammlung->ID.'</td>
  </label>
    </tr> 

    <tr>    
      <label>
      <td class="eingabe"><b>Name:</b></td>  
      <td class="eingabe"><input type="text" name="Name" value="'.htmlentities($sammlung->Name).'" size="100" maxlength="100" required="required" autofocus="autofocus" oninput="changeBackgroundColor(this)"> (max. 100 Zeichen)</td>
      </label>
    </tr> 
    
    <tr>    
    <label>
    <td class="eingabe"><b>Verlag:</b></td>  
    <td class="eingabe">
   
    <!-- Auswahlliste Verlag  -->         
          '; 
          $verlage = new Verlag();
          $verlage->print_select($sammlung->VerlagID); 

    echo ' </label>  &nbsp;
    <a href="edit_verlag.php?title=Verlag&ID='.$sammlung->VerlagID.'&option=open" target="_blank" tabindex="-1" >Bearbeiten</a> |
    <a href="show_table2.php?table=verlag&sortcol=Name&title=Verlage" target="_blank" tabindex="-1" >Daten anzeigen</a> | 
    <a href="edit_verlag.php?title=Verlag&option=insert" target="_blank" tabindex="-1">Neu erfassen</a>

    </tr>

    <tr>    
    <label>
    <td class="eingabe"><b>Standort:</b></td>  
    <td class="eingabe">
   
    <!-- Auswahlliste Standort  -->         
          '; 
          $standorte = new Standort();
          $standorte->print_select($sammlung->StandortID); 

    echo '</label>  &nbsp;
    <a href="edit_standort.php?ID='.$sammlung->StandortID.'&title=Standort&option=open" target="_blank">Bearbeiten</a> |
    <a href="show_table2.php?table=standort&sortcol=Name&title=Standorte" target="_blank">Daten anzeigen</a> | 
    <a href="edit_standort.php?title=Standort&option=insert" target="_blank">Neu erfassen</a>

    </tr>

    <tr>    
      <label>
      <td class="eingabe"><b>Bemerkung:</b></td>
      <td class="eingabe">
      <textarea name="Bemerkung" rows=5 cols=120 oninput="changeBackgroundColor(this)">'.htmlentities($sammlung->Bemerkung).'</textarea> 
      
      </td>
      </label>
    </tr> 

    <tr> 
      <td class="eingabe"></td> 
      <td class="eingabe"><input class="btnSave" type="submit" name="senden" value="Speichern">     
      
    </td>

    </tr> 
        <input type="hidden" name="ID" value="' . $sammlung->ID. '">
        <input type="hidden" name="option" value="update">      
        <input type="hidden" name="title" value="Sammlung"> 
    </form>

        <tr> 
        <td class="eingabe"><b>Musikstücke:</b>
        <p> <a href="edit_musikstueck.php?SammlungID='.$sammlung->ID.'&option=insert&title=Musikstück" target="_blank">Musikstück hinzufügen</a></p>
        <p> <a href="edit_sammlung_list_musikstuecke.php?SammlungID='.$sammlung->ID.'" target="musikstuecke">Aktualisieren</a></p>

        </td> 
        <td class="eingabe"><iframe src="edit_sammlung_list_musikstuecke.php?SammlungID='.$sammlung->ID.'"  width="100%" height="400" name="musikstuecke"></iframe>
      </td>
      </tr> 

      <tr> 
      <td class="eingabe"><b>Links</b>
      <p> <a href="edit_link.php?SammlungID='.$sammlung->ID.'&option=insert" target="Links">Link hinzufügen</a></p>
      <p> <a href="edit_sammlung_list_links.php?SammlungID='.$sammlung->ID.'" target="Links">Aktualisieren</a></p>
      
      </td> 
      <td class="eingabe"><iframe src="edit_sammlung_list_links.php?SammlungID='.$sammlung->ID.'" width="100%" height="200" name="Links"></iframe>
    
      </td>
    </tr> 

    
    <tr>    
      <label>
      <td class="eingabe"><b>Bestellnummer:</b></td>  
      <td class="eingabe"><input type="text" name="Bestellnummer" value="'.$sammlung->Bestellnummer.'" size="45" oninput="changeBackgroundColor(this)"></td>
      </label>
    </tr> 


    </table>
    <p>
    <a href="delete_sammlung.php?ID=' . $sammlung->ID . '&title=Sammlung löschen">Sammlung löschen</a>
    </p>

  '; 
} 
else {
    $info->print_user_error(); 
}


include('foot.php');

?>
