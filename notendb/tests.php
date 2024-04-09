
<?php 
include('head.php');


$tests[] = array('name' => 'Sammlungen ohne Musikstück'
              , 'testview'   => "v_test_sammlung_ohne_musikstueck"
              , 'table'   => "sammlung"              
              );

$tests[] = array('name' => 'Musikstücke ohne Satz'
            , 'testview'   => "v_test_musikstueck_ohne_satz"
            , 'table'   => "musikstueck"              
           );

$tests[] = array('name' => 'Musikstücke ohne Besetzung'
           , 'testview'   => "v_test_musikstueck_ohne_besetzung"
           , 'table'   => "musikstueck"              
          );

$tests[] = array('name' => 'Satz ohne Spieldauer'
          , 'testview'   => "v_test_satz_ohne_spieldauer"
          , 'table'   => "satz"              
         );

$tests[] = array('name' => 'Satz ohne Erprobt-Angabe'
         , 'testview'   => "v_test_satz_ohne_erprobt"
         , 'table'   => "satz"              
        );


          

           



echo '<h2>Tests</h2>'; 

foreach ($tests as $test)
{

  $query='SELECT * FROM '.$test["testview"]; 

  include_once("cl_db.php");
  $conn = new DbConn(); 
  $db=$conn->db; 

  $select = $db->prepare($query); 

  try {
    $select->execute(); 
    include_once("cl_html_table.php");      
    echo '<h3>'.$test['name'].'</h3>';     
    $html = new HtmlTable($select); 
    $html->print_table($test['table'] , true); 
    
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
