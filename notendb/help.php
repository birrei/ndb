<?php 
include('head.php');
?>

<h2>Erfassung / Bearbeitung </h2>

<p> Formular "erfassen": Beim erstmaligen anlegen eines Datensatzes werden im 
    Formular nur die Haupt-Felder (z.B. Nummer, Name) abgefragt. Beim speichern werden diese Felder übernommen 
    und eine eindeutige ID gespeichert. Im Anschluss können im Dialog "Bearbeiten" noch (falls vorhanden) 
    noch weitere Eigenschaften erfasst werden. 
     
<p> Unterscheidung: 
    <br>* Untereinheiten (Sammung -> Musikstücke bzw. Musikstueck -> Sätze )
    <br>* Zuordnungen (z.B. Musikstück-> Besetzungen, Satz -> Stricharten) 

<h2>Suche</h2> 

<h3>Auswahlbox mit Mehrfach-auswahl</h3>
<p>Auswahl mehrerer Kategorie-Einträge: während der Auswahl STRG-Taste bzw. SHIFT-Taste gedrückt halten </p> 

<p> Hinweis zur Suchlogik: 
<br />Filtereinträge innerhalb einer Kategorie (innerhalb einer Auswahlbox) werden per ODER verknüpft. 
<br />Die Kombination von Kategorien erfolgt über UND-Verknüpfung. 

<br />Beispiel:
    <br />"Violine" ODER "Violine und Klavier" (2 Einträge in Auswahlbox markiert)
    <br/> UND 
    <br />Verwendungszweck: "Hochzeit" ODER "Fest"

<h3>Suchtext</h3>
Sucht einen Teil-Text innerhalb folgender Felder: 
<ul>
<li>Sammlung: Name, Bemerkung, Bestellnummer </li>
<li>Musikstück: Name, Opus, Bearbeiter, Aufführungsjahr </li>
<li>Satz: Name, Bemerkung</li>
</ul>
<?php 
include('foot.php');
?>

