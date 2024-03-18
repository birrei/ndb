
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
    include_once("ctl_html_info.php"); 
    $info = new HtmlInfo();      
    $info->print_user_error(); 
    $info->print_error($select, $e); 
  }

    // $query='SELECT * FROM '.$test["testview"]; 
    // // echo '<pre>'.$query.'</pre>'; 

    // $stmt = $db->prepare($query); 
    
    // try {
    //   $stmt->execute(); 
    //   if ($stmt->rowCount() > 0)  {
    //     echo '<h3>'.$test['name'].'</h3>';           
    //     $html_table= get_html_table($stmt, $test['table'] , true); 
    //     echo $html_table;  
    //   }
    // }
    // catch (PDOException $e) {
    //   echo get_html_user_error_info(); 
    //   echo get_html_error_info($stmt, $e);       
    // }

}




include('foot.php');

?>
