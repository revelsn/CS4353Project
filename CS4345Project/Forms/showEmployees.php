<?php
	session_start();
	$_SESSION['pageTitle'] = 'Employees';
	include '../header.php';
	include '../Classes/Employee.php';
	
	$employees = getAllEmployees();
	
	//print_r($employees);
?>
	<body>
		<h2>Employees</h2>
		<div><a href='editEmployee.php'>Add an Employee</a></div>
		<table>
			<thead>
				<tr><th>Name</th><th>Date Employed</th><th>Location</th><th>Username</th><th>Edit</th>
				<?php
					if($_SESSION['user_is_admin'] == 1)
						echo "<th>Delete</th>";
				?>
				</tr>
			</thead>
			<?php
				$a = 0;
				foreach($employees as $emp){
					$a++;
					$rowStyle = ($a % 2 == 0) ? 'even' : 'odd';
					echo "<tr class ='".$rowStyle."'><td>".str_replace("'", "", $emp['fName'])." ".str_replace("'", "", $emp['lName'])."</td>";
					echo "<td>".date("F j, Y", strtotime($emp['dateEmployed']))."</td><td>".str_replace("'", "", $emp['location'])."</td>";
					echo "<td>".strtolower(str_replace("'", "", $emp['fName'])).'.'.strtolower(str_replace("'", "", $emp['lName'])).'.'.$emp['id']."</td>";
					echo "<td> <a href='editEmployee.php?empId=".$emp['id']."'>Edit</a></td>";
					if($_SESSION['user_is_admin'] == 1)
						echo "<td> <a href='deleteEmployee.php?empId=".$emp['id']."'>Delete</a></td></tr>";
				}
			?>
		</table>
<?php 
	include '../footer.php';
?>