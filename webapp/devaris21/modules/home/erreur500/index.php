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
				<h1 class="text-orange" style="font-size: 65px;"> NON, désolé !</h1>
				<span><?= $this->getUrl() ?></span>
				<hr>
				<h2 class="font-bold text-red">L'accès à cette page vous est interdite !</h2><br>
				<h4 style="line-height: 25px;">
					Nous sommes désolé de ne pas pouvoir donner suite à votre requette car vous n'avez l'autorisation neccessaire pour acceder à cette page. Quelques conseils :
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