<?php

include 'Database.php';

class Auth
{

	public function create ($username, $password, $email)
	{
		$bdd = new Database('home');

		$password = $this->_hashPassword($password);

		$create = $bdd->getBdd()->prepare('INSERT INTO users (name, email, password, createdAt) VALUES (:name, :email, :password, NOW())');
		$create->bindParam(':name', $username, PDO::PARAM_STR, 16);
		$create->bindParam(':email', $email, PDO::PARAM_STR, 60);
		$create->bindParam(':password', $password, PDO::PARAM_STR, 255);
		$create->execute();

	}

	public function update ($infos, $password)
	{
		
	}

	public function updatePassword($new, $password)
	{

	}

	public function delete ()
	{

	}

	public function connection ($login, $password)
	{
		$bdd = new Database('home');

		$getUser = $bdd->getBdd()->prepare('SELECT id, password FROM users WHERE name = :login OR email = :login');
		$getUser->bindParam(':login', $login, PDO::PARAM_STR);
		$getUser->execute();

		$user = $getUser->fetch(PDO::FETCH_ASSOC);

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

	private $_error;

	public function getError()
	{
		return $this->_error();
	}

	public function setError($error)
	{
		$this->_error = $error;
	}

	private function _updateToken($id)
	{
		$bdd = new Database('home');

		$token = sha1(time() * rand(1, 555));
		$updateToken = $bdd->getBdd()->prepare('UPDATE users SET token = :token WHERE id = :id');
		$updateToken->bindParam(':token', $token, PDO::PARAM_STR, 60);
		$updateToken->bindParam(':id', $id);
		return $updateToken->execute();
	}

	private function _hashPassword($password)
	{
		return password_hash($password, PASSWORD_DEFAULT);
	}

	private function _checkPassword($password, $hash)
	{
		return password_verify($password, $hash);
	}
}