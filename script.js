var optionsHTML = "";

// Original functionality (populating select options)
$("#rotaryClubListSearch").change(function(){
	var club = $(this).val();
	
	$.ajax({
	  url:"ajax.php",
	  method:"post",
	  data:{
		"target":"getRotarians",
		"data":{"value":club}
	  },
	  success:function(res){
		var data = JSON.parse(res);
		if (data.status == "success") {
		  data = data.data;
		  var rotarianOptionsHTML = "<option value =''>~~~ Select Rotarian ~~~</option>";
		  $.each(data,function(index,value) {
			rotarianOptionsHTML += "<option value='"+value.key+"'>"+value.value+"</option>";
		  });
		  optionsHTML = rotarianOptionsHTML;
		  $(".rotarianSearch").html(optionsHTML);
		  $(".registerer_name").html(optionsHTML);
		  $('.rotarianSearch').select2();
		  $('.registerer_name').select2();
		}
	  }
	});
  });
  
  // New functionality (populating table rows) when checkbox is checked
$("#select-all-rotarians").change(function() {
	if ($(this).is(':checked')) {
		$("#rotaryClubListSearch").change(function(){
			var club = $(this).val();
			
			$.ajax({
			url:"ajax.php",
			method:"post",
			data:{
				"target":"getRotarians",
				"data":{"value":club}
			},
			success:function(res){
				var data = JSON.parse(res);
				if (data.status == "success") {
				data = data.data;
				var rowCount = 1;
				$('#rotarianTable tbody').empty(); 
				$.each(data, function(index, value) {
					var rowHtml = "<tr>\
					<th scope='row'>" + rowCount + "</th>\
					<td>" + value.value + "</td>\
					<td><input type='text' class='form-control' name='rotarian_call_name[]'></td>\
					<td>" + value.mobile + "</td>\
					<td><input type='checkbox' class='ann-checkbox'></td>\
					<td><input type='checkbox' class='annette-checkbox'></td>\
					<td>\
						<select class='form-select' name='food_preference[]'>\
						<option value=''>Select Food Preference</option>\
						<option value='Veg'>Veg</option>\
						<option value='Non Veg'>Non Veg</option>\
						<option value='Sat Veg Sunday Non Veg'>Sat Veg & Sunday Non Veg</option>\
						</select>\
					</td>\
					</tr>";
					$('#rotarianTable tbody').append(rowHtml);
					rowCount++;
				});
				}
			}
			});
		});
	}
});

  

/*$("#registerer_club").change(function(){
	var club = $(this).val();
	
	$.ajax({
		url:"ajax.php",
		method:"post",
		data:{
			"target":"getRotarians",
			"data":{"value":club}
		},
		success:function(res){
			var data = JSON.parse(res);
			if (data.status == "success") {
				data = data.data;
				var rotarianOptionsHTML = "<option value =''>~~~ Select Registerer ~~~</option>";
				$.each(data,function(index,value) {
					rotarianOptionsHTML += "<option value='"+value.key+"'>"+value.value+"</option>";
				});
				let optionsHTML = rotarianOptionsHTML;
				$(".registerer_name").html(optionsHTML);
				$('.registerer_name').select2();
			}
		}
	});
});
*/
$("#registerer_name").change(function(){

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
							
							$("#registerer_mobile").val(data.mobile_no);
							$("#registerer_email").val(data.email);

						}
					}
				});
			});
$("#rotarianRegister").on("submit",function(e){
	e.preventDefault();
	// var data = $("form").serializeArray();
	var data = new FormData(this);
	
		$('body').addClass("disabled blur");
		$('.loading').show();
	
	$.ajax({
		url:"ajax.php",
		method:"post",
		processData: false, // Prevent jQuery from processing the data
        contentType: false,
		data:data,
		success:function(res){
			var response = JSON.parse(res);
			// console.log(response);
			$('.loading').css("display","none");
			$('body').removeClass("disabled blur");	
			if(response.error ==1){
				clearErrors();
				var transactionErrors = response.data.transaction;
				var rotarianErrors = response.data.rotarian;
				var annErrors = response.data.ann;
				var annetteErrors = response.data.annette;
				if( Object.keys(transactionErrors).length > 0 )
					messagevalidation(transactionErrors);

				if( Object.keys(annErrors).length > 0 )
					messagevalidation(annErrors);

				if( Object.keys(annetteErrors).length > 0 )
					messagevalidation(annetteErrors);

						
				
			}else{
				alert("Rotarians are registered successfully!.");
				window.location.reload();
				$('.loading').css("display","none");
				$('body').removeClass("disabled blur");
			}
		}
	});
});

function messagevalidation(data){
	$.each(data,function(finder,error){
		
		$('[name="'+finder+'"]').closest('.form-group').append("<span class='error'>"+error+"</span>");
	})

}
function clearErrors() {
	$(".error").remove();
}




