
<?php 
include('head.php');
include("cl_db.php");

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
$Verlage=[];   /* Sammlung */
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

$spieldauer_von=''; 
$spieldauer_bis=''; 
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
$filterStricharten=''; 
$filterNotenwerte='';  
$filterUebungen='';  
$filterErprobt=''; 
$filterSchwierigkeitsgrad=''; 
$filterInstrumente=''; 

$filterLookups=''; 
$filterSpieldauer='';   
$filterSuchtext='';  


$filter=false; 

// $abfrage_beschreibung=''; // String mit den Title-Texten der ausgewählten Einträge 

$edit_table=''; /* Tabelle, die über Bearbeiten-Links in Ergebnis-Tabelle abrufbar sein soll */

$Suche = new Abfrage();

if (isset($_POST['Ebene'])) {
  $Ebene=$_POST["Ebene"];
} else {
  $Ebene='Sammlung'; // default 
}

$Suche->Beschreibung.='* Anzeige-Ebene: '.$Ebene.PHP_EOL; 

/* 
 Die mit dem Absenden der Suche gesetzten Werte werden wieder in die Form-Elemente eingelesen. 
 Die Sucheinstellungen "bleiben stehen" und werden nur durch Betätigen der 
 "Filter zurücksetzen" - Buttons wieder aufgelöst 
*/
  
?> 
<div class="search-page">
<div class="search-filter">
<form id="Suche" action="" method="post">

<fieldset style="width:90%">Ebene: 
    <input type="radio" id="sm" name="Ebene" value="Sammlung" <?php echo ($Ebene=='Sammlung'?'checked':'') ?>>
    <label for="sm">Sammlung</label> 
    <input type="radio" id="mu" name="Ebene" value="Musikstueck" <?php echo ($Ebene=='Musikstueck'?'checked':'') ?>> 
    <label for="mu">Musikstück</label>
    <input type="radio" id="st" name="Ebene" value="Satz" <?php echo ($Ebene=='Satz'?'checked':'') ?>>
    <label for="st">Satz</label> 
  </fieldset>

<p></p>  
<input type="submit" value="Suchen" class="btnSave">
<input type="button" id="btnReset_All" value="Alle Filter zurücksetzen" onclick="Reset_All();" /> 

<!---- Entscheidung Suche speichern ja / nein -----> 
<input type="checkbox" id="sp" name="SucheSpeichern">
<label for="sp">Suche speichern</label> 

<!-- Button: alle Filter zurücksetzen --> 
<script type="text/javascript">  
          function Reset_All() {  
          for(i=0; i<document.forms[0].elements.length; i++){
            if(document.forms[0].elements[i].type == 'text'){
              document.forms[0].elements[i].value=""; 
            }
            if(document.forms[0].elements[i].type == 'select-multiple'){
              document.forms[0].elements[i].selectedIndex = -1;
            }   
          }
      }  
</script> 

