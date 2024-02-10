<?php
include("dbconnect.php");
include('head.php');

$table=$_GET['table'];

if (isset($_GET['sortcol'])) {
    $sortcol=$_GET['sortcol'];
}
else {
    $sortcol='ID';
}

if (isset($_GET['sortorder'])) {
    $sortorder=$_GET['sortorder'];
}
else 
{
    $sortorder='asc';
}

$query = 'select * from '.$table.' order by '.$sortcol.' '.$sortorder;

// echo $query; 

$res = mysqli_query($db, $query);
$data = $res->fetch_all(MYSQLI_ASSOC);
    
echo '<h2>Tabelle: '.$table.'</h2>';
echo '<table>';
// Display table header
echo '<thead>';
echo '<tr>';
foreach ($res->fetch_fields() as $column) {
    echo '<th>'.htmlspecialchars($column->name).'</th>';
}
echo '<th>Aktion</th>';
echo '</tr>';
echo '</thead>';
// If there is data then display each row
if ($data) {
    foreach ($data as $row) {
        $ID=$row["ID"]; 
        echo '<tr>';
        foreach ($row as $cell) {
            echo '<td>'.htmlspecialchars($cell).'</td>';
        }
        echo '<td><a href="edit_'.$table.'.php?ID='.$ID.'">Bearbeiten</a></td>';
        echo '</tr>';
    }
} else {
    echo '<tr><td colspan="'.$res->field_count.'">No records in the table!</td></tr>';
}
echo '</table>';
echo '</body>';
echo '</html>';

include('foot.php');
?>
