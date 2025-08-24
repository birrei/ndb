<?php 
$PageTitle='Suche'; 
include_once('head.php');

include_once("classes/dbconn/class.db.php");  
include_once("classes/class.htmltable.php");    
include_once("classes/class.htmlinfo.php");  

include_once("classes/class.besetzung.php");  
include_once("classes/class.verwendungszweck.php"); 
include_once("classes/class.standort.php"); 
include_once("classes/class.komponist.php"); 
include_once("classes/class.verlag.php"); 
include_once("classes/class.gattung.php"); 
include_once("classes/class.epoche.php"); 
include_once("classes/class.erprobt.php");  

include_once("classes/class.schwierigkeitsgrad.php");  
include_once("classes/class.instrument.php");  
include_once("classes/class.instrument_schwierigkeitsgrad.php");  

include_once("classes/class.lookup.php");   
include_once("classes/class.lookuptype.php");
include_once("classes/class.linktype.php");
include_once("classes/class.abfrage.php");
include_once("classes/class.schueler.php");
include_once("classes/class.status.php");
include_once("classes/class.materialtyp.php");

include_once("suche_sql.php");

/***** Parameter: Initialisierung, Defaults  ******/
  if (isset($_POST['Ansicht'])) {
    $Ansicht=$_POST["Ansicht"];
  } else {
    $Ansicht='Sammlung'; // default 
  }
  $AnsichtEbene=getAnsichtEbene($Ansicht); 
  $AnsichtGruppe=getAnsichtGruppe($AnsichtEbene); 
  $edit_table=getEditTable($AnsichtEbene); 

  // // TEST 
  // echo '<br>Ansicht: '.$Ansicht; 
  // echo '<br>Ansicht Ebene: '.$AnsichtEbene; 
  // echo '<br>Ansicht Domäne: '.$AnsichtGruppe; 
  // echo '<br>edit_table: '.$edit_table; 

  $filter=false; 

  $Suche = new Abfrage();
  $Suche->Beschreibung = ""; 


  $query=''; 
  $query_SELECT=''; 
  $query_FROM=''; 
  $query_GROUP_BY=''; 
  $query_WHERE='WHERE 1=1 '.PHP_EOL; 
  $query_ORDER_BY=''; 

  /**************** */

?>

  &nbsp;
  &nbsp;

<!---- Link: Filter ein/ausblenden  ----->

  <a onclick="hideFilter()" href="#">Filter ein/ausblenden</a>
  <script> 
    function hideFilter() {
      // Sichtbarkeit linke Filter-Spalte ein / aus  
      if (document.getElementById("search-filter").hidden==false)
      {
        document.getElementById("search-filter").hidden=true; 
        document.getElementById("search-page").style.gridTemplateColumns = "auto";
      } else 
      {
        document.getElementById("search-filter").hidden=false;      
        document.getElementById("search-page").style.gridTemplateColumns = "350pt auto"; 
      }

    }
  </script>


<div class="search-page" id="search-page">
<div class="search-filter" id="search-filter">

<!---- Button: alle Filter zurücksetzen --> 
  <br>
  <input type="button" id="btnReset_All" value="Alle Filter zurücksetzen" onclick="Reset_All();" /> 
  <script type="text/javascript">  
            function Reset_All() {  
            for(i=0; i<document.forms[0].elements.length; i++){
              if(document.forms[0].elements[i].type == 'text'){
                document.forms[0].elements[i].value=""; 
              }
              if(document.forms[0].elements[i].type == 'select-one'){
                if(document.forms[0].elements[i].id!='Ansicht') {
                  document.forms[0].elements[i].selectedIndex = -1;
                }
              }   
              if(document.forms[0].elements[i].type == 'select-multiple'){
                document.forms[0].elements[i].selectedIndex = -1;
              }     
              if(document.forms[0].elements[i].type == 'checkbox'){
                document.forms[0].elements[i].checked = 0;
              }    
              if(document.forms[0].elements[i].type == 'radio'){
                document.forms[0].elements[i].checked = 0;
              }                                     
            }
        }  
  </script> 

<form id="Suche" action="" method="post">

