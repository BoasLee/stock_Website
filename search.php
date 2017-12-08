<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Boas' Website </title>
    <link type="text/css" rel="stylesheet" href="mystyle.css">
</head>
<body>


	<?php require "inc_header.php" ?> 
	<?php require "DbUtil.php"?> 

	<?php

	// Gather incoming form data 
	$Symbol = @$_REQUEST["Symbol"]; 
	if(empty($Symbol)) 
	{
	$Symbol = "";
	}
	?>


    <div class="center">
        <form name = "searchForm" class="bar" method = "get">
        <input name="Symbol" value=<?php print "'{$Symbol}'" ?>/>
             <button type="submit" onClick="searchForm.action='Search.php?Symbol = $Symbol';">
            Search
        </button>        
        </form>
    </div>
<?php
	$objDBUtil = new DbUtil; 
if($Symbol != "")
{
		$db = $objDBUtil->Open();
		$query = "SELECT symName, symSymbol FROM symbols " . 
		"WHERE symName like " . $objDBUtil->DBQuotes("%". $Symbol ."%")."or symSymbol like " 
		. $objDBUtil->DBQuotes("%". $Symbol ."%") ." order by symName limit 500" ; 
		$result = $db->query($query);
		
		print <<<EOD
		<p style="text-align: center;">
			Search: $Symbol <br>
	        Results: $result->num_rows <br>				
		</p>
	
		<center>
		<table style="width:500px; margin:0;">
		<tr>
		<td width = 140 align = center   > <b> Company </b></td>
		<td width = 100 align = left > <b>Symbol</b></td>
		</tr>
		</table>
		<div style="height: 330px; width:520px; overflow: auto;">
		<table style="width:500px; margin:0;">

EOD;
		while($row = $result->fetch_assoc()) 
		{ 
			extract($row);
			print <<<EOD
			<tr>
 			  <td width = 400 align = left   > $symName </td>
			  <td width = 100 align = left > $symSymbol </td>
   			  <td width = 50 align = center   > <a href="quote.php?Symbol=$symSymbol">Quote</a></td> 
 			  <td width = 50 align = center > <a href="history.php?Symbol=$symSymbol">History</a></td>
			</tr>
EOD;
			
		}
		print "</table>";
		print "</div>";
		print "</center>";	
}
else
{
	print <<<EOD
		<p style = "text-align: center;">
			Search:  <br>
	        Results: 0 <br>				
		</p>
EOD;
}
?>
</body>
</html> 
<?php
$db = $objDBUtil->Close();
?>