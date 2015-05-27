<?php

include_once "./librairie.php";

debutPage("Liste des formations");
aside($_SESSION["id"]);

$user = new User($_SESSION["id"], $_SESSION["login"], $_SESSION["mail"]);

/* Liste des formations à venir */

<<<<<<< HEAD
tabFormations("Liste des formations à venir", $user->getFormationsFutures());
=======
/* Liste des formations disponibles */

ligneLabelFormations("Liste des formations a venir");

listeTableauFormations($user->getFormationsFutures($user->getId()));

echo "</table>\n";
>>>>>>> origin/master

finPage();

?>