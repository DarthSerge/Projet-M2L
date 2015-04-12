<?php

include_once "DB.php";

Class User{

	//attributs
	private $id;
	private $login;
	private $mdp;
	private $admin;
	private $mail;
	private $ListeFormation = array();

	/* Constructeur */

	function __construct($id, $login, $mail) {
		$this->id = $id;
		$this->login = $login;
		$this->mail = $mail;
	}

	//Vérification des identifiants de connexion
	function CheckConnexion($login,$mdp) {
		$data = new DB_User();

		$retour = $data->checkId($login,$mdp);

		if (!$retour)
			return false;

		else {
			$utilisateur =  array(
				"id" => $retour["user_id"],
				"login" => $retour["user_login"],
				"mail" => $retour["user_mail"]
				);

			return $utilisateur;
		}
	}

	//getters et setters
	function getId() {
		return $this->id;
	}

	function getLogin() {
		return $this->login;
	}

	function getMail() {
		return $this->mail;
	}

	//renvoi un tableau de formations suivi par l'utilisateur
	function getFormationUser($statut) {
		$data = new DB_Formation();

		$this->ListeFormation = $data->getFormationUser($this->id, $statut);
	}

	function getFormationsDemandees() {
		$data = new DB_Formation();

		return $data->getFormationUser($this->id, 0);
	}

	function getFormationsAnnulees() {
		$data = new DB_Formation();

		return $data->getFormationUser($this->id, -1);
	}

	function getFormationsEnCours() {
		$data = new DB_Formation();

		return $data->getFormationUser($this->id, 1);
	}

	function getFormationsTerminees() {
		$data = new DB_Formation();

		return $data->getFormationUser($this->id, 2);
	}
}

?>