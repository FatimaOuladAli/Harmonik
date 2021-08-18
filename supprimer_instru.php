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

    if(isset($_GET['id'])){
	
        $sql = 'DELETE FROM modeles WHERE modeles.id=:id';
        $q = $bdd->prepare($sql);
         $lignes = $q->execute(array(
             'id' => $_GET['id'] ,
         ));

         if($lignes){
            $_SESSION['message'] = ['class' => 'success', 'text' => 'Cet instrument est bien supprimer'];
             header('Location: index.php');
         }
    }
