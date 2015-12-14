<?php
namespace models;
class Models
{
	private $_error;

	public function setError($error)
	{
		$this->_error = $error;
	}

	public function getError()
	{
		return $this->_error;
	}
}