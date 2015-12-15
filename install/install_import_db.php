<?php
/**
* Install_import_db.php
*
* PHP file to import the sql file who add some table and create a user
*
* PHP Version 5.6.14-0+deb8u1 (cli) (built: Oct  4 2015 16:13:10)
*
* @category Model
* @package  Model
* @author   isma91 <ismaydogmus@gmail.com>
* @author   Raph <rbleuzet@gmail.com>
* @license  http://opensource.org/licenses/gpl-license.php GNU Public License
*/
try {
	$bdd = new PDO("mysql:host=" . $_POST["host"] . ";dbname=" . $_POST["database_name"], $_POST["username"], $_POST["password"]);
	$sql = "CREATE TABLE IF NOT EXISTS `blogs` (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`name` varchar(20) NOT NULL,
		`slug` varchar(30) NOT NULL,
		`description` text,
		`url_banner` int(11) DEFAULT NULL,
		`font_id` int(11) NOT NULL DEFAULT '1',
		`user_id` int(11) NOT NULL,
		`created_at` datetime NOT NULL,
		`updated_at` datetime DEFAULT NULL,
		`active` int(11) NOT NULL DEFAULT '1',
		PRIMARY KEY (`id`)
		) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
		CREATE TABLE IF NOT EXISTS `categories` (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`name` varchar(26) NOT NULL,
			`active` int(11) NOT NULL DEFAULT '1',
			PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
		CREATE TABLE IF NOT EXISTS `comments` (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`user_id` int(11) NOT NULL,
			`title` varchar(255) NOT NULL,
			`content` text NOT NULL,
			`score` int(1) NOT NULL,
			`active` int(1) NOT NULL DEFAULT '1',
			`vote` varchar(11) NOT NULL,
			PRIMARY KEY (`id`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
		CREATE TABLE IF NOT EXISTS `mails` (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`blog_id` int(11) NOT NULL,
			`title` varchar(255) NOT NULL,
			`content` text NOT NULL,
			`user_id` int(11) NOT NULL,
			`active` int(1) NOT NULL DEFAULT '1',
			PRIMARY KEY (`id`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
		CREATE TABLE IF NOT EXISTS `media` (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`type` varchar(16) NOT NULL,
			`url` varchar(255) NOT NULL,
			`post_id` int(11) NOT NULL,
			PRIMARY KEY (`id`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
		CREATE TABLE IF NOT EXISTS `posts` (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`blog_id` int(11) NOT NULL,
			`content` text NOT NULL,
			`title` varchar(255) NOT NULL,
			`active` int(11) NOT NULL DEFAULT '1',
			`createdAt` datetime NOT NULL,
			`updatedAt` datetime NOT NULL,
			PRIMARY KEY (`id`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
		CREATE TABLE IF NOT EXISTS `tags` (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`post_id` int(11) NOT NULL,
			`name` varchar(26) NOT NULL,
			`active` int(1) NOT NULL DEFAULT '1',
			PRIMARY KEY (`id`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
		CREATE TABLE IF NOT EXISTS `users` (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`name` varchar(16) CHARACTER SET latin1 NOT NULL,
			`firstname` varchar(50) NOT NULL,
			`lastname` varchar(50) NOT NULL,
			`email` varchar(60) CHARACTER SET latin1 NOT NULL,
			`password` varchar(255) CHARACTER SET latin1 NOT NULL,
			`token` varchar(60) CHARACTER SET latin1 DEFAULT NULL,
			`created_at` datetime NOT NULL,
			`updated_at` datetime NOT NULL,
			`active` int(11) NOT NULL DEFAULT '1',
			PRIMARY KEY (`id`)
			) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
		INSERT INTO `users`(`id`, `name`, `firstname`, `lastname`, `email`, `password`, `token`, `created_at`, `updated_at`, `active`)
		VALUES ('1','" . $_POST["blogger_name"] . "','" . $_POST["blogger_firstname"] . "','" . $_POST["blogger_lastname"] . "','" . $_POST["blogger_email"] . "','" . password_hash($_POST["blogger_password"], PASSWORD_DEFAULT) . "','',NOW(),'','1')";
		$create_tables = $bdd->exec($sql);
		if ($create_tables === 0) {
			echo "true";
		} else {
			echo "false";
		}
} catch (PDOException $exception) {
	if ($exception->getCode() === 2005) {
		echo "Error !! The MySQL server '" . $_POST["host"] . "' is not recognized !!\n";
	} elseif ($exception->getCode() === 1045) {
		if ($_POST["password"] === "") {
			echo "Error !! The MySQL server denied acces to '" . $_POST["username"] . "', maybe you forgot to write the password ??\n";
		} else {
			echo "Error !! The MySQL server denied acces to '" . $_POST["username"] . "', maybe you have write the wrong password ??\n";
		}
	} elseif ($exception->getCode() === 1049) {
		echo "Error !! Database '" . $_POST["database_name"] . "' doesn't exist in the MySQL server '" . $host . "'\n";
	} else {    
		echo "Error !! " . $exception->getMessage();
	}
}
?>