/*jslint browser: true, node : true*/
/*jslint devel : true*/
/*global $, document, this*/
$(document).ready(function(){
	var get, i, array_get, slug, post_id;
	i = 0;
	get = document.location.search.substr(1);
	array_get = get.split('&');
	slug = array_get[0].substr(5);
	post_id = array_get[1].substr(5);
	$("a.retour").attr("href", "?blog=" + slug);
	$.getJSON('api/?post=' + post_id, function (data) {
		data.nb_comments = parseInt(data.nb_comments);
		$("h2#post_title").html(data.title);
		$("div#post_content").html('<p>' + data.content + '</p>');
		if (data.medias.length === 0) {
			$("div#post_medias").html('<p class"title">No media in this post</p>');
		} else {
			$("div#post_medias").html();
		}
		$("div#post_footer").html('<p class="floated_left">Created at <i>' + data.created_at + '</i></p><p class="floated_right">Update at <i>' + data.updated_at + '</i></p>');
		if (data.nb_comments === 0) {
			$("div#post_comments").html('<p class="title">No comments yet</p>');
		} else {
			$("div#post_comments").html();
		}
	});
});