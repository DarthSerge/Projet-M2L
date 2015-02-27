<html>
<head>
	<title>M2L</title>
	<link rel="stylesheet" type="text/css" href="./css/general.css" />
	<script src="js/jquery-2.1.1.min.js"></script>
	<script src="js/general.js"></script>
	<meta charset="utf-8" />
</head>

<body>
	<?php
		session_start();
	?>
	<header>
		<ul>
			<li class="nav"><a href="index.php">Accueil</a></li>
			<li class="nav"><a href="mailto:jeanfrancois.poivey@free.fr">Contactez-nous</a></li>
			<li class="nav"><a href="reservation-salle.php">Nos formations</a></li>

			<?php
				if (!isset($_SESSION["login"]))
				{
			?>
			<li class="nav"><a href="identification.php">Se connecter</a></li>
			<?php
				}

				else
				{
			?>
			<li class="nav"><a href="javascript:if(confirm('Voulez-vous vraiment vous déconnecter ?')){document.location.href='?logout';}">Se déconnecter</a></li>
			<?php
				}
			?>
		</ul>
	</header>

	<section>
		<aside>
			
		</aside>

		<article>