<?php

include_once "./librairie.php";

debutPage("Mon Compte");
aside($_SESSION["id"]);

$user = new User($_SESSION["id"], $_SESSION["login"], $_SESSION["mail"]);

echo "<table class=\"tableauFormations\">\n";

/* Formations en cours */

tabFormations("Formations en cours", $user->getFormationsEnCours());

/* Formations acceptées */

tabFormations("Formations acceptées", $user->getFormationsAcceptees());

/* Formations terminées */

tabFormations("Formations terminées", $user->getFormationsTerminees());

/* Formations demandées */

tabFormations("Formations demandées", $user->getFormationsDemandees());

/* Formations annulées */

tabFormations("Formations annulées", $user->getFormationsAnnulees());

echo "</table>\n";

finPage();

?>