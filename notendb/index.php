<?php 
include('head.php');
?>

<h1> Notendatenbank   </h1> 


<table>

<tr>
    <td><b>Sammlung</b></td>
    <td><a href="show_table2.php?table=sammlung&sortcol=Name" target="_blank">Daten anzeigen</a></td>
    <td><a href="insert_sammlung.php" target="_blank">Neu erfassen</a></td>
</tr>
<tr>
    <td><b>Musikstück</b></td>
    <td><a href="show_table2.php?table=musikstueck&sortcol=Name" target="_blank">Daten anzeigen</a></td>
    <td>Erfassung über Sammlung</td>
</tr>

<tr>
    <td><b>Satz</b></td>
    <td><a href="show_table2.php?table=satz&sortcol=MusikstueckID" target="_blank">Daten anzeigen</a></td>
    <td>Erfassung über Musikstück</td>
</tr>
<tr>
    <td><b>Verlag</b></td>
    <td><a href="show_table2.php?table=verlag&sortcol=Name" target="_blank">Daten anzeigen</a></td>
    <td><a href="insert_verlag.php" target="_blank">Neu erfassen</a></td>
</tr>

<tr>
    <td><b>Komponist</b></td>
    <td><a href="show_table2.php?table=komponist&sortcol=Nachname,Vorname" target="_blank">Daten anzeigen</a></td>
    <td><a href="insert_komponist.php" target="_blank">Neu erfassen</a></td>
</tr>

<tr>
    <td><b>Verwendungszweck</b></td>
    <td><a href="show_table2.php?table=verwendungszweck&sortcol=Name" target="_blank">Daten anzeigen</a></td>
    <td><a href="insert_verwendungszweck.php" target="_blank">Neu erfassen</a></td>
</tr>

<tr>
    <td><b>Besetzung</b></td>
    <td><a href="show_table2.php?table=besetzung&sortcol=Name" target="_blank">Daten anzeigen</a></td>
    <td><a href="insert_besetzung.php" target="_blank">Neu erfassen</a></td>
</tr>

<tr>
    <td><b>Stricharten</b></td>
    <td><a href="show_table2.php?table=strichart&sortcol=Name" target="_blank">Daten anzeigen</a></td>
    <td><a href="insert_strichart.php" target="_blank">Neu erfassen</a></td>
</tr>





</table>



<?php 
include('foot.php');
?>

