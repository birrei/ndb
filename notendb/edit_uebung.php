
<?php 
$PageTitle='Übung'; 
include_once('head.php');
include_once("classes/class.htmlinfo.php");
include_once("classes/class.uebung.php");
include_once("classes/class.uebungtyp.php");
include_once("classes/class.schueler.php");
include_once("classes/class.kalender.php");

$uebung = new Uebung(); 
$info= new HTML_Info(); 

$option=isset($_REQUEST["option"])?$_REQUEST["option"]:'edit';
$show_data=true; 

// echo 'option: '.$option.'<br>'; // test  

$SchuelerID=''; 
$SchuelerName=''; 
$UebungtypID=''; 
$Reihenfolge=0; 
$ID=''; 
$Name=''; 
$Bemerkung = ''; 
$UebungtypID = ''; 
$Datum = ''; 
$Anzahl=0; 
$SatzID ='';  
$Reihenfolge =0; 

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
  case 'insert': // über "Übersicht Übungen"

    $Datum=isset($_REQUEST["Datum"])?$_REQUEST["Datum"]:date('Y-m-d');

    //  // über "Übersicht Übungen", Einfügen-Link - entweder mit oder ohne Datum- Vorauswahl
    // if(isset($_REQUEST["Datum"])) { 
    //    $Datum=$_REQUEST["Datum"]; 
    //    if($Datum=='') { // kein Datum ausgewählt 
    //       $Datum= date('Y-m-d'); 
    //    }
    // }
    // else {
    //   $Datum= date('Y-m-d'); 
    // }
    
    $uebung->insert_row($SchuelerID);
    $show_data = $uebung->load_row();  
    $ID=$uebung->ID; 
    $SchuelerName = $uebung->SchuelerName;     

    // if($show_data) {
    //       $ID=$uebung->ID; 
    //       $Name = $uebung->Name; 
    //       $Bemerkung = $uebung->Bemerkung; 
    //       $UebungtypID = $uebung->UebungtypID;
    //       $SchuelerID = $uebung->SchuelerID ;
    //       // $Datum = $uebung->Datum; 
    //       $Anzahl = $uebung->Anzahl; 
    //       $SatzID = $uebung->SatzID; 
    //       $Reihenfolge = $uebung->Reihenfolge; 
    //   }

    // $uebung->ID=$_REQUEST["ID"];
    // $Name = $_REQUEST["Name"]; 
    // $Bemerkung = $_REQUEST["Bemerkung"];
    // $UebungtypID = $_REQUEST["UebungtypID"] ;
    // $SchuelerID = $_REQUEST["SchuelerID"] ;
    // $Datum = $_REQUEST["Datum"];
    // $Anzahl = $_REQUEST["Anzahl"];
    // $SatzID = $_REQUEST["SatzID"]; 
    // $Reihenfolge = $_REQUEST["Reihenfolge"];


    break; 

  case 'insert2': // über Formualar "Schüler Übungstag" -> Datum oblig. vordefiniert
    
    $Datum=$_REQUEST["Datum"]; 
    $uebung->insert_row($SchuelerID, $Datum);
    $show_data = $uebung->load_row();  
    $ID=$uebung->ID; 
    $SchuelerName = $uebung->SchuelerName; 

    // if($show_data) {

    //     // $Name = $uebung->Name; 
    //     // $Bemerkung = $uebung->Bemerkung; 
    //     // $UebungtypID = $uebung->UebungtypID;
    //     // $SchuelerID = $uebung->SchuelerID ;
    //     // $Datum = $uebung->Datum; 
    //     // $Anzahl = $uebung->Anzahl; 
    //     // $SatzID = $uebung->SatzID; 
    //     // $Reihenfolge = $uebung->Reihenfolge; 
    // }

    // echo 'ID: '.$ID.'<br>'; // test  
    // echo 'Name: '.$Name.'<br>'; // test  
    // echo 'Bemerkung: '.$Bemerkung.'<br>'; // test  
    // echo 'UebungtypID: '.$UebungtypID.'<br>'; // test  
    // echo 'Datum: '.$Datum.'<br>'; // test  
    // echo 'Anzahl: '.$Anzahl.'<br>'; // test  
    // echo 'SatzID: '.$SatzID.'<br>'; // test  
    // echo 'Reihenfolge: '.$Reihenfolge.'<br>'; // test  
  

    break;     

  case 'edit': // über "Bearbeiten"-Link    
    $uebung->ID=$_REQUEST["ID"];
    $show_data = $uebung->load_row();   
    
    if($show_data) {
        $ID=$uebung->ID; 
        $Name = $uebung->Name; 
        $Bemerkung = $uebung->Bemerkung; 
        $UebungtypID = $uebung->UebungtypID;
        $SchuelerID = $uebung->SchuelerID ;
        $SchuelerName = $uebung->SchuelerName; 
        $Datum = $uebung->Datum; 
        $Anzahl = $uebung->Anzahl; 
        $SatzID = $uebung->SatzID; 
        $Reihenfolge = $uebung->Reihenfolge; 
    }
    break; 
  
  case 'update':  

    $ID=$_REQUEST["ID"];
    $Name = $_REQUEST["Name"]; 
    $Bemerkung = $_REQUEST["Bemerkung"];
    $UebungtypID = $_REQUEST["UebungtypID"] ;
    $SchuelerID = $_REQUEST["SchuelerID"] ;
    $SchuelerName = $_REQUEST["SchuelerName"] ;
    $Datum = $_REQUEST["Datum"];
    $Anzahl = $_REQUEST["Anzahl"];
    $SatzID = $_REQUEST["SatzID"]; 
    $Reihenfolge = $_REQUEST["Reihenfolge"];
   
   
    // echo 'ID: '.$ID.'<br>'; // test  
    // echo 'SchuelerID: '.$SchuelerID.'<br>'; // test      
    // echo 'SchuelerID: '.$SchuelerID.'<br>'; // test      
    // echo 'SchuelerName: '.$SchuelerName.'<br>'; // test  
    // echo 'Bemerkung: '.$Bemerkung.'<br>'; // test  
    // echo 'UebungtypID: '.$UebungtypID.'<br>'; // test  
    // echo 'Datum: '.$Datum.'<br>'; // test  
    // echo 'Anzahl: '.$Anzahl.'<br>'; // test  
    // echo 'SatzID: '.$SatzID.'<br>'; // test  
    // echo 'Reihenfolge: '.$Reihenfolge.'<br>'; // test  
   

    $uebung->ID = $ID; 
    $uebung->update_row(
        $Name , 
        $Bemerkung, 
        $UebungtypID,
        $SchuelerID, 
        $Datum,
        $Anzahl,
        $SatzID,
        $Reihenfolge
      ); 

    if($uebung->Fehler) {
      // gespeichertes holen  
      $uebung->load_row(); 
      $Datum=$uebung->Datum; 
    }
    else  {
      $Name = $uebung->Name; 
      $Bemerkung = $uebung->Bemerkung; 
      $UebungtypID = $uebung->UebungtypID;
      $SchuelerID = $uebung->SchuelerID ;
      $Datum = $uebung->Datum; 
      $Anzahl = $uebung->Anzahl; 
      $SatzID = $uebung->SatzID; 
      $Reihenfolge = $uebung->Reihenfolge; 

    }

     



    break; 

  case 'delete_1':        
    $uebung->ID = $_POST["ID"];  
    $uebung->load_row(); 
    $Name=$uebung->Name; 
    $Datum = $uebung->Datum; 
    if($uebung->is_deletable()) {
      $info->print_form_delete_confirm(basename(__FILE__), $uebung->Title, $uebung->ID, $uebung->Name);   
    }     
    break; 

  case 'delete_2':    
    $uebung->ID=$_REQUEST["ID"]; 
    $uebung->delete(); 
    $show_data=false; 
    break; 

  case 'copy': // Kopie mit aktuellem Datum (heute)
    unset($_GET); 
    $uebung = new Uebung();          
    $uebung->ID=$_REQUEST["ID"]; 
    $uebung->copy();   
    $uebung->load_row();   
    $SchuelerID=$uebung->SchuelerID;
    $Datum = $uebung->Datum;                  
    break; 

  case 'copy2': // Kopie mit Datum Übernahme vom Original 
    unset($_GET); 
    $uebung = new Uebung();          
    $uebung->ID=$_REQUEST["ID"]; 
    $uebung->load_row(); 
    $uebung->copy($uebung->Datum);   
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
    <td class="form-edit form-edit-col2">'.$ID.'<br></td>
    </label>
  </tr> '; 
  
