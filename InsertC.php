<html>
<head>
<title>MSU Police Report Database Demo</title>
<link rel="stylesheet" type="text/css" href="stylesheets/main.css">
</head>
<body>
<br>

<?php
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = 'critters';
$dbname = 'gannon';
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

function get_location()
{
	$dbhost = 'localhost';
	$dbuser = 'root';
	$dbpass = 'critters';
	$dbname = 'gannon';
	$mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
	if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}
	else{
    echo "Successfully connected to MySQL database '{$dbhost}.{$dbname}'";
	}
	echo "<br><h1>MSU Police Report Database Demo</h1>";
	$sql = "SELECT * FROM ((SELECT LocationID, CampusLocationName as loc FROM campus_location) UNION (SELECT LocationID, Address as loc FROM street_address)) as A Order by loc";
	$options ='';
	$result = $mysqli->query($sql);
	while($row = $result->fetch_assoc())
	{
		$LocationID = $row["LocationID"];
		$loc = $row["loc"];
		$options.='<option value ="'.$LocationID.'">'.$loc.'</option>';
	}return $options;
}

function get_crimes()
{
	$dbhost = 'localhost';
	$dbuser = 'root';
	$dbpass = 'critters';
	$dbname = 'gannon';
	$mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
	if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}
	else{
    echo "Successfully connected to MySQL database '{$dbhost}.{$dbname}'";
	}
	echo "<br><h1>MSU Police Report Database Demo</h1>";
	$sql = "SELECT CrimeID, CName FROM crimes Order by CName";
	$options ='';
	$result = $mysqli->query($sql);
	while($row = $result->fetch_assoc())
	{
		$CrimeID = $row["CrimeID"];
		$CName = $row["CName"];
		$options.='<option value ="'.$CrimeID.'">'.$CName.'</option>';
	}return $options;
}

function get_year()
{
	$years = array('2015'=> 2015, '2014'=>2014, '2013'=>2013);
	$options='';
	while(list($k,$v)=each($years))
	{
		$options.='<option value="'.$v.'">'.$k.'</option>';
	}
	return $options;
}
function get_month()
{
	$months = array('January'=>01, 'February'=>02, 'March'=>03, 'April'=>04, 'May'=>05, 'June'=>06, 
	'July'=>07,'August'=>08,'September'=>09, 'October'=> 10, 'November'=>11, 'December'=>12);
	$options = '';
	while(list($k,$v) = each ($months))
	{
		$options.='<option value="'.$v.'">'.$k.'</option>';
	}
	return $options;
}
function get_day()
{
	$d = array();
	for($i = 1; $i < 31; $i++) 
    $d[$i] = $i;
	$options = '';
	while(list($k,$v) = each ($d))
	{
		$options.='<option value="'.$v.'">'.$k.'</option>';		
	}
	return $options;
}
?>



<h2>Add New Case</h2>
<p>
<br>

<form action="functions/InsertCases.php" method="post">
    <table border='1'>
        <tr>
            <td align = "left">Case Number</td>
            <td align="left"><input type="text" name="casenum"></td>
        </tr>
        <tr>
            <td align = "left">Report Date</td>
            <td align="left"><select name = "ReportYears" ><?php echo get_year(); ?></select>
			<select name = "ReportMonths" ><?php echo get_month(); ?></select>
			<select name = "ReportDays" ><?php echo get_day(); ?></select></td>
        </tr>
		
		<tr>
            <td align = "left">Event start time</td>
            <td align="left"><select name = "StartYears" ><?php echo get_year(); ?></select>
			<select name = "StartMonths" ><?php echo get_month(); ?></select>
			<select name = "StartDays" ><?php echo get_day(); ?></select></td>
        </tr>
        <tr>
            <td align = "left">Event end time</td>
            <td align="left"><select name = "EndYears" ><?php echo get_year(); ?></select>
			<select name = "EndMonths" ><?php echo get_month(); ?></select>
			<select name = "EndDays" ><?php echo get_day(); ?></select></td>
        </tr>
		<tr>
			<td align= "left">Choose Location</td>
			<td align= "left"><select name ="allLocations"><?php echo get_location(); ?></select></td>   
		</tr>
       <tr>
            <td align = "left">Crimes </td>
            <td align="left"><select id = "CrimeList" multiple = "multiple" name = "CrimeList[]" ><?php echo get_crimes(); ?></select></td>
        </tr>
        <tr>
            <td align = "left">Hate Crime</td>
            <td align="left"><input type="radio" name="hatecrime" value="y">Yes<br><input type="radio" name="hatecrime" value="n">No<br> </td>
        </tr>
        <tr>
            <td align = "left">Arrests</td>
            <td align="left"><input type="radio" name="arrests" value="y">Yes<br><input type="radio" name="arrests" value="n">No<br> </td>
        </tr>
        <tr>
            <td align = "left">Referrals</td>
            <td align="left"><input type="radio" name="referrals" value="y">Yes<br><input type="radio" name="referrals" value="n">No<br> </td>
        </tr>
        <tr>
            <td align = "left">Incident description </td>
            <td align="left"><input type="text" name="Idescription" style="width: 400px;"></td>
        </tr>
		<tr>
            <td align = "left">Disposition description </td>
            <td align="left"><input type="text" name="Ddescription" style="width: 400px;"></td>
        </tr>
		<tr>
            <td align = "left">Outcomes</td>
            <td align="left"><input type="radio" name="outcomes" value=1>Open<br><input type="radio" name="outcomes" value=2>Pending/NA<br><input type="radio" name="outcomes" value=3>Closed<br></td>
        </tr>

        <tr><td></td><td><input type="submit" value="Create"></td><td></td></tr>
    </table>
    
    
</form>


<center>(C) 2015 Erik McLaughlin, Matthew Gannon and Andrew O'Donnell</center>
</body>
</html>
