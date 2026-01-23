-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 22 jan. 2026 à 13:00
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `bd_emplois`
--

-- --------------------------------------------------------

--
-- Structure de la table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `id_departement` int(11) NOT NULL,
  `emailC` varchar(100) NOT NULL,
  `mot_de_passe` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `admin`
--

INSERT INTO `admin` (`id_admin`, `id_departement`, `emailC`, `mot_de_passe`) VALUES
(0, 1, 'lyslone7@gmail.com', 'azerty237');

-- --------------------------------------------------------

--
-- Structure de la table `alert`
--

CREATE TABLE `alert` (
  `id_alert` int(11) NOT NULL,
  `type_alert` enum('conflit','complet','modification','rappel') NOT NULL,
  `message` text DEFAULT NULL,
  `id_classe` int(11) NOT NULL,
  `id_utilisateur` int(11) NOT NULL,
  `lu` tinyint(1) DEFAULT NULL,
  `date_creation_alert` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `classe`
--

CREATE TABLE `classe` (
  `id_classe` int(11) NOT NULL,
  `nom_classe` varchar(100) NOT NULL,
  `effectif` int(11) DEFAULT NULL,
  `annee_aca` varchar(9) NOT NULL,
  `id_filiere` int(11) NOT NULL,
  `date_creation` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `classe`
--

INSERT INTO `classe` (`id_classe`, `nom_classe`, `effectif`, `annee_aca`, `id_filiere`, `date_creation`) VALUES
(1, 'ICT-L1', 300, '2024-2025', 1, '0000-00-00 00:00:00'),
(2, 'ICT-L2', 175, '2024-2025', 1, '0000-00-00 00:00:00'),
(3, 'ICT-L3', 200, '2024-2025', 1, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `configuration`
--

CREATE TABLE `configuration` (
  `id_config` int(11) NOT NULL,
  `cle` varchar(50) NOT NULL,
  `valeur` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `date_modif` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `cours_salle`
--

CREATE TABLE `cours_salle` (
  `id_cours_salle` int(11) NOT NULL,
  `id_ue` int(11) NOT NULL,
  `id_salle` int(11) NOT NULL,
  `priorite` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `creneau`
--

CREATE TABLE `creneau` (
  `id_creneau` int(11) NOT NULL,
  `id_ue` int(11) NOT NULL,
  `id_salle` int(11) DEFAULT NULL,
  `id_seance` int(11) NOT NULL,
  `jour` enum('LUNDI','MARDI','MERCREDI','JEUDI','VENDREDI','SAMEDI') NOT NULL,
  `heure_debut_cre` time NOT NULL,
  `heure_fin_cre` time NOT NULL,
  `type_seance_cre` enum('CM','TD','TP') NOT NULL,
  `date_seance_cre` date DEFAULT NULL,
  `statut_cre` enum('proposé','confirmé','annulé') DEFAULT NULL,
  `date_creation_cre` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_modification_cre` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `departement`
--

CREATE TABLE `departement` (
  `id_departement` int(11) NOT NULL,
  `nom_departement` varchar(100) NOT NULL,
  `responsable_nom` varchar(100) DEFAULT NULL,
  `date_creation` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `departement`
--

INSERT INTO `departement` (`id_departement`, `nom_departement`, `responsable_nom`, `date_creation`) VALUES
(1, 'Informatique', 'Makemgue Lyslone', '0000-00-00 00:00:00'),
(2, 'Mathematique', 'Kenfack Pierre', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `etudiant`
--

CREATE TABLE `etudiant` (
  `id_etudiant` int(11) NOT NULL,
  `id_utilisateur` int(11) NOT NULL,
  `matricule` varchar(150) NOT NULL,
  `id_classe` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `classe` varchar(10) DEFAULT NULL,
  `id_filiere` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `etudiant`
--

INSERT INTO `etudiant` (`id_etudiant`, `id_utilisateur`, `matricule`, `id_classe`, `nom`, `email`, `classe`, `id_filiere`) VALUES
(1, 6, 'ETU2023001', 1, 'Durand Marie', 'durand@universite.com', NULL, 1),
(2, 7, 'ETU2023002', 1, 'Petit Thomas', 'petit@universite.com', NULL, 1),
(3, 8, 'ETU2023003', 2, 'Moreau Alice', 'alice.moreau@universite.com', NULL, 1),
(4, 9, 'ETU2023004', 2, 'Lefebvre Julien', 'lefebvre@universite.com', NULL, 1),
(5, 10, 'ETU2023005', 3, 'Garcia Camille', 'garcia@universite.com', NULL, 1);

-- --------------------------------------------------------

--
-- Structure de la table `enseignant`
--

CREATE TABLE `enseignant` (
  `id_enseignant` int(11) NOT NULL,
  `id_utilisateur` int(11) NOT NULL,
  `grade` enum('PROFESSEUR','MCF','ATER','VACATAIRE') NOT NULL,
  `heures_service` int(11) DEFAULT 192,
  `id_departement` int(11) NOT NULL,
  `nom_ens` varchar(100) NOT NULL,
  `email_ens` varchar(50)UNIQUE NOT NULL,
  `matricule_ens` varchar(20)UNIQUE NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `enseignant`
--

INSERT INTO `enseignant` (`id_enseignant`, `id_utilisateur`, `grade`, `heures_service`, `id_departement`, `nom_ens`, `email_ens`, `matricule_ens`) VALUES
(7, 1, 'PROFESSEUR', 192, 1,'kouandou Aboubakar', 'abou5@universite.com', 'ENS2023001'),
(8, 2, 'MCF', 192, 2,'Martin Claire', 'claire.martin@universite.com', 'ENS2023002'),
(9, 3, 'VACATAIRE', 128, 2,'Bernard Pierre', 'pierre.bernard@universite.com', 'ENS2023003'),
(10, 4, 'PROFESSEUR', 96, 1,'Nkondock Mi Bahana', 'bahana7@universite.com', 'ENS2023004'),
(11, 5, 'PROFESSEUR', 192, 1,'Roux Alain', 'alain.roux@universite.com', 'ENS2023005');

--
-- Structure de la table `filiere`
--

CREATE TABLE `filiere` (
  `id_filiere` int(11) NOT NULL,
  `code_filiere` varchar(10) NOT NULL,
  `id_departement` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `filiere`
--

INSERT INTO `filiere` (`id_filiere`, `code_filiere`, `id_departement`) VALUES
(1, 'ICT4D', 1),
(2, 'INFO', 1);

-- --------------------------------------------------------

--
-- Structure de la table `salle`
--

CREATE TABLE `salle` (
  `id_salle` int(11) NOT NULL,
  `code_salle` varchar(20) NOT NULL,
  `batiment` varchar(50) NOT NULL,
  `etage` int(11) DEFAULT NULL,
  `capacite` int(11) NOT NULL,
  `type_salle` enum('AMPHI','TD','TP','LABO','BUREAU') NOT NULL,
  `equipements` text DEFAULT NULL,
  `disponible` tinyint(1) DEFAULT 1,
  `id_departement` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `salle`
--

INSERT INTO `salle` (`id_salle`, `code_salle`, `batiment`, `etage`, `capacite`, `type_salle`, `equipements`, `disponible`, `id_departement`) VALUES
(0, '[value-2]', '[value-3]', 0, 0, '', '[value-7]', 0, 0),
(1, 'R110', 'block pédagogique', 1, 300, 'TD', 'craies, projecteur', 24, 1),
(2, 'S003', 'département informatique', 0, 250, '', 'marqueurs, projecteur', 24, 1),
(3, 'S008', 'département informatique', 1, 300, 'TP', 'marqueurs, projecteur', 24, 1),
(4, 'Amphi501', 'G', 0, 501, 'AMPHI', 'craies, projecteur', 24, 1),
(5, 'S111', 'département informatique', 1, 200, 'TD', 'marqueurs, projecteur', 24, 1);

-- --------------------------------------------------------

--
-- Structure de la table `seance`
--

CREATE TABLE `seance` (
  `id_seance` int(11) NOT NULL,
  `id_ue` int(11) NOT NULL,
  `id_enseignant` int(11) NOT NULL,
  `id_salle` int(11) DEFAULT NULL,
  `id_classe` int(11) NOT NULL,
  `date_seance` date NOT NULL,
  `heure_debut` time NOT NULL,
  `heure_fin` time NOT NULL,
  `type_seance` enum('CM','TD','TP','EXAMEN','RATTRAPAGE') NOT NULL DEFAULT 'CM',
  `statut` enum('PLANIFIEE','CONFIRMEE','ANNULEE','TERMINEE') DEFAULT 'PLANIFIEE',
  `jour` enum('Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `seance`
--

INSERT INTO `seance` (`id_seance`, `id_ue`, `id_enseignant`, `id_salle`, `id_classe`, `date_seance`, `heure_debut`, `heure_fin`, `type_seance`, `statut`, `jour`) VALUES
(1, 1, 2, 1, 1, '2025-01-08', '08:00:00', '11:00:00', 'CM', 'TERMINEE', 'Lundi'),
(2, 2, 3, 1, 1, '2025-01-08', '12:00:00', '15:00:00', 'TD', 'TERMINEE', 'Lundi'),
(3, 3, 2, 1, 1, '2025-01-09', '11:00:00', '14:00:00', 'CM', 'TERMINEE', 'Mardi'),
(4, 4, 5, 1, 1, '2025-01-10', '09:00:00', '12:00:00', 'CM', 'TERMINEE', 'Mercredi'),
(5, 5, 4, 1, 1, '2025-01-10', '13:00:00', '15:00:00', 'TD', 'TERMINEE', 'Mercredi'),
(6, 6, 1, 1, 1, '2025-01-11', '08:00:00', '11:00:00', 'CM', 'TERMINEE', 'Jeudi'),
(7, 3, 2, 1, 1, '2025-01-12', '15:00:00', '18:00:00', 'TD', 'TERMINEE', 'Vendredi'),
(8, 7, 4, 2, 2, '2025-01-15', '08:00:00', '11:00:00', 'CM', 'TERMINEE', 'Lundi'),
(9, 10, 2, 2, 2, '2025-01-15', '12:00:00', '15:00:00', 'TD', 'TERMINEE', 'Lundi');

-- --------------------------------------------------------

--
-- Structure de la table `ues`
--

CREATE TABLE `ues` (
  `id_ue` int(11) NOT NULL,
  `code_ue` varchar(20) NOT NULL,
  `intitule` varchar(200) NOT NULL,
  `id_classe` int(11) NOT NULL,
  `id_enseignant` int(11) NOT NULL,
  `credit_ects` int(11) DEFAULT 6,
  `volume_horaire_total` int(11) NOT NULL,
  `semestre_ue` int(11) NOT NULL,
  `type_ue` enum('CM','TD','TP','PROJET') NOT NULL,
  `couleur_agenda` varchar(7) DEFAULT '#3788d8'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `ues`
--

INSERT INTO `ues` (`id_ue`, `code_ue`, `intitule`, `id_classe`, `id_enseignant`, `credit_ects`, `volume_horaire_total`, `semestre_ue`, `type_ue`, `couleur_agenda`) VALUES
(1, 'ICT101', 'Informatique Générale', 1, 2, 6, 60, 0, '', '#3498DB'),
(2, 'ICT103', 'Bases de Données', 1, 3, 5, 45, 0, '', '#2ECC71'),
(3, 'ICT105', 'Algorithmique', 1, 2, 4, 30, 0, '', '#E74C3C'),
(4, 'ICT107', 'Algèbre Linéaire', 1, 5, 6, 60, 0, '', '#9B59B6'),
(5, 'ICT109', 'Mathématiques', 1, 4, 5, 45, 0, '', '#1ABC9C'),
(6, 'ICT111', 'Data Coding', 1, 1, 5, 45, 0, '', '#E67E22'),
(7, 'ICT201', 'Introduction GL', 2, 4, 5, 30, 0, '', '#34495E'),
(8, 'ICT203', 'Base De Données', 2, 3, 6, 45, 0, '', '#16A085'),
(9, 'ICT205', 'Python', 2, 5, 6, 30, 0, '', '#8E44AD'),
(10, 'ICT207', 'Java', 2, 2, 6, 60, 0, '', '#27AE60'),
(11, 'ICT217', 'Spécialité GL', 2, 1, 4, 30, 0, '', '#E74C3C'),
(12, 'ICT213', 'Spécialité Réseau', 2, 2, 4, 30, 0, '', '#E74C3C'),
(13, 'ICT215', 'Spécialité Sécu', 2, 2, 4, 30, 0, '', '#E74C3C'),
(14, 'ENG204', 'Anglais', 2, 3, 6, 60, 0, '', '#9B59B6'),
(15, 'FRAN204', 'Français', 2, 5, 6, 60, 0, '', '#9B59B6'),
(16, 'ICT301', 'Algorithmique Avancés', 3, 1, 5, 45, 0, '', '#1ABC9C'),
(17, 'ICT303', 'BDD', 3, 3, 5, 45, 0, '', '#E67E22'),
(18, 'ICT305', 'Dotnet', 3, 4, 4, 30, 0, '', '#34495E'),
(19, 'ICT307', 'POO', 3, 4, 5, 45, 0, '', '#16A085'),
(20, 'ICT313', 'Spécialité Réseau', 3, 2, 4, 30, 0, '', '#8E44AD'),
(21, 'ICT315', 'Spécialité Sécu', 3, 5, 4, 30, 0, '', '#8E44AD'),
(22, 'ICT317', 'Spécialité GL', 3, 1, 4, 30, 0, '', '#8E44AD'),
(23, 'FRAN304', 'Français', 3, 5, 6, 60, 0, '', '#27AE60'),
(24, 'ENG304', 'Anglais', 3, 2, 6, 60, 0, '', '#9B59B6');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `id_utilisateur` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `matricule` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `role` enum('admin','enseignant','etudiant') DEFAULT NULL,
  `date_creation` datetime DEFAULT NULL,
  `actif` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id_utilisateur`, `nom`, `matricule`, `email`, `role`, `date_creation`, `actif`) VALUES
(1, 'Kouandou Aboubakar', 'ENS2023001', 'abou5@universite.com', 'enseignant', NULL, 1),
(2, 'Martin Claire', 'ENS2023002', 'claire.martin@universite.com', 'enseignant', NULL, 1),
(3, 'Bernard Pierre', 'ENS2023003', 'pierre.bernard@universite.com', 'enseignant', NULL, 1),
(4, 'Nkondock Mi Bahana', 'ENS2023004', 'bahana7@universite.com', 'enseignant', NULL, 1),
(5, 'Roux Alain', 'ENS2023005', 'alain.roux@universite.fr', 'enseignant', NULL, 1),
(6, 'Durand Marie', 'ETU2023001', 'durand@universite.com', 'etudiant', NULL, 1),
(7, 'Petit Thomas', 'ETU2023002', 'petit@universite.com', 'etudiant', NULL, 1),
(8, 'Moreau Alice', 'ETU2023003', 'moreau@universite.com', 'etudiant', NULL, 1),
(9, 'Lefebvre Julien', 'ETU2023004', 'lefebvre@universite.com', 'etudiant', NULL, 1),
(10, 'Garcia Camille', 'ETU2023005', 'garcia@universite.com', 'etudiant', NULL, 1);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`),
  ADD UNIQUE KEY `emailC` (`emailC`),
  ADD UNIQUE KEY `mot_de_passe` (`mot_de_passe`),
  ADD KEY `id_departement` (`id_departement`);

--
-- Index pour la table `alert`
--
ALTER TABLE `alert`
  ADD PRIMARY KEY (`id_alert`),
  ADD KEY `id_classe` (`id_classe`),
  ADD KEY `id_utilisateur` (`id_utilisateur`);

--
-- Index pour la table `classe`
--
ALTER TABLE `classe`
  ADD PRIMARY KEY (`id_classe`),
  ADD KEY `id_filiere` (`id_filiere`);

--
-- Index pour la table `configuration`
--
ALTER TABLE `configuration`
  ADD PRIMARY KEY (`id_config`),
  ADD UNIQUE KEY `cle` (`cle`);

--
-- Index pour la table `cours_salle`
--
ALTER TABLE `cours_salle`
  ADD PRIMARY KEY (`id_cours_salle`),
  ADD KEY `uk_cours_salle` (`id_ue`,`id_salle`),
  ADD KEY `idx_salle_cours` (`id_salle`,`id_ue`);

--
-- Index pour la table `creneau`
--
ALTER TABLE `creneau`
  ADD PRIMARY KEY (`id_creneau`),
  ADD KEY `id_salle` (`id_salle`),
  ADD KEY `id_seance` (`id_seance`),
  ADD KEY `id_ue` (`id_ue`);

--
-- Index pour la table `departement`
--
ALTER TABLE `departement`
  ADD PRIMARY KEY (`id_departement`);

--
-- Index pour la table `enseignant`
--
ALTER TABLE `enseignant`
  ADD PRIMARY KEY (`id_enseignant`),
  ADD UNIQUE KEY `id_utilisateur` (`id_utilisateur`),
  ADD UNIQUE KEY `email_ens` (`email_ens`),
  ADD UNIQUE KEY `matricule_ens` (`matricule_ens`),
  ADD KEY `idx_enseignant_dep` (`id_departement`);

--
-- Index pour la table `etudiant`
--
ALTER TABLE `etudiant`
  ADD PRIMARY KEY (`id_etudiant`),
  ADD UNIQUE KEY `id_utilisateur` (`id_utilisateur`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `id_classe` (`id_classe`),
  ADD KEY `idx_etudiant_classe` (`id_classe`);

--
-- Index pour la table `filiere`
--
ALTER TABLE `filiere`
  ADD PRIMARY KEY (`id_filiere`),
  ADD UNIQUE KEY `code_filiere` (`code_filiere`),
  ADD KEY `id_departement` (`id_departement`);

--
-- Index pour la table `salle`
--
ALTER TABLE `salle`
  ADD PRIMARY KEY (`id_salle`),
  ADD UNIQUE KEY `code_salle` (`code_salle`),
  ADD KEY `id_departement` (`id_departement`),
  ADD KEY `idx_salle_departement` (`id_departement`);

--
-- Index pour la table `seance`
--
ALTER TABLE `seance`
  ADD PRIMARY KEY (`id_seance`),
  ADD KEY `idx_seance_date` (`date_seance`),
  ADD KEY `idx_seance_ue` (`id_ue`),
  ADD KEY `idx_seance_enseignant` (`id_enseignant`),
  ADD KEY `idx_seance_salle` (`id_salle`),
  ADD KEY `idx_seance_classe` (`id_classe`);

--
-- Index pour la table `ues`
--
ALTER TABLE `ues`
  ADD PRIMARY KEY (`id_ue`),
  ADD UNIQUE KEY `code_ue` (`code_ue`),
  ADD KEY `id_classe` (`id_classe`),
  ADD KEY `id_enseignant` (`id_enseignant`),
  ADD KEY `idx_cours_classe` (`id_classe`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`id_utilisateur`),
  ADD UNIQUE KEY `matricule` (`matricule`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `alert`
--
ALTER TABLE `alert`
  MODIFY `id_alert` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `classe`
--
ALTER TABLE `classe`
  MODIFY `id_classe` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `configuration`
--
ALTER TABLE `configuration`
  MODIFY `id_config` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `cours_salle`
--
ALTER TABLE `cours_salle`
  MODIFY `id_cours_salle` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `creneau`
--
ALTER TABLE `creneau`
  MODIFY `id_creneau` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `departement`
--
ALTER TABLE `departement`
  MODIFY `id_departement` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `enseignant`
--
ALTER TABLE `enseignant`
  MODIFY `id_enseignant` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT pour la table `etudiant`
--
ALTER TABLE `etudiant`
  MODIFY `id_etudiant` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `filiere`
--
ALTER TABLE `filiere`
  MODIFY `id_filiere` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
