

# Aktuell
## Tabellen-Anpassung am Beispiel "Gattung"
Gattung als Untertabelle  
offen: 
 * erstellen: cl_gattung.php 
 * anpassen: cl_musiksteuck.php: Spalte Gattung entfernen, Spalte GattungID ergänzen 
 * erstellen: insert_gattung.php 
 * erstellen: edit_gattung.php 
 * anpassen: edit_musikstueck.php 
 * anpassen: index.php -> insert_gattung.php in Auflistung ergäzen 
 * anpassen: foot.php -> insert_gattung.php in Auflistung ergänzen 
 * Ergänzen: Suchbox / Filter: search_musikstueck.php 
 * sammlung.Standort löschen ALTER TABLE musikstueck DROP Gattung 

erledigt: 
 * DDL: sql\20240321_gattung.sql
 * Anpassen: View v_musikstueck, v_satz  


# In Planung: 
  * Such-Seite: Ergebnistabelle erweitern
  * Such-Seite: Ergebnistabelle nach einzelnen Spalten sortierbar 
  * Such-Seite: weitere Suchfilter 
    * Spieldauer von bis
    * Komponist? 
    * Standort?  
    * .... 
  * Tests: 
    * Sammlung ohne Standort bzw. Standort "XXX"
    * Testviews Musikstück: Sammlung Name mit anzeigen 
  * Erfassung Satz:
    * Funktion: Feldinhalte aus anderem Satz des gleichen Musikstücks übernehmen (Checkbox "bekannte Eigenschaft übernehmen"?)   
    * Nummer automatisch besetzen
    * neues Feld: Aufführungsmaterial vorhanden
    * Feld: "Melodische Besonderheiten"
    * Feld: "Rhythmische Besonderheiten"
    * Feld: "Übung"
    * Löschfunktionen 

