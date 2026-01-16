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
include_once("classes/class.uebungtyp.php");
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
    &nbsp; <a href="help_suche.php" target="_blank">Hilfe</a>
<form id="Suche" action="" method="GET">

  <br><b>Ansicht: </b>
  <select id="Ansicht" name="Ansicht" onchange="this.form.submit()" style="background-color: lightgreen">
      <option value="Sammlung" <?php echo ($Ansicht=='Sammlung'?'selected':'');?>>Sammlung</option>   
      <option value="Sammlung2" <?php echo ($Ansicht=='Sammlung2'?'selected':'')?>>Sammlung, Musikstück</option>
      <option value="Sammlung3" <?php echo ($Ansicht=='Sammlung3'?'selected':'')?>>Sammlung, Musikstück, Satz</option>              
      <option value="Sammlung4" <?php echo ($Ansicht=='Sammlung4'?'selected':'')?>>Sammlung, Musikstück, Satz + Schüler</option>    

      <option value="Schueler1" <?php echo ($Ansicht=='Schueler1'?'selected':'')?>>Schüler</option> 
      <option value="Schueler2" <?php echo ($Ansicht=='Schueler2'?'selected':'')?>>Schüler erweitert</option>                                        
  
      <option value="Uebung1" <?php echo ($Ansicht=='Uebung1'?'selected':'')?>>Übungen</option> 

    </select>



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
  <p class="navi-trenner">Schüler </p> 
  <?php

/************* Gruppe Schüler, Filter Schüler -> immer sichtbar   ***********/ 

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
  $schueler->print_select($SchuelerID,'',$schueler->Title, true );  


/************* Gruppe Schüler, Filter Status -> immer sichtbar   ***********/ 

  if ($AnsichtGruppe=='Schueler' || $AnsichtGruppe=='Noten' ) {

    $StatusID=isset($_REQUEST['StatusID'])?$_REQUEST['StatusID']:''; 

    $status = new Status();

    if ($StatusID!='') {
      $filter=true;        
      $Suchabfrage->StatusID = $StatusID;        
      $status->ID= $StatusID; 
      $status->load_row(); 
      $Suchabfrage->Beschreibung.='* Status Schüler/Noten: '.$status->Name.'<br>';
      $Suchabfrage->AnzahlFilter1+=1;
      $Suchabfrage->AnzahlFilter2+=1;              
    }

    echo '<p>';
    $status->print_select($StatusID, 'Status Noten');
    echo '</p>';
  }


/************* Gruppe Schüler, Filter Instrument  ***********/  
  if ($AnsichtGruppe=='Schueler') {
    $instrument_schueler = new Instrument();
    $InstrumentID_Schueler=''; 
    if (isset($_REQUEST['InstrumentID_Schueler'])) { 
      $InstrumentID_Schueler=$_REQUEST['InstrumentID_Schueler'];       
      if ($InstrumentID_Schueler!='') {
        $Suchabfrage->InstrumentID_Schueler=$InstrumentID_Schueler; 
        $instrument_schueler->ID=  $InstrumentID_Schueler; 
        $instrument_schueler->load_row(); 
        $Suchabfrage->Beschreibung.='* Instrument: '.$instrument_schueler->Name.'<br>';     
        $filter=true;
      $Suchabfrage->AnzahlFilter1+=1;              
      }
    }
    $instrument_schueler->Parent='Schueler'; 
    $instrument_schueler->print_select_suche($InstrumentID_Schueler,'Instrument');
  }

