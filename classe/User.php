<?php

include_once "DB.php";

Class User{

	//attributs
	private $login;
	private $mdp;
	private $id;
	private $admin;
	private $mail;
	private $ListeFormation = array();

	//constructeur
	function __construct($login,$mdp){

		$data		= new DB_User();
		$Formation  = new Formation();

		$retour = $data->checkId($login,$mdp)

		if (!$retour){
			scriptAlert("Les identifiants saisis sont incorrects");

			return false;
		}else{
			$this->id 		= $retour["user_id"];
			$this->admin 	= $retour["user_admin"];
			$this->login 	= $retour["user_login"];
			$this->mail 	= $retour["user_mail"];

			$this->ListeFormation = $Formation->getFormationUser();

			return true;
		}
	}

	//renvoi un tableau de formations suivi par l'utilisateur
	function getFormationUser(){

		$data = new DB_Formation();

		$this->ListeFormation = $data->getFormationUser($this->id);
	}
}

?>