<?php 
  /* Standort  */
  if (isset($_POST['Standorte'])) {
    $Standorte = $_POST['Standorte'];   // Array gewählte Standorte 
    $filterStandorte = 'IN ('.implode(',', $Standorte).')'; 
    $filter=true;     
  }
  $standort = new Standort();
  $standort->print_select_multi($Standorte);      
  $Suche->Beschreibung.=(count($Standorte)>0?$standort->titles_selected_list:'');    

  /* Besetzung  */
  if (isset($_POST['Besetzungen'])) {
    $Besetzungen = $_POST['Besetzungen'];    
    $filterBesetzung = 'IN ('.implode(',', $Besetzungen).')'; 
    $filter=true;        
  }
  $besetzung = new Besetzung();
  $besetzung->print_select_multi($Besetzungen); 
  $Suche->Beschreibung.=(count($Besetzungen)>0?$besetzung->titles_selected_list:'');  

  /* Verwendungszwecke  */
  if (isset($_POST['Verwendungszwecke'])) {
    $Verwendungszwecke = $_POST['Verwendungszwecke'];   
    $filterVerwendungszweck = 'IN ('.implode(',', $Verwendungszwecke).')'; 
    $filter=true;     
  }  
  $verwendungszweck = new Verwendungszweck();
  $verwendungszweck->print_select_multi($Verwendungszwecke);    
  $Suche->Beschreibung.=(count($Verwendungszwecke)>0?$verwendungszweck->titles_selected_list:'');  

  /* Gattungen  */
  $gattung = new Gattung();
  $gattung->print_select_multi($Gattungen);  
  $Suche->Beschreibung.=(count($Gattungen)>0?$gattung->titles_selected_list:'');
  if (isset($_POST['Gattungen'])) {
    $Gattungen = $_POST['Gattungen'];  
    $filterGattungen = 'IN ('.implode(',', $Gattungen).')'; 
    $filter=true;     
  }      

  /* Epochen  */
  if (isset($_POST['Epochen'])) {
    $Epochen = $_POST['Epochen'];   
    $filterEpochen = 'IN ('.implode(',', $Epochen).')'; 
    $filter=true; 
  }    
  $epochen = new Epoche();
  $epochen->print_select_multi($Epochen); 
  $Suche->Beschreibung.=(count($Epochen)>0?$epochen->titles_selected_list:'');  
  
  /* Schwierigkeitsgrad  */
  if (isset($_POST['Schwierigkeitsgrad'])) {
    $Schierigkeitsgrad = $_POST['Schwierigkeitsgrad']; 
    $filterSchwierigkeitsgrad= 'IN ('.implode(',', $Schierigkeitsgrad).')'; 
    $filter=true;       
  }
  $schierigkeitsgrad = new Schwierigkeitsgrad();
  $schierigkeitsgrad->print_select_multi($Schierigkeitsgrad);  
  $Suche->Beschreibung.=(count($Schierigkeitsgrad)>0?$schierigkeitsgrad->titles_selected_list:'');
 
  /* Instrumente  */
  if (isset($_POST['Instrumente'])) {
    $Instrumente = $_POST['Instrumente'];  
    $filterInstrumente= 'IN ('.implode(',', $Instrumente).')'; 
    $filter=true;      
  } 
  $instrument = new Instrument();
  $instrument->print_select_multi($Instrumente);        
  $Suche->Beschreibung.=(count($Instrumente)>0?$instrument->titles_selected_list:'');
  
  /* Erprobt  */
  if (isset($_POST['Erprobt'])) {
    $Erprobt = $_POST['Erprobt'];   
    $filterErprobt= 'IN ('.implode(',', $Erprobt).')'; 
    $filter=true;     
  } 
  $erprobt = new Erprobt();
  $erprobt->print_select_multi($Erprobt);  
  $Suche->Beschreibung.=(count($Erprobt)>0?$erprobt->titles_selected_list:'');            


  /* Verlag  */
  if (isset($_POST['Verlage'])) {
    $Verlage = $_POST['Verlage']; 
    $filterVerlage = 'IN ('.implode(',', $Verlage).')'; 
    $filter=true;       
  }
  $verlag = new Verlag();
  $verlag->print_select_multi($Verlage);
  $Suche->Beschreibung.=(count($Verlage)>0?$verlag->titles_selected_list:'');            


  /* Komponisten  */
  if (isset($_POST['Komponisten'])) {
    $Komponisten = $_POST['Komponisten'];   
    $filterKomponisten = 'IN ('.implode(',', $Komponisten).')'; 
    $filter=true;        
  }   
  $komponist = new Komponist();
  $komponist->print_select_multi($Komponisten);     
  $Suche->Beschreibung.=(count($Komponisten)>0?$komponist->titles_selected_list:''); 
 
  /* Linktypen  */      
  if (isset($_POST['Linktypen'])) {
    $Linktypen = $_POST['Linktypen']; 
    $filterLinktypen = 'IN ('.implode(',', $Linktypen).')'; 
    $filter=true;       
  }  
  $linktyp = new Linktype();
  $linktyp->print_select_multi($Linktypen);      
  $Suche->Beschreibung.=(count($Linktypen)>0?$linktyp->titles_selected_list:''); 


/*******  Spieldauer  ****************/  

  if (isset($_REQUEST['SpieldauerVon']) and isset($_REQUEST['SpieldauerBis']) ) {
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
      $Suche->Beschreibung.='* Spieldauer von '.$spieldauer_von.' bis '.$spieldauer_bis.' Sekunden'.PHP_EOL;
      $filter=true; 
    }
  }
   ?>    
  <p><b>Spieldauer:</b>
  <br /> von 
  min: <input type="text" id="SpieldauerVon_min" name="SpieldauerVon_min" size="5" value="" oninput="set_SpieldauerVon();"> 
  sec: <input type="text" id="SpieldauerVon" name="SpieldauerVon" size="5" value="<?php echo $spieldauer_von; ?>">
  <br /> bis
    min: <input type="text" id="SpieldauerBis_min" name="SpieldauerBis_min" size="5" value="" oninput="set_SpieldauerBis();">
    sec: <input type="text" id="SpieldauerBis" name="SpieldauerBis" size="5" value="<?php echo $spieldauer_bis; ?>">

  <input type="button" id="btnReset_Spieldauer" value="Filter zurücksetzen" onclick="Reset_Spieldauer();" />  
  <script type="text/javascript">  
        function Reset_Spieldauer() {  
          document.getElementById("SpieldauerVon").value='';  
          document.getElementById("SpieldauerBis").value='';  
        }
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

