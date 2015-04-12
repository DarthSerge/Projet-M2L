<?php

session_start();

include_once "./classe/DB.php";
include_once "./classe/DB_User.php";
include_once "./classe/DB_Formation.php";
include_once "./classe/User.php";
include_once "./classe/Formation.php";

function redirect($url) {
	header("Location:".$url);
}

function getFichier() {
	return basename($_SERVER['PHP_SELF'], ".php");
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

	if (getFichier() != "identification") {
		echo "<header>\n";
			echo "<ul>\n";
				echo "<li class=\"nav\"><a href=\"index.php\">Mon compte</a></li>\n";
				echo "<li class=\"nav\"><a href=\"mailto:jeanfrancois.poivey@free.fr\">Contactez-nous</a></li>\n";
				echo "<li class=\"nav\"><a href=\"formations.php\">Les formations</a></li>\n";
				echo "<li class=\"nav\" id=\"deconnexion\"><a href=\"\">Se déconnecter</a></li>\n";
			echo "</ul>\n";
		echo "</header>\n";
	}
		echo "<section>\n";
			echo "<aside>\n";
			echo "</aside>\n";

			echo "<article>\n";
}

function finPage() {
			echo "</article>\n";
		echo "</section>\n";

	if (getFichier() != "identification") {
			echo "<footer>\n";
				echo "<a href=\"mentions-legales.php\">Mentions Légales</a>\n";
			echo "</footer>\n";
	}
	echo "</body>\n";

	echo "</html>\n";
}


?>