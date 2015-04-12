<?php

include_once "DB.php";
include_once "Prestataire.php";

Class DB_Prestataire extends DB {

	//renvoi un tableau fetch_assoc contenant les informations d'un prestataire
	function getPrestataire($id){

		//connection a la base
		$dbh = $this->connect();
		$sql = "SELECT prest_id,prest_raison_sociale,prest_adresse,prest_telephone,prest_siret FROM prestataire WHERE prest_id = :id";

		//on envoie la requête et on bind les arguments
		$stmt = $dbh->prepare($sql);
		$stmt->BindValue(":id",$id);

		if ($stmt->execute()){
				
			$data = $stmt->fetch(PDO::FETCH_ASSOC);

			return $data;
		}else{
			echo("Erreur lors de la lecture des données");
			return false;
		}
	}
}

?>