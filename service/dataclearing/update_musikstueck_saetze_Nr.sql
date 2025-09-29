
/* Satz Nr anhand Seitenzahl (sofern in Name aufgeführt) updaten */


UPDATE satz SET Nr = SUBSTR(Name, INSTR(Name, 'S.') + 3, 2)  where MusikstueckID=2143;

select ID, Nr, Name, SUBSTR(Name, INSTR(Name, 'S.') + 3, 2) Seite from satz where MusikstueckID=2143;

select ID, Nr, Name, INSTR(Name, 'S.') Pos from satz where MusikstueckID=2143;