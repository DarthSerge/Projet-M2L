<?php

include_once "DB_Pretataire";

class Prestataire{

	private $id;
	private $raisonSociale;
	private $adresse;
	private $telephone;
	private $siret;

	//constructeur
	function __construct($id){
		$data = new DB_Pretataire();

		$retour = $data->getPrestataire($id);
		
		$this->id 				= $retour["prest_id"];
		$this->raisonSociale 	= $retour["prest_raison_sociale"];
		$this->adresse 			= $retour["prest_adresse"];
		$this->telephone 		= $retour["prest_telephone"];
		$this->siret 			= $retour["prest_siret"];
	}

	//getters
	function getId(){
		return $this->id;
	}

	function getRaisonSociale(){
		return $this->raisonSociale;
	}

	function getAdresse(){
		return $this->adresse;
	}

	function getTelephone(){
		return $this->telephone;
	}

	function getSiret(){
		return $this->siret;
	}
}

?>