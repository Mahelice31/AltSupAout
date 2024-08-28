-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Généré le : jeudi 11 juillet 2024 à 4:40
-- Version du serveur : 5.7.40
-- Version de PHP : 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- Base de données : `alt_sup_project`

-- --------------------------------------------------------

-- Structure de la table `alertes`
DROP TABLE IF EXISTS `alertes`;
CREATE TABLE IF NOT EXISTS `alertes` (
    `id_alertes` INT NOT NULL AUTO_INCREMENT,
    `description_alerte` TEXT NOT NULL,
    `type_alertes` INT NOT NULL,
    `niveau_alertes` INT NOT NULL,
    PRIMARY KEY (`id_alertes`),
    FOREIGN KEY (`type_alertes`) REFERENCES `type_alerte`(`id_type_alerte`),
    FOREIGN KEY (`niveau_alertes`) REFERENCES `niveau_alerte`(`id_niveau_alerte`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- Déchargement des données de la table `alertes`
INSERT INTO `alertes` (`id_alertes`, `description_alerte`, `type_alertes`, `niveau_alertes`) VALUES
(1, 'Il n y a rien a signaler', 1, 1),
(2, 'Il y a un probleme', 2, 2),
(3, 'Il y a un probleme', 2, 3),
(4, 'Il y a un probleme', 2, 4),
(5, 'Il y a un probleme', 2, 5),
(6, 'Il y a un probleme', 2, 6);

-- --------------------------------------------------------

-- Structure de la table `formulaire`
DROP TABLE IF EXISTS `formulaire`;
CREATE TABLE IF NOT EXISTS `formulaire` (
    `id_formulaire` INT PRIMARY KEY AUTO_INCREMENT,
    `rendez_vous_formulaire` INT NOT NULL,
    `id_etudiant_formulaire` INT NOT NULL,
    `nom_etudiant_formulaire` VARCHAR(50) NOT NULL,
    `prenom_etudiant_formulaire` VARCHAR(50) NOT NULL,
    `nom_entreprise_formulaire` VARCHAR(50) NOT NULL,
    `nom_tuteur_formulaire` VARCHAR(50) NOT NULL,
    `prenom_tuteur_formulaire` VARCHAR(50) NOT NULL,
    `poste_etudiant_formulaire` VARCHAR(50) NOT NULL,
    `missions_etudiant_formulaire` TEXT NOT NULL,
    `commentaires_formulaire` TEXT,
    `ponctualite_formulaire` TINYINT NOT NULL CHECK (`ponctualite_formulaire` BETWEEN 1 AND 5),
    `capacite_integration_formulaire` TINYINT NOT NULL CHECK (`capacite_integration_formulaire` BETWEEN 1 AND 5),
    `sens_organisation_formulaire` TINYINT NOT NULL CHECK (`sens_organisation_formulaire` BETWEEN 1 AND 5),
    `sens_communication_formulaire` TINYINT NOT NULL CHECK (`sens_communication_formulaire` BETWEEN 1 AND 5),
    `travail_equipe_formulaire` TINYINT NOT NULL CHECK (`travail_equipe_formulaire` BETWEEN 1 AND 5),
    `reactivite_formulaire` TINYINT NOT NULL CHECK (`reactivite_formulaire` BETWEEN 1 AND 5),
    `perseverance_formulaire` TINYINT CHECK (`perseverance_formulaire` BETWEEN 1 AND 5),
    `force_proposition_formulaire` TINYINT CHECK (`force_proposition_formulaire` BETWEEN 1 AND 5),
    `projets_semestre_formulaire` TEXT NOT NULL,
    `axes_amelioration_formulaire` TEXT NOT NULL,
    `points_forts_formulaire` TEXT NOT NULL,
    `memoire_mastere` TEXT,
    `projet_poursuite_etudes_formulaire` BOOLEAN NOT NULL,
    `projet_recrutement_formulaire` BOOLEAN NOT NULL,
    `format_suivi_formulaire` VARCHAR(50) NOT NULL,
    `commentaire_suivi_formulaire` TEXT,
    `nom_suiveur_formulaire` VARCHAR(50) NOT NULL,
    `prenom_suiveur_formulaire` VARCHAR(50) NOT NULL,
    `date_suivi_formulaire` DATE NOT NULL,
    FOREIGN KEY (`rendez_vous_formulaire`) REFERENCES `rendez_vous`(`id_rendez_vous`),
    FOREIGN KEY (`id_etudiant_formulaire`) REFERENCES `etudiants`(`id_etudiant`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- Structure de la table `ecoles`
DROP TABLE IF EXISTS `ecoles`;
CREATE TABLE IF NOT EXISTS `ecoles` (
    `id_ecole` INT PRIMARY KEY AUTO_INCREMENT,
    `nom_ecole` VARCHAR(50) NOT NULL UNIQUE
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

-- Déchargement des données de la table `ecoles`
INSERT INTO `ecoles` (`id_ecole`, `nom_ecole`) VALUES
(1, 'EFAB'),
(2, 'ESUPCOM'),
(3, 'ICAN'),
(4, 'ISA'),
(5, 'PPA'),
(6, 'PPA Sport'),
(7, 'Modart'),
(8, 'Maestris BTS'),
(9, 'EDBS'),
(10, 'EFET Studio Creart'),
(11, 'ISFJ'),
(12, 'ESGI'),
(13, 'ENGDE'),
(14, 'ESIS'),
(15, 'EIML');

-- --------------------------------------------------------

-- Structure de la table `etudiants`
DROP TABLE IF EXISTS `etudiants`;
CREATE TABLE IF NOT EXISTS `etudiants` (
    `id_etudiant` INT NOT NULL AUTO_INCREMENT,
    `email` VARCHAR(50) DEFAULT NULL,
    `nom` VARCHAR(50) DEFAULT NULL,
    `prenom` VARCHAR(50) DEFAULT NULL,
    `ecole` INT NOT NULL,
    `niveau_etude` INT NOT NULL,
    `statut` VARCHAR(50) DEFAULT NULL,
    `intitule_stage_alternance` TEXT NOT NULL,
    `missions` TEXT NOT NULL,
    `tuteur` INT NOT NULL,
    `entreprise` INT NOT NULL,
    PRIMARY KEY (`id_etudiant`),
    FOREIGN KEY (`ecole`) REFERENCES `ecoles`(`id_ecole`),
    FOREIGN KEY (`niveau_etude`) REFERENCES `niveau_etude`(`id_niveau_etude`),
    FOREIGN KEY (`tuteur`) REFERENCES `tuteur`(`id_tuteur`),
    FOREIGN KEY (`entreprise`) REFERENCES `entreprise`(`id_entreprise`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

-- Déchargement des données de la table `etudiants`
INSERT INTO `etudiants` (`id_etudiant`, `email`, `nom`, `prenom`, `ecole`, `niveau_etude`, `statut`, `intitule_stage_alternance`, `missions`, `tuteur`, `entreprise`) VALUES
(19, 'sonny@gmail.com', 'Brusseau', 'Sonny', 1, 1, 'Alternant', 'Développeur', 'Développer des applications', 1, 1),
(3, 'lmarshall@gmail.com', 'Marshall', 'Laure-anne', 2, 2, 'Alternant', 'Développeur', 'Développer des applications', 2, 2);

-- --------------------------------------------------------

-- Structure de la table `roles`
DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
    `id_role` INT NOT NULL AUTO_INCREMENT,
    `nom_role` VARCHAR(50) DEFAULT NULL,
    PRIMARY KEY (`id_role`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- Déchargement des données de la table `roles`
INSERT INTO `roles` (`id_role`, `nom_role`) VALUES
(1, 'DirecteurCRE'),
(2, 'CRE'),
(3, 'ResponsablePedagogique'),
(4, 'SuiveurAlternant');

-- --------------------------------------------------------

-- Structure de la table `utilisateurs`
DROP TABLE IF EXISTS `utilisateurs`;
CREATE TABLE IF NOT EXISTS `utilisateurs` (
    `id_utilisateur` INT NOT NULL AUTO_INCREMENT,
    `email` VARCHAR(50) DEFAULT NULL,
    `mdp` VARCHAR(50) DEFAULT NULL,
    `nom` VARCHAR(50) DEFAULT NULL,
    `prenom` VARCHAR(50) DEFAULT NULL,
    `id_role` INT NOT NULL,
    PRIMARY KEY (`id_utilisateur`),
    FOREIGN KEY (`id_role`) REFERENCES `roles`(`id_role`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- Déchargement des données de la table `utilisateurs`
INSERT INTO `utilisateurs` (`id_utilisateur`, `email`, `mdp`, `nom`, `prenom`, `id_role`) VALUES
(19, 'sonny@gmail.com', 'DirecteurCRE', 'Brusseau', 'Sonny', 1),
(3, 'lmarshall@gmail.com', 'ResponsablePedagogique', 'Marshall', 'Laure-anne', 2),
(5, 'benedicte@gmail.com', 'ResponsablePedagogique', 'Maurin-crepet', 'Benedicte', 3),
(8, 'a.vardanyan@gmail.com', 'SuiveurAlternant', 'Vardanyan', 'Arthur', 4),
(20, 'c.paoli@gmail.com', 'c.paoli', 'Paoli', 'christophe', 1);

-- --------------------------------------------------------

-- Structure de la table `tuteur`
DROP TABLE IF EXISTS `tuteur`;
CREATE TABLE IF NOT EXISTS `tuteur` (
    `id_tuteur` INT PRIMARY KEY AUTO_INCREMENT,
    `nom_tuteur` VARCHAR(50) NOT NULL UNIQUE,
    `entreprise_tuteur` INT NOT NULL,
    FOREIGN KEY (`entreprise_tuteur`) REFERENCES `entreprise`(`id_entreprise`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Déchargement des données de la table `tuteur`
INSERT INTO `tuteur` (`id_tuteur`, `nom_tuteur`, `entreprise_tuteur`) VALUES
(1, 'Dupont', 1),
(2, 'Durand', 2);
(3, 'DUFER', 2);
-- --------------------------------------------------------

-- Structure de la table `role_utilisateur`
DROP TABLE IF EXISTS `role_utilisateur`;
CREATE TABLE IF NOT EXISTS `role_utilisateur` (
    `id_role_utilisateur` INT PRIMARY KEY AUTO_INCREMENT,
    `nom_role_utilisateur` VARCHAR(50) NOT NULL UNIQUE
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- Structure de la table `entreprise`
DROP TABLE IF EXISTS `entreprise`;
CREATE TABLE IF NOT EXISTS `entreprise` (
    `id_entreprise` INT PRIMARY KEY AUTO_INCREMENT,
    `nom_entreprise` VARCHAR(50) NOT NULL UNIQUE
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Déchargement des données de la table `entreprise`
INSERT INTO `entreprise` (`id_entreprise`, `nom_entreprise`) VALUES
(1, 'Societe generale'),
(2, 'BNP Paribas');
-- --------------------------------------------------------

-- Structure de la table `niveau_alerte`
DROP TABLE IF EXISTS `niveau_alerte`;
CREATE TABLE IF NOT EXISTS `niveau_alerte` (
    `id_niveau_alerte` INT PRIMARY KEY AUTO_INCREMENT,
    `nom_niveau_alerte` VARCHAR(50) NOT NULL UNIQUE
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- Structure de la table `type_alerte`
DROP TABLE IF EXISTS `type_alerte`;
CREATE TABLE IF NOT EXISTS `type_alerte` (
    `id_type_alerte` INT PRIMARY KEY AUTO_INCREMENT,
    `nom_type_alerte` VARCHAR(50) NOT NULL UNIQUE
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- Structure de la table `niveau_etude`
DROP TABLE IF EXISTS `niveau_etude`;
CREATE TABLE IF NOT EXISTS `niveau_etude` (
    `id_niveau_etude` INT PRIMARY KEY AUTO_INCREMENT,
    `nom_niveau_etude` VARCHAR(50) NOT NULL UNIQUE
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `niveau_etude` (`id_niveau_etude`, `nom_niveau_etude`) VALUES
(1, 'Bachelor 1'),
(2, 'Bachelor 2'),
(3, 'Bachelor 3'),
(4, 'Mastere 1'),
(5, 'Mastere 2');

-- --------------------------------------------------------

-- Structure de la table `rendez_vous`
DROP TABLE IF EXISTS `rendez_vous`;
CREATE TABLE IF NOT EXISTS `rendez_vous` (
    `id_rendez_vous` INT PRIMARY KEY AUTO_INCREMENT,
    `intitule_rendez_vous` VARCHAR(50) NOT NULL,
    `etudiant_rendez_vous` INT NOT NULL,
    `tuteur_rendez_vous` INT NOT NULL,
    `suiveur_rendez_vous` INT NOT NULL,
    `creneau_rendez_vous` DATETIME NOT NULL,
    FOREIGN KEY (`etudiant_rendez_vous`) REFERENCES `etudiants`(`id_etudiant`),
    FOREIGN KEY (`tuteur_rendez_vous`) REFERENCES `tuteur`(`id_tuteur`),
    FOREIGN KEY (`suiveur_rendez_vous`) REFERENCES `utilisateurs`(`id_utilisateur`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

COMMIT;
