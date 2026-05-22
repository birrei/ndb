
/*
 * 
 

DROP TABLE feiertag; 
CREATE TABLE feiertag (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Bezeichnung VARCHAR(100) NOT NULL,
    Datum DATE NOT NULL,
    Bundesland VARCHAR(50), 
    Bemerkung VARCHAR(50),  
    SchuljahrID int 
)
;



Ich benötige ein SQL Insert Statement für meine Tabelle "feiertag". 
Sie soll die Feiertage des Bundeslandes Baden-Württemberg für die Schuljahre, die in Tabelle "Schuljahr" (*) enthalten sind, vollständig umfassen. 
 
Die Tabelle "feiertag" hat folgende Felder: 
- Bezeichnung (= Bezeichnung des Feiertages) 
- Datum
- Bundesland 
- Bemerkung (falls Hinweise zum Feiertag verfügbar) 
- SchuljahrID (ID aus Tabelle "Schuljahr" (*)) 
 
 
(*) Tabelle "Schuljahr": 
----------------------------------------------
ID  Schuljahr 	Startdatum Enddatum
----------------------------------------------
1	Schuljahr 2023/2024	2023-08-01	2024-07-31
2	Schuljahr 2024/2025	2024-08-01	2025-07-31
3	Schuljahr 2025/2026	2025-08-01	2026-07-31


 
 * 
 * */


INSERT INTO feiertag (Bezeichnung, Datum, Bundesland, Bemerkung, SchuljahrID) VALUES
-- Schuljahr 2023/2024 (ID: 1)
('Tag der Deutschen Einheit', '2023-10-03', 'Baden-Württemberg', NULL, 1),
('Allerheiligen', '2023-11-01', 'Baden-Württemberg', NULL, 1),
('1. Weihnachtstag', '2023-12-25', 'Baden-Württemberg', NULL, 1),
('2. Weihnachtstag', '2023-12-26', 'Baden-Württemberg', NULL, 1),
('Neujahr', '2024-01-01', 'Baden-Württemberg', NULL, 1),
('Heilige Drei Könige', '2024-01-06', 'Baden-Württemberg', NULL, 1),
('Karfreitag', '2024-03-29', 'Baden-Württemberg', NULL, 1),
('Ostermontag', '2024-04-01', 'Baden-Württemberg', NULL, 1),
('Tag der Arbeit', '2024-05-01', 'Baden-Württemberg', NULL, 1),
('Christi Himmelfahrt', '2024-05-09', 'Baden-Württemberg', NULL, 1),
('Pfingstmontag', '2024-05-20', 'Baden-Württemberg', NULL, 1),
('Fronleichnam', '2024-05-30', 'Baden-Württemberg', NULL, 1),
-- Schuljahr 2024/2025 (ID: 2)
('Tag der Deutschen Einheit', '2024-10-03', 'Baden-Württemberg', NULL, 2),
('Allerheiligen', '2024-11-01', 'Baden-Württemberg', NULL, 2),
('1. Weihnachtstag', '2024-12-25', 'Baden-Württemberg', NULL, 2),
('2. Weihnachtstag', '2024-12-26', 'Baden-Württemberg', NULL, 2),
('Neujahr', '2025-01-01', 'Baden-Württemberg', NULL, 2),
('Heilige Drei Könige', '2025-01-06', 'Baden-Württemberg', NULL, 2),
('Karfreitag', '2025-04-18', 'Baden-Württemberg', NULL, 2),
('Ostermontag', '2025-04-21', 'Baden-Württemberg', NULL, 2),
('Tag der Arbeit', '2025-05-01', 'Baden-Württemberg', NULL, 2),
('Christi Himmelfahrt', '2025-05-29', 'Baden-Württemberg', NULL, 2),
('Pfingstmontag', '2025-06-09', 'Baden-Württemberg', NULL, 2),
('Fronleichnam', '2025-06-19', 'Baden-Württemberg', NULL, 2),
-- Schuljahr 2025/2026 (ID: 3)
('Tag der Deutschen Einheit', '2025-10-03', 'Baden-Württemberg', NULL, 3),
('Allerheiligen', '2025-11-01', 'Baden-Württemberg', NULL, 3),
('1. Weihnachtstag', '2025-12-25', 'Baden-Württemberg', NULL, 3),
('2. Weihnachtstag', '2025-12-26', 'Baden-Württemberg', NULL, 3),
('Neujahr', '2026-01-01', 'Baden-Württemberg', NULL, 3),
('Heilige Drei Könige', '2026-01-06', 'Baden-Württemberg', NULL, 3),
('Karfreitag', '2026-04-03', 'Baden-Württemberg', NULL, 3),
('Ostermontag', '2026-04-06', 'Baden-Württemberg', NULL, 3),
('Tag der Arbeit', '2026-05-01', 'Baden-Württemberg', NULL, 3),
('Christi Himmelfahrt', '2026-05-14', 'Baden-Württemberg', NULL, 3),
('Pfingstmontag', '2026-05-25', 'Baden-Württemberg', NULL, 3),
('Fronleichnam', '2026-06-04', 'Baden-Württemberg', NULL, 3), 
('Tag der Deutschen Einheit', '2026-10-03', 'Baden-Württemberg', NULL, 4),
('Allerheiligen', '2026-11-01', 'Baden-Württemberg', NULL, 4),
('1. Weihnachtstag', '2026-12-25', 'Baden-Württemberg', NULL, 4),
('2. Weihnachtstag', '2026-12-26', 'Baden-Württemberg', NULL, 4),
('Neujahr', '2027-01-01', 'Baden-Württemberg', NULL, 4),
('Heilige Drei Könige', '2027-01-06', 'Baden-Württemberg', NULL, 4),
('Karfreitag', '2027-03-26', 'Baden-Württemberg', NULL, 4),
('Ostermontag', '2027-03-29', 'Baden-Württemberg', NULL, 4),
('Tag der Arbeit', '2027-05-01', 'Baden-Württemberg', NULL, 4),
('Christi Himmelfahrt', '2027-05-06', 'Baden-Württemberg', NULL, 4),
('Pfingstmontag', '2027-05-17', 'Baden-Württemberg', NULL, 4),
('Fronleichnam', '2027-05-27', 'Baden-Württemberg', NULL, 4)

