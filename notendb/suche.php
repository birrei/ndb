<?php 
include('head.php');
include("dbconn/cl_db.php");

include("cl_html_table.php");    
include("cl_html_info.php");  

include("cl_besetzung.php");  
include("cl_verwendungszweck.php"); 
include("cl_standort.php"); 
include("cl_komponist.php"); 
include("cl_verlag.php"); 
include("cl_gattung.php"); 
include("cl_epoche.php"); 
include("cl_erprobt.php");  
include("cl_schwierigkeitsgrad.php");  
include("cl_instrument.php");  

include("cl_lookup.php");   
include("cl_lookuptype.php");
include("cl_linktype.php");
include("cl_abfrage.php");

$Standorte=[];   /* Sammlung */
// $Verlage=[];   /* Sammlung */
$Linktypen=[];   /* Sammlung */

$Komponisten=[];  // im Suchfilter ausgewählte Komponisten (IDs) 
$Besetzungen=[]; // im Suchfilter ausgewählte Besetzungen (IDs) 
$Verwendungszwecke=[];  // im Suchfilter ausgewählte Verwendungszwecke (IDs) 
$Gattungen=[];  // im Suchfilter ausgewählte Gattungen (IDs) 
$Epochen=[];   // im Suchfilter ausgewählte Epochen (IDs) 

$Erprobt=[];  // im Suchfilter ausgewählte Erprobt-Einträge  (IDs) 
$Schierigkeitsgrad=[]; // im Suchfilter ausgewählte Schwierigkeitsgrade  (IDs) 
$Instrumente=[]; // im Suchfilter ausgewählte Instrumente  (IDs) 
$Stricharten=[];  // im Suchfilter ausgewählte Stricharten  (IDs) 
$Notenwerte=[]; // im Suchfilter ausgewählte Notenwerte  (IDs) 
$Uebungen=[]; // im Suchfilter ausgewählte Übung-Einträge  (IDs) 

$lookup_all_values_selected=[]; // im Suchfilter ausgewählte Besonderheiten-IDs (gesammelt aus allen lookup-types) ?


$ErprobtJahr_von=''; 
$ErprobtJahr_bis=''; 

$suchtext=''; 

/***************************/



$filterStandorte='';   
$filterVerlage='';
$filterLinktypen='';      
$filterBesetzung=''; 
$filterVerwendungszweck='';
$filterKomponisten='';   
$filterGattungen='';  
$filterEpochen='';    
// $filterStricharten=''; 
// $filterNotenwerte='';  
// $filterUebungen='';  
$filterErprobt=''; 
$filterSchwierigkeitsgrad=''; 
$filterInstrumente=''; 

$filterLookups=''; 
$filterSpieldauer='';
$filterErprobtJahr='';     
$filterSuchtext='';  

$filter=false; 

$edit_table=''; /* Tabelle, die über Bearbeiten-Links in Ergebnis-Tabelle abrufbar sein soll */

$Suche = new Abfrage();

if (isset($_POST['Ansicht'])) {
  $Ansicht=$_POST["Ansicht"];
} else {
  $Ansicht='Sammlung'; // default 
}
?> 
<div class="search-page">
<div class="search-filter">
<form id="Suche" action="" method="post">

<!---- Ansicht -----> 
<?php
$Suche->Beschreibung.='* Ansicht: '.$Ansicht.PHP_EOL; 
?>
<b>Ansicht: </b>
<select id="Ansicht" name="Ansicht">
          <option value="Sammlung" <?php echo ($Ansicht=='Sammlung'?'selected':'');?>>Sammlung</option>      
          <option value="Musikstueck" <?php echo ($Ansicht=='Musikstueck'?'selected':'');?>>Musikstück</option>
          <option value="Satz" <?php echo ($Ansicht=='Satz'?'selected':'')?>>Satz</option>
          <option value="Sammlung Links" <?php echo ($Ansicht=='Sammlung Links'?'selected':'')?>>Sammlung Links</option>          
</select>

<!---- Entscheidung Suche speichern ja / nein -----> 
&nbsp; &nbsp; <input type="checkbox" id="sp" name="SucheSpeichern"><label for="sp">Suche speichern</label> 

<!---- Suche starten -----> 
<p><input class="btnSave" type="submit" value="Suchen" class="btnSave">

