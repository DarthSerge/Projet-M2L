<?php

include_once "./librairie.php";

debutPage("Mon Compte");
aside($_SESSION["id"]);


echo $_SESSION["kiwi"];
foreach ($_SESSION["kiwi"] as $test)
	echo $test."<br>";




$user = new User($_SESSION["id"], $_SESSION["login"], $_SESSION["mail"],$_SESSION["credits"],$_SESSION["jours"]);

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

finPage();

?>