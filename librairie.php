<?php

session_start();

include_once "./classe/DB.php";
include_once "./classe/DB_User.php";
include_once "./classe/DB_Prestataire.php";
include_once "./classe/DB_Formation.php";
include_once "./classe/User.php";
include_once "./classe/Prestataire.php";
include_once "./classe/Formation.php";

function redirect($url) {
	header("Location:".$url);
}

function getFichier() {
	return basename($_SERVER['PHP_SELF']);
}

function debutPage($titre) {
	echo "<!DOCTYPE html>\n";
	echo "<html>\n";

	echo "<head>\n";
		echo "<title>".$titre."</title>\n";
		echo "<meta charset=\"utf-8\" />\n";
		echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"./css/general.css\" />\n";
		echo "<script src=\"js/jquery-2.1.1.min.js\"></script>\n";
		echo "<script src=\"js/general.js\"></script>\n";
	echo "</head>\n";

	echo "<body>\n";

	if (isset($_GET["deconnexion"])) {
		session_destroy();
		redirect("identification.php");
	}

	if (getFichier() != "identification.php") {
		if (!isset($_SESSION["id"]))
			redirect("identification.php");

		echo "<header>\n";
			echo "<ul>\n";
				echo "<li class=\"nav\"><img src=\"images/logoM2L.png\" title=\"logo\" alt=\"Logo de la M2L\" \></li>\n";
				echo "<li class=\"nav\"><a href=\"compte.php\">Mon compte</a></li>\n";
				echo "<li class=\"nav\"><a href=\"mailto:jeanfrancois.poivey@free.fr\">Contactez-nous</a></li>\n";
				echo "<li class=\"nav\"><a href=\"formations.php\">Les formations</a></li>\n";

				if ($_SESSION["admin"])
					echo "<li class=\"nav\"><a href=\"gestion-employes.php\">Gestion</a></li>\n";

				echo "<li class=\"nav\"><a href=\"?deconnexion\" id=\"deconnexion\">Se déconnecter</a></li>\n";
			echo "</ul>\n";
		echo "</header>\n";
	}
		echo "<section>\n";
}

function aside($id) {
	if ($id != 0) {
		echo "<aside>\n";
			echo "<div><span>Login :</span> ".$_SESSION["login"]."</div>";
			echo "<div><span>Mail :</span> ".$_SESSION["mail"]."</div>";
			echo "<div><span>Crédits :</span> ".$_SESSION["credits"]."</div>";
			echo "<div><span>Jours restant :</span> ".$_SESSION["jours"]."</div>";
		echo "</aside>\n";
	}

	echo "<article>\n";
}

function finPage() {
			echo "</article>\n";
		echo "</section>\n";

	echo "</body>\n";

	echo "</html>\n";
}

function ligneLabelFormations($label) {
	echo "<tr>\n";
		echo "<th colspan=\"8\" class=\"typeFormations\">".$label."</th>\n";
	echo "</tr>\n";
}

function ligueAucuneFormation() {
	echo "<tr>\n";
		echo "<td colspan=\"8\">Aucune formation</td>\n";
	echo "</tr>\n";
}

function ligneChamps() {
	echo "<tr>\n";
		echo "<th class=\"libelle\">Libellé</th>\n";
		echo "<th class=\"contenu\">Contenu</th>\n";
		echo "<th class=\"date\">Date de début</th>\n";
		echo "<th class=\"date\">Date de fin</th>\n";
		echo "<th class=\"lieu\">Lieu</th>\n";
		echo "<th class=\"prerequis\">Prérequis</th>\n";
		echo "<th class=\"prestataire\">Prestataire</th>\n";
		echo "<th class=\"credits\">Crédits</th>\n";
	echo "</tr>\n";
}

function verifIdFormation($idFormation) {
	$employe = new User($_SESSION["id"], $_SESSION["login"], $_SESSION["mail"],$_SESSION["credits"], $_SESSION["jours"],$_SESSION["admin"]);

	// Formation Demandée

	$tab = $employe->getFormationsDemandees();
	$tabDemandees = array();

	foreach ($tab as $formation)
		$tabDemandees[] = $formation->getId();

	if (in_array($idFormation, $tabDemandees))
		return "demandee";
	
	/* Formation Acceptée */

	$tab = $employe->getFormationsAcceptees();
	$tabAcceptees = array();

	foreach ($tab as $formation)
		$tabAcceptees[] = $formation->getId();

	if (in_array($idFormation, $tabAcceptees))
		return "acceptee";

	/* Formation Refusée */

	$tab = $employe->getFormationsAnnulees();
	$tabRefusees = array();

	foreach ($tab as $formation)
		$tabRefusees[] = $formation->getId();

	if (in_array($idFormation, $tabRefusees))
		return "refusee";

	/* Formation basique */

	return "basique";
}

