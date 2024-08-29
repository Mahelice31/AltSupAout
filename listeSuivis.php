<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="class1.css?<?php echo time(); ?>" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <title>Admin - Formulaires</title>
</head>

<body class="bodyAdmin">
    <?php
    session_start();
    if (!isset($_SESSION['logged_in']) || !in_array($_SESSION['logged_in'], [1, 2, 3, 4])) {
        header('Location: home.php');
        exit();
    }

    // Connexion à la base de données
    $db = new mysqli('localhost', 'root', '', 'alt_sup_project');
    if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    }

    $email = $_SESSION['email'];

    // Requête pour l'id utilisateur
    $queryEmail = "SELECT id_utilisateur FROM utilisateurs WHERE email=?";
    $stmt = $db->prepare($queryEmail);
    if ($stmt) {
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $id_utilisateur = $row['id_utilisateur'];
        $stmt->close();
    } else {
        die("Query failed: " . $db->error);
    }

    // Notification logic
    $notifications = [];

    // Vérifiez si un étudiant n'a pas eu de suivi depuis 30 jours
    $query = "SELECT nom_etudiant_formulaire, prenom_etudiant_formulaire, date_suivi_formulaire 
              FROM formulaire 
              WHERE DATE_SUB(CURDATE(), INTERVAL 30 DAY) > date_suivi_formulaire";
    $result = $db->query($query);

    if ($result) {
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $notifications[] = "L'étudiant " . $row['prenom_etudiant_formulaire'] . " " . $row['nom_etudiant_formulaire'] . " n'a pas eu de suivi depuis plus de 30 jours.";
                
                // Optionnel : Envoyer un email de notification
                $to = $email; // Adresse email de l'admin ou de l'utilisateur concerné
                $subject = "Notification de suivi en retard";
                $message = "Bonjour,\n\nL'étudiant " . $row['prenom_etudiant_formulaire'] . " " . $row['nom_etudiant_formulaire'] . " n'a pas eu de suivi depuis plus de 30 jours.\n\nCordialement,\nL'équipe de gestion.";
                $headers = "From: admin@example.com";
                mail($to, $subject, $message, $headers);
            }
        }
    } else {
        die("Query failed: " . $db->error);
    }
    ?>

    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="navbar-header">
            <a name="home" class="navLogo" href="home.php">
                <img src="logo.png" class="logo" alt="Logo">
            </a>
            <a class="navA" href="DirecteurCre.php">Menu</a>
            <a class="navA" href="adminAddUtilisateur.php">Ajouter utilisateurs</a>
            <a class="navA" href="adminAddStudent.php">Ajouter un étudiant</a>
            <a class="navA" href="etudiants.php">Liste des étudiants</a>
            <a class="navA" href="listeSuivis.php">Liste des suivis</a>
        </div>

        <div class="divTime">
            <?php
            if (isset($_SESSION['email'])) {
                $email = $_SESSION['email'];
                $sqlSelect = "SELECT prenom FROM utilisateurs WHERE email = ?";
                $stmt = $db->prepare($sqlSelect);
                if ($stmt) {
                    $stmt->bind_param('s', $email);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $username = $row['prenom'];
                        echo "<span>Bienvenue, $username</span>";
                    } else {
                        echo "Utilisateur inconnu";
                    }
                    $stmt->close();
                } else {
                    die("Query failed: " . $db->error);
                }
            } else {
                header("Location: home.php");
                exit();
            }
            ?>    
            <a class="alerte alertes span" href="#">
                <img src="cloche.png" class="cloche alertes:hower alertes span" alt="Notifications">
                <span>3</span>
            </a>          
        </div>
    </nav>

    <div class="containerAdmin text-center">
        <div class="divAdminMenu bg-light">
            <div class="col">
                <div class="divTitle">
                    <h1>Liste des formulaires</h1>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Entreprise</th>
                            <th>Tuteur</th>
                            <th>Poste</th>
                            <th>Missions</th>
                            <th>Commentaires</th>
                            <th>Ponctualité</th>
                            <th>Capacité d'intégration</th>
                            <th>Sens de l'organisation</th>
                            <th>Sens de la communication</th>
                            <th>Travail en équipe</th>
                            <th>Réactivité</th>
                            <th>Persévérance</th>
                            <th>Force de proposition</th>
                            <th>Projets du semestre</th>
                            <th>Axes d'amélioration</th>
                            <th>Points forts</th>
                            <th>Mémoire</th>
                            <th>Projet de poursuite d'études</th>
                            <th>Projet de recrutement</th>
                            <th>Format de suivi</th>
                            <th>Nom du suiveur</th>
                            <th>Prénom du suiveur</th>
                            <th>Date de suivi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = "SELECT * FROM formulaire";
                        $result = $db->query($query);

                        if ($result) {
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>
                                        <td>".$row['nom_etudiant_formulaire']."</td>
                                        <td>".$row['prenom_etudiant_formulaire']."</td>
                                        <td>".$row['nom_entreprise_formulaire']."</td>
                                        <td>".$row['nom_tuteur_formulaire']."</td>
                                        <td>".$row['poste_etudiant_formulaire']."</td>
                                        <td>".$row['missions_etudiant_formulaire']."</td>
                                        <td>".$row['commentaires_formulaire']."</td>
                                        <td>".$row['ponctualite_formulaire']."</td>
                                        <td>".$row['capacite_integration_formulaire']."</td>
                                        <td>".$row['sens_organisation_formulaire']."</td>
                                        <td>".$row['sens_communication_formulaire']."</td>
                                        <td>".$row['travail_equipe_formulaire']."</td>
                                        <td>".$row['reactivite_formulaire']."</td>
                                        <td>".$row['perseverance_formulaire']."</td>
                                        <td>".$row['force_proposition_formulaire']."</td>
                                        <td>".$row['projets_semestre_formulaire']."</td>
                                        <td>".$row['axes_amelioration_formulaire']."</td>
                                        <td>".$row['points_forts_formulaire']."</td>
                                        <td>".$row['memoire_master']."</td>
                                        <td>".$row['projet_poursuite_etudes_formulaire']."</td>
                                        <td>".$row['projet_recrutement_formulaire']."</td>
                                        <td>".$row['format_suivi_formulaire']."</td>
                                        <td>".$row['nom_suiveur_formulaire']."</td>
                                        <td>".$row['prenom_suiveur_formulaire']."</td>
                                        <td>".$row['date_suivi_formulaire']."</td>
                                    </tr>";
                                }
                            }
                        } else {
                            die("Query failed: " . $db->error);
                        }
                        // Fermer la connexion après avoir terminé
                        $db->close();
                        ?>
                    </tbody>
                </table
