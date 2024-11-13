
<?php 
include('head.php');
include("cl_sammlung.php");
include("cl_verlag.php");
include("cl_standort.php");
include("cl_html_info.php");

$sammlung = new Sammlung();

$show_data=false; 

if (isset($_REQUEST["option"])) {
  switch($_REQUEST["option"]) {
    case 'edit': // über "Bearbeiten"-Link
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
      $Erfasst=(isset($_POST["Erfasst"])?1:0); 
      $sammlung->ID = $_POST["ID"];    
      $sammlung->update_row(
        $_POST["Name"]
        , $_POST["VerlagID"]
        , $_POST["StandortID"]
        // , $_POST["Bestellnummer"]
        , $_POST["Bemerkung"]
        , $Erfasst
      ); 
      $show_data=true;           
      break; 
  }
}

$info= new HtmlInfo(); 

$info->print_screen_header($sammlung->Title.' bearbeiten'); 
$info->print_link_table('v_sammlung', 'sortcol=ID&sortorder=DESC', $sammlung->Titles,false,'&show_filter'); 
$info->print_link_insert($sammlung->table_name, $sammlung->Title, false); 


if ($show_data) {
  echo '
  <form action="edit_sammlung.php" method="post">
  <table class="form-edit"> 
  <tr>    
  <label>
  <td class="form-edit form-edit-col1">ID:</td>  
  <td class="form-edit form-edit-col2">'.$sammlung->ID.' 
      &nbsp; <label><input type="checkbox" name="Erfasst" '.($sammlung->Erfasst==1?'checked':'').'> Vollständig erfasst </label> 
  </td>
  </label>
    </tr> 
   '; 
  echo '
    <tr>    
      <label>
      <td class="form-edit form-edit-col1">Name:</td>  
      <td class="form-edit form-edit-col2"><input type="text" name="Name" value="'.htmlentities($sammlung->Name).'" size="100" maxlength="100" required="required" autofocus="autofocus" oninput="changeBackgroundColor(this)"> (max. 100 Zeichen)</td>
      </label>
    </tr> 
    '; 
  echo '   
    <tr>    
    <label>
    <td class="form-edit form-edit-col1">Verlag:</td>  
    <td class="form-edit form-edit-col2">
   
    <!-- Auswahlliste Verlag  -->         
          '; 
          $verlage = new Verlag();
          $verlage->print_select($sammlung->VerlagID); 

    echo ' </label>  &nbsp;
       '; 

    $info->print_link_edit($verlage->table_name, $sammlung->VerlagID,$verlage->Title, true); 
    $info->print_link_table($verlage->table_name,'sortcol=Name',$verlage->Titles,true,'');    
    $info->print_link_insert($verlage->table_name,$verlage->Title,true); 

  echo '
    </tr>

    <tr>    
    <label>
    <td class="form-edit form-edit-col1">Standort:</td>  
    <td class="form-edit form-edit-col2">   
          '; 
          $standorte = new Standort();
          $standorte->print_select($sammlung->StandortID); 

    echo '</label>  &nbsp;';

    $info->print_link_edit($standorte->table_name, $sammlung->StandortID,$standorte->Title, true); 
    $info->print_link_table($standorte->table_name,'sortcol=Name',$standorte->Titles,true,'');    
    $info->print_link_insert($standorte->table_name,$standorte->Title,true); 

    echo '
    </tr>

    <tr>    
      <label>
      <td class="form-edit form-edit-col1">Bemerkung:</td>
      <td class="form-edit form-edit-col2">
      <textarea name="Bemerkung" rows=1 cols=120 oninput="changeBackgroundColor(this)">'.htmlentities($sammlung->Bemerkung).'</textarea> 
      
      </td>
      </label>
    </tr> 

    <tr> 
      <td class="form-edit form-edit-col1"></td> 
      <td class="form-edit form-edit-col2"><input class="btnSave" type="submit" name="senden" value="Speichern">     
      
    </td>

    </tr> 
        <input type="hidden" name="ID" value="' . $sammlung->ID. '">
        <input type="hidden" name="option" value="update">      
        <input type="hidden" name="title" value="Sammlung"> 
    </form>

        <tr> 
        <td class="form-edit form-edit-col1">Musikstücke:
        <p> <a href="edit_musikstueck.php?SammlungID='.$sammlung->ID.'&option=insert&title=Musikstück" target="_blank" class="form-link form-link-switch" onfocus="linkStyleFocus(this)">Musikstück hinzufügen</a></p>
        <p> <a href="edit_sammlung_musikstuecke.php?SammlungID='.$sammlung->ID.'" target="musikstuecke" class="form-link form-link-switch">Aktualisieren - &gt;</a></p>



        </td> 
        <td class="form-edit form-edit-col2">
            <iframe src="edit_sammlung_musikstuecke.php?SammlungID='.$sammlung->ID.'"  height="150" name="musikstuecke" class="form-iframe-var2"></iframe>
      </td>
      </tr> 


    ';

    ?>
   
   <tr> 
      <td class="form-edit form-edit-col1">Daten anzeigen: <br /> <br />
        <input type="radio" id="Besonderheiten" name="target_form" value="Besonderheiten" onclick="changeIframeSrc('subform1', 'edit_sammlung_lookups.php?SammlungID=<?php echo $sammlung->ID; ?>');" checked>
        <label for="Besonderheiten">Besonderheiten</label><br>
        <input type="radio" id="Links" name="target_form" value="Links" onclick="changeIframeSrc('subform1', 'edit_sammlung_links.php?SammlungID=<?php echo $sammlung->ID; ?>');">
        <label for="Links">Links</label>
     </td>
     <td class="form-edit form-edit-col2">
           <iframe src="edit_sammlung_lookups.php?SammlungID=<?php echo $sammlung->ID; ?>" height="200" name="subform1" id="subform1" class="form-iframe-var2"></iframe>
      </td>
      </tr> 
  
      
    <?php 
    echo 
    '      





    </table>


  '; 
 
  $info->print_link_delete_row2($sammlung->table_name, $sammlung->ID, $sammlung->Title, false);   

} 
else {
    $info->print_user_error(); 
}


include('foot.php');

?>