echo '
  <tr>    
  <td class="form-edit form-edit-col1">Schüler Name:</td>  
  <td class="form-edit form-edit-col2">
    <b>'; 
      echo $SchuelerName; 
      // $schueler = new Schueler(); 
      // $schueler->ID = $SchuelerID; 
      // $schueler->load_row(); 
      // echo $schueler->Name; 
   echo '</b> &nbsp; '; 

   $info->print_link_edit('schueler', $SchuelerID, 'Schueler', true);    

   echo '
   </td>
    </tr> 
'; 

echo '
  <tr>    
    <label>
    <td class="form-edit form-edit-col1"><br>Übung Reihenfolge:</td>  

    <td class="form-edit form-edit-col2"><br>
    <input type="number" name="Reihenfolge" value="'.$Reihenfolge.'" oninput="changeBackgroundColor(this)"> 
      <i> (Reihenfolge innerhalb Schüler / Datum) </i> 
    </td>
 
    </label>
  </tr>     

'; 


echo '
  <tr>    
    <label>
    <td class="form-edit form-edit-col1">Übung Inhalt:</td>  
    <td class="form-edit form-edit-col2"><input type="text" name="Name" value="'.htmlentities($Name ?? '').'" size="100" autofocus="autofocus" oninput="changeBackgroundColor(this)"></td>
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
        $typ->print_select($UebungtypID); 

    echo ' </label>  
      '; 
      $info->print_link_edit($typ->table_name, $UebungtypID,$typ->Title, true); 
      $info->print_link_table($typ->table_name,'sortcol=Name',$typ->Titles,true,'');    


  echo '</td>
    </tr>'; 


