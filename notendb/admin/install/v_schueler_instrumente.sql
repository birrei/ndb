CREATE OR REPLACE VIEW v_schueler_instrumente as 
select SchuelerID
    , group_concat(
        IF(Schwierigkeitsgrade!='', 
        concat(Instrument, ': ', Schwierigkeitsgrade), 
        Instrument
        ) 
        order by Instrument, Schwierigkeitsgrade separator ', ') Instrumente  
from (
    select schueler_schwierigkeitsgrad.SchuelerID
        , schueler_schwierigkeitsgrad.InstrumentID
        , instrument.Name as Instrument 
        , if(coalesce(schwierigkeitsgrad.Name, '')!=''
            , group_concat(concat(schwierigkeitsgrad.Name) order by schwierigkeitsgrad.Name separator ', ')
            , '') as Schwierigkeitsgrade  
    from schueler_schwierigkeitsgrad
        LEFT JOIN schwierigkeitsgrad on schwierigkeitsgrad.ID = schueler_schwierigkeitsgrad.SchwierigkeitsgradID 
        LEFT JOIN instrument on instrument.ID = schueler_schwierigkeitsgrad.InstrumentID   
    group by schueler_schwierigkeitsgrad.SchuelerID
        , schueler_schwierigkeitsgrad.InstrumentID  
) schueler_instrument
group by SchuelerID 