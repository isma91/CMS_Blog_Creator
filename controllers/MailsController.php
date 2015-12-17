<?php
namespace controllers;

use models\Database;
use models\Mail;
class MailsController extends Mail
{
	public function create ($blog_id, $title, $content)
	{
		$bdd = new Database('home');

		$create = $bdd->getBdd()->prepare('INSERT INTO mails (blog_id, title, content, user_id) VALUES (:blog_id, :title, :content, :user_id)');
		$create->bindParam(':blog_id', $blog_id);
		$create->bindParam(':title', $title);
		$create->bindParam(':content', $content);
		$create->bindParam(':user_id', $_SESSION['id']);
		$create->execute();

		return true;
	}

	public function delete ()
	{

	}
}