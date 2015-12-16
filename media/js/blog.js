/*jslint browser: true, node : true*/
/*jslint devel : true*/
/*global $, document, this*/
$(document).ready(function(){
	var slug, i;
	i = 0;
	get_posts();
	setInterval(get_posts, 30000);
	function get_posts() {
		slug = document.location.search.substr(6);
		$.getJSON('api/?blog=' + slug, function (data) {
			$('meta[name=description]').remove();
			$('head').append( '<meta name="description" content="' + data.description + '">' );
			document.title = data.name;
			$("div#blog_name").html(data.name);
			if (typeof data.articles !== "undefined") {
				for (i = 0; i < data.articles.length; i = i + 1) {
					document.getElementById('blog_posts').innerHTML = document.getElementById('blog_posts').innerHTML + '<div class="jumbotron" id="' + data.articles[i].post_id + '"></div>'
				}
				for (j = 0; j < data.articles.length; j = j + 1) {
					if (data.articles[j].content.length > 150) {
						data.articles[j].content = data.articles[j].content.substr(0, 150);
						data.articles[j].content = data.articles[j].content + "...";
					}
					$("#" + data.articles[j].post_id).html('<div class="mui-panel"><h3 class="post_title">' + data.articles[j].title + '</h3></div><div class="mui-panel">' + data.articles[j].content + '</div><div class="mui-panel"><span class="floated_left">Créer le <i>' + data.articles[j].created_at + '</i></span><span class="floated_right">' + data.articles[j].nb_comments + ' Commentaire(s)</span></div></div>');
				}
			} else {
				$("#blog_posts").html('<div class="jumbotron">No post in this blog yet !!</div>');
			}
		});
	}
});