--     create or REPLACE view v_tmp_Spieldauer as 
--     select distinct 0 as ID
--             , Spieldauer
--             ,  case 
--                 when Spieldauer >= 20 
--                     THEN  Spieldauer 
--                 when Spieldauer < 20 
--                     Then Spieldauer * 60 
--             END as Spieldauer_sec 
--     from satz  
--     where Spieldauer is not null 
--     order by Spieldauer

--     ; 


-- select * 
-- from v_tmp_Spieldauer 
-- where Spieldauer <> Spieldauer_sec

-- ; 
-- select satz.ID, satz.Name, satz.Spieldauer, ref.Spieldauer_sec 
-- from satz inner join v_tmp_Spieldauer ref 
-- on satz.Spieldauer = ref.Spieldauer 
-- where satz.Spieldauer <> ref.Spieldauer_sec
-- ; 

-- update satz 
-- inner join v_tmp_Spieldauer ref 
-- on satz.Spieldauer = ref.Spieldauer 
-- set satz.Spieldauer = ref.Spieldauer_sec
-- where satz.Spieldauer <> ref.Spieldauer_sec






