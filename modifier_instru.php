<?php

session_start();
try {
    /* Etape 1: on instancie la classe PDO dans un objet $bdd (copier/coller en modifiant la ligne $bdd) */
        $options = [
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
            PDO::ATTR_ERRMODE =>  PDO::ERRMODE_EXCEPTION
        ];
        $bdd = new PDO('mysql:host=localhost;dbname=ecf', 'root', '', $options);
    } catch (Exception $e) {
    
        die('Erreur : ' . $e->getMessage());
    }

    if(isset($_POST['modele'], 
    $_POST['prix'],
    $_POST['stock'],
    $_POST['marque'],
    $_POST['categorie'])){

        $sql = 'UPDATE modeles 
            SET modeles.modele = :modele, modeles.prix = :prix, modeles.stock = :stock, modeles.date_creation = NOW(), modeles.marques_id = :marque_id, modeles.categories_id = :categorie_id
            WHERE modeles.id = :id';
            $q = $bdd->prepare($sql);
            $ligne = $q->execute(array(
                'modele' => htmlspecialchars($_POST['modele']),
                'prix' => htmlspecialchars( $_POST['prix']),
                'stock' => htmlspecialchars($_POST['stock']),
                'marque_id' => htmlspecialchars($_POST['marque']),
                'categorie_id' => htmlspecialchars($_POST['categorie']),
                'id' => $_GET['id'],
        ));
        if($ligne){
            $_SESSION['message'] = ['class' => 'success', 'text' => 'Vous avez modifier cet instrument'];
            header('Location: index.php');
        }
        
    }


    $sql = 'SELECT modeles.id, modeles.modele, modeles.prix, modeles.stock, modeles.date_creation, marques.marque, categories.categorie 
        FROM modeles 
        INNER JOIN marques 
        ON modeles.marques_id = marques.id 
        INNER JOIN categories 
        ON modeles.categories_id = categories.id
        WHERE modeles.id = :id';
        $q = $bdd->prepare($sql);
        $q -> execute(array('id' => $_GET['id']));
        $data = $q-> fetch(PDO::FETCH_ASSOC);

    $sql = 'SELECT id, marque FROM marques';
    $q = $bdd -> query($sql);
    $marques = $q -> fetchAll(PDO::FETCH_ASSOC);

    $sql = 'SELECT id, categorie FROM categories';
    $q = $bdd -> query($sql);
    $categories = $q -> fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="../images/harmonik.ico" type="image/x-icon">
    <title>Modifier un instrument</title>
</head>
<body>
<?php require 'header.inc.php'; ?>
    <div class="sous_titre">
        Modifier un instrument
    </div>
    
    <form action="" method="post">
        <label for="marque">Marque</label> <br>
        <select id="marque" name="marque">
        <?php foreach($marques as $marque) : ?>
            <option value="<?=$marque['id'] ?>"><?= $marque['marque'] ?></option>
        <?php endforeach ?>
        </select> <br>
        <label for="modele"> Modèle</label> <br>
        <input type="text" id="modele" name="modele" value="<?= $data['modele'] ?> "><br>
        <label for="categorie">Catégorie</label> <br>
        <select name="categorie" id="categorie">
        <?php foreach($categories as $categorie) : ?>
            <option value="<?=$categorie['id'] ?>"><?= $categorie['categorie'] ?></option>
        <?php endforeach ?>
        </select> <br>
        <label for="prix">Prix (€)</label> <br>
        <input type="text" id="prix" name="prix" value="<?= $data['prix'] ?> "><br>
        <label for="quantite">Quantité</label> <br>
        <input type="text" id="stock" name="stock" value="<?= $data['stock'] ?> "> <br>
        <label for="date">Date:</label> <br>
        <input type="date" id="start"
                value="2021-07-22"
                min="2018-01-01" max="2021-12-31"><br>
        </div>
        <div class="button_add">
            <button type="submit"><a href="index.php">Accueil</a></button>
            <button type="submit">Modifier</button>
        </div>
        
    </form>
    
</body>
</html>