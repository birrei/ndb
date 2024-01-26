<?php
include("dbconnect.php");

$table=$_GET['table'];
$query = 'SELECT * FROM '.$table.' order by ID desc'; // jede Tabelle hat ein ID-Feld

$res = mysqli_query($db, $query);
$data = $res->fetch_all(MYSQLI_ASSOC);
    
?>
<html xmlns='http://www.w3.org/1999/xhtml' xml:lang='en'>
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1"/>
   <title><?php echo $table; ?> (Ansicht)</title>
   <link rel='stylesheet' type='text/css' href='style.css'/>
</head>
<body>
<?php 

echo '<table>';
// Display table header
echo '<thead>';
echo '<tr>';
foreach ($res->fetch_fields() as $column) {
    echo '<th>'.htmlspecialchars($column->name).'</th>';
}
echo '</tr>';
echo '</thead>';
// If there is data then display each row
if ($data) {
    foreach ($data as $row) {
        echo '<tr>';
        foreach ($row as $cell) {
            echo '<td>'.htmlspecialchars($cell).'</td>';
        }
        echo '</tr>';
    }
} else {
    echo '<tr><td colspan="'.$res->field_count.'">No records in the table!</td></tr>';
}
echo '</table>';
echo '</body>';
echo '</html>';


?>
