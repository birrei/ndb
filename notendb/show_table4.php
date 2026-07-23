<?php
include_once('classes/class.htmlinfo.php');
include_once('classes/class.sqlpart.php');
include_once("classes/dbconn/class.db.php");
include_once("classes/class.schueler.php");
include_once("classes/class.wochentage.php");

$info=new HTML_Info(); 

$table_edit=''; 
$query=''; 
$show_data=false; 
$ansicht=''; 
$PageTitle=''; 
$fehlertext=''; 
$show_help_link=true; 
$add_link_show = false; 

if (isset($_REQUEST["ansicht"])) {
  $ansicht=$_REQUEST["ansicht"]; 
  $show_data=true; 
} 

$add_link_edit=true; 

switch ($ansicht) // $PageTitle, $table_edit 
{
  case 'sammlungen'; 
    $PageTitle='Übersicht Sammlungen'; 
    $table_edit = 'sammlung'; 
    break; 
  case 'besonderheiten'; 
    $PageTitle='Übersicht Besonderheiten'; 
    break;     
  case 'schueler'; 
    $PageTitle='Übersicht Schüler';  
    $table_edit='schueler';     
    break; 
  case 'uebungen'; 
    $PageTitle='Übersicht Übungen ';  
    $table_edit='uebung';     
    break; 
  case 'uebungstage'; // aka "Übungstage / alt: Übungen / Datum 
    $PageTitle='Übersicht Übungstage';  
    break;     
  case 'verwendungszwecke'; 
    $PageTitle='Übersicht Verwendungszwecke';  
    $table_edit='verwendungszweck';     
    break; 
  case 'standorte'; 
    $PageTitle='Übersicht Standorte';  
    $table_edit='standort';     
    break; 
  case 'linktypen'; 
    $PageTitle='Übersicht Linktypen';  
    break; 
  case 'verlage'; 
    $PageTitle='Übersicht Verlage';  
    $table_edit='verlag';     
    break; 
  case 'komponisten'; 
    $PageTitle='Übersicht Komponisten';  
    break; 
    
  case 'besetzungen'; 
    $PageTitle='Übersicht Besetzungen';  
    break; 
  case 'status'; 
    $PageTitle='Übersicht Status-Ausprägungen';  
    break; 

  case 'gattungen'; 
    $PageTitle='Übersicht Gattungen';  
    break; 

  case 'epochen'; 
    $PageTitle='Übersicht Epochen';  
    break; 

  case 'materialtypen'; 
    $PageTitle='Übersicht Materialtypen';  
    break; 

  case 'schwierigkeitsgrade'; 
    $PageTitle='Übersicht Schwierigkeitsgrade';  
    break; 

  case 'instrumente'; 
    $PageTitle='Übersicht Instrumente';  
    break; 
  case 'erprobt'; 
    $PageTitle='Übersicht Erprobt';  
    break; 

  case 'kalender'; 
    $PageTitle='Kalender';  
    $table_edit='kalender';     
    break; 
  case 'schuljahre'; 
    $PageTitle='Übersicht Schuljahre';   
    break; 
  case 'ferien'; 
    $PageTitle='Übersicht Ferienzeiten';   
    break; 
  case 'feiertage'; 
    $PageTitle='Übersicht Feiertage';   
    break; 
  case 'schueler-kalender-vorlage'; 
    $PageTitle='Vorlage Übungstage (Schüler Plan-Kalender) ';   
    break; 
  case 'bewertungen'; 
    $PageTitle='Übersicht Bewertungen';   
    break; 

  case 'uebungstypen'; 
    $PageTitle='Übersicht Übungstypen';   
    break; 

  case 'info-alle-spieldauern'; 
    $PageTitle='Verwendete Spieldauern';   
    $show_help_link=false; 
    break; 
  case 'info-alle-tempobezeichnungen'; 
    $PageTitle='Verwendete Tempobezeichnungen';   
    $show_help_link=false; 
    break; 
  case 'test-sammlungen-ohne-musikstueck'; 
    $PageTitle='Sammlungen ohne Musikstück';   
    $show_help_link=false; 
    break; 
  case 'test-musikstuecke-ohne-satz'; 
    $PageTitle='Musikstücke ohne Satz';   
    $show_help_link=false; 
    break; 
  case 'test-musikstuecke-ohne-besetzung'; 
    $PageTitle='Musikstücke ohne Besetzung';   
    $show_help_link=false; 
    break; 
  case 'test-saetze-ohne-spieldauer'; 
    $PageTitle='Sätze ohne Spieldauer';   
    $show_help_link=false; 
    break; 
  case 'test-saetze-ohne-schwierigkeitsgrad'; 
    $PageTitle='Sätze ohne Schwierigkeitsgrad';   
    $show_help_link=false; 
    break; 
  case 'abfragetypen'; 
    $PageTitle='Übersicht Abfragetypen';  
    break; 
  case 'abfragen'; 
    $PageTitle='Übersicht Gespeicherte Abfragen';  
    $add_link_show = true;     
    break; 
}

include_once('head.php'); 

if ($ansicht=='' OR $query='') {
  $info->print_user_error('Es wurde keine Ansicht definiert.'); 
  goto pagefoot;
}

echo '<h3 class="header-with-help-link">'.$PageTitle.'</h3>'.PHP_EOL; 
if ($show_help_link) {
  echo '<a href="help_uebersichten.php?#uebersichten_'.$ansicht.'" target="_blank">Hilfe</a>';
}

echo '<p></p>'; 
// XXXX Filter einschränken ermöglichen (es sollen nicht automatisch alle Zeilen einer Tabelle auf einmal angezeigt werden)

