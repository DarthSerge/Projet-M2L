<?php 

include_once "DB.php";

Class Formation{

	//attributs 
	private $id;
	private $libelle;
	private $dateDebut;
	private $dateFin;
	private $lieu;
	private $requis;
	private $prestataire_id; //ne sert que pour faciliter le constructeur
	private $prestataire;

	//constructeur (penser à mettre le prestataire_id)
	function __construct($id,$libelle,$dateDebut, $DateFin,$lieu, $requis, $prestataire_id){
		$this->id 			= $id;
		$this->libelle 		= $libelle;
		$this->dateDebut 	= $dateDebut;
		$this->dateFin		= $dateFin;
		$this->lieu 		= $lieu;
		$this->requis 		= $requis;
		$this->prestataire 	= new Prestataire($prestataire_id)
	}

	//getters et setters
	function getId() {
		return $this->id;
	}

	function getLibelle() {
		return $this->libelle;
	}

	function getContenu() {
		return $this->contenu;
	}

	function getDateDebut() {
		return $this->dateDebut;
	}

	function getDateFin() {
		return $this->datefin;
	}

	function getNombreJours() {
		return $this->nombreJours;
	}

	function getLieu() {
		return $this->lieu;
	}

	function getRequis() {
		return $this->requis;
	}

	function getPrestataire() {
		return $this->prestataire;
	}

	function getImage() {
		return $this->image;
	}

	//renvoi un tableau d'objet formation contenant toutes les formations
	function getAllFormation() {
		$data = new DB_Formation();

		return $data->getAllFormation();
	}
}

?>