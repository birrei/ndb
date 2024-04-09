
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

$Standorte=[];   /* Sammlung */
$Verlage=[];   /* Sammlung */
$Komponisten=[];   /* Musikstück  */  
$Besetzungen=[];   /* Musikstück  */  
$Verwendungszwecke=[];   /* Musikstück  */  
$Gattungen=[];   /* Musikstück  */
$Epochen=[];   /* Musikstück  */

$Stricharten=[];  /* Satz  */
$Notenwerte=[];  /* Satz  */
$Erprobt=[];  /* Satz  */


$spieldauer_von=''; 
$spieldauer_bis=''; 
$suchtext=''; 

if (isset($_POST['Ebene'])) {
  $Ebene=$_POST["Ebene"]; 
} else {
  $Ebene='Sammlung'; // default 
}

/* zuvor gewählte Werte sichern, um sie wieder im Formular zu setzen */  
if ("POST" == $_SERVER["REQUEST_METHOD"]) {
  if (isset($_REQUEST['Standorte'])) {
    $Standorte = $_REQUEST['Standorte'];   
  }
  if (isset($_REQUEST['Verlage'])) {
    $Verlage = $_REQUEST['Verlage'];   
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
  if (isset($_REQUEST['Erprobt'])) {
    $Erprobt = $_REQUEST['Erprobt'];   
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
<form id="Suche" action="suche.php" method="post">
<table> 
<tr>    
    <td class="selectboxes"><!--  Spalte 1 --> 
        <b>Standort(e):</b> <br>   
        <?php 
            $standort = new Standort();
            $standort->print_select_multi($Standorte);         
          echo ''; 
        ?>
    </td>
    <td class="selectboxes"><!--  Spalte 2 --> 
        <b>Verlag(e):</b> <br>   
    <?php 
            $verlag = new Verlag();
            $verlag->print_select_multi($Verlage);         
          echo ''; 
        ?>
    </td>
    <td class="selectboxes"><!--  Spalte 3 --> 
      <b>Komponist(en):</b> <br>  
    <?php 
            $komponist = new Komponist();
            $komponist->print_select_multi($Komponisten);         
          echo ''; 
        ?>      
    </td>

    <td class="selectboxes"><!--  Spalte 4 --> 
 
    </td>
    <td class="selectboxes"><!--  Spalte 5 --> 

    </td>

  </tr>



<tr>
    <td class="selectboxes"><!--  Spalte 1 --> 
      <b>Besetzung(en):</b> <br>   
        <?php 
            $besetzung = new Besetzung();
            $besetzung->print_select_multi($Besetzungen); 
        ?>
    </td> 
    <td class="selectboxes"><!--  Spalte 2 --> 
      <b>Verwendungszweck(e):</b> <br>   
        <?php 
            $verwendungszweck = new Verwendungszweck();
            $verwendungszweck->print_select_multi($Verwendungszwecke);         
          echo ''; 
        ?>
    </td>  
    <td class="selectboxes"><!--  Spalte 3 --> 
      <b>Gattung(en):</b> <br>
    <?php 
            $gattung = new Gattung();
            $gattung->print_select_multi($Gattungen);         
          echo ''; 
        ?>
    </td>
    <td class="selectboxes"><!--  Spalte 4 --> <b>Epoche(n):</b> <br>  
    <?php 
            $epochen = new Epoche();
            $epochen->print_select_multi($Epochen);         
          echo ''; 
        ?>      
    </td>
    <td class="selectboxes"><!--  Spalte 5 --> 

    </td>
</tr> 
<tr>
    <td class="selectboxes"><!--  Spalte 1 --> 
        <b>Strichart(en):</b> <br>
    <?php 
            $stricharten = new Strichart();
            $stricharten->print_select_multi($Stricharten);      
          echo ''; 
        ?>
    </td>
    <td class="selectboxes"><!--  Spalte 2 --> 
      <b>Notenwert(e):</b> <br>
    <?php 
            $notenwerte = new Notenwert();
            $notenwerte->print_select_multi($Notenwerte);      
          echo ''; 
        ?>
    </td>

    <td class="selectboxes"><!--  Spalte 3 --> 
    <b>Erprobt:</b> <br>
    <?php 
            $erprobt = new Erprobt();
            $erprobt->print_select_multi($Erprobt);      
          echo ''; 
        ?>
   </td>

  <td class="selectboxes"><!--  Spalte 4 --> 
  Suchtext: <br> 
    <input type="text" id="suchtext" name="suchtext" size="20" value="<?php echo $suchtext; ?>">
<!--     <br>Durchsucht werden die Name- und Bemerkung-Felder von Sammlung, Musikstück und Satz. --> 
    <br><input type="button" id="btnReset_suchtext" value="Filter zurücksetzen" onclick="Reset_suchtext();" />  
        <script type="text/javascript">  
                function Reset_suchtext() {  
                  document.getElementById("suchtext").value='';  
            }  
        </script>     
 </td>
  <td class="selectboxes"><!--  Spalte 5 --> 
     Spieldauer von: <br> <input type="text" id="SpieldauerVon" name="SpieldauerVon" size="5" value="<?php echo $spieldauer_von; ?>"><br> 
     Spieldauer bis: <br> <input type="text" id="SpieldauerBis" name="SpieldauerBis" size="5" value="<?php echo $spieldauer_bis; ?>"><br> 

     <input type="button" id="btnReset_Spieldauer" value="Filter zurücksetzen" onclick="Reset_Spieldauer();" />  
        <script type="text/javascript">  
                function Reset_Spieldauer() {  
                  document.getElementById("SpieldauerVon").value='';  
                  document.getElementById("SpieldauerBis").value='';  
            }  
        </script> 

    </td>
</tr>
</table> 

<p></p>

<input type="button" id="btnReset_All" value="Alle Filter zurücksetzen" onclick="Reset_All();" /> 
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
<p></p>

<fieldset>Ebene: 
    <input type="radio" id="sm" name="Ebene" value="Sammlung" <?php echo ($Ebene=='Sammlung'?'checked':'') ?>>
    <label for="sm">Sammlung</label> 
    <input type="radio" id="mu" name="Ebene" value="Musikstueck" <?php echo ($Ebene=='Musikstueck'?'checked':'') ?>> 
    <label for="mu">Musikstück</label>
    <input type="radio" id="st" name="Ebene" value="Satz" <?php echo ($Ebene=='Satz'?'checked':'') ?>>
    <label for="st">Satz</label> 
  </fieldset>
<p>
  <input type="submit" value="Suchen" class="btnSave"></p> 

</form>
<?php
  $filter=false; 

  $filterStandorte='';   
  $filterVerlage='';   
  $filterBesetzung=''; 
  $filterVerwendungszweck='';
  $filterKomponisten='';   
  $filterGattungen='';  
  $filterEpochen='';    
  $filterStricharten=''; 
  $filterNotenwerte='';   
  $filterErprobt=''; 
  $filterSpieldauer='';   
  $filterSuchtext='';  
  
  /* Ausgewählte Werte für Abfrage-Filter auslesen  */
  if ("POST" == $_SERVER["REQUEST_METHOD"]) {
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
    if (isset($_REQUEST['Erprobt'])) {
      $Erprobt = $_REQUEST['Erprobt'];   
      $filterErprobt= 'IN ('.implode(',', $Erprobt).')'; 
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
        $filterSpieldauer=' BETWEEN '.$spieldauer_von.' AND '.$spieldauer_bis; 
        $filter=true; 
      }
      if($spieldauer_von !='' and $spieldauer_bis !=''){
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
                            sa.Erprobt LIKE '%".$suchtext."%' OR
                            sa.Taktart LIKE '%".$suchtext."%' OR
                            sa.Tonart LIKE '%".$suchtext."%' OR
                            sa.Tempobezeichnung LIKE '%".$suchtext."%' OR
                            sa.Schwierigkeitsgrad LIKE '%".$suchtext."%' OR                             
                            sa.Bemerkung LIKE '%".$suchtext."%'
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
            , s.Bemerkung 
            , GROUP_CONCAT(DISTINCT m.Name order by m.Nummer SEPARATOR ', ') Musikstuecke
            , s.Bestellnummer 
            ";

        break; 
      case 'Musikstueck': 
        $query.="SELECT s.ID
            ,s.Name as Sammlung
            , st.Name as Standort
            , m.Nummer as MNr
            , m.Name as Musikstueck
            , k.Name as Komponist 
            , gattung.Name as Gattung 
            , epoche.Name as Epoche
            , m.JahrAuffuehrung            
            , GROUP_CONCAT(DISTINCT b.Name order by b.Name SEPARATOR ', ') Besetzungen
            , GROUP_CONCAT(DISTINCT v.Name order by v.Name SEPARATOR ', ') Verwendungszwecke   
            , GROUP_CONCAT(DISTINCT sa.Name order by sa.Nr SEPARATOR ', ') Saetze                 
            ";         
        break; 
      case 'Satz': 
        $query.="SELECT s.ID
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
            , sa.Spieldauer
            , sa.Schwierigkeitsgrad
            , sa.Lagen 
            , erprobt.Name as Erprobt 
            , GROUP_CONCAT(DISTINCT str.Name order by str.Name SEPARATOR ', ') Stricharten              
            , GROUP_CONCAT(DISTINCT notenwert.Name order by notenwert.Name SEPARATOR ', ') Notenwerte  
            , sa.Bemerkung              
            ";            
        break;      

    }


    $query.="
      FROM sammlung s 
      LEFT JOIN standort st on s.StandortID = st.ID    
      LEFT JOIN verlag  on s.VerlagID = verlag.ID            
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
      if($filterErprobt!=''){
        $query.=' AND sa.ErprobtID '.$filterErprobt. PHP_EOL; 
      }         
      if($filterSpieldauer!=''){
        $query.=' AND sa.Spieldauer '.$filterSpieldauer. PHP_EOL; 
      }
      if($filterSuchtext!=''){
        $query.=' AND'.$filterSuchtext. PHP_EOL; 
      }


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

      include_once("cl_db.php");
      $conn = new DbConn(); 
      $db=$conn->db; 
      
      $select = $db->prepare($query); 
        
      try {
        $select->execute(); 
        include_once("cl_html_table.php");      
        $html = new HtmlTable($select); 
        $html->print_table('sammlung', True); 
      }
      catch (PDOException $e) {
        include_once("cl_html_info.php"); 
        $info = new HtmlInfo();      
        $info->print_user_error(); 
        $info->print_error($select, $e); 
      }
      

    }
    else {
          echo '<p>Es wurde kein Filter gesetzt. </p>'; 
  }

include('foot.php');

?>
