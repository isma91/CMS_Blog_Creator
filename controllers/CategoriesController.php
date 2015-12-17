<?php
namespace controllers;

use models\Database;
use models\Category;
class CategoriesController extends Category
{
	public function get ()
	{
		$bdd = new Database('home');

		$get = $bdd->getBdd()->prepare('SELECT id, name FROM categories WHERE active = 1');
		$get->execute();

		$all = $get->fetchAll(\PDO::FETCG_ASSOC);

		return json_encode($all);
	}
}