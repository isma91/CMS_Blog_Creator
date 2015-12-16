/*jslint browser: true, node : true*/
/*jslint devel : true*/
/*global $, document, this*/
$(document).ready(function(){
	var i, j, k;
	i = 0;
	j = 0;
	k = 0;
	get_last_six_blogs();
	setInterval(get_last_six_blogs, 60000);
	function get_last_six_blogs() {
		$.get("models/get_last_blogs.php", function (data) {
			$("div#last_six_blogs").html("");
			data = JSON.parse(data);
			if (data === null) {
				$("div#last_six_blogs").html('<div class="jumbotron"><h2 class="blog_name">No Blog yet !!</h2><div class="mui-panel"></div></div>');
			} else {
				for (i = 0; i < data.blog_id.length; i = i + 1) {
					document.getElementById('last_six_blogs').innerHTML = document.getElementById('last_six_blogs').innerHTML + '<div class="jumbotron resume_last_six_blog"><h2><a href="?blog=' + data.slug[i] + '">' + data.blog_name[i] + '</a></h2><h3><a href="?profile=' + data.user_id[i] +  '">' + data.username[i] + '</a></h3><div id="' + data.slug[i] +'"></div></div>';
				}
				for (j = 0; j < data.slug.length; j = j + 1) {
					$.getJSON('api/?blog=' + data.slug[j] + '&limit=2', function (data) {
						if (typeof data.articles !== "undefined") {
							for (k = 0; k < data.articles.length; k = k + 1) {
								if (data.articles[k].content.length > 15) {
									data.articles[k].content = data.articles[k].content.substr(0, 15);
									data.articles[k].content = data.articles[k].content + "...";
								}
								document.getElementById(data.slug).innerHTML = document.getElementById(data.slug).innerHTML + '<div class="mui-panel"><h3 class="post_title">' + data.articles[k].title + '</h3><div class="mui-divider"></div><p>' + data.articles[k].content + '</p><div class="mui-divider"></div><i>' + data.articles[k].created_at + '</i></div>';
							}
						} else {
							document.getElementById(data.slug).innerHTML = '<div class="mui-panel"><h3 class="post_title">Not posts in this blog yet !!</h3></div>';
						}
					});
				}
			}
		});
	}
});