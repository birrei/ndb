
<?php 
include('head.php');
include('snippets.php');
include("dbconnect_pdo.php");

$table='besetzung'; 
$Besetzungen=[]; 

?> 
<form action="search_musikstueck.php" method="post">

<table class="eingabe"> 

<tr>    
    <label>
    <td class="eingabe">Besetzung:</td>  
    <td class="eingabe">
        <!-- select Besetzung  --> 
        <?php 

              $select = $db->query("SELECT DISTINCT `ID` as BesetzungID, `Name` FROM `besetzung` order by `Name`");
              $options = $select->fetchAll(PDO::FETCH_KEY_PAIR);
              
              $html = get_html_select2($options, 'Besetzungen[]', '', false, true); // s. snippets.php
              echo $html;
        ?>
    </td>
    </label>
     </tr> 

  <tr> 
    <td class="eingabe"></td> 
    <td class="eingabe"><input type="submit" value="Suchen"></td>
</tr>
</table> 

</form>

<?php
  $filter=false; // Prüfung, ob ein Filter gesetzt ist (wenn nicht -> keine Daten anzeigen)  
  $filterBesetzung=''; 
  
  if ("POST" == $_SERVER["REQUEST_METHOD"]) {


    if (isset($_REQUEST['Besetzungen'])) {
      $Besetzungen = $_REQUEST['Besetzungen'];   
      $filterBesetzung = 'IN ('.implode(',', $Besetzungen).')'; 
      $filter=true; 
    }
 
  }

  if ($filter ) {
      $query='SELECT m.ID,s.Name as Sammlung, m.Name as Musikstueck, b.Name as Besetzung
              from musikstueck m
              LEFT JOIN musikstueck_besetzung mb
              on m.ID = mb.MusikstueckID
              LEFT JOIN besetzung b
              on mb.BesetzungID = b.ID
              LEFT JOIN sammlung s
              on s.ID = m.SammlungID           
              WHERE 1=1 
                  '.($filterBesetzung!='' ?' AND mb.BesetzungID '.$filterBesetzung:'').'
              ORDER BY s.Name, m.Nummer'; 

      // echo '<pre>'.$query.'</pre>'; 
      $stmt = $db->prepare($query); 
      // $stmt->bindParam(':SammlungID', $_GET["SammlungID"], PDO::PARAM_INT); 

      try {
        $stmt->execute(); 
        // $html_table= get_html_table($stmt, 'musikstueck', false); 
        $html_table= get_html_table($stmt);  // Ohne Bearbeiten-Link         
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