<!-- Button: alle Filter zurücksetzen --> 
<input type="button" id="btnReset_All" value="Alle Filter zurücksetzen" onclick="Reset_All();" /> 
<script type="text/javascript">  
          function Reset_All() {  
          for(i=0; i<document.forms[0].elements.length; i++){
            if(document.forms[0].elements[i].type == 'text'){
              document.forms[0].elements[i].value=""; 
            }
            if(document.forms[0].elements[i].type == 'select-one'){
              document.forms[0].elements[i].selectedIndex = -1;
            }   
            if(document.forms[0].elements[i].type == 'select-multiple'){
              document.forms[0].elements[i].selectedIndex = -1;
            }               
          }
      }  
</script> 

<?php 
/************** Suchtext  **********/  

if (isset($_POST['suchtext'])) {
  $suchtext = $_POST['suchtext'];  
  if ($suchtext!='') { 
      $Suche->Beschreibung.='* Suchtext: '.$suchtext.PHP_EOL; 
      $filter=true; 
  }
}  
?>
<p>Suchtext: <input type="text" id="suchtext" name="suchtext" size="30px" value="<?php echo $suchtext; ?>" autofocus> 
  <!-- XXX verworfen
      <input type="button" id="btnReset_suchtext" value="Suchtext leeren" onclick="Reset_suchtext();" />  
      <script type="text/javascript">  
              function Reset_suchtext() {  
                document.getElementById("suchtext").value='';  
          }  
      </script>  -->

<p class="navi-trenner">Sammlung </p> 

<?php
/************* Verlag  ***********/
 
  $verlag = new Verlag();
  $VerlagID=''; 
  if (isset($_POST['VerlagID']) ) {
    if ($_POST['VerlagID']!='') {
      $VerlagID = $_POST['VerlagID']; 
      $verlag->ID=  $VerlagID; 
      $verlag->load_row(); 
      $filterVerlage='='.$VerlagID.' '; 
      $Suche->Beschreibung.=($VerlagID!=''?'* Verlag: '.$verlag->Name.PHP_EOL:'');     
      $filter=true;    
    }   
  }
  echo '<p>';
  $verlag->print_select($VerlagID, $verlag->Title.': &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;');
  echo '</p>';
 // multi-select (verworfen)
  // if (isset($_POST['Verlage'])) {
  //   $Verlage = $_POST['Verlage']; 
  //   $filterVerlage = 'IN ('.implode(',', $Verlage).')'; 
  //   $filter=true;       
  // }
  // $verlag = new Verlag();
  // $verlag->print_select_multi($Verlage);
  // $verlag->print_select_multi($Verlage);
  // $Suche->Beschreibung.=(count($Verlage)>0?$verlag->titles_selected_list:'');    


/************* Standort  ***********/

  $standort = new Standort();
  $StandortID=''; 
  if (isset($_POST['StandortID'])) {
    if ( $_POST['StandortID']!='') {
      $StandortID = $_POST['StandortID']; 
      $standort->ID=  $StandortID; 
      $standort->load_row(); 
      $filterStandorte='='.$StandortID.' '; 
      $Suche->Beschreibung.=($StandortID!=''?'* Standort: '.$standort->Name.PHP_EOL:'');     
      $filter=true;       
   }
  }
  echo '<p>';
  $standort->print_select($StandortID, $standort->Title.': &nbsp;');
  echo '</p>';
  // if (isset($_POST['Standorte'])) {
  //   $Standorte = $_POST['Standorte'];   // Array gewählte Standorte 
  //   $filterStandorte = 'IN ('.implode(',', $Standorte).')'; 
  //   $filter=true;     
  // }
  // $standort = new Standort();
  // $standort->print_select_multi($Standorte);      
  // $Suche->Beschreibung.=(count($Standorte)>0?$standort->titles_selected_list:'');    

/*********  Sammlung Besonderheiten **********/  
  // XXX noch analog zu Satz Besonderheiten umsetzen (Genaue Suche)
  $lookuptypes=new Lookuptype(); 
  $lookuptypes->Relation='sammlung'; 
  $lookuptypes->setArrData(); 
  $filterLookups_sammlung=''; 

  for ($i = 0; $i < count($lookuptypes->ArrData); $i++) {
    $lookup=New Lookup(); 
    $lookup->LookupTypeID=$lookuptypes->ArrData[$i]["ID"];
    $lookup_type_name=$lookuptypes->ArrData[$i]["Name"]; 
    $lookup_type_key= $lookuptypes->ArrData[$i]["type_key"]; // z.B: "besdynam" ect.  
    $lookup_values_selected=[];      
    if (isset($_POST[$lookup_type_key])) {
      $lookup_values_selected= $_POST[$lookup_type_key]; 
      $filterLookups_sammlung.=' AND sammlung_lookup.LookupID IN ('.implode(',', $lookup_values_selected).') -- '.$lookup_type_name.''. PHP_EOL; 
      $filter=true; 
    } 
    $lookup->print_select_multi($lookup_type_key,$lookup_values_selected, $lookup_type_name.':');
    $Suche->Beschreibung.=(count($lookup_values_selected)?$lookup->titles_selected_list:'');   
  }

