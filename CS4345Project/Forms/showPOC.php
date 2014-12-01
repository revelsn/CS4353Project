<?php
	session_start();
	$_SESSION['pageTitle'] = 'Companies';
	include '../header.php';
	include '../Classes/PointOfContact.php';
	
	$contacts = getAllPointsOfContact();
	
	//print_r($contacts);
?>
	<body>
		<h2>Points of Contact</h2>
		<div><a href='editPointOfContact.php'>Add an Point of Contact</a></div>
		<table>
			<thead>
				<tr><th>Name</th><th>Company Name</th><th>Phone</th><th>Email</th><th>Date</th><th>Edit</th>
				<?php
					if($_SESSION['user_is_admin'] == 1)
						echo "<th>Delete</th>";
				?>
				</tr>
			</thead>
			<?php
				$a = 0;
				foreach($contacts as $contact){
					$a++;
					$rowStyle = ($a % 2 == 0) ? 'even' : 'odd';
					echo "<tr class ='".$rowStyle."'><td>".str_replace("'", "", $contact['fName'])." ".str_replace("'", "", $contact['lName'])."</td>";
					if($contact['isIndividual'])
						echo "<td>* Individual *</td>";
					else
						echo "<td>".str_replace("'", "", $contact['companyName'])."</td>";
					echo "<td>".str_replace("'", "", $contact['phone'])."</td>";
					echo "<td>".str_replace("'", "", $contact['email'])."</td>";
					echo "<td>".date("F j, Y", strtotime($contact['dateCreated']))."</td>";
					echo "<td> <a href='editPointOfContact.php?id=".$contact['id']."'>Edit</a></td>";
					if($_SESSION['user_is_admin'] == 1)
						echo "<td> <a href='deletePOC.php?id=".$contact['id']."'>Delete</a></td>";
					echo "</tr>";
				}
			?>
		</table>
<?php 
	include '../footer.php';
?>