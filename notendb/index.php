<?php 
include('head.php');
?>

<style>
table.start, td.start {
  border-style: solid;
  border-color: lightgray;
  border-collapse: collapse;
  padding-right: 10px;     
}
h1 {
    background-color: lightblue; 
}
h3 {
    background-color: greenyellow; 
    margin-top: 0px; 

}
</style>

<h1> Notendatenbank   </h1>

<table class="start">
<tr> 
    <td class="start"><h3>Sammlungen</h3></td>
    <td class="start">
              <a href="show_table2.php?table=v_sammlung&sortcol=ID&sortorder=DESC&show_filter">Sammlungen</a> | 
              <a href="edit_sammlung.php?title=Sammlung&option=insert">Neu erfassen</a> 
            </td>
           </tr>    


      <tr> <td class="start"> <h3>Sammlung Stammdaten</h3></td> 
      <td class="start">
                <a href="show_table2.php?table=verlag&sortcol=Name">Verlage</a> |  
                <a href="show_table2.php?table=standort&sortcol=Name">Standorte</a> | 
                <a href="show_table2.php?table=linktype&sortcol=Name">Link-Typen</a> 

              </td>
            </tr>

        <tr> <td class="start"> <h3>Musikstück Stammdaten</h3> </td> 
      
        <td class="start">
              <a href="show_table2.php?table=v_komponist&sortcol=Name">Komponisten</a> | 
              <a href="show_table2.php?table=besetzung&sortcol=Name">Besetzungen</a> | 
              <a href="show_table2.php?table=verwendungszweck&sortcol=Name">Verwendungszwecke</a> | 
              <a href="show_table2.php?table=gattung&sortcol=Name">Gattungen</a> | 
              <a href="show_table2.php?table=epoche&sortcol=Name">Epochen</a> 

            </td>
      </tr>



        <tr> <td class="start"> <h3>Satz Stammdaten</h3> </td>
        <td class="start">
            <a href="show_table2.php?table=erprobt&sortcol=Name">Erprobt-Eigenschaften</a> | 
            <a href="show_table2.php?table=schwierigkeitsgrad&sortcol=Name">Schwierigkeitsgrade</a> | 
            <a href="show_table2.php?table=instrument&sortcol=Name">Instrumente</a> | 
            <!-- <a href="show_table2.php?table=v_lookup&sortcol=LookupTypeName,Name">Besonderheiten</a> |  -->
            <a href="show_table2.php?table=v_besonderheiten&sortcol=Name">Besonderheiten</a> | 
            <!-- <a href="show_table2.php?table=lookup_type&sortcol=Name">Besonderheit Typen</a>  -->
            <a href="show_table2.php?table=v_besonderheittypen&sortcol=Name">Besonderheit Typen</a> 
            </td>
        </tr>

        <tr> <td class="start"> <h3>Material</h3> </td> 
        <td class="start">
            <a href="show_table2.php?table=v_material&sortcol=Name">Material</a> |    
            <a href="show_table2.php?table=materialtyp&sortcol=Name">Materialtypen</a>
            </td>
        </tr>

        <tr> <td class="start"> <h3>Schüler</h3> </td>
        <td class="start">
            <a href="show_table2.php?table=v_schueler&sortcol=Name">Schüler</a> |               
            <a href="show_table2.php?table=status&sortcol=Name">Status</a> | 
            BETA: <a href="show_table2.php?table=v_uebung&sortcol=ID&sortorder=DESC">Übung</a> 
            <a href="show_table2.php?table=uebungtyp&sortcol=Name">Übung Typ</a> 
            </td>

      </tr>       


        <tr> <td class="start"> <h3>Tests und Info-Sichten</h3> </td> 
        <td class="start">
            <a href="tests.php?title=Tests" tabindex="-1">Tests</a> |   
            <a href="show_table2.php?table=v2_info_Tempobezeichnungen&sortcol=Tempobezeichnung">Verwendete Tempobezeichnungen</a> | 
            <a href="show_table2.php?table=v2_info_Tonarten&sortcol=Tonart">Verwendete Tonarten</a> | 
            <a href="show_table2.php?table=v2_info_Taktarten&sortcol=Taktart">Verwendete Taktarten</a> | 
            <a href="show_table2.php?table=v2_info_Spieldauern&sortcol=Spieldauer">Verwendete Spieldauern</a> 
            </td>
      
      </tr>        
   

        <tr> <td class="start"> <h3>Abfragen</h3> </td> 
        <td class="start">    
            <a href="show_table2.php?table=v_abfrage&sortcol=Name&add_link_show">Abfragen</a> | 
            <a href="show_table2.php?table=abfragetyp&sortcol=Name">Abfrage-Typen</a> 
            </td>
      </tr>           



        <tr> 
          <td class="start"> <h3>Repository</h3> </td> 
          <td class="start">    
            <a href="https://github.com/birrei/ndb/tree/main" tabindex="-1" target="_blank">GitHub</a> 
            <a href="https://github.com/birrei/ndb/blob/main/changelog.md" tabindex="-1" target="_blank">Changelog</a>
            </td>
      </tr>            


</table>

<?php 
include('foot.php');
include('class.Log.php'); 
$Loginfo = new Log(); 
$Loginfo->printUserName(); 
 
?>

