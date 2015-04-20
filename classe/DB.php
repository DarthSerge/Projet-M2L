<?php 

Class DB {

	const USER = 'root';
	const PASSWORD = '';
	const HOTE = 'localhost';
	const PORT = '82';
	const BASE = 'M2L';

	function connect() {

		//Définition des paramètre de connection PDO
		$dsn="mysql:".self::HOTE.";port=".self::PORT.";dbname=".self::BASE;

		try {	
			//Connection à la base MySQL
			$dbh = new PDO($dsn, self::USER, self::PASSWORD);
			$dbh->exec("set character set utf8");
		}
		catch (PDOException $e) {
			die("Erreur! :" . $e->getMessage());
		}
		return $dbh;
	}
}

?>