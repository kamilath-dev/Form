<?php
$bdd = new PDO('mysql:host=localhost;dbname=espace_membre;charset=utf8',"root", '');

if(isset($_POST['forminscription']))
{   
    $pseudo = htmlspecialchars($_POST['pseudo']);
    $mail = htmlspecialchars($_POST['mail']);
    $mail2 = htmlspecialchars($_POST['mail2']);
    $mdp = sha1($_POST['mdp']);
    $mdp2 = sha1($_POST['mdp2']);

    if (!empty($_POST['pseudo']) AND !empty($_POST['mail']) AND !empty($_POST['mail2']) AND !empty($_POST['mdp']) AND !empty($_POST['mdp2']) )
    {
        $pseudolength = strlen($pseudo);
        if($pseudolength <= 255)
        {
            if($mail == $mail2)
            {
                if (filter_var($mail, FILTER_VALIDATE_EMAIL))
                {   
                    $reqmail = $bdd->prepare("SELECT * FROM membres WHERE mail=?");
                    $reqmail->execute(array($mail));
                    $mailexist = $reqmail->rowCount();
                    if ($mailexist == 0)
                    {
                        if($mdp == $mdp2)
                        {
                            $insertmbr = $bdd->prepare("INSERT INTO membres(pseudo, mail, motpasse) VALUES(?, ?, ?)");
                            $insertmbr->execute(array($pseudo, $mail, $mdp));
                            # qui permet de rediriger user vers une autre page $_SESSION['comptecree'] = "Votre compte a bien été créé !"; 
                            # header('Location: membre.php');
                            $erreur = "Votre compte a bien été créé ! <a href=\"connection.php\">Me connecter</a>";
                        }
                        else
                        {
                            $erreur = "Vos mots de passes ne correspondes pas !";
                        }
                    }
                    else
                    {
                        $erreur = "Adresse mail déjà utilisée !";
                    }
                }
                else
                {
                    $erreur = "Votre adresse mail n'est pas valide !";
                }      
            }
            else
            {
                $erreur = "Vos adresses mails ne correspondes pas !";
            }
        }
        else
        {
            $erreur = " Votre pseudo ne doit pas dépasser 255 caractères";
        }
    }
    else
    {
        $erreur = "Tous les champs doivent etre remplie !";
    }
}
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
        <h2>Inscription</h2>
        <br/><br/>
        <form method="POST" action="">
            <table>
                <tr>
                    <td align="right">
                        <label for="pseudo"> Pseudo:</label>
                    </td>
                    <td>
                        <input type="text" placeholder="Votre pseudo" name="pseudo" value ="<?php if (isset($pseudo)) { echo $pseudo; } ?>"  />
                    </td>
                </tr>
                <tr>
                    <td align="right">
                        <label for="mail"> Mail:</label>
                    </td>
                    <td>
                        <input type="email" placeholder="Votre mail" name="mail"/>
                    </td>
                </tr>
                <tr>
                    <td align="right">
                        <label for="mail2"> Confirmation de votre Mail:</label>
                    </td>
                    <td>
                        <input type="email" placeholder=" Confirmez votre mail" id="mail2" name="mail2" />
                    </td>
                </tr>
                <tr>
                    <td align="right">
                        <label for="mdp"> Mot de passe:</label>
                    </td>
                    <td>
                        <input type="password" placeholder=" Votre mot de passe"  id="mdp" name="mdp" />
                    </td>
                </tr>
                <tr>
                    <td align="right">
                        <label for="mdp2">Confirmation du  Mot de passe:</label>
                    </td>
                    <td>
                        <input type="password" placeholder="Confirmez  votre password"  id="mdp2" name="mdp2"/>
                    </td>
                </tr>
            </table>
            </br>
            <input type="submit" name="forminscription" value="je m'inscris" />
        </form>
        <?php
            if (isset($erreur))
            {
                echo '<font color="red">' . $erreur. '</font>';
            }
        ?>
    </div>
</body>
</html>