<?php
/************** Auswahl Ansicht **********/  
  $Suche->Beschreibung.='Ansicht: '.$Ansicht.' (Gruppe: '.$AnsichtGruppe.')'.PHP_EOL; 
  $Suche->Beschreibung.='Aktive Filter: '.PHP_EOL; 
  // $Suche->Beschreibung.='* Ansicht Ebene: '.$AnsichtEbene.PHP_EOL; 
  // $Suche->Beschreibung.='* Ansicht Gruppe: '.$AnsichtGruppe.PHP_EOL; 
  ?>
  <br><b>Ansicht: </b>
  <select id="Ansicht" name="Ansicht" onchange="this.form.submit()" style="background-color: lightgreen">
      <option value="Sammlung" <?php echo ($Ansicht=='Sammlung'?'selected':'');?>>Sammlung (Noten)</option>   
      <option value="Sammlung erweitert" <?php echo ($Ansicht=='Sammlung erweitert'?'selected':'')?>>Sammlung erweitert (Noten)</option>   
      <option value="Sammlung Links" <?php echo ($Ansicht=='Sammlung Links'?'selected':'')?>>Sammlung Links (Noten)</option>              
      <option value="Musikstueck" <?php echo ($Ansicht=='Musikstueck'?'selected':'');?>>Musikstück (Noten)</option>
     <option value="Satz" <?php echo ($Ansicht=='Satz'?'selected':'')?>>Satz (Noten)</option>
      <option value="Satz Besonderheiten" <?php echo ($Ansicht=='Satz Besonderheiten'?'selected':'')?>>Satz Besonderheiten (Noten)</option>                     
      <option value="Satz Schueler" <?php echo ($Ansicht=='Satz Schueler'?'selected':'')?>>Satz Schüler (Noten)</option>    
      <option value="Material" <?php echo ($Ansicht=='Material'?'selected':'')?>>Material (Material)</option>
      <option value="Material_erweitert" <?php echo ($Ansicht=='Material_erweitert'?'selected':'')?>>Material erweitert (Material)</option>      
      <option value="Schueler" <?php echo ($Ansicht=='Schueler'?'selected':'')?>>Schüler (Schüler)</option> 
      <option value="Schueler erweitert" <?php echo ($Ansicht=='Schueler erweitert'?'selected':'')?>>Schüler erweitert (Schüler)</option>                                        
  </select>

<!---- Checkbox Suche speichern ja / nein -----> 
   &nbsp; &nbsp; <input type="checkbox" id="sp" name="SucheSpeichern"><label for="sp">Suche speichern</label> 

<?php 
/************* Filter Suchtext  **********/  
  $suchtext=''; 
  $query_WHERE_Suchtext=''; 
  if (isset($_POST['suchtext'])) {
    $suchtext = $_POST['suchtext'];  
    if ($suchtext!='') { 
      $Suche->Beschreibung.='* Suchtext: '.$suchtext.PHP_EOL; 
      $filter=true; 
      $query_WHERE_Suchtext=getSQL_WHERE_Suchtext($AnsichtGruppe,$suchtext);
    }
  }  
  ?>

  <p>Suchtext: <br><input type="text" id="suchtext" name="suchtext" size="30px" value="<?php echo $suchtext; ?>" autofocus> 
  <input class="btnSave" type="submit" value="Suchen" width="100px">
  <input type="hidden" name="Filter" value="Suchen">
  </P> 
<!-- Navi-Block "Schüler (immer anzeigen) -->
  <p class="navi-trenner">Schüler </p> 
  <?php
/************* Filter Schüler (Auswahlbox immer anzeigen) ***********/

  if($AnsichtGruppe=='Schueler') {
    $optAktiv='ja'; // default nur "Aktiv"
    $filter=true; 
    if (isset($_POST["optAktiv"])) {
      $optAktiv=$_POST["optAktiv"]; 
    }
    switch($optAktiv) {
      case 'ja': 
        $query_WHERE.='AND schueler.Aktiv=1 '.PHP_EOL; 
        $Suche->Beschreibung.='* Nur aktive Schüler'.PHP_EOL; 
        break; 
      // case 'nein': 
      //   $query_WHERE.='AND schueler.Aktiv=0 '.PHP_EOL; 
      //   $Suche->Beschreibung.='* Nicht vollständig erfasste Sammlungen'.PHP_EOL;           
      //   break;              
    }    
    ?><p>
      <input type="radio" name="optAktiv" id="optAktivNein" value="nein"<?php echo ($optAktiv=='nein'?' checked':''); ?>><label for="optAktivNein">Alle Schüler</label> 
      <input type="radio" name="optAktiv" id="optAktivJa" value="ja"<?php echo ($optAktiv=='ja'?' checked':''); ?>><label for="optAktivJa">Nur aktive Schüler</label>
      </p> 
    <?php 
  }


  $schueler = new Schueler();
  $SchuelerID=''; 
  if (isset($_POST['SchuelerID'])) {
    if ($_POST['SchuelerID']!='') {
      $SchuelerID = $_POST['SchuelerID']; 
      $schueler->ID=$SchuelerID; 
      $schueler->load_row(); 
      $Suche->Beschreibung.='* Schüler: '.$schueler->Name.PHP_EOL;  
      switch($AnsichtEbene) {
        case 'Sammlung': 
          $query_WHERE.='AND satz.ID IN (SELECT SatzID from schueler_satz where SchuelerID='.$SchuelerID.') ' . PHP_EOL;
          break;     
        case 'Musikstueck': 
          $query_WHERE.='AND satz.ID IN (SELECT SatzID from schueler_satz where SchuelerID='.$SchuelerID.') ' . PHP_EOL;
          break;         
        case 'Satz': 
          $query_WHERE.='AND schueler_satz.SchuelerID='.$SchuelerID.' ' . PHP_EOL;
          break;                        
        case 'Material': 
          $query_WHERE.='AND material.ID IN (SELECT MaterialID from schueler_material where SchuelerID='.$SchuelerID.') ' . PHP_EOL;              
          break; 
        case 'Schueler': 
          $query_WHERE.='AND schueler.ID='.$SchuelerID.' ' . PHP_EOL;  
          break;            
      }         
      $filter=true;       
    }
  }
  $schueler->print_select($SchuelerID,'',$schueler->Title, true );

