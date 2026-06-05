<?php
include_once('classes/class.htmlinfo.php');
include_once('classes/class.sqlpart.php');
include_once("classes/dbconn/class.db.php");
include_once("classes/class.schueler.php");
include_once("classes/class.uebungtyp.php");
include_once("classes/class.wochentage.php");

$info=new HTML_Info(); 

$query=''; 
$show_data=false; 
$ansicht=''; 
$PageTitle=''; 
$fehlertext=''; 

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
  case 'schueler'; 
    $PageTitle='Übersicht Schüler';  
    $table_edit='schueler';     
    break; 
  case 'uebungen'; 
    $PageTitle='Übersicht Übungen ';  
    $table_edit='uebung';     
    break; 
  case 'uebungen-datum2'; // aka "Übungstage / alt: Übungen / Datum 
    $PageTitle='Übersicht Übungstage';  
    // $table_edit='';     
    break;     
  case 'verwendungszwecke'; 
    $PageTitle='Übersicht Verwendungszwecke';  
    $table_edit='verwendungszweck';     
    break; 
  case 'standorte'; 
    $PageTitle='Übersicht Standorte';  
    $table_edit='standort';     
    break; 
  case 'verlage'; 
    $PageTitle='Übersicht Verlage';  
    $table_edit='verlag';     
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
    $PageTitle='Vorlage Schüler-Kalender (Abfrage) - BETA: Schuljahr 2025/2026';   
    break; 


}

include_once('head.php'); 

if ($ansicht=='' OR $query='') {
  $info->print_user_error('Es wurde keine Ansicht definiert.'); 
  goto pagefoot;
}

echo '<h3 class="header-with-help-link">'.$PageTitle.'</h3>'.PHP_EOL; 
echo '<a href="help_uebersichten.php?#uebersichten_'.$ansicht.'" target="_blank">Hilfe</a>';

echo '<p></p>'; 
// XXXX Filter einschränken ermöglichen (es sollen nicht automatisch alle Zeilen einer Tabelle auf einmal angezeigt werden)

