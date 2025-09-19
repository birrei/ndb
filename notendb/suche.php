<?php 
$PageTitle='Suche'; 
include_once('head.php');
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
include_once("classes/class.suchabfrage.php");


/***** Parameter: Initialisierung, Defaults  ******/

  $Suchabfrage=new Suchabfrage();
  $Ansicht=isset($_REQUEST['Ansicht'])?$_REQUEST['Ansicht']:'Sammlung'; 
  $Suchabfrage->setAnsicht($Ansicht); 
  $AnsichtGruppe=$Suchabfrage->AnsichtGruppe; 

  $filter=false;  

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

<form id="Suche" action="" method="GET">

  <br><b>Ansicht: </b>
  <select id="Ansicht" name="Ansicht" onchange="this.form.submit()" style="background-color: lightgreen">
      <option value="Sammlung" <?php echo ($Ansicht=='Sammlung'?'selected':'');?>>Sammlung</option>   
      <option value="Sammlung erweitert" <?php echo ($Ansicht=='Sammlung erweitert'?'selected':'')?>>Sammlung erweitert</option>
      <option value="Sammlung erweitert 2" <?php echo ($Ansicht=='Sammlung erweitert 2'?'selected':'')?>>Sammlung erweitert 2</option>              
      <option value="Sammlung erweitert 3" <?php echo ($Ansicht=='Sammlung erweitert 3'?'selected':'')?>>Sammlung erweitert 3</option>    

      <!-- <option value="Sammlung Links" <?php echo ($Ansicht=='Sammlung Links'?'selected':'')?>>Sammlung spezial: Links</option>     
      <option value="Satz Besonderheiten" <?php echo ($Ansicht=='Satz Besonderheiten'?'selected':'')?>>Satz spezial: Besonderheiten</option>                     

      <option value="Schueler" <?php echo ($Ansicht=='Schueler'?'selected':'')?>>Schüler</option> 
      <option value="Schueler erweitert" <?php echo ($Ansicht=='Schueler erweitert'?'selected':'')?>>Schüler erweitert</option>                                         -->
  
    </select>

    &nbsp; <a href="help_suche.php#suche_ansichten" target="_blank">Hilfe</a>

<?php 

/************* Filter Suchtext  **********/  

  $Suchabfrage->Beschreibung.='Filter:<br>'; 

  $Suchtext=''; 
  if (isset($_REQUEST['Suchtext'])) {
    $Suchtext = $_REQUEST['Suchtext'];     
    if ($Suchtext!='') {
      $Suchabfrage->Suchtext=$Suchtext; 
      $Suchabfrage->Beschreibung.=$Suchtext!=''?'* Suchtext: '.$Suchtext.'<br>':''; 
      $filter=true; 
      $Suchabfrage->AnzahlFilter1+=1; 
      $Suchabfrage->AnzahlFilter2+=1; 
    }
  }  
  ?>
  <p>Suchtext: <br><input type="text" id="Suchtext" name="Suchtext" size="30px" value="<?php echo $Suchtext; ?>" autofocus> 
  <input class="btnSave" type="submit" value="Suchen" width="100px">
  <input type="hidden" name="Filter" value="Suchen">
  </P> 

<!-- Navi-Block "Schüler (immer anzeigen) -->
  <p class="navi-trenner">Schüler </p> 
  <?php