/************* Filter Schüler Status (3 Varianten)  ***********/
  $status = new Status();
  $StatusID=''; 
  $captionStatus=''; 

  switch($AnsichtGruppe) {
    case 'Noten': 
      if (isset($_POST['StatusID'])) {
        $StatusID = $_POST['StatusID']; 
        if ($StatusID!='') {
          $filter=true;    
          $status->ID= $StatusID; 
          $status->load_row(); 
          $query_WHERE.='AND satz.ID IN (SELECT SatzID FROM schueler_satz WHERE StatusID='.$StatusID.') '.PHP_EOL; 
          $Suche->Beschreibung.='* Status Schüler Satz: '.$status->Name.PHP_EOL;    
        }
      }
      echo '<p>';
      $status->print_select($StatusID, 'Status Schüler Satz');
      echo '</p>';
      break; 

    case 'Material':

      if (isset($_POST['StatusID'])) {
        $StatusID = $_POST['StatusID']; 
        if ($StatusID!='') {
          $filter=true;    
          $status->ID= $StatusID; 
          $status->load_row(); 
          $query_WHERE.='AND material.ID IN (SELECT MaterialID FROM schueler_material WHERE StatusID='.$StatusID.') '.PHP_EOL; 
          $Suche->Beschreibung.='* Status Schüler Material: '.$status->Name.PHP_EOL;              
        }
      }
      echo '<p>';
      $status->print_select($StatusID, 'Status Schüler Material');
      echo '</p>';
      break; 

    case 'Schueler':
      if (isset($_POST['StatusID'])) {
        $StatusID = $_POST['StatusID']; 
        if ($StatusID!='') {
          $filter=true;    
          $status->ID= $StatusID; 
          $status->load_row(); 
          $query_WHERE.='AND (schueler_satz.StatusID='.$StatusID.' OR schueler_material.StatusID='.$StatusID.') '.PHP_EOL;           
          $Suche->Beschreibung.='* Status Noten / Material: '.$status->Name.PHP_EOL;                 
        }
      }
      echo '<p>';
      $status->print_select($StatusID, 'Status Noten / Material');
      echo '</p>';
  
      break;   
  }



/*** Navi-Block "Sammlung */
  if($AnsichtGruppe=='Noten') {
    ?>
    <p class="navi-trenner">Sammlung </p> 
    <?php
  }
 
/************* Filter Standort  ***********/
  if ($AnsichtGruppe=='Noten') {
    $standort = new Standort();
    $StandortID=''; 
    if (isset($_POST['StandortID'])) {
      $StandortID = $_POST['StandortID']; 
      if ($StandortID!='') {
        $standort->ID=$StandortID; 
        $standort->load_row(); 
        // $filterStandorte='='.$StandortID.' '; 
        $query_WHERE.='AND sammlung.StandortID='.$StandortID.' ' . PHP_EOL;     
        $Suche->Beschreibung.='* Standort: '.$standort->Name.PHP_EOL;     
        $filter=true;       
      }
    }
    echo '<p>';
    $standort->print_select($StandortID, $standort->Title);
    echo '</p>';  
  }

/************* Filter Verlag  ***********/
  if ($AnsichtGruppe=='Noten') {
    $verlag = new Verlag();
    $VerlagID='';     
    if (isset($_POST['VerlagID']) ) {
      $VerlagID=$_POST['VerlagID']; 
      if ($VerlagID!='') {
        $verlag->ID=$VerlagID; 
        $verlag->load_row(); 
        // $filterVerlage='='.$VerlagID.' '; 
        $query_WHERE.='AND sammlung.VerlagID='.$VerlagID.' ' . PHP_EOL;            
        $Suche->Beschreibung.='* Verlag: '.$verlag->Name.PHP_EOL;     
        $filter=true;    
      }   
    }
    echo '<p>';
    $verlag->print_select($VerlagID, $verlag->Title);
    echo '</p>';
  }


