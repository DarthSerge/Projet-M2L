<?php

include('DB.php');
include('Script.php');

Class User{

	//attributs
	private $login;
	private $mdp;
	private $id;
	private $admin;
	private $ListeFormation = array();

	//constructeur
	function __construct($login,$mdp){

		$db = new Connection();
		$Formation = new Formation();

		$this->login = $login;
		$this->mdp = $mdp;

		if (!$db->checkId()){
			scriptAlert("Les identifiants saisis sont incorrects");
			return false;
		}else{
			$this->ListeFormation = $Formation->getFormationUser();
			scriptAlert("Connection réussie");
			return true;
		}
	}

	//renvoi toutes les formations suivi par l'utilisateur
	function getFormationUser(){

		$db = new Connection();

		$this->ListeFormation = $db.getFormationUser($this->id);
	}
}

?>