switch ($ansicht)  // setzen: $PageTitle, $table_edit, $show_help_link
{
/***************** Daten ****************************** */  
  case 'sammlungen': 
    include_once("classes/class.standort.php");

    $StandortID=(isset($_REQUEST["StandortID"])?$_REQUEST["StandortID"]:'');

    $Suchtext=(isset($_REQUEST["Suchtext"])?$_REQUEST["Suchtext"]:'');    

    $Erfasst=-1; 

    if(isset($_REQUEST["VollstaendigErfasstNein"])) {
      $Erfasst=0; 
    }

    echo '<form action="" method="get">'.PHP_EOL;  
    $standort = new Standort(); 
    echo 'Standort: '.PHP_EOL; 
    $standort->print_preselect($StandortID); 
        echo ' &#9475;';
    echo '<label><input type="checkbox" name="VollstaendigErfasstNein" '.($Erfasst==0?'checked':'').'>Unvollständig erfasst</label>'; 
            echo ' &#9475;';
    echo 'Suchtext: <input type="text" id="Suchtext" name="Suchtext" size="30px" value="'.$Suchtext.'"> '; 
    echo '<input type="submit" class="btnSave" name="senden" value="Suchen">';
    echo '<input type="hidden" name="ansicht" value="'.$ansicht.'">
          </form>';    

    $query="SELECT sammlung.ID
                  , sammlung.Name
                  , v_sammlung_standorte.Standorte     
                  , verlag.Name as Verlag
                  , sammlung.Bemerkung
                  , v_sammlung_lookuptypes.LookupList as Besonderheiten       
                  , IF(Erfasst=1, 'X' , '') as `vollständig erfasst`  
            FROM sammlung 
                LEFT join verlag  on sammlung.VerlagID = verlag.ID 
                LEFT JOIN v_sammlung_standorte ON v_sammlung_standorte.SammlungID=sammlung.ID 
                LEFT JOIN sammlung_lookup on sammlung_lookup.SammlungID = sammlung.ID       
                LEFT JOIN v_sammlung_lookuptypes on v_sammlung_lookuptypes.SammlungID = sammlung.ID         
           WHERE 1=1 
    "; 


    $query.=($Erfasst > -1?'AND Erfasst='.$Erfasst.' '.PHP_EOL:''); 

    $query.=($StandortID!=''?'AND sammlung.ID IN (SELECT SammlungID FROM sammlung_standort WHERE StandortID='.$StandortID.') '.PHP_EOL:''); 
    
    if($Suchtext!='') {
      $query.="AND ( sammlung.Name LIKE '%".$Suchtext."%' 
                  OR sammlung.Bemerkung LIKE '%".$Suchtext."%' 
                  OR verlag.Name LIKE '%".$Suchtext."%' 
                  OR v_sammlung_lookuptypes.LookupList LIKE '%".$Suchtext."%' 
                            ) "; 
    }
    $query.="GROUP by sammlung.ID 
             ORDER BY sammlung.ID DESC 
            "; 
    echo '<p><a href="edit_'.$table_edit.'.php?option=insert" target="_blank">Neu erfassen</a></p>';
    
    
    
    break; 



  case 'besonderheiten': 
    include_once("classes/class.lookup.php");
    include_once("classes/class.lookuptype.php");

    $table_edit='lookup'; 

    $LookupTypeID=(isset($_REQUEST["LookupTypeID"])?$_REQUEST["LookupTypeID"]:'');

    $Suchtext=(isset($_REQUEST["Suchtext"])?$_REQUEST["Suchtext"]:'');    

    echo '<form action="" method="get">'.PHP_EOL; 

    $lookuptype = new Lookuptype(); 
    echo 'Besonderheit Typ: '.PHP_EOL; 
    $lookuptype->print_preselect($LookupTypeID); 
    echo ' Suchtext: <input type="text" id="Suchtext" name="Suchtext" size="30px" value="'.$Suchtext.'"> '; 
    echo '<input type="submit" class="btnSave" name="senden" value="Suchen">';
    echo '<input type="hidden" name="ansicht" value="'.$ansicht.'">
          </form>';  
          
  
        $query="
        SELECT lookup.ID
            , lookup.Name as Besonderheit 
            , lookup_type.Name as `Besonderheit Typ` 
            -- , lookup_type.type_key as LookupTypeKey         
            -- , lookup.LookupTypeID 
            -- , lookup_type.Relation  
            FROM lookup 
            LEFT JOIN lookup_type
              on lookup_type.ID = lookup.LookupTypeID
            WHERE 1=1 "; 

    if($Suchtext!='') {
      $query.="AND ( lookup.Name LIKE '%".$Suchtext."%' 
                            ) "; 
    }
    $query.=($LookupTypeID!=''?'AND LookupTypeID='.$LookupTypeID.' '.PHP_EOL:''); 

    $query.="ORDER by lookup.Name 
            "; 
    echo '<p><a href="edit_'.$table_edit.'.php?option=insert" target="_blank">Neu erfassen</a></p>';
    break;     
  case 'schueler':  
    include_once("classes/class.status.php");

    $StatusID=(isset($_REQUEST["StatusID"])?$_REQUEST["StatusID"]:'');
    $Status_Umkehr=(isset($_REQUEST["Status_Umkehr"])?true:false);    
    $Datum=(isset($_REQUEST["Datum"])?$_REQUEST["Datum"]:'');
    $Unterricht_Wochentag =(isset($_REQUEST["wochentag_nr"])?$_REQUEST["wochentag_nr"]:0);

    $Aktiv=1; 
    if(isset($_REQUEST["Filter"])) {
      $Aktiv=(isset($_REQUEST["Aktiv"])?1:0); 
    }

    echo '<form action="" method="get">'.PHP_EOL;  
    echo '<label><input type="checkbox" name="Aktiv" onchange="this.form.submit()" '.($Aktiv==1?'checked':'').'>Aktiv</label>'; 
    echo ' &#9475;';

    $status = new Status(); 
    echo 'Status Satz Verknüpfung: '.PHP_EOL; 
    $status->print_preselect($StatusID); 

    echo '<label><input type="checkbox" name="Status_Umkehr" onchange="this.form.submit()" '.($Status_Umkehr?'checked':'').'>Umkehrsuche</label>'; 
    echo ' &#9475;'; 
    echo 'Datum: <input type="date" name="Datum" value="'.$Datum.'" onchange="this.form.submit()">'; 
    echo ' &#9475; Unterricht Wochentag: '; 
    $wochentage = new Wochentage(); 
    $wochentage->print_preselect($Unterricht_Wochentag); 
        
    echo '<input type="hidden" name="ansicht" value="'.$ansicht.'">'; 
    echo '<input type="hidden" name="Filter" value="gesetzt">'; // Nur beim Erstaufruf der Seite nicht gesetzt 
    echo '</form>';           

    $sqlpart = new SQLPart(); 

    $query="SELECT schueler.ID 
          , schueler.Name
          , schueler.Bemerkung       
          , v_schueler_instrumente.Instrumente
          , IF(schueler.Unterricht_Wochentag=0, '', wochentage.wochentag_name) as   `Unterricht Wochentag` 
          , IF(schueler.Unterricht_Reihenfolge=0, '', schueler.Unterricht_Reihenfolge) as `Unterricht Tag Reihenfolge` 
          , IF(schueler.Unterricht_Dauer=0, '', schueler.Unterricht_Dauer) as `Unterricht Dauer` 
          , schueler.Unterricht_Seit  as `Datum Unterricht Seit`  
          , TIMESTAMPDIFF(YEAR, schueler.Unterricht_Seit, CURDATE()) as `Unterricht seit Jahre`           
          , schueler.Geburtsdatum 
          , TIMESTAMPDIFF(YEAR, schueler.Geburtsdatum, CURDATE()) as `Alter` 
          , v_schueler_lookuptypes.LookupList as Besonderheiten 
          "         
          ; 
    if ($StatusID!='') {
        $query.=', '.$sqlpart->getSQL_COL_CONCAT_Noten(200); 
    }
    $query.=", IF(COUNT(distinct uebung.Datum) > 0, COUNT(distinct uebung.Datum), NULL) as `Übung Anzahl Tage`  
          , MAX(uebung.Datum) as `Datum letzte Übung`           
          "; 
                   


    $query.="
        FROM schueler 
          LEFT JOIN  v_schueler_instrumente ON v_schueler_instrumente.SchuelerID = schueler.ID 
          LEFT JOIN uebung ON schueler.ID = uebung.SchuelerID
          LEFT JOIN schueler_satz on  schueler_satz.SchuelerID= schueler.ID 
          LEFT JOIN wochentage ON wochentage.wochentag_nr = schueler.Unterricht_Wochentag 
          LEFT JOIN v_schueler_lookuptypes on v_schueler_lookuptypes.SchuelerID = schueler.ID  
      ";

    $query.="

          LEFT JOIN status on schueler_satz.StatusID= status.ID             
          LEFT join satz on satz.ID = schueler_satz.SatzID 
          LEFT join musikstueck on musikstueck.ID = satz.MusikstueckID 
          LEFT JOIN sammlung on sammlung.ID = musikstueck.SammlungID 
          
      WHERE 1=1 
      ";

      // if ($Status_Umkehr) {
      //   $query.=($StatusID!=''?'AND schueler.ID NOT IN (SELECT SchuelerID FROM schueler_satz WHERE StatusID='.$StatusID.')  '.PHP_EOL:' ');
      // } else {
      //   $query.=($StatusID!=''?'AND schueler.ID IN (SELECT SchuelerID FROM schueler_satz WHERE StatusID='.$StatusID.')  '.PHP_EOL:' ');
      // }
    
    $query.=($Aktiv==1?"AND schueler.Aktiv=1 ".PHP_EOL:"AND schueler.Aktiv=0 "); 

    if ($Status_Umkehr) {
      $query.=($StatusID!=''?'AND schueler_satz.StatusID!='.$StatusID.' '.PHP_EOL:' ');
    } else {
      $query.=($StatusID!=''?'AND schueler_satz.StatusID='.$StatusID.' '.PHP_EOL:' ');      
    }

    if ($Unterricht_Wochentag > 0 ) {
      $query.="AND schueler.Unterricht_Wochentag=".$Unterricht_Wochentag." ";  
    }

    if (!empty($Datum)) {
      $query.="AND uebung.Datum='".$Datum."' ";  
    }

    $query.="GROUP By schueler.ID 
             ORDER BY schueler.Unterricht_Wochentag, schueler.Unterricht_Reihenfolge 
            "; 

    break; 


  case 'uebungen': 
    include_once("classes/class.uebungtyp.php");
    include_once("classes/class.bewertung.php");

    $Datum=(isset($_REQUEST["Datum"])?$_REQUEST["Datum"]:date('Y-m-d')); 

    $SchuelerID=(isset($_REQUEST["SchuelerID"])?$_REQUEST["SchuelerID"]:'');    
    $UebungtypID=(isset($_REQUEST["UebungtypID"])?$_REQUEST["UebungtypID"]:'');    
    $BewertungID=(isset($_REQUEST["BewertungID"])?$_REQUEST["BewertungID"]:'');    
    $Unterricht_Geplant=(isset($_REQUEST["Unterricht_Geplant"])?$_REQUEST["Unterricht_Geplant"]:'');  
    $Suchtext=(isset($_REQUEST["Suchtext"])?$_REQUEST["Suchtext"]:'');   

    echo '<form action="" method="get">'.PHP_EOL;       
    echo '<a href="edit_kalender.php?Datum='.$Datum.'&option=edit" target="_blank" title="Datum bearbeiten">Datum</a>: <input type="date" name="Datum" value="'.$Datum.'" onchange="this.form.submit()">'; 

    $schueler = new Schueler(); 
        echo ' &#9475;';    
    echo ' Schüler: '.PHP_EOL; 
    // $schueler->print_select($SchuelerID,'','',true); 
    $schueler->print_preselect($SchuelerID); 

    $uebung_typ = new UebungTyp(); 
        echo ' &#9475;';    
    echo ' Übungtyp: '.PHP_EOL; 
    $uebung_typ->print_preselect($UebungtypID); 

    $bewertung = new Bewertung(); 
        echo ' &#9475;';    
    echo ' Bewertung: '.PHP_EOL; 
    $bewertung->print_preselect($BewertungID); 

    echo ' Suchtext: <input type="text" id="Suchtext" name="Suchtext" size="30px" value="'.$Suchtext.'"> '; 

    echo '<input type="submit" class="btnSave" name="senden" value="Suchen">';
    echo '<input type="hidden" name="ansicht" value="'.$ansicht.'">'; 
    echo '</form>';           

    $sqlpart = new SQLPart(); 

    $query="SELECT  schueler.Name as Schueler
                  , uebung.Datum as `Datum`                   
                  , schueler.Unterricht_Reihenfolge as `Schüler Reihen-folge`
                  , uebung.Reihenfolge as `Übung Reihen-folge`
                  , uebung.Name as `Uebung Inhalt`  
                  "; 

    $query.=", ".$sqlpart->getSQL_COL_CONCAT_Noten(300); 
    $query.=", v_uebung_lookuptypes.LookupList2 as Besonderheiten   
                  , uebung.Bemerkung  as `Übung Bemerkung`   
                  , CONCAT(uebung.Anzahl, ' ', uebungtyp.Einheit) Dauer   
                  , uebungtyp.Name as `Uebung Typ` 
                  , bewertung.Name as Bewertung                
                  , uebung.ID
                "; 

    $query.="FROM uebung 
                  INNER join schueler on schueler.ID=uebung.SchuelerID
                                and schueler.Aktiv=1
                  left join uebungtyp on uebung.UebungtypID=uebungtyp.ID 
                  left join bewertung on bewertung.ID = uebung.BewertungID 
                  left join satz  on satz.ID=uebung.SatzID 
                  left join musikstueck on satz.MusikstueckID = musikstueck.ID
                  left JOIN sammlung on sammlung.ID = musikstueck.SammlungID
                  left join v_uebung_lookuptypes on v_uebung_lookuptypes.UebungID=uebung.ID
                  LEFT JOIN kalender ON uebung.Datum = kalender.Datum  "; 

    $query.="      WHERE 1=1 "; 


    if ($Unterricht_Geplant!='') {
      $query.="AND kalender.Unterricht_Geplant=".$Unterricht_Geplant." ".PHP_EOL;  
    }            

    if (!empty($Datum)) {
      $query.="AND uebung.Datum='".$Datum."' ".PHP_EOL;  
    }
    if ($SchuelerID!='') {
      $query.="AND uebung.SchuelerID=".$SchuelerID." ";  
    }
    if ($UebungtypID!='') {
      $query.="AND uebung.UebungtypID=".$UebungtypID." ";  
    }
    if ($BewertungID!='') {
      $query.="AND uebung.BewertungID=".$BewertungID." ";  
    }
    if($Suchtext!='') {
      $query.="AND ( uebung.Name LIKE '%".$Suchtext."%' 
                  OR uebung.Bemerkung LIKE '%".$Suchtext."%' 
                  OR uebungtyp.Name LIKE '%".$Suchtext."%' 
                  OR v_uebung_lookuptypes.LookupList LIKE '%".$Suchtext."%' 
                  OR satz.Name LIKE '%".$Suchtext."%' 
                  OR satz.Bemerkung LIKE '%".$Suchtext."%' 
                  OR musikstueck.Name LIKE '%".$Suchtext."%' 
                  OR musikstueck.Bemerkung LIKE '%".$Suchtext."%' 
                  OR sammlung.Name LIKE '%".$Suchtext."%' 
                  OR sammlung.Bemerkung LIKE '%".$Suchtext."%' 
                            ) "; 

    }    

    $query.="ORDER BY uebung.Datum DESC, schueler.Unterricht_Reihenfolge, uebung.Reihenfolge, uebung.Name "; 

    echo '<p><a href="edit_'.$table_edit.'.php?option=insert&SchuelerID='.$SchuelerID.'&Datum='.$Datum.'" target="_blank">Neu erfassen</a></p>';

    break; 


  case 'uebungstage': // aka "Übungstage" ************************************
    include_once("classes/class.schuljahr.php");

    $table_edit='schueler_kalender'; 
    $add_link_edit=true; 
 
    $Datum=(isset($_REQUEST["Datum"])?$_REQUEST["Datum"]:date('Y-m-d')); 
    $SchuelerID=(isset($_REQUEST["SchuelerID"])?$_REQUEST["SchuelerID"]:'');    
    $Unterricht_Wochentag =(isset($_REQUEST["wochentag_nr"])?$_REQUEST["wochentag_nr"]:0);
    $Unterricht_Geplant=(isset($_REQUEST["Unterricht_Geplant"])?$_REQUEST["Unterricht_Geplant"]:''); 
    $Unterricht_Protokolliert=(isset($_REQUEST["Unterricht_Protokolliert"])?$_REQUEST["Unterricht_Protokolliert"]:''); 
    $Suchtext=(isset($_REQUEST["Suchtext"])?$_REQUEST["Suchtext"]:'');   

    $SchuljahrID=(isset($_REQUEST["SchuljahrID"])?$_REQUEST["SchuljahrID"]:'');

    if(!isset($_REQUEST["SchuljahrID"])) {
      $schuljahr= new Schuljahr(); 
      $SchuljahrID= $schuljahr->getCurrentID(); 
    }

    echo '<form action="" method="get">'.PHP_EOL;       
    echo '<a href="edit_kalender.php?Datum='.$Datum.'&option=edit" target="_blank" title="Datum bearbeiten">Datum</a>: <input type="date" name="Datum" value="'.$Datum.'" onchange="this.form.submit()">'; 

    $schueler = new Schueler(); 
        echo ' &#9475;';    
    echo ' Schüler: '.PHP_EOL; 
    $schueler->print_preselect($SchuelerID); 

    $schuljahr = new Schuljahr(); 
        echo ' &#9475;';        
    echo 'Schuljahr: '.PHP_EOL; 
    $schuljahr->print_preselect($SchuljahrID, '', true); 

    echo ' &#9475;';
    echo ' Geplant <select id="Unterricht_Geplant" name="Unterricht_Geplant" onchange="this.form.submit()" >
              <option value="" '.($Unterricht_Geplant==''?'selected':'').'></option>
              <option value="0" '.($Unterricht_Geplant=='0'?'selected':'').'>Nein</option>
              <option value="1" '.($Unterricht_Geplant=='1'?'selected':'').'>Ja</option>
          </select> '; 

    echo ' &#9475;';
    echo ' Protokolliert <select id="Unterricht_Protokolliert" name="Unterricht_Protokolliert" onchange="this.form.submit()" >
              <option value="" '.($Unterricht_Protokolliert==''?'selected':'').'></option>
              <option value="0" '.($Unterricht_Protokolliert=='0'?'selected':'').'>Nein</option>
              <option value="1" '.($Unterricht_Protokolliert=='1'?'selected':'').'>Ja</option>
          </select> '; 

    echo ' &#9475;';            
    echo ' Suchtext: <input type="text" id="Suchtext" name="Suchtext" size="30px" value="'.$Suchtext.'"> '; 

    echo '<input type="submit" class="btnSave" name="senden" value="Suchen">';
    echo '<input type="hidden" name="ansicht" value="'.$ansicht.'">'; 
    echo '</form>';           

    $query="
      SELECT schueler.Name AS `Schüler Name`
          , schueler.Bemerkung `Schueler Bemerkung` 
          , schueler_kalender.Datum     
          , kalender.Wochentag_Name `Kalender Wochentag`  
          , schueler_kalender.Bemerkung `Übungstag Bemerkung`                  
          , schueler.Unterricht_Reihenfolge as `Unterricht Reihenfolge` 
          , COUNT(distinct uebung.ID) as `Anzahl Übungen` 
          , SUM(uebung.Anzahl ) as `Summe Minuten` 
          , (SUM(uebung.Anzahl ) - schueler.Unterricht_Dauer ) as `Abweichung Dauer` 
          , GROUP_CONCAT(DISTINCT uebung.Reihenfolge, '. ', uebung.Name, ' (', coalesce(uebungtyp.Name, ''), ')'  order by uebung.Reihenfolge separator '<br>') `Übungen Inhalte`  
          , IF(kalender.Unterricht_Geplant=1, 'X' , '') as `Unterricht geplant`   
          , IF(kalender.Unterricht_Protokolliert=1, 'X' , '') as `Unterricht protokolliert`   
          , ferien.Bezeichnung AS Ferientag 
          , feiertag.Bezeichnung AS Feiertag 
          , schuljahr.Bezeichnung AS Schuljahr
          , schueler_kalender.ID              
    FROM  schueler_kalender 
          INNER JOIN schueler 
              ON schueler.ID= schueler_kalender.SchuelerID 
          INNER JOIN 
              kalender ON schueler_kalender.Datum = kalender.Datum         
          INNER JOIN schuljahr 
            ON kalender.Datum  BETWEEN schuljahr.Datum_Start AND schuljahr.Datum_Ende 
          LEFT JOIN ferien 
            ON kalender.Datum BETWEEN ferien.Datum_Start AND ferien.Datum_Ende 
            -- ON schuljahr.ID = ferien.SchuljahrID 
          LEFT JOIN feiertag 
            ON kalender.Datum = feiertag.Datum             
            -- ON schuljahr.ID = feiertag.SchuljahrID             
          LEFT JOIN uebung 
              ON schueler.ID = uebung.SchuelerID 
              AND schueler_kalender.Datum = uebung.Datum 
            -- LEFT JOIN wochentage ON wochentage.wochentag_nr = schueler.Unterricht_Wochentag                   
          LEFT join uebungtyp 
              ON uebung.UebungtypID=uebungtyp.ID 
            WHERE schueler.Aktiv=1 
        "; 
 
    if ($Unterricht_Geplant!='') {
      $query.="AND kalender.Unterricht_Geplant=".$Unterricht_Geplant." ".PHP_EOL;  
    }       
    if ($Unterricht_Protokolliert!='') {
      $query.="AND kalender.Unterricht_Protokolliert=".$Unterricht_Protokolliert." ".PHP_EOL;  
    }       

    if (!empty($Datum)) {
      $query.="AND schueler_kalender.Datum='".$Datum."' ".PHP_EOL;  
    }
     if ($SchuelerID!='') {
      $query.="AND schueler.ID=".$SchuelerID." ".PHP_EOL;  
    }
     if ($SchuljahrID!='') {
      $query.="AND schuljahr.ID=".$SchuljahrID." ".PHP_EOL;  
    }

    // if ($Unterricht_Wochentag > 0 ) {
    //   $query.="AND schueler.Unterricht_Wochentag=".$Unterricht_Wochentag." ".PHP_EOL;  
    // }

    if($Suchtext!='') {
      $query.="AND ( schueler.Bemerkung LIKE '%".$Suchtext."%' 
                  OR schueler_kalender.Bemerkung LIKE '%".$Suchtext."%' 
                  ) "; 
    }     

    $query.="
        GROUP BY schueler.ID, schueler_kalender.Datum  
        ORDER BY schueler_kalender.Datum DESC, schueler.Unterricht_Reihenfolge, uebung.Name                     
             "; 
    echo '<p><a href="edit_'.$table_edit.'.php?option=insert&SchuelerID='.$SchuelerID.'" target="_blank">Neu erfassen</a></p>';

    break;   

