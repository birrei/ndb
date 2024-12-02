
<?php 
include('head.php');

/** Test Potenzmenge */
/* https://www.php.de/forum/webentwicklung/php-einsteiger/php-tipps-2006/40886-array-alle-m%C3%B6glichen-kombinationen */
// $instrumente = array(1,2,3);
// $out = array(array());
// foreach ($instrumente as $val1) {
//     $temp = $out;
//   foreach ($temp as $val2) {
//     $out[] = array_merge($val2,array($val1));
//   }
// } 


$instrumente= array("1_Violine","3_Klavier","2_Viola", "4_Gitarre", "5_Sopranflöte"); 
$out= array(); 

// print_r($instrumente); 


// // 2er kombi 
foreach($instrumente as $val) {
  $tmp=[]; 
  $strtmp=''; 
  foreach($instrumente as $val2) {
    $tmp[0]=$val;
    $tmp[1]=$val2; 
    sort($tmp); 
    $strtmp=implode(', ', $tmp); 
    // print_r($tmp);     
    $out[]= $strtmp; 
  }
}

printArr($out); 

$out=[]; 

// 3er kombi 
foreach($instrumente as $val) {
  $tmp=[]; 
  $strtmp=''; 
  foreach($instrumente as $val2) {
    foreach($instrumente as $val3) {
      $tmp[0]=$val;
      $tmp[1]=$val2; 
      $tmp[2]=$val3;     
      sort($tmp); 
  
      $strtmp=implode(', ', $tmp); 
      // print_r($tmp);     
      $out[]= $strtmp; 

    }
  }
}

printArr($out); 

$out=[]; 

// 4er kombi 
foreach($instrumente as $val) {
  $tmp=[]; 
  $strtmp=''; 
  foreach($instrumente as $val2) {
    foreach($instrumente as $val3) {
      foreach($instrumente as $val4) {

        $tmp[0]=$val;
        $tmp[1]=$val2; 
        $tmp[2]=$val3;     
        $tmp[3]=$val4;          
        sort($tmp); 
    
        $strtmp=implode(', ', $tmp); 
        // print_r($tmp);     
        $out[]= $strtmp; 
      }
    }
  }
}

printArr($out); 

function printArr($arr_besetz_in) {
  echo '<hr>'; 
  // sort($out); 
  $arr_besetz_out = array_unique($arr_besetz_in, SORT_STRING); 
  sort($arr_besetz_out); 
  // print_r($out2); 
  foreach($arr_besetz_out as $besetz_tmp) {
      $sufftmp = array("1_", "2_", "3_", "4_", "5_"); 
      $besetz= str_replace($sufftmp, "", $besetz_tmp); 
      echo $besetz.'<br>'; 
  }
}





include('foot.php');

?>
