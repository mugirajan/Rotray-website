<?php
	include('controller.php');
	$login = False;
	if(isset($_SESSION['username']) && isset($_SESSION['password'])){
		$login = True;
	}

	$rotarian_list = getRotarianList();
	$rotaryClubList = getRotaryClubs();
?>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Registration form - Shubha Mangalam - The Finale</title>
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script> 

		<link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.css" rel="stylesheet"/>
	    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.js"></script>
	    <script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.full.js"></script>
	    <script src="script.js"></script>
	</head>
	<style type="text/css">
		:root{
			--bs-border-color: black;
			--danger:red;
		}

		.required-color{
			color: var(--danger);
		}
		.error{
			color: var(--danger);
		}
		
		.dotted {
		    border:0;
		    border-bottom: 2px dotted;
		}
		.textBox{
			width: fit-content !important;
		}
		.input-group>.form-control{
			margin-top:-5px !important;
		}
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
		.loading {
			position: fixed;
			top: 50%; /* Adjust the distance from the bottom */
			right: 50%; /* Adjust the distance from the right */
			left:50%;
			bottom: 50%;
			background-color: transparent;
			color: white;
			padding: 10px 20px;
			border-radius: 5px;
			text-decoration: none;
			transition: background-color 0.3s ease;
			display: none;
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
		}
		.select2-container--default .select2-selection--single{
			border: 1px solid black;
		}
		.form-control{
			border:1px solid var(--bs-border-color) ;
		}
		.disabled {
		   pointer-events: none; /* Disable pointer events */
		   opacity: 0.5;
		}
		/* Style the container holding the checkboxes */
		#rotariansCheckboxes {
			border: 1px solid #ddd;
			padding: 10px;
			border-radius: 5px;
			background-color: #f9f9f9;
			max-height: 300px; 
			overflow-y: auto;
		}

		#rotariansCheckboxes input[type="checkbox"] {
			margin-right: 10px;
		}

		#rotariansCheckboxes div {
			padding: 5px 0;
			font-family: Arial, sans-serif;
			font-size: 14px;
		}

		#rotariansCheckboxes label {
			font-weight: bold;
		}

		#selectAllRotarians {
			margin-right: 10px;
		}

		label[for="selectAllRotarians"] {
			font-size: 16px;
			color: #333;
		}

		#rotariansCheckboxes label:hover {
			color: #007bff;
			cursor: pointer;
		}

		#rotariansCheckboxes div:hover {
			background-color: #e8f0fe;
		}

		#rotarianCard {
			box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
			border-radius: 8px;
			padding: 15px;
			background-color: white;
			margin-bottom: 20px;
		}

		#rotariansCheckboxes::-webkit-scrollbar {
			width: 6px;
		}

		#rotariansCheckboxes::-webkit-scrollbar-track {
			background: #f1f1f1;
		}

		#rotariansCheckboxes::-webkit-scrollbar-thumb {
			background-color: #888;
			border-radius: 10px;
		}

		#rotariansCheckboxes::-webkit-scrollbar-thumb:hover {
			background: #555;
		}
	</style>
	<body class="" style="text-align: center;">
	<section style="width: 90%;margin: auto">
		<div class="row">
			<div class="col">
				<!-- <img src="sangamam.png" style="width:100%"> -->
				<img src="./229241.jpg" style="width:100%">
			</div>
		</div>
		<div> 
			
			<form id="rotarianRegister" method="post">
				<input type="hidden" name="target" value="formSubmit">
				<input type="hidden" name="data" value="">

				<div style="padding-left: 3.5%;padding-right: 3.5%">
					<!-- Select Rotarian Section -->
					<div class="col-auto">
						<input type="checkbox" id="select-all-rotarians" name="select-all-rotarians">
						<label for="select-all-rotarians">Select All Rotarians</label>
					</div>
					<!--select rotarian-->				
					<div class="form-group row">
						<div class="col" style="text-align:left">
							<label for="rotary_club_name" class="col-sm-2 col-form-label"><h5 class="required">Rotary Club of</h5></label>
					    	<select style="width: 100%" name ="rotaryClubListSearch" id="rotaryClubListSearch" class="rotaryClubListSearch form-select">
					    		<option value=""></option>
							  	<?php foreach($rotaryClubList as $option){?>
							  		<option value="<?php echo $option['key'];?>"><?php echo $option['value'];?></option>
							  		<?php }?>
						    </select>
					   	</div>
					</div>
					<br>
					<div>
						<ul class="nav nav-tabs" id="myTab" role="tablist">
						  	<li class="nav-item" role="presentation">
						    	<button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Rotarian</button>
						  	</li>
							<li class="nav-item" role="presentation">
						    	<button class="nav-link" id="guest-tab" data-bs-toggle="tab" data-bs-target="#guest" type="button" role="tab" aria-controls="guest" aria-selected="false">Guest</button>
						  	</li>
						  	<li class="d-none nav-item" role="presentation">
						    	<button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#ann" type="button" role="tab" aria-controls="profile" aria-selected="false">Ann</button>
						  	</li>
						  	<li class="d-none nav-item" role="presentation">
						    	<button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#annette" type="button" role="tab" aria-controls="contact" aria-selected="false">Annette</button>
						  	</li>
						</ul>

						<div class="tab-content" id="myTabContent">
							<div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
								<table class="table table-bordered table-hover" id="rotarianTable">
								  	<thead>
								    	<tr>
								      		<th scope="col">Sl.No</th>
								      		<th scope="col">Name</th>
								      		<th scope="col">Call Name</th>
											<th scope="col">Mobile</th>
											<th scope="col">Food Preference</th>
											<th scope="col">Partner</th>
											<th scope="col">Annette</th>
								    	</tr>
								  	</thead>
								  	<tbody>
									    
								  	</tbody>

								</table>

								<button  type= "button" class="btn btn-info" id="add-rotrain" style="float: right;margin-bottom:1rem">Add</button>
								
							</div>
							<div class="tab-pane fade" id="guest" role="tabpanel" aria-labelledby="guest-tab">
						  		
						  		<table class="table table-bordered table-hover" id="guestTable">
								  	<thead>
								    	<tr>
								      		<th scope="col">Sl.No</th>
								      		<th scope="col">Name</th>
								      		<th scope="col">Call Name</th>
								      		<th scope="col">Mobile</th>
											<th scope="col">Food Preference</th>
								    	</tr>
								  	</thead>
								  	<tbody>
									    
								  	</tbody>
								</table>
								<button type="button" class="btn btn-info" id="add-guest" style="margin-bottom:1rem;float: right;">Add</button>
								
						  	</div>
						  	<div class="tab-pane fade" id="ann" role="tabpanel" aria-labelledby="profile-tab">
						  		
						  		<table class="table table-bordered table-hover" id="annTable">
								  	<thead>
								    	<tr>
								      		<th scope="col">Sl.No</th>
								      		<th scope="col">Name</th>
								      		<th scope="col">Call Name</th>
								      		<th scope="col">Mobile</th>
								    	</tr>
								  	</thead>
								  	<tbody>
									    
								  	</tbody>
								</table>
								<button type="button" class="btn btn-info" id="add-ann" style="float: right;">Add</button>
								
						  	</div>
						  	<div class="tab-pane fade" id="annette" role="tabpanel" aria-labelledby="contact-tab">
						  		<table class="table table-bordered table-hover" id="annetteTable">
								  	<thead>
								    	<tr>
								      		<th scope="col">Sl.No</th>
								      		<th scope="col">Name</th>
								      		<th scope="col">Call Name</th>
								      		<th scope="col">Mobile</th>
								    	</tr>
								  	</thead>
								  	<tbody>
									    
								  	</tbody>
								  	
								</table>
								<button type="button" class="btn btn-info" id="add-annette" style="float: right;">Add</button>
								
						  	</div>
						</div>
					</div>
				</div>
				<div style="padding-left: 3.5%;padding-right: 3.5%">
					<table class="table table-bordered table-hover" id="paymentTable">
						<thead>
							<tr>
								<th scope="col">Category</th>
								<th scope="col">Rotarian</th>
								<th scope="col">Partner</th>
								<th scope="col">Annette</th>
								<th scope="col">Guest</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<th scope="row">Registration Charges</th>
								<td id="rotarianTotal">1500</td>
								<td id="annTotal">1500</td>
								<td id="annetteTotal">1500</td>
								<td id="guestTotal">1500</td>
							</tr>
						</tbody>
					</table>
				</div>
				<div style="text-align: center;padding-left: 3.5%;padding-right: 3.5%">
					<h5>Payment to be made in the form of Cheque / DD / NEFT / RTGS / UPI to</h5>
					<h5> Punniyamoorthy V. - City Union Bank - A/C.NO. 5001010133990970, IFSC - CIUB0000338</h4>
						<hr>
					<h4>PAYMENT DETAILS</h4>
					<div style="text-align:left;">
						<div class="row">
							<div class="col-sm-4">
							  	<div class="form-group disabled">
								    <label class="required" for="totalAmount">AMOUNT :</label>
									<input type="text" class="form-control dotted" name="totalAmount" id="totalAmount"> 
								</div>	
							</div>
							<div class="col-sm-4">
							  	<div class="form-group">
								    <label for="transactionRef" class="required">CHEQUE No. / DD. No. / Transaction ID :</label>
									<input type="text" class="form-control dotted" name="transactionRef" id="transactionRef"> 
								</div>	
							</div>

							<div class="col-sm-4" >
							  	<div class="form-group">
								    <label for="formFile" class="form-label required">Proof of Payment </label>
						 			<input class="form-control" type="file" name ="receipt" id="formFile">
								</div>	
							</div>
						</div>
					</div>
					<hr>
					<div class="rigisterer-detials" style="text-align:left;">
						<div class="row" style="text-align:center;">
							<div class="col">
								<h3>Registerer Details</h3>
							</div>
						</div>
						<div class="row">
							
							<div class="col-sm-4">
								<div class="form-group">
									<label class="required"> Registerer Name</label>
									<select style='width: 100%' name ='registerer_name' id='registerer_name' class='registerer_name form-select'>
										<option value=""></option>
									</select>
								</div>
							</div>
							<div class="col-sm-4">
								<div class="form-group">
									<label class="required">E-mail</label>
									<input type="email" class="form-control" name="registerer_email" id="registerer_email">
								</div>
							</div>
							<div class="col-sm-4">
								<div class="form-group">
									<label class="required">Mobile</label>
									<input type="text" class="form-control" name="registerer_mobile" id="registerer_mobile">
								</div>
							</div>
						</div>
					</div>
					
				</div>
				<br>
				<div class="row">
				  	<div class="input-group" style="text-align: center;">
					    <button type="submit" class="btn btn-primary" class="submit" >Submit</button>
					</div>	
				</div>
				<b><hr></b>
				<div class="">
					<div style="text-align: center;">
						<strong>
							<a href="website-terms-and-conditions.html">Website Terms & Conditions</a>
								|| 
							<a href="rid-3234-privacy-policy.html">RID 3234 Privacy Policy</a>
								|| 
							<a href="rid-3234-return-policy.html">Return Policy</a>
						</strong>
					</div>	
				</div>
				
				<!-- 
				<div class="row" style="text-align: center;">
					<h4>For Communications: Rtn Kannan A, G1, Guru Jeeva Flats, 24, 5th Main Road, (Near Independence Day Park),
					Nanganallur, Chennai - 600061 / 99429 04699 / kannanhextar@gmail.com</h4>
				</div>
				 -->

			</form>
		</div>
	</section>
		
	<?php if($login == False){ ?>
		<!-- <div class="float-button btn btn-primary login" id="login"> Admin</div> -->
		<?php }else{?>
		<div class="btn float-button login" id="logout">Exit</div>
		<div class="btn float-button register" id="manage">manage</div>
		<?php }?>
		<div class="loading" ><img src="loading.gif" style="height: 40px;width: 40px;"></div>
	</body>
	<script type="text/javascript">
		var optionsvalues = <?php echo json_encode($rotarian_list);?>; 
		var rowHtml ="";
		var rotarianRowCount = 1;
		var guestRowCount = 1; 
		var annRowCount = 1;
		var annetteRowCount = 1;
		var optionsHTML = "";
		$(document).ready(function(){
			$('.required').append("<span class='required-color'>*</span>");
			clearErrors();
		});

		function calculateMemberRegistrationFee(){
			var data = $("form").serializeArray();
			$.ajax({
				url:"ajax.php",
				method:"post",
				data:{
					"target":"calculateMemberRegistrationFee",
					"data":{
						"value": data
					}
				},
				success: function(res){
					var response = JSON.parse(res);
					$("#rotarianTotal").html(response.rotarian);				
					$("#annTotal").html(response.ann);				
					$("#annetteTotal").html(response.annette);
					$("#guestTotal").html(response.guest);
					$("#totalAmount").val(response.total);				
				}
			});
		}
		
		function getRotarianHTML(count) {
    				rotarianRowHtml = "<tr>\
                        <th scope='row'>"+count+"</th>\
                        <td>\
                            <select style='width: 100%' name ='rotarianSearch[]' id='rotarianSearch_"+count+"' class='rotarianSearch form-select'>"+optionsHTML+"</select>\
                        </td>\
                        <td><input type='text' class='form-control textBox' name='rotarian_call_name[]' id='rotarian_call_name"+count+"'></td>\
                        <td><input type='text' class='form-control textBox rotarian_mobile' name='rotarian_mobile[]' id='rotarian_mobile"+count+"'></td>\
                        <td><select class='form-select' name='food_preference[]' id='food_preference_"+count+"'>\
                                <option value=''>Select Food Preference</option>\
                                <option value='Veg'>Veg</option>\
                                <option value='Non Veg'>Non Veg</option>\
                                <option value='Sat Veg Sunday Non Veg'>Sat Veg & Sunday Non Veg</option>\
                            </select>\
                        </td>\
						<td><input type='button' value='add' class='add-partner-btn'></td>\
						<td><input type='button' value='add' class='add-annette-btn'></td>\
                       </tr>";
			return rotarianRowHtml;
		}

		function getAnnHTML(count) {
			annRowHtml = "<tr class='partner-fields'>\
					<th scope='row'>" + count + "</th>\
					<td><input type='text' class='ann_name form-control textBox' name='ann_name[]' id='ann_name_" + count + "' placeholder='Partner Name'></td>\
					<td><input type='text' class='form-control textBox ann_call_name' name='ann_call_name[]' id='ann_call_name_" + count + "' placeholder='Partner Call Name'></td>\
					<td><input type='text' class='form-control textBox' name='ann_mobile[]' id='ann_mobile_" + count + "' placeholder='Partner Mobile'></td>\
					<td><select class='form-select' name='ann_food_preference[]' id='ann_food_preference"+count+"'>\
					<option value=''>Select Food Preference</option>\
					<option value='Veg'>Veg</option>\
					<option value='Non Veg'>Non Veg</option>\
					<option value='Sat Veg Sunday Non Veg'>Sat Veg & Sunday Non Veg</option>\
					</select></td>";
			return annRowHtml;
		}
		
		function getAnnetteHTML(count) {
			rotarianRowHtml = "	<tr class='annette-fields'>\
									<th scope='row'>"+count+"</th>\
									<td>\
										<input type='text' class='form-control textBox annette_name' name='annette_name[]' id='annette_name_"+count+"' placeholder='Annette Name'>\
									</td>\
									<td><input type='text' class='form-control textBox annette_call_name' name='annette_call_name[]'id='annette_call_name_"+count+"' placeholder='Annette Call Name'></td>\
									<td><input type='text' class='form-control textBox' name='annette_mobile[]'id='annette_mobile"+count+"' placeholder='Annette Mobile'></td>\
									<td><select class='form-select' name='annette_food_preference[]' id='ann_food_preference"+count+"'>\
									<option value=''>Select Food Preference</option>\
									<option value='Veg'>Veg</option>\
									<option value='Non Veg'>Non Veg</option>\
									<option value='Sat Veg Sunday Non Veg'>Sat Veg & Sunday Non Veg</option>\
									</select></td>\
								</tr>";
			return rotarianRowHtml;
		}

		
		function getGuestHTML(count) {
			rotarianRowHtml= "<tr>\
				<th scope='row'>"+count+"</th>\
				<td><input type='text' class='guest_name form-control textBox' name='guest_name[]' id='guest_name_"+count+"'></td>\
				<td><input type='text' class='form-control textBox guest_call_name' name='guest_call_name[]' id='guest_call_name_"+count+"'></td>\
				<td><input type='text' class='form-control textBox' name='guest_mobile[]' id='guest_mobile_"+count+"'></td>\
				<td><select class='form-select' name='guest_food_preference[]' id='guest_food_preference_"+count+"'>\
					<option value=''>Select Food Preference</option>\
					<option value='Veg'>Veg</option>\
					<option value='Non Veg'>Non Veg</option>\
					<option value='Sat Veg Sunday Non Veg'>Sat Veg & Sunday Non Veg</option>\
				</select></td>\
			</tr>";
			return rotarianRowHtml;
		}

		function resetRotarian() {
			$(".rotarianSearch").change(function(){
				console.log("Captured rot event")
				calculateMemberRegistrationFee();
				var rotarianMemberId = $(this).val();
				var element = $(this);
				$.ajax({
					url:"ajax.php",
					method:"post",
					data:{
						"target":"getRotarianDetail",
						"data":{"value":rotarianMemberId}
					},
					success:function(res){
						var response = JSON.parse(res);
						if(response.status = "success"){
							var data = response.data;
							// console.log(data.mobile_no);
							element.closest("tr").find(".rotarian_mobile").val(data.mobile_no);
						}
					}
				});
			});

			$(".ann_name").change(function(){
				console.log("Captured Ann event")
				calculateMemberRegistrationFee();
			});	
			$(".annette_name").change(function(){
				console.log("Captured Annette event")
				calculateMemberRegistrationFee();
			});	
			$(".guest_name").change(function(){
				console.log("Captured guest event")
				calculateMemberRegistrationFee();
			});	
		}
		
		$(document).ready(function() {
			var rotarianTableElement = $("#rotarianTable");
			var guestTableElement = $("guestTable");
			var annTableElement = $("#annTable");
			var annetteTableElement = $("#annetteTable");
			
			for (var i = 1; i >= 1; i--) {
				rotarianTableElement.find('tbody').append(getRotarianHTML(rotarianRowCount));
				guestTableElement.find('tbody').append(getGuestHTML(guestRowCount))
				annTableElement.find('tbody').append(getAnnHTML(annRowCount));
				annetteTableElement.find('tbody').append(getAnnetteHTML(annetteRowCount));
				rotarianRowCount++;
				guestRowCount++;
				annRowCount++;
				annetteRowCount++;
			}
			
		    $('.rotarianSearch').select2();
		    $('.rotaryClubListSearch').select2();
		    $('.registerer_club').select2();
		    $('.registerer_name').select2();
		    resetRotarian();

		});

		$("#add-rotrain").click(function() {
			var rotarianTableElement = $("#rotarianTable");
			var rowCount = rotarianTableElement.find('tbody tr').length + 1; 
			
			var rotarianRowHtml = getRotarianHTML(rowCount);
			rotarianTableElement.find('tbody').append(rotarianRowHtml);
			
			$('.rotarianSearch').select2();
			resetRotarian();
		});

		$("#add-guest").click(function () {
			var guestTableElement = $("#guestTable");
			var currentRowCount = $("#guestTable tbody tr").length + 1;
			guestTableElement.find('tbody').append(getGuestHTML(currentRowCount));
			$('.rotarianSearch').select2();
			resetRotarian();
		});


		$("#add-ann").click(function () {
			var annTableElement = $("#annTable");
			

			annTableElement.find('tbody').append(getAnnHTML(annRowCount));
			annRowCount++;
			$('.rotarianSearch').select2();
			resetRotarian();
		});

		$("#add-annette").click(function () {
			var annetteTableElement = $("#annetteTable");
			

			annetteTableElement.find('tbody').append(getAnnetteHTML(annetteRowCount));
			annetteRowCount++;
			$('.rotarianSearch').select2();
			
			resetRotarian();
		});

		$("#login").click(function(e){
			window.location.href = "admin/";
		});
		$("#manage").click(function(e){
			window.location.href = "manageData.php"	;
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
		
	</script>
	<script src="script.js"></script>
</html>