<?php
include("dbconnect.php");

$table='verlag'; 

$abfrage = 'SELECT ID, Name FROM '.$table.' order by ID desc';
$ergebnis = mysqli_query($db, $abfrage);

echo '<table>';
echo '<tr>
		<th>ID</th>
		<th>Name</th>
	</tr>';

while($row = mysqli_fetch_object($ergebnis))
{

	echo '<tr>'; 
		echo '<td>';  
		echo $row->ID;
		echo '</td>';  

		echo '<td>';   
		echo $row->Name;
		echo '</td>';   

	echo '</tr>';
}

echo '</table>';
?>
