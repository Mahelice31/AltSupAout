<?php
// Connexion à la base de données
$db = new PDO('mysql:host=localhost;dbname=alt_sup_project;charset=utf8mb4', 'root', '');

// Vérifier si le formulaire a été soumis
if (isset($_POST['submit'])) {
    // Vérifier si un fichier a été téléchargé
    if (is_uploaded_file($_FILES['csv_file']['tmp_name'])) {
        // Ouvrir le fichier CSV
        $file = fopen($_FILES['csv_file']['tmp_name'], 'r');

        // Ignorer la première ligne (en-têtes)
        fgetcsv($file);

        // Lire et insérer chaque ligne dans la base de données
        while (($row = fgetcsv($file)) !== FALSE) {
            $stmt = $db->prepare("INSERT INTO utilisateurs (id, nom, prenom, email, ecole, niveau_etude, statut, intitule_stage_alternance, missions, tuteur, entreprise) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute($row);
        }

        // Fermer le fichier
        fclose($file);

        echo "Importation réussie!";
    } else {
        echo "Veuillez télécharger un fichier CSV.";
    }
}
?>
