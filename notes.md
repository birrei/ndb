
### Thema "Suche", "Ansichten", "Filter" 

Der Wechsel der Ansicht startet die Suchfunktion(entsprechend Button "Suchen"). Steht ein Filter-Element sowohl in der ab- als auch in der angewählten Ansicht zur Verfügung, wird eine eventuell aktive Filter-Einstellung als wirksam übernommen - andernfalls wird die Filterung entfernt. 

Die Ansichten sind in Ansicht-Gruppen (Noten, Material, Schüler) eingeteilt, der Gruppen-Name steht in der Auswahlbox in Klammern hinter dem Ansicht-Namen. Innerhalb einer Ansicht-Gruppe steht für jede Ansicht der gleiche Satz von Filtern zur Verfügung. Zwischen den Ansicht-Gruppen können die zur Verfügung stehenden Filter abweichen. Einige Filter (z.B. Schüler, Status Schüler) stehen in jeder Ansicht-Gruppe zur Verfügung. 


Wird eine eine gruppierte Auflistung innerhalb einer Zelle gefiltert? 
  * Ja, wenn in der Zellen-Liste Unterelemente angezeigt werden. Beispiel: In einer Sammlung-Zeile werden die zugehörigen Musikstücke in einer Zelle gruppiert angezeigt. Wenn im Filter eine Besetzung gesucht wird, werden innerhalb der Zellen-internen Auflistung nur noch die passenden Musikstücke angezeigt. 
  * Nein, wenn in der Zellen-Liste (Attribut-) Zuordnungen angezeigt werden. Beispiel: In einer Musikstück-Zelle werden die verfügbaren Besetzungen angezeigt. Wenn über den Filter eine Besetzung gesucht wird, werden bei aktivem Filter innerhalb der gruppierten Auflistung alle für das Musikstück verfügbaren Besetzungen (also nicht nur die gesuchte Besetzung) angezeigt. 

Nachtrag: (*) Zelleninhalt mit Schüler-Auflistungen sind zwar technisch gesehen Zuordungen (mit Asoc-Tabelle), jedoch keine Attribut-(Eigenschaft-) Zuordnungen, stattdessen verknüpfte Unterelemente. ... Eine Sammlung von Besonderheiten gehört zu den Eigenschaften eines Satzes (wird nicht gefiltert), eine Sammlung von Schülern ist keine Sammlung von Eigenschaften sondern es sind (verknüpfte) Unterelemente. 

Fazit - Vorgehen bei Zellen-internen Auflistungen: 
* Unterelemente (direkte und verknüpte): Filtern 
* Eigeschafts-Sammlung: nicht filtern 



### Notizen für Doku: 

* Prio: "Funktion vor Design" (aktuell ist Layout nur so mittel, Prio ist korrektes funktionieren) 

* Erfassung: Zuordnung Einteilungen: 
    * Einfach-Zuordnungen (z.B. Sammlung > Verlag, ein Notenheft kann nur einen Verlag haben)
    * Feste Mehrfach-Zuordnungen (z.B. Besetzungen) (vorgegeben, fest im Formular verankert)
    * Konfigurierbare Mehrfach-Zuordnungen ("Besonderheiten")

* Arten von Tests 
  * Technische Tests: von Entwicklung/Entwickler definiert (z.B. zu jeder Sammlung sollte es mind. 1 Musikstück geben). Für jeden Test wird  eine View angelegt (s. notendb/views, views "v3_test_*.sql"). Die Abfragen auf die Views werden in "Tests" (tests.php) hinterlegt.  
  * Fachliche Tests: werden von Anwender / Nutzer / Auftraggeber definiert.  
  (Beispiel: Es sollte unter bestimmten Bedingungen mind. 1 Griffart zugeordnet sein). Diese Tests werden in Tabelle "Abfragen" hinterlegt. 

* Löschbarkeit in Unterformularen: 
  1) mit Schnell-Löschmöglichkeit: 1: Gespeichert sind nur Verknüpfungsinformationen (die leicht wiederhergestellt werden können). 
  2) ohne Schnell-Löschmöglichkeit: es gibt Zusätzliche (Text-Datenfelder, deren Inhalt mit einer Löschung verloren geht)    

* Suche: Breite Suchfilter-Liste: = Breite des längsten Eintrags innerhalb einer Auswahl-Box (im akt. Projekt: Besetzung- Einträge) (nicht vermeidbar, da ansonsten Teile von Einträgen nicht sichtbar bzw. gleich beginnende Einträge nicht unterscheidbar sind )

* Schüler: Nur eine Name-Feld, aus Datenschutzgründen keine vollständigen Namen (weil: Nur für Lehrer, der weiß wer das ist) Keine Schülerverwaltung im umfassenden Sinne, nur Daten die für Unterichts-Praxis erforderlich sind.  

* Besonderheiten können für Sammlungen oder Sätze erfasst werden. Jede Besonderheit wird einem Besonderheit-Typ untergeordnet. Der Typ ist für die Erfassung einer Besonderheit am Satz / an der Sammlung nicht zwinged erforderlich -  jede Besonderheit hat  (über Typen hinweg) eine eigene eindeutige ID. 






