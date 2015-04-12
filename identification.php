<?php

include_once "./librairie.php";

debutPage("Connexion");
aside(0);

$login = "";
$msgErreur = "";
$msgLogin = "";
$msgMDP = "";
$error = false;

if (isset($_POST["login"]) && isset($_POST["mdp"])) {
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
		$db = new DB_User;

		if ($db->checkId($login,$_POST["mdp"])) {
			$_SESSION["id"] = 2;
			$_SESSION["login"] = "pipoulefifou";
			$_SESSION["mail"] = "pipou@lefifou.com";
			redirect("compte.php");
		} else
			$msgErreur = "Identifiants incorrect !";
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