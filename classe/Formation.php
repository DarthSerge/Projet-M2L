<?php 

include('DB.php');
include('Script.php');

Class Formation{

	//attributs 
	private $contenu;
	private $dateDebut;
	private $dateFin;
	private $nombreJours;
	private $lieu;
	private $requis;
	private $prestataire;
	private $image;
	private $id;
	private $etat;

	//constructeur
	function __construct($contenu,$dateDebut,$DateFin,$nombreJours,$lieu,$requis;$prestataire,$image,$etat,$id){

		$this->id = $id;
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
	function getContenu(){
		return $this->contenu;
	}

	function getId(){
		return $this->id;
	}

	function getDateDebut(){
		return $this->dateDebut;
	}

	function getDateFin(){
		return $this->datefin;
	}

	function getNombreJours(){
		return $this->nombreJours;
	}

	function getLieu(){
		return $this->lieu;
	}

	function getRequis(){
		return $this->requis;
	}

	function getPrestataire(){
		return $this->prestataire;
	}

	function getImage(){
		return $this->image;
	}

	function setContenu($contenu){
		$this->contenu = $contenu;
	}

	function setContenu($id){
		$this->id = $id;
	}

	function setContenu($dateDebut){
		$this->dateDebut = $dateDebut;
	}

	function setContenu($dateFin){
		$this->dateFin = $dateFin;
	}

	function setContenu($nombreJours){
		$this->nombreJours = $nombreJours;
	}

	function setContenu($lieu){
		$this->lieu = $lieu;
	}

	function setContenu($requis){
		$this->requis = $requis;
	}

	function setContenu($prestataire){
		$this->prestataire = $prestataire;
	}

	function setContenu($image){
		$this->image = $image;
	}

	function getAllFormation{
		
	}

}

?>