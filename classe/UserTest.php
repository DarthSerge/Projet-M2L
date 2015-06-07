<?php

include "./User.php";
include "./Formation.php";
include "./Prestataire.php";

class UserTest extends PHPUnit_Framework_TestCase {

	public function testInscriptionFormation() {
		$formation = new Formation(1, "formationTest", "", "2015-03-09", "2015-03-18", "Paris", "Aucun", 150, 1);
		$user = new User(1, "serge", "serge@mail.com", 5000, 15);

		$this->assertTrue($user->inscriptionFormation($formation->getId()));
	}

}