
<?php 
include('head.php');
include("cl_db.php");

include("cl_html_table.php");    
include("cl_html_info.php");  

include("cl_besetzung.php");  
include("cl_verwendungszweck.php"); 
include("cl_standort.php"); 
include("cl_komponist.php"); 
include("cl_strichart.php"); 
include("cl_verlag.php"); 
include("cl_gattung.php"); 
include("cl_epoche.php"); 
include("cl_notenwert.php");
include("cl_erprobt.php");  
include("cl_schwierigkeitsgrad.php");  
include("cl_uebung.php");  

include("cl_lookup.php");   
include("cl_lookuptype.php");
include("cl_linktype.php");

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
$Stricharten=[];  // im Suchfilter ausgewählte Stricharten  (IDs) 
$Notenwerte=[]; // im Suchfilter ausgewählte Notenwerte  (IDs) 
$Uebungen=[]; // im Suchfilter ausgewählte Übung-Einträge  (IDs) 
$lookuptypes_selected=[]; // im Suchfilter ausgewählte Besonderheiten  (IDs) 

$spieldauer_von=''; 
$spieldauer_bis=''; 
$suchtext=''; 

$abfrage_beschreibung=''; // String mit den Title-TExten der ausgewählten Einträge 

$edit_table=''; /* Tabelle, die über Bearbeiten-Links in Ergebnis-Tabelle abrufbar sein soll */

if (isset($_POST['Ebene'])) {
  $Ebene=$_POST["Ebene"]; 
} else {
  $Ebene='Sammlung'; // default 
}

/* 
 Die mit dem Absenden der Suche gesetzten Werte werden wieder in die Form-Elemente eingelesen. 
 Die Sucheinstellungen "bleiben stehen" und werden nur durch betätigen der "Filter zurücksetzen" Buttons wieder aufgelöst 
*/

if ("POST" == $_SERVER["REQUEST_METHOD"]) {
  if (isset($_REQUEST['Standorte'])) {
    $Standorte = $_REQUEST['Standorte'];   
  }
  if (isset($_REQUEST['Verlage'])) {
    $Verlage = $_REQUEST['Verlage'];   
  }
  if (isset($_REQUEST['Linktypen'])) {
    $Linktypen = $_REQUEST['Linktypen'];   
  }            
  if (isset($_REQUEST['Komponisten'])) {
    $Komponisten = $_REQUEST['Komponisten'];      
  }   
  if (isset($_REQUEST['Besetzungen'])) {
    $Besetzungen = $_REQUEST['Besetzungen'];      
  }
  if (isset($_REQUEST['Verwendungszwecke'])) {
    $Verwendungszwecke = $_REQUEST['Verwendungszwecke'];   
  }  
  if (isset($_REQUEST['Gattungen'])) {
    $Gattungen = $_REQUEST['Gattungen'];   
  }
  if (isset($_REQUEST['Epochen'])) {
    $Epochen = $_REQUEST['Epochen'];   
  }        
  if (isset($_REQUEST['Stricharten'])) {
    $Stricharten = $_REQUEST['Stricharten'];   
  } 
  if (isset($_REQUEST['Notenwerte'])) {
    $Notenwerte = $_REQUEST['Notenwerte'];   
  } 
  if (isset($_REQUEST['Stricharten'])) {
    $Stricharten = $_REQUEST['Stricharten'];   
  }
  if (isset($_REQUEST['Uebungen'])) {
    $Uebungen = $_REQUEST['Uebungen'];   
  }            
  if (isset($_REQUEST['Erprobt'])) {
    $Erprobt = $_REQUEST['Erprobt'];   
  } 
  if (isset($_REQUEST['Schwierigkeitsgrad'])) {
    $Schierigkeitsgrad = $_REQUEST['Schwierigkeitsgrad'];   
  }   
  if (isset($_REQUEST['SpieldauerVon'])) {
    $spieldauer_von = $_REQUEST['SpieldauerVon'];   
  }
  if (isset($_REQUEST['SpieldauerBis'])) {
    $spieldauer_bis = $_REQUEST['SpieldauerBis'];   
  }
  if (isset($_REQUEST['suchtext'])) {
    $suchtext = $_REQUEST['suchtext'];   
  }                    
}
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