/************ Linktypen  ************** */  

  if (isset($_POST['Linktypen'])) {
    $Linktypen = $_POST['Linktypen']; 
    $filterLinktypen = 'IN ('.implode(',', $Linktypen).')'; 
    $filter=true;       
  }  
  $linktyp = new Linktype();
  $linktyp->print_select_multi($Linktypen);      
  $Suche->Beschreibung.=(count($Linktypen)>0?$linktyp->titles_selected_list:''); 

?>
<p class="navi-trenner">Musikstück </p> 
<?php 

/************* Komponist  ***********/
  $komponist = new Komponist();
  $KomponistID=''; 
  if (isset($_POST['KomponistID'])) {
    if ($_POST['KomponistID']!='') {
      $KomponistID = $_POST['KomponistID']; 
      $komponist->ID=  $KomponistID; 
      $komponist->load_row(); 
      $filterKomponisten='='.$KomponistID.' '; 
      $Suche->Beschreibung.=($KomponistID!=''?'* Komponist: '.$komponist->Name.PHP_EOL:'');     
      $filter=true;       
    }
  }
  $komponist->print_select($KomponistID,$komponist->Title .' : &nbsp;&nbsp;&nbsp;');


  // if (isset($_POST['Komponisten'])) {
  //   $Komponisten = $_POST['Komponisten'];   
  //   $filterKomponisten = 'IN ('.implode(',', $Komponisten).')'; 
  //   $filter=true;        
  // }   
  // $komponist = new Komponist();
  // $komponist->print_select_multi($Komponisten);     
  // $Suche->Beschreibung.=(count($Komponisten)>0?$komponist->titles_selected_list:''); 
 

/************* Besetzungen  ***********/
  if (isset($_POST['Besetzungen'])) {
    $Besetzungen = $_POST['Besetzungen'];    
    $filterBesetzung = 'IN ('.implode(',', $Besetzungen).')'; 
    $filter=true;        
  }
  $besetzung = new Besetzung();
  $besetzung->print_select_multi($Besetzungen); 
  $Suche->Beschreibung.=(count($Besetzungen)>0?$besetzung->titles_selected_list:'');  

/************* Verwendungszwecke  ***********/
  if (isset($_POST['Verwendungszwecke'])) {
    $Verwendungszwecke = $_POST['Verwendungszwecke'];   
    $filterVerwendungszweck = 'IN ('.implode(',', $Verwendungszwecke).')'; 
    $filter=true;     
  }  
  $verwendungszweck = new Verwendungszweck();
  $verwendungszweck->print_select_multi($Verwendungszwecke);    
  $Suche->Beschreibung.=(count($Verwendungszwecke)>0?$verwendungszweck->titles_selected_list:'');  

/************* Gattung  ***********/

  $gattung = new Gattung();
  $GattungID=''; 
  if (isset($_POST['GattungID'])) {
      if ($_POST['GattungID']!='') {
      $GattungID = $_POST['GattungID']; 
      $gattung->ID=  $GattungID; 
      $gattung->load_row(); 
      $filterGattungen='='.$GattungID.' '; 
      $Suche->Beschreibung.=($GattungID!=''?'* Gattung: '.$gattung->Name.PHP_EOL:'');     
      $filter=true;       
    }
  }
  echo '<p>'; 
  $gattung->print_select($GattungID, $gattung->Title .' : &nbsp;&nbsp;&nbsp;');
  echo '</p>'; 

  // if (isset($_POST['Gattungen'])) {
  //   $Gattungen = $_POST['Gattungen'];  
  //   $filterGattungen = 'IN ('.implode(',', $Gattungen).')'; 
  //   $filter=true;     
  // }      
  // $gattung = new Gattung();
  // $gattung->print_select_multi($Gattungen);  
  // $Suche->Beschreibung.=(count($Gattungen)>0?$gattung->titles_selected_list:'');


