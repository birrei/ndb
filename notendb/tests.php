
<?php 
include('head.php');


$abfragen[] = array('name' => 'Sammlungen ohne Musikstück'
              , 'testview'   => "v3_test_sammlung_ohne_musikstueck"
              , 'table'   => "sammlung"              
              );

$abfragen[] = array('name' => 'Musikstücke ohne Satz'
            , 'testview'   => "v3_test_musikstueck_ohne_satz"
            , 'table'   => "musikstueck"              
           );

$abfragen[] = array('name' => 'Musikstücke ohne Besetzung'
           , 'testview'   => "v3_test_musikstueck_ohne_besetzung"
           , 'table'   => "musikstueck"              
          );


$abfragen[] = array('name' => 'Satz ohne Spieldauer'
          , 'testview'   => "v3_test_satz_ohne_spieldauer"
          , 'table'   => "satz"              
         );

$abfragen[] = array('name' => 'Satz ohne Schwierigkeitsgrad'
              , 'testview'   => "v3_test_satz_ohne_schwierigkeitsgrad"
              , 'table'   => "satz"              
              );

// $abfragen[] = array('name' => 'Besonderheiten doppelt belegt'
//               , 'testview'   => "v3_test_besonderheiten_doppelt"
//               , 'table'   => "lookup"              
//               );

// $abfragen[] = array('name' => 'Musikstücke ohne Verwendungszweck'
//           , 'testview'   => "v3_test_musikstueck_ohne_verwendungszweck"
//           , 'table'   => "musikstueck"              
//          );          



echo '<h2>Tests</h2>'; 

foreach ($abfragen as $abfrage)
{

  $query='SELECT * FROM '.$abfrage["testview"]; 

  include_once("dbconn/cl_db.php");
  $conn = new DbConn(); 
  $db=$conn->db; 

  $select = $db->prepare($query); 

  try {
    $select->execute(); 
    include_once("classes/class.htmltable.php");      
  
    if ($select->rowCount() > 0 ) {
      echo '<h3>'.$abfrage['name'].'</h3>';     
      $html = new HtmlTable($select); 
      $html->add_link_edit=true; 
      $html->edit_link_title= ucfirst($abfrage['table']); 
      $html->edit_link_table=$abfrage['table']; 
      $html->print_table2(); 

     }
  
    
  }
  catch (PDOException $e) {
    include_once("classes/class.htmlinfo.php"); 
    $info = new HtmlInfo();      
    $info->print_user_error(); 
    $info->print_error($select, $e); 
  }


}




include('foot.php');

?>
