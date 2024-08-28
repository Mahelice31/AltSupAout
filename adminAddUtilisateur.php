
<!doctype html>
    <html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="class1.css?<?php echo time(); ?>" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
        <title>Admin - Utilisateurs</title>
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
                <span>3</span>
                </a>
            </div>
        </nav>
            
        <div class="containerAdmin text-center">
            <div class="divAdminMenu bg-light">

            
                <div class="row">
                    <div class="col-md-4">
                        <div class="divTitle">
                            <h1>Ajouter un utilisateur</h1>
                        </div>
                        <form class="" method="post">
                            <div class="texte">
                                <input type="text" name="nom" required>  
                                <span></span>
                                <label>Nom</label>
                            </div>
                            <div class="texte">
                                <input type="text" name="prenom" required>
                                <span></span>
                                <label>Prénom</label>
                            </div>
                            <div class="texte">
                                <input type="email" name="email" required>
                                <span></span>
                                <label>Adresse mail</label>
                            </div>
                            <div class="texte">
                                <input type="password" name="mdp" required>
                                <span></span>
                                <label>Mot de passe</label>
                            </div>
                            <div class="texte">
                                <input type="password" name="confirm" required>
                                <span></span>
                                <label>Confirmation du mot de passe</label>
                            </div>

                            <div class="register-link">
                            <div class="containerAdmin">
                                <select name="role">
                                    <?php
                                        $db = new PDO('mysql:host=localhost;dbname=alt_sup_project;charset=utf8mb4', 'root', '');
                                        $data = $db->query("SELECT * FROM roles")->fetchAll();
                                        foreach ($data as $row) {
                                            echo "<option value='".$row['id_role']."'>".$row['nom_role']."</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                            </div>
                            <div class="containerAdmin">
                            <div class="button" style="width: 80%;">
                            <input type="submit" name="submit" value="Ajouter un utilisateur">
                            </div>
                            </div>

                        </form>

                        <?php
                            $db = new PDO('mysql:host=localhost;dbname=alt_sup_project;charset=utf8mb4', 'root', '');
                            if(isset($_POST['submit'])) {
                                $nom = $_POST['nom'];
                                $prenom = $_POST['prenom'];
                                $mail = $_POST['email'];
                                $mdp = $_POST['mdp'];
                                $confirm = $_POST['confirm'];
                                $id_role = $_POST['role'];

                                if ($mdp != $confirm) {
                                    echo "Les mots de passe ne correspondent pas";
                                }

                                else {
                                    $existingUser = $db->prepare("SELECT * FROM utilisateurs WHERE email = :email");
                                    $existingUser->execute(['email' => $mail]);
                                    if($existingUser->rowCount() > 0) {
                                        // L'utilisateur existe déjà, afficher un message d'erreur
                                        echo "Cet adresse e-mail est déjà utilisée.";
                                    } else {
                                        // Insérer l'utilisateur dans la base de données
                                        $insertUser = $db->prepare("INSERT INTO utilisateurs (nom, prenom, email, mdp, id_role) VALUES (:nom, :prenom, :email, :mdp, :id_role)");
                                        $insertUser->execute(['nom' => $nom, 'prenom' => $prenom, 'email' => $mail, 'mdp' => $mdp, 'id_role' => $id_role]);
                                
                                        // Afficher un message de succès
                                        header ("Location: adminAddUtilisateur.php");
                                        $_POST=array();
                                        exit();
                                    }
                                }
                            }
                            

                            if (isset($mdpFailure)) {
                                echo "$mdpFailure";
                            }
                            if (isset($failure)) {
                                echo "$failure";
                            }

                        ?>
                    </div>
                    <div class="col">
                            <div class="divTitle">
                                <h1>Liste des utilisateurs</h1>
                            </div>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Nom</th>
                                        <th>Prenom</th>
                                        <th>Email</th>
                                        <th>Mot de passe</th>
                                        <th>Rôle</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $db = new PDO('mysql:host=localhost;dbname=alt_sup_project;charset=utf8mb4', 'root', '');
                                        $userData = $db->query("SELECT utilisateurs.*, roles.* FROM utilisateurs
                                        LEFT JOIN roles ON utilisateurs.id_role = roles.id_role
                                        ORDER BY roles.nom_role")->fetchAll();

                                        if (isset($_POST['supprimer'])) {
                                            $idSupprimer = $_POST['id_supprimer'];
                                            $db->exec("DELETE FROM utilisateurs WHERE id_utilisateur = $idSupprimer");
                                            header ("Location: adminUtilisateur.php");
                                            exit();
                                        }

                                        foreach ($userData as $row) {
                                            echo "<tr>
                                            <td>".$row['nom']."</td>
                                            <td>".$row['prenom']."</td>
                                            <td>".$row['email']."</td>
                                            <td>".$row['mdp']."</td>
                                            <td>".$row['nom_role']."</td>
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