echo '
  <tr>    
     <td class="form-edit form-edit-col1">Datum:</td>   
     <td class="form-edit form-edit-col2"><input type="date" name="Datum" value="'.$Datum.'" '.($option=='insert'?'style="background-color:#fad0e0"':'').' oninput="changeBackgroundColor(this)" requested></td>
  </tr> 

  <tr>    
    <td class="form-edit form-edit-col1">Anzahl: </td>  
      <td class="form-edit form-edit-col2"><input type="number" name="Anzahl" value="'.$Anzahl.'" oninput="changeBackgroundColor(this)"> 
      </td>
  </tr>
  
  '; 


  echo '
  <tr>    
    <label>  
    <td class="form-edit form-edit-col1">Satz:</td>  
    <td class="form-edit form-edit-col2">  '; 
    
        $schueler = new Schueler(); 
        $schueler->ID = $SchuelerID; 
        $schueler->print_select_saetze($SatzID); 
        echo ' </label> ';             
        $info->print_link_edit('satz',$SatzID,true);   

    echo '</td>
      </tr>

      '; 

  ?>

  <tr>    
    <label>
    <td class="form-edit form-edit-col1">Bemerkung:</td>  
    <td class="form-edit form-edit-col2">
      <textarea name="Bemerkung" rows=2 cols=100 oninput="changeBackgroundColor(this)"><?php echo htmlentities($Bemerkung ?? '') ;?></textarea> 
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
    <td class="form-edit form-edit-col1">
        <a href="edit_uebung_lookups.php?UebungID=<?php echo $ID; ?>" target="Info">Besonderheiten:</a>
      </td>  
  <td class="form-edit form-edit-col2">
    <iframe src="edit_uebung_lookups.php?UebungID=<?php echo $ID; ?>&source=iframe" height="200" id="subform1" name="Info" class="form-iframe-var2"></iframe>
  </td>
  </tr> 

 

  <input type="hidden" name="option" value="update">
  <input type="hidden" name="ID" value="<?php echo $ID; ?>">
  <input type="hidden" name="SchuelerID" value="<?php echo $SchuelerID; ?>">  
  <input type="hidden" name="SchuelerName" value="<?php echo $SchuelerName; ?>">  

        
  </form>

  <?php 
    echo '
      <tr> 
        <td class="form-edit form-edit-col1"></td> 
        <td class="form-edit form-edit-col2">
        <br>'; 
        $info->print_form_inline('delete_1',$ID,$uebung->Title, 'löschen'); 
        $info->print_form_inline('copy',$ID,$uebung->Title, 'kopieren'); 
        $info->print_form_inline('copy2',$ID,$uebung->Title, 'mit Datum kopieren'); 
        echo '
        </td>
      </tr> '; 

  ?>
  </table> 

<?php 

pagefoot: 

include_once('foot.php');


?>
