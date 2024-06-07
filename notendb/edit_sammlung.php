
<?php 
include('head.php');
include("cl_sammlung.php");
include("cl_verlag.php");
include("cl_standort.php");
include("cl_html_info.php");

echo '<h2>Sammlung bearbeiten</h2>'; 

$sammlung = new Sammlung();
$info= new HtmlInfo(); 

if (!isset($_GET["option"]) and isset($_GET["ID"]))  {
  // geöffnet über einen "Bearbeiten"-Link
  $sammlung->ID=$_GET["ID"];
  $sammlung->load_row();  
  $info->print_action_info($sammlung->ID, 'view');    
}
if (isset($_GET["option"]) and $_GET["option"]=='insert') {
  // nach insert geladen   
  $sammlung->insert_row($_GET["Name"]); 
  $sammlung->load_row();  
  $info->print_action_info($sammlung->ID, 'insert');     
}
if (isset($_POST["option"]) and $_POST["option"]=='edit') {
  // in akt. Datei nach dem editieren gespeichert 
  $sammlung->ID = $_POST["ID"];    
  $sammlung->update_row(
    $_POST["Name"]
    , $_POST["VerlagID"]
    , $_POST["StandortID"]
    , $_POST["Bestellnummer"]
    , $_POST["Bemerkung"]
  ); 
  $info->print_action_info($sammlung->ID, 'update');     
}

  echo '
  <form action="edit_sammlung.php" method="post">

  <table class="eingabe"> 
  <tr>    
  <label>
  <td class="eingabe">ID:</td>  
  <td class="eingabe">'.$sammlung->ID.'</td>
  </label>
    </tr> 

    <tr>    
      <label>
      <td class="eingabe">Name:</td>  
      <td class="eingabe"><input type="text" name="Name" value="'.htmlentities($sammlung->Name).'" size="100" maxlength="100" required="required" autofocus="autofocus"> (max. 100 Zeichen)</td>
      </label>
    </tr> 
    
    
    <tr>    
    <label>
    <td class="eingabe">Verlag:</td>  
    <td class="eingabe">
   
    <!-- Auswahlliste Verlag  -->         
          '; 
          $verlage = new Verlag();
          $verlage->print_select($sammlung->VerlagID); 

    echo '
    </label>
    </tr>

    <tr>    
    <label>
    <td class="eingabe">Standort:</td>  
    <td class="eingabe">
   
    <!-- Auswahlliste Standort  -->         
          '; 
          $standorte = new Standort();
          $standorte->print_select($sammlung->StandortID); 

    echo '
    </label>
    </tr>

 

    <tr>    
      <label>
      <td class="eingabe">Bestellnummer:</td>  
      <td class="eingabe"><input type="text" name="Bestellnummer" value="'.$sammlung->Bestellnummer.'" size="45"></td>
      </label>
    </tr> 

    <tr>    
      <label>
      <td class="eingabe">Bemerkung:</td>  
      <td class="eingabe">
      <textarea name="Bemerkung" rows=7 cols=120 maxlength="1000">'.htmlentities($sammlung->Bemerkung).'</textarea> (max. 1000 Zeichen)
      </td>
      </label>
    </tr> 

    <tr> 
      <td class="eingabe"></td> 
      <td class="eingabe"><input class="btnSave" type="submit" name="senden" value="Speichern">     
      
    </td>

    </tr> 
        <input type="hidden" name="ID" value="' . $sammlung->ID. '">
        <input type="hidden" name="option" value="edit">      
        <input type="hidden" name="title" value="Sammlung"> 
    </form>

        <tr> 
        <td class="eingabe">Musikstücke:
        <p> <a href="edit_musikstueck.php?SammlungID='.$sammlung->ID.'&option=insert&title=Musikstück" target="_blank">Musikstück hinzufügen</a></p>
       
        </td> 
        <td class="eingabe"><iframe src="edit_sammlung_list_musikstuecke.php?SammlungID='.$sammlung->ID.'"  width="100%" height="400" name="Besetzungen"></iframe>
      </td>
      </tr> 

      <tr> 
      <td class="eingabe">Links:</td> 
      <td class="eingabe"><iframe src="edit_sammlung_list_links.php?SammlungID='.$sammlung->ID.'" width="100%" height="200" name="Links"></iframe>
    </td>
    </tr> 

     </table>
     <p><br></p> 
  '; 

include('foot.php');

?>