/************* Filter Sammlung Besonderheiten **********/  
  // if ($AnsichtGruppe=='Noten') {
  // // if ($Ansicht=='Sammlung') {
  //   // XXX noch analog zu Satz Besonderheiten umsetzen (Genaue Suche)
  //   $lookuptypes=new Lookuptype(); 
  //   $lookuptypes->Relation='sammlung'; 
  //   $arrLookupTypes=$lookuptypes->getArrData(); 
  //   $filterLookups_sammlung=''; 
  //   for ($i = 0; $i < count($arrLookupTypes); $i++) {
  //     $lookup=New Lookup(); 
  //     $lookup->LookupTypeID=$arrLookupTypes[$i]["ID"];
  //     $lookup_type_name=$arrLookupTypes[$i]["Name"]; 
  //     $lookup_type_key= $arrLookupTypes[$i]["type_key"]; // z.B: "besdynam" ect.  
  //     $lookup_values_selected=[];      
  //     if (isset($_POST[$lookup_type_key])) {
  //       $lookup_values_selected= $_POST[$lookup_type_key]; 
  //       // $query_WHERE.='AND sammlung_lookup.LookupID IN ('.implode(',', $lookup_values_selected).') -- '.$lookup_type_name.''. PHP_EOL; 
  //       $query_WHERE.='AND sammlung.ID IN (SELECT SammlungID FROM sammlung_lookup WHERE LookupID IN ('.implode(',', $lookup_values_selected).')) -- '.$lookup_type_name.''. PHP_EOL; 
  //       $filter=true; 
  //     } 
  //     $lookup->print_select_multi($lookup_type_key,$lookup_values_selected, $lookup_type_name.':');
  //     $Suche->Beschreibung.=(count($lookup_values_selected)?$lookup->titles_selected_list:'');   
  //   }
  // }

/************* Filter Linktypen  ************** */  
  if ($Ansicht=='Sammlung Links') {
    $Linktypen=[];   /* Sammlung */
    $linktyp = new Linktype();
    if (isset($_POST['Linktypen'])) {
      $Linktypen = $_POST['Linktypen']; 
      $query_WHERE.='AND links.LinktypeID IN ('.implode(',', $Linktypen).') '.PHP_EOL; 
      $filter=true;       
    }  
    $linktyp->print_select_multi($Linktypen);      
    $Suche->Beschreibung.=(count($Linktypen)>0?$linktyp->titles_selected_list:''); 
  }


/************ Filter Sammlung Erfasst ja / nein ************/  
  if($AnsichtGruppe=='Noten') {
    $optErfasst=''; // default "ohne Sammlung"
    if (isset($_POST["optErfasst"])) {
      $filter=true; 
      $optErfasst=$_POST["optErfasst"]; 
      switch($optErfasst) {
        case 'ja': 
          $query_WHERE.='AND sammlung.Erfasst=1 '.PHP_EOL; 
          $Suche->Beschreibung.='* Vollständig erfasste Sammlungen'.PHP_EOL; 
          break; 
        case 'nein': 
          $query_WHERE.='AND sammlung.Erfasst=0 '.PHP_EOL; 
          $Suche->Beschreibung.='* Nicht vollständig erfasste Sammlungen'.PHP_EOL;           
          break;              
      }
    }
    ?><p>
      <input type="radio" name="optErfasst" id="optErfasstNein" value="nein"<?php echo ($optErfasst=='nein'?' checked':''); ?>><label for="optErfasstNein">Nicht vollständig erfasst</label> 
      <input type="radio" name="optErfasst" id="optErfasstJa" value="ja"<?php echo ($optErfasst=='ja'?' checked':''); ?>><label for="optErfasstJa">vollständig erfasst</label>
      </p> 
    <?php 
  }

/*** Navi-Block "Musikstück */
  if($AnsichtGruppe=='Noten') {
    ?>
    <p class="navi-trenner">Musikstück </p> 
    <?php 
  }

/************* Filter Komponist  ***********/
  if ($AnsichtGruppe=='Noten') {
    $komponist = new Komponist();
    $KomponistID=''; 
    if (isset($_POST['KomponistID'])) {
      if ($_POST['KomponistID']!='') {
        $KomponistID = $_POST['KomponistID']; 
        $komponist->ID=  $KomponistID; 
        $komponist->load_row(); 
        $query_WHERE.='AND musikstueck.KomponistID='.$KomponistID.' '.PHP_EOL; 
        $Suche->Beschreibung.=($KomponistID!=''?'* Komponist: '.$komponist->Name.PHP_EOL:'');     
        $filter=true;       
      }
    }
    $komponist->print_select($KomponistID,$komponist->Title);
  }

