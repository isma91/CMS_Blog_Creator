/*jslint browser: true, node : true*/
/*jslint devel : true*/
/*global $, document, this*/
$(document).ready(function(){
	$("input#password").bind("change paste keyup", function() {
		var score, password;
		score = 0;
		password = $(this).val();
		if (password.length > 4) {
			score = score + 1;
		}
		if (password.length > 4 && (password.match(/[a-z]/)) && (password.match(/[A-Z]/))) {
			score = score + 1;
		}
		if (password.length > 4 && password.match(/\d+/)) {
			score = score + 1;
		}
		if (password.length > 4 && password.match(/.[!,@,#,$,%,^,&,*,?,_,~,-,(,)]/) ) {
			score = score + 1;
		}
		switch (score) {
			case 0:
			$("span#span_label_password").html(" at least 5 characters").css("color", "#808080");
			$(this).css({"border-color":"#808080"});
			break;
			case 1:
			$("span#span_label_password").html(" weak").css("color", "#FF0000");
			$(this).css({"border-color":"#FF0000"});
			break;
			case 2:
			$("span#span_label_password").html(" weak").css("color", "#FF0000");
			$(this).css({"border-color":"#FF0000"});
			break;
			case 3:
			$("span#span_label_password").html(" medium").css("color", "#FFA500");
			$(this).css({"border-color":"#FFA500"});
			break;
			case 4:
			$("span#span_label_password").html(" strong").css("color", "#007B00");
			$(this).css({"border-color":"#007B00"});
			break;
		}
	});
	$("input#confirm_password").bind('change paste keyup', function() {
		if ($(this).val() !== $("input#password").val()) {
			$(this).css({"border-color":"#FF0000"});
			$("span#span_label_confirm_password").html(" not the same password").css("color", "#FF0000");
		} else {
			$(this).css({"border-color":"#007B00"});
			$("span#span_label_confirm_password").html(" same password").css("color", "#007B00");
		}
	});
});