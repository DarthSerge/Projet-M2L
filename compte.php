<?php

include_once "./librairie.php";

debutPage("Mon Compte");
aside($_SESSION["id"]);

$user = new User($_SESSION["id"], $_SESSION["login"], $_SESSION["mail"]);

$annulees = $user->getFormationsAnnulees();
$demandees = $user->getFormationsDemandees();
$acceptees = $user->getFormationsAcceptees();
$enCours = $user->getFormationsEnCours();
$terminees = $user->getFormationsTerminees();

echo "<table id=\"tableauFormations\">\n";

/* Formations en cours */

ligneLabelFormations("Formations en cours");

listeTableauFormations($enCours);

/* Formations acceptées */

ligneLabelFormations("Formations acceptées");

listeTableauFormations($acceptees);

/* Formations terminées */

ligneLabelFormations("Formations terminées");

listeTableauFormations($terminees);

/* Formations demandées */

ligneLabelFormations("Formations demandées");

listeTableauFormations($demandees);

/* Formations annulées */

ligneLabelFormations("Formations annulées");

listeTableauFormations($annulees);

echo "</table>\n";

finPage();

?>