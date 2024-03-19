
<?php 
include('head.php');
// include('snippets.php');
// include("dbconnect_pdo.php");

include("cl_html_table.php");    
include("cl_html_info.php");  

include("cl_besetzung.php");  
include("cl_verwendungszweck.php"); 
include("cl_db.php");



$Besetzungen=[]; 
$Verwendungszwecke=[]; 

if (isset($_POST['Ebene'])) {
  $Ebene=$_POST["Ebene"]; 
} else {
  $Ebene='Musikstueck'; // default 
}

if ("POST" == $_SERVER["REQUEST_METHOD"]) {
  if (isset($_REQUEST['Besetzungen'])) {
    $Besetzungen = $_REQUEST['Besetzungen'];      
  }
  if (isset($_REQUEST['Verwendungszwecke'])) {
    $Verwendungszwecke = $_REQUEST['Verwendungszwecke'];   
  }  
}
?> 

<form action="search_musikstueck.php" method="post">
<table class="eingabe"> 
<tr>    
    <td class="eingabe">Wähle eine oder mehrere Besetzungen aus: <br>  <br>  
        <?php 
            $besetzung = new Besetzung();
            $besetzung->print_select_multi($Besetzungen); 
        ?>
    </td>
 
    <td class="eingabe">Wähle einen oder mehrere Verwendungszwecke aus: <br>  <br>  
        <?php 
            $verwendungszweck = new Verwendungszweck();
            $verwendungszweck->print_select_multi($Verwendungszwecke);         
          echo ''; 
        ?>
    </td>
  
  </tr> 

</table> 

<fieldset>Aggegationsebene: 
    <input type="radio" id="sm" name="Ebene" value="Sammlung" <?php echo ($Ebene=='Sammlung'?'checked':'') ?>>
    <label for="sm">Sammlung</label> 
    <input type="radio" id="mu" name="Ebene" value="Musikstueck" <?php echo ($Ebene=='Musikstueck'?'checked':'') ?>> 
    <label for="mi">Musikstück</label>
    <input type="radio" id="st" name="Ebene" value="Satz" <?php echo ($Ebene=='Satz'?'checked':'') ?>>
    <label for="st">Satz</label> 
  </fieldset>


<p> <input type="submit" value="Suchen"></p> 

</form>



<?php
  $filter=false; // Prüfung, ob ein Filter gesetzt ist (wenn nicht -> keine Daten anzeigen)  
  $filterBesetzung=''; 
  $filterVerwendungszweck='';   
  
  if ("POST" == $_SERVER["REQUEST_METHOD"]) {
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
            , GROUP_CONCAT(DISTINCT m.Name order by m.Name SEPARATOR ', ') Musikstuecke
            , GROUP_CONCAT(DISTINCT b.Name order by b.Name SEPARATOR ', ') Besetzungen
            , GROUP_CONCAT(DISTINCT v.Name order by v.Name SEPARATOR ', ') Verwendungszwecke   
            ";

        break; 
      case 'Musikstueck': 
        $query.="SELECT s.ID
            ,s.Name as Sammlung
            , st.Name as Standort
            , m.Nummer as MNr
            , m.Name as Musikstueck
            , GROUP_CONCAT(DISTINCT b.Name order by b.Name SEPARATOR ', ') Besetzungen
            , GROUP_CONCAT(DISTINCT v.Name order by v.Name SEPARATOR ', ') Verwendungszwecke   
            , GROUP_CONCAT(DISTINCT sa.Name order by sa.Name SEPARATOR ', ') Saetze                 
            ";         
        break; 
      case 'Satz': 
        $query.="SELECT s.ID
            ,s.Name as Sammlung
            , st.Name as Standort
            , m.Nummer as MNr
            , m.Name as Musikstueck
            , sa.Name as Satz 
            , GROUP_CONCAT(DISTINCT b.Name order by b.Name SEPARATOR ', ') Besetzungen
            , GROUP_CONCAT(DISTINCT v.Name order by v.Name SEPARATOR ', ') Verwendungszwecke                  
            ";            
        break;      

    }


    $query.="
      FROM musikstueck m
      LEFT JOIN sammlung s on s.ID = m.SammlungID 
      LEFT JOIN standort st on s.StandortID = st.ID 
      LEFT JOIN musikstueck_besetzung mb on m.ID = mb.MusikstueckID
      LEFT JOIN besetzung b on mb.BesetzungID = b.ID
      LEFT JOIN musikstueck_verwendungszweck mv on m.ID = mv.MusikstueckID 
      LEFT JOIN verwendungszweck v on mv.VerwendungszweckID=v.ID    
      LEFT JOIN satz sa on sa.MusikstueckID = m.ID 
      WHERE 1=1 
      ". PHP_EOL; 

      if($filterBesetzung!=''){
        $query.=' AND mb.BesetzungID '.$filterBesetzung. PHP_EOL; 
      }
      if($filterVerwendungszweck!=''){
        $query.=' AND mv.VerwendungszweckID '.$filterVerwendungszweck. PHP_EOL; 
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
