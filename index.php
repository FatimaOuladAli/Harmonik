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

        $sql = 'SELECT modeles.id, modeles.modele, modeles.prix, modeles.stock, modeles.date_creation, marques.marque, categories.categorie 
        FROM modeles
        INNER JOIN marques 
        ON modeles.marques_id = marques.id 
        INNER JOIN categories
        ON modeles.categories_id = categories.id';
        $q = $bdd->query($sql);
        $lignes = $q-> fetchAll(PDO::FETCH_ASSOC);
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="../images/harmonik.ico" type="image/x-icon">
    <title>Accueil</title>
</head>
<body>
    
    <?php require 'header.inc.php'; ?>
    <div class="sous_titre">
        Liste des instruments
    </div>

    <?php if(isset($_SESSION['message'])){
            echo '<div class= "message ' . $_SESSION['message']['class'] . '">' . $_SESSION['message']['text'] . '</div>';
            unset($_SESSION['message']);
        } ?>
    <div class="button">
        <button type="submit"><a href="ajouter_instru.php">Ajouter</a></button>
    </div>
    <table>
        <thead>
            <tr>
                <th>Modèle</th>
                <th>Marque</th>
                <th>Catégorie</th>
                <th>Prix (€)</th>
                <th>Date</th>
                <th>Stock</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        <?php foreach($lignes as $ligne) : ?>
            <tr>
                <td><?= $ligne['modele'] ?></td>
                <td><?= $ligne['marque'] ?></td>
                <td><?= $ligne['categorie'] ?></td>
                <td><?= $ligne['prix'] ?></td>
                <td><?= $ligne['date_creation'] ?></td>
                <td><?= $ligne['stock'] ?></td>
                <td>
                    <div>
                        <a href="modifier_instru.php?id=<?= $ligne['id'] ?>" onclick="return confirm('Voulez vous vraiment modifier ?')">
                            <img src="../images/modifier.png" alt="">
                        </a>
                        <a href="supprimer_instru.php?id=<?= $ligne['id'] ?>" onclick="return confirm('Voulez vous vraiment supprimer ?')">
                        <img src="../images/supprimer.png" alt="">
                        </a>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>