<?php

include_once "./librairie.php";

debutPage("Gestion des employés");
aside($_SESSION["id"]);

$user = new User($_SESSION["id"], $_SESSION["login"], $_SESSION["mail"],$_SESSION["credits"],$_SESSION["jours"],$_SESSION["admin"]);

/* Liste des demandes en attentes */

tabDemandes($user->getDemandes());

finPage();

?>