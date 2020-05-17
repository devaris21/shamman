<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>

    <table align="center" border="0" cellpadding="0" cellspacing="0" style="border: 2px solid orangered; border-collapse: collapse; width: 100%; max-width: 600px;" class="content">
<!--         <tr>
            <td style="padding: 15px 10px 15px 10px;">
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                        <td align="center" style="color: #fff; font-family: Arial, sans-serif; font-size: 12px;">
                            Email not displaying correctly?  <a href="#" style="color: #0073AA;">View it in your browser</a>
                        </td>
                    </tr>
                </table>
            </td>
        </tr> -->
        <tr>
            <td align="center" bgcolor="green" style="padding: 20px 20px 20px 20px; color: #ffffff; font-family: Arial, sans-serif; font-size: 36px; font-weight: bold;">
                <img src="http://www.dleg.net/logos/auto.png" alt="le logo" width="250" height="110" style="display:block;">
            </td>
        </tr>
        <tr>
            <td align="justify" bgcolor="#ffffff" style="padding: 20px 20px 20px 20px; color: #555555; font-family: Arial, sans-serif; font-size: 15px; line-height: 40px; border-bottom: 1px solid #f6f6f6;">
                <h2 align="center"><?= $objet ?></h2>
                <b><?= $message ?></b>
            </td>
        </tr>
        <tr>
            <td><img src="<?= $image ?>"></td>
        </tr>
        <tr>
            <td align="left" bgcolor="#f9f9f9" style="padding: 10px 10px 0 10px; color: #555555; font-family: Arial, sans-serif; font-size: 15px; line-height: 30px;">
                <b>Type de sinistre:</b> <?= $this->typesinistre->name ?>;
            </td>
        </tr>
        <tr>
            <td align="left" bgcolor="#f9f9f9" style="padding: 10px 10px 0 10px; color: #555555; font-family: Arial, sans-serif; font-size: 15px; line-height: 30px;">
                <b>Objet:</b> <?= $this->name ?>;
            </td>
        </tr>
        <tr>
            <td align="left" bgcolor="#f9f9f9" style="padding: 10px 10px 0 10px; color: #555555; font-family: Arial, sans-serif; font-size: 15px; line-height: 30px;">
                <b>Sinistre survenue le :</b> Du <?= datelong($this->date_etablissement) ?>;
            </td>
        </tr>
        <tr>
            <td align="left" bgcolor="#f9f9f9" style="padding: 10px 10px 0 10px; color: #555555; font-family: Arial, sans-serif; font-size: 15px; line-height: 30px;">
                <b>Lieu :</b> <?= $this->lieudrame ?> 
            </td>
        </tr>
        <tr>
            <td align="left" bgcolor="#f9f9f9" style="padding: 10px 10px 0 10px; color: #555555; font-family: Arial, sans-serif; font-size: 15px; line-height: 30px;">
                    <b>Détails / Explication :</b> <?= $this->comment ?>
                    <br><br>
            </td>
        </tr>


       <tr>
        <td align="center" bgcolor="#dddddd" style="padding: 15px 10px 15px 10px; color: #555555; font-family: Arial, sans-serif; font-size: 12px; line-height: 18px;">
            <b>Gestion du Parc Automobile.</b><br>Abidjan Côte d'Ivoire. &bull; 01 79 30 00 Tel: +225 56 49 17 13
        </td>
    </tr>
<!--     <tr>
        <td style="padding: 15px 10px 15px 10px;">
            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <td align="center" width="100%" style="color: #fff; font-family: Arial, sans-serif; font-size: 12px;">
                        2017-18 &copy; <a href="http://html.codedthemes.com/mash-able/" style="color: #0073AA;">Mash Able</a>
                    </td>
                </tr>
            </table>
        </td>
    </tr> -->
</table>

</body>
</html>