<?php
$bdd = new PDO('mysql:host=localhost;dbname=tuto;charset=utf8',
 "root", "");

if (isset($_POST['pseudo']) AND isset($_POST['message']) AND
 !empty($_POST['pseudo']) AND !empty($_POST['message']))
{
    $pseudo = htmlspecialchars($_POST['pseudo']);
    $message = htmlspecialchars($_POST['message']);

    $requete = $bdd->prepare('INSERT INTO chat(pseudo, message)
     VALUES(?, ?)');
    $requete->execute(array($pseudo, $message));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TUTO PHP</title>
</head>
<body>
    <form method="post" action="">
        <input type="text" name="pseudo" placeholder="PSEUDO"value="
        <?php if (isset($pseudo)) { echo $pseudo;} ?>"/><br/><br/>
        <textarea type="text" name="message" placeholder="MESSAGE">
        </textarea><br/><br/> 
        <input type="submit" value="Envoyer"/>
    </form>

    <?php
    $allmsg = $bdd->query('SELECT * FROM chat ORDER BY id DESC');
    while($msg = $allmsg->fetch())
    {
    ?> 
    <b><?php echo $msg['pseudo']; ?></b><?php echo $msg['message']; ?><br/>
    <?php
    }
    ?>
    
</body>
</html>