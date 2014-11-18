<?php
	session_start();
	$_SESSION['pageTitle'] = 'Employees';
	include '../header.php';
	include '../Classes/Location.php';
	
	$locations = getAllLocations();
?>
	<body>
		<h2>Locations</h2>
		<div><a href='editLocation.php'>Add a Location</a></div>
		<table>
			<thead>
				<tr><th>Location Name</th><th>Street Addr</th><th>City</th><th>State</th><th>Zip</th><th>Edit</th><th>Delete</th></tr>
			</thead>
			<?php
				$a = 0;
				foreach($locations as $loc){
					$a++;
					$rowStyle = ($a % 2 == 0) ? 'even' : 'odd';
					echo "<tr class ='".$rowStyle."'><td>".str_replace("'", "", $loc['locationName'])."</td><td>".str_replace("'", "", $loc['streetAddr1']);
					if(strlen($loc['streetAddr1']) > 0)
						echo ", ".str_replace("'", "", $loc['streetAddr2']);
					echo "</td><td>".str_replace("'", "", $loc['city'])."</td><td>".$loc['state']."</td><td>".$loc['zip']."</td><td> <a href='editLocation.php?locId=".$loc['id']."'>Edit</a></td><td> <a href='editLocation.php?locId=".$loc['id']."'>Delete</a></td></tr>";
				}
			?>
		</table>
<?php 
	include '../footer.php';
?>