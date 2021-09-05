-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 16 mars 2021 à 15:07
-- Version du serveur :  10.4.17-MariaDB
-- Version de PHP : 8.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `annonceo`
--

-- --------------------------------------------------------

--
-- Structure de la table `annonce`
--

CREATE TABLE `annonce` (
  `id_annonce` int(3) NOT NULL,
  `titre` varchar(255) NOT NULL,
  `description_courte` varchar(255) NOT NULL,
  `description_longue` text NOT NULL,
  `prix` int(6) NOT NULL,
  `photo` varchar(200) NOT NULL,
  `pays` varchar(20) NOT NULL,
  `ville` varchar(20) NOT NULL,
  `adresse` varchar(50) NOT NULL,
  `cp` int(5) NOT NULL,
  `membre_id` int(3) DEFAULT NULL,
  `photo_id` int(3) DEFAULT NULL,
  `categorie_id` int(3) NOT NULL,
  `date_enregistrement` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `annonce`
--

INSERT INTO `annonce` (`id_annonce`, `titre`, `description_courte`, `description_longue`, `prix`, `photo`, `pays`, `ville`, `adresse`, `cp`, `membre_id`, `photo_id`, `categorie_id`, `date_enregistrement`) VALUES
(26, 'Lion a vendre', 'Lion sympa', 'Lion en bon etat qui vient direct de la savane', 15000, '20210306192210-970-frida-bredesen-IxlY2KB4Krs-unsplash.jpg', 'Espagne', 'paris', '5 rue de provence', 94800, 19, 23, 11, '2021-03-06 19:22:10'),
(27, 'Belles bagues', 'un lot de bague', 'de très jolies bagues très peu porter', 1000, '20210306194646-826-bague5.jpg', 'France', 'paris', '6 allee germinal', 91210, 20, 24, 10, '2021-03-06 19:46:46'),
(41, 'playstation 5', 'playstation 5 avec 2 manette et tout les jeux existant', 'Vous ne la trouverez nulle part', 1000, '20210311150439-333-20210306160707-699-play5.webp', 'France', 'paris', '18 avenue des tilleuls', 94320, 22, 34, 6, '2021-03-11 15:04:39'),
(42, 'tableau d\'art', 'un faux tableau mais bien imité', 'en fait c\'est une photo que j\'ai collé', 250, '20210311173845-364-31056991-29406133.jpg', 'France', 'paris', '134 Rue d\'Aubervilliers', 75019, 22, 35, 9, '2021-03-11 17:38:45'),
(43, 'tshirt', 'tshirt sale', 'tshirt tres sale', 50, '20210313200303-863-téléchargement.jfif', 'France', 'paris', '5 rue de provence', 94800, 19, 36, 10, '2021-03-13 20:03:03'),
(44, 'rergergerg', 'aergaregaerg', 'regaerg', 1, '20210313203417-201-shingeki-no-kyojin-logo.png', 'France', 'Allemagne', '8 Rue Charles Darwin', 91210, 19, 37, 6, '2021-03-13 20:34:17');

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

CREATE TABLE `categorie` (
  `id_categorie` int(3) NOT NULL,
  `titres` varchar(255) NOT NULL,
  `motcles` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `categorie`
--

INSERT INTO `categorie` (`id_categorie`, `titres`, `motcles`) VALUES
(1, 'Emploi', 'Offre d\'emploi'),
(2, 'Vehicule', 'Voitures, Motos, Bateaux, Vélos, Equipement'),
(3, 'Immobilier', 'Ventes, Locations, Colocations, Bureaux, Logement '),
(4, 'Vacances', 'Camping, Hotels, Hôte'),
(5, 'Multimedia', 'Jeux Vidéos, Informatique, Image, Son, Téléphone'),
(6, 'Loisirs', 'Films, Musique, Livres'),
(7, 'Materiel', 'Outillage, Fourniture de Bureau, Matériel Agricole'),
(8, 'Services', 'Prestations de services, Evénements'),
(9, 'Maison', 'Ameublement, Electroménager, Bricolage, Jardinage'),
(10, 'Vetements', 'Jean, Chemise, Robe, Chaussure, ...'),
(11, 'Autres', '');

-- --------------------------------------------------------

--
-- Structure de la table `commentaire`
--

CREATE TABLE `commentaire` (
  `id_commentaire` int(3) NOT NULL,
  `membre_id` int(3) NOT NULL,
  `annonce_id` int(3) NOT NULL,
  `commentaire` text NOT NULL,
  `date_enregistrement` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `commentaire`
--

INSERT INTO `commentaire` (`id_commentaire`, `membre_id`, `annonce_id`, `commentaire`, `date_enregistrement`) VALUES
(21, 19, 41, 'super vendeur', '2021-03-11 15:30:45'),
(22, 22, 26, 'lion sympa', '2021-03-11 15:53:17'),
(23, 19, 42, 'un vrai faux superbe', '2021-03-11 18:14:22'),
(24, 19, 27, 'top', '2021-03-11 19:45:15'),
(25, 23, 26, 'super', '2021-03-14 15:17:31'),
(26, 23, 27, 'super', '2021-03-14 15:18:25');

-- --------------------------------------------------------

--
-- Structure de la table `membre`
--

CREATE TABLE `membre` (
  `id_membre` int(3) NOT NULL,
  `pseudo` varchar(200) NOT NULL,
  `mdp` varchar(255) NOT NULL,
  `nom` varchar(200) NOT NULL,
  `prenom` varchar(200) NOT NULL,
  `telephone` varchar(200) NOT NULL,
  `email` varchar(255) NOT NULL,
  `civilite` enum('m','f') NOT NULL,
  `statut` int(1) NOT NULL,
  `date_enregistrement` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `membre`
--

INSERT INTO `membre` (`id_membre`, `pseudo`, `mdp`, `nom`, `prenom`, `telephone`, `email`, `civilite`, `statut`, `date_enregistrement`) VALUES
(6, 'melka', '$2y$10$jDrTeIf6645tFFTlR6QmP.RGfHm0l5MSR4P.qaAuRON/XsEwHcATu', 'Chalal', 'Camel', '0651179731', 'camel.chalal@gmail.com', 'm', 2, '2021-02-25 14:33:50'),
(19, 'samiha24', '$2y$10$6hmuGbeOSSDRN2mmJatDGeZatJD7KnDimhy66iKiZQezJF2Qehp/.', 'samiha', 'samiha', '0606060606', 'samiha@gmail.com', 'f', 1, '2021-03-02 13:23:04'),
(20, 'sam', '$2y$10$qYy2NBK3c.8m9436x4G3ku/MfrVK7AGorg4M9KUsgpFteA7T2MsPG', 'Vinciguerra', 'Estelle', '0707070707', 'Vinciguerra.stellam@gmail.com', 'f', 1, '2021-03-04 11:00:10'),
(22, 'so', '$2y$10$t37xu9bcV1celbp/bNJ0Qe9xSUJt2aYA5dp5ZX5IrMsNXBy9hkK6y', 'sofian', 'el fares', '06061218451', 'sofian@gmail.com', 'm', 1, '2021-03-06 16:00:50'),
(23, 'samir', '$2y$10$GXeZI0a6aDy2wsvarO27NeSe1LPTJtb2Js/shguz2EDlsk/gB0KNu', 'Chalal', 'Samir', '0651108737', 'samir.chalal@outlook.com', 'm', 1, '2021-03-14 15:15:57');

-- --------------------------------------------------------

--
-- Structure de la table `note`
--

CREATE TABLE `note` (
  `id_note` int(3) NOT NULL,
  `membre_id1` int(3) NOT NULL,
  `membre_id2` int(3) NOT NULL,
  `note` int(3) NOT NULL,
  `date_enregistrement` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `note`
--

INSERT INTO `note` (`id_note`, `membre_id1`, `membre_id2`, `note`, `date_enregistrement`) VALUES
(6, 22, 19, 5, '2021-03-09 19:47:16'),
(7, 22, 20, 3, '2021-03-09 19:47:22'),
(11, 19, 22, 5, '2021-03-11 18:44:35'),
(12, 22, 22, 4, '2021-03-11 19:04:27'),
(13, 20, 22, 1, '2021-03-11 19:45:48'),
(14, 20, 19, 2, '2021-03-11 19:45:57'),
(15, 20, 19, 5, '2021-03-13 16:38:44'),
(16, 20, 19, 5, '2021-03-13 16:39:01'),
(17, 20, 19, 5, '2021-03-13 16:39:24'),
(18, 23, 20, 5, '2021-03-14 15:19:07');

-- --------------------------------------------------------

--
-- Structure de la table `photo`
--

CREATE TABLE `photo` (
  `id_photo` int(3) NOT NULL,
  `photo1` varchar(255) NOT NULL,
  `photo2` varchar(255) NOT NULL,
  `photo3` varchar(255) NOT NULL,
  `photo4` varchar(255) NOT NULL,
  `photo5` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `photo`
--

INSERT INTO `photo` (`id_photo`, `photo1`, `photo2`, `photo3`, `photo4`, `photo5`) VALUES
(21, '20210306111533-99-wexor-tmg-L-2p8fapOA8-unsplash.jpg', '', '', '', ''),
(22, '20210306160707-699-play5.webp', ' ', ' ', ' ', ' '),
(23, '20210306192210-743-arleen-wiese-2vbhN2Yjb3A-unsplash.jpg', '20210306192210-970-frida-bredesen-IxlY2KB4Krs-unsplash.jpg', '', '', ''),
(24, '20210306194646-463-bague1.jpg', '20210306194646-151-bague2.jpg', '', '20210306194646-175-bague4.jpg', '20210306194646-826-bague5.jpg'),
(25, '20210306194820-568-gwen-weustink-I3C1sSXj1i8-unsplash.jpg', '20210306194820-178-jeremy-bishop-hppWAs2WTZU-unsplash.jpg', '20210306194820-199-wexor-tmg-L-2p8fapOA8-unsplash.jpg', '', ''),
(26, '20210306195148-745-play5.webp', '', '', '', ''),
(27, '20210306233807-643-Moi.png', '', '', '', ''),
(28, '20210306233844-316-jeremy-bishop-hppWAs2WTZU-unsplash.jpg', '', '', '', ''),
(29, '20210307105929-475-31056991-29406133.jpg', ' ', ' ', ' ', ' '),
(30, '20210307105952-320-31056991-29406133.jpg', ' ', ' ', ' ', ' '),
(31, '20210307110554-461-31056991-29406133.jpg', '20210307110554-436-sunset-over-lake-2-1377767.jpg', ' ', ' ', ' '),
(32, '20210307110955-791-31056991-29406133.jpg', '20210307110955-520-sunset-over-lake-2-1377767.jpg', '', '', ''),
(33, '20210308114339-933-31056991-29406133.jpg', '20210308114339-633-sunset-over-lake-2-1377767.jpg', '', '', ''),
(34, '20210311150439-333-20210306160707-699-play5.webp', '', '', '', ''),
(35, '20210311173845-364-31056991-29406133.jpg', '', '', '', ''),
(36, '20210313200303-863-téléchargement.jfif', '', '', '', ''),
(37, '20210313203417-201-shingeki-no-kyojin-logo.png', '', '', '', '');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `annonce`
--
ALTER TABLE `annonce`
  ADD PRIMARY KEY (`id_annonce`),
  ADD KEY `membre_id` (`membre_id`),
  ADD KEY `photo_id` (`photo_id`),
  ADD KEY `categorie_id` (`categorie_id`);

--
-- Index pour la table `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`id_categorie`);

--
-- Index pour la table `commentaire`
--
ALTER TABLE `commentaire`
  ADD PRIMARY KEY (`id_commentaire`),
  ADD KEY `membre_id` (`membre_id`),
  ADD KEY `annonce_id` (`annonce_id`);

--
-- Index pour la table `membre`
--
ALTER TABLE `membre`
  ADD PRIMARY KEY (`id_membre`);

--
-- Index pour la table `note`
--
ALTER TABLE `note`
  ADD PRIMARY KEY (`id_note`),
  ADD KEY `membre_id1` (`membre_id1`),
  ADD KEY `membre_id2` (`membre_id2`);

--
-- Index pour la table `photo`
--
ALTER TABLE `photo`
  ADD PRIMARY KEY (`id_photo`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `annonce`
--
ALTER TABLE `annonce`
  MODIFY `id_annonce` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT pour la table `categorie`
--
ALTER TABLE `categorie`
  MODIFY `id_categorie` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pour la table `commentaire`
--
ALTER TABLE `commentaire`
  MODIFY `id_commentaire` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT pour la table `membre`
--
ALTER TABLE `membre`
  MODIFY `id_membre` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT pour la table `note`
--
ALTER TABLE `note`
  MODIFY `id_note` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT pour la table `photo`
--
ALTER TABLE `photo`
  MODIFY `id_photo` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `annonce`
--
ALTER TABLE `annonce`
  ADD CONSTRAINT `annonce_ibfk_1` FOREIGN KEY (`membre_id`) REFERENCES `membre` (`id_membre`),
  ADD CONSTRAINT `annonce_ibfk_2` FOREIGN KEY (`photo_id`) REFERENCES `photo` (`id_photo`),
  ADD CONSTRAINT `annonce_ibfk_3` FOREIGN KEY (`categorie_id`) REFERENCES `categorie` (`id_categorie`);

--
-- Contraintes pour la table `commentaire`
--
ALTER TABLE `commentaire`
  ADD CONSTRAINT `commentaire_ibfk_1` FOREIGN KEY (`membre_id`) REFERENCES `membre` (`id_membre`),
  ADD CONSTRAINT `commentaire_ibfk_2` FOREIGN KEY (`annonce_id`) REFERENCES `annonce` (`id_annonce`);

--
-- Contraintes pour la table `note`
--
ALTER TABLE `note`
  ADD CONSTRAINT `note_ibfk_1` FOREIGN KEY (`membre_id1`) REFERENCES `membre` (`id_membre`),
  ADD CONSTRAINT `note_ibfk_2` FOREIGN KEY (`membre_id2`) REFERENCES `membre` (`id_membre`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
