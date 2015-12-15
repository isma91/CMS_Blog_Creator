<?php
namespace controllers;

use models\Category;
use models\Database;
class CategoriesController extends Category
{
	public function create ($name)
	{
		$bdd = new Database('home');

		$create = $bdd->getBdd()->prepare('INSERT INTO categories (name) VALUES (:name)');
		$create->bindParam(':name', $name);
		$create->execute();
		return true;
	}

	public function getAll ()
	{
		$bdd = new Database('home');

		$get = $bdd->getBdd()->prepare('SELECT id, name FROM categories WHERE active = 1');
		$get->execute();

		$all = $get->fetchAll(\PDO::FETCH_ASSOC);
		return $all;
	}
}