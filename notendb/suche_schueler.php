<?php 
include('head.php');
include("dbconn/cl_db.php");

include("cl_html_table.php");    
include("cl_html_info.php");  

include("cl_instrument.php");  
include("cl_schwierigkeitsgrad.php");  
include("cl_status.php");  

include("cl_lookup.php");   
include("cl_lookuptype.php");
include("cl_abfrage.php");
include("cl_schueler.php");


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
$filter=false; 

$filterSchwierigkeitsgrad=''; 
$filterSuchtext='';  

$edit_table=''; /* Tabelle, die über Bearbeiten-Links in Ergebnis-Tabelle abrufbar sein soll */

$Suche = new Abfrage();
$Suche->Beschreibung = "<b>Schüler-Suche</b>".PHP_EOL; 

?>

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

&nbsp;
&nbsp;

<!-- Link: Filter ein/ausblenden --> 
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

<?php 
if (isset($_POST['Ansicht'])) {
  $Ansicht=$_POST["Ansicht"];
} else {
  $Ansicht='Schueler'; // default 
}
?> 

<div class="search-page" id="search-page">
<div class="search-filter" id="search-filter">

<form id="Suche" action="" method="post">


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

<p class="navi-trenner">Schüler Attribute</p> 
<?php

  /************* Schüler  ***********/
  $schueler = new Schueler();
  $SchuelerID=''; 
  $filterSchueler=''; 
  if (isset($_POST['SchuelerID'])) {
    if ($_POST['SchuelerID']!='') {
      $SchuelerID = $_POST['SchuelerID']; 
      $schueler->ID=  $SchuelerID; 
      $schueler->load_row(); 
      $filterSchueler='AND schueler.ID='.$SchuelerID.' '; 
      $Suche->Beschreibung.=($SchuelerID!=''?'* Schüler: '.$schueler->Name:'');     
      $filter=true;       
    }
  }
  $schueler->print_select($SchuelerID,'',$schueler->Title);

  echo '<p></p>'; 

  /************* Instrument  ***********/
  $instrument = new Instrument();
  $InstrumentID=''; 
  $filterInstrument=''; 
  if (isset($_POST['InstrumentID'])) {
    if ($_POST['InstrumentID']!='') {
      $InstrumentID = $_POST['InstrumentID']; 
      $instrument->ID=  $InstrumentID; 
      $instrument->load_row(); 
      $filterInstrument='AND schueler.ID IN (SELECT SchuelerID FROM schueler_schwierigkeitsgrad WHERE InstrumentID='.$InstrumentID.') '; 
      $Suche->Beschreibung.=($InstrumentID!=''?'* Instrument: '.$instrument->Name:'');     
      $filter=true;       
    }
  }
  $instrument->print_select($InstrumentID,'',$instrument->Title);


  /************* Schwierigkeitsgrad  ***********/
  $schwierigkeitsgrad = new Schwierigkeitsgrad();
  if (isset($_POST['Schwierigkeitsgrad'])) {
    $Schwierigkeitsgrade = $_POST['Schwierigkeitsgrad']; 
    // echo count($Schwierigkeitsgrade); 
    $filterSchwierigkeitsgrad='AND schueler.ID IN (SELECT SchuelerID FROM schueler_schwierigkeitsgrad WHERE SchwierigkeitsgradID IN ('.implode(',', $Schwierigkeitsgrade).')) '; 
    $filter=true;       
  }
  $schwierigkeitsgrad->print_select_multi($Schwierigkeitsgrade);  
  $Suche->Beschreibung.=(count($Schwierigkeitsgrade)>0?$schwierigkeitsgrad->titles_selected_list:'');  

  /************* Status Noten / Material  ***********/
  $status = new Status();
  $StatusID=''; 
  $filterStatus=''; 
  if (isset($_POST['StatusID'])) {
    if ($_POST['StatusID']!='') {
      $StatusID = $_POST['StatusID']; 
      $status->ID= $StatusID; 
      $status->load_row(); 
      // XXX Material noch einbeziehen
      // $filterStatus='AND schueler.ID IN (SELECT SchuelerID FROM schueler_satz WHERE StatusID='.$StatusID.') '; 
      $filterStatus='AND schueler_satz.StatusID='.$StatusID.' '; // nur Sätze mit gewähltem Status anzeigen 

      $Suche->Beschreibung.=($StatusID!=''?'* Status: '.$status->Name:'');     
      $filter=true;       
    }
  }
  $status->print_select($StatusID,'Status Noten / Material');

