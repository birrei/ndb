
<?php 
include('head.php');
include('snippets.php');
include("dbconnect_pdo.php");

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
        <!-- select Besetzung  --> 
        <?php 
          $select = $db->query("SELECT DISTINCT `ID` as BesetzungID, `Name` FROM `besetzung` order by `Name`");
          $options = $select->fetchAll(PDO::FETCH_KEY_PAIR);
          $html = get_html_select_multi('Besetzung', $options, 'Besetzungen[]', $Besetzungen); // s. snippets.php
          echo $html;
        ?>
    </td>
 
    <td class="eingabe">Wähle einen oder mehrere Verwendungszwecke aus: <br>  <br>  
        <!-- select Verwendungszweck  --> 
        <?php 
          $select = $db->query("SELECT DISTINCT `ID` as BesetzungID, `Name` FROM `verwendungszweck` order by `Name`");
          $options = $select->fetchAll(PDO::FETCH_KEY_PAIR);
          $html = get_html_select_multi('Verwendungszweck', $options, 'Verwendungszwecke[]',$Verwendungszwecke); // s. snippets.php
          echo $html;
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
      $query='SELECT m.ID
                ,s.Name as Sammlung
                , s.Standort
                , m.Nummer as Nr
                , m.Name as Musikstueck
                , b.Name as Besetzung
                , v.Name as Verwendungszweck 
              FROM musikstueck m
              LEFT JOIN sammlung s on s.ID = m.SammlungID 
              LEFT JOIN musikstueck_besetzung mb on m.ID = mb.MusikstueckID
              LEFT JOIN besetzung b on mb.BesetzungID = b.ID
              LEFT JOIN musikstueck_verwendungszweck mv on m.ID = mv.MusikstueckID 
              LEFT JOIN verwendungszweck v on mv.VerwendungszweckID=v.ID               
              WHERE 1=1 
                '.($filterBesetzung!=''?' AND mb.BesetzungID '.$filterBesetzung:'').'
                '.($filterVerwendungszweck!=''?' AND mv.VerwendungszweckID '.$filterVerwendungszweck:'').'          
              ORDER BY s.Name, m.Nummer'; 

      // echo '<pre>'.$query.'</pre>'; 
      $stmt = $db->prepare($query); 

      try {
        $stmt->execute(); 
        // $html_table= get_html_table($stmt, 'musikstueck', false); 
        $html_table= get_html_table($stmt, 'musikstueck', true);  // Ohne Bearbeiten-Link         
        echo $html_table;  
      }
      catch (PDOException $e) {
        echo get_html_user_error_info(); 
        echo get_html_error_info($stmt, $e);       
      }
    }
    else {
          echo '<p>Es wurde kein Filter gesetzt. </p>'; 
      }

include('foot.php');

?>
