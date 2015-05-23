<?php

include_once "./librairie.php";

debutPage("Liste des formations");
aside($_SESSION["id"]);

$user = new User($_SESSION["id"], $_SESSION["login"], $_SESSION["mail"]);

echo "<table id=\"tableauFormations\">\n";

/* Liste des formations disponibles */

ligneLabelFormations("Liste des formations a venir");

listeTableauFormations($user->getFormationsDispo());

echo "</table>\n";

finPage();

?>