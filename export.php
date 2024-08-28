<?php
// Connexion à la base de données
$db = new PDO('mysql:host=localhost;dbname=alt_sup_project;charset=utf8mb4', 'root', '');

// Définir le nom du fichier CSV
$filename = "export_data.csv";

// Définir les en-têtes pour le téléchargement du fichier CSV
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=' . $filename);

// Ouvrir un flux de sortie en mode écriture
$output = fopen('php://output', 'w');

// Écrire les en-têtes des colonnes dans le fichier CSV
fputcsv($output, array('id', 'nom', 'prenom', 'email', 'ecole', 'niveau_etude', 'statut', 'intitule_stage_alternance', 'missions', 'tuteur', 'entreprise'));

// Récupérer les données de la table
$query = $db->query("SELECT * FROM utilisateurs");

// Écrire les données de chaque ligne dans le fichier CSV
while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
    fputcsv($output, $row);
}

// Fermer le flux de sortie
fclose($output);
?>
