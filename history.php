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
        <button type="submit">
            History
        </button>

     <button type="submit" onClick="searchForm.action='quote.php?Symbol = $Symbol';">
            Quote
        </button>
        
        
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
	$query = "SELECT symSymbol, symName FROM symbols " . 
 	"WHERE symSymbol=" . $objDBUtil->DBQuotes($Symbol) ; 
 	$result = $db->query($query);
 	$row = @$result->fetch_assoc();
 	if($row==NULL)
 	{
 		 header("Location: " . "search.php?Symbol=$Symbol"); 
		 ob_end_flush(); 
		 exit(); 
 	}
 	else
 	{	
 	extract($row);
 		print <<<EOD
	    <div class="TableContainer">
		<p style="text-align: center;">
			Name: $symName <br>
	        Symbol: $symSymbol <br>				
		</p>
EOD;
		$query = "SELECT qQuoteDateTime, qLastSalePrice, qNetChangePrice, qNetChangePct, qShareVolumeQty FROM quotes " . 
		"WHERE qSymbol=" . $objDBUtil->DBQuotes($Symbol)."order by qQuoteDateTime DESC" ; 
		$result = $db->query($query);

		print <<<EOD
		<center>
		<table style="width:500px; margin:0;">
		<tr>
		<td width = 100 align = left> <b> Date</b></td>
		<td width = 100 align = center > <b>Last</b></td>
		<td width = 100 align = center > <b>Change</b></td>
		<td width = 100 align = center > <b>% Change </b></td>
		<td width = 100 align = center > <b>Volume</b></td>
		</tr>
		</table>
		<div style="height: 330px; width:520px; overflow: auto;">
		<table style="width:500px; margin:0;">

EOD;
		while($row = @$result->fetch_assoc()) 
		{ 
			extract($row);
		
			$qQuoteDateTime  = substr($qQuoteDateTime, 0, 10);
			$qLastSalePrice  = number_format ( $qLastSalePrice , 2 );
			$qNetChangePrice = number_format ( $qNetChangePrice , 2 );
			$qNetChangePct   = number_format ( $qNetChangePct , 2 );
			$qShareVolumeQty = number_format ( $qShareVolumeQty );
			 
			print <<<EOD
			<tr>
			<td width = 100 align = left   > <b> $qQuoteDateTime   </b></td>
			<td width = 100 align = center > <b> $qLastSalePrice   </b></td>
			<td width = 100 align = center > <b> $qNetChangePrice  </b></td>
			<td width = 100 align = center > <b> $qNetChangePct    </b></td>
			<td width = 100 align = center > <b> $qShareVolumeQty  </b></td>
			</tr>
EOD;
			
		}
		print "</table>";
		print "</div>";
		print "</center>";
		print "</div>";	
 	}

}
?>
</body>
</html> 
<?php
$db = $objDBUtil->Close();
?>
