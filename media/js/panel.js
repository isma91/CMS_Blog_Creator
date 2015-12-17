/*jslint browser: true, node : true*/
/*jslint devel : true*/
/*global $, document, this*/
$(document).ready(function(){
	var user_name, toggle_account_count, toggle_blogs_count, toggle_create_blog_count;
	toggle_account_count = 0;
	toggle_blogs_count = 0;
	toggle_create_blog_count = 0;
	user_name = $("span#user_name").html();
	$('meta[name=description]').remove();
	$('head').append( '<meta name="description" content="Admin panel of ' + user_name + '">' );
	document.title = user_name + "'s admin panel";
	$("button.toggle_account").click(function() {
		toggle_account_count = toggle_account_count + 1;
		if (toggle_account_count % 2 === 0) {
			$("button.toggle_account").html('Hide your Account <span class="glyphicon glyphicon-user"></span>');
		} else {
			$("button.toggle_account").html('Display your Account <span class="glyphicon glyphicon-user"></span>');
		}
		$("div.account").fadeToggle("slow");
	});
	$("button.toggle_blogs").click(function() {
		toggle_blogs_count = toggle_blogs_count + 1;
		if (toggle_blogs_count % 2 === 0) {
			$("button.toggle_blogs").html('Display all your Blogs <span class="glyphicon glyphicon-folder-open"></span>');
		} else {
			$("button.toggle_blogs").html('Hide all your Blogs <span class="glyphicon glyphicon-folder-close"></span>');
		}
		$("div.blogs").fadeToggle("slow");
	});
	$("button.toggle_create_blog").click(function() {
		toggle_create_blog_count = toggle_create_blog_count + 1;
		if (toggle_create_blog_count % 2 === 0) {
			$("button.toggle_create_blog").html('Display Create Blog <span class="glyphicon glyphicon-plus"></span>');
		} else {
			$("button.toggle_create_blog").html('Hide Create Blog <span class="glyphicon glyphicon-minus"></span>');
		}
		$("div.create_blog").fadeToggle("slow");
	});
	$("input#blog_domain").bind("change paste keyup", function() {
		if ($(this).val().length > 30) {
			$(this).val($(this).val().substr(0, 30));
		}
		$("span#blog_slug").html($(this).val() + ".blog-creator.prod");
	});
	$("input#blog_name").bind("change paste keyup", function() {
		if ($(this).val().length > 40) {
			$(this).val($(this).val().substr(0, 40));
		}
	});
});