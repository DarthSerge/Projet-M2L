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

echo "<table border=\"1\">\n";
	echo "<tr>\n";
		echo "<td>Libellé</td>\n";
		echo "<td>Date de début</td>\n";
		echo "<td>Date de fin</td>\n";
		echo "<td>Lieu</td>\n";
		echo "<td>Crédits</td>\n";
	echo "</tr>\n";

	echo "<tr>\n";
		echo "<td cols=\"5\">Formations annulées</td>\n";
	echo "</tr>\n";

	echo "<tr>\n";
	echo "</tr>\n";

	echo "<tr>\n";
		echo "<td cols=\"5\">Formations annulées</td>\n";
	echo "</tr>\n";

	echo "<tr>\n";
	echo "</tr>\n";

	echo "<tr>\n";
		echo "<td cols=\"5\">Formations annulées</td>\n";
	echo "</tr>\n";

	echo "<tr>\n";
	echo "</tr>\n";

	echo "<tr>\n";
		echo "<td cols=\"5\">Formations annulées</td>\n";
	echo "</tr>\n";

	echo "<tr>\n";
	echo "</tr>\n";
echo "</table>\n";

finPage();

?>