switch ($ansicht)  // setzen: $PageTitle, $table_edit 
{
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
 
    $Datum=(isset($_REQUEST["Datum"])?$_REQUEST["Datum"]:date('Y-m-d')); 

    $SchuelerID=(isset($_REQUEST["SchuelerID"])?$_REQUEST["SchuelerID"]:'');    
    $UebungtypID=(isset($_REQUEST["UebungtypID"])?$_REQUEST["UebungtypID"]:'');    
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
    $uebung_typ->print_select($UebungtypID); 
        echo ' &#9475;';

    echo ' Suchtext: <input type="text" id="Suchtext" name="Suchtext" size="30px" value="'.$Suchtext.'"> '; 
    echo ' &#9475;';
    echo ' Geplant <select id="Unterricht_Geplant" name="Unterricht_Geplant" onchange="this.form.submit()" >
              <option value="" '.($Unterricht_Geplant==''?'selected':'').'></option>
              <option value="0" '.($Unterricht_Geplant=='0'?'selected':'').'>Nein</option>
              <option value="1" '.($Unterricht_Geplant=='1'?'selected':'').'>Ja</option>
          </select> '; 

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
                  , IF(kalender.Unterricht_Geplant=1, 'X' , '') as `Unterrichtstag Geplant`                   
                  , uebung.ID
                "; 

    $query.="FROM uebung 
                  INNER join schueler on schueler.ID=uebung.SchuelerID
                                and schueler.Aktiv=1
                  left join uebungtyp on uebung.UebungtypID=uebungtyp.ID 
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

  
 
  case 'uebungen-datum': // ALT XXXX löschen 

    $add_link_edit=false; 
 
    $Datum=(isset($_REQUEST["Datum"])?$_REQUEST["Datum"]:date('Y-m-d')); 
    $SchuelerID=(isset($_REQUEST["SchuelerID"])?$_REQUEST["SchuelerID"]:'');    
    $Unterricht_Wochentag =(isset($_REQUEST["wochentag_nr"])?$_REQUEST["wochentag_nr"]:0);
    $Unterricht_Geplant=(isset($_REQUEST["Unterricht_Geplant"])?$_REQUEST["Unterricht_Geplant"]:''); 
    $Suchtext=(isset($_REQUEST["Suchtext"])?$_REQUEST["Suchtext"]:'');   

    echo '<form action="" method="get">'.PHP_EOL;       
    echo '<a href="edit_kalender.php?Datum='.$Datum.'&option=edit" target="_blank" title="Datum bearbeiten">Datum</a>: <input type="date" name="Datum" value="'.$Datum.'" onchange="this.form.submit()">'; 

    $schueler = new Schueler(); 
        echo ' &#9475;';    
    echo ' Schüler: '.PHP_EOL; 
    $schueler->print_select($SchuelerID,'','',true); 

    echo ' &#9475; Unterricht Wochentag: '; 
    $wochentage = new Wochentage(); 
    $wochentage->print_preselect($Unterricht_Wochentag);     


    echo ' &#9475;';
    echo ' Geplant <select id="Unterricht_Geplant" name="Unterricht_Geplant" onchange="this.form.submit()" >
              <option value="" '.($Unterricht_Geplant==''?'selected':'').'></option>
              <option value="0" '.($Unterricht_Geplant=='0'?'selected':'').'>Nein</option>
              <option value="1" '.($Unterricht_Geplant=='1'?'selected':'').'>Ja</option>
          </select> '; 

    echo '<input type="submit" class="btnSave" name="senden" value="Suchen">';
    echo '<input type="hidden" name="ansicht" value="'.$ansicht.'">'; 
    echo '</form>';           

    $query="
              SELECT schueler.Name
                  , schueler.Bemerkung 
                  , IF(schueler.Unterricht_Wochentag=0, '', wochentage.wochentag_name) as   `Unterricht Wochentag`     
                  , uebung.Datum 
                  , schueler.Unterricht_Reihenfolge as `Unterricht Reihenfolge` 
                  , COUNT(distinct uebung.ID) as `Anzahl Übungen` 
                  , SUM(uebung.Anzahl ) as `Summe Minuten` 
                  , (SUM(uebung.Anzahl ) - schueler.Unterricht_Dauer ) as `Abweichung Dauer` 
                  -- , GROUP_CONCAT(uebung.Name, ' (', coalesce(uebungtyp.Name, '') , ')'  order by uebung.Name separator '<br>') Inhalte 
                  , GROUP_CONCAT(uebung.Reihenfolge, '. ', uebung.Name, ' (', coalesce(uebungtyp.Name, ''), ')'  order by uebung.Reihenfolge separator '<br>') `Übungen Inhalte`  
                  , IF(kalender.Unterricht_Geplant=1, 'X' , '') as `Unterrichtstag Geplant`                   
            FROM  uebung 
                  LEFT JOIN schueler ON schueler.ID = uebung.SchuelerID 
                  LEFT JOIN wochentage ON wochentage.wochentag_nr = schueler.Unterricht_Wochentag                   
                  left join uebungtyp on uebung.UebungtypID=uebungtyp.ID 
                  left join satz  on satz.ID=uebung.SatzID 
                  left join musikstueck on satz.MusikstueckID = musikstueck.ID
                  left JOIN sammlung on sammlung.ID = musikstueck.SammlungID  
                  left JOIN v_uebung_lookuptypes on v_uebung_lookuptypes.UebungID = uebung.ID 
                  LEFT JOIN kalender ON uebung.Datum = kalender.Datum  
            WHERE 1=1 
                           
        "; 
 
    if ($Unterricht_Geplant!='') {
      $query.="AND kalender.Unterricht_Geplant=".$Unterricht_Geplant." ".PHP_EOL;  
    }       

    if (!empty($Datum)) {
      $query.="AND uebung.Datum='".$Datum."' ";  
    }
     if ($SchuelerID!='') {
      $query.="AND uebung.SchuelerID=".$SchuelerID." ";  
    }

    if ($Unterricht_Wochentag > 0 ) {
      $query.="AND schueler.Unterricht_Wochentag=".$Unterricht_Wochentag." ";  
    }
    

    $query.="GROUP BY uebung.SchuelerID, uebung.Datum  
             ORDER BY uebung.Datum DESC, schueler.Unterricht_Reihenfolge, uebung.Name  "; 

    break;     

  case 'uebungen-datum2': // aka "Übungstage" ************************************
    include_once("classes/class.schuljahr.php");
    include_once("classes/class.schuljahre.php");    

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

    // if($SchuljahrID=='') {
    //   $schuljahr= new Schuljahr(); 
    //   $SchuljahrID= $schuljahr->getCurrentID(); 
    // }



    echo '<form action="" method="get">'.PHP_EOL;       
    echo '<a href="edit_kalender.php?Datum='.$Datum.'&option=edit" target="_blank" title="Datum bearbeiten">Datum</a>: <input type="date" name="Datum" value="'.$Datum.'" onchange="this.form.submit()">'; 

    $schueler = new Schueler(); 
        echo ' &#9475;';    
    echo ' Schüler: '.PHP_EOL; 
    $schueler->print_preselect($SchuelerID); 

    $schuljahre = new Schuljahre(); 
        echo ' &#9475;';        
    echo 'Schuljahr: '.PHP_EOL; 
    $schuljahre->print_preselect($SchuljahrID, '', true); 

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
          , GROUP_CONCAT(uebung.Reihenfolge, '. ', uebung.Name, ' (', coalesce(uebungtyp.Name, ''), ')'  order by uebung.Reihenfolge separator '<br>') `Übungen Inhalte`  
          , IF(kalender.Unterricht_Geplant=1, 'X' , '') as `Unterricht geplant`   
          , IF(kalender.Unterricht_Protokolliert=1, 'X' , '') as `Unterricht protokolliert`   
          , ferien.Bezeichnung AS Ferientag 
          , feiertag.Bezeichnung AS Feiertag 
          , schuljahr.Bezeichnung AS Schuljahr
          , schueler_kalender.ID              
    FROM  schueler_kalender
        INNER JOIN schueler 
            ON schueler.ID= schueler_kalender.SchuelerID 
        LEFT JOIN 
            kalender 
                ON schueler_kalender.Datum = kalender.Datum         
        LEFT JOIN schuljahr 
          ON kalender.Datum  BETWEEN schuljahr.Datum_Start AND schuljahr.Datum_Ende 
        LEFT JOIN ferien 
          ON kalender.Datum BETWEEN ferien.Datum_Start AND ferien.Datum_Ende 
        LEFT JOIN feiertag 
          ON kalender.Datum = feiertag.Datum             
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

    $query.="
        GROUP BY schueler.ID, schueler_kalender.Datum  
        ORDER BY schueler_kalender.Datum DESC, schueler.Unterricht_Reihenfolge, uebung.Name                     
             "; 
    echo '<p><a href="edit_'.$table_edit.'.php?option=insert&SchuelerID='.$SchuelerID.'" target="_blank">Neu erfassen</a></p>';

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
  case 'schuljahre': 

    $add_link_edit=false; 
    $table_edit='schuljahr';   

    $query="SELECT ID, 
                    Bezeichnung, 
                    Datum_Start as `Datum von`, 
                    Datum_Ende as `Datum bis`
            FROM schuljahr  
            WHERE 1=1 
            "; 

    $query.="ORDER BY schuljahr.Datum_Start "; 

    break;     

  case 'kalender': /*********************************************** */
    include_once("classes/class.schuljahr.php");
    include_once("classes/class.schuljahre.php");    

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
    $schuljahre = new Schuljahre();      
    echo 'Schuljahr: '.PHP_EOL; 
    $schuljahre->print_preselect($SchuljahrID, '', false); 

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

  case 'ferien': 
    include_once("classes/class.schuljahr.php");
    include_once("classes/class.schuljahre.php");

    $add_link_edit=false; 
    $table_edit='ferien';      

    $SchuljahrID=(isset($_REQUEST["SchuljahrID"])?$_REQUEST["SchuljahrID"]:'');

    if($SchuljahrID=='') {
      $schuljahr= new Schuljahr(); 
      $SchuljahrID= $schuljahr->getCurrentID(); 
    }

    echo '<form action="" method="get">'.PHP_EOL;  
    $schuljahre = new Schuljahre(); 
    echo 'Schuljahr: '.PHP_EOL; 
    $schuljahre->print_preselect($SchuljahrID, '', false); 
        // echo ' &#9475;';
    // echo '<input type="submit" class="btnSave" name="senden" value="Suchen">';
    echo '<input type="hidden" name="ansicht" value="'.$ansicht.'">
          </form>';    


    $query="SELECT s.ID 
          , f.Bezeichnung 
          , f.Datum_Start  AS `Datum von` 
          , f.Datum_Ende  AS `Datum bis` 
          , s.Bezeichnung AS Schuljahr 
          , f.Bundesland 
          -- , s.Datum_Start  as `Datum Schuljahr von` 
          -- , s.Datum_Ende  as `Datum Schuljahr bis` 
        FROM schuljahr s 
          INNER JOIN  ferien f on f.SchuljahrID = s.ID 
        WHERE 1=1 ".PHP_EOL; 
    
    if($SchuljahrID!='') {
      $query.="AND s.ID='".$SchuljahrID."' ";  
    }

    $query.="ORDER BY s.Datum_Start, f.Datum_Start";     

    break; 
  case 'feiertage': 
    include_once("classes/class.schuljahr.php");
    include_once("classes/class.schuljahre.php");

    $add_link_edit=false; 
    $table_edit='ferien';      

    $SchuljahrID=(isset($_REQUEST["SchuljahrID"])?$_REQUEST["SchuljahrID"]:'');

    if($SchuljahrID=='') {
      $schuljahr= new Schuljahr(); 
      $SchuljahrID= $schuljahr->getCurrentID(); 
    }

    echo '<form action="" method="get">'.PHP_EOL;  
    $schuljahre = new Schuljahre(); 
    echo 'Schuljahr: '.PHP_EOL; 
    $schuljahre->print_preselect($SchuljahrID, '', false); 
        // echo ' &#9475;';
    // echo '<input type="submit" class="btnSave" name="senden" value="Suchen">';
    echo '<input type="hidden" name="ansicht" value="'.$ansicht.'">
          </form>';    

    $query="SELECT s.ID 
          , f.Bezeichnung 
          , f.Datum 
          , s.Bezeichnung AS Schuljahr 
          , f.Bundesland           
        FROM schuljahr s 
          INNER JOIN feiertag f on f.SchuljahrID = s.ID 
        WHERE 1=1 ".PHP_EOL; 
    
    if($SchuljahrID!='') {
      $query.="AND s.ID='".$SchuljahrID."' ";  
    }

    $query.="ORDER BY f.Datum";      
    break; 

  
  
    case 'XXXX': 

    break; 



  case 'schueler-kalender-vorlage': 

    $add_link_edit=false; 
    $table_edit='kalender'; // pro forma 

    $SchuelerID=(isset($_REQUEST["SchuelerID"])?$_REQUEST["SchuelerID"]:'');   
    
    echo '<form action="" method="get">'.PHP_EOL;       

    $schueler = new Schueler(); 
        // echo ' &#9475;';    
    echo ' Schüler: '.PHP_EOL; 
    $schueler->print_select($SchuelerID,'','',true); 

    echo '<input type="submit" class="btnSave" name="senden" value="Suchen">';
    echo '<input type="hidden" name="ansicht" value="'.$ansicht.'">'; 

    echo '</form>';         
    
    if ($SchuelerID=='') {
      echo 'Bitte einen Schüler auswählen!'; 
      goto pagefoot;
    }    
    
    $schueler->ID = $SchuelerID; 

    $query=$schueler->getQuery('kalender_vorlage'); 
    
    break;     



  
    /**
  
    Komponisten
    Besetzungen
    Verwendungszwecke
    Gattungen
    Epochen
    Materialtypen
    Schwierigkeitsgrade, Instrumente
    Erprobt-Eigenschaften
    Besonderheiten, Besonderheit Typen
    Status Ausprägungen (Status Schüler Satz/Material-Zuordnung)
    Übung Typen
    Link-Typen
    Abfrage-Typen
   **/ 


}

if($query=='') {
  $info->print_user_error('Es wurde keine Ansicht definiert.');   
  goto pagefoot;
}




/******************************* */
// echo '<pre>'.$query.'</pre>'; // Test 


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
