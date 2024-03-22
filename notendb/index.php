<?php 
include('head.php');
?>

<h1> Notendatenbank   </h1> 


<table>
<tr>
    <td><b>Sammlung</b></td>
    <td><a href="show_table2.php?table=v_sammlung" target="_blank">Daten anzeigen</a></td>
    <td><a href="insert_sammlung.php" target="_blank" >Neu erfassen</a></td>
</tr>
<tr>
    <td><b>Musikstück</b></td>
    <td><a href="show_table2.php?table=v_musikstueck" target="_blank">Daten anzeigen</a></td>
    <td>Erfassung über Sammlung</td>
</tr>

<tr>
    <td><b>Satz</b></td>
    <td><a href="show_table2.php?table=v_satz" target="_blank">Daten anzeigen</a></td>
    <td>Erfassung über Musikstück</td>
</tr>

<tr>
    <td><b>Verlag</b></td>
    <td><a href="show_table2.php?table=verlag" target="_blank">Daten anzeigen</a></td>
    <td><a href="insert_verlag.php" target="_blank">Neu erfassen</a></td>
</tr>
<tr>
    <td><b>Standort</b></td>
    <td><a href="show_table2.php?table=standort" target="_blank">Daten anzeigen</a></td>
    <td><a href="insert_standort.php" target="_blank">Neu erfassen</a></td>
</tr>
<tr>
    <td><b>Komponist</b></td>
    <td><a href="show_table2.php?table=komponist" target="_blank">Daten anzeigen</a></td>
    <td><a href="insert_komponist.php" target="_blank">Neu erfassen</a></td>
</tr>

<tr>
    <td><b>Verwendungszweck</b></td>
    <td><a href="show_table2.php?table=verwendungszweck" target="_blank">Daten anzeigen</a></td>
    <td><a href="insert_verwendungszweck.php" target="_blank">Neu erfassen</a></td>
</tr>

<tr>
    <td><b>Besetzung</b></td>
    <td><a href="show_table2.php?table=besetzung" target="_blank">Daten anzeigen</a></td>
    <td><a href="insert_besetzung.php" target="_blank">Neu erfassen</a></td>
</tr>
<tr>
    <td><b>Gattung</b></td>
    <td><a href="show_table2.php?table=gattung" target="_blank">Daten anzeigen</a></td>
    <td><a href="insert_gattung.php" target="_blank">Neu erfassen</a></td>
</tr>

<tr>
    <td><b>Stricharten</b></td>
    <td><a href="show_table2.php?table=strichart" target="_blank">Daten anzeigen</a></td>
    <td><a href="insert_strichart.php" target="_blank">Neu erfassen</a></td>
</tr>








</table>



<?php 
include('foot.php');
?>

