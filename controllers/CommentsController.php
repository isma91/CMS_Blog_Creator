<?php
namespace controllers;

use models\Comment;
use models\Database;
class CommentsController extends Comment
{
	public function create ($post_id, $content, $title, $score)
	{
		if (is_null($post_id)) {
			return false;
		}

		$bdd = new Database('home');
		$create = $bdd->getBdd()->prepare('INSERT INTO comments (user_id, post_id, title, content, score) VALUES (:user_id, :post_id, :title, :content, :score)');
		$create->bindParam(':post_id', $post_id);
		$create->bindParam(':content', $content);
		$create->bindParam(':title', $title);
		$create->bindParam(':score', $score);
		$create->bindParam(':user_id', $_SESSION['id']);
		if ($create->execute()) {
			return true;
		}
		return false;

	}

	public function delete ($post_id)
	{
		$bdd = new Database('home');

		$test = $bdd->getBdd()->prepare('SELECT id FROM comments WHERE id = :id AND user_id = :user_id');
		$test->bindParam(':id', $post_id);
		$test->bindParam(':user_id', $_SESSION['id']);
		$test->execute();

		$id = $test->fetch();
		if ($id) {
			return false;
		}

		$delete = $bdd->getBdd()->prepare('UPDATE comments SET active = 0 WHERE id = :id AND user_id = :user_id');
		$delete->bindParam(':id', $post_id, \PDO::PARAM_INT);
		$delete->bindParam(':user_id', $_SESSION['id']);
		$delete->execute();
		return true;
	}

	public function getCommentsByPostId ($post_id)
	{
		$bdd = new Database('home');

		$get = $bdd->getBdd()->prepare('SELECT comments.id, comments.title, comments.content, users.name FROM comments LEFT JOIN users ON users.id = comments.user_id WHERE comments.active = 1 AND post_id = :post_id');
		$get->bindParam(':post_id', $post_id);
		$get->execute();

		$all = $get->fetchAll(\PDO::FETCH_ASSOC);
		return json_encode($all);
	}
}