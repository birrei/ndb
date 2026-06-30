
drop TABLE `schuljahr`; 

CREATE TABLE `schuljahr` (
    `ID` INT AUTO_INCREMENT,
    `Bezeichnung` VARCHAR(50) NOT NULL,
    `Datum_Start` DATE NOT NULL,
    `Datum_Ende` DATE NOT NULL,
    PRIMARY KEY (`ID`)
)
;

INSERT INTO `schuljahr` (`Bezeichnung`, `Datum_Start`, `Datum_Ende`) VALUES 
('Schuljahr 2023/2024', '2023-08-01', '2024-07-31'),
('Schuljahr 2024/2025', '2024-08-01', '2025-07-31'),
('Schuljahr 2025/2026', '2025-08-01', '2026-07-31'),
('Schuljahr 2026/2027', '2026-08-01', '2027-07-31'),
('Schuljahr 2027/2028', '2027-08-01', '2028-07-31'),
('Schuljahr 2028/2029', '2028-08-01', '2029-07-31'),
('Schuljahr 2029/2030', '2029-08-01', '2030-07-31')
;

select * from schuljahr; 


ALTER TABLE schuljahr  ADD Eingelesen  BOOLEAN default false; -- real: Tinyint(1)