/************* Epochen  ***********/
  $epoche = new Epoche();
  $EpocheID=''; 
  if (isset($_POST['EpocheID'])) {
    if ($_POST['EpocheID']!='') { 
      $EpocheID = $_POST['EpocheID']; 
      $epoche->ID=  $EpocheID; 
      $epoche->load_row(); 
      $filterEpochen='='.$EpocheID.' '; 
      $Suche->Beschreibung.=($EpocheID!=''?'* Epoche: '.$epoche->Name.PHP_EOL:'');     
      $filter=true;     
    }  
  }
  echo '<p>'; 
  $epoche->print_select($EpocheID, $epoche->Title .' : &nbsp;&nbsp;&nbsp;');
  echo '</p>'; 

  // if (isset($_POST['Epochen'])) {
  //   $Epochen = $_POST['Epochen'];   
  //   $filterEpochen = 'IN ('.implode(',', $Epochen).')'; 
  //   $filter=true; 
  // }    
  // $epochen = new Epoche();
  // $epochen->print_select_multi($Epochen); 
  // $Suche->Beschreibung.=(count($Epochen)>0?$epochen->titles_selected_list:'');  
  
  ?>
  <p class="navi-trenner">Satz</p> 
  <?php   
/************* Schwierigkeitsgrad  ***********/
  if (isset($_POST['Schwierigkeitsgrad'])) {
    $Schierigkeitsgrad = $_POST['Schwierigkeitsgrad']; 
    $filterSchwierigkeitsgrad= 'IN ('.implode(',', $Schierigkeitsgrad).')'; 
    $filter=true;       
  }
  $schierigkeitsgrad = new Schwierigkeitsgrad();
  $schierigkeitsgrad->print_select_multi($Schierigkeitsgrad);  
  $Suche->Beschreibung.=(count($Schierigkeitsgrad)>0?$schierigkeitsgrad->titles_selected_list:'');
 
/************* Schwierigkeitsgrad / Instrumente  ***********/
  if (isset($_POST['Instrumente'])) {
    $Instrumente = $_POST['Instrumente'];  
    $filterInstrumente= 'IN ('.implode(',', $Instrumente).')'; 
    $filter=true;      
  } 
  $instrument = new Instrument();
  $instrument->print_select_multi($Instrumente);        
  $Suche->Beschreibung.=(count($Instrumente)>0?$instrument->titles_selected_list:'');
  
/************* Erprobt  ***********/
  if (isset($_POST['Erprobt'])) {
    $Erprobt = $_POST['Erprobt'];   
    $filterErprobt= 'IN ('.implode(',', $Erprobt).')'; 
    $filter=true;     
  } 
  $erprobt = new Erprobt();
  $erprobt->print_select_multi($Erprobt);  
  $Suche->Beschreibung.=(count($Erprobt)>0?$erprobt->titles_selected_list:'');            

  /************* Erprobt Jahr ***********/
  if (isset($_REQUEST['ErprobtJahr_von']) and isset($_REQUEST['ErprobtJahr_bis']) ) {
    if ($_REQUEST['ErprobtJahr_von']!='') {
      $ErprobtJahr_von=(is_numeric($_REQUEST['ErprobtJahr_von'])?$_REQUEST['ErprobtJahr_von']:'');
    }
    if ($_REQUEST['ErprobtJahr_bis']!='') {
      $ErprobtJahr_bis=(is_numeric($_REQUEST['ErprobtJahr_bis'])?$_REQUEST['ErprobtJahr_bis']:''); 
    }
    if ($ErprobtJahr_von !='' and $ErprobtJahr_bis =='') {
      $filterErprobtJahr='='.$ErprobtJahr_von.PHP_EOL; 
      $Suche->Beschreibung.='* Erprobt Jahr: '.$ErprobtJahr_von.PHP_EOL;
      $filter=true;       
    }
    if($ErprobtJahr_von !='' and $ErprobtJahr_bis !=''){
      $filterErprobtJahr=' BETWEEN '.$ErprobtJahr_von.' AND '.$ErprobtJahr_bis; 
      $Suche->Beschreibung.='* Erprobt Jahr: von '.$ErprobtJahr_von.' bis '.$ErprobtJahr_bis.PHP_EOL;
      $filter=true; 
    }
  }

  ?>    
  <p><span class="field-caption">Erprobt Jahr:</span> 
  von: <input type="text" id="ErprobtJahr_von" name="ErprobtJahr_von" size="5"  value="<?php echo $ErprobtJahr_von; ?>"> 
  bis: <input type="text" id="ErprobtJahr_bis" name="ErprobtJahr_bis" size="5" value="<?php echo $ErprobtJahr_bis; ?>">
  <!-- 
  XXX verworfen (AG: OK?)
  <input type="button" id="btnReset_ErprobtJahr" value="Filter zurücksetzen" onclick="Reset_ErprobtJahr();" />  
  <script type="text/javascript">  
        function Reset_ErprobtJahr() {  
          document.getElementById("ErprobtJahr_von").value='';  
          document.getElementById("ErprobtJahr_bis").value='';  
        }
    </script>  
    -->
  </p>
 
  <?php  
  
