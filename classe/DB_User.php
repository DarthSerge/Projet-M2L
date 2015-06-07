<?php

include_once "DB.php";

Class DB_User extends DB {

	//test de connection
	function checkId($login,$mdp){

		//connection a la base
		$dbh = $this->connect();
		$sql = "SELECT user_id, user_admin, user_login, user_mail FROM user WHERE user_login = :login AND user_mdp = :mdp AND user_actif = 1;";

		//on envoie la requête et on bind les arguments
		$stmt = $dbh->prepare($sql);
		$stmt->BindValue(':login',$login);
		$stmt->BindValue(':mdp',md5($mdp));
		
		//vrai si les identifiants sont corrects ou faux dans le cas contraire
		if ($stmt->execute()) {
			$retour = $stmt->fetch(PDO::FETCH_ASSOC);

			$retour["credits"] 	= $this->getCreditsUser($retour["id"]);
			$retour["jours"] 	= $this->getJoursUser($retour["id"]);

			if (count($retour) != 1) {
				return $retour;
			} else {
				return false;
			}
		}
		else{
			echo("Erreur dans la requête");
			return false;
		}
	}

	//ajoute/supprime des formations à l'utilisateur
	function updateFormationUser($id){

		//connection à la base et début de transaction
		$dbh = $this->connect();
		$dhb->beginTransaction();

		//on commence par la suppression des données de la liste des formations de l'utilisateur
		$sql = "DELETE FROM formation_user WHERE form_user_id = :id";

		//on envoie la requête et on bind les arguments
		$stmt = $dbh->prepare($sql);
		$stmt->BindValue(':id',$id);

		//si la requete échoue on annule la transaction
		if (!$stmt->execute()){
			$dbh->rollBack();
			echo("Erreur dans la de suppression");
			return false;
		}

		//pour chaque formation choisie l'on insert une ligne dans la table de relation
		foreach ($this->ListeFormation as $Formation){

			//on insert les nouvelles données
			$sql = "INSERT INTO formation_user(form_user_id,form_formation_id) VALUES(:userId,:formationId)";

			//on envoie la requête et on bind les arguments
			$stmt = $dbh->prepare($sql);
			$stmt->BindValue(':userId',$id);
			$stmt->BindValue(':formationID',$Formation->getId());

			//si la requete échoue on annule la transaction
			if (!$stmt->execute()){
			$dbh->rollBack();
			echo("Erreur dans la requete d'insertion");
			return false;
			}
			
		}
		//on ferme la transaction
		$dbh->commit();
		return true;
	}

	function getFormationsFutures($id){

		$listeFormationsDispo = array();

		//connection a la base
		$dbh = $this->connect();
		$sql = "SELECT form_id,form_libelle, form_contenu, form_date_debut, form_date_fin, form_lieu, form_cout_credit,prest_id,form_prerequis FROM formation WHERE form_date_debut >= DATE_ADD(CURDATE(),INTERVAL 1 day)";

		//on envoie la requête et on bind les arguments
		$stmt = $dbh->prepare($sql);
		$stmt->BindValue(':id',$id);
		
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
				$listeFormationsDispo[] = $formation;
			}

		}else{
			echo("Erreur lors de la lecture des données");
			return false;
		}
		return $listeFormationsDispo;
	}

	function getCreditsUser($id){
		//connexion 
		$dbh = $this->connect();
		$sql = "CALL getCredits(:id);";

		//on envoie la requête et on bind les arguments
		$stmt = $dbh->prepare($sql);
		$stmt->BindValue(':id',$id);
		
		//renvoi 
		if ($stmt->execute()){

			$res = $stmt->fetch(PDO::FETCH_ASSOC);

			return $res["credit"];
		} else
			return false;
	}

	function getJoursUser($id) {
		$nbJours = 0;
		$listeFormations = array();

		$dbh1 = $this->connect();

		/* Récupération du nombre de jours initial */

		$dbh1 = $this->connect();
		$sql = "SELECT param_valeur FROM parametres WHERE param_libelle = 'jours'";
		$stmt1 = $dbh1->prepare($sql);
		
		if ($stmt1->execute()) {
			while ($data1 = $stmt1->fetch(PDO::FETCH_ASSOC))
				$nbTotal = $data1["param_valeur"];
		} else
			$nbTotal = 0;

		/* Récupération des formations de l'utilisateurs (sauf celles qui ont été annulés) */

		$dbh2 = $this->connect();
		$sql = "SELECT form_id FROM participe WHERE user_id = :id AND part_statut <> 'annulee';";
		$stmt2 = $dbh2->prepare($sql);
		$stmt2->BindValue(':id', $id);
		
		if ($stmt2->execute()) {
			while ($data2 = $stmt2->fetch(PDO::FETCH_ASSOC))
				$listeFormations[] = $data2["form_id"];
		} else
			$listeFormations = false;

			$_SESSION["kiwi"] = $listeFormations;

		/* Calcul du nombre de jours de ces formations combinées */

		$dbh3 = $this->connect();
		$sql = "CALL calculJours(:idFormation);";
		$stmt3 = $dbh3->prepare($sql);

		if ($listeFormations != false) {
			foreach ($listeFormations as $formation) {
				$stmt3->BindValue(':idFormation', $formation);

				if ($stmt3->execute()){
					$res = $stmt3->fetch(PDO::FETCH_ASSOC);
					$nbJours += $res["jours"];
				}
			}
		}

		return $nbTotal - $nbJours;
	}

}

?>