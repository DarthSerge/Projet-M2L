<?php

include_once "./librairie.php";

debutPage("Liste des formations");
aside($_SESSION["id"]);

$user = new User($_SESSION["id"], $_SESSION["login"], $_SESSION["mail"],$_SESSION["credits"],$_SESSION["jours"]);

/* Liste des formations à venir */

tabFormations("Liste des formations à venir", $user->getFormationsFutures());

tabFormations("Liste des formations en attentes", $user->getFormationsAttente());

finPage();

?>