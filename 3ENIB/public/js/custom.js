$(document).ready(function(){
	$("#signup-company").fadeOut();
	$("#student-subscription").change(function(){
		if($(this).is(':checked')){
			$("#signup-company").fadeOut();
			$("#signup-student").fadeIn();
		}
	});
	$("#company-subscription").change(function(){
		if($(this).is(':checked')){
			$("#signup-company").fadeIn();
			$("#signup-student").fadeOut();
		}
	});

	$(".post-panel-remove").click(function(event) {
		if (confirm('Are you sure you want to save this thing into the database?')) {
    		alert("oui");
		} 
		else {
		    alert("non");
		}
	});
});