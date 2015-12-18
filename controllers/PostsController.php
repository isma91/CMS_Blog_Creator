<?php
namespace controllers;

use models\Post;
use models\Database;
use controllers\MediasController;
class PostsController extends Post
{
	private $_posts;
	private $_post;

	public function setPost($post)
	{
		$this->_post = $post;
	}

	public function getPost()
	{
		return $this->_post;
	}

	public function getPosts()
	{
		return $this->_posts;
	}

	public function setPosts($posts)
	{
		$this->_posts = $posts;
	}

	public function render()
	{
		if (isset($_GET['token']) && isset($_POST['post_update']) && isset($_GET['post_id']) && $_GET['post'] == 'edit') {
			if ($_GET['token'] == $_SESSION['token']) {
				$this->update($_POST['title'], $_POST['content'], $_GET['post_id']);
			}
		}

		if (isset($_POST['token']) && isset($_POST['create_post']) && isset($_POST['blog_id'])) {
			if ($_POST['token'] == $_SESSION['token']) {
				if (isset($_POST['url'])) {
					$url = explode(",", $_POST['url']);
					$this->create($_POST['blog_id'], $_POST['title'], $_POST['content'], $url);
				} else {
					$this->create($_POST['blog_id'], $_POST['title'], $_POST['content']);
				}
			}
		}

		if (isset($_GET['post']) && isset($_GET['post_id']) && isset($_GET['token']) && $_GET['post'] == 'delete') {
			if ($_GET['token'] == $_SESSION['token']) {
				$this->delete($_GET['post_id']);
			}
		}

		if (isset($_GET['post']) && isset($_GET['post_id']) && isset($_GET['token']) && $_GET['post'] == 'edit') {
			$this->readPost($_GET['post_id']);
		}

		if (isset($_GET['token']) && isset($_GET['blog']) && isset($_GET['blog_id']) && $_GET['blog'] == 'post') {
			$this->readPosts($_GET['blog_id']);
		}
	}

	public function create($id, $title, $content, $urls = null)
	{

		$bdd = new Database('home');

		$create = $bdd->getBdd()->prepare('INSERT INTO posts (title, content, blog_id, created_at, updated_at) VALUES (:title, :content, :blog_id, NOW(), NOW())');
		$create->bindParam(':title', $title);
		$create->bindParam(':content', $content);
		$create->bindParam(':blog_id', $id);
		if ($create->execute()) {
			if (!is_null($urls) && is_array($urls)) {
				$select = $bdd->getBdd()->prepare('SELECT id FROM posts WHERE title = :title AND content = :content AND blog_id = :blog_id AND active = 1 ORDER BY id DESC LIMIT 1');
				$select->bindParam(':title', $title);
				$select->bindParam(':content', $content);
				$select->bindParam(':blog_id', $id);
				$select->execute();
				$id = $select->fetch(\PDO::FETCH_ASSOC);
				$medias = new MediasController();
				$medias->create($urls, $id['id']);
			}
			$this->setError('Post successfully created');
			return true;
		}
	}
	public function update($title, $content, $id)
	{
		$bdd = new Database('home');

		$update = $bdd->getBdd()->prepare('UPDATE posts SET content = :content, title = :title, updated_at = NOW() WHERE id = :id');
		$update->bindParam(':content', $content);
		$update->bindParam(':title', $title);
		$update->bindParam(':id', $id);
		$update->execute();

		$this->setError('Successfully updated');
		return true;
	}

	public function delete($id)
	{
		$bdd = new Database('home');

		$delete = $bdd->getBdd()->prepare('UPDATE posts SET active = 0 WHERE id = :id');
		$delete->bindParam(':id', $id);
		$delete->execute();
		
		$this->setError('Successfully removed');
		return true;
	}

	public function readPosts($blog_id)
	{
		$bdd = new Database('home');

		$read = $bdd->getBdd()->prepare('SELECT * FROM posts WHERE blog_id = :id AND active = 1');
		$read->bindParam(':id', $blog_id);
		$read->execute();

		$posts = $read->fetchAll(\PDO::FETCH_ASSOC);
		if (empty($posts)) {
			$post = array('error' => 'blog id invalid');
		} else {
			$i = 0;
			foreach ($posts as $post) {
				$medias = new MediasController();

				$nb_comments = $bdd->getBdd()->prepare('SELECT COUNT(id) AS nb_comments FROM comments WHERE post_id = :post_id');
				$nb_comments->bindParam(':post_id', $post['id'], \PDO::PARAM_INT);
				$nb_comments->execute();

				$nb_comments = $nb_comments->fetch(\PDO::FETCH_ASSOC);
				$posts[$i]['nb_comments'] = $nb_comments['nb_comments'];
				$posts[$i]['medias'] = $medias->getByPost($post['id']);
				$i++;
			}
		}
		$this->setPosts($posts);
		return true;
	}

	public function readPost($id, $json = 0)
	{
		$bdd = new Database('home');

		$read = $bdd->getBdd()->prepare('SELECT * FROM posts WHERE id = :id AND active = 1');
		$read->bindParam(':id', $id);
		$read->execute();

		$post = $read->fetch(\PDO::FETCH_ASSOC);
		if ($json == 0) {
			$this->setPost($post);
			return true;
		} else {
			if (empty($post)) {
				$post = array('error' => 'post id invalid');
			} else {
				$medias = new MediasController();

				$nb_comments = $bdd->getBdd()->prepare('SELECT COUNT(id) AS nb_comments FROM comments WHERE post_id = :post_id');
				$nb_comments->bindParam(':post_id', $post['id'], \PDO::PARAM_INT);
				$nb_comments->execute();

				$nb_comments = $nb_comments->fetch(\PDO::FETCH_ASSOC);
				$post['comments'] = array();
				if ($nb_comments["nb_comments"] !== 0) {
					$all_post_comments = $bdd->getBdd()->prepare('SELECT users.id AS "user_id", comments.id AS "comment_id", users.name AS "user_name", title, content, score, vote FROM comments LEFT JOIN users ON users.id = comments.user_id WHERE post_id = :post_id');
					$all_post_comments->bindParam(':post_id', $post['id'], \PDO::PARAM_INT);
					$all_post_comments->execute();
					$all_post_comments = $all_post_comments->fetchAll();
					foreach ($all_post_comments as $comment) {
						$post['comments']['comment_id'][] = $comment['comment_id'];
						$post['comments']['user_id'][] = $comment['user_id'];
						$post['comments']['user_name'][] = $comment['user_name'];
						$post['comments']['title'][] = $comment['title'];
						$post['comments']['content'][] = $comment['content'];
						$post['comments']['score'][] = $comment['score'];
						$post['comments']['vote'][] = $comment['vote'];
					}
				}
				$post['nb_comments'] = $nb_comments['nb_comments'];
				$post['medias'] = $medias->getByPost($post['id']);
			}
			return json_encode($post);
		}
	}
}