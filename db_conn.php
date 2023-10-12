<?php 

// Définition des paramètres de connexion à la base de données
$sName = "localhost";
$uName = "root";
$pass = "";
$db_name = "to_do_list";

try {

  // Établir une connexion à la base de données en utilisant PDO
    $conn = new PDO("mysql:host=$sName;dbname=$db_name", 
                    $uName, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
  echo "Connection failed : ". $e->getMessage();
}