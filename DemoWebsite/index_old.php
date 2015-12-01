<html>
<head>
<title>MSU Police Database Demo</title>
<!--<meta http-equiv="refresh" content="0; url=dbclass/index.html" />-->
</head>
<body>
<h1>Find Cases</h1>
<p>
<form action="FindCases.php" method="post">
<input type="checkbox" name="bycase" value="ByCase">
Case #:        <input type="text" name="case"><br>
<input type="checkbox" name="bydateocc" value="ByDateOcc">
Date Occurred: <input type="date" name="dateoccurred"> (Note: dates must be in format `yyyy-mm-dd`)<br>
<input type="checkbox" name="bydaterepo" value="ByDateRepo">
Date Reported: <input type="date" name="datereported"><br>
<input type="checkbox" name="byhatecrime" value="ByHateCrime">
Hate Crime:<br> <input type="radio" name="hatecrime" value="both" checked>Both<br><input type="radio" name="hatecrime" value="yes">Yes<br><input type="radio" name="hatecrime" value="no">No<br> 
<input type="submit">
</form>
<h1>List All Cases</h1>
<p>
<form action="RetAll.php" method="post">
<input type="submit">
</p>
<h1>Retrieve Record by Ticket #</h1>
<p>
<form action="RetByTicketNum.php" method="post">
Ticket #: <input type="text" name="ticket"><br>
<input type="submit">
</form>
</p>
<h1>Retrieve Record by Bin #</h1>
<p>
<form action="RetByBinNum.php" method="post">
Bin #: <input type="text" name="bin"><br>
<input type="submit">
</form>
</body>
</html>