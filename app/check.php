<?php

// Vérifier si la variable POST 'id' est définie
if(isset($_POST['id'])){
    require '../db_conn.php';

    // Récupèrer l'ID de la tâche à modifier depuis la variable POST
    $id = $_POST['id'];

    if(empty($id)){
       echo 'error';
    }else {

        // Une requête SQL pour récupérer l'ID et le statut de la tâche
        $tasks = $conn->prepare("SELECT id, statut FROM tasks WHERE id=?");
        $tasks->execute([$id]);

        // Récupèrer les données de la tâche
        $todo = $tasks->fetch();
        $uId = $todo['id'];
        $statut = $todo['statut'];

        // Inverser le statut (1 pour terminé, 0 pour non terminé)
        $ustatut = $statut ? 0 : 1;

        // Exécuter une requête SQL pour mettre à jour le statut de la tâche
        $res = $conn->query("UPDATE tasks SET statut=$ustatut WHERE id=$uId");

        if($res){
            echo $statut;
        }else {
            echo "error";
        }
        $conn = null;
        exit();
    }
}else {
    header("Location: ../index.php?mess=error");
}