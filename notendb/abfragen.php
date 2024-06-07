
<?php 
include('head.php');

$abfragen[] = array('name' => 'Sammlungen ohne Musikstück'
              , 'testview'   => "v_test_sammlung_ohne_musikstueck"
              , 'table'   => "sammlung"              
              );

$abfragen[] = array('name' => 'Musikstücke ohne Satz'
            , 'testview'   => "v_test_musikstueck_ohne_satz"
            , 'table'   => "musikstueck"              
           );

$abfragen[] = array('name' => 'Musikstücke ohne Besetzung'
           , 'testview'   => "v_test_musikstueck_ohne_besetzung"
           , 'table'   => "musikstueck"              
          );

$abfragen[] = array('name' => 'Satz ohne Spieldauer'
          , 'testview'   => "v_test_satz_ohne_spieldauer"
          , 'table'   => "satz"              
         );

$abfragen[] = array('name' => 'Satz ohne Erprobt-Angabe'
         , 'testview'   => "v_test_satz_ohne_erprobt"
         , 'table'   => "satz"              
        );

$abfragen[] = array('name' => 'Satz ohne Schwierigkeitsgrad'
              , 'testview'   => "v_test_satz_ohne_schwierigkeitsgrad"
              , 'table'   => "satz"              
              );



echo '<h2>Tests</h2>'; 

foreach ($abfragen as $abfrage)
{

  $query='SELECT * FROM '.$abfrage["testview"]; 

  include_once("cl_db.php");
  $conn = new DbConn(); 
  $db=$conn->db; 

  $select = $db->prepare($query); 

  try {
    $select->execute(); 
    include_once("cl_html_table.php");      
    echo '<h3>'.$abfrage['name'].'</h3>';     
    $html = new HtmlTable($select); 
    $html->print_table($abfrage['table'] , true,'', ucfirst($abfrage['table'])); 
  
    
  }
  catch (PDOException $e) {
    include_once("cl_html_info.php"); 
    $info = new HtmlInfo();      
    $info->print_user_error(); 
    $info->print_error($select, $e); 
  }


}




include('foot.php');

?>
