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
	if(is_null($Symbol)) 
	{
	$Symbol = "";
	}
	?>


    <div class="center">
        <form name = "searchForm" class="bar" method = "get">
        <input name = "Symbol"  value=<?php print "'{$Symbol}'" ?>/>
        <button type="submit">
            Quote
        </button>

     <button type="submit" onClick="searchForm.action='history.php?Symbol = $Symbol';">
            History
        </button>
 
             <button type="submit" onClick="searchForm.action='search.php?Symbol = $Symbol';">
            Search
        </button>
        </form>
    </div>
<?php
	$objDBUtil = new DbUtil; 
if($Symbol != "")
{
	$db = $objDBUtil->Open();
	$query = "SELECT symSymbol, symName, symMarketCap FROM symbols " . 
 	"WHERE symSymbol=" . $objDBUtil->DBQuotes($Symbol); 
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
 	$tempMarketCap = $symMarketCap;
 
 		print <<<EOD
	    <div class="TableContainer">
		<p style="text-align: center;">
			Name: $symName <br>
	        Symbol: $symSymbol <br> 
		</p>
EOD;
//		$query = "SELECT * FROM quotes " . 
//		"WHERE qSymbol=" . $objDBUtil->DBQuotes($Symbol)."order by qQuoteDateTime DESC limit 1" ; 
		

		$query = "SELECT * FROM symbols left outer join quotes on symSymbol = qSymbol " . 
		"WHERE symSymbol =" . $objDBUtil->DBQuotes($Symbol)."order by qQuoteDateTime DESC limit 1" ; 



		$result = $db->query($query);
		$row = @$result->fetch_assoc();
		extract($row);
		
		print <<<EOD

		<table style="width:500px; margin: 0 auto;">
			<tr>
EOD;
	
		if (is_null($qLastSalePrice))
		{
			$qLastSalePrice = "n/a";
		}
		else 
		{
			$qLastSalePrice  = number_format ( $qLastSalePrice , 2 );
		}
		
		if (is_null($qPreviousClosePrice))
		{
			$qPreviousClosePrice = "n/a";
		}
		else 
		{
			$qPreviousClosePrice  = number_format ( $qPreviousClosePrice , 2 );
		}
		
		if (is_null($qNetChangePct))
		{
			$qNetChangePct = "n/a";
		}
		else 
		{
			$qNetChangePct  = number_format ( $qNetChangePct , 2 );
		}

		if (is_null($qNetChangePrice))
		{
			$qNetChangePrice = "n/a";
		}
		else 
		{
			$qNetChangePrice  = number_format ( $qNetChangePrice , 2 );
		}

		if (is_null($qBidPrice))
		{
			$qBidPrice = "n/a";
		}
		else 
		{
			$qBidPrice  = number_format ( $qBidPrice , 2 );
		}

		if (is_null($qAskPrice))
		{
			$qAskPrice = "n/a";
		}
		else 
		{
			$qAskPrice  = number_format ( $qAskPrice , 2 );
		}

		if (is_null($qTodaysHigh))
		{
			$qTodaysHigh = "n/a";
		}
		else 
		{
			$qTodaysHigh  = number_format ( $qTodaysHigh , 2 );
		}

		if (is_null($q52WeekHigh))
		{
			$q52WeekHigh = "n/a";
		}
		else 
		{
			$q52WeekHigh  = number_format ( $q52WeekHigh , 2 );
		}

		if (is_null($qTodaysLow))
		{
			$qTodaysLow = "n/a";
		}
		else 
		{
			$qTodaysLow  = number_format ( $qTodaysLow , 2 );
		}

		if (is_null($q52WeekLow))
		{
			$q52WeekLow = "n/a";
		}
		else 
		{
			$q52WeekLow  = number_format ( $q52WeekLow , 2 );
		}

		if (is_null($qShareVolumeQty))
		{
			$qShareVolumeQty = "n/a";
		}
		else 
		{
			$qShareVolumeQty  = number_format ( $qShareVolumeQty , 0 );
		}

		if (is_null($qCurrentPERatio))
		{
			$qCurrentPERatio = "n/a";
		}
		else 
		{
			$qCurrentPERatio  = number_format ( $qCurrentPERatio , 2 );
		}

		if (is_null($tempMarketCap))
		{
			$tempMarketCap = "n/a";
		}
		else 
		{
			$tempMarketCap  = number_format ( $tempMarketCap , 2 );
		}
		
		
		if (is_null($qEarningsPerShare))
		{
			$qEarningsPerShare = "n/a";
		}	
		else 
		{
			$qEarningsPerShare  = number_format ( $qEarningsPerShare , 2 );
		}
		
		
		if (is_null($qTotalOutstandingSharesQty))
		{
			$qTotalOutstandingSharesQty = "n/a";
		}	
		else 
		{
			$qTotalOutstandingSharesQty  = number_format ( $qTotalOutstandingSharesQty , 0 );
		}
		
		if (is_null($qCashDividendAmount))
		{
				$qCashDividendAmount = "n/a";
		}
		else 
		{
			$qCashDividendAmount  = number_format ( $qCashDividendAmount , 2 );
		}
		
		if (is_null($qCurrentYieldPct))
		{
			$qCurrentYieldPct = "n/a";
		}	
		else 
		{
			$qCurrentYieldPct  = number_format ( $qCurrentYieldPct , 2 );
		}
		

		
		
		print <<<EOD
  				<td width = 100 align = left  > Last</td>
 				<td width = 100 align = right > $qLastSalePrice </td>
				<td width = 200 align = center> Prev Close</td> 
 				<td width = 100 align = right > $qPreviousClosePrice </td>
			</tr>
			<tr>
 				<td width = 100 align = left  > Change </td>
 				<td width = 100 align = right > $qNetChangePrice </td> 
  				<td width = 200 align = center> Bid</td>
				<td width = 100 align = right > $qBidPrice</td> 
			</tr>
			<tr>
 				<td width = 100 align = left  >%Change </td>
 				<td width = 100 align = right > $qNetChangePct %</td> 
  				<td width = 200 align = center>Ask</td>
				<td width = 100 align = right >$qAskPrice</td> 
			</tr>
			<tr>
 				<td width = 100 align = left  > High </td>
 				<td width = 100 align = right > $qTodaysHigh</td> 
  				<td width = 200 align = center> 52 Week High</td>
				<td width = 100 align = right > $q52WeekHigh</td> 
			</tr>
			<tr>
 				<td width = 100 align = left  > Low </td>
 				<td width = 100 align = right > $qTodaysLow</td> 
  				<td width = 200 align = center> 52 Week Low</td>
				<td width = 100 align = right > $q52WeekLow</td> 
			</tr>
			<tr>
 				<td> Daily Volume </td>
 				<td align = right > $qShareVolumeQty</td> 
  			</tr>
			</table>
			<p style="text-align: center;"> Fundamentals</p>
			<table style="width:500px; margin: 0 auto;">
			<tr>
 				<td width = 100 align = left  > Pe Ratio </td>
 				<td width = 100 align = right > $qCurrentPERatio</td> 
  				<td width = 200 align = center> MarketCap.</td>
				<td width = 100 align = right > $tempMarketCap Mil</td> 
			</tr>
			<tr>
 				<td width = 100 align = left  > Earnings/Share </td>
 				<td width = 100 align = right > $qEarningsPerShare</td> 
  				<td width = 200 align = center> # shrs out.</td>
				<td width = 100 align = right > $qTotalOutstandingSharesQty</td> 
			</tr>
			<tr>
 				<td width = 100 align = left  > Div/Share </td>
 				<td width = 100 align = right > $qCashDividendAmount</td> 
  				<td width = 200 align = center> Div. Yield</td>
				<td width = 100 align = right > $qCurrentYieldPct %</td> 
			</tr>
		</table>
	 	</div>
EOD;
 	}
}
?>
</body>
</html> 
<?php
$db = $objDBUtil->Close();
?>
