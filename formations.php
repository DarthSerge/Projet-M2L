<?php

include_once "./librairie.php";

debutPage("Liste des formations");

$user = new User($_SESSION["id"], $_SESSION["login"], $_SESSION["mail"], $_SESSION["credits"],$_SESSION["jours"],$_SESSION["admin"]);

/* Action sur les formations */

if (isset($_POST["action"]) && isset($_POST["formation"]) && $_POST["formation"] != "") {

	/* Inscription */

	if ($_POST["action"] == "inscription") {
		$user->inscription($_POST["formation"]);
		$_SESSION["credits"] -= $_POST["credits"];
		$_SESSION["jours"] -= $_POST["jours"];
	}

	/* Désinscription */

	if ($_POST["action"] == "desinscription") {
		$user->desinscription($_POST["formation"]);
		$_SESSION["credits"] += $_POST["credits"];
		$_SESSION["jours"] += $_POST["jours"];
	}
}

aside($_SESSION["id"]);

/* Liste des formations à venir */

tabFormations("Liste des formations à venir", $user->getFormationsFutures());

finPage();

?>