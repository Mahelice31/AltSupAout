<!doctype html>
    <html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="class1.css?<?php echo time(); ?>" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
        <title>Admin</title>
    </head>
    <body class="bodyAdmin">
        <?php

            session_start();
            if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== 1) {
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
                <a class="navA" href="DirecteurCre.php">Menu</a>
                <a class="navA" href="adminAddUtilisateur.php">Ajouter utilisateurs</a>
                <!-- <a class="navA" href="adminUtilisateur.php">Gérer utilisateurs</a>
                <a class="navA" href="adminRole.php">Roles</a> -->
                <a class="navA" href="adminAddStudent.php">Ajouter un étudiant</a>
                <a class="navA" href="etudiants.php">Liste des étudiants</a>
                <!-- <a class="navA" href="suivi-tuteur.php"> Faire un suivi</a> -->
                <a class="navA" href="listeSuivis.php">Liste des suivis</a>
            </div>
            <div class="divTime">
                <?php

                    if(isset($_SESSION['email'])) {
                        $email = $_SESSION['email'];
                        $db = mysqli_connect('localhost', 'root', '', 'alt_sup_project');
                        $sqlSelect = "SELECT prenom FROM utilisateurs WHERE email = '$email'";
                        $result = mysqli_query($db, $sqlSelect);
                       // Exécution de la requête
                        $query = "SELECT * FROM alertes";
                        $alerte = $db->query($query);

                        // Vérifiez si la requête a retourné des résultats
                        if ($alerte) {
                            // Obtenez le nombre de lignes
                            $numRows = $alerte->num_rows;

                            // Libérez les ressources
                            $alerte->free();
                        }

                        if(mysqli_num_rows($result) > 0) {
                            $row = mysqli_fetch_assoc($result);
                            $username = $row['prenom'];
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
            <a class="alerte alertes alertes span" href="#">
                <img src="cloche.png" class=" cloche alertes:hower alertes span">
                <span><?php echo $numRows; ?></span>
                </a>
            </div>
        </nav>
        <div class="containerAdmin text-center">
            <div class="divAdminMenu bg-light">
                <div class="row">
                    <div class="col-md-4">
                    <div class="divTitle">
                        <h1>Ajouter un rôle</h1>
                    </div>
                    <form class="" method="post">
                        <div class="texte">
                            <input type="text" name="role" required>  
                            <span></span>
                            <label>nom du rôle</label>
                        </div>
                        <div class="button">
                        <input type="submit" name="submit" value="Ajouter un rôle">
                        </div> 
                    </form>
                    <?php
                        if (isset($_POST['submit'])) {
                            $db = new PDO('mysql:host=localhost;dbname=alt_sup_project;charset=utf8mb4', 'root', '');
                            $role = $_POST['role'];
                            $insertRole = "INSERT INTO roles (nom_role) values (:nom_role)";
                            $stmt = $db->prepare($insertRole);
                            $stmt->bindParam(':nom_role', $role);
                            $stmt->execute();
                            $_POST=array();
                            header ("Location: adminRole.php");
                        }
                    ?>
                    </div>
                    <div class="col">
                        <div class="divTitle">
                            <h1>Liste des rôles</h1>
                        </div>
                        <?php
                            $db = new PDO('mysql:host=localhost;dbname=alt_sup_project;charset=utf8mb4', 'root', '');
                            $select = "SELECT roles.*, COUNT(utilisateurs.id_role) AS total_utilisateur, utilisateurs.*
                            FROM roles
                            LEFT JOIN utilisateurs ON utilisateurs.id_role = roles.id_role
                            GROUP BY roles.id_role";
                            $stmt = $db->prepare($select);
                            $stmt->execute();
                            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        ?>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Nom du rôle</th>
                                    <th>Nombre d'utilisateurs</th>
                                    <th>Supprimer</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                if (isset($_POST['supprimer'])) {
                                    $idSupprimer = $_POST['id_supprimer'];
                                    $db->exec("DELETE FROM roles WHERE id_role = $idSupprimer");
                                    header ("Location: adminRole.php");
                                }

                                foreach ($data as $row) {
                                    echo "<tr>
                                    <td>".$row['nom_role']."</td>
                                    <td>".$row['total_utilisateur']."</td>
                                    <td><form method='post'>
                                        <input type='hidden' name='id_supprimer' value='".$row['id_role']."'>
                                        <button type='submit' name='supprimer' class='btn btn-danger'>Supprimer</button>
                                        </form></td>
                                    </tr>";
                                }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <script src="time.js"></script>
    </body>