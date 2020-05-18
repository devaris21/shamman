<!DOCTYPE html>
<html>

<?php include($this->rootPath("webapp/gestion/elements/templates/head.php")); ?>


<body class="gray-bg">
	<div class="container" style="padding-top: 1%;">
		<div class="ibox ">
			<div class="ibox-title">
				<h5 class="text-left">DEVARI.COM <small>http://www.devari.com/webservice/</small></h5>
				<div class="ibox-tools">

				</div>
			</div>
			<div class="ibox-content text-center css-animation-box">
				<h2 style="font-size: 30px;" class="text-green text-uppercase">Nouvel abonnement</h2>

				<div class="hr-line-dashed"></div>

				<div class="row">
					<div class="col-sm-5 border-right">
						<h4 class="m-b-lg text-center text-uppercase">Quelques points importants</h4>
						<div id="animation_box text-left" class="animated">
							<dl class="text-left">
								<dt>Le code de validation</dt>
								<dd>Pour renouveller votre abonnement, il vous faut obligatoirement un code de validation composé de 5 blocs de caractères.<br> Pour vous en procurer, veuillez <a href="">nous contacter</a> !</dd><br>

								<dt>Internet est requis</dt>
								<dd>La validation du code requiert une connexion à internet. veuillez vous assurer d'en avoir avant de commencer.</dd><br>

								<dt>4 tentavives</dt>
								<dd>Vous n'aurez droit qu'à un maximum de 4 tentatives pour valider votre ceode. Si vous échouer 5 fois de suite, l'application se vérouillera automatiquement. Vous devriez alors <a href="">nous contacter</a> !</dd><br>

								<dt>Besoin d'aide ?</dt>
								<dd>Si vous savez pas comment vous y prendre ou si vous avez besoin d'une aide ou d'une assistance particulière, veuillez <a href="">nous contacter</a> !</dd>
							</dl>
						</div>
					</div>

					<div class="col-lg-7 animation-efect-links text-center">
						<br><br>
						<div>
							<span>Fin d'abonnement le</span>
							<h2 class="text-uppercase" style="font-size: 32px"><?= datecourt($mycompte->expired) ?></h2>
							<h3 class="text-red">L'application a expiré</h3>
						</div><br><br>
						<h4 class="m-b-lg text-uppercase">
							Entrer les 5 blocs de caractères qui composent <br>le code de validation.
						</h4>
						<form id="formAbonnement" method="post">
							<div class="row">
								<div class="col-sm">
									<input type="text" name="bloc1" maxlength="5" uppercase autofocus="on" class="text-center gras form-control input-sm" name="">
								</div>
								<div class="col-sm">
									<input type="text" name="bloc2" maxlength="5" uppercase class="text-center gras form-control input-sm" name="">
								</div>
								<div class="col-sm">
									<input type="text" name="bloc3" maxlength="5" uppercase class="text-center gras form-control input-sm" name="">
								</div>
								<div class="col-sm">
									<input type="text" name="bloc4" maxlength="5" uppercase class="text-center gras form-control input-sm" name="">
								</div>
								<div class="col-sm">
									<input type="text" name="bloc5" maxlength="5" uppercase class="text-center gras form-control input-sm" name="">
								</div>
							</div><br><hr>
							<div>
								<button class="btn btn-primary dim"><i class="fa fa-check"></i> Valider le code !</button>
							</div>
						</form>
					</div>
				</div>

			</div>
		</div>
	</div>

	<?php include($this->rootPath("webapp/gestion/elements/templates/script.php")); ?>

</body>

</html>