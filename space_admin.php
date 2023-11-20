<?php
$bdd = new PDO('mysql:host=localhost;dbname=administrations;charset=utf8',"root", '');

if(isset($_GET['type']) AND $_GET['type'] == 'membres'){
    
    if(isset($_GET['confirme']) AND !empty($_GET['confirme'])){
        $confirme = (int) $_GET['confirme'];

        $req = $bdd->prepare('UPDATE membres SET confirme = 1 WHERE id = ?');
        $req->execute(array($confirme));
    }

    if(isset($_GET['supprime']) AND !empty($_GET['supprime'])){
        $supprime = (int) $_GET['supprime'];

        $req = $bdd->prepare('DELETE FROM membres  WHERE id = ?');
        $req->execute(array($supprime));
    }   
} elseif(isset($_GET['type']) AND $_GET['type'] == 'commentaires') {
    if(isset($_GET['approuve']) AND !empty($_GET['approuve'])){
        $approuve = (int) $_GET['approuve'];

        $req = $bdd->prepare('UPDATE commentaires SET approuve = 1 WHERE id = ?');
        $req->execute(array($approuve));
    }

    if(isset($_GET['supprime']) AND !empty($_GET['supprime'])){
        $supprime = (int) $_GET['supprime'];

        $req = $bdd->prepare('DELETE FROM commentaires  WHERE id = ?');
        $req->execute(array($supprime));
    }   
} 

$membres = $bdd->query('SELECT * FROM membres');
$commentaires = $bdd->query('SELECT * FROM commentaires');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration</title>
</head>
<body>
    
    <ul>
        <?php while($m = $membres->fetch()){ ?>
            <li><?= $m['id'] ?> : <?= $m['pseudo'] ?><?php if($m['confirme'] == 0) 
            { ?> - <a href="space_admin.php?type=membres&confirme=<?= $m['id'] ?>">Confirmer</a><?php
            } ?> - <a href="space_admin.php?type=membres&supprime=<?= $m['id'] ?>">Supprimer</a></li>
        <?php } ?>
    </ul>

    <br/>    <br/>

    <ul>
        <?php while($c = $commentaires->fetch()){ ?>
            <li><?= $c['id'] ?> : <?= $c['pseudo'] ?> : <?= $c['contenu'] ?><?php if($c['approuve'] == 0) 
            { ?> - <a href="space_admin.php?type=commentaires&approuve=<?= $c['id'] ?>">Approuver</a><?php
            } ?> - <a href="space_admin.php?type=commentaires&supprime=<?= $c['id'] ?>">Supprimer</a></li>
        <?php } ?>
    </ul>
</body>
</html>