/************* Gruppe Schüler, Filter Schwierigkeitsgrade  ***********/  
  if ($AnsichtGruppe=='Schueler') {
    if (isset($_REQUEST['Schwierigkeitsgrad_Schueler'])) {
      $Suchabfrage->Schwierigkeitsgrade_Schueler = $_REQUEST['Schwierigkeitsgrad_Schueler'];   
      $filter=true;     
      $Suchabfrage->AnzahlFilter1+=1;       
    }  
    $schwierigkeitsgrad_schueler = new Schwierigkeitsgrad();
    $schwierigkeitsgrad_schueler->Parent='Schueler';     
    $schwierigkeitsgrad_schueler->print_select_multi($Suchabfrage->Schwierigkeitsgrade_Schueler);    
    $Suchabfrage->Beschreibung.=(count($Suchabfrage->Schwierigkeitsgrade_Schueler)>0?$schwierigkeitsgrad_schueler->titles_selected_list.'<br>':'');  
  }

 /*** Navi-Block Gruppe Uebungen */
  if($AnsichtGruppe=='Uebungen') {
    ?>
    <p class="navi-trenner">Übungen</p> 
    <?php
  }

  if ($AnsichtGruppe=='Uebungen' ) {

    $UebungtypID=isset($_REQUEST['UebungtypID'])?$_REQUEST['UebungtypID']:'';

    $uebungtyp = new UebungTyp();

    if ($UebungtypID!='') {
        $filter=true;
        $Suchabfrage->UebungtypID = $UebungtypID;         
        $uebungtyp->ID=$UebungtypID; 
        $uebungtyp->load_row(); 
        $Suchabfrage->Beschreibung.='* Übung Typ: '.$uebungtyp->Name.'<br>';      
    }
    $uebungtyp->print_select($UebungtypID,true);  

    $Datum=(isset($_REQUEST["Datum"])?$_REQUEST["Datum"]:'');     
        
    echo '<br><br> Übung Datum: <input type="date" name="Datum" value="'.$Datum.'" >'; 
    
    if ($Datum!='') {
        $filter=true; 
        $Suchabfrage->Datum = $Datum; 
    }

  }

/*** Navi-Block Gruppe Noten, "Sammlung */
  if($AnsichtGruppe=='Noten') {
    ?>
    <p class="navi-trenner">Sammlung </p> 
    <?php
  }
 
/************* Gruppe Noten, Filter Standort  ***********/
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

/************* Gruppe Noten, Filter Verlag  ***********/
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

/************* Gruppe Noten, Filter Linktyp  ************** */  
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


/*** Navi-Block Gruppe Noten, "Musikstück */
  if($AnsichtGruppe=='Noten') {
    ?>
    <p class="navi-trenner">Musikstück </p> 
    <?php 
  }

/************* Gruppe Noten, Filter Komponist  ***********/
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


/************* Gruppe Noten, Filter Besetzungen  ***********/
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

/************* Gruppe Noten, Filter Verwendungszwecke  ***********/
  if ($AnsichtGruppe=='Noten') {
    if (isset($_REQUEST['Verwendungszwecke'])) {
      $Suchabfrage->Verwendungszwecke = $_REQUEST['Verwendungszwecke'];   
      $filter=true;     
      $Suchabfrage->AnzahlFilter1+=1;       
    }  
    $verwendungszweck = new Verwendungszweck();
    $verwendungszweck->print_select_multi($Suchabfrage->Verwendungszwecke);    
    $Suchabfrage->Beschreibung.=(count($Suchabfrage->Verwendungszwecke)>0?$verwendungszweck->titles_selected_list.'<br>':'');  
  }

/************* Gruppe Noten, Filter Gattung  ***********/
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

/************* Gruppe Noten, Filter Epoche  ***********/
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
 
/************* Gruppe Noten, Filter Materialtyp  **********/
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


/*** Navi-Block Gruppe Noten, "Satz */
  if($AnsichtGruppe=='Noten') {
    ?>
    <p class="navi-trenner">Satz </p> 
    <?php
  }

/************* Gruppe Noten, Filter Satz: Instrument/Schwierigkeitsgrad  ***********/
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