;


select * from feiertag order by datum 


/*

1. Datenbasis prüfen
Die Termine basieren auf den offiziellen beweglichen und festen Feiertagen für Baden-Württemberg. 
Feiertage im August (wie Mariä Himmelfahrt, das in BW nur regional gilt) wurden weggelassen, da sie nicht landesweit gesetzlich verankert sind.

2. Zuordnung kontrollieren
Feste Feiertage: 
Tag der Deutschen Einheit (03.10.), Allerheiligen (01.11.), Weihnachten (25./26.12.), Neujahr (01.01.), Heilige Drei Könige (06.01.), 
Tag der Arbeit (01.05.).
Bewegliche Feiertage: 
Vom Osterdatum abhängige Tage (Karfreitag, Ostermontag, Christi Himmelfahrt, Pfingstmontag, Fronleichnam) wurden für jedes Jahr präzise berechnet und der passenden SchuljahrID zugewiesen.

Wichtige Datumsprüfungen für diesen Zeitraum:Ostern 2027 liegt sehr früh, 
weshalb Karfreitag auf den 26. März 2027 und Ostermontag auf den 29. März 2027 fällt.
Durch das frühe Osterfest rücken auch die abhängigen Feiertage weit nach vorne: 
Christi Himmelfahrt ist bereits am 6. Mai 2027 und Fronleichnam am 27. Mai 2027.
Falls die SchuljahrID für das Schuljahr 2026/2027 in Ihrer Datenbank nicht 4 lautet,
passen Sie den letzten Wert in den Klammern einfach an Ihre tatsächliche ID an.


 * */


select s.ID 
	, f.Bezeichnung 
	, f.Datum 
	, s.Bezeichnung as Schuljahr 
from schuljahr s 
	inner join feiertag f on f.SchuljahrID = s.ID 
where 1=1 
order by f.Datum desc 

