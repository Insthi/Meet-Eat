-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:8889
-- Généré le : mar. 30 déc. 2025 à 16:11
-- Version du serveur : 8.0.40
-- Version de PHP : 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `Meet&Eat`
--

-- --------------------------------------------------------

--
-- Structure de la table `centre_interet`
--

CREATE TABLE `centre_interet` (
  `id_interet` int NOT NULL,
  `libelle` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `commentaires`
--

CREATE TABLE `commentaires` (
  `id_commentaire` int NOT NULL,
  `id_restaurant` int NOT NULL,
  `nom_personne` varchar(150) NOT NULL,
  `date_commentaire` date NOT NULL,
  `commentaire` text,
  `note` tinyint NOT NULL
) ;

-- --------------------------------------------------------

--
-- Structure de la table `discussion`
--

CREATE TABLE `discussion` (
  `id_discussion` int NOT NULL,
  `type_discussion` varchar(20) DEFAULT NULL,
  `id_session` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `match_user`
--

CREATE TABLE `match_user` (
  `id_match` int NOT NULL,
  `id_user_1` int DEFAULT NULL,
  `id_user_2` int DEFAULT NULL,
  `id_session` int DEFAULT NULL,
  `date_match` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `message`
--

CREATE TABLE `message` (
  `id_message` int NOT NULL,
  `id_discussion` int DEFAULT NULL,
  `id_user` int DEFAULT NULL,
  `contenu` text,
  `date_envoi` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `paiement`
--

CREATE TABLE `paiement` (
  `id_paiement` int NOT NULL,
  `id_reservation` int DEFAULT NULL,
  `moyen_paiement` varchar(50) DEFAULT NULL,
  `montant` decimal(6,2) DEFAULT NULL,
  `date_paiement` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `participant_discussion`
--

CREATE TABLE `participant_discussion` (
  `id_discussion` int NOT NULL,
  `id_user` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `profil`
--

CREATE TABLE `profil` (
  `id_profil` int NOT NULL,
  `id_user` int DEFAULT NULL,
  `prenom` varchar(100) DEFAULT NULL,
  `nom` varchar(100) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `biographie` text,
  `date_naissance` date DEFAULT NULL,
  `pronoms` varchar(50) DEFAULT NULL,
  `orientation` varchar(50) DEFAULT NULL,
  `intention_relation` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `question_quiz`
--

CREATE TABLE `question_quiz` (
  `id_question` int NOT NULL,
  `question` text,
  `type_question` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `reponse_quiz`
--

CREATE TABLE `reponse_quiz` (
  `id_reponse` int NOT NULL,
  `id_user` int DEFAULT NULL,
  `id_question` int DEFAULT NULL,
  `valeur_reponse` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `reservation`
--

CREATE TABLE `reservation` (
  `id_reservation` int NOT NULL,
  `id_user` int DEFAULT NULL,
  `id_session` int DEFAULT NULL,
  `statut` varchar(50) DEFAULT NULL,
  `date_reservation` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `restaurant`
--

CREATE TABLE `restaurant` (
  `id_restaurant` int NOT NULL,
  `nom` varchar(150) DEFAULT NULL,
  `adresse` varchar(255) DEFAULT NULL,
  `type_cuisine` varchar(100) DEFAULT NULL,
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `restaurant`
--

INSERT INTO `restaurant` (`id_restaurant`, `nom`, `adresse`, `type_cuisine`, `description`) VALUES
(1, 'Dans le Noir ', '51 Rue Quincampoix, 75004 Paris', 'Cuisine française / expérience sensorielle', 'Dîner dans le noir complet pour éveiller les autres sens et vivre une expérience totalement différente de la restauration classique.'),
(2, 'Under the Sea', 'Rue du 4 Septembre, 92130 Issy-les-Moulineaux', 'Cuisine européenne moderne / immersif', 'Restaurant immersif avec ambiance sous-marine, projections et sons pour une sensation d’être « sous l’eau ».'),
(3, 'Jungle Palace', '12 Rue de la Fidélité, 75010 Paris', 'Cuisine maison & exotique / immersif', 'Ambiance jungle luxuriante et plats exotiques dans un décor étonnant et immersif.'),
(4, 'Bustronome', '2 Avenue Kléber, 75016 Paris', 'Cuisine française contemporaine / expérience panoramique', 'Restaurant gastronomique à bord d’un bus panoramique traversant Paris, avec vues sur les monuments.'),
(5, 'Bus Toqué', 'Paris (départs variables)', 'Cuisine gastronomique mobile', 'Dîner gastronomique dans un bus tout en visitant l’urbain parisien.'),
(6, 'Le Train Bleu', 'Gare de Lyon, Pl. Louis Armand, 75012 Paris', 'Cuisine française traditionnelle / historique', 'Salle Belle-Époque monumentale avec décor somptueux et cuisine française classique.'),
(7, 'Au Pied de Cochon', '6 Rue Coquillière, 75001 Paris', 'Brasserie française iconique', 'Brasserie parisienne ouverte 24/7, célèbre pour ses plats classiques et son ambiance animée.'),
(8, 'Sacrée Fleur Montmartre', '50 Rue de Clignancourt, 75018 Paris', 'Cuisine française moderne', 'Bistrot charmant dans Montmartre avec une sélection de plats créatifs.'),
(9, 'Pierre Sang', '6 Rue Gambey ou 55 Rue Oberkampf, 75011 Paris', 'Fusion franco-coréenne / moderne', 'Cuisine créative sans menu fixe, inspirée par la fusion des saveurs.'),
(10, 'Pierre Sang Express', '25 Rue Oberkampf, 75011 Paris', 'Cuisine coréenne / street-food raffinée', 'Version rapide et abordable du concept fusion Pierre Sang.'),
(11, 'Le Wagon Bleu', '7 Rue Boursault, 75017 Paris', 'Cuisine française & méditerranéenne / train historique', 'Dans un wagon d’Orient-Express rénové, ambiance rétro unique.'),
(12, 'La Grenouillère', '19 Rue de la Grenouillère, 62170 La Madelaine-sous-Montreuil', 'Haute cuisine française / gastronomique étoilé', 'Restaurant reconnu internationalement par le chef Alexandre Gauthier, cuisine inventive autour du terroir du Nord.'),
(13, 'Arborescence', '76 Rue de la Gare, 59170 Croix', 'Cuisine gastronomique créative', 'Cuisine poétique et inspirée par les éléments naturels, ambiance gastronomique contemporaine.'),
(14, 'Les Pieds Bleus (Troglodyte)', '20 bis Rue Foulques Nerra, 49350 Gennes-Val-de-Loire', 'Cuisine troglodyte & régionale', 'Repas dans des galeries souterraines avec spécialités d’Anjou comme les fouées cuits au feu de bois.'),
(15, 'Le Lieu Unique', '2 Rue de la Biscuiterie, 44000 Nantes', 'Cuisine contemporaine / ancien site industriel', 'Dans l’ancienne biscuiterie LU, ambiance industrielle et créative autour du repas.'),
(16, 'Alaska Brocante & Snack', 'Rennes', 'Cuisine bistrot / déco vintage', 'Bistrot installé dans une brocante rétro offrant un cadre original pour déjeuner ou dîner.'),
(17, 'La Table des Pionniers', 'Chamonix (au sommet, accessible en téléphérique)', 'Cuisine de montagne / expérience altitude', 'Repas avec vue panoramique spectaculaire sur les montagnes.'),
(18, 'Le Refuge du Goûter', 'Mont-Blanc (haute altitude)', 'Cuisine de montagne rustique', 'Restaurant d’altitude pour randonneurs, ambiance unique dans les Alpes.'),
(19, 'Bouchon lyonnais typique', 'Lyon', 'Cuisine lyonnaise traditionnelle', 'Petite salle conviviale mettant à l’honneur spécialités locales (quenelles, tablier de sapeur).'),
(20, 'Bouillabaisse portuaire', 'Marseille', 'Cuisine méditerranéenne & fruits de mer', 'Plusieurs adresses célèbres autour du vieux port pour déguster la bouillabaisse provençale.'),
(21, 'Cassoulet & spécialités sud-ouest', 'Toulouse', 'Cuisine régionale', 'Plats locaux traditionnels dans des restaurants toulousains typiques.'),
(22, 'Bar à vins & cannelés revisités', 'Bordeaux', 'Cuisine régionale & vins', 'Bars à vin branchés combinant dégustations de vins bordelais et cuisine créative.'),
(23, 'Cuisine niçoise en bord de mer', 'Nice', 'Cuisine méditerranéenne', 'Plats frais de la mer, socca, salade niçoise et autres spécialités.'),
(24, 'Winstub traditionnelle', 'Strasbourg', 'Cuisine alsacienne', 'Ambiance chaleureuse et plats typiques (choucroute, baeckeoffe) dans une winstub.'),
(25, 'Influences méditerranéennes & tapas modernes', 'Montpellier', 'Cuisine contemporaine méditerranéenne', 'Tapas & plats créatifs inspirés du sud de la France.'),
(26, 'Fruits de mer & surf-chic', 'Biarritz', 'Cuisine basque & océanique', 'Restaurateurs surf-chic avec produits de la mer ultra-frais.'),
(27, 'Gastronomie bourguignonne innovante', 'Dijon', 'Cuisine bourguignonne revisité', 'Plats traditionnels modernisés avec une touche créative.'),
(28, 'Cuisine portugaise réinventée', 'Paris/banlieue', 'Cuisine portugaise contemporaine', 'Cantines modernes proposant feijoada, cozido ou bacalhau revisités.'),
(29, 'Bouillon historique', 'Paris (Bouillon Julien)', 'Brasserie art nouveau', 'Parisien classique à prix abordable, décor art nouveau emblématique.');

-- --------------------------------------------------------

--
-- Structure de la table `session`
--

CREATE TABLE `session` (
  `id_session` int NOT NULL,
  `id_restaurant` int DEFAULT NULL,
  `date_session` date DEFAULT NULL,
  `heure_debut` time DEFAULT NULL,
  `heure_fin` time DEFAULT NULL,
  `capacite_max` int DEFAULT NULL,
  `prix` decimal(6,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id_user` int NOT NULL,
  `email` varchar(255) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `date_creation` datetime DEFAULT CURRENT_TIMESTAMP,
  `derniere_connexion` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `user_interet`
--

CREATE TABLE `user_interet` (
  `id_user` int NOT NULL,
  `id_interet` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `centre_interet`
--
ALTER TABLE `centre_interet`
  ADD PRIMARY KEY (`id_interet`);

--
-- Index pour la table `commentaires`
--
ALTER TABLE `commentaires`
  ADD PRIMARY KEY (`id_commentaire`),
  ADD KEY `id_restaurant` (`id_restaurant`);

--
-- Index pour la table `discussion`
--
ALTER TABLE `discussion`
  ADD PRIMARY KEY (`id_discussion`),
  ADD KEY `id_session` (`id_session`);

--
-- Index pour la table `match_user`
--
ALTER TABLE `match_user`
  ADD PRIMARY KEY (`id_match`),
  ADD KEY `id_user_1` (`id_user_1`),
  ADD KEY `id_user_2` (`id_user_2`),
  ADD KEY `id_session` (`id_session`);

--
-- Index pour la table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id_message`),
  ADD KEY `id_discussion` (`id_discussion`),
  ADD KEY `id_user` (`id_user`);

--
-- Index pour la table `paiement`
--
ALTER TABLE `paiement`
  ADD PRIMARY KEY (`id_paiement`),
  ADD UNIQUE KEY `id_reservation` (`id_reservation`);

--
-- Index pour la table `participant_discussion`
--
ALTER TABLE `participant_discussion`
  ADD PRIMARY KEY (`id_discussion`,`id_user`),
  ADD KEY `id_user` (`id_user`);

--
-- Index pour la table `profil`
--
ALTER TABLE `profil`
  ADD PRIMARY KEY (`id_profil`),
  ADD UNIQUE KEY `id_user` (`id_user`);

--
-- Index pour la table `question_quiz`
--
ALTER TABLE `question_quiz`
  ADD PRIMARY KEY (`id_question`);

--
-- Index pour la table `reponse_quiz`
--
ALTER TABLE `reponse_quiz`
  ADD PRIMARY KEY (`id_reponse`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_question` (`id_question`);

--
-- Index pour la table `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`id_reservation`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_session` (`id_session`);

--
-- Index pour la table `restaurant`
--
ALTER TABLE `restaurant`
  ADD PRIMARY KEY (`id_restaurant`);

--
-- Index pour la table `session`
--
ALTER TABLE `session`
  ADD PRIMARY KEY (`id_session`),
  ADD KEY `id_restaurant` (`id_restaurant`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Index pour la table `user_interet`
--
ALTER TABLE `user_interet`
  ADD PRIMARY KEY (`id_user`,`id_interet`),
  ADD KEY `id_interet` (`id_interet`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `centre_interet`
--
ALTER TABLE `centre_interet`
  MODIFY `id_interet` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `commentaires`
--
ALTER TABLE `commentaires`
  MODIFY `id_commentaire` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `discussion`
--
ALTER TABLE `discussion`
  MODIFY `id_discussion` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `match_user`
--
ALTER TABLE `match_user`
  MODIFY `id_match` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `message`
--
ALTER TABLE `message`
  MODIFY `id_message` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `paiement`
--
ALTER TABLE `paiement`
  MODIFY `id_paiement` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `profil`
--
ALTER TABLE `profil`
  MODIFY `id_profil` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `question_quiz`
--
ALTER TABLE `question_quiz`
  MODIFY `id_question` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `reponse_quiz`
--
ALTER TABLE `reponse_quiz`
  MODIFY `id_reponse` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `reservation`
--
ALTER TABLE `reservation`
  MODIFY `id_reservation` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `restaurant`
--
ALTER TABLE `restaurant`
  MODIFY `id_restaurant` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT pour la table `session`
--
ALTER TABLE `session`
  MODIFY `id_session` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `commentaires`
--
ALTER TABLE `commentaires`
  ADD CONSTRAINT `commentaires_ibfk_1` FOREIGN KEY (`id_restaurant`) REFERENCES `restaurant` (`id_restaurant`);

--
-- Contraintes pour la table `discussion`
--
ALTER TABLE `discussion`
  ADD CONSTRAINT `discussion_ibfk_1` FOREIGN KEY (`id_session`) REFERENCES `session` (`id_session`);

--
-- Contraintes pour la table `match_user`
--
ALTER TABLE `match_user`
  ADD CONSTRAINT `match_user_ibfk_1` FOREIGN KEY (`id_user_1`) REFERENCES `user` (`id_user`),
  ADD CONSTRAINT `match_user_ibfk_2` FOREIGN KEY (`id_user_2`) REFERENCES `user` (`id_user`),
  ADD CONSTRAINT `match_user_ibfk_3` FOREIGN KEY (`id_session`) REFERENCES `session` (`id_session`);

--
-- Contraintes pour la table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `message_ibfk_1` FOREIGN KEY (`id_discussion`) REFERENCES `discussion` (`id_discussion`),
  ADD CONSTRAINT `message_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`);

--
-- Contraintes pour la table `paiement`
--
ALTER TABLE `paiement`
  ADD CONSTRAINT `paiement_ibfk_1` FOREIGN KEY (`id_reservation`) REFERENCES `reservation` (`id_reservation`);

--
-- Contraintes pour la table `participant_discussion`
--
ALTER TABLE `participant_discussion`
  ADD CONSTRAINT `participant_discussion_ibfk_1` FOREIGN KEY (`id_discussion`) REFERENCES `discussion` (`id_discussion`),
  ADD CONSTRAINT `participant_discussion_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`);

--
-- Contraintes pour la table `profil`
--
ALTER TABLE `profil`
  ADD CONSTRAINT `profil_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`);

--
-- Contraintes pour la table `reponse_quiz`
--
ALTER TABLE `reponse_quiz`
  ADD CONSTRAINT `reponse_quiz_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`),
  ADD CONSTRAINT `reponse_quiz_ibfk_2` FOREIGN KEY (`id_question`) REFERENCES `question_quiz` (`id_question`);

--
-- Contraintes pour la table `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `reservation_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`),
  ADD CONSTRAINT `reservation_ibfk_2` FOREIGN KEY (`id_session`) REFERENCES `session` (`id_session`);

--
-- Contraintes pour la table `session`
--
ALTER TABLE `session`
  ADD CONSTRAINT `session_ibfk_1` FOREIGN KEY (`id_restaurant`) REFERENCES `restaurant` (`id_restaurant`);

--
-- Contraintes pour la table `user_interet`
--
ALTER TABLE `user_interet`
  ADD CONSTRAINT `user_interet_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`),
  ADD CONSTRAINT `user_interet_ibfk_2` FOREIGN KEY (`id_interet`) REFERENCES `centre_interet` (`id_interet`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
