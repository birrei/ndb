<?php 
include('head.php');
?>

<h1> Notendatenbank   </h1> 

<p> Erfassung Ablauf: 
    
<table>

<tr>
    <td><b>Komponist</b></td>
    <td><a href="show_table.php?table=komponist&sortorder=DESC">Daten anzeigen</a></td>
    <td><a href="insert_komponist.php">Neu erfassen</a></td>
</tr>
<tr>
    <td><b>Verlag</b></td>
    <td><a href="show_table.php?table=verlag&sortorder=DESC">Daten anzeigen</a></td>
    <td><a href="insert_verlag.php">Neu erfassen</a></td>
</tr>
<tr>
    <td><b>Sammlung</b></td>
    <td><a href="show_table.php?table=sammlung&ssortorder=DESC">Daten anzeigen</a></td>
    <td><a href="insert_sammlung.php">Neu erfassen</a></td>
</tr>
<tr>
    <td><b>Musikstück</b></td>
    <td><a href="show_table.php?table=musikstueck&sortorder=DESC">Daten anzeigen</a></td>
    <td><a href="insert_musikstueck.php">Neu erfassen</a></td>
</tr>

<tr>
    <td><b>Besetzung</b></td>
    <td><a href="show_table.php?table=besetzung&sortorder=DESC">Daten anzeigen</a></td>
    <td>Erfassung Besetzung noch nicht verfügbar, bitte bei Bedarf phpMyAdmin verwenden. 
        <br />Die Zuordnung von Besetzungen zum Musikstück erfolgt über das Musikstueck-Formular</td>
</tr>

<tr>
    <td><b>Satz</b></td>
    <td><a href="show_table.php?table=satz&sortorder=DESC">Daten anzeigen</a></td>
    <td>Erfassung über Musikstück</td>
</tr>


</table>



<?php 
include('foot.php');
?>

