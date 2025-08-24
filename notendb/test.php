<?php
$PageTitle='TEST'; 
include_once('head.php');
include_once('classes/class.htmlinfo.php');

// ---------------------------------------------------------------

/* Test Ergänzung Ausgabe Besonderheit-Typen  */

    include_once('classes/class.lookuptype.php');

    $lookuptypes=new Lookuptype(); 
    $arrLookupTypes=$lookuptypes->getArrData2(); 

    echo '<pre>'; 
    print_r($arrLookupTypes); 
    echo '</pre>';      



// ---------------------------------------------------------------

// /** Test Dictionary **/

// include_once('dictionary.php');
// // print_r($objekte); 
// $table=isset($_REQUEST["table"])?$_REQUEST["table"]:''; 

// if ($table=='') {
//     echo 'Es wurde kein Tabellen-Objekt definiert.'; 
//     goto pagefoot;
// }

// echo $objekte[0].[""]; 

// $table_exists=in_array($table, $objekte); 

// // $table_exists=array_search($table, $objekte); 
// // $table_exists=array_key_exists($table, $objekte); 

// if (!array_key_exists($table, $objekte)) {
//     echo 'Das Objekt "'.$table.'" ist nicht definiert.'; 
//     goto pagefoot;
// }



// // falls $table noch tatsächlich als Tabellen-Name übergeben wird





// $objekt = $objekte[$table]; // $objekte definiert in dictionary.php

// echo '<pre>';
// print_r($objekt); 
// echo '</pre>';

// $viewname=$table; 
// $tablename=$objekt["tablename"]; 
// $printname=$objekt["printname"]; 
// $printname_plural=$objekt["printname_plural"]; 

// echo '<pre>';
// echo 'viewname: '.$viewname.PHP_EOL;
// echo 'tablename: '.$tablename.PHP_EOL;
// echo 'printname: '.$printname.PHP_EOL;
// echo 'printname_plural: '.$printname_plural.PHP_EOL;
// echo '</pre>';


pagefoot: 
include_once('foot.php');
?>
