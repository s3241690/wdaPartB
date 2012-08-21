<?php 
	require_once('connect.inc');
	
	// Get Regions
	$query = 'select * from region';
    $regionList = mysql_query($query, $dbconn);
	
	// Get Grape Varieties
	$query = 'select * from grape_variety;';
    $grapeVarietyList = mysql_query($query, $dbconn);
	
	// Get Lower Bound of the Wine Production Years
	$query = 'select min(year) from wine';
    $yearMinimum = mysql_query($query, $dbconn);
	$yearMinimum = mysql_fetch_row($yearMinimum);
	$yearMinimum = $yearMinimum[0];
	
	// Get Upper Bound of the Wine Production Years
	$query = 'select max(year) from wine;';
    $yearMaximum = mysql_query($query, $dbconn);
	$yearMaximum = mysql_fetch_row($yearMaximum);
	$yearMaximum = $yearMaximum[0];
	
	// Calculate Production Year Difference 
	$yearDifference = $yearMaximum - $yearMinimum;
	
	
		
	// Collect GET variables	
		if(isset($_GET['wineName']) == true )
			$wineName = $_GET['wineName'];
		if(isset($_GET['wineryName']) == true )
			$wineryName = $_GET['wineryName'];			
		if(isset($_GET['region']) == true )
			$region = $_GET['region'];	
		if(isset($_GET['grapeVariety']) == true )
			$grapeVariety = $_GET['grapeVariety'];				
		if(isset($_GET['yearLowerBound']) == true )
			$yearLowerBound = $_GET['yearLowerBound'];			
		if(isset($_GET['yearUpperBound']) == true )
			$yearUpperBound = $_GET['yearUpperBound'];	
		if(isset($_GET['minWinesInStock']) == true )
			$minWinesInStock = $_GET['minWinesInStock'];			
		if(isset($_GET['minWinesOrdered']) == true )
			$minWinesOrdered = $_GET['minWinesOrdered'];				
		if(isset($_GET['costLowerBound']) == true )
			$costLowerBound = $_GET['costLowerBound'];
		if(isset($_GET['costUpperBound']) == true )
			$costUpperBound = $_GET['costUpperBound'];			
		
	
?>

<html>
	<head>
		<Title>WDA Assignment 1: Wine Database Search Page</Title>
		<link rel="stylesheet" href="style.css" type="text/css" />
	</head>
	
	<body>
	

		<!-- Display Search Form-->
		<form action ="processSearch.php" method="GET">
			<fieldset>
			<legend>Search Wines</legend>
			<div>
				<label class="search">Wine Name:</label>
				<input type="text" value="<?php echo $wineName;?>" name="wineName" />
			</div>
			
			<div>
			 <label class="search">Winery Name:</label>
			 <input type="text" value="<?php echo $wineryName;?>" name="wineryName" />
			</div>
			
			<!--Display Region List -->	
			<div>
				<label class="search">Region:</label>
				<select name="region" >

					<?php 
					 while($row = mysql_fetch_row($regionList)) {
						$regionListItem = $row[1];
						
						if (strcmp($regionListItem, $region) == 0)
							echo '<option value="'. $regionListItem . '" selected="selected">'.$regionListItem.'</option>';
						else
							echo '<option value="'. $regionListItem . '">'.$regionListItem.'</option>';
					}
					?>
				</select>
			</div>
			
			<!--Display Grape Variety List -->	
			<div>
				<label class="search">Grape Variety:</label>
				<select name="grapeVariety">
					<?php 
					 while($row = mysql_fetch_row($grapeVarietyList)) {
						$grapeVarietyListItem = $row[1];
						
						if (strcmp($grapeVarietyListItem, $grapeVariety) == 0)
							echo '<option value="'. $grapeVarietyListItem. '" selected="selected">'. $grapeVarietyListItem. '</option>';
						else
							echo '<option value="'. $grapeVarietyListItem. '">'. $grapeVarietyListItem. '</option>';
					}
					?>
				</select>
			</div>
			
			<!-- Display Year Lower -->
			<div> 	
				<label class="search">Year Lower Bound:</label>
				<select name="yearLowerBound">
					
					<?php
					for ($ylb = $yearMaximum; $ylb >= $yearMinimum; $ylb--)
					{
						if ($ylb == $yearLowerBound)
							echo '<option value="'.$ylb.'" selected="selected">'.$ylb.'</option>';
						else
							echo '<option value="'.$ylb.'">'.$ylb.'</option>';
					}		
					?>		
				</select>
			</div>
			<!-- Display Year Upper -->
			<div>
				<label class="search">Year Upper Bound:</label>
				<select name="yearUpperBound">
					<?php
					for ($yub = $yearMaximum; $yub >= $yearMinimum; $yub--)
					{
						if ($yub == $yearUpperBound)
							echo '<option value="'.$yub.'" selected="selected">'.$yub.'</option>';
						else
							echo '<option value="'.$yub.'">'.$yub.'</option>';
					}		
					?>		
				</select>
			</div>
			
			<!-- Display Minimum Wines In Stock-->
			<div>
				<label class="search">Minimum Wines in Stock:</label>
				<input type="text" value="<?php echo $minWinesInStock;?>" name="minWinesInStock" />
			</div>
			<!-- Display Minimum Wines Ordered -->
			<div>
				<label class="search">Minimum Wines Ordered:</label>
				<input type="text" value="<?php echo $minWinesOrdered;?>" name="minWinesOrdered" />
			</div>
			
			<!-- Display Cost Range-->
			<div>
				<label class="search">Cost Minimum:</label>
				<input type="text" value="<?php echo $costLowerBound;?>" name="costLowerBound" />
			</div>
			<div>
				<label class="search">Cost Maximum:</label>
				<input type="text" value="<?php echo $costupperBound;?>" name="costupperBound" />
			</div>
		
			<div>
				<input type="submit" name="submit" value="Seach" class="search">
				<a href="search.php"><input type="reset"/></a>
			</div>
			</fieldset>
			</form>
	
	</body>

</html>