/************* Filter Besetzungen  ***********/
  if ($AnsichtGruppe=='Noten') {
    // XXX Anpassung + Check Options in Arbeit 
    $Besetzungen_selected=[]; // im Suchfilter ausgewählte Besetzungen (IDs) 
    $Besetzungen_all= []; 
    $Besetzungen_not_selected= []; 
    $besetzung_check_include=false; // Einschluss-Suche aktiviert 
    $besetzung_check_exclude=false; // Ausschluss-Suche aktiviert 
    $besetzung = new Besetzung();
    if (isset($_POST['Besetzungen'])) {
      $filter=true;       
      $Besetzungen_selected = $_POST['Besetzungen'];    
      if (isset($_POST["include_Besetzung"])) { 
        $besetzung_check_include=true;
        for ($i = 0; $i < count($Besetzungen_selected); $i++) {
            $query_WHERE.='AND musikstueck.ID IN (SELECT MusikstueckID FROM musikstueck_besetzung WHERE BesetzungID='.$Besetzungen_selected[$i].') '. PHP_EOL; 
        }       
      }   
      else {
          $query_WHERE.='AND musikstueck.ID IN (SELECT MusikstueckID FROM musikstueck_besetzung WHERE BesetzungID IN ('.implode(',', $Besetzungen_selected).')) '.PHP_EOL; 
      }
      if (isset($_POST["exclude_Besetzung"]))  {
        $besetzung_check_exclude=true; 
        $Besetzungen_all= $besetzung->getArray();         
        $Besetzungen_not_selected = array_diff($Besetzungen_all, $Besetzungen_selected); // nicht ausgewählte Werte    
        $query_WHERE.='AND musikstueck.ID NOT IN (SELECT DISTINCT MusikstueckID from musikstueck_besetzung WHERE BesetzungID IN ('.implode(',', $Besetzungen_not_selected).')) '. PHP_EOL; 
      }     
    }
    // print_r($Besetzungen_all); 
    // print_r($Besetzungen_selected); 
    $besetzung->print_select_multi($Besetzungen_selected, $besetzung_check_include, $besetzung_check_exclude); 
    $Suche->Beschreibung.=(count($Besetzungen_selected)>0?$besetzung->titles_selected_list.PHP_EOL:'');  
    $Suche->Beschreibung.=($besetzung_check_include?' / +Einschluss-Suche':'');  
    $Suche->Beschreibung.=($besetzung_check_exclude?' / +Ausschluss-Suche':'');  
  }

/************* Filter Verwendungszwecke  ***********/
  if ($AnsichtGruppe=='Noten') {
    $Verwendungszwecke=[]; 
    if (isset($_POST['Verwendungszwecke'])) {
      $Verwendungszwecke = $_POST['Verwendungszwecke'];   
      $query_WHERE.='AND musikstueck.ID IN (SELECT MusikstueckID FROM musikstueck_verwendungszweck WHERE VerwendungszweckID IN ('.implode(',', $Verwendungszwecke).')) '.PHP_EOL; 
      $filter=true;     
    }  
    $verwendungszweck = new Verwendungszweck();
    $verwendungszweck->print_select_multi($Verwendungszwecke);    
    $Suche->Beschreibung.=(count($Verwendungszwecke)>0?$verwendungszweck->titles_selected_list.PHP_EOL:'');  
  }

/************* Filter Gattung  ***********/
  if ($AnsichtGruppe=='Noten') {
    $gattung = new Gattung();
    $GattungID=''; 
    if (isset($_POST['GattungID'])) {
        if ($_POST['GattungID']!='') {
        $GattungID = $_POST['GattungID']; 
        $gattung->ID=  $GattungID; 
        $gattung->load_row(); 
        $query_WHERE.='AND musikstueck.GattungID ='.$GattungID.' '.PHP_EOL; 
        $Suche->Beschreibung.=($GattungID!=''?'* Gattung: '.$gattung->Name.PHP_EOL:'');     
        $filter=true;       
      }
    }
    echo '<p>'; 
    $gattung->print_select($GattungID, $gattung->Title);
    echo '</p>'; 
  }

/************* Filter Epochen  ***********/
  if ($AnsichtGruppe=='Noten') {
    $epoche = new Epoche();
    $EpocheID=''; 
    if (isset($_POST['EpocheID'])) {
      if ($_POST['EpocheID']!='') { 
        $EpocheID = $_POST['EpocheID']; 
        $epoche->ID=  $EpocheID; 
        $epoche->load_row(); 
        $filterEpochen='AND musikstueck.EpocheID ='.$EpocheID.' '.PHP_EOL; 
        $Suche->Beschreibung.=($EpocheID!=''?'* Epoche: '.$epoche->Name.PHP_EOL:'');     
        $filter=true;     
      }  
    }
    echo '<p>'; 
    $epoche->print_select($EpocheID, $epoche->Title);
    echo '</p>'; 
  }
 

/*** Navi-Block "Satz */
  if($AnsichtGruppe=='Noten') {
    ?>
    <p class="navi-trenner">Satz </p> 
    <?php
  }

