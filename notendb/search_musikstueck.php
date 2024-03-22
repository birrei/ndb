
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


$Standorte=[];   /* Sammlung */
$Verlage=[];   /* Sammlung */
$Komponisten=[];   /* Musikstück  */  
$Besetzungen=[];   /* Musikstück  */  
$Verwendungszwecke=[];   /* Musikstück  */  
$Gattungen=[];   /* Musikstück  */  
$Stricharten=[];  /* Satz  */

if (isset($_POST['Ebene'])) {
  $Ebene=$_POST["Ebene"]; 
} else {
  $Ebene='Sammlung'; // default 
}

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
  if (isset($_REQUEST['Stricharten'])) {
    $Stricharten = $_REQUEST['Stricharten'];   
  }    
}
?> 
<form action="search_musikstueck.php" method="post">
<table> 
<tr>    
    <td class="selectboxes"><b>Standort(e):</b> <br>   
        <?php 
            $standort = new Standort();
            $standort->print_select_multi($Standorte);         
          echo ''; 
        ?>
    </td>
    <td class="selectboxes"><b>Verlag(e):</b> <br>   
    <?php 
            $verlag = new Verlag();
            $verlag->print_select_multi($Verlage);         
          echo ''; 
        ?>
    </td>
    <td class="selectboxes"><b>Komponist(en):</b> <br>  
    <?php 
            $komponist = new Komponist();
            $komponist->print_select_multi($Komponisten);         
          echo ''; 
        ?>      
    </td>
</tr>

<tr>
    <td class="selectboxes"><b>Besetzung(en):</b> <br>   
        <?php 
            $besetzung = new Besetzung();
            $besetzung->print_select_multi($Besetzungen); 
        ?>
    </td> 
    <td class="selectboxes"><b>Verwendungszweck(e):</b> <br>   
        <?php 
            $verwendungszweck = new Verwendungszweck();
            $verwendungszweck->print_select_multi($Verwendungszwecke);         
          echo ''; 
        ?>
    </td>  
    <td class="selectboxes"><b>Gattung(en):</b> <br>
    <?php 
            $gattung = new Gattung();
            $gattung->print_select_multi($Gattungen);         
          echo ''; 
        ?>
    </td>
</tr> 

<tr>
    <td class="selectboxes"><b>Strichar(en):</b> <br>
    <?php 
            $stricharten = new Strichart();
            $stricharten->print_select_multi($Stricharten);      
          echo ''; 
        ?>
    </td>
<td class="selectboxes"></td>
<td class="selectboxes"></td>
</tr>
</table> 

<fieldset>Ebene: 
    <input type="radio" id="sm" name="Ebene" value="Sammlung" <?php echo ($Ebene=='Sammlung'?'checked':'') ?>>
    <label for="sm">Sammlung</label> 
    <input type="radio" id="mu" name="Ebene" value="Musikstueck" <?php echo ($Ebene=='Musikstueck'?'checked':'') ?>> 
    <label for="mu">Musikstück</label>
    <input type="radio" id="st" name="Ebene" value="Satz" <?php echo ($Ebene=='Satz'?'checked':'') ?>>
    <label for="st">Satz</label> 
  </fieldset>
<p>
  <input type="submit" value="Suchen" style="font-weight: bold;width:50%"></p> 

</form>

<?php
  $filter=false; 

  $filterStandorte='';   
  $filterVerlage='';   
  $filterBesetzung=''; 
  $filterVerwendungszweck='';
  $filterKomponisten='';   
  $filterGattungen='';  
  $filterStricharten='';   
  
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
    if (isset($_REQUEST['Stricharten'])) {
      $Stricharten = $_REQUEST['Stricharten'];   
      $filterStricharten = 'IN ('.implode(',', $Stricharten).')'; 
      $filter=true; 
    }
  }

  if (isset($_POST['Ebene'])) {
    $Ebene=$_POST["Ebene"]; 
  }
  
  

  if ($filter ) {
    $query=""; 

    /* Spaltenauswahl und Aggregation abhängig von Ebene */ 
    switch ($Ebene){
      case 'Sammlung': 
        $query.="SELECT s.ID
            ,s.Name as Sammlung
            , st.Name as Standort
            , verlag.Name as Verlag
            , GROUP_CONCAT(DISTINCT m.Name order by m.Nummer SEPARATOR ', ') Musikstuecke
            -- , GROUP_CONCAT(DISTINCT b.Name order by b.Name SEPARATOR ', ') Besetzungen
            -- , GROUP_CONCAT(DISTINCT v.Name order by v.Name SEPARATOR ', ') Verwendungszwecke   
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
            , GROUP_CONCAT(DISTINCT b.Name order by b.Name SEPARATOR ', ') Besetzungen
            , GROUP_CONCAT(DISTINCT v.Name order by v.Name SEPARATOR ', ') Verwendungszwecke   
            , GROUP_CONCAT(DISTINCT sa.Name order by sa.Nr SEPARATOR ', ') Saetze                 
            ";         
        break; 
      case 'Satz': 
        $query.="SELECT s.ID
            ,s.Name as Sammlung
            , st.Name as Standort
            , m.Nummer as MNr
            , m.Name as Musikstueck
            , k.Name as Komponist            
            , sa.Nr as SatzNr
            , sa.Name as Satz 
            , GROUP_CONCAT(DISTINCT str.Name order by str.Name SEPARATOR ', ') Stricharten                
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
      LEFT JOIN musikstueck_besetzung mb on m.ID = mb.MusikstueckID
      LEFT JOIN besetzung b on mb.BesetzungID = b.ID
      LEFT JOIN musikstueck_verwendungszweck mv on m.ID = mv.MusikstueckID 
      LEFT JOIN verwendungszweck v on mv.VerwendungszweckID=v.ID    
      LEFT JOIN satz sa on sa.MusikstueckID = m.ID 
      LEFT JOIN satz_strichart ssa on ssa.satzID = sa.ID
      LEFT JOIN strichart str on ssa.StrichartID = str.ID 
                          
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
      if($filterStricharten!=''){
        $query.=' AND ssa.StrichartID '.$filterStricharten. PHP_EOL; 
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
        include_once("ctl_html_info.php"); 
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
