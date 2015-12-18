/*jslint browser: true, node : true*/
/*jslint devel : true*/
/*global $, document, this*/
$(document).ready(function(){
	var get, array_get, slug, post_id, comment_title, comment_content, comment_select, error_add_comment, i, comments, plus_comment_id, minus_comment_id, j, comment_get_post_comments;
	i = 0;
	j = 0;
	get = document.location.search.substr(1);
	array_get = get.split('&');
	slug = array_get[0].substr(5);
	post_id = array_get[1].substr(5);
	comments = '';
	comment_get_post_comments = "";
	$("a.retour").attr("href", "?blog=" + slug);
	setInterval(get_post_comments, 60000);
	function get_post_comments() {
		$.getJSON('api/?post=' + post_id, function (data) {
			if (data.nb_comments === 0) {
				$("div#post_comments").html('<p class="title">No comments yet</p>');
			} else {
				$.getJSON('api/?connected=user', function (data_user_connected) {
					if (data_user_connected.connected === false) {
						for (i = 0; i < data.comments.title.length; i = i + 1) {
							comments = comments + '<div class="mui-panel post_comment"><h4 class="title">' + data.comments.title[i] + '</h4><p>' + data.comments.content[i] + '</p><div class="mui-panel"><span class="floated_left">Note : ' + data.comments.score[i] + '</span><span class="floated_right">Comment"s note : ' + data.comments.vote[i] + '</span></div></div>';
						}
					} else {
						for (i = 0; i < data.comments.title.length; i = i + 1) {
							comments = comments + '<div class="mui-panel post_comment"><h4 class="title">' + data.comments.title[i] + '</h4><p>' + data.comments.content[i] + '</p><div class="mui-panel"><span class="floated_left">Note : ' + data.comments.score[i] + '</span><span class="floated_right">Comment"s note : <span <span id="vote_' + data.comments.comment_id[i] + '">' + data.comments.vote[i] + '</span></span></div><div class="mui-panel">You can vote <a href="?profile=' + data.comments.user_id[i] + '">' + data.comments.user_name[i] + '</a>"s comment <button class="mui-btn mui-btn--small mui-btn--fab mui-btn--primary plus_comment" id="plus_' + data.comments.comment_id[i] + '"><span class="glyphicon glyphicon-thumbs-up"></span></button><button class="mui-btn mui-btn--small mui-btn--fab mui-btn--danger minus_comment" id="minus_' + data.comments.comment_id[i] + '"><span class="glyphicon glyphicon-thumbs-down"></span></button></div></div>';
						}
						$("div#post_comments").html("");
						$("div#post_comments").html(comments);
					}
				});
			}
		});
	}
	$.getJSON('api/?post=' + post_id, function (data) {
		console.log(data);
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
			$.getJSON('api/?connected=user', function (data_user_connected) {
				if (data_user_connected.connected === false) {
					for (i = 0; i < data.comments.title.length; i = i + 1) {
						comments = comments + '<div class="mui-panel post_comment"><h4 class="title">' + data.comments.title[i] + '</h4><p>' + data.comments.content[i] + '</p><div class="mui-panel"><span class="floated_left">Note : ' + data.comments.score[i] + '</span><span class="floated_right">Comment"s note : ' + data.comments.vote[i] + '</span></div></div>';
					}
				} else {
					for (i = 0; i < data.comments.title.length; i = i + 1) {
						comments = comments + '<div class="mui-panel post_comment"><h4 class="title">' + data.comments.title[i] + '</h4><p>' + data.comments.content[i] + '</p><div class="mui-panel"><span class="floated_left">Note : ' + data.comments.score[i] + '</span><span class="floated_right">Comment"s note : <span id="vote_' + data.comments.comment_id[i] + '">' + data.comments.vote[i] + '</span></span></div><div class="mui-panel">You can vote <a href="?profile=' + data.comments.user_id[i] + '">' + data.comments.user_name[i] + '</a>"s comment <button class="mui-btn mui-btn--small mui-btn--fab mui-btn--primary plus_comment" id="plus_' + data.comments.comment_id[i] + '"><span class="glyphicon glyphicon-thumbs-up"></span></button><button class="mui-btn mui-btn--small mui-btn--fab mui-btn--danger minus_comment" id="minus_' + data.comments.comment_id[i] + '"><span class="glyphicon glyphicon-thumbs-down"></span></button></div></div>';
					}
				}
				$("div#post_comments").html(comments);
			});
		}
		$.getJSON('api/?connected=user', function (data_user) {
			if (data_user.connected === false) {
				$("div#post_add_comment").html('<p class="title">You must be connected to add a comment</p>');
			} else {
				$("div#post_add_comment").html('<h4 class="title">Your Comment</h4><div class="mui-textfield"><input type="text" id="comment_title"><label>Title <span id="span_comment_title"></span></label></div><div class="mui-textfield"><input type="text" id="comment_content"><label>Content <span id="span_comment_content"></span></label></div><div class="mui-select"><select id="comment_select"><option value=0>Note : 0</option><option value=1>Note : 1</option><option value=2>Note : 2</option><option value=3>Note : 3</option><option value=4>Note : 4</option><option value=5>Note : 5</option></select></div><button type="submit" class="mui-btn" id="add_comment">Add the comment <span class="glyphicon glyphicon-plus"></span></button>');
				$("button#add_comment").click(function() {
					error_add_comment = 0;
					comment_title = $.trim($("input#comment_title").val());
					comment_content = $.trim($("input#comment_content").val());
					comment_select = $.trim($("select#comment_select").val());
					if (comment_title === "") {
						error_add_comment = error_add_comment + 1;
						$("input#comment_title").css("border-color", "red");
						$("span#span_comment_title").html("can't be empty");
						$("span#span_comment_title").css("color", "red");
					} else {
						$("input#comment_title").css("border-color", "black");
						$("span#span_comment_title").html("");
						$("span#span_comment_title").css("color", "black");
					}
					if (comment_content === "") {
						error_add_comment = error_add_comment + 1;
						$("input#comment_content").css("border-color", "red");
						$("span#span_comment_content").html("can't be empty");
						$("span#span_comment_content").css("color", "red");
					} else {
						$("input#comment_content").css("border-color", "black");
						$("span#span_comment_content").html("");
						$("span#span_comment_content").css("color", "black");
					}
					if (error_add_comment === 0) {
						$.post('api/', {title: comment_title, content: comment_content, post_id: post_id, note: comment_select, send: "comment"}, function (data, textStatus, xhr) {
							if (textStatus === "success") {
								$("div.display-error").html('<div class="alert alert-info display-error">Your comment was added with success</div>');
								get_post_comments();
								$("input#comment_title").val("");
								$("input#comment_content").val("");
								$("select#comment_select").val(0);
							} else {
								$("div.display-error").html('<div class="alert alert-info display-error">Something happened, your comment can"t be created</div>');
							}
						});
					}
				});
				$("button.plus_comment").click(function() {
					plus_comment_id = this.id.substr(5);
					$.post('api/', {vote: "plus", comment_id: plus_comment_id, send: "vote"}, function (data, textStatus, xhr) {
						if (textStatus === "success") {
							$("div.display-error").html('<div class="alert alert-info display-error">Your vote was added with success</div>');
							$("span#vote_" + plus_comment_id).html(parseInt($("span#vote_" + plus_comment_id).html()) + 1);
						} else {
							$("div.display-error").html('<div class="alert alert-info display-error">Something happened, your vote can"t be added</div>');
						}
					});
				});
				$("button.minus_comment").click(function() {
					minus_comment_id = this.id.substr(6);
					$.post('api/', {vote: "minus", comment_id: minus_comment_id, send: "vote"}, function (data, textStatus, xhr) {
						if (textStatus === "success") {
							$("div.display-error").html('<div class="alert alert-info display-error">Your vote was added with success</div>');
							$("span#vote_" + minus_comment_id).html(parseInt($("span#vote_" + minus_comment_id).html()) - 1);
						} else {
							$("div.display-error").html('<div class="alert alert-info display-error">Something happened, your vote can"t be added</div>');
						}
					});
				});
			}
		});
	});
});