/*******  Spieldauer  ****************/  
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
      // $spieldauer_von = $spieldauer_von * 60;         
      // $spieldauer_bis = $spieldauer_bis * 60;            
      $filterSpieldauer=' BETWEEN '.$spieldauer_von.' AND '.$spieldauer_bis; 
      // $Suche->Beschreibung.='* Spieldauer: zwischen '.$spieldauer_von.' und '.$spieldauer_bis.' Sekunden'.PHP_EOL;
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
  
  <!-- XXX verworfen <input type="button" id="btnReset_Spieldauer" value="Filter zurücksetzen" onclick="Reset_Spieldauer();" />   -->
  <script type="text/javascript">  
        // XXX verworfen
        // function Reset_Spieldauer() {  
        //   document.getElementById("SpieldauerVon").value='';  
        //   document.getElementById("SpieldauerBis").value='';  
        // }
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

/************** Besonderheiten Satz **********/

  $lookuptypes=new Lookuptype(); 
  $lookuptypes->Relation='satz'; 
  $lookuptypes->setArrData(); 
  $filterLookups_satz=''; 

  for ($i = 0; $i < count($lookuptypes->ArrData); $i++) {
    // print_r($lookuptypes->ArrData[$i]);  // Test     
    $lookup_check_excl=false; 
    $lookup_type_name=$lookuptypes->ArrData[$i]["Name"]; 
    $lookup_type_key= $lookuptypes->ArrData[$i]["type_key"]; 
    $lookup=New Lookup(); 
    $lookup->LookupTypeID=$lookuptypes->ArrData[$i]["ID"];
    $lookup_values=[]; // alle Lookupwerte eines Typs 
    $lookup_values_selected=[];    // ausgewählte Lookup-Werte 
    $lookup_values_not_selected=[];  // nicht ausgewählte Lookup-Werte 
    $lookup_values = $lookup->getArrLookups();
    // print_r($lookup_values); // Test 
    if (isset($_POST[$lookup_type_key])) {
      $filter=true;       
      $lookup_values_selected= $_POST[$lookup_type_key]; 
      // print_r($lookup_values_selected); // test 
      if (isset($_POST['ex_'.$lookup_type_key])) {
        // Checkbox "Genaue Suche" wurde aktiviert 
        $lookup_check_excl=true; 
        // ausgewählte Eintraege filtern           
        for ($i = 0; $i < count($lookup_values_selected); $i++) {
          $filterLookups_satz.=' AND satz.ID IN (SELECT SatzID from satz_lookup WHERE LookupID='.$lookup_values_selected[$i].') '. PHP_EOL; 
        }
        $lookup_values_not_selected = array_diff($lookup_values, $lookup_values_selected); // nicht ausgewählte Werte    
        // nicht ausgewählte Eintraege wegfiltern 
        $filterLookups_satz.=' AND satz.ID NOT IN (SELECT DISTINCT SatzID from satz_lookup WHERE LookupID IN ('.implode(',', $lookup_values_not_selected).')) '. PHP_EOL; 
      } 
      else {
        $filterLookups_satz.=' AND satz_lookup.LookupID IN ('.implode(',', $lookup_values_selected).') '. PHP_EOL;         
      }
      // echo '<pre>'.$filterLookups_satz.'</pre>'; 
    } 
    $lookup->print_select_multi($lookup_type_key,$lookup_values_selected, $lookup_type_name.':', true, $lookup_check_excl);
    $Suche->Beschreibung.=(count($lookup_values_selected)>0?$lookup->titles_selected_list:'');   
  }
 
  ?>
