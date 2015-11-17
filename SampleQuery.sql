USE Clery;

SELECT CA.IncidentDescription LIMIT 5
    FROM CASE AS CA, CRIMES AS CR
    WHERE CA.CID = CR.CrimeID 
    AND CR.CName = 'DUI';