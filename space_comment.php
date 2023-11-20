<meta charset="UTF-8">
<?php
$bdd = new PDO('mysql:host=localhost;dbname=espace_commentaire;charset=utf8',"root", '');

if(isset($_GET['id']) AND !empty($_GET['id'])){

    $getid = htmlspecialchars($_GET['id']);

    $article = $bdd->prepare('SELECT * FROM articles WHERE id = ?');
    $article->execute(array($getid));
    $article = $article->fetch();

?>

<h2>Article:</h2>
<p><?= $article['contenu'] ?></p>

<?php
}
?>