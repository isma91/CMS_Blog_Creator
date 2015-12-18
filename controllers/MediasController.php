<?php
namespace controllers;

use models\Media;
use models\Database;
class MediasController extends Media
{
	public function create ($urls, $post_id)
	{
		$bdd = new Database('home');

		if (!is_array($urls)) {
			return array('error' => 'you must send an array');
		}

		foreach ($urls as $url) {
			$create = $bdd->getBdd()->prepare('INSERT INTO media (type, url, post_id) VALUES ("image", :url, :post_id)');
			$create->bindParam(':url', $url);
			$create->bindParam(':post_id', $post_id);
			if (!$create->execute()) {
				return false;
			}
		}
		return true;

	}

	public function getByPost ($id)
	{
		$bdd = new Database('home');

		$get = $bdd->getBdd()->prepare('SELECT * FROM media WHERE post_id = :post_id');
		$get->bindParam(':post_id', $id);
		$get->execute();

		$medias = $get->fetchAll(\PDO::FETCH_ASSOC);

		return $medias;
	}

	public function delete ()
	{

	}
}