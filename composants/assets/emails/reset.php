<!DOCTYPE html>
<html>
<head> 
    <meta name="swift-page-name" id="swift-page-name" content="home">
    <meta name="swift-page-section" id="swift-section-name" content="home">
    <meta name="msapplication-tileimage" content="//abs.twimg.com/favicons/win8-tile-144.png">
    <meta name="msapplication-tilecolor" content="#00aced">
</head>
<body > 
    <div style="max-width: 680px ; margin: 3% auto ;">
        <div style=" padding: 4%; background-color: #fff; border: 0.5px solid #ddd; border-bottom: 6px solid #ddd;">

            <div>
                <img style="height: 50px; float: right;" src="http://dummyimage.com/800x600/4d494d/686a82.gif&text=placeholder+image" alt="placeholder+image">
                <h1 style="font-size: 50px; color: grey; margin: 0; letter-spacing: 5px; font-weight: bold">AMB</h1>
                <small>Plateforme de gestion de parc Auto-Moto-Bateau</small>
            </div>
            <br><br>

            <h2 style="color: #23B2DBFF; text-align: center;">Reinitialisation de votre mot de passe</h2>

            <span><b>Cher <?= $this->name() ?>,</b> </span>
            <p>Vos paramètres de connexion ont bien été reinitialisé. Nous vous invitons cette fois-ci à bien les conserver dans un endroit sûr !</p><br>

            <p>Nous tenons à vous rappelez également que les informations de connexion communiquées ci-dessous vous sont individuelles et vous incomberont de tout acte ou action ménée sur ladite plateforme à partir d'une session ouverte par celles-ci!</p><br>

            <table>
                <tbody >
                    <tr>
                        <td class="gras">Identifiant : </td>
                        <td><?= $this->login ?></td>
                    </tr>
                    <tr>
                        <td class="gras"> Mot de passe :</td>
                        <td><?= $pass ?></td>
                    </tr>
                </tbody>
            </table>
            <br>
            <div>
                <a class="bouton" href="<?= Native\SHAMMAN::getConfig("metadata","website")  ?>" target="_blank">Aller sur la plateforme</a>
            </div><br>

            <p>Vous serez emmener à changer ces informations lors de votre premiere connexion !.</p><br><br><br>

            <div style="text-align: right;">
                <h4 style="margin: 5px auto" >Cordialement,</h4>
                <small style="text-align: right; color: grey;">AMB | Plateforme de gestion de parc Auto-Moto-Bateau</small>
            </div>
        </div>
        <br>
        
        <?php include(__DIR__."/templates/footer.php"); ?>

    </div>
</body>
</html>

<?php include(__DIR__."/templates/style.css"); ?>

