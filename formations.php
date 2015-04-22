<?php

include_once "./librairie.php";

debutPage("Liste des formations");
aside($_SESSION["id"]);

$user = new User($_SESSION["id"], $_SESSION["login"], $_SESSION["mail"]);

echo "\nAnnulées = ";
foreach ($user->getListeAnnulees() as $item)
	echo $item." ";

echo "\nEn Cours = ";
foreach ($user->getListeEnCours() as $item)
	echo $item." ";

echo "\nTerminees = ";
foreach ($user->getListeTerminees() as $item)
	echo $item." ";

echo "\nAcceptées = ";
foreach ($user->getListeAcceptees() as $item)
	echo $item." ";

echo "\nDemandées = ";
foreach ($user->getListeDemandees() as $item)
	echo $item." ";


echo "<table id=\"tableauFormations\">\n";

/* Liste des formations */

ligneLabelFormations("Liste des formations");

listeTableauFormations($user->getAllFormations());

echo "</table>\n";

finPage();

?>