/************* Filter Instrument/Schwierigkeitsgrad  ***********/
  if ($AnsichtGruppe=='Noten') {
    $InstrumentSchwierigkeitsgrade=[];
    $schwierigkeitsgrad = new InstrumentSchwierigkeitsgrad();
    if (isset($_POST['InstrumentSchwierigkeitsgrad'])) {
      $InstrumentSchwierigkeitsgrade = $_POST['InstrumentSchwierigkeitsgrad']; 
      $query_WHERE.=$schwierigkeitsgrad->getSucheFilterSQL($InstrumentSchwierigkeitsgrade).PHP_EOL;
      $filter=true;       
    }
    $schwierigkeitsgrad->print_select_multi($InstrumentSchwierigkeitsgrade);  
    $Suche->Beschreibung.=(count($InstrumentSchwierigkeitsgrade)>0?$schwierigkeitsgrad->titles_selected_list.PHP_EOL:'');
  }

  if ($AnsichtGruppe=='Schueler') {
    $instrument = new Instrument();
    $InstrumentID=''; 
    $filterInstrument=''; 
    if (isset($_POST['InstrumentID'])) {
      if ($_POST['InstrumentID']!='') {
        $InstrumentID = $_POST['InstrumentID']; 
        $instrument->ID=  $InstrumentID; 
        $instrument->load_row(); 
        $query_WHERE.='AND schueler.ID IN (SELECT SchuelerID FROM schueler_schwierigkeitsgrad WHERE InstrumentID='.$InstrumentID.') '.PHP_EOL; 
        $Suche->Beschreibung.='* Instrument (Schüler): '.$instrument->Name.PHP_EOL;     
        $filter=true;       
      }
    }
    $instrument->print_select($InstrumentID,'','Instrument (Schüler)');

    $Schwierigkeitsgrade=[];
    $schwierigkeitsgrad = new Schwierigkeitsgrad();
    if (isset($_POST['Schwierigkeitsgrad'])) {
      $Schwierigkeitsgrade = $_POST['Schwierigkeitsgrad']; 
      // echo count($Schwierigkeitsgrade); 
      $query_WHERE.='AND schueler.ID IN (SELECT SchuelerID FROM schueler_schwierigkeitsgrad WHERE SchwierigkeitsgradID IN ('.implode(',', $Schwierigkeitsgrade).')) '.PHP_EOL; 
      $filter=true;       
    }
    $schwierigkeitsgrad->print_select_multi($Schwierigkeitsgrade, 'Schwierigkeitsgrad (Schüler)');  
    $Suche->Beschreibung.=(count($Schwierigkeitsgrade)>0?$schwierigkeitsgrad->titles_selected_list:'');  
  }
  
/************* Filter Erprobt  ***********/
  if ($AnsichtGruppe=='Noten') {
    $Erprobt=[];  // im Suchfilter ausgewählte Erprobt-Einträge  (IDs) 
    if (isset($_POST['Erprobt'])) {
      $Erprobt = $_POST['Erprobt'];   
      $query_WHERE.='AND satz.ID IN (SELECT SatzID FROM satz_erprobt WHERE ErprobtID IN ('.implode(',', $Erprobt).')) '.PHP_EOL; 
      $filter=true;     
    } 
    $erprobt = new Erprobt();
    $erprobt->print_select_multi($Erprobt);  
    $Suche->Beschreibung.=(count($Erprobt)>0?$erprobt->titles_selected_list:'');            
  }
  // /************* Erprobt Jahr // vermutlich nicht benötigt ***********/
  // $ErprobtJahr_von=''; 
  // $ErprobtJahr_bis=''; 
  // if (isset($_REQUEST['ErprobtJahr_von']) and isset($_REQUEST['ErprobtJahr_bis']) ) {
  //   if ($_REQUEST['ErprobtJahr_von']!='') {
  //     $ErprobtJahr_von=(is_numeric($_REQUEST['ErprobtJahr_von'])?$_REQUEST['ErprobtJahr_von']:'');
  //   }
  //   if ($_REQUEST['ErprobtJahr_bis']!='') {
  //     $ErprobtJahr_bis=(is_numeric($_REQUEST['ErprobtJahr_bis'])?$_REQUEST['ErprobtJahr_bis']:''); 
  //   }
  //   if ($ErprobtJahr_von !='' and $ErprobtJahr_bis =='') {
  //     $filterErprobtJahr='='.$ErprobtJahr_von.PHP_EOL; 
  //     $Suche->Beschreibung.='* Erprobt Jahr: '.$ErprobtJahr_von.PHP_EOL;
  //     $filter=true;       
  //   }
  //   if($ErprobtJahr_von !='' and $ErprobtJahr_bis !=''){
  //     $filterErprobtJahr=' BETWEEN '.$ErprobtJahr_von.' AND '.$ErprobtJahr_bis; 
  //     $Suche->Beschreibung.='* Erprobt Jahr: von '.$ErprobtJahr_von.' bis '.$ErprobtJahr_bis.PHP_EOL;
  //     $filter=true; 
  //   }
  // }


