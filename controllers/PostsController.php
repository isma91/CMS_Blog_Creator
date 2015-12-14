<?php
class Posts extends Post
{
	public function create($id, $title, $content)
	{
		$bdd = new Database('home');

		$create = $bdd->getBdd()->prepare('INSERT INTO posts (title, content, blog_id, createdAt, updatedAt) VALUES (:title, :content, :blog_id, NOW(), NOW())');
		$create->bindParam(':title', $title);
		$create->bindParam(':content', $content);
		$create->bindParam(':blog_id', $id);
		if ($create->execute())
			return true;
	}
	public function update()
	{
		$bdd = new Database('home');

		$update = $bdd->getBdd()->prepare('UPDATE posts SET content = :content, title = :title, updatedAt = NOW() WHERE id = :id');
		$update->bindParam(':content', $content);
		$update->bindParam(':title', $title);
		$update->bindParam(':id', $id);
	}
	public function delete()
	{
		$bdd = new Database('home');

		$delete = $bdd->getBdd()->prepare('UPDATE posts SET active = 0 WHERE id = :id');
		$delete->bindParam(':id', $id);
		$delete->execute();

		return true;
	}
	public function readPosts($blog_id)
	{
		$bdd = new Database('home');

		$read = $bdd->getBdd()->prepare('SELECT * FROM posts WHERE blog_id = :id');
		$read->bindParam(':id', $blog_id);
		$read->execute();

		$posts = $read->fetchAll(PDO::FETCH_ASSOC);
		return $posts;
	}

	public function readPost($id)
	{
		$bdd = new Database('home');

		$read = $bdd->getBdd()->prepare('SELECT * FROM posts WHERE id = :id');
		$read->bindParam(':id', $id);
		$read->execute();
	}
}