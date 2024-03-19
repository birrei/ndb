
<?php 
include('head.php');
// include('snippets.php');
// include("dbconnect_pdo.php");

include("cl_html_table.php");    
include("cl_html_info.php");  

include("cl_besetzung.php");  
include("cl_verwendungszweck.php"); 
include("cl_db.php");


$table='besetzung'; 

$Besetzungen=[]; 
$Verwendungszwecke=[]; 

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
<hr />

<td class="eingabe"><input type="submit" value="Suchen"></td>
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

  if ($filter ) {

    $query="SELECT s.ID
        ,s.Name as Sammlung
        , st.Name as Standort 
        , m.Nummer as MNr
        , m.Name as Musikstueck
        , v.Name as Verwendungszweck 
        , GROUP_CONCAT(DISTINCT b.Name order by b.Name SEPARATOR ', ') Besetzungen                  
      FROM musikstueck m
      LEFT JOIN sammlung s on s.ID = m.SammlungID 
      LEFT JOIN standort st on s.StandortID = st.ID 
      LEFT JOIN musikstueck_besetzung mb on m.ID = mb.MusikstueckID
      LEFT JOIN besetzung b on mb.BesetzungID = b.ID
      LEFT JOIN musikstueck_verwendungszweck mv on m.ID = mv.MusikstueckID 
      LEFT JOIN verwendungszweck v on mv.VerwendungszweckID=v.ID               
      WHERE 1=1 
      "; 

      if($filterBesetzung!=''){
        $query.=' AND mb.BesetzungID '.$filterBesetzung; 
      }
      if($filterVerwendungszweck!=''){
        $query.=' AND mv.VerwendungszweckID '.$filterVerwendungszweck; 
      }            
      $query.= '
        group by 
            m.ID  
        ORDER BY
            s.Name, m.Nummer'; 

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
