<?php

include_once "DB.php";

Class DB_Formation extends DB {

	function misaAJourFormations(){
		//connection a la base
		$dbh = $this->connect();

		/* Mise à jour des formations acceptées */

		$liste = "(0";

		$sql = "SELECT form_id FROM formation WHERE form_date_debut = '".date("Y-m-d")."'";

		//on envoie la requête
		$stmt1 = $dbh->prepare($sql);

		if ($stmt1->execute()) {
			while($data = $stmt1->fetch(PDO::FETCH_ASSOC))
				$liste .= ",".$data["form_id"];

			$liste .= ")";

			$sql = "UPDATE participe SET part_statut='encours' WHERE part_statut='acceptee' AND form_id IN ".$liste;
			$stmt2 = $dbh->prepare($sql);
			$stmt2->execute();
		}

		/* Mise à jour des formations en cours */

		$liste = "(0";

		$sql = "SELECT form_id FROM formation WHERE form_date_fin = '".date("Y-m-d")."'";

		//on envoie la requête
		$stmt1 = $dbh->prepare($sql);

		if ($stmt1->execute()) {
			while($data = $stmt1->fetch(PDO::FETCH_ASSOC))
				$liste .= ",".$data["form_id"];

			$liste .= ")";

			$sql = "UPDATE participe SET part_statut='terminee' WHERE part_statut='encours' AND form_id IN ".$liste;
			$stmt2 = $dbh->prepare($sql);
			$stmt2->execute();
		}
	}

	//renvoi la liste complète des formations sous forme de tableau d'objet
	function getAllFormations(){

		$listeFormations = array();

		//connection a la base
		$dbh = $this->connect();
		$sql = "SELECT form_id, form_libelle, form_contenu, form_date_debut, form_date_fin, form_lieu, form_prerequis, form_cout_credit, prest_id FROM formation WHERE form_date_debut>CURDATE()";

		//on envoie la requête
		$stmt = $dbh->prepare($sql);

		if ($stmt->execute()){
			while($data = $stmt->fetch(PDO::FETCH_ASSOC)){
				$formation = new Formation($data["form_id"],
					  					   $data["form_libelle"],
										   $data["form_contenu"],
										   $data["form_date_debut"],
										   $data["form_date_fin"],
										   $data["form_lieu"],
										   $data["form_prerequis"],
										   $data["form_cout_credit"],
										   $data["prest_id"]);
				$listeFormations[] = $formation;
			}

		}else{
			echo("Erreur lors de la lecture des données");
			return false;
		}
		return $listeFormations;
	}

	//renvoi la liste complète des formations sous forme de tableau d'objet
	function getFormations($id, $statut){

		$listeFormations = array();

		//connection a la base
		$dbh = $this->connect();
		$sql = "CALL getFormations(:id, :statut)";

		//on envoie la requête
		$stmt = $dbh->prepare($sql);
		$stmt->BindValue(":id",$id);
		$stmt->BindValue(":statut",$statut);

		if ($stmt->execute()){
			while($data = $stmt->fetch(PDO::FETCH_ASSOC))
				$listeFormations[] = $data["form_id"];

		}else{
			echo("Erreur lors de la lecture des données");
			return false;
		}
		return $listeFormations;
	}

	//renvoi la liste des formations suivi par l'utilisateur spécifié
	function getFormationUser($userId, $statut){

		$listeFormations = array();

		//connection a la base
		$dbh = $this->connect();

		$sql = "SELECT f.form_id, form_libelle, form_contenu, form_date_debut, form_date_fin, form_lieu, form_prerequis, form_cout_credit, prest_id FROM formation f WHERE form_id IN (SELECT p.form_id FROM participe p WHERE user_id = :userId AND part_statut = :statut)";

		//on envoie la requête et on bind les arguments
		$stmt = $dbh->prepare($sql);
		$stmt->BindValue(":userId",$userId);
		$stmt->BindValue(":statut",$statut);

		if ($stmt->execute())
			while($data = $stmt->fetch(PDO::FETCH_ASSOC)){
				$formation = new Formation($data["form_id"],
					  					   $data["form_libelle"],
										   $data["form_contenu"],
										   $data["form_date_debut"],
										   $data["form_date_fin"],
										   $data["form_lieu"],
										   $data["form_prerequis"],
										   $data["form_cout_credit"],
										   $data["prest_id"]);
				$listeFormations[] = $formation;
			}

		 else {
			echo("Erreur lors de la lecture des données");
			return false;
		}
		return $listeFormations;
	}

	
	function getDemandes(){

		$listeDemande = array();

		//connection a la base
		$dbh = $this->connect();

		$sql = "SELECT p.user_id, p.form_id, u.user_login, f.form_libelle, f.form_date_debut, f.form_date_fin, (SELECT prest_raison_sociale FROM prestataire WHERE prest_id=f.prest_id) as prestataire, f.form_cout_credit FROM participe p INNER JOIN user u ON p.user_id=u.user_id INNER JOIN formation f ON p.form_id=f.form_id WHERE p.part_statut = 'demandee'";

		//on envoie la requête et on bind les arguments
		$stmt = $dbh->prepare($sql);

		if ($stmt->execute())
			while($data = $stmt->fetch(PDO::FETCH_ASSOC))
				$listeDemande[] = array("userId" => $data["user_id"],
										"formId" => $data["form_id"],
										"employe" => $data["user_login"],
										"formation" => $data["form_libelle"],
										"debut" => $data["form_date_debut"],
										"fin" => $data["form_date_fin"],
										"prestataire" => $data["prestataire"],
										"credits" => $data["form_cout_credit"]);
			
		 else {
			echo("Erreur lors de la lecture des données");
			return false;
		}

		return $listeDemande;
	}

	function getNbJours($id) {
		//connexion 
		$dbh = $this->connect();
		$sql = "CALL calculJours(:id);";

		//on envoie la requête et on bind les arguments
		$stmt = $dbh->prepare($sql);
		$stmt->BindValue(':id',$id);
		
		//renvoi 
		if ($stmt->execute()){

			$res = $stmt->fetch(PDO::FETCH_ASSOC);

			return $res["jours"];
		} else
			return false;
	}
}

?>