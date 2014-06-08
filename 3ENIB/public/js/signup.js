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
});