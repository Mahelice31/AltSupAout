<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="class1.css?<?php echo time(); ?>" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <title>Admin - Etudiants</title>
</head>

<body class="bodyAdmin">
<?php
session_start();
            if (!isset($_SESSION['logged_in']) || !in_array($_SESSION['logged_in'], [1, 2, 3, 4])) {
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
        
    <div class="containerAdmin text-center">
        <div class="divAdminMenu bg-light">
            <h1></h1>
            <div class="col">
                <h1>Import/Export</h1>
                <form action="import.php" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="csv_file" class="form-label">Choisir un fichier CSV</label>
                        <input type="file" name="csv_file" id="csv_file" class="form-control" required>
                    </div>
                    <div class="button" style="margin-top: 3%; width: 80%;">
                         <a href="export.php"><input type="submit" name="submit" value="Importer les données">
                    </div>
                </form>

            <div class="texte-center">
            <div class="button" style="margin-top: 3%; width: 80%;">
                <a href="export.php"><input type="submit" name="submit" value="Exporter les données en CSV">
            </div>
            </div>
            </div>
            <div class="col">
                <div class="divTitle">
                    <h1>Liste des étudiants</h1>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Email</th>
                            <th>École</th>
                            <th>Niveau d'étude</th>
                            <th>Statut</th>
                            <th>Intitulé Stage/Alternance</th>
                            <th>Missions</th>
                            <th>Tuteur</th>
                            <th>Entreprise</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $db = new PDO('mysql:host=localhost;dbname=alt_sup_project;charset=utf8mb4', 'root', '');
                            $etudiantData = $db->query("SELECT etudiants.*, ecoles.nom_ecole, niveau_etude.nom_niveau_etude, tuteur.nom_tuteur, entreprise.nom_entreprise 
                                                        FROM etudiants
                                                        LEFT JOIN ecoles ON etudiants.ecole = ecoles.id_ecole
                                                        LEFT JOIN niveau_etude ON etudiants.niveau_etude = niveau_etude.id_niveau_etude
                                                        LEFT JOIN tuteur ON etudiants.tuteur = tuteur.id_tuteur
                                                        LEFT JOIN entreprise ON etudiants.entreprise = entreprise.id_entreprise
                                                        ORDER BY etudiants.nom")->fetchAll();

                            foreach ($etudiantData as $row) {
                                echo "<tr>
                                    <td>".$row['nom']."</td>
                                    <td>".$row['prenom']."</td>
                                    <td>".$row['email']."</td>
                                    <td>".$row['nom_ecole']."</td>
                                    <td>".$row['nom_niveau_etude']."</td>
                                    <td>".$row['statut']."</td>
                                    <td>".$row['intitule_stage_alternance']."</td>
                                    <td>".$row['missions']."</td>
                                    <td>".$row['nom_tuteur']."</td>
                                    <td>".$row['nom_entreprise']."</td>
                                </tr>";
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="time.js"></script>
</body>
</html>
