<?php

include_once "DB.php";

Class DB_Formation extends DB {


	//renvoi la liste complète des formations sous forme de tableau d'objet
	function getAllFormation(){

		$Liste = array();

		//connection a la base
		$dbh = $this->connect();
		$sql = "SELECT form_id, form_libelle, form_contenu,form_date_debut AS debut ,form_date_fin AS fin, DATEDIFF(debut,fin) ,form_lieu,form_requis,form_prestataire_id,form_image FROM formation";

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
										   $data["form_id"],
										   $data["form_libelle"]);
				$Liste[] = $Formation;
			}

		}else{
			echo("Erreur lors de la lecture des données");
			return false;
		}
		return $Liste;
	}

	//renvoi la liste des formations suivi parl'utilisateur spécifié
	function getFormationUser($userId, $statut) {

		$Liste = array();

		//connection a la base
		$dbh = $this->connect();

		$sql = "SELECT form_id,form_contenu,form_date_debut AS debut ,form_date_fin AS fin,DATEDIFF(debut,fin),form_lieu,form_requis,form_prestataire_id,form_image FROM formation WHERE form_id IN (SELECT form_id FROM participe WHERE user_id = :user_id AND part_statut = :statut)";

		//on envoie la requête et on bind les arguments
		$stmt = $dbh->prepare($sql);
		$stmt->BindValue(":userId",$userId);
		$stmt->BindValue(":statut",$statut);

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
										   $data["form_id"],
										   $data["form_libelle"]);
				$Liste[] = $Formation;
			}

		}else{
			echo("Erreur lors de la lecture des données");
			return false;
		}
		return $Liste;
	}
}

?>