function listeTableauFormations($tableau) {
	if (count($tableau) == 0)
		ligueAucuneFormation("Aucune formation");

	else {
		ligneChamps();

		foreach ($tableau as $formation) {
			$prestataire = $formation->getPrestataire();
			$id = $formation->getId();
			$categorie = verifIdFormation($id);

			if ($categorie == "basique")
				if ($_SESSION["credits"] < $formation->getCredits() || $_SESSION["jours"] < $formation->getNbJours())
					$categorie = "insuffisant";

			if (getFichier() != "formations.php")
				echo "<tr>\n";
			
			else {
				echo "<tr id=\"".$id."\" title=\"".$formation->getLibelle()."\" class=\"".$categorie."\">\n";

				if ($categorie == "basique" || $categorie == "demandee" || $categorie == "acceptee") {
					if ($categorie == "basique")
						$action = "inscription";
					else
						$action = "desinscription";

					echo "<form id=\"formation".$id."\" action=\"formations.php\" method=\"post\">\n";
						echo "<input type=\"hidden\" name=\"action\" value=\"".$action."\" />\n";
						echo "<input type=\"hidden\" name=\"formation\" value=\"".$id."\" />\n";
						echo "<input type=\"hidden\" name=\"credits\" value=\"".$formation->getCredits()."\" />\n";
						echo "<input type=\"hidden\" name=\"jours\" value=\"".$formation->getNbJours()."\" />\n";
					echo "</form>\n";
				}
			}

				echo "<td class=\"libelle\">".$formation->getLibelle()."</td>\n";
				echo "<td class=\"contenu\">".$formation->getContenu()."</td>\n";
				echo "<td class=\"date\">".$formation->getDateDebut()."</td>\n";
				echo "<td class=\"date\">".$formation->getDateFin()."</td>\n";
				echo "<td class=\"lieu\">".$formation->getLieu()."</td>\n";
				echo "<td class=\"prerequis\">".$formation->getRequis()."</td>\n";
				echo "<td class=\"prestataire\">".$prestataire->getRaisonSociale()."</td>\n";
				echo "<td class=\"credits\">".$formation->getCredits()."</td>\n";
			echo "</tr>\n";
		}
	}
}

function tabFormations($label, $tableau) {
	echo "<table>\n";

	ligneLabelFormations($label);

	listeTableauFormations($tableau);

	echo "</table>\n";
}

function tabDemandes($tableau) {
	echo "<table>\n";

	echo "<tr>\n";
		echo "<th colspan=\"8\" class=\"typeDemandes\">Liste des demandes en attentes</th>\n";
	echo "</tr>\n";

	echo "<tr>\n";
		echo "<th class=\"employe\">Employé(e)</th>\n";
		echo "<th class=\"formation\">Formation</th>\n";
		echo "<th class=\"date\">Date de début</th>\n";
		echo "<th class=\"date\">Date de fin</th>\n";
		echo "<th class=\"prestataire\">Prestataire</th>\n";
		echo "<th class=\"credits\">Crédits</th>\n";
		echo "<th class=\"accepter\">Accepter</th>\n";
		echo "<th class=\"refuser\">Refuser</th>\n";
	echo "</tr>\n";

	if (count($tableau) == 0)
		ligueAucuneFormation("Aucune formation");

	else {
		ligneChamps();

		foreach ($tableau as $formation) {
			$prestataire = $formation->getPrestataire();
			$id = $formation->getId();
			$categorie = verifIdFormation($id);

			if ($categorie == "basique")
				if ($_SESSION["credits"] < $formation->getCredits() || $_SESSION["jours"] < $formation->getNbJours())
					$categorie = "insuffisant";

			if (getFichier() != "formations.php")
				echo "<tr>\n";
			
			else {
				echo "<tr id=\"".$id."\" title=\"".$formation->getLibelle()."\" class=\"".$categorie."\">\n";

				if ($categorie == "basique" || $categorie == "demandee" || $categorie == "acceptee") {
					if ($categorie == "basique")
						$action = "inscription";
					else
						$action = "desinscription";

					echo "<form id=\"formation".$id."\" action=\"formations.php\" method=\"post\">\n";
						echo "<input type=\"hidden\" name=\"action\" value=\"".$action."\" />\n";
						echo "<input type=\"hidden\" name=\"formation\" value=\"".$id."\" />\n";
						echo "<input type=\"hidden\" name=\"credits\" value=\"".$formation->getCredits()."\" />\n";
						echo "<input type=\"hidden\" name=\"jours\" value=\"".$formation->getNbJours()."\" />\n";
					echo "</form>\n";
				}
			}

				echo "<td class=\"libelle\">".$formation->getLibelle()."</td>\n";
				echo "<td class=\"contenu\">".$formation->getContenu()."</td>\n";
				echo "<td class=\"date\">".$formation->getDateDebut()."</td>\n";
				echo "<td class=\"date\">".$formation->getDateFin()."</td>\n";
				echo "<td class=\"lieu\">".$formation->getLieu()."</td>\n";
				echo "<td class=\"prerequis\">".$formation->getRequis()."</td>\n";
				echo "<td class=\"prestataire\">".$prestataire->getRaisonSociale()."</td>\n";
				echo "<td class=\"credits\">".$formation->getCredits()."</td>\n";
			echo "</tr>\n";
		}
	}

	echo "</table>\n";
}

?>