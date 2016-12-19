<script type="text/javascript">
$(document).ready(function() {//When the dom is ready
	$("#username").change(function() { //if theres a change in the username textbox
	
	var username = $("#username").val();//Get the value in the username textbox
	var re =/^\w+$/; ///[a-zA-Z0-9]/; //^\w+$
	if (re.test(username)) {
	//var matches = regexuser.exec(username); // either an array or null
	//var matchStatus = Boolean(matches);
	//if(ereg('^[a-zA-Z0-9-_\.]', username)){
	//if (matchStatus){
	if(username.length > 5){ //if the lenght greater than 3 characters

		$("#availability_status").html('<img src="/forum/images/icon/loader.gif" align="absmiddle"> <!--&nbsp;Checking availability...-->');
			//Add a loading image in the span id="availability_status"

		$.ajax({  //Make the Ajax Request
			type: "POST",  
			url: "checkuseremail_register.php",  //file name
			data: "username="+ username,  //data
			success: function(server_response){  
		   alert(server_response);
			   $("#availability_status").ajaxComplete(function(event, request){ 
					if(server_response == '0'){ //if ajax_check_username.php return value "0"
						$("#availability_status").html('<img src="/forum/images/icon/available.png" align="absmiddle"> <!--font color="Green"> Available </font-->  ');
						//add this image to the span with id "availability_status"
					}  
					else  if(server_response == '1'){//if it returns "1"
						$("#availability_status").html('<img src="/forum/images/icon/not_available.png" align="absmiddle"> <!--font color="red">Not Available </font-->');
					}  
				});
			} 
		}); 

	}
	else{
		alert("Error: Username must contain only letters, numbers and underscores!");
		$("#availability_status").html('<font color="#cc0000">Username too short</font>');
		 
	    //if in case the username is less than or equal 3 characters only 
	}
	return false;
	}
	else{
		$("#availability_status").html('<img src="/forum/images/icon/not_available.png" align="absmiddle"> <!--font color="red">Not Available </font-->');
	}
	});
	
	
	$("#email").change(function() { //if theres a change in the username textbox

		var email = $("#email").val();//Get the value in the username textbox
	
	var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	if (regex.test(email)){

		$("#avaitatus").html('<img src="/forum/images/icon/loader.gif" align="absmiddle"><!--&nbsp;Checking availability...-->');
			//Add a loading image in the span id="availability_status"

		$.ajax({  //Make the Ajax Request
			type: "POST",  
			url: "checkuseremail_register.php",  //file name
			data: "email="+ email,  //data
			success: function(server_response){  
			alert(server_response);
			   $("#avaitatus").ajaxComplete(function(event, request){ 
					if(server_response == '0'){ //if ajax_check_username.php return value "0"
						$("#avaitatus").html('<img src="/forum/images/icon/available.png" align="absmiddle"> <!--font color="Green"> Available </font-->  ');
						//add this image to the span with id "availability_status"
					}  
					else  if(server_response == '1'){//if it returns "1"
						$("#avaitatus").html('<img src="/forum/images/icon/not_available.png" align="absmiddle"> <!--font color="red">Not Available </font-->');
					}  
				});
			} 
		}); 

	return false;
	}
	else{
		$("#avaitatus").html('<img src="/forum/images/icon/not_available.png" align="absmiddle"> <!--font color="red">Not Available </font-->');
	}
	});
	
});

</script>