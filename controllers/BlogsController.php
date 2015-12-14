<?php
namespace controllers;

use models\Blog;
class BlogsController extends Blog
{
	public function create ($name)
	{
		$bdd = new Database('home');

		if ($this->_checkName($name)) {
			$this->setError('Blog\'s name already in use');
			return false;
		}
		$create = $bdd->getBdd()->prepare('INSERT INTO blogs (name, owner_id, createdAt, updatedAt) VALUES (:name, :owner_id, NOW(), NOW())');
		$create->bindParam(':name', $name);
		$create->bindParam(':owner_id', $_SESSION['id']);
		$create->execute();
	}

	public function delete ($id)
	{
		$bdd = new Database('home');

		$delete = $bdd->getBdd()->prepare('UPDATE blogs SET active = 0 WHERE id = :id');
		$delete->bindParam(':id', $id);
		$delete->execute();
	}

	private function _checkName($name)
	{
		$bdd = new Database('home');

		$check = $bdd->getBdd()->prepare('SELECT name FROM blogs WHERE name = :name AND active = 1');
		$check->bindParam(':name', $name);
		$check->execute();

		$blog = $check->fetch(PDO::FETCH_ASSOC);
		if ($blog) {
			return false;
		}
		return true;
	}
}