</form>
</div> <!-- ende class search-filter --> 
<div class="search-table">
<?php

  if ($filter ) {
    $query=""; 

    switch ($Ansicht){
      case 'Sammlung': 
        $query.="SELECT sammlung.ID
            ,sammlung.Name as Sammlung
            , standort.Name as Standort
            , verlag.Name as Verlag
            , sammlung.Bemerkung 
            , GROUP_CONCAT(DISTINCT musikstueck.Nummer order by musikstueck.Nummer SEPARATOR ', ') Musikstuecke
            , v_sammlung_lookuptypes.LookupList as Besonderheiten   
            , GROUP_CONCAT(DISTINCT linktype.Name order by linktype.Name SEPARATOR ', ') Links                             
            ";
        $edit_table='sammlung'; 
          break; 

        case 'Sammlung Links': 
            $query.="SELECT sammlung.ID
                , standort.Name as Standort
                , sammlung.Name as Sammlung
                , linktype.Name as LinkTyp
                , link.Bezeichnung
                , link.URL
                ";
            $edit_table='sammlung'; 
              break;    
      case 'Musikstueck': 
        $query.="SELECT musikstueck.ID
            ,sammlung.Name as Sammlung
            , standort.Name as Standort
            , musikstueck.Nummer as MNr
            , musikstueck.Name as Musikstueck
            , komponist.Name as Komponist
            , musikstueck.Bearbeiter 
            , gattung.Name as Gattung 
            , epoche.Name as Epoche         
            , GROUP_CONCAT(DISTINCT besetzung.Name order by besetzung.Name SEPARATOR ', ') Besetzungen
            , GROUP_CONCAT(DISTINCT verwendungszweck.Name order by verwendungszweck.Name SEPARATOR ', ') Verwendungszwecke   
            , GROUP_CONCAT(DISTINCT satz.Nr order by satz.Nr SEPARATOR ', ') Saetze                 
            ";         

        $edit_table='musikstueck'; 
          break; 

      case 'Satz': 
        $query.="SELECT satz.ID
            ,sammlung.Name as Sammlung
            , musikstueck.Nummer as MNr
            , musikstueck.Name as Musikstueck
            , satz.Nr as SatzNr
            , satz.Name as Satz 
            , satz.Tonart 
            , satz.Taktart
            , satz.Tempobezeichnung
            , concat(
                satz.Spieldauer DIV 60
                ,''''
                , 
                satz.Spieldauer MOD 60
                , ''''''
              ) as Spieldauer              
            , GROUP_CONCAT(DISTINCT concat(instrument.Name, ': ', schwierigkeitsgrad.Name)  order by schwierigkeitsgrad.Name SEPARATOR ', ') `Schwierigkeitsgrade`                   
            , GROUP_CONCAT(DISTINCT  
                CASE 
	                when satz_erprobt.Jahr is null 
  		            then erprobt.Name 
  		            else concat(satz_erprobt.Jahr, ': ', erprobt.Name)
  	            end 
                order by satz_erprobt.Jahr 
                DESC SEPARATOR ', ') as Erprobt                
            , v_satz_lookuptypes.LookupList as Besonderheiten                  
            , satz.Orchesterbesetzung 
            , satz.Bemerkung                         
            ";        
      $edit_table='satz';                 
        break;      

    }

    $query.="
      FROM sammlung 
        LEFT JOIN standort  on sammlung.StandortID = standort.ID    
        LEFT JOIN verlag  on sammlung.VerlagID = verlag.ID
        LEFT JOIN link  on sammlung.ID = link.SammlungID
        LEFT JOIN linktype  on linktype.ID = link.LinktypeID
        LEFT JOIN musikstueck on sammlung.ID = musikstueck.SammlungID 
        LEFT JOIN v_komponist komponist on komponist.ID = musikstueck.KomponistID
        LEFT JOIN gattung on gattung.ID = musikstueck.GattungID  
        LEFT JOIN epoche on epoche.ID = musikstueck.EpocheID              
        LEFT JOIN musikstueck_besetzung on musikstueck.ID = musikstueck_besetzung.MusikstueckID
        LEFT JOIN besetzung on musikstueck_besetzung.BesetzungID = besetzung.ID
        LEFT JOIN musikstueck_verwendungszweck on musikstueck.ID = musikstueck_verwendungszweck.MusikstueckID 
        LEFT JOIN verwendungszweck on musikstueck_verwendungszweck.VerwendungszweckID=verwendungszweck.ID    
        LEFT JOIN satz on satz.MusikstueckID = musikstueck.ID 
        LEFT JOIN satz_erprobt on satz.ID = satz_erprobt.SatzID 
        LEFT JOIN erprobt on erprobt.ID = satz_erprobt.ErprobtID  
        left JOIN satz_schwierigkeitsgrad on satz_schwierigkeitsgrad.SatzID = satz.ID 
        LEFT JOIN schwierigkeitsgrad on schwierigkeitsgrad.ID = satz_schwierigkeitsgrad.SchwierigkeitsgradID 
        LEFT JOIN instrument on instrument.ID = satz_schwierigkeitsgrad.InstrumentID 
        LEFT JOIN satz_lookup on satz_lookup.SatzID = satz.ID 
        LEFT JOIN v_satz_lookuptypes on v_satz_lookuptypes.SatzID = satz.ID
        LEFT JOIN sammlung_lookup on sammlung_lookup.SammlungID = sammlung.ID       
        LEFT JOIN v_sammlung_lookuptypes on v_sammlung_lookuptypes.SammlungID = sammlung.ID 

      WHERE 1=1 ". PHP_EOL; 

      switch ($Ansicht){    
        case 'Musikstueck': 
          $query.=" AND musikstueck.ID IS NOT NULL ". PHP_EOL;         
          break; 
        case 'Satz': 
          $query.=" AND satz.ID IS NOT NULL ". PHP_EOL;             
          break;      
      }

     /* Filter ergänzen */   
      if($filterStandorte!=''){ 
        $query.=' AND sammlung.StandortID '.$filterStandorte. PHP_EOL; 
      } 
      if($filterVerlage!=''){
        $query.=' AND sammlung.VerlagID '.$filterVerlage. PHP_EOL; 
      }
      if($filterLinktypen!=''){
        $query.=' AND link.LinktypeID '.$filterLinktypen. PHP_EOL; 
      }             
      if($filterKomponisten!=''){
        $query.=' AND musikstueck.KomponistID '.$filterKomponisten. PHP_EOL; 
      }            
      if($filterBesetzung!=''){
        $query.=' AND musikstueck_besetzung.BesetzungID '.$filterBesetzung. PHP_EOL; 
      }
      if($filterVerwendungszweck!=''){
        $query.=' AND musikstueck_verwendungszweck.VerwendungszweckID '.$filterVerwendungszweck. PHP_EOL; 
      }
      if($filterGattungen!=''){
        $query.=' AND musikstueck.GattungID '.$filterGattungen. PHP_EOL; 
      }    
      if($filterEpochen!=''){
        $query.=' AND musikstueck.EpocheID '.$filterEpochen. PHP_EOL; 
      }           

      $query.=($filterErprobt!=''?' AND satz_erprobt.ErprobtID '.$filterErprobt. PHP_EOL:''); 

      $query.=($filterErprobtJahr!=''?' AND satz_erprobt.Jahr '.$filterErprobtJahr. PHP_EOL:'');       

      if($filterSchwierigkeitsgrad!=''){
        $query.=' AND satz_schwierigkeitsgrad.SchwierigkeitsgradID '.$filterSchwierigkeitsgrad. PHP_EOL; 
      }
      if($filterInstrumente!=''){
        $query.=' AND satz_schwierigkeitsgrad.InstrumentID '.$filterInstrumente. PHP_EOL; 
      }
      $query.=($filterLookups_sammlung!=''?$filterLookups_sammlung.PHP_EOL:''); 
      $query.=($filterLookups_satz!=''?$filterLookups_satz.PHP_EOL:''); 
                       
      if($filterSpieldauer!=''){
        $query.=' AND satz.Spieldauer '.$filterSpieldauer. PHP_EOL; 
      }
 
      if($suchtext!=''){
        $query.="AND (sammlung.Name LIKE '%".$suchtext."%' OR  
                            sammlung.Bemerkung LIKE '%".$suchtext."%' OR 
                            sammlung.Bestellnummer LIKE '%".$suchtext."%' OR
                            musikstueck.Name LIKE '%".$suchtext."%' OR                              
                            musikstueck.Opus LIKE '%".$suchtext."%' OR
                            musikstueck.Bearbeiter LIKE '%".$suchtext."%' OR
                            satz.Name LIKE '%".$suchtext."%' OR
                            satz.Taktart LIKE '%".$suchtext."%' OR
                            satz.Tonart LIKE '%".$suchtext."%' OR
                            satz.Tempobezeichnung LIKE '%".$suchtext."%' OR
                            satz.Bemerkung LIKE '%".$suchtext."%' OR 
                            satz.Orchesterbesetzung LIKE '%".$suchtext."%' OR
  	                        verlag.Name LIKE '%".$suchtext."%' OR
                            standort.Name LIKE '%".$suchtext."%' OR  
                            komponist.Name LIKE '%".$suchtext."%' OR 
                            gattung.Name LIKE '%".$suchtext."%' OR 
                            epoche.Name LIKE '%".$suchtext."%' OR  
                            besetzung.Name LIKE '%".$suchtext."%' OR 
                            verwendungszweck.Name LIKE '%".$suchtext."%' OR 
                            v_satz_lookuptypes.LookupList LIKE '%".$suchtext."%' OR
                            v_sammlung_lookuptypes.LookupList LIKE '%".$suchtext."%'                            
                            )". PHP_EOL;         
      }

      /* Gruppierung abhängig von Ansicht   */
      switch ($Ansicht){    
        case 'Sammlung':         
          $query.=" group by sammlung.ID". PHP_EOL;     
          break;    
        case 'Sammlung Links':         
            $query.=" group by sammlung.ID, link.Bezeichnung". PHP_EOL;     
            break;                      
        case 'Musikstueck': 
         $query.=" group by musikstueck.ID". PHP_EOL;    
          // $query.=" group by satz.MusikstueckID". PHP_EOL;     
          break; 
        case 'Satz': 
          $query.=" group by satz.ID". PHP_EOL;             
          break;      
      }

      /* Sortierung abhängig von Ansicht  */
      switch ($Ansicht){    
        case 'Sammlung': 
        case 'Sammlung Links':             
          $query.=" ORDER BY standort.Name, sammlung.Name". PHP_EOL;     
          break; 
        case 'Musikstueck': 
          $query.=" ORDER BY standort.Name, sammlung.Name, musikstueck.Nummer". PHP_EOL;         
          break; 
        case 'Satz': 
          $query.=" ORDER BY standort.Name, sammlung.Name, musikstueck.Nummer, satz.Nr". PHP_EOL;           
          break;      
      }

    // echo '<pre>'.$query.'</pre>'; // Test  
      // echo '<pre>'.$filterLookups_satz.'</pre>'; // Test    
    
      if ($Suche->Beschreibung!='') {
        echo '<p>Auswahl:</p><pre>'.$Suche->Beschreibung.'</pre>';
      }

      if (isset($_POST["SucheSpeichern"])) {
        $timestamp = time();
        $Suche->Name= 'Suche '.date("d.m.Y - H:i", time()); // Temp. Name, kann später geändert werden
        $Suche->Abfrage = $query; 
        $Suche->Tabelle = $edit_table;
        $Suche->Abfragetyp='Suche';  
        $Suche->insert_row2(); 
        echo '<p>Die Suchabfrage wurde gespeichert: <br />'; 
        echo '<a href="show_abfrage.php?ID='.$Suche->ID.'&title=Abfrage" target="_blank">Abfrage-Ergebnis anzeigen</a>
            | <a href="edit_abfrage.php?ID='.$Suche->ID.'&title=Abfrage&option=edit" target="_blank">Abfrage bearbeiten</a>
            | <a href="show_table2.php?table=v_abfrage&sortcol=ID&sortorder=DESC&title=Abfragen&add_link_show&show_filter" target="_blank">Übersicht Abfragen</a>         
            ';
            
        } else {
          // Abfrage nicht speichern, Ergebnis ausgeben           
          include_once("dbconn/cl_db.php");
          $conn = new DbConn(); 
          $db=$conn->db; 
          
          $select = $db->prepare($query); 
            
          try {
            $select->execute(); 
            include_once("cl_html_table.php");      
            $html = new HtmlTable($select); 
            $html->add_link_edit=true; 
            $html->edit_link_table=$edit_table; 
            $html->edit_link_title=$Ansicht; 
            $html->edit_link_open_newpage=true; 
            $html->show_row_count=true; 
            $html->print_table2(); 
          }
          catch (PDOException $e) {
            include_once("cl_html_info.php"); 
            $info = new HtmlInfo();      
            $info->print_user_error(); 
            $info->print_error($select, $e); 
          }    
      }

    } // Ende if($filter)
    else {
      echo '<p>Es wurde kein Filter gesetzt. </p>'; 
    }
 ?>
</div> <!-- end class search-table -->
</div> <!-- end class search-page -->

<?php 
include('foot.php');
?>
