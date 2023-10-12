<?php

// Vérifier si la variable POST 'nom_tache' est définie
if(isset($_POST['nom_tache'])){
    require '../db_conn.php';

    // Récupèrer la valeur 'nom_tache' à partir de la variable POST
    $nom_tache = $_POST['nom_tache'];

    // Vérifier si le champ 'nom_tache' est vide
    if(empty($nom_tache)){
        header("Location: ../index.php?mess=error");
    }else {

        // Préparer une requête SQL pour insérer 'nom_tache' dans la table 'tasks'
        $stmt = $conn->prepare("INSERT INTO tasks(nom_tache) VALUE(?)");
        // Exécuter la requête SQL
        $res = $stmt->execute([$nom_tache]);

        if($res){
            header("Location: ../index.php?mess=success"); 
        }else {
            header("Location: ../index.php");
        }
        $conn = null;
        exit();
    }
}else {
    header("Location: ../index.php?mess=error");
}