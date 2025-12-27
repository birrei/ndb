
<?php 
$PageTitle='Übung'; 
include_once('head.php');
include_once("classes/class.htmlinfo.php");
include_once("classes/class.uebung.php");
include_once("classes/class.uebungtyp.php");
include_once("classes/class.schueler.php");

$uebung = new Uebung(); 
$info= new HTML_Info(); 

$option=isset($_REQUEST["option"])?$_REQUEST["option"]:'edit';
$show_data=true; 

$SchuelerID=''; 
$UebungtypID=''; 
$Einheit=''; 

if (isset($_REQUEST["SchuelerID"])) {
  $SchuelerID=$_REQUEST["SchuelerID"]!=''?$_REQUEST["SchuelerID"]:''; 
}

if (isset($_REQUEST["UebungtypID"])) {
  $UebungtypID=$_REQUEST["UebungtypID"]!=''?$_REQUEST["UebungtypID"]:''; 
  if ($UebungtypID!='') {
    $uebungtyp=new UebungTyp(); 
    $uebungtyp->ID= $UebungtypID; 
    $uebungtyp->load_row(); 
    $Einheit = $uebungtyp->Einheit; 
  }  
}

switch($option) {

  case 'insert': 
    $uebung->insert_row($SchuelerID);
    break; 

  case 'edit': // über "Bearbeiten"-Link    
    $uebung->ID=$_REQUEST["ID"];
   // $uebung->load_row();  
    $show_data = $uebung->load_row();      
    $SchuelerID=$uebung->SchuelerID; 
    break; 
  
  case 'update':     
    $uebung->ID=$_POST["ID"]; 
    $uebung->update_row(
      $_POST["Name"], 
      $_POST["Bemerkung"], 
      $_POST["UebungtypID"], 
      $_POST["SchuelerID"], 
      $_POST["Datum"], 
      $_POST["Anzahl"], 
      $_POST["SatzID"]    );  
    $SchuelerID=$uebung->SchuelerID;     
    break; 

  case 'delete_1':        
    $uebung->ID = $_POST["ID"];  
    $uebung->load_row(); 
    $Name=$uebung->Name; 
    if($uebung->is_deletable()) {
      $info->print_form_delete_confirm(basename(__FILE__), $uebung->Title, $uebung->ID, $uebung->Name);   
    }     
    break; 

  case 'delete_2':    
    $uebung->ID=$_REQUEST["ID"]; 
    $uebung->delete(); 
    $show_data=false; 
    break; 

  case 'copy': 
    unset($_GET); 
    $uebung = new Uebung();          
    $uebung->ID=$_REQUEST["ID"]; 
    $uebung->copy();   
    $uebung->load_row();   
    $SchuelerID=$uebung->SchuelerID;             
    // $info->print_info_copy($uebung->Title, $ID_ref, $uebung->ID, 'edit_uebung'); 
  break;     
}

// test
// echo '<pre>
// option: '.$option.' 
// ID: '.$uebung->ID.' 
// Name: '.$uebung->Name.' 
// UebungtypID: '.$uebung->UebungtypID.' 
// SchuelerID: '.$uebung->SchuelerID.' 
// Datum: '.$uebung->Datum.' 
// Anzahl: '.$uebung->Anzahl.' 
// Bemerkung: '.$uebung->Bemerkung.' 
// </pre>'; 


$info->print_screen_header($uebung->Title.' bearbeiten'); 

// XXX folgende 2 Zeilen löschen (Übung wird immer vom Schüler aus angelegt)     

// $info->print_link_table('v_uebung', 'sortcol=Datum&sortorder=DESC', $uebung->Titles,false);

// $info->print_link_insert($uebung->table_name, $uebung->Title, false); 

if (!$show_data) {goto pagefoot;}


echo '</p>
<form action="edit_uebung.php" method="post">
<table class="form-edit" width="100%"> 
  <tr>    
    <label>
    <td class="form-edit form-edit-col1">ID:</td>  
    <td class="form-edit form-edit-col2">'.$uebung->ID.'</td>
    </label>
  </tr> '; 
  
