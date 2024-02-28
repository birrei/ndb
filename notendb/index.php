<?php 
include('head.php');
?>

<h1> Notendatenbank   </h1> 


<table>

<tr>
    <td><b>Sammlung</b></td>
    <td><a href="show_table2.php?table=sammlung">Daten anzeigen</a></td>
    <td><a href="insert_sammlung.php">Neu erfassen</a></td>
</tr>
<tr>
    <td><b>Musikstück</b></td>
    <td><a href="show_table2.php?table=musikstueck">Daten anzeigen</a></td>
    <td>Erfassung über Sammlung</td>
</tr>

<tr>
    <td><b>Satz</b></td>
    <td><a href="show_table2.php?table=satz">Daten anzeigen</a></td>
    <td>Erfassung über Musikstück</td>
</tr>
<tr>
    <td><b>Verlag</b></td>
    <td><a href="show_table2.php?table=verlag">Daten anzeigen</a></td>
    <td><a href="insert_verlag.php">Neu erfassen</a></td>
</tr>

<tr>
    <td><b>Komponist</b></td>
    <td><a href="show_table2.php?table=komponist">Daten anzeigen</a></td>
    <td><a href="insert_komponist.php">Neu erfassen</a></td>
</tr>

<tr>
    <td><b>Verwendungszweck</b></td>
    <td><a href="show_table2.php?table=verwendungszweck">Daten anzeigen</a></td>
    <td><a href="insert_verwendungszweck.php">Neu erfassen</a></td>
</tr>

<tr>
    <td><b>Besetzung</b></td>
    <td><a href="show_table2.php?table=besetzung">Daten anzeigen</a></td>
    <td><a href="insert_besetzung.php">Neu erfassen</a></td>
</tr>

<tr>
    <td><b>Stricharten</b></td>
    <td><a href="show_table2.php?table=strichart">Daten anzeigen</a></td>
    <td><a href="insert_strichart.php">Neu erfassen</a></td>
</tr>





</table>



<?php 
include('foot.php');
?>

