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

// include("cl_schwierigkeitsgrad.php");  
// include("cl_instrument.php");  
include("cl_instrument_schwierigkeitsgrad.php");  

include("cl_lookup.php");   
include("cl_lookuptype.php");
include("cl_linktype.php");
include("cl_abfrage.php");
include("cl_schueler.php");

$Standorte=[];   /* Sammlung */
// $Verlage=[];   /* Sammlung */
$Linktypen=[];   /* Sammlung */

$Komponisten=[];  // im Suchfilter ausgewählte Komponisten (IDs) 

$Verwendungszwecke=[];  // im Suchfilter ausgewählte Verwendungszwecke (IDs) 
$Gattungen=[];  // im Suchfilter ausgewählte Gattungen (IDs) 
$Epochen=[];   // im Suchfilter ausgewählte Epochen (IDs) 

$Erprobt=[];  // im Suchfilter ausgewählte Erprobt-Einträge  (IDs) 
$Schwierigkeitsgrade=[]; // im Suchfilter ausgewählte Schwierigkeitsgrade  (IDs). Instrument/Schwierigkeitsgrad!  
$Instrumente=[]; // im Suchfilter ausgewählte Instrumente  (IDs) 
$Stricharten=[];  // im Suchfilter ausgewählte Stricharten  (IDs) 
$Notenwerte=[]; // im Suchfilter ausgewählte Notenwerte  (IDs) 
$Uebungen=[]; // im Suchfilter ausgewählte Übung-Einträge  (IDs) 

$Schueler=[]; 


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
$filterErprobt=''; 
$filterSchwierigkeitsgrad=''; 
$filterInstrumente=''; 

$filterLookups=''; 
$filterSpieldauer='';
$filterErprobtJahr='';    
$filterSchueler=''; 

$filterSuchtext='';  

$filter=false; 

$edit_table=''; /* Tabelle, die über Bearbeiten-Links in Ergebnis-Tabelle abrufbar sein soll */

$Suche = new Abfrage();

?>
<p><a onclick="hideFilter()" href="#">Filter ein/ausblenden</a>
<script> 
      function hideFilter() {
        if (document.getElementById("filterpanel").hidden==false)
        {
          document.getElementById("filterpanel").hidden=true; 
        } else 
        {
          document.getElementById("filterpanel").hidden=false;           
        }

      }
</script>

<!-- Button: alle Filter zurücksetzen --> 
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
          }
      }  
</script> 
</p>

<?php 
if (isset($_POST['Ansicht'])) {
  $Ansicht=$_POST["Ansicht"];
} else {
  $Ansicht='Sammlung'; // default 
}
?> 




<div class="search-page">
<div class="search-filter" id="filterpanel">

<form id="Suche" action="" method="post">

<!---- Ansicht -----> 
<?php
$Suche->Beschreibung.='* Ansicht: '.$Ansicht.PHP_EOL; 
?>
<b>Ansicht: </b>
<select id="Ansicht" name="Ansicht">
          <option value="Sammlung" <?php echo ($Ansicht=='Sammlung'?'selected':'');?>>Sammlung</option>   
          <option value="Sammlung Links" <?php echo ($Ansicht=='Sammlung Links'?'selected':'')?>>Sammlung Links</option>   
          <option value="Musikstueck" <?php echo ($Ansicht=='Musikstueck'?'selected':'');?>>Musikstück</option>
          <option value="Satz" <?php echo ($Ansicht=='Satz'?'selected':'')?>>Satz</option>
          <option value="Satz Besonderheiten" <?php echo ($Ansicht=='Satz Besonderheiten'?'selected':'')?>>Satz Besonderheiten</option>                     
</select>

<!---- Entscheidung Suche speichern ja / nein -----> 
&nbsp; &nbsp; <input type="checkbox" id="sp" name="SucheSpeichern"><label for="sp">Suche speichern</label> 


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
<!---- Suche starten -----> 
<p>Suchtext: <br><input type="text" id="suchtext" name="suchtext" size="30px" value="<?php echo $suchtext; ?>" autofocus> 
<input class="btnSave" type="submit" value="Suchen" class="btnSave" width="100px">
</P> 


<?php


  /************* Schüler  ***********/
  $schueler = new Schueler();
  $SchuelerID=''; 
  if (isset($_POST['SchuelerID'])) {
    if ($_POST['SchuelerID']!='') {
      $SchuelerID = $_POST['SchuelerID']; 
      $schueler->ID=  $SchuelerID; 
      $schueler->load_row(); 
      $filterSchueler='='.$SchuelerID.' '; 
      $Suche->Beschreibung.=($SchuelerID!=''?'* Schüler: '.$schueler->Name.PHP_EOL:'');     
      $filter=true;       
    }
  }
  $schueler->print_select($SchuelerID,'',$schueler->Title .' : &nbsp;&nbsp;&nbsp;');

