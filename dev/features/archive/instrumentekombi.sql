
-- nicht verwendet 

SELECT DISTINCT i1.Name as i1_Name, i2.Name as i2_Name 
from instrument i1
inner join instrument i2 on 1=1
where i1.Name in ('Violine 1', 'Klavier', 'Viola', 'Sopranflöte', 'Gitarre') 
and  i2.Name in ('Violine 1', 'Klavier', 'Viola', 'Sopranflöte', 'Gitarre') 
order by i1.Name, i2.Name


SELECT DISTINCT i1.Name as i1_Name
    , i2.Name as i2_Name 
    , i3.Name as i3_Name     
from instrument i1
inner join instrument i2 on 1=1
inner join instrument i3 on 1=1 
where i1.Name in  ('Violine 1', 'Klavier', 'Viola', 'Sopranflöte', 'Gitarre') 
and  i2.Name in ('Violine 1', 'Klavier', 'Viola', 'Sopranflöte', 'Gitarre') 
and  i3.Name in ('Violine 1', 'Klavier', 'Viola', 'Sopranflöte', 'Gitarre') 
order by i1.Name, i2.Name, i3.Name



SELECT DISTINCT i1.Name as i1_Name
    , i2.Name as i2_Name 
    , i3.Name as i3_Name  
    , i4.Name as i4_Name        
from instrument i1
inner join instrument i2 on 1=1
inner join instrument i3 on 1=1 
inner join instrument i4 on 1=1 
where i1.Name in  ('Violine 1', 'Klavier', 'Viola', 'Sopranflöte', 'Gitarre') 
and  i2.Name in ('Violine 1', 'Klavier', 'Viola', 'Sopranflöte', 'Gitarre') 
and  i3.Name in ('Violine 1', 'Klavier', 'Viola', 'Sopranflöte', 'Gitarre') 
and  i4.Name in ('Violine 1', 'Klavier', 'Viola', 'Sopranflöte', 'Gitarre') 
order by i1.Name, i2.Name, i3.Name, i4.Name 

