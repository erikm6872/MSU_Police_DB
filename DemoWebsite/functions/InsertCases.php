<html>
<head>
<title>Search Results</title>
<link rel="stylesheet" type="text/css" href="../stylesheets/main.css">
</head>
<body>
<br>
<?php
$dbhost = 'localhost';
$dbuser = 'gannon';
$dbpass = '3kz8knpmbv';
$dbname = 'csci440final';
/*
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = 'critters';
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

mysqli_autocommit($mysqli, false);
$flag = true;

$sql22 = "SELECT COUNT(*) FROM disposition";
$result = $mysqli->query($sql22);
$row = $result->fetch_assoc();

$nextID = $row['COUNT(*)'] +1;
echo $nextID;

$sql = "SELECT * FROM cases";

 
 $caseNum 		= $_POST["casenum"];

 $ReportYears	= $_POST["ReportYears"];
 $ReportMonths 	= $_POST["ReportMonths"];
 $ReportDays		= $_POST["ReportDays"];
 $ReportTime 	= $ReportYears ."-".$ReportMonths."-".$ReportDays;
 $ReportTime. "tt";

 $StartYears		= $_POST["StartYears"];
 $StartMonths	= $_POST["StartMonths"];
 $StartDays		= $_POST["StartDays"];
 $StartTime 		= $StartYears . "-" . $StartMonths . "-" . $StartDays;
 $StartTime. "yy";
 $endYears 		= $_POST["EndYears"];
 $EndMonths		= isset($_POST["EndMonths"]);
 $EndDays		= isset($_POST["EndDays"]);
 $EndTime		= $endYears . "-" .$EndMonths ."-" . $EndDays;
 $EndTime . "zz";
$allLocations	= $_POST["allLocations"];
//print_r($_POST['CrimeList']);
$CrimeList	= $_POST['CrimeList'];

 $hatecrime		= $_POST["hatecrime"];
 $arrests		= $_POST["arrests"];
 $referrals		= $_POST["referrals"];
 $Idescription   = $_POST["Idescription"];
 $Ddescription	= $_POST["Ddescription"];
 $outcomes		= $_POST["outcomes"];


$sql1 = "INSERT INTO disposition (DispositionID, Description, Arrests, Referrals, OutcomeID) 
VALUES ($nextID, '$Ddescription', '$arrests', '$referrals', $outcomes);";
$sql3 = "INSERT INTO cases (CaseNumber, DispositionID, OccuredStartTime, OccuredEndTime, IncidentDescription, ReportDateTime, HateCrime)
VALUES ('$caseNum', $nextID, '$StartTime', '$EndTime', '$Idescription', '$ReportTime', '$hatecrime');";
$sql4 = "INSERT INTO case_location_map (CaseNumber, LocationID) 
VALUES ('$caseNum', $allLocations);";
$sql2 = "INSERT INTO crime_case_map (CrimeID, CaseNumber) VALUES ";
foreach ($CrimeList as $a){
   //echo $a;
   $sql2 .= "($a, '$caseNum'),";
}
$sql2 = rtrim($sql2, ",");
$sql2.= ";";
//$sql1.= $sql2;
//echo $sql1;

$results = mysqli_query($mysqli, $sql1);
if (!$results) {
	$flag = false;
	echo "Error Details". mysqli_error($mysqli). " ";
}
$results = mysqli_query($mysqli, $sql3);
if (!$results) {
	$flag = false;
	echo "Error Details". mysqli_error($mysqli). " ";
}
$results = mysqli_query($mysqli, $sql4);
if (!$results) {
	$flag = false;
	echo "Error Details". mysqli_error($mysqli). " ";
}
$results = mysqli_query($mysqli, $sql2);
if (!$results) {
	$flag = false;
	echo "Error Details". mysqli_error($mysqli). " ";
}
if($flag){
	mysqli_commit($mysqli);
	echo "All Queries executed successfully";
}else {
	mysqli_rollback($mysqli);
	echo "All Queries rolled back";
}

?>
<br>
Return to <a href="../index.php">Homepage</a>
</p>
<center>(C) 2015 Erik McLaughlin, Matthew Gannon and Andrew O'Donnell</center>
</body>
</html>
