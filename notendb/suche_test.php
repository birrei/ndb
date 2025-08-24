<?php 
$PageTitle='Suche Test'; 
include_once('head.php');

include_once("classes/dbconn/class.db.php");  
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

include_once("suche_sql.php");

/***** Parameter: Initialisierung, Defaults  ******/
  if (isset($_POST['Ansicht'])) {
    $Ansicht=$_POST["Ansicht"];
  } else {
    $Ansicht='Sammlung'; // default 
  }
  $AnsichtEbene=getAnsichtEbene($Ansicht); 
  $AnsichtGruppe=getAnsichtGruppe($AnsichtEbene); 
  $edit_table=getEditTable($AnsichtEbene); 

  // // TEST 
  // echo '<br>Ansicht: '.$Ansicht; 
  // echo '<br>Ansicht Ebene: '.$AnsichtEbene; 
  // echo '<br>Ansicht Domäne: '.$AnsichtGruppe; 
  // echo '<br>edit_table: '.$edit_table; 

  $filter=false; 

  $Suche = new Abfrage();
  $Suche->Beschreibung = ""; 


  $query=''; 
  $query_SELECT=''; 
  $query_FROM=''; 
  $query_GROUP_BY=''; 
  $query_WHERE='WHERE 1=1 '.PHP_EOL; 
  $query_ORDER_BY=''; 

  /**************** */

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

<form id="Suche" action="" method="post">

<?php
/************** Auswahl Ansicht **********/  
  $Suche->Beschreibung.='Ansicht: '.$Ansicht.' (Gruppe: '.$AnsichtGruppe.')'.PHP_EOL; 
  $Suche->Beschreibung.='Aktive Filter: '.PHP_EOL; 
  // $Suche->Beschreibung.='* Ansicht Ebene: '.$AnsichtEbene.PHP_EOL; 
  // $Suche->Beschreibung.='* Ansicht Gruppe: '.$AnsichtGruppe.PHP_EOL; 
  ?>
  <br><b>Ansicht: </b>
  <select id="Ansicht" name="Ansicht" onchange="this.form.submit()" style="background-color: lightgreen">
      <option value="Sammlung" <?php echo ($Ansicht=='Sammlung'?'selected':'');?>>Sammlung (Noten)</option>   
      <option value="Sammlung erweitert" <?php echo ($Ansicht=='Sammlung erweitert'?'selected':'')?>>Sammlung erweitert (Noten)</option>   
      <option value="Sammlung Links" <?php echo ($Ansicht=='Sammlung Links'?'selected':'')?>>Sammlung Links (Noten)</option>              
      <option value="Musikstueck" <?php echo ($Ansicht=='Musikstueck'?'selected':'');?>>Musikstück (Noten)</option>
      <option value="Satz" <?php echo ($Ansicht=='Satz'?'selected':'')?>>Satz (Noten)</option>
      <option value="Satz Besonderheiten" <?php echo ($Ansicht=='Satz Besonderheiten'?'selected':'')?>>Satz Besonderheiten (Noten)</option>                     
      <option value="Satz Schueler" <?php echo ($Ansicht=='Satz Schueler'?'selected':'')?>>Satz Schüler (Noten)</option>    
      <option value="Material" <?php echo ($Ansicht=='Material'?'selected':'')?>>Material (Material)</option>
      <option value="Material_erweitert" <?php echo ($Ansicht=='Material_erweitert'?'selected':'')?>>Material erweitert (Material)</option>      
      <option value="Schueler" <?php echo ($Ansicht=='Schueler'?'selected':'')?>>Schüler (Schüler)</option> 
      <option value="Schueler erweitert" <?php echo ($Ansicht=='Schueler erweitert'?'selected':'')?>>Schüler erweitert (Schüler)</option>                                        
  </select>

<!---- Checkbox Suche speichern ja / nein -----> 
   &nbsp; &nbsp; <input type="checkbox" id="sp" name="SucheSpeichern"><label for="sp">Suche speichern</label> 

<?php 



