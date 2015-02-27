<?php

Class DB_Formation extends DB{


	//renvoi la liste complète des formations sous forme de tableau d'objet
	function getAllFormation(){

		$Liste = array();

		//connection a la base
		$dbh = $this->connect();
		$sql = "SELECT form_id,form_contenu,form_date_debut,form_date_fin,XXXXXX as nombre_jours,form_lieu,form_requis,form_prestataire,form_image FROM formation";

		//on envoie la requête
		$stmt = $dbh->prepare($sql);

		if ($stmt->execute()){
			while($data = $stmt->fetch()){
				$Formation = new Formation($data["form_contenu"],
										   $data["form_date_debut"],
										   $data["form_date_fin"],
										   $data["nombre_jours"],
										   $data["form_lieu"],
										   $data["form_requis"],
										   $sata["form_prestataire"],
										   $data["form_image"],
										   "",
										   $data["form_id"]);
				$Liste[] = $Formation;
			}

		}else{
			scriptAlert("Erreur lors de la lecture des données");
			return false;
		}
		return $Liste;
	}

	//renvoi la liste des formations suivi parl'utilisateur spécifié
	function getFormationUser($userId){

		$Liste = array();

		//connection a la base
		$dbh = $this->connect();
		$sql = "SELECT form_id,form_contenu,form_date_debut,form_date_fin,form_etat,XXXXXX as nombre_jours,form_lieu,form_requis,form_prestataire,form_image FROM formation WHERE user_id = :userId";

		//on envoie la requête et on bind les arguments
		$stmt = $dbh->prepare($sql);
		$stmt->BindValue(':userId',$userId);

		if ($stmt->execute()){
			while($data = $stmt->fetch()){
				$Formation = new Formation($data["form_contenu"],
										   $data["form_date_debut"],
										   $data["form_date_fin"],
										   $data["nombre_jours"],
										   $data["form_lieu"],
										   $data["form_requis"],
										   $sata["form_prestataire"],
										   $data["form_image"],
										   $data["form_etat"],
										   $data["form_id"]);
				$Liste[] = $Formation;
			}

		}else{
			scriptAlert("Erreur lors de la lecture des données");
			return false;
		}
		return $Liste;
	}
	
}



?>