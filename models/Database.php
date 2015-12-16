<?php
namespace models;

class Database
{
	private $_db;

	public function __construct($dbname)
	{
		if (file_exists('config.php')) {
			$config = include 'config.php';
		} else {
			$config = include '../config.php';
		}

		$this->_db = new \PDO('mysql:host=' . $config['databases'][$dbname]['host'] . ';dbname=' . $config['databases'][$dbname]['dbname'], $config['databases'][$dbname]['user'], $config['databases'][$dbname]['password']);

	}
	public function getBdd()
	{
		return $this->_db;
	}
}