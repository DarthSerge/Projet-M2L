<?php

include_once "./librairie.php";

debutPage("Connexion");


$msgErreur = "";
$msgLogin = "";
$msgMDP = "";
$error = false;

if (isset($_POST["login"]) && isset($_POST["mdp"])) {
	if ($_POST["login"] == "") {
		$msgLogin = "Champ obligatoire !";
		$error = true;
	}

	if ($_POST["mdp"] == "") {
		$msgMDP = "Champ obligatoire !";
		$error = true;
	}

	if (!$error) {
		$db = new DB_User;

		if ($db->checkId($_POST["login"],$_POST["mdp"])) {
		/*	$_SESSION["id"] = ;
			$_SESSION["login"] = ;
			$_SESSION["mail"] = ;*/
			redirect("compte.php");
		} else
			$msgErreur = "Identifiants incorrect !";
	}
}

echo "<div id=\"form\">\n";
	echo "<form action=\"identification.php\" method=\"post\">\n";
		echo "<h1>Gestion des formations</h1>\n";
		echo "<p>Authentification</p>\n";
		echo "<div><label> Login *<span>".$msgLogin."</span></label><input type=\"text\" name=\"login\" /></div>\n";
		echo "<div><label> Mot de passe *<span>".$msgMDP."</span></label><input type=\"password\" name=\"mdp\" /></div>\n";
		echo "<input type=\"submit\" value=\"Connexion\" id=\"boutonConnexion\">\n";
	echo "</form>\n";
	echo "<div id=\"msgErreur\">";
		echo $msgErreur;
	echo "</div>\n";
echo "</div>\n";

finPage();

?>