?>

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

/*********  Sammlung Besonderheiten **********/  
  // XXX noch analog zu Satz Besonderheiten umsetzen (Genaue Suche)
  $lookuptypes=new Lookuptype(); 
  $lookuptypes->Relation='sammlung'; 
  $arrLookupTypes=$lookuptypes->getArrData(); 
  $filterLookups_sammlung=''; 

  for ($i = 0; $i < count($arrLookupTypes); $i++) {
    $lookup=New Lookup(); 
    $lookup->LookupTypeID=$arrLookupTypes[$i]["ID"];
    $lookup_type_name=$arrLookupTypes[$i]["Name"]; 
    $lookup_type_key= $arrLookupTypes[$i]["type_key"]; // z.B: "besdynam" ect.  
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

/************* Besetzungen  ***********/
  // XXX Anpassung + Check Options in Arbeit 
  $Besetzungen_selected=[]; // im Suchfilter ausgewählte Besetzungen (IDs) 
  $Besetzungen_all= []; 
  $Besetzungen_not_selected= []; 
  $besetzung_check_exact=false; // Einschluss-Suche aktiviert 
  $besetzung_check_exclude=false; // Ausschluss-Suche aktiviert 

  $besetzung = new Besetzung();

  if (isset($_POST['Besetzungen'])) {
    $filter=true;       
    $Besetzungen_selected = $_POST['Besetzungen'];    
    if (isset($_POST["exact_Besetzung"])) { 
       $besetzung_check_exact=true;
       for ($i = 0; $i < count($Besetzungen_selected); $i++) {
          $filterBesetzung.='AND musikstueck.ID IN (SELECT MusikstueckID from musikstueck_besetzung WHERE BesetzungID='.$Besetzungen_selected[$i].') '. PHP_EOL; 
       }       
    }   else {
        $filterBesetzung = 'AND musikstueck_besetzung.BesetzungID IN ('.implode(',', $Besetzungen_selected).') '; 
    }
    if (isset($_POST["exclude_Besetzung"]))  {
      $besetzung_check_exclude=true; 
      $Besetzungen_all= $besetzung->getArray();         
      $Besetzungen_not_selected = array_diff($Besetzungen_all, $Besetzungen_selected); // nicht ausgewählte Werte    
      $filterBesetzung.='AND musikstueck.ID NOT IN (SELECT DISTINCT MusikstueckID from musikstueck_besetzung WHERE BesetzungID IN ('.implode(',', $Besetzungen_not_selected).')) '. PHP_EOL; 
    }     
  }

  // print_r($Besetzungen_all); 
  // print_r($Besetzungen_selected); 

  // $besetzung->print_select_multi($Besetzungen_selected); 
  $besetzung->print_select_multi($Besetzungen_selected, $besetzung_check_exact, $besetzung_check_exclude); 
  $Suche->Beschreibung.=(count($Besetzungen_selected)>0?$besetzung->titles_selected_list:'');  
  $Suche->Beschreibung.=($besetzung_check_exact?' / +Einschluss-Suche':'');  
  $Suche->Beschreibung.=($besetzung_check_exclude?' / +Ausschluss-Suche':'');  
  

/************* Verwendungszwecke  ***********/
  if (isset($_POST['Verwendungszwecke'])) {
    $Verwendungszwecke = $_POST['Verwendungszwecke'];   
    $filterVerwendungszweck = 'IN ('.implode(',', $Verwendungszwecke).')'; 
    $filter=true;     
  }  
  $verwendungszweck = new Verwendungszweck();
  $verwendungszweck->print_select_multi($Verwendungszwecke);    
  $Suche->Beschreibung.=(count($Verwendungszwecke)>0?$verwendungszweck->titles_selected_list.PHP_EOL:'');  

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
 
  ?>
  <p class="navi-trenner">Satz</p> 

  <?php

  /************* Instrument/Schwierigkeitsgrad  ***********/
    $schwierigkeitsgrad = new InstrumentSchwierigkeitsgrad();
    if (isset($_POST['Schwierigkeitsgrad'])) {
      $Schwierigkeitsgrade = $_POST['Schwierigkeitsgrad']; 
      $filterSchwierigkeitsgrad = $schwierigkeitsgrad->getSucheFilterSQL($Schwierigkeitsgrade);       
      $filter=true;       
    }
    $schwierigkeitsgrad->print_select_multi($Schwierigkeitsgrade);  
    $Suche->Beschreibung.=(count($Schwierigkeitsgrade)>0?$schwierigkeitsgrad->titles_selected_list:'');
  
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
      $filterSpieldauer=' BETWEEN '.$spieldauer_von.' AND '.$spieldauer_bis; 
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

/************** Besonderheiten Satz **********/

  $lookuptypes=new Lookuptype(); 
  $lookuptypes->Relation='satz'; 
  $arrLookupTypes=$lookuptypes->getArrData(); 
  $filterLookups_satz=''; 
  for ($i = 0; $i < count($arrLookupTypes); $i++) {
    echo '<p>$i Start Schleife: '.$i; // test 
    // print_r($arrLookupTypes[$i]);  // Test     
    $lookup_check_include=false; // Einschluss-Suche ja/nein 
    $lookup_check_exclude=false;    // Ausschluss-Suche ja/nein
    $lookup_type_name=$arrLookupTypes[$i]["Name"]; 
    $lookup_type_key= $arrLookupTypes[$i]["type_key"]; 

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
      if (isset($_POST['exact_'.$lookup_type_key])) { //  "Einschluss-Suche" aktiviert 
        $lookup_check_include=true;         
        for ($k = 0; $k < count($lookup_values_selected); $k++) {
          $filterLookups_satz.=' AND satz.ID IN (SELECT SatzID from satz_lookup WHERE LookupID='.$lookup_values_selected[$k].') '. PHP_EOL; 
        }
      } 
      else {
        $filterLookups_satz.=' AND satz.ID IN (SELECT SatzID from satz_lookup WHERE LookupID IN ('.implode(',', $lookup_values_selected).'))'. PHP_EOL;         
      }
      if (isset($_POST['exclude_'.$lookup_type_key])) {    // Ausschluss-Suche aktiviert 
        $lookup_values = $lookup->getArrLookups();        
        $lookup_check_exclude=true; 
        $lookup_values_not_selected = array_diff($lookup_values, $lookup_values_selected); // nicht ausgewählte Werte    
        $filterLookups_satz.=' AND satz.ID NOT IN (SELECT DISTINCT SatzID from satz_lookup WHERE LookupID IN ('.implode(',', $lookup_values_not_selected).')) '. PHP_EOL; 
      }      
    }    
    $lookup->print_select_multi($lookup_type_key,$lookup_values_selected, $lookup_type_name.':', true, $lookup_check_include, true,$lookup_check_exclude );
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
           -- , standort.Name as Standort
            , musikstueck.Nummer as Nr
            , musikstueck.Name as Musikstueck
            , komponist.Name as Komponist
            -- , GROUP_CONCAT(DISTINCT besetzung.Name order by besetzung.Name SEPARATOR ', ') Besetzungen
            , v_musikstueck_besetzungen.Besetzungen 
            , GROUP_CONCAT(DISTINCT verwendungszweck.Name order by verwendungszweck.Name SEPARATOR ', ') Verwendungszwecke   
            , GROUP_CONCAT(DISTINCT satz.Nr order by satz.Nr SEPARATOR ', ') Saetze         
            , musikstueck.Bearbeiter 
            , gattung.Name as Gattung 
            , epoche.Name as Epoche              
        
            ";         

        $edit_table='musikstueck'; 
          break; 

      case 'Satz': 
        $query.="SELECT satz.ID
            ,sammlung.Name as Sammlung
            -- , musikstueck.Nummer as MNr
            , musikstueck.Name as Musikstueck
            , satz.Nr as Nr
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
            -- , GROUP_CONCAT(DISTINCT concat(instrument.Name, ': ', schwierigkeitsgrad.Name)  order by schwierigkeitsgrad.Name SEPARATOR ', ') `Schwierigkeitsgrade`                   
            , SatzSchwierigkeitsgrad.Schwierigkeitsgrade 
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
        
        case 'Satz Besonderheiten': 
          $query.="SELECT satz.ID
              , v_satz_lookuptypes.LookupList2 as Besonderheiten              
              ,sammlung.Name as Sammlung
              , musikstueck.Nummer as MNr
              , musikstueck.Name as Musikstueck
              , satz.Nr as SatzNr
              , satz.Name as Satz                                      
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
        
        LEFT JOIN (
          select musikstueck_besetzung.MusikstueckID         
               , GROUP_CONCAT(DISTINCT besetzung.Name  order by besetzung.Name SEPARATOR ', ') Besetzungen       
          from musikstueck_besetzung 
              left join besetzung on besetzung.ID = musikstueck_besetzung.BesetzungID 
          group by musikstueck_besetzung.MusikstueckID 
                  ) v_musikstueck_besetzungen 
              on v_musikstueck_besetzungen.MusikstueckID = musikstueck.ID 

        LEFT JOIN musikstueck_verwendungszweck on musikstueck.ID = musikstueck_verwendungszweck.MusikstueckID 
        LEFT JOIN verwendungszweck on musikstueck_verwendungszweck.VerwendungszweckID=verwendungszweck.ID    
        LEFT JOIN satz on satz.MusikstueckID = musikstueck.ID 
        LEFT JOIN satz_erprobt on satz.ID = satz_erprobt.SatzID 
        LEFT JOIN erprobt on erprobt.ID = satz_erprobt.ErprobtID  
        
        LEFT JOIN (
          SELECT satz_schwierigkeitsgrad.SatzID      
              , GROUP_CONCAT(DISTINCT concat(instrument.Name, ': ', schwierigkeitsgrad.Name)  
                 ORDER by concat(instrument.Name, ': ', schwierigkeitsgrad.Name) SEPARATOR ', ') `Schwierigkeitsgrade`                    
          from satz_schwierigkeitsgrad 
          LEFT JOIN schwierigkeitsgrad on schwierigkeitsgrad.ID = satz_schwierigkeitsgrad.SchwierigkeitsgradID 
          LEFT JOIN instrument on instrument.ID = satz_schwierigkeitsgrad.InstrumentID 
          group by satz_schwierigkeitsgrad.SatzID 
        )  SatzSchwierigkeitsgrad
          on satz.ID = SatzSchwierigkeitsgrad.SatzID 

        LEFT JOIN satz_schwierigkeitsgrad on satz_schwierigkeitsgrad.SatzID = satz.ID 
        LEFT JOIN instrument_schwierigkeitsgrad 
            ON instrument_schwierigkeitsgrad.InstrumentID = satz_schwierigkeitsgrad.InstrumentID
            AND instrument_schwierigkeitsgrad.SchwierigkeitsgradID = satz_schwierigkeitsgrad.SchwierigkeitsgradID


        -- LEFT JOIN schwierigkeitsgrad on schwierigkeitsgrad.ID = satz_schwierigkeitsgrad.SchwierigkeitsgradID 
        -- LEFT JOIN instrument on instrument.ID = satz_schwierigkeitsgrad.InstrumentID 
        
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

      $query.=($filterBesetzung!=''?$filterBesetzung:''); 

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

      $query.=($filterSchwierigkeitsgrad!=''?$filterSchwierigkeitsgrad. PHP_EOL:'');       

      $query.=($filterLookups_sammlung!=''?$filterLookups_sammlung.PHP_EOL:''); 

      $query.=($filterLookups_satz!=''?$filterLookups_satz.PHP_EOL:''); 
                       
      if($filterSpieldauer!=''){
        $query.=' AND satz.Spieldauer '.$filterSpieldauer. PHP_EOL; 
      }
 
      if($filterSchueler!=''){
        $query.=' AND satz.ID IN (SELECT SatzID from schueler_satz where SchuelerID='.$SchuelerID.')' . PHP_EOL; 
      }            


      if($suchtext!=''){
        $query.="AND (sammlung.Name LIKE '%".$suchtext."%' OR  
                            sammlung.Bemerkung LIKE '%".$suchtext."%' OR 
                            -- v_sammlung_lookuptypes.LookupList LIKE '%".$suchtext."%'   OR 
  	                        verlag.Name LIKE '%".$suchtext."%' OR
                            standort.Name LIKE '%".$suchtext."%' OR                              
                            
                            musikstueck.Name LIKE '%".$suchtext."%' OR                              
                            musikstueck.Opus LIKE '%".$suchtext."%' OR
                            musikstueck.Bearbeiter LIKE '%".$suchtext."%' OR

                            komponist.Name LIKE '%".$suchtext."%' OR 
                            gattung.Name LIKE '%".$suchtext."%' OR 
                            epoche.Name LIKE '%".$suchtext."%' OR  
                            besetzung.Name LIKE '%".$suchtext."%' OR 
                            verwendungszweck.Name LIKE '%".$suchtext."%' OR 

                            -- v_satz_lookuptypes.LookupList LIKE '%".$suchtext."%' OR

                            satz.Name LIKE '%".$suchtext."%' OR
                            satz.Taktart LIKE '%".$suchtext."%' OR
                            satz.Tonart LIKE '%".$suchtext."%' OR
                            satz.Tempobezeichnung LIKE '%".$suchtext."%' OR
                            satz.Bemerkung LIKE '%".$suchtext."%' OR 
                            satz.Orchesterbesetzung LIKE '%".$suchtext."%'                                                     
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
        case 'Satz Besonderheiten':           
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
            
        } else {
          // Abfrage nicht speichern, Ergebnis ausgeben   
          if ($Suche->Beschreibung!='') {
            echo '<p>Auswahl:</p><pre>'.$Suche->Beschreibung.'</pre>';
          }
    
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