/************** Besonderheiten **********/

  $lookuptypes=new Lookuptype(); 
  $lookuptypes->setArrData(); 
  $filterLookups2=''; 

  for ($i = 0; $i < count($lookuptypes->ArrData); $i++) {
    $lookup=New Lookup(); 
    $lookup->LookupTypeID=$lookuptypes->ArrData[$i]["ID"];
    $lookup_type_name=$lookuptypes->ArrData[$i]["Name"]; 
    $lookup_type_key= $lookuptypes->ArrData[$i]["type_key"]; // z.B: "besdynam" ect.  
    $lookup_values_selected=[];      
    if (isset($_POST[$lookup_type_key])) {
      $lookup_values_selected= $_POST[$lookup_type_key]; 
      // $lookup_all_values_selected = array_merge($lookup_all_values_selected, $lookup_values_selected);  // falsch! (jede lookup-Gruppe muss für Filter separat ausgelesen )
      $filterLookups2.=' AND satz_lookup.LookupID IN ('.implode(',', $lookup_values_selected).') -- '.$lookup_type_name.''. PHP_EOL; 
      $filter=true; 
    } 
    $lookup->print_select_multi($lookup_type_key,$lookup_values_selected, $lookup_type_name.':');
    $Suche->Beschreibung.=(count($lookup_values_selected)?$lookup->titles_selected_list:'');   
  }

/************** Suchtext  **********/  
  if (isset($_POST['suchtext'])) {
    $suchtext = $_POST['suchtext'];  
    if ($suchtext!='') { 
        $Suche->Beschreibung.='* Suchtext: '.$suchtext.PHP_EOL; 
        $filter=true; 
    }
  }   
  ?>
  <p>Suchtext: <br> 
    <input type="text" id="suchtext" name="suchtext" size="20" value="<?php echo $suchtext; ?>"> 

    <br><input type="button" id="btnReset_suchtext" value="Filter zurücksetzen" onclick="Reset_suchtext();" />  
        <script type="text/javascript">  
                function Reset_suchtext() {  
                  document.getElementById("suchtext").value='';  
            }  
        </script> 
    </p>

</form>

</div> <!-- ende class search-filter --> 
<div class="search-table">


