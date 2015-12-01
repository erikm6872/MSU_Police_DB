<html>
<head>
<title>Search Results</title>
<link rel="stylesheet" type="text/css" href="../stylesheets/main.css">
</head>
<body>
<br>
<?php
$dbhost = 'localhost';
$dbuser = 'user';
$dbpass = 'G?%qM1E^UvxbKjsv@vw"/V1klOm$u-';
$dbname = 'csci440final';

/**  These credentials don't work... Apparently we only have access via PHPMyAdmin

$dbhost = 'csci440.cs.montana.edu';
$dbuser = 'gannon';
$dbpass = '3kz8knpmbv';
$dbname = 'gannon';
*/


$resultLimit = '500';   //Max number of results to show
$orderBy = 'ReportDateTime ASC';   //How to order results

$mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbname);   //Create new mysqli connection
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;  //Throw an error if there's a problem
}
else{
    echo "Successfully connected to MySQL database '{$dbhost}.{$dbname}'";  //Otherwise show successful connection message
}
echo "<br><h1>MSU Police Report Database Demo</h1>";

$sql = "SELECT * FROM cases";   //Main SQL for search results
$multOp = False;   //Set to true if there's more than one search condition

// Check what search settings were enabled, get the input values via POST and append the SQL query accordingly

if (isset($_POST["bycase"])){   //Case Number
    $caseNum = $_POST["casenum"];
    $sql .= " WHERE CaseNumber LIKE \"%{$caseNum}%\"";
    $multOp = True;
}
if(isset($_POST["bydateocc"])){
    $dateOccurred = $_POST["dateoccurred"];
    if($multOp)
		$sql .= " AND OccurredStartTime LIKE \"%{$dateOccurred}%\"";
	else{
		$sql .= " WHERE OccurredStartTime LIKE \"%{$dateOccurred}%\"";
		$multOp = True;
	}
}
if(isset($_POST["bydaterepo"])){
    $dateReported = $_POST["datereported"];
	if($multOp)
		$sql .= " AND ReportDateTime LIKE \"%{$dateReported}%\"";
	else{
		$sql .= " WHERE ReportDateTime LIKE \"%{$dateReported}%\"";
		$multOp = True;
	}
}
if(isset($_POST["byhatecrime"])){
    $hateCrime = $_POST["hatecrime"];
    if($multOp)
        $sql .= " AND HateCrime='{$hateCrime}'";
    else{
        $sql .= " WHERE HateCrime='{$hateCrime}'";
        $multOp = True;
    }
}
if(isset($_POST["byclery"])){
    $clery = $_POST["clery"];
    $clerySQL = "CaseNumber IN (SELECT M.CaseNumber FROM case_location_map AS M, locations AS L WHERE M.LocationID=L.LocationID AND L.CleryLocationsID={$clery})";
    if($multOp)
        $sql .= " AND {$clerySQL}";
    else{
        $sql .= " WHERE {$clerySQL}";
        $multOp = True;
    }
}
//$sql .= " ORDER BY {$orderBy}";
if(isset($_POST["limitrows"])){
    $resultLimit = $_POST["rowlimit"];
    $sql .= " LIMIT {$resultLimit}";
}
$sql .= ";";

echo "<br><br><h3>Main SQL query: `{$sql}`</h3>"; //Display the full query text
$result = $mysqli->query($sql); //Run the query
$row_count = $result->num_rows; //Get the number of returned rows
if($row_count == 0){
    echo "<p><h3>No results found.</h3></p>";   //Show message if no rows are returned
}
else{
    $result->data_seek(0);  //Start at row 0
    echo "{$row_count} results found.<br>";
    
    //Build the HTML table to show query results
    echo "<table border='1'>";
    echo "<tr><th>Case #</th><th>Date/Time Reported</th><th>Location</th><th>Crime</th><th>Incident Description</th><th>Disposition Description</th></tr>";
    
    //Loop over each returned row
    while($row = $result->fetch_assoc()){
        //Get description text from `disposition` table
        $dispSQL = "SELECT Description FROM disposition WHERE DispositionID={$row['DispositionID']};";
        $dispQuery = $mysqli->query($dispSQL);
        $dispText = $dispQuery->fetch_assoc();
        
        //Get location name from either `campus_location` or `street_address` table
        $locationSQL = "SELECT loc FROM ((SELECT LocationID, CampusLocationName as loc FROM campus_location) UNION (SELECT LocationID, Address as loc FROM street_address)) AS A, case_location_map AS M WHERE M.CaseNumber='{$row['CaseNumber']}' AND M.LocationID=A.LocationID;";
        $locationQuery = $mysqli->query($locationSQL);
        $locationText = $locationQuery->fetch_assoc();
        
        //Get crime name and category from `crimes` and `category` tables
        $crimeSQL = "SELECT C.CName, CA.CategoryName FROM crimes AS C, category as CA, crime_case_map AS M WHERE M.CaseNumber='{$row['CaseNumber']}' AND M.CrimeID=C.CrimeID AND C.CategoryID=CA.CategoryID;";
        $crimeQuery = $mysqli->query($crimeSQL);
        $crimeText = $crimeQuery->fetch_assoc();
        
        echo "<p>";
        
        //Insert values into the HTML table
        echo "<tr><td>{$row['CaseNumber']}</td>";
        echo "<td>{$row['ReportDateTime']}</td>";
        echo "<td>{$locationText['loc']}</td>";
        echo "<td>{$crimeText['CName']} ({$crimeText['CategoryName']})</td>";   //({$crimeClassText['CategoryName']})</td>";
        echo "<td>{$row['IncidentDescription']}</td>";
        echo "<td>{$dispText['Description']}</td>";
        
    
        echo "</tr>";
    }
    echo "</table>";
}
?>
<br>
Return to <a href="../index.php">Homepage</a>
</p>
<center>(C) 2015 Erik McLaughlin, Matthew Gannon and Andrew O'Donnell</center>
</body>
</html>
