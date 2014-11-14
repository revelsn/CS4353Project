<?php
	session_start();
	$_SESSION['pageTitle'] = 'Employees';
	include '../header.php';
	include '../Classes/Employee.php';
	
	$employees = getAllEmployees();
?>
	<body>
		<h2>Employees</h2>
		<div><a href='editEmployee.php'>Add an Employee</a></div>
		<table>
			<thead>
				<tr><th>Name</th><th>Date Employed</th><th>Location</th><th>Edit</th><th>Delete</th></tr>
			</thead>
			<?php
				$a = 0;
				foreach($employees as $emp){
					$a++;
					$rowStyle = ($a % 2 == 0) ? 'even' : 'odd';
					echo "<tr class ='".$rowStyle."'><td>".str_replace("'", "", $emp['fName'])." ".str_replace("'", "", $emp['lName'])."</td><td>".date("F j, Y", strtotime($emp['dateEmployed']))."</td><td>".$emp['location']."</td><td> <a href='editEmployee.php?empId=".$emp['id']."'>Edit</a></td><td> <a href='deleteEmployee.php?empId=".$emp['id']."'>Delete</a></td></tr>";
				}
			?>
		</table>
<?php 
	include '../footer.php';
?>