<p> Suche speichern: <input type="text" name="Abfrage"  style="width:90%"> </p> 


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


    <!-- Start Spalte 1 -->  
    <?php 
      $standort = new Standort();
      $standort->print_select_multi($Standorte);         

      $besetzung = new Besetzung();
      $besetzung->print_select_multi($Besetzungen); 

      $verwendungszweck = new Verwendungszweck();
      $verwendungszweck->print_select_multi($Verwendungszwecke);    

      $gattung = new Gattung();
      $gattung->print_select_multi($Gattungen);  

      $epochen = new Epoche();
      $epochen->print_select_multi($Epochen); 

      $schierigkeitsgrad = new Schwierigkeitsgrad();
      $schierigkeitsgrad->print_select_multi($Schierigkeitsgrad);  

      $erprobt = new Erprobt();
      $erprobt->print_select_multi($Erprobt);      

      $stricharten = new Strichart();
      $stricharten->print_select_multi($Stricharten);     

      $notenwerte = new Notenwert();
      $notenwerte->print_select_multi($Notenwerte);      
 
      $uebungen = new Uebung();
      $uebungen->print_select_multi($Uebungen);      
 
      $verlag = new Verlag();
      $verlag->print_select_multi($Verlage);      

      $komponist = new Komponist();
      $komponist->print_select_multi($Komponisten);     
  
      $linktyp = new Linktype();
      $linktyp->print_select_multi($Linktypen);      

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

  $lookuptypes=new Lookuptype(); 
  $lookuptypes->setArrData(); 

  for ($i = 0; $i < count($lookuptypes->ArrData); $i++) {
    $lookup=New Lookup(); 
    $lookup->LookupTypeID=$lookuptypes->ArrData[$i]["ID"];
    echo '<p><b>'.$lookuptypes->ArrData[$i]["Name"].':</b><br/>'; /* Auswahl-Box Bezeichnung*/
    $type_key= $lookuptypes->ArrData[$i]["type_key"];       // $_POST[ $type_key]) = Array enthält die ausgewählten Werte (IDs) 
    
    if (isset($_POST[$type_key])) {
      $lookup->print_select_multi($lookuptypes->ArrData[$i]["type_key"], $_POST[$type_key]);
      // $lookuptypes_selected[] = $_POST[$type_key];
      $lookuptypes_selected = array_merge($lookuptypes_selected, $_POST[$type_key]);  // Sammlung markierte Eintrag-IDS aus allen Lookups 
    } else  {
      $lookup->print_select_multi($lookuptypes->ArrData[$i]["type_key"]);
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

  /* Ausgewählte Werte für Abfrage-Filter auslesen   */

  $filter=false; 

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

  $filterLookups=''; 
  $filterSpieldauer='';   
  $filterSuchtext='';  
  
  if ("POST" == $_SERVER["REQUEST_METHOD"]) // XXX 
  {
    if (isset($_REQUEST['Standorte'])) {
      $Standorte = $_REQUEST['Standorte'];   
      $filterStandorte = 'IN ('.implode(',', $Standorte).')'; 
      $filter=true; 
    }
    if (isset($_REQUEST['Verlage'])) {
      $Verlage = $_REQUEST['Verlage'];   
      $filterVerlage = 'IN ('.implode(',', $Verlage).')'; 
      $filter=true; 
    }
    if (isset($_REQUEST['Linktypen'])) {
      $Linktypen = $_REQUEST['Linktypen'];   
      $filterLinktypen = 'IN ('.implode(',', $Linktypen).')'; 
      $filter=true; 
    }                    
    if (isset($_REQUEST['Komponisten'])) {
      $Komponisten = $_REQUEST['Komponisten'];   
      $filterKomponisten = 'IN ('.implode(',', $Komponisten).')'; 
      $filter=true; 
    }      
    if (isset($_REQUEST['Besetzungen'])) {
      $Besetzungen = $_REQUEST['Besetzungen'];
      $filterBesetzung = 'IN ('.implode(',', $Besetzungen).')'; 
      $filter=true;  
    }
    if (isset($_REQUEST['Verwendungszwecke'])) {
      $Verwendungszwecke = $_REQUEST['Verwendungszwecke'];   
      $filterVerwendungszweck = 'IN ('.implode(',', $Verwendungszwecke).')'; 
      $filter=true; 
    }
    if (isset($_REQUEST['Gattungen'])) {
      $Gattungen = $_REQUEST['Gattungen'];   
      $filterGattungen = 'IN ('.implode(',', $Gattungen).')'; 
      $filter=true; 
    }  
    if (isset($_REQUEST['Epochen'])) {
      $Epochen = $_REQUEST['Epochen'];   
      $filterEpochen = 'IN ('.implode(',', $Epochen).')'; 
      $filter=true; 
    }       
    if (isset($_REQUEST['Stricharten'])) {
      $Stricharten = $_REQUEST['Stricharten'];   
      $filterStricharten = 'IN ('.implode(',', $Stricharten).')'; 
      $filter=true; 
    }
    if (isset($_REQUEST['Notenwerte'])) {
      $Notenwerte = $_REQUEST['Notenwerte'];   
      $filterNotenwerte = 'IN ('.implode(',', $Notenwerte).')'; 
      $filter=true; 
    }
    if (isset($_REQUEST['Uebungen'])) {
      $Uebungen = $_REQUEST['Uebungen'];   
      $filterUebungen = 'IN ('.implode(',', $Uebungen).')'; 
      $filter=true; 
    }    
    if (isset($_REQUEST['Erprobt'])) {
      $Erprobt = $_REQUEST['Erprobt'];   
      $filterErprobt= 'IN ('.implode(',', $Erprobt).')'; 
      $filter=true; 
    }    
    if (isset($_REQUEST['Schwierigkeitsgrad'])) {
      $Schierigkeitsgrad = $_REQUEST['Schwierigkeitsgrad'];   
      $filterSchwierigkeitsgrad= 'IN ('.implode(',', $Schierigkeitsgrad).')'; 
      $filter=true; 
    }     

    if (count($lookuptypes_selected) > 0 ){
      // erstmals bei "Besonderheiten" 
      $filterLookups = 'IN ('.implode(',', $lookuptypes_selected).')'; 
      $filter=true;        
    }

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
        $filter=true; 
      }
    }
    if ($suchtext!='') { 
      $filterSuchtext =  "(sammlung.Name LIKE '%".$suchtext."%' OR  
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
                            besetzung.Name LIKE '%".$suchtext."%' /* 28.05.2024 */ 
                            )"; 

      $filter=true; 
    }



      // echo '<pre>'.$filterSuchtext.'</pre>'; // Test 

  }
      
  if (isset($_POST['Ebene'])) {
    $Ebene=$_POST["Ebene"]; 
  }


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
            , schwierigkeitsgrad.Name as Schwierigkeitsgrad
            , erprobt.Name as Erprobt             
            , GROUP_CONCAT(DISTINCT uebung.Name order by uebung.Name SEPARATOR ', ') Uebung              
            , GROUP_CONCAT(DISTINCT strichart.Name order by strichart.Name SEPARATOR ', ') Stricharten              
            , GROUP_CONCAT(DISTINCT notenwert.Name order by notenwert.Name SEPARATOR ', ') Notenwerte
            , GROUP_CONCAT(DISTINCT uebung.Name order by uebung.Name SEPARATOR ', ') Uebungen
            , GROUP_CONCAT(DISTINCT concat(lookup_type.Name, ': ', lookup.Name)  order by  concat(lookup_type.Name, ': ', lookup.Name)  SEPARATOR ', ') Besonderheiten                    
            , satz.Lagen 
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
      LEFT JOIN satz_strichart on satz_strichart.satzID = satz.ID
      LEFT JOIN strichart on satz_strichart.StrichartID = strichart.ID 
      LEFT JOIN satz_notenwert on satz_notenwert.SatzID = satz.ID
      LEFT JOIN notenwert on notenwert.ID = satz_notenwert.NotenwertID  
      LEFT JOIN erprobt on erprobt.ID = satz.ErprobtID       
      LEFT JOIN schwierigkeitsgrad on schwierigkeitsgrad.ID = satz.SchwierigkeitsgradID    
      LEFT JOIN satz_uebung on satz_uebung.SatzID = satz.ID 
      LEFT JOIN uebung on uebung.ID = satz_uebung.UebungID    

      left join satz_lookup on satz_lookup.SatzID = satz.ID 
      left join lookup on lookup.ID = satz_lookup.LookupID 
      left join lookup_type on lookup_type.ID = lookup.LookupTypeID
      
      WHERE 1=1 
      ". PHP_EOL; 

      /*   */
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
      if($filterStricharten!=''){
        $query.=' AND satz_strichart.StrichartID '.$filterStricharten. PHP_EOL; 
      }
      if($filterNotenwerte!=''){
        $query.=' AND satz_notenwert.NotenwertID '.$filterNotenwerte. PHP_EOL; 
      }
      if($filterUebungen!=''){
        $query.=' AND satz_uebung.UebungID '.$filterUebungen. PHP_EOL; 
      }       
      if($filterErprobt!=''){
        $query.=' AND satz.ErprobtID '.$filterErprobt. PHP_EOL; 
      }
      if($filterSchwierigkeitsgrad!=''){
        $query.=' AND satz.SchwierigkeitsgradID '.$filterSchwierigkeitsgrad. PHP_EOL; 
      }                
      if($filterSpieldauer!=''){
        $query.=' AND satz.Spieldauer '.$filterSpieldauer. PHP_EOL; 
      }
      if($filterSuchtext!=''){
        $query.=' AND'.$filterSuchtext. PHP_EOL; 
      }
      $query.=($filterLookups!=''?' AND satz_lookup.LookupID '.$filterLookupsammlung.PHP_EOL:''); 


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

      /* Werte für Beschreibungs-Text einsammeln */
      $abfrage_beschreibung.=(count($Standorte)>0?$standort->titles_selected_list:'');  
      $abfrage_beschreibung.=(count($Besetzungen)>0?$besetzung->titles_selected_list:'');  
      $abfrage_beschreibung.=(count($Verwendungszwecke)>0?$verwendungszweck->titles_selected_list:'');  
      $abfrage_beschreibung.=(count($Gattungen)>0?$gattung->titles_selected_list:'');  
      $abfrage_beschreibung.=(count($Epochen)>0?$epochen->titles_selected_list:'');  
      $abfrage_beschreibung.=(count($Schierigkeitsgrad)>0?$schierigkeitsgrad->titles_selected_list:'');     
      $abfrage_beschreibung.=(count($Erprobt)>0?$erprobt->titles_selected_list:'');     
      $abfrage_beschreibung.=(count($Notenwerte)>0?$notenwerte->titles_selected_list:'');     
      $abfrage_beschreibung.=(count($Uebungen)>0?$uebungen->titles_selected_list:'');     
      $abfrage_beschreibung.=(count($Verlage)>0?$verlag->titles_selected_list:'');     
      $abfrage_beschreibung.=(count($Komponisten)>0?$komponist->titles_selected_list:''); 
      $abfrage_beschreibung.=(count($Stricharten)>0?$stricharten->titles_selected_list:'');     
          
      $abfrage_beschreibung.=(count($Linktypen)>0?$linktyp->titles_selected_list:'');   
      if($spieldauer_von !='' and $spieldauer_bis !=''){
          $abfrage_beschreibung.='* Spieldauer von '.$spieldauer_von.' bis '.$spieldauer_bis.' Sekunden'.PHP_EOL;
      }
      if ($suchtext!='') {
          $abfrage_beschreibung.='* Suchtext: '.$suchtext.PHP_EOL;
      }
      // XXX Lookups / Besonderheiten 
        
      // echo '<pre>'.$abfrage_beschreibung.'</pre>'; // Test    
          
      if (isset($_POST["Abfrage"])) {
        // Abfrage speichern, Ergebnis nicht ausgeben 
        if ($_POST["Abfrage"]!='') {
       
          include_once("cl_abfrage.php");
          $abfrage = new Abfrage();
          $abfrage->insert_row($_POST["Abfrage"]); 
          $abfrage->update_row($abfrage->Name,$abfrage_beschreibung,$query, $edit_table);
          echo '<p>Die Suche wurde als Abfrage gespeichert: <br />'; 
          echo '<a href="show_abfrage.php?ID='.$abfrage->ID.'&title=Abfrage" target="_blank">Abfrage-Ergebnis anzeigen</a>
              | <a href="edit_abfrage.php?ID='.$abfrage->ID.'&title=Abfrage" target="_blank">Abfrage bearbeiten</a>';

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
