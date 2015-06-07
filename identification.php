<?php

include_once "./librairie.php";

debutPage("Connexion");
aside(0);

$login = "";
$msgErreur = "";
$msgLogin = "";
$msgMDP = "";
$error = false;

if (isset($_SESSION["id"]))
	redirect("compte.php");

elseif (isset($_POST["login"]) && isset($_POST["mdp"])) {
	$login = $_POST["login"];

	if ($login == "") {
		$msgLogin = "Champ obligatoire !";
		$error = true;
	}

	if ($_POST["mdp"] == "") {
		$msgMDP = "Champ obligatoire !";
		$error = true;
	}

	if (!$error) {
		$utilisateur = new User(0, "", "",0,0);

		$test = $utilisateur->CheckConnexion($login, $_POST["mdp"]);

		if (!$test)
			$msgErreur = "Identifiants incorrect !";

		else {
			$miseAJour = new DB_Formation();
			$miseAJour->misaAJourFormations();

			$_SESSION["id"] = $test["id"];
			$_SESSION["login"] = $test["login"];
			$_SESSION["mail"] = $test["mail"];
			$_SESSION["credits"] = $test["credits"];
			$_SESSION["jours"] = $test["jours"];
			$_SESSION["admin"] = $test["admin"];
			redirect("compte.php");
		}
	}
}

echo "<div id=\"form\">\n";
	echo "<form action=\"identification.php\" method=\"post\">\n";
		echo "<h1>Gestion des formations</h1>\n";
		echo "<p>Authentification</p>\n";
		echo "<div><label> Login *<span>".$msgLogin."</span></label><input type=\"text\" name=\"login\" value=\"".$login."\"/></div>\n";
		echo "<div><label> Mot de passe *<span>".$msgMDP."</span></label><input type=\"password\" name=\"mdp\" /></div>\n";
		echo "<input type=\"submit\" value=\"Connexion\" id=\"boutonConnexion\">\n";
	echo "</form>\n";
	echo "<div id=\"msgErreur\">";
		echo $msgErreur;
	echo "</div>\n";
echo "</div>\n";

finPage();

?>