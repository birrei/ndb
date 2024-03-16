
<?php 
include('head.php');
include("cl_sammlung.php");
include("cl_verlag.php");
include("cl_standort.php");
include("cl_html_info.php");

echo '<h2>Sammlung bearbeiten</h2>'; 

$sammlung = new Sammlung();

if (isset($_GET["ID"])) {
  $sammlung->ID = $_GET["ID"];
  $sammlung->load_row(); 
}

if (isset($_POST["senden"])) {
  $sammlung->ID = $_POST["ID"]; 
  if ($_POST["option"] == 'edit') { 
    $sammlung->update_row(
                      $_POST["Name"]
                      , $_POST["VerlagID"]
                      , $_POST["StandortID"]
                      , $_POST["Bestellnummer"]
                      , $_POST["Bemerkung"]
                      
                    ); 

    $info= new HtmlInfo(); 
    $info->print_action_info($sammlung->ID, 'update'); 
    $info->print_close_form_info();                        
  }
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
      <td class="eingabe"><input type="text" name="Name" value="'.$sammlung->Name.'" size="80" maxlength="80" required="required" autofocus="autofocus"></td>
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
   
    <!-- Auswahlliste Verlag  -->         
          '; 
          $standorte = new Standort();
          $standorte->print_select($sammlung->StandortID); 

    echo '
    </label>
    </tr>

 

    <tr>    
      <label>
      <td class="eingabe">Bestellnummer:</td>  
      <td class="eingabe"><input type="text" name="Bestellnummer" value="'.$sammlung->Bestellnummer.'" size="45" maxlength="80" autofocus="autofocus"></td>
      </label>
    </tr> 

    <tr>    
      <label>
      <td class="eingabe">Bemerkung:</td>  
      <td class="eingabe"><input type="text" name="Bemerkung" value="'.$sammlung->Bemerkung.'" size="45" maxlength="80" autofocus="autofocus"></td>
      </label>
    </tr> 

    <tr> 
      <td class="eingabe"></td> 
      <td class="eingabe"><input type="submit" name="senden" value="Speichern">     
      
    </td>
    </tr> 

        <input type="hidden" name="ID" value="' . $sammlung->ID. '">
        <input type="hidden" name="option" value="edit">      
        </form>

        <tr> 
        <td class="eingabe">Musikstücke:</td> 
        <td class="eingabe"><iframe src="edit_sammlung_list_musikstuecke.php?SammlungID='.$sammlung->ID.'" width="500" height="400" name="Besetzungen"></iframe>
      </td>
      </tr> 


  </table> 
  '; 

include('foot.php');

?>
