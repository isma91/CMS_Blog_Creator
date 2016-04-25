<?php
/**
* Config-sample.php
*
* This is a sample config file, if you install and the config.php file doesn't create,
* you can rename this file to config.php and change the host, dbname, user, password
* change install to true to use this project
*
* PHP Version 5.6.14-0+deb8u1 (cli) (built: Oct  4 2015 16:13:10)
*
* @category Model
* @package  Model
* @author   isma91 <ismaydogmus@gmail.com>
* @author   Raph <rbleuzet@epitech.eu>
* @license  http://opensource.org/licenses/gpl-license.php GNU Public License
*/
return [
	'databases' => [
		'home' => [
			'host' => 'localhost',
			'dbname' => 'blog_creator',
			'user' => 'root',
			'password' => '',
		],
	],
	"install" => false
];