<?php 

include_once "DB.php";

Class Formation{

	//attributs 
	private $contenu;
	private $libelle;
	private $dateDebut;
	private $dateFin;
	private $nombreJours;
	private $lieu;
	private $requis;
	private $prestataire;
	private $image;
	private $id;

	//constructeur
	function __construct($contenu, $dateDebut, $DateFin, $nombreJours, $lieu, $requis, $prestataire, $image, $id, $libelle) {
		$this->id = $id;
		$this->libelle = $libelle;
		$this->contenu = $contenu;
		$this->dateDebut = $dateDebut;
		$this->dateFin = $dateFin;
		$this->nombreJours = $nombreJours;
		$this->lieu = $lieu;
		$this->requis = $requis;
		$this->prestataire = $prestataire;
		$this->image = $image;
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

	function getAllFormation() {
		
	}
}

?>