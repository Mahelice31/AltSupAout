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
    if (!isset($_SESSION['logged_in']) || !in_array($_SESSION['logged_in'], [1, 2, 3, 4])) {
        header('Location: home.php');
        exit();
    }

    // Connexion à la base de données
    try {
        $db = new PDO('mysql:host=localhost;dbname=alt_sup_project;charset=utf8mb4', 'root', '');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo "Erreur de connexion à la base de données : " . $e->getMessage();
        exit();
    }

    $email = $_SESSION['email'];
    $queryEmail = "SELECT id_utilisateur FROM utilisateurs WHERE email = :email";
    $stmt = $db->prepare($queryEmail);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $id_utilisateur = $row['id_utilisateur'];
    ?>
    
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="navbar-header">
            <a name="home" class="navLogo" href="home.php">
                <img src="logo.png" class="logo" alt="Logo">
            </a>
            <a class="navA" href="SuiveursAlternant.php">Menu</a>
            <a class="navA" href="etiudiants.php">Liste des étudiants</a>
            <a class="navA" href="suivi_tuteur.php">Faire un suivi</a>
            <a class="navA" href="listeSuivis.php">Liste des suivis</a>
        </div>
        <div class="divTime">
            <?php
            if (isset($_SESSION['email'])) {
                $sqlSelect = "SELECT prenom FROM utilisateurs WHERE email = :email";
                $stmt = $db->prepare($sqlSelect);
                $stmt->bindParam(':email', $email);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($result) {
                    $username = $result['prenom'];
                } else {
                    echo "Utilisateur inconnu";
                }
            } else {
                header("Location: home.php");
                exit();
            }
            ?>
    </nav>

    <div class="containerAdmin text-center">
        <div class="divAdminMenu bg-light">
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $id_etudiant = $_POST['id_etudiant_formulaire'];
                $nom_etudiant = $_POST['nom_etudiant_formulaire'];
                $prenom_etudiant = $_POST['prenom_etudiant_formulaire'];
                $nom_entreprise = $_POST['nom_entreprise_formulaire'];
                $nom_tuteur = $_POST['nom_tuteur_formulaire'];
                $prenom_tuteur = $_POST['prenom_tuteur_formulaire'];
                $poste_etudiant = $_POST['poste_etudiant_formulaire'];
                $missions_etudiant = $_POST['missions_etudiant_formulaire'];

                // Validation check
                if (!empty($id_etudiant) && !empty($nom_etudiant) && !empty($prenom_etudiant) &&
                    !empty($nom_entreprise) && !empty($nom_tuteur) && !empty($prenom_tuteur) &&
                    !empty($poste_etudiant) && !empty($missions_etudiant)) {

                    // Insertion des données dans la table formulaire
                    $sql = "INSERT INTO formulaire (
                        id_etudiant_formulaire, nom_etudiant_formulaire, prenom_etudiant_formulaire,
                        nom_entreprise_formulaire, nom_tuteur_formulaire, prenom_tuteur_formulaire,
                        poste_etudiant_formulaire, missions_etudiant_formulaire
                    ) VALUES (
                        :id_etudiant_formulaire, :nom_etudiant_formulaire, :prenom_etudiant_formulaire,
                        :nom_entreprise_formulaire, :nom_tuteur_formulaire, :prenom_tuteur_formulaire,
                        :poste_etudiant_formulaire, :missions_etudiant_formulaire
                    )";

                    $stmt = $db->prepare($sql);
                    $stmt->bindParam(':id_etudiant_formulaire', $id_etudiant);
                    $stmt->bindParam(':nom_etudiant_formulaire', $nom_etudiant);
                    $stmt->bindParam(':prenom_etudiant_formulaire', $prenom_etudiant);
                    $stmt->bindParam(':nom_entreprise_formulaire', $nom_entreprise);
                    $stmt->bindParam(':nom_tuteur_formulaire', $nom_tuteur);
                    $stmt->bindParam(':prenom_tuteur_formulaire', $prenom_tuteur);
                    $stmt->bindParam(':poste_etudiant_formulaire', $poste_etudiant);
                    $stmt->bindParam(':missions_etudiant_formulaire', $missions_etudiant);

                    if ($stmt->execute()) {
                        echo "<div class='container'><div class='alert alert-success' role='alert'>Merci d'avoir répondu à ce questionnaire</div></div>";
                    } else {
                        echo "<div class='container'><div class='alert alert-danger' role='alert'>Erreur lors de l'insertion des données</div></div>";
                    }
                } else {
                    echo "<div class='container'><div class='alert alert-danger' role='alert'>Veuillez remplir tout le formulaire svp !</div></div>";
                }
            }
            ?>

            <div class="container">
                <h1 class="text-center my-4">SYNTHESE SUIVI TUTEUR</h1>
                <p class="text-justify">
                    <b>Bonjour,</b><br>
                    Ce questionnaire s'adresse aux suiveurs, qui représentent le campus et
                    réalisent les points d'étape de mi-parcours avec les tuteurs entreprise et étudiants. Pour
                    rappel, chaque apprenti doit faire l'objet à minima d'un suivi annuel. Chaque suivi doit être
                    enregistré via ce formulaire le jour du suivi. Ce questionnaire a pour objectif de faire la
                    synthèse de l'ensemble des SUIVIS et d'alerter les équipes relations entreprise et
                    pédagogique au besoin.<br>
                    Bien à vous<br>
                    <b>Directeur des Relations Entreprises et des Admissions</b> - <i>Sonny BRUSSEAU</i>
                </p>

                <form action="" method="post">
                    <div class="mb-4">
                        <h2>ETUDIANT</h2>
                        <div class="row">
                            <div class="form-group col-4 text-start">
                                <label for="id_etudiant_formulaire">ID étudiant *</label>
                                <input type="number" class="form-control" name="id_etudiant_formulaire" id="id_etudiant_formulaire" required>
                            </div>
                            <div class="form-group col-4 text-start">
                                <label for="nom_etudiant_formulaire">NOM de l'étudiant *</label>
                                <input type="text" class="form-control" name="nom_etudiant_formulaire" id="nom_etudiant_formulaire" required>
                            </div>
                            <div class="form-group col-4 text-start">
                                <label for="prenom_etudiant_formulaire">PRENOM de l'étudiant *</label>
                                <input type="text" class="form-control" name="prenom_etudiant_formulaire" id="prenom_etudiant_formulaire" required>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h2>ENTREPRISE</h2>
                        <div class="row">        
                            <div class="form-group col-6 text-start">
                                <label for="poste_etudiant_formulaire">POSTE occupé par l'étudiant *</label>
                                <input type="text" class="form-control" name="poste_etudiant_formulaire" id="poste_etudiant_formulaire" required>
                            </div>
                            <div class="form-group col-6 text-start">
                                <label for="nom_entreprise_formulaire">Nom de l'entreprise *</label>
                                <input type="text" class="form-control" name="nom_entreprise_formulaire" id="nom_entreprise_formulaire" required>
                            </div>
                            <div class="form-group col-6 text-start">
                                <label for="nom_tuteur_formulaire">NOM du tuteur d'entreprise *</label>
                                <input type="text" class="form-control" name="nom_tuteur_formulaire" id="nom_tuteur_formulaire" required>
                            </div>
                            <div class="form-group col-6 text-start">
                                <label for="prenom_tuteur_formulaire">PRENOM du tuteur d'entreprise *</label>
                                <input type="text" class="form-control" name="prenom_tuteur_formulaire" id="prenom_tuteur_formulaire" required>
                            </div>
                            <div class="form-group col-12 text-start">
                                <label for="missions_etudiant_formulaire">MISSIONS confiées à l'étudiant *</label>
                                <textarea class="form-control" name="missions_etudiant_formulaire" id="missions_etudiant_formulaire" required></textarea>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Soumettre</button>
                </form>
            </div>
        </div>
    </div>

    <script src="time.js"></script>
</body>
</html>
