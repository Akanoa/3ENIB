
var document_added = 0;

function removeDocument (element){
	document_added--;
	if($("#documents").children().length>1)
			element.parentNode.parentNode.remove();
	else
		return false;
	var documents = $("#documents").children();

	var i = 0;

	var inputs = $(".document .visibility input");
	for (input in inputs)
	{
		inputs[input].name = "private["+i+"]";
		i++;
	}
}

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

	$(".remove-document").click(function(event) {
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

	$("#add-document").click(function(event){
		document_added++;
		$("#documents").append($(".document")[0].outerHTML);
		var inputs = $("#documents .document:last-child .visibility input");
		for (input in inputs)
		{
			inputs[input].name = "private["+document_added+"]";
		}
	});

}( jQuery ));