/************* Filter Spieldauer  ****************/  
  if ($AnsichtGruppe=='Noten') {
    $spieldauer_von_min=''; // Nutzer-Eingabe 
    $spieldauer_bis_min='';  //  Nutzer-Eingabe 
    $spieldauer_von=''; // Umrechnung, Sekunden 
    $spieldauer_bis=''; // Umrechnung, Sekunden 

    if (isset($_REQUEST['SpieldauerVon']) and isset($_REQUEST['SpieldauerBis']) ) {
      $spieldauer_von_min= $_REQUEST['SpieldauerVon_min']; 
      $spieldauer_bis_min= $_REQUEST['SpieldauerBis_min'];      
      if ($_REQUEST['SpieldauerVon']!='') {
        $spieldauer_von=(is_numeric($_REQUEST['SpieldauerVon'])?$_REQUEST['SpieldauerVon']:'');
      }
      if ($_REQUEST['SpieldauerBis']!='') {
        $spieldauer_bis=(is_numeric($_REQUEST['SpieldauerBis'])?$_REQUEST['SpieldauerBis']:''); 
      }
      if($spieldauer_von !='' and $spieldauer_bis !=''){
        $query_WHERE.=' BETWEEN '.$spieldauer_von.' AND '.$spieldauer_bis; 
        $Suche->Beschreibung.='* Spieldauer: zwischen '.$spieldauer_von_min.' Minuten und '.$spieldauer_bis_min.' Minuten'.PHP_EOL;
        $filter=true; 
      }
    }
    ?>    
    <p><span class="field-caption">Spieldauer (min):</span> 
    von: <input type="text" id="SpieldauerVon_min" name="SpieldauerVon_min" size="5" value="<?php echo $spieldauer_von_min; ?>" oninput="set_SpieldauerVon();"> 
    bis: <input type="text" id="SpieldauerBis_min" name="SpieldauerBis_min" size="5" value="<?php echo $spieldauer_bis_min; ?>" oninput="set_SpieldauerBis();">
    <!-- input-felder für Sekunden, hier verborgen: --> 
    <input style="display:none" type="text" id="SpieldauerBis" name="SpieldauerBis" size="5" value="<?php echo $spieldauer_bis; ?>">
    <input style="display:none" type="text" id="SpieldauerVon" name="SpieldauerVon" size="5" value="<?php echo $spieldauer_von; ?>">
    
    <script type="text/javascript">  
          function set_SpieldauerVon() {
            var txt_min = document.getElementById("SpieldauerVon_min").value;
            var sekunden = getSeconds(txt_min);
            document.getElementById("SpieldauerVon").value=sekunden;         
          }            
          function set_SpieldauerBis() {
            var txt_min = document.getElementById("SpieldauerBis_min").value;
            var sekunden = getSeconds(txt_min);
            document.getElementById("SpieldauerBis").value=sekunden;         
          }   
      </script> 
      
    </p>

    <?php 
  }


/*** Navi-Block "Material */
  if($AnsichtGruppe=='Material') {
    ?>
    <p class="navi-trenner">Material</p> 
    <?php
  }   


/************* Filter Materialtyp  **********/
  if ($AnsichtGruppe=='Material') {
    $materialtyp = new Materialtyp();
    $MaterialtypID=''; 
    if (isset($_POST['MaterialtypID'])) {
      $MaterialtypID = $_POST['MaterialtypID'];           
      if ($MaterialtypID!='') {
        $materialtyp->ID= $MaterialtypID; 
        $materialtyp->load_row(); 
        $query_WHERE.='AND material.MaterialtypID ='.$MaterialtypID.' '.PHP_EOL; 
        $Suche->Beschreibung.=($MaterialtypID!=''?'* Materialtyp: '.$materialtyp->Name.PHP_EOL:'');     
        $filter=true;       
      }
    }
    echo '<p>'; 
    $materialtyp->print_select($MaterialtypID, $materialtyp->Title);
    echo '</p>'; 
  }



      ?>
    <p class="navi-trenner">Besonderheiten</p> 
    <?php

/************* Filter Besonderheiten  **********/
  // if($AnsichtGruppe=='Noten') {

    $lookuptypes=new Lookuptype(); 
    // $lookuptypes->Relation='satz'; 
    $arrLookupTypes=$lookuptypes->getArrData2(); 
    $filterLookups_satz=''; 
    for ($i = 0; $i < count($arrLookupTypes); $i++) {
      // print_r($arrLookupTypes[$i]);  // Test     
      $lookup_check_include=false; // Einschluss-Suche ja/nein 
      $lookup_check_exclude=false;    // Ausschluss-Suche ja/nein
      $lookup_type_name=$arrLookupTypes[$i]["Name"]; 
      $lookup_type_key= $arrLookupTypes[$i]["type_key"]; 

      $relations = $arrLookupTypes[$i]["Relation"];  // array zugeordnete "relations"
      // echo 'Anzahl relations: '.count($relations).'<br>';
      //       echo '1. relation: '.$relations[0].'<br>';

      // print_r($relations); 

      $lookup=New Lookup(); 
      $lookup->LookupTypeID=$arrLookupTypes[$i]["ID"];
      $lookup_values=[]; // alle Lookupwerte eines Typs 
      $lookup_values_selected=[];    // ausgewählte Lookup-Werte 
      $lookup_values_not_selected=[];  // nicht ausgewählte Lookup-Werte 
      // print_r($lookup_values); // Test 
      if (isset($_POST[$lookup_type_key])) {
        $filter=true;       
        $lookup_values_selected= $_POST[$lookup_type_key]; 
        // print_r($lookup_values_selected); // test 
        if (isset($_POST['include_'.$lookup_type_key])) { 
          //  "Einschluss-Suche" aktiviert 
          $lookup_check_include=true;         
          for ($k = 0; $k < count($lookup_values_selected); $k++) {
            $query_WHERE.= getSQL_WHERE_Filter_Lookup_include($lookup_values_selected[$k], $relations); 
          }
        } 
        else {
          //  "Einschluss-Suche" NICHT aktiviert, 
          $query_WHERE.= getSQL_WHERE_Filter_Lookup($lookup_values_selected, $relations);             
        }
        if (isset($_POST['exclude_'.$lookup_type_key])) {    
          // Ausschluss-Suche aktiviert 
          $lookup_values = $lookup->getArrLookups();        
          $lookup_check_exclude=true; 
          $lookup_values_not_selected = array_diff($lookup_values, $lookup_values_selected); // nicht ausgewählte Werte    
          $query_WHERE.='AND satz.ID NOT IN (SELECT DISTINCT SatzID from satz_lookup WHERE LookupID IN ('.implode(',', $lookup_values_not_selected).')) '. PHP_EOL; 
        }      
      }    
      $lookup->print_select_multi($lookup_type_key,$lookup_values_selected, $lookup_type_name.':', true, $lookup_check_include, true,$lookup_check_exclude );
      $Suche->Beschreibung.=(count($lookup_values_selected)>0?$lookup->titles_selected_list:'');   
    }

