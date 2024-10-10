<?php 
	include "controller.php";
	if(!isset($_SESSION['username']) && !isset($_SESSION['password'])){
		header("Location: admin/");
    	exit();
	}
	$data = fetchEventRegisterDetails();
?>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

	<!-- DataTables CSS -->
	<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">

	<!-- jQuery -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

	<!-- Bootstrap JS -->
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

	<!-- DataTables JS -->
	<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
	<style type="text/css">
		.float-button.login {
			position: fixed;
			top: 20px; /* Adjust the distance from the bottom */
			right: 20px; /* Adjust the distance from the right */
			background-color: #007bff;
			color: white;
			padding: 10px 20px;
			border-radius: 5px;
			text-decoration: none;
			transition: background-color 0.3s ease;
		}
		.float-button.register {
			position: fixed;
			top: 80px; /* Adjust the distance from the bottom */
			right: 20px; /* Adjust the distance from the right */
			background-color: #007bff;
			color: white;
			padding: 10px 20px;
			border-radius: 5px;
			text-decoration: none;
			transition: background-color 0.3s ease;
		}.float-button.export {
			position: fixed;
			top: 140px; /* Adjust the distance from the bottom */
			right: 20px; /* Adjust the distance from the right */
			background-color: #007bff;
			color: white;
			padding: 10px 20px;
			border-radius: 5px;
			text-decoration: none;
			transition: background-color 0.3s ease;
		}
		.float-button:hover {
			
		}
	</style>

</head>
<body style="padding-left: 9%;padding-right: 9%;">
	
	<img src="header1-after.png" style="width:100%">
	<table id="myDataTable" class="table">
	    <thead>
	        <tr>
	            <th>ID</th>
	            <th>Club Name</th>
	            <th>Name</th>
	            <th>Call Name</th>
	            <th>Type</th>
	            <th>Transaction Ref.</th>
	            <th>Action</th>
	            <!-- Add more table headers as needed -->
	        </tr>
	    </thead>
	    <tbody>
	    	<?php foreach($data as $row){ ?>
	        <tr>
	            <td><?php echo $row["id"]; ?></td>
	            <td><?php echo $row["clubName"]; ?></td>
	            <td><?php echo $row["name"]; ?></td>
	            <td><?php echo $row["callName"]; ?></td>
	            <td><?php echo $row["type"]; ?></td>
	            <td><?php echo $row["transaction_ref"]; ?></td>
	            <td><a href="<?php echo $row["receipt_path"]; ?>" target="new"><i class="fa fa-download"></i></a></td>
	            <!-- Add more table data rows as needed -->
	        </tr>
	    <?php }?>
	        <!-- More rows -->
	    </tbody>
	</table>
	<div class="btn float-button login" id="logout">Logout</div>
	<div class="btn float-button register" id="register">Register</div>
	<div class="btn float-button export" id="export">Export <i class='fas fa-file-export'></i></div>

</body>
<script type="text/javascript">
	$(document).ready(function() {

	    $('#myDataTable').DataTable({
	        "paging": true, // Enable pagination
	        "searching": true, // Enable search functionality
	        // Add more options as needed
	    });
	});

	$("#logout").click(function(e){
		e.preventDefault();

		if(confirm("Are you sure logout ?")){
			$.ajax({
		            url: 'session.php', // PHP script to handle setting the session
		            type: 'POST',
		            data: {"method":"unsetSession" }, // Data to be sent to the server
		            success: function(response) {
		                // Handle success if needed
		                window.location.href ="index.php";
		            },
		            error: function(xhr, status, error) {
		                // Handle errors if any
		                console.error('Error setting session value:', error);
		            }
		        });
		}
	});

	$("#register").click(function(e){
		e.preventDefault();

		window.location.href = "/";
	});
	$("#export").click(function (e) {
		window.location.href ="export.php"
	});

</script>
</html>