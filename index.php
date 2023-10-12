<?php 
require 'db_conn.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>To-Do List</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="main-section">
       <div class="add-section">

       <!-- Formulaire pour ajouter une nouvelle tâche -->
          <form action="app/add.php" method="POST" autocomplete="off">
             <?php if(isset($_GET['mess']) && $_GET['mess'] == 'error'){ ?>
                <input type="text" 
                     name="nom_tache" 
                     style="border-color: #ff6666"
                     placeholder="This field is required" />
              <button type="submit">Add &nbsp; <span>&#43;</span></button>

             <?php }else{ ?>
              <input type="text" 
                     name="nom_tache" 
                     placeholder="Nom de la tache" />
              <button type="submit">Ajouter &nbsp; <span>&#43;</span></button>
             <?php } ?>
          </form>
       </div>
       <?php 

       // Récupèrer la liste des tâches depuis la base de données
          $tasks = $conn->query("SELECT * FROM tasks ORDER BY id DESC");
       ?>
       <div class="show-todo-section">
            <?php if($tasks->rowCount() <= 0){ ?>
                <div class="todo-item">
                    <div class="empty">
                        <!-- Afficher un message si la liste est vide -->
                        <p>La liste est vide</p>
                    </div>
                </div>
            <?php } ?>

            <?php while($todo = $tasks->fetch(PDO::FETCH_ASSOC)) { ?>

                <!-- Afficher chaque tâche de la base de données -->
                <div class="todo-item">
                    <span id="<?php echo $todo['id']; ?>"
                          class="remove-to-do">x</span>
                    <?php if($todo['statut']){ ?> 

                        <!-- Afficher la tâche avec une coche si elle est terminée -->
                        <input type="checkbox"
                               class="check-box"
                               data-todo-id ="<?php echo $todo['id']; ?>"
                               checked />
                        <h2 class="checked"><?php echo $todo['nom_tache'] ?></h2>
                    <?php }else { ?>

                        <!-- Afficher la tâche sans coche si elle n'est pas terminée -->
                        <input type="checkbox"
                               data-todo-id ="<?php echo $todo['id']; ?>"
                               class="check-box" />
                        <h2><?php echo $todo['nom_tache'] ?></h2>
                    <?php } ?>
                    <br>
                    <small>crée le: <?php echo $todo['date_creation'] ?></small> 
                </div>
            <?php } ?>
       </div>
    </div>

    <script src="js/jquery-3.2.1.min.js"></script>

    <!-- Script JavaScript pour gérer les interactions utilisateur -->
    <script>
        $(document).ready(function(){

            // Gestion de la suppression d'une tâche
            $('.remove-to-do').click(function(){
                const id = $(this).attr('id');
                
                $.post("app/remove.php", 
                      {
                          id: id
                      },
                      (data)  => {
                         if(data){
                             $(this).parent().hide(600);
                         }
                      }
                );
            });

            // Gestion de la coche pour marquer une tâche comme terminée
            $(".check-box").click(function(e){
                const id = $(this).attr('data-todo-id');
                
                $.post('app/check.php', 
                      {
                          id: id
                      },
                      (data) => {
                          if(data != 'error'){
                              const h2 = $(this).next();
                              if(data === '1'){
                                  h2.removeClass('checked');
                              }else {
                                  h2.addClass('checked');
                              }
                          }
                      }
                );
            });
        });
    </script>
</body>
</html>