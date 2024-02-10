<?php 
include('head.php');
?>

<h1> Notendatenbank   </h1> 

<table>
<tr>
    <td><b>Verlag</b></td>
    <td><a href="show_table.php?table=verlag&sortcol=Name">Daten anzeigen</a></td>
    <td><a href="insert_verlag.php">Neu erfassen</a></td>
</tr>
<tr>
    <td><b>Sammlung</b></td>
    <td><a href="show_table.php?table=sammlung&sortcol=Name">Daten anzeigen</a></td>
    <td><a href="insert_sammlung.php">Neu erfassen</a></td>
</tr>



</table>



<?php 
include('foot.php');
?>

