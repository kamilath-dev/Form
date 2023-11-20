<?php
session_start();

$bdd = new PDO('mysql:host=localhost;dbname=espace_membre;charset=utf8',"root", '');

if(isset($_SESSION['id']) AND !empty($_SESSION['id'])){
    if(isset($_POST['envoie_message'])){
        if(isset($_POST['destinataire'],$_POST['message']) AND !empty($_POST['destinataire']) AND !empty($_POST['message'])){
            $destinataire = htmlspecialchars($_POST['destinataire']);
            $message = htmlspecialchars($_POST['message']);
    
            $id_destinataire = $bdd->prepare('SELECT id FROM membres WHERE pseudo = ?');
            $id_destinataire->execute(array($destinataire));
            $dest_exist = $id_destinataire->rowCount();

            if($dest_exist == 1){
                $id_destinataire = $id_destinataire->fetch();
                $id_destinataire = $id_destinataire['id'];
        
                $ins = $bdd->prepare('INSERT INTO messages(id_expediteur,id_destinataire,message) VALUES (?, ?, ?)');
                $ins->execute(array($_SESSION['id'],$id_destinataire,$message));
        
                $error = "Votre message a été envoyer !";      
            }else{
                $erroe = "Cette utilisateur n'existe pas !";
            }
    
            // var_dump($id_destinataire); permet de recuperer les infos d'une variable
        } else{
            $error = "Veuillez remplie tous les champs ! ";
        }
    }   
    
    $destinataires = $bdd->query('SELECT pseudo FROM membres ORDER BY pseudo');
    
    ?>
    
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Envoie De Message</title>
    </head>
    <body>
        <form method="POST">
            <label>Destinataire:</label>
            <select name="destinataire">
                <?php while($d = $destinataires->fetch()) { ?>
                    <option><?= $d['pseudo']?></option> 
                <?php } ?>
            </select>
            <br/><br/>
            <textarea placeholder="Votre message" name="message"></textarea>
            <br/><br/>
            <input type="submit" value="Envoyer" name="envoie_message" />
            <br/><br/>
            <?php if(isset($error)) { echo '<span style="color:red">'. $error.'</span>'; } ?>
        </form>
        <br />
        <a href="reception.php">Boite de réception</a>
    </body>
    </html> 
<?php
}
?>