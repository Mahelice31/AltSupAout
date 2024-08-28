
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
            if (!isset($_SESSION['logged_in']) || !in_array($_SESSION['logged_in'], [1, 2, 3])) {
                header('Location: home.php');
                exit();
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
            <a class="alerte alertes alertes span" href="#">
                <img src="cloche.png" class=" cloche alertes:hower alertes span">
                <span>3</span>
                </a>
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
                        <div class="divTitle">
                            <h1>Ajouter un étudiant</h1>
                        </div>
                        <form class="" method="post">
                        <div class="texte">
                                <input type="email" name="email" required>
                                <span></span>
                                <label>Adresse mail</label>
                            </div>
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
                            <div class="register-link">
                                <div class="containerAdmin">
                                    <select name="ecole">
                                        <?php
                                            $db = new PDO('mysql:host=localhost;dbname=alt_sup_project;charset=utf8mb4', 'root', '');
                                            $data = $db->query("SELECT * FROM ecoles")->fetchAll();
                                            foreach ($data as $row) {
                                                echo "<option value='".$row['id_ecole']."'>".$row['nom_ecole']."</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="register-link">
                                <div class="containerAdmin">
                                    <select name="ecole">
                                        <?php
                                            $db = new PDO('mysql:host=localhost;dbname=alt_sup_project;charset=utf8mb4', 'root', '');
                                            $data = $db->query("SELECT * FROM niveau_etude")->fetchAll();
                                            foreach ($data as $row) {
                                                echo "<option value='".$row['id_niveau_etude']."'>".$row['nom_niveau_etude']."</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="texte">
                                <input type="text" name="statut" required>
                                <span></span>
                                <label>Statut</label>
                            </div>
                            <div class="texte">
                                <input type="text" name="intitule_stage_alternance" required>
                                <span></span>
                                <label>Intitulé du stage en alternance</label>
                            </div>
                            <div class="texte">
                                <input type="text" name="missions" required>
                                <span></span>
                                <label>Missions</label>
                            </div>
                            <div class="register-link">
                                <div class="containerAdmin">
                                    <select name="tuteur">
                                        <?php
                                            $db = new PDO('mysql:host=localhost;dbname=alt_sup_project;charset=utf8mb4', 'root', '');
                                            $data = $db->query("SELECT * FROM tuteur")->fetchAll();
                                            foreach ($data as $row) {
                                                echo "<option value='".$row['id_tuteur']."'>".$row['nom_tuteur']."</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="register-link">
                                <div class="containerAdmin">
                                    <select name="entreprise">
                                        <?php
                                            $db = new PDO('mysql:host=localhost;dbname=alt_sup_project;charset=utf8mb4', 'root', '');
                                            $data = $db->query("SELECT * FROM entreprise")->fetchAll();
                                            foreach ($data as $row) {
                                                echo "<option value='".$row['id_entreprise']."'>".$row['nom_entreprise']."</option>";
                                            }
                                        ?>
                                    </select>
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
                                $mail = $_POST['email'];
                                $nom = $_POST['nom'];
                                $prenom = $_POST['prenom'];
                                $ecole = $_POST['ecole'];
                                $niveau_etude = $_POST['niveau_etude'];
                                $statut = $_POST['statut'];
                                $intitule_stage_alternance = $_POST['intitule_stage_alternance'];
                                $missions = $_POST['missions'];
                                $tuteur = $_POST['tuteur'];
                                $entreprise = $_POST['entreprise'];

                                // else {
                                //     $existingUser = $db->prepare("SELECT * FROM utilisateurs WHERE email = :email");
                                //     $existingUser->execute(['email' => $mail]);
                                //     if($existingUser->rowCount() > 0) {
                                //         // L'utilisateur existe déjà, afficher un message d'erreur
                                //         echo "Cet adresse e-mail est déjà utilisée.";
                                //     } else {
                                //         // Insérer l'utilisateur dans la base de données
                                //         $insertUser = $db->prepare("INSERT INTO utilisateurs (nom, prenom, email, mdp, id_role) VALUES (:nom, :prenom, :email, :mdp, :id_role)");
                                //         $insertUser->execute(['email' => $mail, 'nom' => $nom, 'prenom' => $prenom, 'ecole' => $ecole, 'niveau_etude' => $niveau_etude, 'statut' => $statut, 'intitule_stage_alternance' => $intitule_stage_alternance, 'missions' => $missions, 'tuteur' => $tuteur, 'entreprise' => $entreprise]);
                                
                                //         // Afficher un message de succès
                                //         header ("Location: adminAddStudent.php");
                                //         $_POST=array();
                                //         exit();
                                //     }
                                // }
                            }
                            

                            if (isset($mdpFailure)) {
                                echo "$mdpFailure";
                            }
                            if (isset($failure)) {
                                echo "$failure";
                            }

                        ?>
                    </div>            
            </div>
        </div>
        <script src="time.js"></script>
    </body>
