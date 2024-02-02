<?php 
include('head.php');
?>




<h1> Notendatenbank Start  </h1> 

<p> IN ARBEIT! </p> 



<h2> Erfassung  </h2> 


<table> 
<tr>
        <td>Komponist(en) schon vorhanden? </td>
        <td><a href="show_table.php?table=komponist&sortcol=Nachname&sortorder=ASC" target="_blank">Komponisten anzeigen</a></td> 
        <td>Komponist ergänzen XXX </td> 

</tr> 

<p> weiteres folgt ... 


</table>


<h2> Tabellenliste </h2>
<p> Anzeige der DAten in neuem Fenster, nach neuester Erfassung abwärts </p> 

<table> 
<tr>
        <td>Komponisten</td>
        <td><a href="show_table.php?table=komponist&sortorder=desc" target="_blank">Daten anzeigen</a></td> 
        
</tr> 
<tr>
        <td>Verlage</td>
        <td><a href="show_table.php?table=verlag&sortorder=desc" target="_blank">Daten anzeigen</a></td> 
      
</tr> 

<tr>
        <td>Sammlungen</td>
        <td><a href="show_table.php?table=sammlung&sortorder=desc" target="_blank">Daten anzeigen</a></td> 
      
</tr> 

<tr>
        <td>Musikstuecke</td>
        <td><a href="show_table.php?table=musikstueck&sortorder=desc" target="_blank">Daten anzeigen</a></td> 
      
</tr> 

<tr>
        <td>Sätze</td>
        <td><a href="show_table.php?table=satz&sortorder=desc" target="_blank">Daten anzeigen</a></td> 
              
</tr> 

<tr>
        <td>Musikstuecke (Sicht)</td>
        <td><a href="show_table.php?table=musikstuecke_v&sortorder=desc" target="_blank">Daten anzeigen</a></td> 
    
</tr> 
<tr>
        <td>Sätze (Sicht)</td>
        <td><a href="show_table.php?table=saetze_v&sortorder=desc" target="_blank">Daten anzeigen</a></td> 
          
</tr> 


</table>

<br>


<?php 

include('foot.php');
?>