/************* Filter Besonderheiten  **********/

  $lookuptypes=new Lookuptype(); 
  // $lookuptypes->Relation='satz'; 
  $arrLookupTypes=$lookuptypes->getArrData2(); 
  $filterLookups_satz=''; 
  for ($i = 0; $i < count($arrLookupTypes); $i++) {
    // print_r($arrLookupTypes[$i]);  // Test     
    $lookup_check_include=false; // Einschluss-Suche ja/nein 
    $lookup_check_exclude=false;    // Ausschluss-Suche ja/nein
    $lookup_type_name=$arrLookupTypes[$i]["Name"]; 
    $lookup_type_key= $arrLookupTypes[$i]["type_key"]; 

    $relations = $arrLookupTypes[$i]["Relation"];  // XXX array ggf. zugeordneten "relations"
    // print_r($relations); 

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
      if (isset($_POST['include_'.$lookup_type_key])) { 
        //  "Einschluss-Suche" aktiviert 
        $lookup_check_include=true;         
        for ($k = 0; $k < count($lookup_values_selected); $k++) {
          $query_WHERE.= getSQL_WHERE_Filter_Lookup_include($lookup_values_selected[$k], $relations); 
        }
      } 
      else {
        //  "Einschluss-Suche" NICHT aktiviert, 
        $query_WHERE.= getSQL_WHERE_Filter_Lookup($lookup_values_selected, $relations);             
      }
      if (isset($_POST['exclude_'.$lookup_type_key])) {    
        // Ausschluss-Suche aktiviert 
        $lookup_values = $lookup->getArrLookups();        
        $lookup_check_exclude=true; 
        $lookup_values_not_selected = array_diff($lookup_values, $lookup_values_selected); // nicht ausgewählte Werte    
        $query_WHERE.='AND satz.ID NOT IN (SELECT DISTINCT SatzID from satz_lookup WHERE LookupID IN ('.implode(',', $lookup_values_not_selected).')) '. PHP_EOL; 
      }      
    }    
    $lookup->print_select_multi($lookup_type_key,$lookup_values_selected, $lookup_type_name.':', true, $lookup_check_include, true,$lookup_check_exclude );
    $Suche->Beschreibung.=(count($lookup_values_selected)>0?$lookup->titles_selected_list:'');   
  }






/*** Navi-Block "Material */


/************* Filter Material mit / ohne Sammlung
 * XXX entfernen, nicht mehr relevant 
 * 
 *  **********/  
 


?>
</form>
</div> 
<!-- ende class search-filter --> 
<div class="search-result" id="search-result">
<?php

/************* SQL zusammensetzen  **********/  

  $query.=getSQL_SELECT($Ansicht); 

  $query.=getSQL_FROM($Ansicht); 

  switch ($AnsichtEbene){    
    case 'Musikstueck': 
      $query_WHERE.="AND musikstueck.ID IS NOT NULL ". PHP_EOL;         
      break;                  
    case 'Satz': 
      $query_WHERE.="AND satz.ID IS NOT NULL ". PHP_EOL;             
      break;      
  }
  
  $query.=$query_WHERE; 

  // if($suchtext!='') {
  //   $query_WHERE_Suchtext=getSQL_WHERE_Suchtext($AnsichtGruppe, $suchtext); 
  //   $query.=$query_WHERE_Suchtext; 
  //   // XXX groß-klein - Schreibung berücksichtigen 
  // }

  $query.= getSQL_GROUP_BY($AnsichtEbene); 

  $query.= getSQL_ORDER_BY($Ansicht, $filter); 

/************* Falls kein Filter ausgewählt wurde **********/  
  if(!$filter) {
    echo 'Es wurde kein Filter gesetzt'.PHP_EOL;
    goto keinFilter; 
  } 

/************* Ergebnistabelle anzeigen bzw. alternativ Suche speichern  **********/  

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
    
    goto keinFilter; 
    
  } 

  if ($Suche->Beschreibung!='') {
    echo '<pre>'.$Suche->Beschreibung.'</pre>';
  }

  include_once("classes/dbconn/class.db.php");
  $conn = new DBConnection(); 
  $db=$conn->db; 
  
  $select = $db->prepare($query); 

    
  try {
    $select->execute(); 
    include_once("classes/class.htmltable.php");      
    $html = new HTML_Table($select); 
    $html->add_link_edit=true; 
    $html->edit_link_table=$edit_table; 
    $html->edit_link_title=$Ansicht; 
    $html->edit_link_open_newpage=true; 
    $html->show_row_count=true; 
    $html->print_table2(); 
  }
  catch (PDOException $e) {
    include_once("classes/class.htmlinfo.php"); 
    $info = new HTML_Info();      
    $info->print_user_error(); 
    $info->print_error($select, $e); 
  }    

  echo '<pre style="font-size: 11px; visibility: hidden;">'.$query.'</pre>'; // Test  

  keinFilter: 

?>
</div> <!-- end class search-result -->
</div> <!-- end class search-page -->

<?php 
 
include_once('foot.php');
?>