/************* Filter Schüler, Schüler Status - Auswahlfelder werden - unabhängig von Ansicht - immer angezeigt ***********/

  $SchuelerID=isset($_REQUEST['SchuelerID'])?$_REQUEST['SchuelerID']:'';
    
  $schueler = new Schueler();

  if ($SchuelerID!='') {
      $filter=true;
      $Suchabfrage->SchuelerID = $SchuelerID;         
      $schueler->ID=$SchuelerID; 
      $schueler->load_row(); 
      $Suchabfrage->Beschreibung.='* Schüler: '.$schueler->Name.'<br>';      
      $Suchabfrage->AnzahlFilter1+=1; 
      $Suchabfrage->AnzahlFilter2+=1;  
  }

  $StatusID=isset($_REQUEST['StatusID'])?$_REQUEST['StatusID']:''; 

  $status = new Status();

  if ($StatusID!='') {
    $filter=true;        
    $Suchabfrage->StatusID = $StatusID;        
    $status->ID= $StatusID; 
    $status->load_row(); 
    $Suchabfrage->Beschreibung.='* Status Schüler: '.$status->Name.'<br>';
    $Suchabfrage->AnzahlFilter1+=1;
    $Suchabfrage->AnzahlFilter2+=1;              
  }

  $schueler->print_select($SchuelerID,'',$schueler->Title, true );  

  echo '<p>';
  $status->print_select($StatusID, 'Status');
  echo '</p>';


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
    if (isset($_REQUEST['StandortID'])) {
      $StandortID = $_REQUEST['StandortID']; 
      if ($StandortID!='') {
        $filter=true;          
        $Suchabfrage->StandortID = $StandortID; 
        $standort->ID=$StandortID; 
        $standort->load_row();   
        $Suchabfrage->Beschreibung.='* Standort: '.$standort->Name.'<br>';
        $Suchabfrage->AnzahlFilter1+=1;
        $Suchabfrage->AnzahlFilter2+=1;      
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
    if (isset($_REQUEST['VerlagID']) ) {
      $VerlagID=$_REQUEST['VerlagID']; 
      if ($VerlagID!='') {
        $filter=true;
        $Suchabfrage->VerlagID = $VerlagID;                   
        $verlag->ID=$VerlagID; 
        $verlag->load_row();      
        $Suchabfrage->Beschreibung.='* Verlag: '.$verlag->Name.'<br>';     
        $Suchabfrage->AnzahlFilter1+=1;
        $Suchabfrage->AnzahlFilter2+=1; 
      }   
    }
    echo '<p>';
    $verlag->print_select($VerlagID, $verlag->Title);
    echo '</p>';
  }

/************* XXXX Filter Linktypen  ************** */  
  if ($AnsichtGruppe=='Noten') {
    $Linktypen=[];   /* Sammlung */
    $linktyp = new Linktype();
    if (isset($_REQUEST['Linktypen'])) {
      $Linktypen = $_REQUEST['Linktypen'];
      $Suchabfrage->Linktypen = $Linktypen;  
      $filter=true;    
      $Suchabfrage->AnzahlFilter1+=1;
      $Suchabfrage->AnzahlFilter2+=1;    
    }  
    $linktyp->print_select_multi($Linktypen);      
    $Suchabfrage->Beschreibung.=(count($Linktypen)>0?$linktyp->titles_selected_list.PHP_EOL:''); 
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
    if (isset($_REQUEST['KomponistID'])) {
      if ($_REQUEST['KomponistID']!='') {
        $KomponistID = $_REQUEST['KomponistID']; 
        $Suchabfrage->KomponistID = $KomponistID; 
        $komponist->ID=  $KomponistID; 
        $komponist->load_row(); 
        $Suchabfrage->Beschreibung.='* Komponist: '.$komponist->Name.'<br>';     
        $filter=true; 
        $Suchabfrage->AnzahlFilter1+=1;
        // $Suchabfrage->AnzahlFilter2+=1;       
      }
    }
    $komponist->print_select($KomponistID,$komponist->Title);
  }


/************* Filter Besetzungen  ***********/
  if ($AnsichtGruppe=='Noten') {
    $besetzung = new Besetzung();
    if (isset($_REQUEST['Besetzungen'])) {
      $filter=true; 
      $Suchabfrage->AnzahlFilter1+=1;       
      $Suchabfrage->Besetzungen_selected = $_REQUEST['Besetzungen']; // Array IDs aus Mehrfachauswahl    
      $Suchabfrage->besetzung_check_include=isset($_REQUEST["include_Besetzung"])?true:false; 
      $Suchabfrage->besetzung_check_exclude=isset($_REQUEST["exclude_Besetzung"])?true:false; 
      $Suchabfrage->Besetzungen_all= $besetzung->getArray();              
      $Suchabfrage->Besetzungen_not_selected = array_diff($Suchabfrage->Besetzungen_all, $Suchabfrage->Besetzungen_selected); 
    }
    $besetzung->print_select_multi($Suchabfrage->Besetzungen_selected, $Suchabfrage->besetzung_check_include, $Suchabfrage->besetzung_check_exclude); 
    $Suchabfrage->Beschreibung.=(count($Suchabfrage->Besetzungen_selected)>0?$besetzung->titles_selected_list.PHP_EOL:'');  
    $Suchabfrage->Beschreibung.=($Suchabfrage->besetzung_check_include?' / +Einschluss-Suche':'');  
    $Suchabfrage->Beschreibung.=($Suchabfrage->besetzung_check_exclude?' / +Ausschluss-Suche':'');  
  }

/************* Filter Verwendungszwecke XXX offen: Einschluss/Ausschluss-Suche (erforderlich?) ***********/
  if ($AnsichtGruppe=='Noten') {
    if (isset($_REQUEST['Verwendungszwecke'])) {
      $Suchabfrage->Verwendungszwecke = $_REQUEST['Verwendungszwecke'];   
      $filter=true;     
      $Suchabfrage->AnzahlFilter1+=1;       
    }  
    $verwendungszweck = new Verwendungszweck();
    $verwendungszweck->print_select_multi($Suchabfrage->Verwendungszwecke);    
    $Suchabfrage->Beschreibung.=(count($Suchabfrage->Verwendungszwecke)>0?$verwendungszweck->titles_selected_list.PHP_EOL:'');  
  }

/************* Filter Gattung  ***********/
  if ($AnsichtGruppe=='Noten') {
    $gattung = new Gattung();
    $GattungID=''; 
    if (isset($_REQUEST['GattungID'])) {
        $GattungID = $_REQUEST['GattungID'];       
        if ($GattungID!='') {
          $filter=true;   
          $Suchabfrage->AnzahlFilter1+=1; 
          $Suchabfrage->GattungID = $GattungID; 
          $gattung->ID=$GattungID; 
          $gattung->load_row();
          $Suchabfrage->Beschreibung.=($GattungID!=''?'* Gattung: '.$gattung->Name.'<br>':'');     
      }
    }
    echo '<p>'; 
    $gattung->print_select($GattungID, $gattung->Title);
    echo '</p>'; 
  }

/************* Filter Epoche  ***********/
  if ($AnsichtGruppe=='Noten') {
    $epoche = new Epoche();
    $EpocheID=''; 
    if (isset($_REQUEST['EpocheID'])) {
      $EpocheID=$_REQUEST['EpocheID']; 
      if ($EpocheID!='') { 
        $filter=true; 
        $Suchabfrage->AnzahlFilter1+=1; 
        $Suchabfrage->EpocheID=$EpocheID; 
        $epoche->ID=  $EpocheID; 
        $epoche->load_row(); 
        $Suchabfrage->Beschreibung.=($EpocheID!=''?'* Epoche: '.$epoche->Name.'<br>':'');     
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

/************* Filter Satz: Instrument/Schwierigkeitsgrad  ***********/
  if ($AnsichtGruppe=='Noten') {
    $InstrumentSchwierigkeitsgrade=[];
    $schwierigkeitsgrad = new InstrumentSchwierigkeitsgrad();
    if (isset($_REQUEST['InstrumentSchwierigkeitsgrad'])) {
      $InstrumentSchwierigkeitsgrade = $_REQUEST['InstrumentSchwierigkeitsgrad'];   
      $Suchabfrage->InstrumentSchwierigkeitsgrade = $InstrumentSchwierigkeitsgrade; 
      $filter=true; 
      $Suchabfrage->AnzahlFilter1+=1;       
    }
    $schwierigkeitsgrad->print_select_multi($InstrumentSchwierigkeitsgrade);  
    $Suchabfrage->Beschreibung.=(count($InstrumentSchwierigkeitsgrade)>0?$schwierigkeitsgrad->titles_selected_list.'<br>':'');
  }


  // if ($AnsichtGruppe=='Schueler') {
    //   $instrument_schueler = new Instrument();
    //   $InstrumentID_Schueler=''; 
    //   if (isset($_REQUEST['InstrumentID_Schueler'])) {
    //     if ($_REQUEST['InstrumentID_Schueler']!='') {
    //       $InstrumentID_Schueler = $_REQUEST['InstrumentID_Schueler']; 
    //       $instrument_schueler->ID=  $InstrumentID_Schueler; 
    //       $instrument_schueler->load_row(); 
    //       $query_WHERE.='AND schueler.ID IN (SELECT SchuelerID FROM schueler_schwierigkeitsgrad WHERE InstrumentID='.$InstrumentID_Schueler.') '.PHP_EOL; 
    //       $Suchabfrage->Beschreibung.='* Instrument (Schüler): '.$instrument_schueler->Name.'<br>';     
    //       $filter=true;       
    //     }
    //   }
    //   $instrument_schueler->Parent='Schueler';     
    //   $instrument_schueler->print_select_suche($InstrumentID_Schueler,'Instrument');

    //   $Schwierigkeitsgrade_Schueler=[]; 
    //   $schwierigkeitsgrad_schueler = new Schwierigkeitsgrad();
    //   if (isset($_REQUEST['Schwierigkeitsgrad_Schueler'])) {
    //     $Schwierigkeitsgrade_Schueler = $_REQUEST['Schwierigkeitsgrad_Schueler']; 
    //     // echo count($Schwierigkeitsgrade); 
    //     $query_WHERE.='AND schueler.ID IN (SELECT SchuelerID FROM schueler_schwierigkeitsgrad WHERE SchwierigkeitsgradID IN ('.implode(',', $Schwierigkeitsgrade_Schueler).')) '.PHP_EOL; 
    //     $filter=true;       
    //   }
    //   $schwierigkeitsgrad_schueler->Parent='Schueler';    
    //   $schwierigkeitsgrad_schueler->print_select_multi($Schwierigkeitsgrade_Schueler, 'Schwierigkeitsgrad (Schüler)');  
    //   $Suchabfrage->Beschreibung.=(count($Schwierigkeitsgrade_Schueler)>0?$schwierigkeitsgrad_schueler->titles_selected_list.PHP_EOL:'');  
    // }
  
/************* Filter Erprobt  ***********/
  // if ($AnsichtGruppe=='Noten') {
  //   $Erprobt=[];  // im Suchfilter ausgewählte Erprobt-Einträge  (IDs) 
  //   if (isset($_REQUEST['Erprobt'])) {
  //     $Erprobt = $_REQUEST['Erprobt'];   
  //     $query_WHERE.='AND satz.ID IN (SELECT SatzID FROM satz_erprobt WHERE ErprobtID IN ('.implode(',', $Erprobt).')) '.PHP_EOL; 
  //     $filter=true;
  //      $Suchabfrage->AnzahlFilter1+=1;      
  //   } 
  //   $erprobt = new Erprobt();
  //   $erprobt->print_select_multi($Erprobt);  
  //   $Suchabfrage->Beschreibung.=(count($Erprobt)>0?$erprobt->titles_selected_list.PHP_EOL:'');            
  // }

        // XXX NICHT /************* Erprobt Jahr // vermutlich nicht benötigt ***********/
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
        //     $Suchabfrage->Beschreibung.='* Erprobt Jahr: '.$ErprobtJahr_von.PHP_EOL;
        //     $filter=true;       
        //   }
        //   if($ErprobtJahr_von !='' and $ErprobtJahr_bis !=''){
        //     $filterErprobtJahr=' BETWEEN '.$ErprobtJahr_von.' AND '.$ErprobtJahr_bis; 
        //     $Suchabfrage->Beschreibung.='* Erprobt Jahr: von '.$ErprobtJahr_von.' bis '.$ErprobtJahr_bis.PHP_EOL;
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
        $Suchabfrage->Beschreibung.='* Spieldauer: zwischen '.$spieldauer_von_min.' Minuten und '.$spieldauer_bis_min.' Minuten'.PHP_EOL;
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
  if($AnsichtGruppe=='Noten') {
    ?>
    <p class="navi-trenner">Material</p> 
    <?php
  }   

/************* #Material: Filter Materialtyp  **********/
  if ($AnsichtGruppe=='Noten') {
    $materialtyp = new Materialtyp();
    $MaterialtypID=''; 
    if (isset($_REQUEST['MaterialtypID'])) {
      $MaterialtypID = $_REQUEST['MaterialtypID'];           
      if ($MaterialtypID!='') {
        $materialtyp->ID= $MaterialtypID; 
        $Suchabfrage->MaterialtypID=$MaterialtypID;
        $materialtyp->load_row(); 
        $Suchabfrage->Beschreibung.=($MaterialtypID!=''?'* Materialtyp: '.$materialtyp->Name.'<br>':'');     
        $filter=true;
        $Suchabfrage->AnzahlFilter1+=1;       
        $Suchabfrage->AnzahlFilter2+=1;       
      }
    }
    echo '<p>'; 
    $materialtyp->print_select($MaterialtypID, $materialtyp->Title);
    echo '</p>'; 
  }




/************* #Material: Filter Instrument **********/  
  if ($AnsichtGruppe=='Noten') {
    $instrument_material = new Instrument();
    $InstrumentID_Material=''; 
    if (isset($_REQUEST['InstrumentID_Material'])) { 
      $InstrumentID_Material=$_REQUEST['InstrumentID_Material'];       
      if ($InstrumentID_Material!='') {
        $Suchabfrage->InstrumentID_Material=$InstrumentID_Material; 
        $instrument_material->ID=  $InstrumentID_Material; 
        $instrument_material->load_row(); 
        $Suchabfrage->Beschreibung.='* Instrument Material: '.$instrument_material->Name.'<br>';     
        $filter=true;
        $Suchabfrage->AnzahlFilter2+=1;       
      }
    }
    $instrument_material->Parent='Material'; 
    $instrument_material->print_select_suche($InstrumentID_Material,'Instrument');



/************* #Material: Filter Schwierigkeitsgrad **********/      
    $Schwierigkeitsgrade_Material=[];
    $schwierigkeitsgrad_material = new Schwierigkeitsgrad();
    if (isset($_REQUEST['Schwierigkeitsgrad_Material'])) {
      $Schwierigkeitsgrade_Material = $_REQUEST['Schwierigkeitsgrad_Material']; 
      $Suchabfrage->Schwierigkeitsgrade_Material = $Schwierigkeitsgrade_Material; 
      $filter=true; 
      $Suchabfrage->AnzahlFilter2+=1;      
    }
    $schwierigkeitsgrad_material->Parent='Material'; 
    $schwierigkeitsgrad_material->print_select_multi($Schwierigkeitsgrade_Material);  
    $Suchabfrage->Beschreibung.=(count($Schwierigkeitsgrade_Material)>0?$schwierigkeitsgrad_material->titles_selected_list.'<br>':'');  
  }


  ?>
<p class="navi-trenner">Besonderheiten</p> 
<?php

/************* Filter Besonderheiten  XXXX **********/
  $lookuptypes=new Lookuptype(); 
  $arrLookupTypes=$lookuptypes->getArrData2();
  for ($i = 0; $i < count($arrLookupTypes); $i++) {
    $tmpAdditionalInfo='';  
    $lookuptype_check_include=false; // Einschluss-Suche ja/nein 
    $lookuptype_check_exclude=false;    // Ausschluss-Suche ja/nein
    $lookup_type_name=$arrLookupTypes[$i]["Name"]; 
    $lookup_type_key= $arrLookupTypes[$i]["type_key"]; 
    $relations = $arrLookupTypes[$i]["Relation"];  // array zugeordnete "relations"
    
    $lookup=New Lookup(); 
    $lookup->LookupTypeID=$arrLookupTypes[$i]["ID"];
    $lookup_values=[]; // alle Lookupwerte eines Typs 
    $lookup_values_selected=[];    // ausgewählte Lookup-Werte 
    $lookup_values_not_selected=[];  // nicht ausgewählte Lookup-Werte 
    // // print_r($lookup_values); // Test 
    if (isset($_REQUEST[$lookup_type_key])) {
      $filter=true;   
          // print_r($relations);  // Test 
      if (in_array("sammlung", $relations)) {
        $Suchabfrage->AnzahlFilter1+=1;
        $Suchabfrage->AnzahlFilter2+=1;  
      }
      if (in_array("satz", $relations)) {
        $Suchabfrage->AnzahlFilter1+=1;
      }
      if (in_array("material", $relations)) {
        $Suchabfrage->AnzahlFilter2+=1;
      }               
      $lookup_values_selected= $_REQUEST[$lookup_type_key]; 
      $lookup_values = $lookup->getArrLookups();       
      $lookup_values_not_selected = array_diff($lookup_values, $lookup_values_selected); // nicht ausgewählte Werte    
      $lookuptype_check_include=(isset($_REQUEST['include_'.$lookup_type_key])?true:false);   //  "Einschluss-Suche" aktiviert        
      $lookuptype_check_exclude=(isset($_REQUEST['exclude_'.$lookup_type_key])?true:false);   //  "Ausschluss-Suche" aktiviert        

      $Suchabfrage->AllLookupTypes[$lookup_type_key] = Array(
        'lookuptype_ID'=>$arrLookupTypes[$i]["ID"],
        'lookuptype_name'=>$arrLookupTypes[$i]["Name"],          
        'lookuptype_key'=>$arrLookupTypes[$i]["type_key"],
        'lookuptype_relations'=>$arrLookupTypes[$i]["Relation"], // array
        'lookuptype_check_include'=>$lookuptype_check_include, 
        'lookuptype_check_exclude'=>$lookuptype_check_exclude, 
        'lookup_values_all'=>$lookup_values, // array  // alle Lookupwerte (IDS) eines Typs          
        'lookup_values_selected'=>$lookup_values_selected, // array  // alle ausgewählten Lookupwerte (IDS) eines Typs          
        'lookup_values_not_selected'=>$lookup_values_not_selected // array  // alle NICHT ausgewählten Lookupwerte (IDS) eines Typs          
                                
      );
      if($lookuptype_check_include) {
        $tmpAdditionalInfo.='[Einschluss-Suche] '; 
      }      
      if($lookuptype_check_exclude) {
        $tmpAdditionalInfo.='[Ausschluss-Suche] '; 
      }      
    }    
    $lookup->print_select_multi($lookup_type_key,$lookup_values_selected, $lookup_type_name.':', true, $lookuptype_check_include, true,$lookuptype_check_exclude );
    $Suchabfrage->Beschreibung.=(count($lookup_values_selected)>0?$lookup->titles_selected_list.' '.$tmpAdditionalInfo.'<br>':'');   
  }


?>
</form>
</div> 
<!-- ende class search-filter --> 
<div class="search-result" id="search-result">
<?php

  // echo 'Anzahl Filter 1: '.$Suchabfrage->AnzahlFilter1.'<br>'; // TEST
  // echo 'Anzahl Filter 2: '.$Suchabfrage->AnzahlFilter2.'<br>'; // TEST


/************* Falls kein Filter ausgewählt wurde **********/  
  if(!$filter) {
    $Suchabfrage->Beschreibung.='Es wurde kein Filter gesetzt.';     
    echo 'Es wurde kein Filter gesetzt'.PHP_EOL;
    goto keinFilter; 
  } 

/************* Ausgabe Ergebnisse **********/  

  // $Suchabfrage->printSQL=true;  // TEST 

  $Suchabfrage->printDescription(); 

  if ($Suchabfrage->AnzahlFilter1 > 0) {
     $Suchabfrage->printTable('Sammlung_Noten'); 
  }

  // $Suchabfrage->printTest(); // TEST 
 
  if ($Suchabfrage->AnzahlFilter2 > 0) {
     $Suchabfrage->printTable('Sammlung_Material');  
  }

  // $Suchabfrage->printTest(); // TEST 


  keinFilter: 


?>
</div> <!-- end class search-result -->
</div> <!-- end class search-page -->

<?php 
 
include_once('foot.php');
?>
