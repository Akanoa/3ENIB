(function ( $ ) {
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
		if (confirm('Voulez vous supprimer ce message?')) {
			var val = $(this).parent()[0].href;
			window.location.replace(val);
		} 
		else {
		    return false;
		}
	});

	$(".post-edit").fadeToggle();

	$(".post-panel-edit").click(function(event){
		var form = $(this).parent().parent().find("form").fadeToggle();
		console.log("test");
	});

	tinymce.init({selector : '.post-edit-form',
				  plugins  : 'code image textcolor link',
				  toolbar  : "undo \
				  			  redo \
				  			  bold \
				  			  italic \
				  			  underline \
				  			  strikethrough \
				  			  alignleft \
				  			  aligncenter \
				  			  alignright \
				  			  alignjustify \
				  			  forecolor \
				  			  backcolor \
				  			  code \
				  			  image \
				  			  link \
				  			  ",
				});

}( jQuery ));

