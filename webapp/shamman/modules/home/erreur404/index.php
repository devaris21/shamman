<!DOCTYPE html>
<html>

<?php include($this->rootPath("webapp/gestion/elements/templates/head.php")); ?>


<body class="gray-bg">
	<div class="container text-center " style="padding-top: 7%;">
		<div class="row">
			<div class="offset-1 col-md-3">
				<br><img style="width: 320px; opacity: 0.5"  src="<?= $this->stockage("images", "societe", "logo.png") ?>" alt="logo de DEVARIS 21">
			</div>
			<div class="col-md-6 offset-1 text-justify">
				<h1 class="text-red text-uppercase" style="font-size: 60px;"> Erreur 404</h1>
				<span><?= $this->getUrl() ?></span>
				<hr>
				<h2 class="font-bold">Désolé, la page est introuvable !</h2><br>
				<h4 style="line-height: 25px;">
					Nous sommes désolé de ne pas pouvoir donner suite à votre requette car la page que vous essayez d'atteindre n'existe pas ou a été déplacé. Quelques conseils :
				</h4><br>
				<ul>
					<li>Vérifiez que l'adresse de la page est correctement saisie</li>
					<li>Contactez votre administrateur</li>
				</ul>
			</div>
		</div>
		<hr>
	</div>

	<?php //include($this->rootPath("webapp/gestion/elements/templates/script.php")); ?>

</body>

</html>