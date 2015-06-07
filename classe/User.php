<?php

include_once "DB.php";
include_once "DB_Formation.php";
include_once "DB_User.php";

Class User {

	//attributs
	private $id;
	private $login;
	private $mdp;
	private $admin;
	private $mail;
	private $ListeFormation = array();
	private $credits;
	private $jours;

	/* Constructeur */
	function __construct($id, $login, $mail,$credits,$jours,$admin) {
		$this->id = $id;
		$this->login = $login;
		$this->mail = $mail;
		$this->credits = $credits;
		$this->jours = $jours;
		$this->admin = $admin;
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
				"mail" => $retour["user_mail"],
				"credits" => $retour["credits"],
				"jours" => $retour["jours"],
				"admin" => $retour["user_admin"],

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

	function getCredits() {
		return $this->credits;
	}

	function getJours() {
		return $this->jours;
	}

	//renvoi un tableau d'objet formation contenant toutes les formations
	function getAllFormations() {
		$data = new DB_Formation();

		return $data->getAllFormations();
	}

	function getListeAnnulees() {
		$data = new DB_Formation();

		return $data->getFormations($this->id, "annulee");
	}

	function getFormationsAnnulees() {
		$data = new DB_Formation();

		return $data->getFormationUser($this->id, "annulee");
	}

	function getListeDemandees() {
		$data = new DB_Formation();

		return $data->getFormations($this->id, "demandee");
	}

	function getFormationsDemandees() {
		$data = new DB_Formation();

		return $data->getFormationUser($this->id, "demandee");
	}

	function getListeAcceptees() {
		$data = new DB_Formation();

		return $data->getFormations($this->id, "acceptee");
	}

	function getFormationsAcceptees() {
		$data = new DB_Formation();

		return $data->getFormationUser($this->id, "acceptee");
	}

	function getListeEnCours() {
		$data = new DB_Formation();

		return $data->getFormations($this->id, "encours");
	}

	function getFormationsEnCours() {
		$data = new DB_Formation();

		return $data->getFormationUser($this->id, "encours");
	}

	function getListeTerminees() {
		$data = new DB_Formation();

		return $data->getFormations($this->id, "terminee");
	}

	function getFormationsTerminees() {
		$data = new DB_Formation();

		return $data->getFormationUser($this->id, "terminee");
	}

	function getFormationsFutures(){
		$data = new DB_User();

		return $data->getFormationsFutures($this->id);
	}

	function getCreditsUser(){
		$data = new DB_User();

		return $data->getCreditsUser($this->id);
	}

	function getJoursUser() {
		$data = new DB_User();

		return $data->getJoursUser($this->id);
	}

	function getFormationsAttente(){
		$data = new DB_Formation();

		return $data->getFormationsAttente();
	}

	function inscription($formationId){
		$data = new DB_User();

		return $data->inscription($formationId, $this->id);
	}

	function desinscription($formationId){
		$data = new DB_User();

		return $data->desinscription($formationId, $this->id);
	}

	function accepteFormation($formationId) {
		$data = new DB_User();

		return $data->changeFormation($formationId, $this->id, "acceptee");
	}

	function refuseFormation($formationId) {
		$data = new DB_User();

		return $data->changeFormation($formationId, $this->id, "refusee");
	}

}

?>