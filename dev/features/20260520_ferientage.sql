drop table ferien; 

CREATE TABLE ferien (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Bezeichnung VARCHAR(100) NOT NULL,
    Datum_Start DATE NOT NULL,
    Datum_Ende DATE NOT NULL,
    Bundesland VARCHAR(50), 
    SchuljahrID int 
)
;


/* Befüllung: 
 * Gemini Prompt: 

 Ich benötige ein SQL Insert Statment für meine Ferientabelle "ferien". 
 Die Befüllung soll die in Tabelle "Schuljahr" abgebildeten Zeiträume umfassen. 
 Das Bundesland soll Baden-Württemberg sein. 
 
 Die Tabelle "ferien" hat folgende Felder: 
 - Bezeichnung (= Bezeichnung der Ferien) 
 - Datum_Start
 - Datum_Ende 
 - Bundesland 
 - SchuljahrID (ID aus Tabelle "Schuljahr" (*)) 
  
  
(*) Tabelle "Schuljahr": 
----------------------------------------------
ID  Schuljahr Startdatum 			Enddatum
----------------------------------------------
1	Schuljahr 2023/2024	2023-08-01	2024-07-31
2	Schuljahr 2024/2025	2024-08-01	2025-07-31
3	Schuljahr 2025/2026	2025-08-01	2026-07-31

 
https://share.google/aimode/2n7yFbjRPd6dyRkV6 


 * */





INSERT INTO ferien (Bezeichnung, Datum_Start, Datum_Ende, Bundesland, SchuljahrID) VALUES
-- Schuljahr 2023/2024 (SchuljahrID = 1)
('Herbstferien', '2023-10-30', '2023-11-03', 'Baden-Württemberg', 1),
('Weihnachtsferien', '2023-12-23', '2024-01-05', 'Baden-Württemberg', 1),
('Osterferien', '2024-03-23', '2024-04-05', 'Baden-Württemberg', 1),
('Pfingstferien', '2024-05-21', '2024-05-31', 'Baden-Württemberg', 1),
('Sommerferien', '2024-07-25', '2024-09-07', 'Baden-Württemberg', 1),

-- Schuljahr 2024/2025 (SchuljahrID = 2)
('Herbstferien', '2024-10-28', '2024-10-31', 'Baden-Württemberg', 2),
('Weihnachtsferien', '2024-12-23', '2025-01-04', 'Baden-Württemberg', 2),
('Osterferien', '2025-04-14', '2025-04-26', 'Baden-Württemberg', 2),
('Pfingstferien', '2025-06-10', '2025-06-20', 'Baden-Württemberg', 2),
('Sommerferien', '2025-07-31', '2025-09-13', 'Baden-Württemberg', 2),

-- Schuljahr 2025/2026 (SchuljahrID = 3)
('Herbstferien', '2025-10-27', '2025-10-31', 'Baden-Württemberg', 3),
('Weihnachtsferien', '2025-12-22', '2026-01-05', 'Baden-Württemberg', 3),
('Osterferien', '2026-03-30', '2026-04-11', 'Baden-Württemberg', 3),
('Pfingstferien', '2026-05-26', '2026-06-05', 'Baden-Württemberg', 3),
('Sommerferien', '2026-07-30', '2026-09-12', 'Baden-Württemberg', 3);




select * from ferien 


--

select s.ID 
	, f.Bezeichnung 
	, f.Datum_Start  as `Ferien Start` 
	, f.Datum_Ende  as `Ferien Ende` 
	, s.Bezeichnung as Schuljahr 
	, s.Datum_Start  as `Schuljahr Start` 
	, s.Datum_Ende  as `Schuljahr Ende` 
from schuljahr s 
	inner join ferien f on f.SchuljahrID = s.ID 
where s.Bezeichnung ='Schuljahr 2025/2026'