/***************** Stammdaten ****************************** */  
  case 'bewertungen': 

    $table_edit='bewertung';     

    $Suchtext=(isset($_REQUEST["Suchtext"])?$_REQUEST["Suchtext"]:'');   

    echo '<form action="" method="get">'.PHP_EOL;  
    echo ' Suchtext: <input type="text" id="Suchtext" name="Suchtext" size="30px" value="'.$Suchtext.'"> '; 
    echo '<input type="submit" class="btnSave" name="senden" value="Suchen">';
    echo '<input type="hidden" name="ansicht" value="'.$ansicht.'">'; 
    echo '</form>';       

    $query="SELECT ID, Name 
            FROM bewertung   
            WHERE 1=1 
            "; 

    if($Suchtext!='') {
      $query.="AND bewertung.Name LIKE '%".$Suchtext."%'  ";          
    }

    $query.="ORDER BY bewertung.Name "; 


    echo '<p><a href="edit_'.$table_edit.'.php?option=insert" target="_blank">Neu erfassen</a></p>';
        

    break;         

  case 'verwendungszwecke': // ************************************

    $Suchtext=(isset($_REQUEST["Suchtext"])?$_REQUEST["Suchtext"]:'');   

    $BerechnungAnzeigen=(isset($_REQUEST["BerechnungAnzeigen"])?true:false);    

    echo '<form action="" method="get">'.PHP_EOL;  

    echo '<label><input type="checkbox" name="BerechnungAnzeigen" onchange="this.form.submit()" '.($BerechnungAnzeigen?'checked':'').'>Berechnungen anzeigen</label> | ' ; 
    
    echo ' Suchtext: <input type="text" id="Suchtext" name="Suchtext" size="30px" value="'.$Suchtext.'"> '; 
    echo '<input type="submit" class="btnSave" name="senden" value="Suchen">';

    echo '<input type="hidden" name="ansicht" value="'.$ansicht.'">'; 
    echo '</form>';       

    if(!$BerechnungAnzeigen) {
      $query="SELECT ID, Name FROM verwendungszweck WHERE 1=1 "; 
      if($Suchtext!='') {
        $query.="AND verwendungszweck.Name LIKE '%".$Suchtext."%'  ";          
      }

    } else {
      $query="SELECT verwendungszweck.ID
                          , verwendungszweck.Name    
                          , COUNT(DISTINCT musikstueck.SammlungID) as   `Anzahl Sammlungen`
                          , COUNT(DISTINCT musikstueck.ID) as   `Anzahl Musikstücke` 
                          , COUNT(DISTINCT satz.ID) as   `Anzahl Sätze` 
                          , SEC_TO_TIME(SUM(satz.Spieldauer)) as `Summe Spieldauer`
              FROM musikstueck inner join satz on satz.MusikstueckID = musikstueck.ID 
              INNER JOIN musikstueck_verwendungszweck on musikstueck.ID = musikstueck_verwendungszweck.MusikstueckID 
              INNER JOIN verwendungszweck on verwendungszweck.ID = musikstueck_verwendungszweck.VerwendungszweckID 
              WHERE 1=1 "; 
      if($Suchtext!='') {
        $query.="AND verwendungszweck.Name LIKE '%".$Suchtext."%'  ";          
      }

      $query.="GROUP BY verwendungszweck.ID "        ; 

    }
    $query.="ORDER BY verwendungszweck.Name "; 

    echo '<p><a href="edit_'.$table_edit.'.php?option=insert" target="_blank">Neu erfassen</a></p>';
    
    
    break; 

  case 'standorte': 

    $Suchtext=(isset($_REQUEST["Suchtext"])?$_REQUEST["Suchtext"]:'');   

    echo '<form action="" method="get">'.PHP_EOL;  
    echo ' Suchtext: <input type="text" id="Suchtext" name="Suchtext" size="30px" value="'.$Suchtext.'"> '; 
    echo '<input type="submit" class="btnSave" name="senden" value="Suchen">';
    echo '<input type="hidden" name="ansicht" value="'.$ansicht.'">'; 
    echo '</form>';       


    $query="SELECT ID, Name 
            FROM standort 
            WHERE 1=1 
            "; 

    if($Suchtext!='') {
      $query.="AND standort.Name LIKE '%".$Suchtext."%'  ";          
    }


    $query.="ORDER BY standort.Name "; 

    echo '<p><a href="edit_'.$table_edit.'.php?option=insert" target="_blank">Neu erfassen</a></p>';
    
    
    break; 

  case 'verlage': 
            
    $table_edit='verlag'; 

    $Suchtext=(isset($_REQUEST["Suchtext"])?$_REQUEST["Suchtext"]:'');   

    echo '<form action="" method="get">'.PHP_EOL;  
    echo ' Suchtext: <input type="text" id="Suchtext" name="Suchtext" size="30px" value="'.$Suchtext.'"> '; 
    echo '<input type="submit" class="btnSave" name="senden" value="Suchen">';
    echo '<input type="hidden" name="ansicht" value="'.$ansicht.'">'; 
    echo '</form>';       

    $query="SELECT ID, Name 
            FROM verlag  
            WHERE 1=1 
            "; 

    if($Suchtext!='') {
      $query.="AND verlag.Name LIKE '%".$Suchtext."%'  ";          
    }

    $query.="ORDER BY verlag.Name "; 


    echo '<p><a href="edit_'.$table_edit.'.php?option=insert" target="_blank">Neu erfassen</a></p>';

    break;   

  case 'komponisten':  
    $table_edit='komponist'; 

    $Suchtext=(isset($_REQUEST["Suchtext"])?$_REQUEST["Suchtext"]:'');   

    echo '<form action="" method="get">'.PHP_EOL;  
    echo ' Suchtext: <input type="text" id="Suchtext" name="Suchtext" size="30px" value="'.$Suchtext.'"> '; 
    echo '<input type="submit" class="btnSave" name="senden" value="Suchen">';
    echo '<input type="hidden" name="ansicht" value="'.$ansicht.'">'; 
    echo '</form>';       

    $query="SELECT
              Vorname
              , Nachname
              , Geburtsjahr
              , Sterbejahr
              , Bemerkung 
              , ID 
            FROM komponist   
            WHERE 1=1 
            "; 

    if($Suchtext!='') {
      $query.="
            AND ( komponist.Vorname LIKE '%".$Suchtext."%'  
            OR komponist.Nachname LIKE '%".$Suchtext."%' 
            OR komponist.Geburtsjahr LIKE '%".$Suchtext."%' 
            OR komponist.Sterbejahr LIKE '%".$Suchtext."%' 
            OR komponist.Bemerkung LIKE '%".$Suchtext."%' 

            )
      
      ";          
    }

    $query.="ORDER BY komponist.Nachname, komponist.Vorname "; 


    echo '<p><a href="edit_'.$table_edit.'.php?option=insert" target="_blank">Neu erfassen</a></p>';

    break;  

  case 'besetzungen': 

    $table_edit='besetzung'; 

    $Suchtext=(isset($_REQUEST["Suchtext"])?$_REQUEST["Suchtext"]:'');   

    echo '<form action="" method="get">'.PHP_EOL;  
    echo ' Suchtext: <input type="text" id="Suchtext" name="Suchtext" size="30px" value="'.$Suchtext.'"> '; 
    echo '<input type="submit" class="btnSave" name="senden" value="Suchen">';
    echo '<input type="hidden" name="ansicht" value="'.$ansicht.'">'; 
    echo '</form>';       

    $query="SELECT ID, Name 
            FROM besetzung   
            WHERE 1=1 
            "; 

    if($Suchtext!='') {
      $query.="AND besetzung.Name LIKE '%".$Suchtext."%'  ";          
    }

    $query.="ORDER BY besetzung.Name "; 


    echo '<p><a href="edit_'.$table_edit.'.php?option=insert" target="_blank">Neu erfassen</a></p>';


    break;  

  case 'gattungen':  

    $table_edit='gattung'; 

    $Suchtext=(isset($_REQUEST["Suchtext"])?$_REQUEST["Suchtext"]:'');   

    echo '<form action="" method="get">'.PHP_EOL;  
    echo ' Suchtext: <input type="text" id="Suchtext" name="Suchtext" size="30px" value="'.$Suchtext.'"> '; 
    echo '<input type="submit" class="btnSave" name="senden" value="Suchen">';
    echo '<input type="hidden" name="ansicht" value="'.$ansicht.'">'; 
    echo '</form>';       

    $query="SELECT ID, Name 
            FROM gattung    
            WHERE 1=1 
            "; 

    if($Suchtext!='') {
      $query.="AND gattung.Name LIKE '%".$Suchtext."%'  ";          
    }

    $query.="ORDER BY gattung.Name "; 


    echo '<p><a href="edit_'.$table_edit.'.php?option=insert" target="_blank">Neu erfassen</a></p>';

    break;  

  case 'epochen':  

    $table_edit='epoche'; 

    $Suchtext=(isset($_REQUEST["Suchtext"])?$_REQUEST["Suchtext"]:'');   

    echo '<form action="" method="get">'.PHP_EOL;  
    echo ' Suchtext: <input type="text" id="Suchtext" name="Suchtext" size="30px" value="'.$Suchtext.'"> '; 
    echo '<input type="submit" class="btnSave" name="senden" value="Suchen">';
    echo '<input type="hidden" name="ansicht" value="'.$ansicht.'">'; 
    echo '</form>';       

    $query="SELECT ID, Name 
            FROM epoche     
            WHERE 1=1 
            "; 

    if($Suchtext!='') {
      $query.="AND epoche.Name LIKE '%".$Suchtext."%'  ";          
    }

    $query.="ORDER BY epoche.Name "; 


    echo '<p><a href="edit_'.$table_edit.'.php?option=insert" target="_blank">Neu erfassen</a></p>';

    break;  

  case 'materialtypen': 

    $table_edit='materialtyp'; 

    $Suchtext=(isset($_REQUEST["Suchtext"])?$_REQUEST["Suchtext"]:'');   

    echo '<form action="" method="get">'.PHP_EOL;  
    echo ' Suchtext: <input type="text" id="Suchtext" name="Suchtext" size="30px" value="'.$Suchtext.'"> '; 
    echo '<input type="submit" class="btnSave" name="senden" value="Suchen">';
    echo '<input type="hidden" name="ansicht" value="'.$ansicht.'">'; 
    echo '</form>';       

    $query="SELECT ID, Name 
            FROM materialtyp      
            WHERE 1=1 
            "; 

    if($Suchtext!='') {
      $query.="AND materialtyp.Name LIKE '%".$Suchtext."%'  ";          
    }

    $query.="ORDER BY materialtyp.Name "; 


    echo '<p><a href="edit_'.$table_edit.'.php?option=insert" target="_blank">Neu erfassen</a></p>';

    break;  


  case 'schwierigkeitsgrade': 

    $table_edit='schwierigkeitsgrad'; 

    $query="SELECT ID, Name 
            FROM schwierigkeitsgrad       
            WHERE 1=1 
            "; 
    $query.="ORDER BY schwierigkeitsgrad.Name "; 

    echo '<p><a href="edit_'.$table_edit.'.php?option=insert" target="_blank">Neu erfassen</a></p>';

    break;  

  case 'instrumente': 

    $table_edit='instrument'; 

    $query="SELECT ID, Name 
            FROM instrument       
            WHERE 1=1 
            "; 
    $query.="ORDER BY instrument.Name "; 

    echo '<p><a href="edit_'.$table_edit.'.php?option=insert" target="_blank">Neu erfassen</a></p>';

    break;  

  case 'erprobt': 

    $table_edit='erprobt'; 

    $query="SELECT ID, Name 
            FROM erprobt        
            WHERE 1=1 
            "; 
    $query.="ORDER BY erprobt.Name "; 

    echo '<p><a href="edit_'.$table_edit.'.php?option=insert" target="_blank">Neu erfassen</a></p>';

    break;      

  case 'status':  

    $table_edit='status'; 

    $query="SELECT ID, Name 
            FROM status         
            WHERE 1=1 
            "; 
    $query.="ORDER BY status.Name "; 

    echo '<p><a href="edit_'.$table_edit.'.php?option=insert" target="_blank">Neu erfassen</a></p>';

    break;  

  case 'uebungstypen': 

    $table_edit='uebungtyp'; 

    $query="SELECT ID, Name, Einheit  
            FROM uebungtyp         
            WHERE 1=1 
            "; 
    $query.="ORDER BY uebungtyp.Name "; 

    echo '<p><a href="edit_'.$table_edit.'.php?option=insert" target="_blank">Neu erfassen</a></p>';

    break;  


  case 'linktypen': 

    $table_edit='linktype'; 

    $query="SELECT ID, Name 
            FROM linktype          
            WHERE 1=1 
            "; 
    $query.="ORDER BY linktype.Name "; 

    echo '<p><a href="edit_'.$table_edit.'.php?option=insert" target="_blank">Neu erfassen</a></p>';

    break;  


  case 'abfragetypen': 

    $table_edit='abfragetyp'; 

    $query="SELECT ID, Name 
            FROM abfragetyp           
            WHERE 1=1 
            "; 
    $query.="ORDER BY abfragetyp.Name "; 

    echo '<p><a href="edit_'.$table_edit.'.php?option=insert" target="_blank">Neu erfassen</a></p>';

    break;  

  case 'abfragen':  

    include_once("classes/class.abfragetyp.php");

    $table_edit='abfrage'; 
    $add_link_edit=true; 
 
    $AbfragetypID=(isset($_REQUEST["AbfragetypID"])?$_REQUEST["AbfragetypID"]:'');     
    $Suchtext=(isset($_REQUEST["Suchtext"])?$_REQUEST["Suchtext"]:'');   

    echo '<form action="" method="get">'.PHP_EOL;       

    $abfragetyp = new Abfragetyp(); 
    echo 'Abfrage-Typ: '.PHP_EOL; 
    $abfragetyp->print_preselect($AbfragetypID); 


    echo ' &#9475;';            
    echo ' Suchtext: <input type="text" id="Suchtext" name="Suchtext" size="30px" value="'.$Suchtext.'"> '; 

    echo '<input type="submit" class="btnSave" name="senden" value="Suchen">';
    echo '<input type="hidden" name="ansicht" value="'.$ansicht.'">'; 
    echo '</form>';           

    $query="SELECT abfrage.ID
            , abfrage.Name
            , abfrage.Beschreibung
            , abfragetyp.Name as Abfragetyp
            -- , abfragetyp.ID as AbfragetypID
          FROM abfrage 
              LEFT JOIN 
              abfragetyp on abfrage.AbfragetypID = abfragetyp.ID 
          WHERE 1=1 ";  

    if ($AbfragetypID!='') {
      $query.="AND abfrage.AbfragetypID=".$AbfragetypID." ".PHP_EOL;  
    }
  

    if($Suchtext!='') {
      $query.="AND ( abfrage.Name LIKE '%".$Suchtext."%' 
                     OR abfrage.Beschreibung LIKE '%".$Suchtext."%' 
                    ) "; 
    }     

    $query.="ORDER BY abfrage.Name "; 

    echo '<p><a href="edit_'.$table_edit.'.php?option=insert" target="_blank">Neu erfassen</a></p>';

    break;  

  case 'lookuptypes': 
    include_once("classes/class.relation.php");    

    $table_edit='lookup_type';     

    $Suchtext=(isset($_REQUEST["Suchtext"])?$_REQUEST["Suchtext"]:'');   
    $RelationID=(isset($_REQUEST["RelationID"])?$_REQUEST["RelationID"]:'');    

    echo '<form action="" method="get">'.PHP_EOL;  
    echo ' Suchtext: <input type="text" id="Suchtext" name="Suchtext" size="30px" value="'.$Suchtext.'"> '; 

    echo ' Relation: ';
    $relation = new Relation(); 
    $relation->print_preselect($RelationID); 

    echo ' <input type="submit" class="btnSave" name="senden" value="Suchen">';
    echo '<input type="hidden" name="ansicht" value="'.$ansicht.'">'; 
    echo '</form>';       


    $query="SELECT lookup_type.ID
              , lookup_type.Name
              , lookup_type.type_key 
              , GROUP_CONCAT(DISTINCT relation.Name ORDER BY relation.Name SEPARATOR ',') as Relationen 
          from lookup_type 
              LEFT JOIN lookuptype_relation 
                  on  lookuptype_relation.LookuptypeID = lookup_type.ID 
              LEFT JOIN 
                  relation on relation.ID = lookuptype_relation.RelationID 
          WHERE 1=1 
          "; 

    if ($RelationID!='') {
      $query.="AND lookup_type.ID IN (SELECT LookuptypeID FROM lookuptype_relation WHERE RelationID=".$RelationID.") ";  
    }

    if($Suchtext!='') {
      $query.="AND lookup_type.Name LIKE '%".$Suchtext."%'  ";          
    }

    $query.=" GROUP BY lookup_type.ID 
              ORDER BY lookup_type.type_key "; 


    echo '<p><a href="edit_'.$table_edit.'.php?option=insert" target="_blank">Neu erfassen</a></p>';
        

    break;         
  case 'schuljahre': 

    $add_link_edit=true; 
    $table_edit='schuljahr';   

    $query="
      SELECT 		
        schuljahr.ID
          , schuljahr.Bezeichnung 
          , schuljahr.Datum_Start as `Datum von`
          , schuljahr.Datum_Ende as `Datum bis`
          , GROUP_CONCAT(DISTINCT DATE_FORMAT(ferien.Datum_Start, '%d.%m.%Y'), ' - ', DATE_FORMAT(ferien.Datum_Ende, '%d.%m.%Y'),' ', ferien.Bezeichnung ORDER BY ferien.Datum_Start separator '<br>') AS Ferien 
           , GROUP_CONCAT(DISTINCT DATE_FORMAT(feiertag.Datum, '%d.%m.%Y'), ' ', feiertag.Bezeichnung ORDER BY feiertag.Datum separator '<br>') AS Feiertage  
        FROM schuljahr 
        LEFT JOIN ferien ON ferien.SchuljahrID=schuljahr.ID 
        LEFT JOIN feiertag ON feiertag.SchuljahrID=schuljahr.ID 
      WHERE 1=1
      GROUP BY schuljahr.ID 
      ORDER BY schuljahr.Datum_Start DESC 
    "; 

    echo '<p><a href="edit_'.$table_edit.'.php?option=insert" target="_blank">Neu erfassen</a></p>';


    break;     

  case 'kalender': /*********************************************** */
    include_once("classes/class.schuljahr.php");

    $SchuljahrID=(isset($_REQUEST["SchuljahrID"])?$_REQUEST["SchuljahrID"]:'');

    if($SchuljahrID=='') {
      $schuljahr= new Schuljahr(); 
      $SchuljahrID= $schuljahr->getCurrentID(); 
    }

    // $date_start=(isset($_REQUEST["date_start"])?$_REQUEST["date_start"]:''); 
    // $date_end=(isset($_REQUEST["date_end"])?$_REQUEST["date_end"]:'');   
    // $date_current = date('Y-m-d');  

    // if($date_start=='') {
    //   // $date_start=date($date_current,strtotime('-30 days'));
    //   $date_start=date('Y-m-d', strtotime($date_current. ' - 30 days'));  
    // }
    // if($date_end=='') {
    //   $date_end=date('Y-m-d', strtotime($date_current. ' + 30 days'));  
    // }

    echo '<form action="" method="get">'.PHP_EOL;  
    // echo 'Start: <input type="date" name="date_start" value="'.$date_start.'" onchange="this.form.submit()">'; 
    // echo ' Ende: <input type="date" name="date_end" value="'.$date_end.'" onchange="this.form.submit()">'; 
    $schuljahr = new Schuljahr();      
    echo 'Schuljahr: '.PHP_EOL; 
    $schuljahr->print_preselect($SchuljahrID, '', false); 

    // echo '<input type="submit" class="btnSave" name="senden" value="Start">';
    echo '<input type="hidden" name="ansicht" value="'.$ansicht.'">'; 
    echo '</form>';       

    $add_link_edit=true; 
    $table_edit='kalender'; 

    $query="SELECT kalender.ID
            , kalender.Datum
            , kalender.Wochentag_Name AS Wochentag 
            , kalender.Kalenderwoche 
            , COALESCE(ferien.Bezeichnung, '') AS Ferien 
            , COALESCE(feiertag.Bezeichnung, '') AS Feiertag 
            , COALESCE(schuljahr.Bezeichnung, '') AS Schuljahr      
            , IF(Unterricht_Geplant=1, 'X' , '') as `Unterricht geplant`    	  
            , IF(Unterricht_Protokolliert=1, 'X' , '') as `Unterricht protokolliert`    	  
        FROM kalender 
          INNER JOIN schuljahr 
            ON kalender.Datum  BETWEEN schuljahr.Datum_Start AND schuljahr.Datum_Ende 
          LEFT JOIN ferien 
            ON kalender.Datum BETWEEN ferien.Datum_Start AND ferien.Datum_Ende 
          LEFT JOIN feiertag 
            ON kalender.Datum = feiertag.Datum 
        WHERE 1=1" .PHP_EOL;     

      // if($date_start!='') {
      //   $query.="AND kalender.Datum >= '".$date_start."' "; 
      // }
      // if($date_start!='') {
      //   $query.="AND kalender.Datum <= '".$date_end."' "; 
      // }

    if ($SchuljahrID!='') {
      $query.="AND schuljahr.ID=".$SchuljahrID." ".PHP_EOL;  
    }

    $query.="ORDER BY kalender.Datum  "; 

    break; 

 
  
    case 'XXXX': 

    break; 

