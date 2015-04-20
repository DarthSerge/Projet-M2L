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
				echo "<li class=\"nav\"><a href=\"compte.php\">Mon compte</a></li>\n";
				echo "<li class=\"nav\"><a href=\"mailto:jeanfrancois.poivey@free.fr\">Contactez-nous</a></li>\n";
				echo "<li class=\"nav\"><a href=\"formations.php\">Les formations</a></li>\n";
				echo "<li class=\"nav\"><a href=\"".getFichier()."?deconnexion\" id=\"deconnexion\">Se déconnecter</a></li>\n";
			echo "</ul>\n";
		echo "</header>\n";
	}
		echo "<section>\n";
}

function aside($id) {
	if ($id != 0) {
		echo "<aside>\n";
			echo "<table border=\"1\">\n";
				echo "<tr>\n";
					echo "<td>Login</td>\n";
					echo "<td>".$_SESSION["login"]."</td>\n";
				echo "</tr>\n";
				
				echo "<tr>\n";
					echo "<td>Mail</td>\n";
					echo "<td>".$_SESSION["mail"]."</td>\n";
				echo "</tr>\n";
			echo "</table>\n";
		echo "</aside>\n";
	}

	echo "<article>\n";
}

function finPage() {
			echo "</article>\n";
		echo "</section>\n";

	if (getFichier() != "identification.php") {
			echo "<footer>\n";
				echo "<a href=\"mentions-legales.php\">Mentions Légales</a>\n";
			echo "</footer>\n";
	}
	echo "</body>\n";

	echo "</html>\n";
}

function ligneLabelFormations($label) {
	echo "<tr>\n";
		echo "<th colspan=\"9\" class=\"typeFormations\">".$label."</th>\n";
	echo "</tr>\n";
}

function ligueAucuneFormation() {
	echo "<tr>\n";
		echo "<td colspan=\"9\">Aucune formation</td>\n";
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

function listeTableauFormations($tableau) {
		if (count($tableau) == 0)
			ligueAucuneFormation("Aucune formation");

		else {
			ligneChamps();

			foreach ($tableau as $formation) {
				$prestataire = $formation->getPrestataire();
				echo "<tr>\n";
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

?>