<?php

  if ($filter ) {
    $query=""; 

    switch ($Ebene){
      case 'Sammlung': 
        $query.="SELECT sammlung.ID
            ,sammlung.Name as Sammlung
            , standort.Name as Standort
            , verlag.Name as Verlag
            , GROUP_CONCAT(DISTINCT linktype.Name order by linktype.Name SEPARATOR ', ') Links            
            , sammlung.Bemerkung 
            , GROUP_CONCAT(DISTINCT musikstueck.Name order by musikstueck.Nummer SEPARATOR ', ') Musikstuecke
            , sammlung.Bestellnummer 
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
            , musikstueck.JahrAuffuehrung            
            , GROUP_CONCAT(DISTINCT besetzung.Name order by besetzung.Name SEPARATOR ', ') Besetzungen
            , GROUP_CONCAT(DISTINCT verwendungszweck.Name order by verwendungszweck.Name SEPARATOR ', ') Verwendungszwecke   
            , GROUP_CONCAT(DISTINCT satz.Name order by satz.Nr SEPARATOR ', ') Saetze                 
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
            , GROUP_CONCAT(DISTINCT concat(schwierigkeitsgrad.Name, ' - ', instrument.Name)  order by schwierigkeitsgrad.Name SEPARATOR ', ') `Schwierigkeitsgrade`                   
            , erprobt.Name as Erprobt             
            , v_satz_lookuptypes.LookupList as Besonderheiten                  
            , satz.Lagen
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
      LEFT JOIN erprobt on erprobt.ID = satz.ErprobtID       
      left JOIN satz_schwierigkeitsgrad on satz_schwierigkeitsgrad.SatzID = satz.ID 
      LEFT JOIN schwierigkeitsgrad on schwierigkeitsgrad.ID = satz_schwierigkeitsgrad.SchwierigkeitsgradID 
      LEFT JOIN instrument on instrument.ID = satz_schwierigkeitsgrad.InstrumentID 
      left join satz_lookup on satz_lookup.SatzID = satz.ID 
      -- left join lookup on lookup.ID = satz_lookup.LookupID 
      -- left join lookup_type on lookup_type.ID = lookup.LookupTypeID
      left join v_satz_lookuptypes on v_satz_lookuptypes.SatzID = satz.ID 

      WHERE 1=1 ". PHP_EOL; 

      switch ($Ebene){    
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
      // if($filterStricharten!=''){
      //   $query.=' AND satz_strichart.StrichartID '.$filterStricharten. PHP_EOL; 
      // }
      // if($filterNotenwerte!=''){
      //   $query.=' AND satz_notenwert.NotenwertID '.$filterNotenwerte. PHP_EOL; 
      // }
      // if($filterUebungen!=''){
      //   $query.=' AND satz_uebung.UebungID '.$filterUebungen. PHP_EOL; 
      // }       
      if($filterErprobt!=''){
        $query.=' AND satz.ErprobtID '.$filterErprobt. PHP_EOL; 
      }
      if($filterSchwierigkeitsgrad!=''){
        $query.=' AND satz_schwierigkeitsgrad.SchwierigkeitsgradID '.$filterSchwierigkeitsgrad. PHP_EOL; 
      }
      if($filterInstrumente!=''){
        $query.=' AND satz_schwierigkeitsgrad.InstrumentID '.$filterInstrumente. PHP_EOL; 
      }
      // $query.=($filterLookups!=''?' AND satz_lookup.LookupID '.$filterLookups.PHP_EOL:''); 
      $query.=($filterLookups2!=''?$filterLookups2.PHP_EOL:''); 
                       
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
                            musikstueck.JahrAuffuehrung LIKE '%".$suchtext."%' OR
                            satz.Name LIKE '%".$suchtext."%' OR
                            satz.Taktart LIKE '%".$suchtext."%' OR
                            satz.Tonart LIKE '%".$suchtext."%' OR
                            satz.Tempobezeichnung LIKE '%".$suchtext."%' OR
                            satz.Bemerkung LIKE '%".$suchtext."%' OR 
                            satz.Orchesterbesetzung LIKE '%".$suchtext."%' OR                             
                            besetzung.Name LIKE '%".$suchtext."%' )". PHP_EOL;         
      }

      /* Gruppierung abhängig von Ebene  */
      switch ($Ebene){    
        case 'Sammlung': 
          $query.=" group by sammlung.ID". PHP_EOL;     
          break; 
        case 'Musikstueck': 
          $query.=" group by musikstueck.ID". PHP_EOL;         
          break; 
        case 'Satz': 
          $query.=" group by satz.ID". PHP_EOL;             
          break;      
      }

      /* Sortierung abhängig von Ebene  */
      switch ($Ebene){    
        case 'Sammlung': 
          $query.=" ORDER BY sammlung.Name". PHP_EOL;     
          break; 
        case 'Musikstueck': 
          $query.=" ORDER BY sammlung.Name, musikstueck.Nummer". PHP_EOL;         
          break; 
        case 'Satz': 
          $query.=" ORDER BY sammlung.Name, musikstueck.Nummer, satz.Nr". PHP_EOL;           
          break;      
      }

      // echo '<pre>'.$query.'</pre>'; // Test  
      // echo '<pre>'.$filterLookups2.'</pre>'; // Test    
    
      if ($Suche->Beschreibung!='') {
        echo '<p>Auswahl:</p><pre>'.$Suche->Beschreibung.'</pre>';
      }

      if (isset($_POST["SucheSpeichern"])) {
        $timestamp = time();
        $Suche->Name= 'Suche '.date("d.m.Y - H:i", time()); // Temp. Name, kann später geändert werden
        $Suche->Abfrage = $query; 
        $Suche->Tabelle = $edit_table; 
        $Suche->insert_row2(); 
        echo '<p>Die Suchabfrage wurde gespeichert: <br />'; 
        echo '<a href="show_abfrage.php?ID='.$Suche->ID.'&title=Abfrage" target="_blank">Abfrage-Ergebnis anzeigen</a>
            | <a href="edit_abfrage.php?ID='.$Suche->ID.'&title=Abfrage" target="_blank">Abfrage bearbeiten</a>
               | <a href="show_table2.php?table=v_abfrage&sortcol=ID&sortorder=DESC&title=Abfragen&add_link_show" target="_blank">Übersicht Abfragen</a>         
            ';
            
        } else {
          // Abfrage nicht speichern, Ergebnis ausgeben           
          include_once("cl_db.php");
          $conn = new DbConn(); 
          $db=$conn->db; 
          
          $select = $db->prepare($query); 
            
          try {
            $select->execute(); 
            include_once("cl_html_table.php");      
            $html = new HtmlTable($select); 

            $html->print_table($edit_table, True, '', $Ebene); 
  
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
