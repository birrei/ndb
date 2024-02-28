<?php
include("dbconnect_pdo.php");
include('head.php');
include('snippets.php');

/* nur für Tabellen mit ID-Spalte verwenden */ 

$table=$_GET['table'];

// $query = 'SELECT * FROM '.$table.' ORDER by ID DESC';
$query = 'SELECT * FROM '.$table;

$select = $db->prepare($query);

try {
    $select->execute(); 
    $html_table= get_html_table($select, $table, true); // s. snippets.php
    echo $html_table;  
}
catch (PDOException $e) {
    echo '<p>Ein Fehler ist aufgetreten.</p>'; 
    echo '<p>'.$e->getMessage().'</p>';
    echo '<p>debugDumpParams: '.$select->debugDumpParams(); 
}

include('foot.php');
?>
