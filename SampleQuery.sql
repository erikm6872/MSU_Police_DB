USE Clery;

SELECT CA.IncidentDescription LIMIT 5
    FROM CASE AS CA, CRIMES AS CR
    WHERE CA.CID=CR.CrimeID 
    AND CR.CName='DUI';
    
SELECT D.Ddescription LIMIT 5
    FROM DISPOSITION AS D, CASE AS C, LOCATION AS L
    WHERE D.Disposition=C.Disposition
    AND C.LocationID=L.LocationID
    AND L.Name='South Fieldhouse Lot';