create or replace view v_links AS 
select link.ID AS ID
,link.URL AS URL
,link.Bezeichnung AS Bezeichnung
,concat('<a href="',link.URL,'" target="_blank">',link.Bezeichnung,'</a>') AS LinkText
,linktype.Name AS LinkTyp
,link.SammlungID AS SammlungID
,link.LinktypeID AS LinktypeID 
from (link left join linktype on(link.LinktypeID = linktype.ID))

