
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


$Komponisten=[];   /* Musikstück  */  
$Besetzungen=[];   /* Musikstück  */  
$Verwendungszwecke=[];   /* Musikstück  */  
$Gattungen=[];   /* Musikstück  */
$Epochen=[];   /* Musikstück  */


$Erprobt=[];  /* Satz  */
$Schierigkeitsgrad=[];  /* Satz  */
$Stricharten=[];  /* Satz  */
$Notenwerte=[];  /* Satz  */
$Uebungen=[];  /* Satz  */

$spieldauer_von=''; 
$spieldauer_bis=''; 
$suchtext=''; 

$edit_table=''; /* Tabelle, die über Bearbeiten-Link in Ergebnis-Tabelle abrufbar sein soll */

$lookuptypes_selected=[]; 

if (isset($_POST['Ebene'])) {
  $Ebene=$_POST["Ebene"]; 
} else {
  $Ebene='Sammlung'; // default 
}

/* 
 Die mit dem Absenden der Suche gesetzten Werte werden wieder in die Form-Elemente eingelesen. 
 Die Sucheinstellungen "bleiben stehen" und werden nur durch betätigen der "Filter zurücksetzen" Buttons aufgelöst 
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
<form id="Suche" action="" method="post">
<table width="100%"> 
<tr> 
<td class="selectboxes"  width="30%">
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

  // echo "<p>Anzahl ausgewählte Lookuptypes: ".count($lookuptypes_selected ); 
  // print_r($lookuptypes_selected); 

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

<!-- Ende Spalte 1 -->  
</td>  
<td>
<!-- Start Spalte 2 -->  



<fieldset>Ebene: 
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
<p> Abfrage unter folgendem Namen speichern: <input type="text" name="Abfrage" size="100"> </p> 
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

</form>
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
      $filterSuchtext =  "(s.Name LIKE '%".$suchtext."%' OR  
                            s.Bemerkung LIKE '%".$suchtext."%' OR 
                            s.Bestellnummer LIKE '%".$suchtext."%' OR
                            m.Name LIKE '%".$suchtext."%' OR                              
                            m.Opus LIKE '%".$suchtext."%' OR
                            m.Bearbeiter LIKE '%".$suchtext."%' OR
                            m.JahrAuffuehrung LIKE '%".$suchtext."%' OR
                            sa.Name LIKE '%".$suchtext."%' OR
                            sa.Taktart LIKE '%".$suchtext."%' OR
                            sa.Tonart LIKE '%".$suchtext."%' OR
                            sa.Tempobezeichnung LIKE '%".$suchtext."%' OR
                            sa.Bemerkung LIKE '%".$suchtext."%' OR 
                            b.Name LIKE '%".$suchtext."%' /* 28.05.2024 */ 
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
        $query.="SELECT s.ID
            ,s.Name as Sammlung
            , st.Name as Standort
            , verlag.Name as Verlag
            , GROUP_CONCAT(DISTINCT linktype.Name order by linktype.Name SEPARATOR ', ') Links            
            , s.Bemerkung 
            , GROUP_CONCAT(DISTINCT m.Name order by m.Nummer SEPARATOR ', ') Musikstuecke
            , s.Bestellnummer 
            ";
        $edit_table='sammlung'; 
          break; 
      case 'Musikstueck': 
        $query.="SELECT m.ID
            ,s.Name as Sammlung
            , st.Name as Standort
            , m.Nummer as MNr
            , m.Name as Musikstueck
            , k.Name as Komponist
            , m.Bearbeiter 
            , gattung.Name as Gattung 
            , epoche.Name as Epoche
            , m.JahrAuffuehrung            
            , GROUP_CONCAT(DISTINCT b.Name order by b.Name SEPARATOR ', ') Besetzungen
            , GROUP_CONCAT(DISTINCT v.Name order by v.Name SEPARATOR ', ') Verwendungszwecke   
            , GROUP_CONCAT(DISTINCT sa.Name order by sa.Nr SEPARATOR ', ') Saetze                 
            ";         

        $edit_table='musikstueck'; 
          break; 

      case 'Satz': 
        $query.="SELECT sa.ID
            ,s.Name as Sammlung
            -- , st.Name as Standort
            , m.Nummer as MNr
            , m.Name as Musikstueck
            -- , k.Name as Komponist            
            , sa.Nr as SatzNr
            , sa.Name as Satz 
            , sa.Tonart 
            , sa.Taktart
            , sa.Tempobezeichnung
            -- , sa.Spieldauer
            , concat(
                sa.Spieldauer DIV 60
                ,''''
                , 
                sa.Spieldauer MOD 60
                , ''''''
              ) as Spieldauer            
            , schwierigkeitsgrad.Name as Schwierigkeitsgrad
            , erprobt.Name as Erprobt             
            , GROUP_CONCAT(DISTINCT uebung.Name order by uebung.Name SEPARATOR ', ') Uebung              
            , GROUP_CONCAT(DISTINCT str.Name order by str.Name SEPARATOR ', ') Stricharten              
            , GROUP_CONCAT(DISTINCT notenwert.Name order by notenwert.Name SEPARATOR ', ') Notenwerte
            , GROUP_CONCAT(DISTINCT uebung.Name order by uebung.Name SEPARATOR ', ') Uebungen
            , GROUP_CONCAT(DISTINCT concat(lookup_type.Name, ': ', lookup.Name)  order by  concat(lookup_type.Name, ': ', lookup.Name)  SEPARATOR ', ') Besonderheiten                    
            , sa.Lagen 
            , sa.Bemerkung                         
            ";        
      $edit_table='satz';                 
        break;      

    }


    $query.="
      FROM sammlung s 
      LEFT JOIN standort st on s.StandortID = st.ID    
      LEFT JOIN verlag  on s.VerlagID = verlag.ID
      LEFT JOIN link  on s.ID = link.SammlungID
      LEFT JOIN linktype  on linktype.ID = link.LinktypeID
      LEFT JOIN musikstueck m on s.ID = m.SammlungID 
      LEFT JOIN v_komponist k on k.ID = m.KomponistID
      LEFT JOIN gattung on gattung.ID = m.GattungID  
      LEFT JOIN epoche on epoche.ID = m.EpocheID              
      LEFT JOIN musikstueck_besetzung mb on m.ID = mb.MusikstueckID
      LEFT JOIN besetzung b on mb.BesetzungID = b.ID
      LEFT JOIN musikstueck_verwendungszweck mv on m.ID = mv.MusikstueckID 
      LEFT JOIN verwendungszweck v on mv.VerwendungszweckID=v.ID    
      LEFT JOIN satz sa on sa.MusikstueckID = m.ID 
      LEFT JOIN satz_strichart ssa on ssa.satzID = sa.ID
      LEFT JOIN strichart str on ssa.StrichartID = str.ID 
      LEFT JOIN satz_notenwert on satz_notenwert.SatzID = sa.ID
      LEFT JOIN notenwert on notenwert.ID = satz_notenwert.NotenwertID  
      LEFT JOIN erprobt on erprobt.ID = sa.ErprobtID       
      LEFT JOIN schwierigkeitsgrad on schwierigkeitsgrad.ID = sa.SchwierigkeitsgradID    
      LEFT JOIN satz_uebung on satz_uebung.SatzID = sa.ID 
      LEFT JOIN uebung on uebung.ID = satz_uebung.UebungID    

      left join satz_lookup on satz_lookup.SatzID = sa.ID 
      left join lookup on lookup.ID = satz_lookup.LookupID 
      left join lookup_type on lookup_type.ID = lookup.LookupTypeID
      
      WHERE 1=1 
      ". PHP_EOL; 

      /*   */
      switch ($Ebene){    
        case 'Musikstueck': 
          $query.=" AND m.ID IS NOT NULL ". PHP_EOL;         
          break; 
        case 'Satz': 
          $query.=" AND sa.ID IS NOT NULL ". PHP_EOL;             
          break;      
      }

     /* Filter ergänzen */   
      if($filterStandorte!=''){
        $query.=' AND s.StandortID '.$filterStandorte. PHP_EOL; 
      } 
      if($filterVerlage!=''){
        $query.=' AND s.VerlagID '.$filterVerlage. PHP_EOL; 
      }
      if($filterLinktypen!=''){
        $query.=' AND link.LinktypeID '.$filterLinktypen. PHP_EOL; 
      }             
      if($filterKomponisten!=''){
        $query.=' AND m.KomponistID '.$filterKomponisten. PHP_EOL; 
      }            
      if($filterBesetzung!=''){
        $query.=' AND mb.BesetzungID '.$filterBesetzung. PHP_EOL; 
      }
      if($filterVerwendungszweck!=''){
        $query.=' AND mv.VerwendungszweckID '.$filterVerwendungszweck. PHP_EOL; 
      }
      if($filterGattungen!=''){
        $query.=' AND m.GattungID '.$filterGattungen. PHP_EOL; 
      }    
      if($filterEpochen!=''){
        $query.=' AND m.EpocheID '.$filterEpochen. PHP_EOL; 
      }           
      if($filterStricharten!=''){
        $query.=' AND ssa.StrichartID '.$filterStricharten. PHP_EOL; 
      }
      if($filterNotenwerte!=''){
        $query.=' AND satz_notenwert.NotenwertID '.$filterNotenwerte. PHP_EOL; 
      }
      if($filterUebungen!=''){
        $query.=' AND satz_uebung.UebungID '.$filterUebungen. PHP_EOL; 
      }       
      if($filterErprobt!=''){
        $query.=' AND sa.ErprobtID '.$filterErprobt. PHP_EOL; 
      }
      if($filterSchwierigkeitsgrad!=''){
        $query.=' AND sa.SchwierigkeitsgradID '.$filterSchwierigkeitsgrad. PHP_EOL; 
      }                
      if($filterSpieldauer!=''){
        $query.=' AND sa.Spieldauer '.$filterSpieldauer. PHP_EOL; 
      }
      if($filterSuchtext!=''){
        $query.=' AND'.$filterSuchtext. PHP_EOL; 
      }
      $query.=($filterLookups!=''?' AND satz_lookup.LookupID '.$filterLookups.PHP_EOL:''); 


      /* Gruppierung abhängig von Ebene  */
      switch ($Ebene){    
        case 'Sammlung': 
          $query.=" group by s.ID". PHP_EOL;     
          break; 
        case 'Musikstueck': 
          $query.=" group by m.ID". PHP_EOL;         
          break; 
        case 'Satz': 
          $query.=" group by sa.ID". PHP_EOL;             
          break;      
      }

      /* Sortierung abhängig von Ebene  */
      switch ($Ebene){    
        case 'Sammlung': 
          $query.=" ORDER BY s.Name". PHP_EOL;     
          break; 
        case 'Musikstueck': 
          $query.=" ORDER BY s.Name, m.Nummer". PHP_EOL;         
          break; 
        case 'Satz': 
          $query.=" ORDER BY s.Name, m.Nummer, sa.Nr". PHP_EOL;           
          break;      
      }

      // echo '<pre>'.$query.'</pre>'; // Test 


      if (isset($_POST["Abfrage"])) {
        // Abfrage speichern, Ergebnis nicht ausgeben 
        if ($_POST["Abfrage"]!='') {
          include_once("cl_abfrage.php");
          $abfrage = new Abfrage();
          $abfrage->insert_row($_POST["Abfrage"]); 
          $abfrage->update_row($abfrage->Name,'',$query, $edit_table);
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

<!-- Ende Spalte 2 -->  
</td>
</tr>
</table>
  <?php


include('foot.php');

?>
