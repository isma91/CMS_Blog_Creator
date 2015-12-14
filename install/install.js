/*jslint browser: true, node : true*/
/*jslint devel : true*/
/*global $, document, this*/
$(document).ready(function(){
	var password_good, confirm_password_good, email_good;
	password_good = false;
	confirm_password_good = false;
	email_good = false;
	$("button.toggle_install").click(function(){
		$("div.form_install").fadeToggle("slow");
		$("button.toggle_install").remove();
	});
	$("button.next_step_install").click(function(){
		$("div.div_form_install").fadeToggle("slow");
		$("div.db_install").fadeIn("slow");

	});
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
			password_good = false;
			$("span#span_label_password").html(" at least 5 characters").css("color", "#808080");
			$(this).css({"border-color":"#808080"});
			break;
			case 1:
			password_good = true;
			$("span#span_label_password").html(" weak").css("color", "#FF0000");
			$(this).css({"border-color":"#FF0000"});
			break;
			case 2:
			password_good = true;
			$("span#span_label_password").html(" weak").css("color", "#FF0000");
			$(this).css({"border-color":"#FF0000"});
			break;
			case 3:
			password_good = true;
			$("span#span_label_password").html(" medium").css("color", "#FFA500");
			$(this).css({"border-color":"#FFA500"});
			break;
			case 4:
			password_good = true;
			$("span#span_label_password").html(" strong").css("color", "#007B00");
			$(this).css({"border-color":"#007B00"});
			break;
		}
	});
	$("input#confirm_password").bind('change paste keyup', function() {
		if ($(this).val() !== $("input#password").val()) {
			confirm_password_good = false;
			$(this).css({"border-color":"#FF0000"});
			$("span#span_label_confirm_password").html(" not the same password").css("color", "#FF0000");
		} else {
			confirm_password_good = true;
			$(this).css({"border-color":"#007B00"});
			$("span#span_label_confirm_password").html(" same password").css("color", "#007B00");
		}
	});
	$("input#email").bind('change paste keyup', function() {
		var regexEmail;
		regexEmail = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
    	if (regexEmail.test($(this).val())) {
    		email_good = true;
			$(this).css({"border-color":"#007B00"});
			$("span#span_label_email").html(" valid email").css("color", "#007B00");
		} else {
			email_good = false;
			$(this).css({"border-color":"#FF0000"});
			$("span#span_label_email").html(" not an email").css("color", "#FF0000");
		}
	});
	$("button#check_database").click(function() {
		var host, username, db_password, db_name;
		host = $("input#host").val();
		username = $("input#username").val();
		db_password = $("input#db_password").val();
		db_name = $("input#db_name").val();
		$.post( "test_db.php", {host: host, username: username, password: db_password, database_name: db_name}, function (data) {
			if (data.substr(0, 5) === "Error") {
				$("div#event").css("display", "none");
				$("div#event").html('<div class="alert alert-danger event-danger">' + data + '</div>');
				$("div#event").fadeIn('slow');
				$("button#finish_install").attr('disabled', "true");
			} else {
				$("div#event").css("display", "none");
				$("div#event").html('<div class="alert alert-success event-success">' + data + '</div>');
				$("div#event").fadeIn('slow');
				$("button#finish_install").removeAttr('disabled');
			}
		});
	});
	$("button#create_database").click(function () {
		var host, username, db_password, db_name;
		host = $("input#host").val();
		username = $("input#username").val();
		db_password = $("input#db_password").val();
		db_name = $("input#db_name").val();
		/* @TODO : mettre ce ajax post juste apres que l'installation soit fini et apres remplir la bdd */
		/*$.post( "create_config.php", {host: host, username: username, password: db_password, database_name: db_name}, function (data) {
			if (data !== 0) {
				$("div#event").html('<div class="alert alert-success event-success">Config file created !!</div>');
				$("div#event").fadeIn('slow');
			} else{
				$("div#event").html('<div class="alert alert-danger event-danger">Error when creating the config file !!</div>');
				$("div#event").fadeIn('slow');
			}
		});*/
		$.post( "install_db.php", {host: host, username: username, password: db_password, database_name: db_name}, function (data) {
			var data_error;
			data_error = false;
			if (data.substr(0, 5) === "Error") {
				$("div#event").css("display", "none");
				$("div#event").html('<div class="alert alert-danger event-danger">' + data + '</div>');
				$("div#event").fadeIn('slow');
			} else {
				$("div#event").css("display", "none");
				$("div#event").html('<div class="alert alert-success event-success">' + data + '</div>');
				$("div#event").fadeIn('slow');
			}
		});
	});
	$("input").bind('change paste keyup', function() {
		if ($("input#last_name").val().length > 0 && $("input#first_name").val().length > 0 && $("input#pseudo").val().length > 0 && password_good === true && confirm_password_good === true && email_good === true) {
			$("button.next_step_install").removeAttr('disabled');
		} else {
			$("button.next_step_install").attr('disabled', "true");
		}
	});
});