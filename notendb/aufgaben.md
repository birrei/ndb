# in Arbeit
Satz > Notenwerte 

erledigt 28.03.2024: 
  * Tabellen erstellen + Inhalte migrieren : 20240326_satz_notenwerte.sql
  * Anpassen: View v_musikstueck, v_satz  
  * erstellen: cl_notenwert.php
  * erstellen: insert_notenwert.php
  * anpassen: cl_satz: function add_notenwert 
  * anpassen: cl_satz: function print_table_notenwerte 
  * erstellen: edit_satz_add_notenwert.php (verbesserte Variante!)
  * erstellen: edit_satz_list_notenwerte.php  (verbesserte Variante!)
    

<!-- 
 * erstellen: cl_epoche.php 
 * erstellen: insert_epoche.php 
 * erstellen: edit_epoche.php 
 * anpassen: cl_musiksteuck.php: Epoche -> EpocheID 
 * anpassen: edit_musikstueck.php : Epoche -> EpocheID 
 * Ergänzen: index.php, foot.php 
 * Erfassung / Bearbeitung / Abrufe testen 
 * Ergänzen/anpassen: Suchbox / Filter: search_musikstueck.php 
 * Feld musikstueck.Epoche löschen: ALTER TABLE musikstueck DROP Epoche 
 * View v_tmp_Epochen aus ddl_views.sql entfernen, View löschen  
   * Produktivnahme: 
  * 20240324_epoche.sql
  * Dateien auf FTP-Server erneuern 
  * ddl_views*- ausführen
  * Test Erfassung 
  * Test Bearbeitung 
  * Test Suche 
  * Feld musikstueck.Epoche löschen: ALTER TABLE musikstueck DROP Epoche 
  * drop view v_tmp_Epochen
   -->



----

# In Planung: 
  * Erfassung Satz:
    * Auswahl 
    * Nummer automatisch besetzen
    * neues Feld: Aufführungsmaterial vorhanden
    * Feld: "Melodische Besonderheiten"
    * Feld: "Rhythmische Besonderheiten"
    * Feld: "Übung"
    * Löschfunktionen 
    * Funktion: Feldinhalte aus anderem Satz des gleichen Musikstücks übernehmen (Checkbox "bekannte Eigenschaft übernehmen"?) 


  * Suche: gespeicherte Suchen 
  * Such-Seite: weitere Suchfilter 
    * Satz: 
          Tonart 
          Taktart
          , Tempobezeichnung
          , Schwierigkeitsgrad
          , Lagen 
          , Erprobt 
          , Notenwerte

  * Suche: Validierung von manuell eingegeben Such-Parametern (z.B: SpieldauerBis > SpieldauerBis ect.)
  * Insert-Formulare: Problem mit mehrfach-Ausführung bei Browser-Aktualisierung. Evt. Ablauf ändern  
  * Such-Seite: Ergebnistabelle erweitern
  * Such-Seite: Ergebnistabelle nach einzelnen Spalten sortierbar 
  * Suchseite: Optimierung per AJAX 



----

# Erledigt 



Tabellen-Anpassung Musikstück / "Gattung"
 * Tabellen erstellen + Inhalte migrieren DDL: ..\sql\20240321_gattung.sql
 * Anpassen: View v_musikstueck, v_satz  
 * erstellen: cl_gattung.php 
 * erstellen: insert_gattung.php 
 * erstellen: edit_gattung.php 
 * anpassen: cl_musiksteuck.php: Spalte Epoche entfernen, Spalte GattungID ergänzen 
 * anpassen: edit_musikstueck.php 
 * Ergänzen: index.php, foot.php 
 * Erfassung / Bearbeitung testen 
 * Ergänzen/anpassen: Suchbox / Filter: search_musikstueck.php 
 * Feld musikstueck.Gattung löschen: ALTER TABLE musikstueck DROP Epoche
 * View löschen: drop view v_tmp_Gattungen

Tabellen-Anpassung Musikstück / "Epoche"  
 * Tabellen erstellen + Inhalte migrieren DDL: ..\sql\20240324_epoche.sql
 * Anpassen: View v_musikstueck, v_satz  
 * erstellen: cl_epoche.php 
 * erstellen: insert_epoche.php 
 * erstellen: edit_epoche.php 
 * anpassen: cl_musiksteuck.php: Epoche -> EpocheID 
 * anpassen: edit_musikstueck.php : Epoche -> EpocheID 
 * Ergänzen: index.php, foot.php 
 * Erfassung / Bearbeitung / Abrufe testen 
 * Ergänzen/anpassen: Suchbox / Filter: search_musikstueck.php 
 * Feld musikstueck.Epoche löschen: ALTER TABLE musikstueck DROP Epoche 
 * View v_tmp_Epochen aus ddl_views.sql entfernen, View löschen  
   * Produktivnahme: 
  * 20240324_epoche.sql
  * Dateien auf FTP-Server erneuern 
  * ddl_views*- ausführen
  * Test Erfassung 
  * Test Bearbeitung 
  * Test Suche 
  * Feld musikstueck.Epoche löschen: ALTER TABLE musikstueck DROP Epoche 
  * drop view v_tmp_Epochen


Sonstiges 26.03.204  

* Such-Seite: Filter Spieldauer von bis   
* Anpassung Erfassung: Musikstueck.Nummer, Satz.Nr + jeweils Name - Vergabe-Automatismus 
* Anpassung Erfassung: edit_sammlung_add_musikstueck.php: default-Wert 0 

