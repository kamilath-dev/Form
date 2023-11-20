<?php
session_start();

$bdd = new PDO('mysql:host=localhost;dbname=espace_membre;charset=utf8',"root", '');

if(isset($_GET['id']) AND $_GET['id'] > 0)
{
    $getid = intval($_GET['id']);
    $requser = $bdd->prepare('SELECT * FROM membres WHERE id = ? ');
    $requser->execute(array($getid));
    $userinfo = $requser->fetch();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace_Membre</title>
</head>
<body>
    <div align="center">
        <h2>Profil de <?php echo $userinfo['pseudo']; ?></h2>
        <br/><br/>
        Pseudo = <?php echo $userinfo['pseudo']; ?>
        <br/>
        Mail = <?php echo $userinfo['mail']; ?>
        <br/>
        <?php
            if(isset($_SESSION['id']) AND  $userinfo['id'] == $_SESSION['id'])
            {
            ?>
            <a href="editionprofil.php">Editer mon profil</a>
            <a href="reception.php">Mes messages</a>
            <a href="deconnection.php">Se deconnecter</a>
            <?php
            }
        ?>
    </div>
</body>
</html>
<?php
}
?>