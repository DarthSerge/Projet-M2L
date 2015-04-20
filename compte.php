<?php

include_once "./librairie.php";

debutPage("Mon Compte");
aside($_SESSION["id"]);

$user = new User($_SESSION["id"], $_SESSION["login"], $_SESSION["mail"]);

echo "<table id=\"tableauFormations\">\n";

/* Formations en cours */

ligneLabelFormations("Formations en cours");

listeTableauFormations($user->getFormationsEnCours());

/* Formations acceptées */

ligneLabelFormations("Formations acceptées");

listeTableauFormations($user->getFormationsAcceptees());

/* Formations terminées */

ligneLabelFormations("Formations terminées");

listeTableauFormations($user->getFormationsTerminees());

/* Formations demandées */

ligneLabelFormations("Formations demandées");

listeTableauFormations($user->getFormationsDemandees());

/* Formations annulées */

ligneLabelFormations("Formations annulées");

listeTableauFormations($user->getFormationsAnnulees());

echo "</table>\n";

finPage();

?>