<?php

include_once "./librairie.php";

debutPage("Gestion des employés");

$user = new User($_SESSION["id"], $_SESSION["login"], $_SESSION["mail"],$_SESSION["credits"],$_SESSION["jours"], $_SESSION["admin"]);

if (!$_SESSION["admin"])
	redirect("compte.php");

/* Action sur les demandes */

if (isset($_POST["action"]) && isset($_POST["employe"]) && $_POST["employe"] != "" && isset($_POST["formation"]) && $_POST["formation"] != "") {

	/* Inscription */

	if ($_POST["action"] == "accepter")
		$user->accepteFormation($_POST["formation"], $_POST["employe"]);

	/* Désinscription */

	if ($_POST["action"] == "refuser")
		$user->refuseFormation($_POST["formation"], $_POST["employe"]);
}

aside($_SESSION["id"]);

/* Liste des demandes en attentes */

tabDemandes($user->getDemandes());

finPage();

?>