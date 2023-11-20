<?php

session_start();

$bdd = new PDO('mysql:host=localhost;dbname=espace_membre;charset=utf8',"root", '');

if(isset($_SESSION['id']) AND !empty($_SESSION['id'])){

$msg = $bdd->prepare('SELECT * FROM messages WHERE id_destinataire = ?');
$msg->execute(array($_SESSION['id']));
$msg_nbr = $msg->rowCount(); // compte le nbre de ranger

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boite de réception</title>
</head>
<body>
    <a href="envoie.php">Nouveau message</a><br /><br /><br />
    <h3>Votre boite de réception:<h3>
    <?php
    if($msg_nbr == 0) { echo "Vous n'avez aucun message..."; }
    while($m = $msg->fetch()) { 
        $p_exp = $bdd->prepare('SELECT pseudo FROM membres WHERE id = ?');
        $p_exp->execute(array($m['id_expediteur']));
        $p_exp = $p_exp->fetch();
        $p_exp = $p_exp['pseudo'];
    ?>
    <b><?= $p_exp ?></b> vous a envoyé: <br />
    <?= nl2br($m['message']) ?><br />
    ----------------------------------<br/>
    <?php } ?>
</body>
</html>
<?php } ?>