?>

<p>

</p>

<hr>
<p>
  <input type="checkbox" id="sp" name="SucheSpeichern"><label for="sp">Suche speichern</label>   <!---- Entscheidung Suche speichern ja / nein -----> 
  <p> <a href="help_suche.php?title=Hilfe%20zur%20Suche#suche-schueler" target="_blank">Hilfe</a> </p> 
</p>



</form>
</div> <!-- ende class search-filter --> 
<div class="search-result" id="search-result">
<?php

  if ($filter ) {
    $query=""; 
    switch ($Ansicht){
      case 'Schueler': 

        /** XXX noch integtrieren: schueler_satz.Bemerkung, schueler_material.Bemerkung */

        $query.="
      select 
      schueler.ID 
    , schueler.Name
    , schueler.Bemerkung       
	, v_schueler_instrumente.Instrumente  
   , GROUP_CONCAT(DISTINCT 
            IF(sm.ID is not null
                   , CONCAT('* ', sm.Name, ': ', material.Name)
                   , CONCAT('* ', material.Name)
                  ) 
            order by 
                IF(sm.ID is not NULL, CONCAT(sm.Name, ': ', material.Name), material.Name)
            SEPARATOR '<br />') as Materialien
     
     
     , GROUP_CONCAT(
            DISTINCT concat('* ', sammlung.Name, ' / ', musikstueck.Name, 
                        IF(satz.Name <> '', CONCAT(' / ', satz.Name), ''), 
                        IF(schueler_satz.StatusID is not null, CONCAT(' / Status: ', status.Name), ''),
                        IF(schueler_satz.Bemerkung <> '', CONCAT(' / ', schueler_satz.Bemerkung), '')
            )  
            order by sammlung.Name, musikstueck.Nummer 
            SEPARATOR '<br />') as Noten 

            ";
        $edit_table='schueler'; 

    }


    switch ($Ansicht){
      case 'Schueler': 
 
          $query.="
    from schueler 
        left join schueler_material on schueler_material.SchuelerID = schueler.ID
        left join material on material.ID = schueler_material.MaterialID 
        left join sammlung sm on sm.ID=material.SammlungID 
        left join schueler_satz on schueler_satz.SchuelerID  = schueler.ID 
        left join status on status.ID = schueler_satz.StatusID           
        left join satz on satz.ID = schueler_satz.SatzID 
        left join musikstueck on musikstueck.ID = satz.MusikstueckID
        left join sammlung on sammlung.ID = musikstueck.SammlungID    
		left join v_schueler_instrumente on v_schueler_instrumente.SchuelerID = schueler.ID 
            WHERE 1=1 ". PHP_EOL; 
                  break; 
 
        }



     /* WHERE Filter */   

      switch ($Ansicht){
        case 'Schueler': 
                
          $query.=($filterSchueler!=''?$filterSchueler.PHP_EOL:''); 

          $query.=($filterInstrument!=''?$filterInstrument.PHP_EOL:''); 

          $query.=($filterSchwierigkeitsgrad!=''?$filterSchwierigkeitsgrad.PHP_EOL:''); 

          $query.=($filterStatus!=''?$filterStatus.PHP_EOL:'');           

          // $query.=($filterLookups_satz!=''?$filterLookups_satz.PHP_EOL:'');           

          if($suchtext!=''){
            $query.="AND (schueler.Name LIKE '%".$suchtext."%'   
                    OR schueler.Bemerkung LIKE '%".$suchtext."%' 
                    OR sammlung.Name LIKE '%".$suchtext."%' 
                    OR sammlung.Bemerkung LIKE '%".$suchtext."%' 
                    OR musikstueck.Name LIKE '%".$suchtext."%'  
                    OR material.Name LIKE '%".$suchtext."%' 
                    OR material.Bemerkung LIKE '%".$suchtext."%'                                                                                   
                    ) ". PHP_EOL;         
          }
          break; 


    }

      /* Gruppierung abhängig von Ansicht   */
      switch ($Ansicht){    
        case 'Schueler':         
          $query.="GROUP BY schueler.ID ". PHP_EOL;     
          break;    

      }

      /* Sortierung abhängig von Ansicht  */
      switch ($Ansicht){    
 
        case 'Schueler': 
          $query.="ORDER BY schueler.Name ". PHP_EOL;           
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
            echo '<pre>'.$Suche->Beschreibung.'</pre>';
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
</div> <!-- end class search-result -->
</div> <!-- end class search-page -->

<?php 
include('foot.php');
?>
