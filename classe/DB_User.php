<?php

include("DB.php");
include("Script.php");

Class DB_User extends Connection{

	//test de connection
	function checkId($login,$mdp){

		//connection a la base
		$dbh = $this->connect();
		$sql = "SELECT user_id,user_admin FROM user WHERE user_login = :login AND user_mdp = :mdp";

		//on envoie la requête et on bind les arguments
		$stmt = $dbh->prepare($sql);
		$stmt->BindValue(':login',$login);
		$stmt->BindValue(':mdp',md5($mdp));
		
		//renvoi vrai si les identifiants sont correct ou faux si erreur SQL ou identifiants incorrects
		if ($stmt->execute()){

			//si identifié on crée l'objet utilisateur en cours
			if ($stmt->fetch() != null){
				$this->id = $stmt->fetch()["id"];
				$this->admin = $stmt->fetch()["admin"];
				return true;
			}else{
				return false;
			}
		}
		else{
			scriptAlert("Erreur dans la requête");
			return false;
		}
	}

	//ajoute/supprime des formations à l'utilisateur
	function updateFormationUser(){

		//connection à la base et début de transaction
		$dbh = $this->connect();
		$dhb->beginTransaction();

		//on commence par la suppression des données de la liste des formations de l'utilisateur
		$sql = "DELETE FROM formation_user WHERE form_user_id = :id";

		//on envoie la requête et on bind les arguments
		$stmt = $dbh->prepare($sql);
		$stmt->BindValue(':id',$this->id);

		//si la requete échoue on annule la transaction
		if (!$stmt->execute()){
			$dbh->rollBack();
			scriptAlert("Erreur dans la de suppression");
			return false;
		}

		//pour chaque formation choisie l'on insert une ligne dans la table de relation
		foreach ($this->ListeFormation as $Formation){

			//on insert les nouvelles données
			$sql = "INSERT INTO formation_user(form_user_id,form_formation_id) VALUES(:userId,:formationId)";

			//on envoie la requête et on bind les arguments
			$stmt = $dbh->prepare($sql);
			$stmt->BindValue(':userId',$this->id);
			$stmt->BindValue(':formationID',$Formation->getId());

			//si la requete échoue on annule la transaction
			if (!$stmt->execute()){
			$dbh->rollBack();
			scriptAlert("Erreur dans la requete d'insertion");
			return false;
			}
			
		}
		//on ferme la transaction
		$dbh->commit();
		return true;
	}
}

?>