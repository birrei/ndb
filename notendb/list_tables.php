<?php
include("dbconnect.php");
include('head.php');

$query = 'show tables';

$res = mysqli_query($db, $query);
$data = $res->fetch_all(MYSQLI_ASSOC);
    
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
            echo '<td><a href="show_table.php?table='.$cell.'&sortorder=desc" target="_blank">'.$cell.'</a></td>';
        }
        echo '</tr>';
    }
} else {
    echo '<tr><td colspan="'.$res->field_count.'">No records in the table!</td></tr>';
}
echo '</table>';
include('foot.php');

?>