/***************** Infosichten ****************************** */
  case 'info-alle-spieldauern': // 

    $add_link_edit=false; 
    $table_edit='';   

    $query="
          select 
          --  NULL as ID
          distinct Spieldauer as `Spieldauer Sekunden` 
          , concat(
              case when length( Spieldauer DIV 60)=1 
              then concat('0', (Spieldauer DIV 60)) 
              else Spieldauer DIV 60
              end
              ,':'
              , 
              case when length( Spieldauer MOD 60)=1 
              then concat('0', (Spieldauer MOD 60)) 
              else Spieldauer MOD 60
              end 
              ) as Spieldauer_1

          , concat(
              Spieldauer DIV 60
              ,''''
              , 
              Spieldauer MOD 60
              , ''''''
              ) as Spieldauer_2

          from satz  
          where Spieldauer is not null 
          order by Spieldauer



          "; 

    break;    
  case 'info-alle-tempobezeichnungen': // 

    $add_link_edit=false; 
    $table_edit='';   

    $query="
      SELECT DISTINCT Tempobezeichnung 
      FROM satz  
      WHERE Tempobezeichnung is not null 
      AND Tempobezeichnung <> ''
      ORDER BY Tempobezeichnung



          "; 

    break;  

/***************** Standard-Tests ****************************** */    
  case 'test-sammlungen-ohne-musikstueck': // 

    // XXXX noch: filter Standort
    // XXXX noch: Suchfeld  

    $add_link_edit=true; 
    $table_edit='sammlung';   

    $query="select 
          standort.Name as Standort     
          , s.Name as Sammlung
          , s.ID
      from sammlung s 
      inner join standort on standort.ID= s.StandortID 
      left join musikstueck m on s.ID = m.SammlungID 
      where s.Erfasst=0
      and m.ID is null 
      order by standort.Name, s.Name
      "; 

    break;  

  case 'test-musikstuecke-ohne-satz': // 

    // XXXX noch: filter Standort
    // XXXX noch: Suchfeld  

    $add_link_edit=true; 
    $table_edit='musikstueck';   

    $query="select standort.Name as Standort 
            , s.Name as Sammlung
            , m.Nummer
            , m.Name as Musikstueck
            , m.ID
        from musikstueck m 
        inner join  sammlung s on s.ID = m.SammlungID 
        inner join standort on standort.ID= s.StandortID 
        left join satz sa on sa.MusikstueckID = m.ID 
        where s.Erfasst=0
        and sa.ID is null 
        -- and m.ID is not nULL 
        order by standort.Name, s.Name, m.Nummer 
          "; 

    break; 
  case 'test-musikstuecke-ohne-besetzung': // 

    // XXXX noch: filter Standort
    // XXXX noch: Suchfeld  

    $add_link_edit=true; 
    $table_edit='musikstueck';   

    $query="select
            standort.Name as Standort 
            , s.Name as Sammlung
            , m.Nummer 
            , m.Name as Musikstueck
            , m.ID    
        from sammlung s 
        inner join standort on standort.ID= s.StandortID 
        inner join musikstueck m on s.ID = m.SammlungID 
        left join musikstueck_besetzung mb 
        on m.ID = mb.MusikstueckID 
        where s.Erfasst=0 
        and mb.ID is null 
        order by standort.Name, s.Name, m.Nummer 
          "; 

    break;     

  case 'test-saetze-ohne-schwierigkeitsgrad': 

    // XXXX noch: filter Standort
    // XXXX noch: Suchfeld  

    $add_link_edit=true; 
    $table_edit='satz';   

    $query="
        select 
            standort.Name as Standort 
            , s.Name as Sammlung
            , m.Nummer as MNr
            , m.Name as Musikstueck
                , sa.Nr as SatzNr
                , sa.Name as Satz
              , sa.ID        
        from musikstueck m 
            inner join  sammlung s on s.ID = m.SammlungID 
            inner join standort on standort.ID= s.StandortID     
            inner join satz sa on sa.MusikstueckID = m.ID 
            left join satz_schwierigkeitsgrad on satz_schwierigkeitsgrad.SatzID = sa.ID 
        where s.Erfasst=0
        and satz_schwierigkeitsgrad.ID is NULL
        order by standort.Name, s.Name, m.Nummer, sa.Nr

          "; 

    break;        




}

if($query=='') {
  $info->print_user_error('Es wurde keine Ansicht definiert.');   
  goto pagefoot;
}


/******************************* */
// echo '<pre>'.$query.'</pre>'; // Test 

// echo '<pre style="font-size: 11px; display: none">'.$query .'</pre>'; // Test  
    
$conn = new DBConnection(); 
$db=$conn->db; 

$select = $db->prepare($query); 
  
try {
  $select->execute(); 
  include_once("classes/class.htmltable.php");      
  $html = new HTML_Table($select); 
  $html->add_link_edit= $add_link_edit; 
  $html->edit_link_table=$table_edit; 
  $html->edit_link_open_newpage = true; 
  $html->add_link_show=$add_link_show;   
  $html->show_row_count=true; 
  $html->print_table2(); 
}
catch (PDOException $e) {
  $info = new HTML_Info();      
  $info->print_user_error(); 
  $info->print_error($select, $e); 
}

pagefoot: 

include_once('foot.php');
?>
