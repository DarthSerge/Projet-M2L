<?php

include_once "./librairie.php";

debutPage("Gestion des employés");
aside($_SESSION["id"]);

/* Liste des formations en attentes */

tabFormations("Liste des formations en attentes", $user->getFormationsAttente());

finPage();

?>