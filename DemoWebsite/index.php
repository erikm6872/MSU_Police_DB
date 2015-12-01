<html>
<head>
<title>MSU Police Report Database Demo</title>
<link rel="stylesheet" type="text/css" href="stylesheets/main.css">
</head>
<body>
<br>

<?php
$dbhost = 'localhost';
$dbuser = 'user';
$dbpass = 'G?%qM1E^UvxbKjsv@vw"/V1klOm$u-';
$dbname = 'csci440final';
/*
$dbhost = 'csci440.cs.montana.edu';
$dbuser = 'gannon';
$dbpass = '3kz8knpmbv';
$dbname = 'gannon';
*/
$mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
else{
    echo "Successfully connected to MySQL database '{$dbhost}.{$dbname}'";
}
echo "<br><h1>MSU Police Report Database Demo</h1>";
//mysql_select_db($dbname);
$sql = "SELECT COUNT(*) FROM cases";
$result = $mysqli->query($sql);
$row = $result->fetch_assoc();
//print_r($row);
//$row = mysqli_fetch_row($result);
echo "<h3>{$row['COUNT(*)']} total cases in database</h3>"; 
?>
<h2>Search Reports</h2>
<p>
<form action="functions/FindCases.php" method="post">
    <table border='1'>
        <tr>
            <td align="left"><input type="checkbox" name="bycase" value="ByCase"></td>
            <td align = "left">Case Number</td>
            <td align="left"><input type="text" name="casenum"></td>
        </tr>
        <tr>
            <td align="left"><input type="checkbox" name="bydateocc" value="ByDateOccurred"></td>
            <td align = "left">Date Occurred</td>
            <td align="left"><input type="text" name="dateoccurred"></td>
        </tr>
        <tr>
            <td align="left"><input type="checkbox" name="bydaterepo" value="ByDateReported"></td>
            <td align = "left">Date Reported</td>
            <td align="left"><input type="text" name="datereported"></td>
        </tr>
        <tr><td align="left"><input type="checkbox" name="byclery" value="ByClery"></td>
            <td align = "left">Location</td>
            <td align="left"><input type="radio" name="clery" value=1>On Campus<br><input type="radio" name="clery" value=2>Off Campus<br><input type="radio" name="clery" value=3>Public Property<br></td>
        </tr>
        <tr><td align="left"><input type="checkbox" name="byhatecrime" value="ByHateCrime"></td>
            <td align = "left">Hate Crime</td>
            <td align="left"><input type="radio" name="hatecrime" value="y">Yes<br><input type="radio" name="hatecrime" value="n">No<br> </td>
        </tr>
        <tr>
            <td align="left"><input type="checkbox" name="limitrows" value="LimitRows" checked></td>
            <td align = "left">Limit Results to </td>
            <td align="left"><input type="text" name="rowlimit" value=500> Rows</td>
        </tr>
        <tr><td></td><td><input type="submit" value="Search"></td><td></td></tr>
    </table>
    
    
</form>
<center>(C) 2015 Erik McLaughlin, Matthew Gannon and Andrew O'Donnell</center>
</body>
</html>
