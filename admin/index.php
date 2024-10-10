<?php
	include "../controller.php";

	if(isset($_SESSION['username']) && isset($_SESSION['password'])){
		header("Location: manageData.php");
    	exit();
	}
?>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Registration form sangamam</title>
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css">
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">
		<link rel="stylesheet" href="../node_modules/mdbootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="../node_modules/mdbootstrap/css/mdb.min.css">
		<link rel="stylesheet" href="../node_modules/mdbootstrap/css/style.css">

		<script type="text/javascript" src="../node_modules/mdbootstrap/js/jquery.min.js"></script>
		<script type="text/javascript" src="../node_modules/mdbootstrap/js/popper.min.js"></script>
		<script type="text/javascript" src="../node_modules/mdbootstrap/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="../node_modules/mdbootstrap/js/mdb.min.js"></script>
	</head>
	<body>
		<section class="ftco-section">
			<div class="container">
				<div class="row justify-content-center">
					<div class="col-md-6 text-center mb-5">
						<h2 class="heading-section"></h2>
					</div>
				</div>
				<div class="row justify-content-center">
					<div class="col-md-7 col-lg-5">
						<div class="login-wrap p-4 p-md-5">
							<div class="icon d-flex align-items-center justify-content-center">
								<span class="fa fa-user-o"></span>
							</div>
							<h3 class="text-center mb-4">Sign In</h3>
							<form action="" id="login" method="post" class="login-form">
								<div class="form-group">
									<input type="text" class="form-control rounded-left" id="username" name="username" placeholder="Username" required>
								</div>
								<div class="form-group d-flex">
									<input type="password" class="form-control rounded-left" id="password" name="password" placeholder="Password" required>
								</div>
								<div class="form-group">
									<button type="submit" name="submit" class="form-control btn btn-primary rounded submit px-3">Login</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</section>
	</body>
	<script type="text/javascript">
		$("#login").on("submit",function(e){
			e.preventDefault();

			var user = $("#username").val();
			var pass = $("#password").val();

			if((user == "admin") && (pass == "admin@123")){
				var data ={
					"username" : user,
					"password":pass
					}
				$.ajax({
		            url: '../session.php', // PHP script to handle setting the session
		            type: 'POST',
		            data: { "setSession":data,
		            		"method":"setSession" }, // Data to be sent to the server
		            success: function(response) {
		                // Handle success if needed
		                window.location.href = "../manageData.php";
		            },
		            error: function(xhr, status, error) {
		                // Handle errors if any
		                console.error('Error setting session value:', error);
		            }
		        });
				
			}else{
				alert("Invalid Credintials.");
			}
		});
	</script>
</html>