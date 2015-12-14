<?php
namespace controllers;

use models\Database;
use models\User;
class UsersController extends User
{
	static public function isConnected ()
	{
		$bdd = new Database('home');
		if (!isset($_SESSION['id']) && !isset($_SESSION['token'])) {
			return false;
		}
		$get = $bdd->getBdd()->prepare('SELECT id, token, name FROM users WHERE id = :id AND token = :token');
		$get->bindParam(':id', $_SESSION['id']);
		$get->bindParam(':token', $_SESSION['token']);
		$get->execute();

		$user = $get->fetch(\PDO::FETCH_ASSOC);
		if ($user) {
			$_SESSION['name'] = $user['name'];
			return true;
		}
	}

	public function create ($username, $password, $email)
	{
		$bdd = new Database('home');

		$password = $this->_hashPassword($password);

		if (!$this->_updateCheckUsername($username)) {
			$this->setError('Username already in use');
			return false;
		}
		if (!$this->_updateCheckEmail($email)) {
			$this->setError('Email already in use');
			return false;
		}


		$create = $bdd->getBdd()->prepare('INSERT INTO users (name, email, password, createdAt) VALUES (:name, :email, :password, NOW())');
		$create->bindParam(':name', $username, \PDO::PARAM_STR, 16);
		$create->bindParam(':email', $email, \PDO::PARAM_STR, 60);
		$create->bindParam(':password', $password, \PDO::PARAM_STR, 255);
		if ($create->execute()) {
			$this->setError('Congrats ! You can connect');
			return true;
		}


	}

	public function update ($username, $email, $password = null)
	{
		$bdd = new Database('home');
		
		if (!$this->_updateCheckUsername($username)) {
			$this->setError('Username already in use');
			return false;
		}
		if (!$this->_updateCheckEmail($email)) {
			$this->setError('Email already in use');
			return false;
		}

		$update = $bdd->getBdd()->prepare('UPDATE users SET name = :name, email = :email WHERE id = :id AND token = :token AND active = 1');
		$update->bindParam(':name', $username, \PDO::PARAM_STR, 16);
		$update->bindParam(':email', $email, \PDO::PARAM_STR, 60);
		$update->bindParam(':id', $_SESSION['id']);
		$update->bindParam(':token', $_SESSION['token']);
		if ($update->execute()) {
			return true;
		}
	}

	public function updatePassword($new)
	{
		$bdd = new Database('home');

		$password = $this->_hashPassword($new);

		$update = $bdd->getBdd()->prepare('UPDATE users SET password = :password WHERE id = :id AND token = :token AND active = 1');
		$update->bindParam(':password', $password);
		$update->bindParam(':id', $_SESSION['id']);
		$update->bindParam(':token', $_SESSION['token']);
		if ($update->execute()) {
			return true;
		}
		return false;
	}

	public function delete ()
	{
		$bdd = new Database('home');

		$delete = $bdd->getBdd()->prepare('UPDATE users SET active = 0 WHERE id = :id AND token = :token AND active = 1');
		$delete->bindParam(':id', $_SESSION['id']);
		$delete->bindParam(':token', $_SESSION['token']);
		if ($delete->execute()) {
			session_destroy();
			return true;
		}
	}

	public function connection ($login, $password)
	{
		$bdd = new Database('home');

		$getUser = $bdd->getBdd()->prepare('SELECT id, password FROM users WHERE (name = :login OR email = :login) AND active = 1');
		$getUser->bindParam(':login', $login, \PDO::PARAM_STR);
		$getUser->execute();

		$user = $getUser->fetch(\PDO::FETCH_ASSOC);

		$hash = $user['password'];
		if (!$hash) {
			$this->setError("Bad login or password");
			return false;
		}

		if (!$this->_checkPassword($password, $hash)) {
			$this->setError("Bad login or password");
			return false;
		}

		$this->_updateToken($user['id']);

		return true;
	}

	public function test ()
	{
		$bdd = new Database('home');

		$getUser = $bdd->getBdd()->prepare('SELECT id FROM users WHERE id = :id AND token = :token');
		$getUser->bindParam(':id', $_SESSION['id']);
		$getUser->bindParam(':token', $_SESSION['token']);
		$getUser->execute();

		$user = $getUser->fetch(\PDO::FETCH_ASSOC);
		if ($user) {
			return true;
		}

		return false;
	}

	private function _updateToken($id)
	{
		$bdd = new Database('home');

		$token = sha1(time() * rand(1, 555));
		$updateToken = $bdd->getBdd()->prepare('UPDATE users SET token = :token WHERE id = :id');
		$updateToken->bindParam(':token', $token, \PDO::PARAM_STR, 60);
		$updateToken->bindParam(':id', $id);
		if ($updateToken->execute()) {
			$_SESSION['token'] = $token;
			$_SESSION['id'] = $id;
			return true;
		}
	}

	private function _hashPassword($password)
	{
		return password_hash($password, PASSWORD_DEFAULT);
	}

	private function _checkPassword($password, $hash)
	{
		return password_verify($password, $hash);
	}

	private function _updateCheckUsername($username)
	{
		$bdd = new Database('home');

		$id = (isset($_SESSION['id'])) ? $_SESSION['id'] : 0;
		$check = $bdd->getBdd()->prepare('SELECT name FROM users WHERE name = :name AND id != :id AND active = 1');
		$check->bindParam(':name', $username, \PDO::PARAM_STR, 16);
		$check->bindParam(':id', $id);
		$check->execute();

		$user = $check->fetch(\PDO::FETCH_ASSOC);
		if ($user)
			return false;

		return true;
	}

	private function _updateCheckEmail($email)
	{
		$bdd = new Database('home');

		$id = (isset($_SESSION['id'])) ? $_SESSION['id'] : 0;
		$check = $bdd->getBdd()->prepare('SELECT email FROM users WHERE email = :email AND id != :id AND active = 1');
		$check->bindParam(':email', $email, \PDO::PARAM_STR, 60);
		$check->bindParam(':id', $id);
		$check->execute();

		$user = $check->fetch(\PDO::FETCH_ASSOC);
		if ($user)
			return false;

		return true;
	}
}