/************* Gruppe Noten, Filter Instrument **********/  
  if ($AnsichtGruppe=='Noten') {
    $instrument_satz = new Instrument();
    $InstrumentID_Satz=''; 
    if (isset($_REQUEST['InstrumentID_Satz'])) { 
      $InstrumentID_Satz=$_REQUEST['InstrumentID_Satz'];       
      if ($InstrumentID_Satz!='') {
        $Suchabfrage->InstrumentID_Satz=$InstrumentID_Satz; 
        $instrument_satz->ID=  $InstrumentID_Satz; 
        $instrument_satz->load_row(); 
        $Suchabfrage->Beschreibung.='* Instrument: '.$instrument_satz->Name.'<br>';     
        $filter=true;
      $Suchabfrage->AnzahlFilter1+=1;              
      }
    }
    // $instrument_material->Parent='Material'; 
    $instrument_satz->Parent='Satz'; 
    $instrument_satz->print_select_suche($InstrumentID_Satz,'Instrument');


/************* Gruppe Noten, Filter Erprobt  ***********/
  if ($AnsichtGruppe=='Noten') {
   
    // $Erprobt=[];  // im Suchfilter ausgewählte Erprobt-Einträge  (IDs) 
    if (isset($_REQUEST['Erprobt'])) {
      $filter=true;      
      $Suchabfrage->Erprobte = $_REQUEST['Erprobt'];   
      

    } 
    $erprobt = new Erprobt(); 
    $erprobt->print_select_multi($Suchabfrage->Erprobte);  
    // $Suchabfrage->Beschreibung.=(count($Erprobt)>0?$erprobt->titles_selected_list.PHP_EOL:''); 
    $Suchabfrage->Beschreibung.=(count($Suchabfrage->Erprobte)>0?$erprobt->titles_selected_list.'<br>':'');  

  }

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




/************* Gruppe Noten, Filter Spieldauer  ****************/  
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












/************* ALT #Material: Filter Schwierigkeitsgrad **********/      
    // $Schwierigkeitsgrade_Material=[];
    // $schwierigkeitsgrad_material = new Schwierigkeitsgrad();
    // if (isset($_REQUEST['Schwierigkeitsgrad_Material'])) {
    //   $Schwierigkeitsgrade_Material = $_REQUEST['Schwierigkeitsgrad_Material']; 
    //   $Suchabfrage->Schwierigkeitsgrade_Material = $Schwierigkeitsgrade_Material; 
    //   $filter=true; 
    //   $Suchabfrage->AnzahlFilter2+=1;      
    // }
    // $schwierigkeitsgrad_material->Parent='Material'; 
    // // $schwierigkeitsgrad_material->Parent='Satz';     
    // $schwierigkeitsgrad_material->print_select_multi($Schwierigkeitsgrade_Material);  
    // $Suchabfrage->Beschreibung.=(count($Schwierigkeitsgrade_Material)>0?$schwierigkeitsgrad_material->titles_selected_list.'<br>':'');  
  
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
      if (in_array("musikstueck", $relations)) {
        // XXXX 
        $Suchabfrage->AnzahlFilter2+=1;
      }               
      $lookup_values_selected= $_REQUEST[$lookup_type_key]; 
      $lookup_values = $lookup->getArrLookups();       
      $lookup_values_not_selected = array_diff($lookup_values, $lookup_values_selected); // nicht ausgewählte Werte    
      $lookuptype_check_include=(isset($_REQUEST['include_'.$lookup_type_key])?true:false);   //  "Einschluss-Suche" aktiviert        
      $lookuptype_check_exclude=(isset($_REQUEST['exclude_'.$lookup_type_key])?true:false);   //  "Ausschluss-Suche" aktiviert        

      $Suchabfrage->LookupTypesSelected[$lookup_type_key] = Array(
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

  $Suchabfrage->printTable(); 

  // $Suchabfrage->printTest(); // TEST 

  keinFilter: 


?>
</div> <!-- end class search-result -->
</div> <!-- end class search-page -->

<?php 
 
include_once('foot.php');
?>