//  }


?>
</form>
</div> 
<!-- ende class search-filter --> 
<div class="search-result" id="search-result">
<?php

/************* SQL zusammensetzen  **********/  

  $query.=getSQL_SELECT($Ansicht); 

  $query.=getSQL_FROM($Ansicht); 

  // XXXX nicht verwenden ! 
  // switch ($AnsichtEbene){    
  //   case 'Musikstueck': 
  //     $query_WHERE.="AND musikstueck.ID IS NOT NULL ". PHP_EOL;         
  //     break;                  
  //   case 'Satz': 
  //     $query_WHERE.="AND satz.ID IS NOT NULL ". PHP_EOL;             
  //     break;      
  // }
  
  $query.=$query_WHERE; 

  if($suchtext!='') {
    $query_WHERE_Suchtext=getSQL_WHERE_Suchtext($AnsichtGruppe, $suchtext); 
    $query.=$query_WHERE_Suchtext; 
    // XXX groß-klein - Schreibung berücksichtigen 
  }

  $query.= getSQL_GROUP_BY($AnsichtEbene); 

  $query.= getSQL_ORDER_BY($Ansicht, $filter); 

/************* Falls kein Filter ausgewählt wurde **********/  
  if(!$filter) {
    echo 'Es wurde kein Filter gesetzt'.PHP_EOL;
    goto keinFilter; 
  } 

/************* Ergebnistabelle anzeigen bzw. alternativ Suche speichern  **********/  

  if (isset($_POST["SucheSpeichern"])) {
    $timestamp = time();
    $Suche->Name= 'Suche '.date("d.m.Y - H:i", time()); // Temp. Name, kann später geändert werden
    $Suche->Abfrage = $query; 
    $Suche->Tabelle = $edit_table;
    $Suche->Abfragetyp='Suche';  
    $Suche->insert_row2(); 
    echo '<p>Die Suchabfrage wurde gespeichert <br />'; 
    echo '<a href="show_abfrage.php?ID='.$Suche->ID.'&title=Abfrage" target="_blank">Ergebnis anzeigen</a>
        | <a href="edit_abfrage.php?ID='.$Suche->ID.'&title=Abfrage&option=edit" target="_blank">Abfrage bearbeiten</a>
        | <a href="show_table2.php?table=v_abfrage&sortcol=ID&sortorder=DESC&title=Abfragen&add_link_show&show_filter" target="_blank">Übersicht Abfragen</a>         
        ';
    
    goto keinFilter; 
    
  } 

  if ($Suche->Beschreibung!='') {
    echo '<pre>'.$Suche->Beschreibung.'</pre>';
  }

  include_once("classes/dbconn/class.db.php");
  $conn = new DBConnection(); 
  $db=$conn->db; 
  
  $select = $db->prepare($query); 

    
  try {
    $select->execute(); 
    include_once("classes/class.htmltable.php");      
    $html = new HTML_Table($select); 
    $html->add_link_edit=true; 
    $html->edit_link_table=$edit_table; 
    $html->edit_link_title=$Ansicht; 
    $html->edit_link_open_newpage=true; 
    $html->show_row_count=true; 
    $html->print_table2(); 
  }
  catch (PDOException $e) {
    include_once("classes/class.htmlinfo.php"); 
    $info = new HTML_Info();      
    $info->print_user_error(); 
    $info->print_error($select, $e); 
  }    

  echo '<pre style="font-size: 11px; visibility: hidden;">'.$query.'</pre>'; // Test  

  keinFilter: 

?>
</div> <!-- end class search-result -->
</div> <!-- end class search-page -->

<?php 
 
include_once('foot.php');
?>
