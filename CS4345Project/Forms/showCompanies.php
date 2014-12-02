<?php
	session_start();
	$_SESSION['pageTitle'] = 'Companies';
	include '../header.php';
	include '../Classes/Company.php';
	
	$companies = getAllCompanies();
	
	//print_r($companies);
?>
	<body>
		<h2>Companies</h2>
		<div><a href='editCompany.php'>Add an Company</a></div>
		<table>
			<thead>
				<tr><th>Company Name</th><th>Date</th><th>Is Individual</th><th>Edit</th>
				<?php
					if($_SESSION['user_is_admin'] == 1)
						echo "<th>Delete</th>";
				?>
				</tr>
			</thead>
			<?php
				$a = 0;
				foreach($companies as $comp){
					$a++;
					$rowStyle = ($a % 2 == 0) ? 'even' : 'odd';
					echo "<tr class ='".$rowStyle."'><td>".str_replace("'", "", $comp['companyName'])."</td>";
					echo "<td>".date("F j, Y", strtotime($comp['dateCreated']))."</td>";
					if($comp['isIndividual'])
						echo "<td><img src='".WEB_ROOT."images/checkmark.png' class='smallImage'></td>";
					else
						echo "<td><img src='".WEB_ROOT."images/x.png' class='smallImage'></td>";
					echo "<td> <a href='editCompany.php?id=".$comp['id']."'>Edit</a></td>";
					if($_SESSION['user_is_admin'] == 1)
						echo "<td> <a href='deleteCompany.php?id=".$comp['id']."'>Delete</a></td>";
					echo "</tr>";
					if($comp['isIndividual']){
						echo "<tr class ='".$rowStyle." subRow'><td colspan='3' class='indvName'>Individual's name: ".$comp['indvName']."</td><td colspan='";
						if($_SESSION['user_is_admin'] == 1)
							echo '3';
						else
							echo '2';
						echo "'><a href='editPointOfContact.php?id=".$comp['indvID']."'>Edit</a></td></tr>";
					}
				}
			?>
		</table>
<?php 
	include '../footer.php';
?>