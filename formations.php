<?php

include_once "./librairie.php";

debutPage("Liste des formations");
aside($_SESSION["id"]);

$user = new User($_SESSION["id"], $_SESSION["login"], $_SESSION["mail"],$_SESSION["credits"],$_SESSION["jours"]);

/* Action sur les formations */

if (isset($_GET["action"]) && isset($_GET["formation"]) && $_GET["formation"] != "") {

	/* Inscription */

	if ($_GET["action"] == "inscription") {
		$formation = $_GET["formation"];

	}

	/* Désinscription */

	if ($_GET["action"] == "desinscription") {
		$formation = $_GET["formation"];

	}
}

/* Liste des formations à venir */

tabFormations("Liste des formations à venir", $user->getFormationsFutures());

finPage();

?>