/*jslint browser: true, node : true*/
/*jslint devel : true*/
/*global $, document, this*/
$(document).ready(function(){
	var i;
	i = 0;
	get_last_six_blogs();
	setInterval(get_last_six_blogs, 60000);
	function get_last_six_blogs() {
		$.get("models/get_last_blogs.php", function (data) {
			$("div#last_six_blogs").html("");
			data = JSON.parse(data);
			for (i = 0; i < data.blog_id.length; i = i + 1) {
				document.getElementById('last_six_blogs').innerHTML = document.getElementById('last_six_blogs').innerHTML + '<div class="jumbotron resume_last_six_blog"><h2><a href="?blog=' + data.blog_id[i] + '">' + data.blog_name[i] + '</a></h2><h3><a href="?profile=' + data.user_id[i] +  '">' + data.username[i] + '</a></h3><div class="mui-panel"><h3>blog content</h3></div></div>';
			}
			console.log(data.blog_id);
			console.log(data.blog_name);
			console.log(data.slug);
			console.log(data.user_id);
			console.log(data.username);
		});
	}
});