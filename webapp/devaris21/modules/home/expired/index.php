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
				<h1 class="text-orange" style="font-size: 50px;"> Vous êtes à expiration !</h1>
				<span><?= $this->getUrl() ?></span>
				<hr>
				<h2 class="font-bold text-red">Il est temps de renouveller votre abonnement !</h2><br>
				<h4 style="line-height: 25px;">
					Nous sommes désolé de ne pas pouvoir donner suite à votre requette car votre abonnement à ce logiciel a expiré. Donc vous n'y avez plus accès. Quelques conseils :
				</h4><br>
				<ul>
					<li><a href="<?= $this->url("devaris21", "home", "renouveller") ?>">Renouveller l'abonnement</a></li>
					<li>Contactez votre administrateur pour vous reabonner !</li>
				</ul>
			</div>
		</div>
		<hr>
	</div>

	<?php //include($this->rootPath("webapp/gestion/elements/templates/script.php")); ?>

</body>

</html>