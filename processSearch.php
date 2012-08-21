<?php

require_once('connect.inc');




// Collect GET Search Criteria
if(isset($_GET['wineName']))
	$wineName = $_GET['wineName'];
if(isset($_GET['wineryName']))
{
	$wineryName = $_GET['wineryName'];
}
if(isset($_GET['region']))
{
	$region = $_GET['region'];
}
if(isset($_GET['grapeVariety']))
	$grapeVariety = $_GET['grapeVariety'];
if(isset($_GET['yearLowerBound']))
	$yearLowerBound = $_GET['yearLowerBound'];
if(isset($_GET['yearUpperBound']))
	$yearUpperBound = $_GET['yearUpperBound'];
if(isset($_GET['minWinesInStock']))
	$minWinesInStock = $_GET['minWinesInStock'];
if(isset($_GET['minWinesOrdered']))
	$minWinesOrdered = $_GET['minWinesOrdered'];
if(isset($_GET['costLowerBound']))
	$costLowerBound = $_GET['costLowerBound'];
if(isset($_GET['costUpperBound']))
	$costUpperBound = $_GET['costUpperBound'];
/*
 *	Error Checking
 *	Adds a binary bit value for each error to the $errors variable
 *	(e.g. error #1 is worth 1, error #2 2, both is worth 3)
 *	The Decimal variable is then returned and decoded to switch 
 *	on it's respective error messages on the search page. 
*/

// Years is Invalid
if($yearLowerBound > $yearUpperBound)
	$errors = 1;
 
// Cost is Invalid
if($costLowerBound > $costUpperBound)
	$errors += 2;

// Create a return string
$returnString ='search.php?wineName='.$wineName.'&wineryName='.wineryName.'&region='
						.$region.'&grapeVariety='.$grapeVariety.'&yearLowerBound='
						.$yearLowerBound.'&yearUpperBound='.$yearUpperBound.'&minWinesInStock='
						.$minWinesInStock.'&minWinesOrdered='.$minWinesOrdered.'&costLowerBound='
						.$costLowerBound.'&costupperBound='.$costupperBound;

// If there are errors add them to the return string and return to search page
if (errors != null)
{
	$returnString .= '&errors='.$errors;
	echo $errors;
	echo $yearLowerBound;
	echo $yearUpperBound;

	// header('Location: '.$returnString);
}

/*  Create  Wine Detail SQL Query */




$wineDetailQuery = "SELECT wine_name, grape_variety, year, winery_name, region_name
FROM winery, region, wine, grape_type
WHERE winery.region_id = region.region_id
AND wine.winery_id = winery.winery_id";
AND
if (isset($wine))
{
  $wineDetailQuery .= " AND wine_name like '{$wine}'";
}
if (isset($winery))
{
  $wineDetailQuery .= " AND winery_name like '{$winery}'";
}

if (isset($region) && $region != "All") {
  $wineDetailQuery .= " AND region_name = '{$region}'";
}


// ... and then complete the query.
$wineDetailQuery .= " ORDER BY wine_name";


// Run the query on the server
if(!($wineDetails = mysql_query($wineDetailQuery, $dbconn))) {
	showerror();
}

// Find out how many rows are available
$rowsFound = mysql_num_rows($wineDetails);

echo '\n'.$rowsFound;

// If the query has results ...
if ($rowsFound > 0) {

	while($line = mysql_fetch_assoc($wineDetails))
	{
		$wineDetails = $line;
	}
	
} // end if $rowsFound body



echo $wineDetails[$i][wine_name];
?>