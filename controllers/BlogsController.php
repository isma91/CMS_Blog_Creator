<?php
namespace controllers;

use models\Blog;
use models\Database;
class BlogsController extends Blog
{
	private $_blogs;
	private $_blog;

	public function __construct()
	{

	}
	public function getBlogs()
	{
		return $this->_blogs;
	}
	public function getBlog()
	{
		return $this->_blog;
	}

	public function render()
	{

		// Create blog
		if (isset($_POST['create_blog'])) {
			$this->create($_POST['name'], $_POST['slug'], $_POST['description']);
		}

		// Edit blog
		if (isset($_POST['blog_edit'])) {
			if ($_GET['token'] == $_SESSION['token']) {
				$this->update($_POST['name'], $_POST['slug'], $_POST['description'], $_POST['id']);
			}
		}
		// Delete blog
		if (isset($_GET['blog']) && isset($_GET['id']) && isset($_GET['token']) && $_GET['blog'] == 'delete') {
			if ($_GET['token'] == $_SESSION['token']) {
				$this->delete($_GET['id']);
			}
		}
		// Get post
		if (isset($_GET['blog']) && $_GET['blog'] == 'post' && isset($_GET['id']) && isset($_GET['token'])) {
			if ($_GET['token'] == $_SESSION['token']) {
				$this->getArticles($_GET['id']);
			}
		}
		if (isset($_GET['blog']) && isset($_GET['id']) && isset($_GET['token']) && $_GET['blog'] == 'edit') {
			if ($_GET['token'] == $_SESSION['token']) {
				$this->_blog = $this->getBlogById($_GET['id']);
			}
		}

		$this->getMyBlogs();
	}
	public function create ($name, $slug, $description)
	{
		$bdd = new Database('home');

		if ($this->_checkSlug($slug)) {
			$this->setError('Blog\'s domain already in use');
			return false;
		}
		$create = $bdd->getBdd()->prepare('INSERT INTO blogs (name, slug, description, user_id, created_at, updated_at) VALUES (:name, :slug, :description, :user_id, NOW(), NOW())');
		$create->bindParam(':name', $name);
		$create->bindParam(':slug', $slug);
		$create->bindParam(':description', $description);
		$create->bindParam(':user_id', $_SESSION['id']);
		if ($create->execute()) {
			header('Location:./');
			$this->setError('Congrats ! Your blog has been created.');
			return true;
		}

		$this->setError('Error occured, please try later');
		return false;
	}

	public function update ($name, $slug, $description, $id = null)
	{
		$bdd = new Database('home');

		if (is_null($id)) {
			$this->setError('Error occured, please try later');
			return false;
		}
		if ($this->_checkSlug($slug, $id)) {
			$this->setError('Blog\'s domain already in use');
			return false;
		}

		$update = $bdd->getBdd()->prepare('UPDATE blogs SET name = :name, slug = :slug, description = :description WHERE id = :id AND user_id = :user_id');
		$update->bindParam(':name', $name);
		$update->bindParam(':slug', $slug);
		$update->bindParam(':description', $description);
		$update->bindParam(':id', $id);
		$update->bindParam(':user_id', $_SESSION['id']);
		if ($update->execute()) {
			header('Location:./');
			$this->setError('Congrats ! Your blog has been updated.');
			return true;
		}

		$this->setError('Error occured, please try later');
		return false;

	}

	public function delete ($id)
	{
		$bdd = new Database('home');

		$delete = $bdd->getBdd()->prepare('UPDATE blogs SET active = 0 WHERE id = :id');
		$delete->bindParam(':id', $id);
		$delete->execute();

		$this->setError('Your blog has been deleted');
		return true;
	}

	private function _checkName($name, $id = 0)
	{
		$bdd = new Database('home');

		$check = $bdd->getBdd()->prepare('SELECT name FROM blogs WHERE name = :name AND active = 1 AND id != :id');
		$check->bindParam(':id', $id);
		$check->bindParam(':name', $name);
		$check->execute();

		$blog = $check->fetch(\PDO::FETCH_ASSOC);
		if ($blog) {
			return true;
		}
		return false;
	}

	private function _checkSlug ($slug, $id = 0)
	{
		$bdd = new Database('home');

		$check = $bdd->getBdd()->prepare('SELECT slug FROM blogs WHERE slug = :slug AND active = 1 AND id != :id');
		$check->bindParam(':id', $id);
		$check->bindParam(':slug', $slug);
		$check->execute();

		$blog = $check->fetch(\PDO::FETCH_ASSOC);
		if ($blog) {
			return true;
		}
		return false;
	}

	public function getBlogBySlug ($slug, $limit = 10)
	{
		$bdd = new Database('home');

		//$offset = ($page * 10);
		// GET ARTICLE
		$getArticles = $bdd->getBdd()->prepare('SELECT posts.id AS post_id, posts.title, posts.content, posts.created_at, posts.updated_at FROM blogs LEFT JOIN posts ON posts.blog_id = blogs.id WHERE blogs.active = 1 AND posts.active = 1 AND blogs.slug = :slug ORDER BY posts.id DESC LIMIT ' . $limit);
		$getArticles->bindParam(':slug', $slug);
		$getArticles->execute();

		$articles = $getArticles->fetchAll(\PDO::FETCH_ASSOC);

		// GET BLOG INFO
		$getBlog = $bdd->getBdd()->prepare('SELECT id AS blog_id, name, slug, description FROM blogs WHERE active = 1 AND slug = :slug');
		$getBlog->bindParam(':slug', $slug);
		$getBlog->execute();

		$blog = $getBlog->fetch(\PDO::FETCH_ASSOC);
		if ($blog !== false) {
			$response = $blog;
			if (!empty($articles)) {
				$i = 0;
				foreach ($articles as $article) {
					$nb_comments = $bdd->getBdd()->prepare('SELECT COUNT(id) AS nb_comments FROM comments WHERE post_id = :post_id');
					$nb_comments->bindParam(':post_id', $article['post_id'], \PDO::PARAM_INT);
					$nb_comments->execute();

					$nb_comments = $nb_comments->fetch(\PDO::FETCH_ASSOC);
					$articles[$i]['nb_comments'] = $nb_comments['nb_comments'];
					$i++;
				}
				$response['articles'] = $articles;
			}
		} else {
			$response = array('error' => 'blog slug invalid');
		}
		return json_encode($response);
	}

	public function getBlogById ($id)
	{
		$bdd = new Database('home');

		$get = $bdd->getBdd()->prepare('SELECT name, id, slug, description FROM blogs WHERE id = :id AND active = 1 AND user_id = :user_id');
		$get->bindParam(':id', $id, \PDO::PARAM_INT, 11);
		$get->bindParam(':user_id', $_SESSION['id']);
		$get->execute();

		$blog = $get->fetch(\PDO::FETCH_ASSOC);
		if ($blog) {
			return $blog;
		}
		return false;
	}

	public function getMyBlogs ()
	{
		$bdd = new Database('home');

		$get = $bdd->getBdd()->prepare('SELECT id, name FROM blogs WHERE user_id = :user_id AND active = 1');
		$get->bindParam(':user_id', $_SESSION['id']);
		$get->execute();

		$all = $get->fetchAll(\PDO::FETCH_ASSOC);

		if (empty($all)) {
			$this->setError('You have no blog');
		}
		$this->_blogs = $all;
	}
}