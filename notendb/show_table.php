<?php
include("dbconnect.php");
include('head.php');

$table=$_GET['table'];


$sortcol='';
if (isset($_GET['sortcol'])) {
    $sortcol=$_GET['sortcol'];
}

if (isset($_GET['sortorder'])) {
    $sortorder=$_GET['sortorder'];
}
else 
{
    $sortorder='asc';
}

$show_edit_link=false; // nur true setzen, wenn Tabelle eine Spalte ID besitzt und ein Bearbeitungsformular vorhanden ist 
if (isset($_GET['show_edit_link'])) {
    $show_edit_link=true;
}


$query = 'select * from '.$table.($sortcol!='' ?' order by '.$sortcol.' '.$sortorder:'');

// echo $query; 

$res = mysqli_query($db, $query);
$data = $res->fetch_all(MYSQLI_ASSOC);
    
// echo '<h2>Tabelle: '.$table.'</h2>';
echo '<table>';
// Display table header
echo '<thead>';
echo '<tr>';
foreach ($res->fetch_fields() as $column) {
    echo '<th>'.htmlspecialchars($column->name).'</th>';

}
echo ($show_edit_link?'<th>Aktion</th>':''); 
echo '</tr>';
echo '</thead>';

// If there is data then display each row
if ($data) {
    foreach ($data as $row) {
        // $ID=$row["ID"]; 
        echo '<tr>';
        foreach ($row as $cell) {
            echo '<td>'.htmlspecialchars($cell).'</td>';
        }
         echo ($show_edit_link?'<td><a href="edit_'.$table.'.php?ID='.$row["ID"].'">Bearbeiten</a></td>':''); 
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