echo '
  <tr>    
  <td class="form-edit form-edit-col1">Schüler Name:</td>  
  <td class="form-edit form-edit-col2"><b>'; 
      $schueler = new Schueler(); 
      $schueler->ID = $uebung->SchuelerID; 
      $schueler->load_row(); 
      echo $schueler->Name; 
   echo '</b></td>
    </tr> 
'; 

echo '
  <tr>    
    <label>
    <td class="form-edit form-edit-col1">Übung Inhalt:</td>  
    <td class="form-edit form-edit-col2"><input type="text" name="Name" value="'.htmlentities($uebung->Name).'" size="40%" autofocus="autofocus" oninput="changeBackgroundColor(this)"></td>
    </label>
  </tr>     

'; 



echo '
  <tr>    
  <label>  
  <td class="form-edit form-edit-col1">Uebung Typ:</td>  
  <td class="form-edit form-edit-col2">  
        '; 
        $typ=new UebungTyp(); 
        $typ->print_select($uebung->UebungtypID); 

    echo ' </label>  
      '; 
      $info->print_link_edit($typ->table_name, $uebung->UebungtypID,$typ->Title, true); 
      $info->print_link_table($typ->table_name,'sortcol=Name',$typ->Titles,true,'');    


  echo '</td>
    </tr>'; 




echo '
  <tr>    
     <td class="form-edit form-edit-col1">Datum:</td>   
     <td class="form-edit form-edit-col2"><input type="date" name="Datum" value="'.$uebung->Datum.'" oninput="changeBackgroundColor(this)"></td>
  </tr> 

  <tr>    
    <td class="form-edit form-edit-col1">Anzahl: </td>  
      <td class="form-edit form-edit-col2"><input type="number" name="Anzahl" value="'.$uebung->Anzahl.'" oninput="changeBackgroundColor(this)"> '.$Einheit.'</td>
  </tr>
  
  '; 


  echo '
  <tr>    
    <label>  
    <td class="form-edit form-edit-col1">Satz:</td>  
    <td class="form-edit form-edit-col2">  
          '; 
        $schueler = new Schueler(); 
        $schueler->ID = $SchuelerID; 
        $schueler->print_select_saetze($uebung->SatzID); 
        echo ' </label> ';             
        $info->print_link_edit('satz',$uebung->SatzID,true);   

    echo '</td>
      </tr>

      '; 

  ?>

  <tr>    
    <label>
    <td class="form-edit form-edit-col1">Bemerkung:</td>  
    <td class="form-edit form-edit-col2">
      <textarea name="Bemerkung" rows=2 cols=100 oninput="changeBackgroundColor(this)"><?php echo htmlentities($uebung->Bemerkung) ;?></textarea> 
    </td>
    </label>
  </tr>    

  <tr> 
    <td class="form-edit form-edit-col1"></td> 
    <td class="form-edit form-edit-col2"><input class="btnSave" type="submit" name="senden" value="Speichern">  
    </td>
  </tr> 

  <tr> 
    <!-- <td class="form-edit form-edit-col1">Besonderheiten:</td>   -->
    <td class="form-edit form-edit-col1"><a href="edit_uebung_lookups.php?UebungID=<?php echo $uebung->ID; ?>" target="Info">Besonderheiten:</a></td>  
  <td class="form-edit form-edit-col2">
    <iframe src="edit_uebung_lookups.php?UebungID=<?php echo $uebung->ID; ?>&source=iframe" height="200" id="subform1" name="Info" class="form-iframe-var2"></iframe>
  </td>
  </tr> 

 

  <input type="hidden" name="option" value="update">
  <input type="hidden" name="ID" value="<?php echo $uebung->ID; ?>">
  <input type="hidden" name="SchuelerID" value="<?php echo $uebung->SchuelerID; ?>">  

        
  </form>

  <?php 
    echo '
      <tr> 
        <td class="form-edit form-edit-col1"></td> 
        <td class="form-edit form-edit-col2">
        <br>'; 
        $info->print_form_inline('delete_1',$uebung->ID,$uebung->Title, 'löschen'); 
        $info->print_form_inline('copy',$uebung->ID,$uebung->Title, 'kopieren'); 
        echo '
        </td>
      </tr> '; 

  ?>
  </table> 

<?php 

pagefoot: 

include_once('foot.php');


?>
