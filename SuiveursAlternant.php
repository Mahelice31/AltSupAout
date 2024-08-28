<!doctype html>
    <html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="class1.css?<?php echo time(); ?>" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
        <title>SuiveursAlternant</title>
    </head>
    <body class="bodyAdmin">
        <?php

            session_start();
            if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== 4) {
                header('Location: home.php');
            }

            //Requête pour l'id
            $db=new PDO('mysql:host=localhost;dbname=alt_sup_project;charset=utf8mb4', 'root', '');
            $email=$_SESSION['email'];
            $queryEmail="SELECT id_utilisateur FROM utilisateurs WHERE email= :email";
            $stmt = $db->prepare($queryEmail);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $id_utilisateur = $row['id_utilisateur'];
        ?>
        <nav class="navbar navbar-default navbar-fixed-top">
            <div class="navbar-header">
                <a name="home" class="navLogo" 

                <?php
                    if (isset($_POST['home'])) {
                        session_destroy();
                        header('Location: home.php');
                    }
                ?>
                href="home.php" style=""><img src="logo.png" class="logo"></img></a>
                <a class="navA" href="SuiveursAlternant.php">Menu</a>
                <!-- <a class="navA" href="etudiants.php">Liste des étudiants</a> -->
                <a class="navA" href="suivi_tuteur.php">Faire un suivi</a>
                <a class="navA" href="listeSuivis.php">liste des suivis</a>

            </div> 
            <div class="divTime">
                <?php

                    if(isset($_SESSION['email'])) {
                        $email = $_SESSION['email'];
                        $db = mysqli_connect('localhost', 'root', '', 'alt_sup_project');
                        $sqlSelect = "SELECT prenom FROM utilisateurs WHERE email = '$email'";
                        $result = mysqli_query($db, $sqlSelect);

                        if(mysqli_num_rows($result) > 0) {
                            $row = mysqli_fetch_assoc($result);
                            $username = $row['prenom'];
                            echo "<a class='name'>Bienvenue $username</a>";
                        } 
                            
                        else {
                            echo "Utilisateur inconnu";
                        }

                        mysqli_close($db);
                        } 
                        
                        else {
                        header("Location: home.php");
                        exit();
                    }

                ?>

              
                <?php
                    echo "<a class='time' id='clock'></a>"; 
                ?>
            </div>

        </nav>
        <div class="containerAdmin">
            <div class="divAdminMenu bg-light text-center">
                <h1 class="adminTitle">Menu</h1>
                <div class="row">
                    <div class="col">
                        <div class="containerAdmin">
                            <div class="button" style="margin-top: 3%; width: 80%;">
                                <a href="suivi_tuteur.php"><input type="submit" name="submit" value="Faire un suivi">
                            </div>
                        </div>
                        <div class="containerAdmin">
                            <div class="button" style="margin-top: 3%; width: 80%;">
                                <a href="listeSuivis.php"><input type="submit" name="submit" value="Liste des suivis">
                            </div>
                </div>
            </div>
        </div>
        
        <script src="time.js"></script>
    </body>