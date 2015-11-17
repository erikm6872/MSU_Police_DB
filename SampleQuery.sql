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
    
SELECT COUNT(CA.CaseNumber)
    FROM CASE AS CA, CRIMES AS CR, CATEGORY AS CAT
    WHERE CA.Crimes=CR.CIdentifier
    AND CR.CategoryName=CAT.CategoryName
    AND CAT.HateCrime='True';
    
SELECT L.Name LIMIT 5
    FROM LOCATION AS L, CASE AS C
    WHERE C.LocationID=L.LocationID
    AND C.CaseNumber='215CR0014406';
    
SELECT C.CaseNumber LIMIT 5
    FROM CASE AS C, DISPOSITION AS D, OUTCOMES AS O
    WHERE C.Disposition=D.Disposition
    AND D.OutcomeID=O.OutcomeID
    AND O.OutcomeType='Open';