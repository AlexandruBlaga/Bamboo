$(document).ready(function() {

	//onclick signup, hide login and show reg form
	$("#signup").click(function() {
		$("#first").slideUp(300, function(){
			$("#second").slideDown(300);
		});
	});

	// onclick signin hide reg form show login form
	$("#signin").click(function() {
		$("#second").slideUp(300, function(){
			$("#first").slideDown(300);
		});
	});

})