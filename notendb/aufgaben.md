
# Aktuell

# In Planung: 
  * Musikstück / Epoche als Untertabelle 
  * Tabellen-Anpassung Musikstück > Epoche 
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

----

# Erledigt 
## Tabellen-Anpassung Musikstück / "Gattung"
Gattung als Untertabelle  
erledigt: 
 * Tabellen erstellen + Inhalte migrieren DDL: ..\sql\20240321_gattung.sql
 * Anpassen: View v_musikstueck, v_satz  
 * erstellen: cl_gattung.php 
 * erstellen: insert_gattung.php 
 * erstellen: edit_gattung.php 
 * anpassen: cl_musiksteuck.php: Spalte Gattung entfernen, Spalte GattungID ergänzen 
 * anpassen: edit_musikstueck.php 
 * Ergänzen: index.php, foot.php 
 * Erfassung / Bearbeitung testen 
 * Ergänzen/anpassen: Suchbox / Filter: search_musikstueck.php 
 * sammlung.Standort löschen: ALTER TABLE musikstueck DROP Gattung 