-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:8889
-- Généré le : mer. 31 déc. 2025 à 13:33
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
-- Base de données : `Meet-Eat`
--

-- --------------------------------------------------------

--
-- Structure de la table `centre_interet`
--

CREATE TABLE `centre_interet` (
  `id_interet` int NOT NULL,
  `libelle` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `discussion`
--

CREATE TABLE `discussion` (
  `id_discussion` int NOT NULL,
  `type_discussion` varchar(20) DEFAULT NULL,
  `id_session` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `participant_discussion`
--

CREATE TABLE `participant_discussion` (
  `id_discussion` int NOT NULL,
  `id_user` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `quiz_amitie`
--

CREATE TABLE `quiz_amitie` (
  `id_question` int NOT NULL,
  `question` text NOT NULL,
  `choix_1` varchar(255) DEFAULT NULL,
  `choix_2` varchar(255) DEFAULT NULL,
  `choix_3` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `quiz_amitie`
--

INSERT INTO `quiz_amitie` (`id_question`, `question`, `choix_1`, `choix_2`, `choix_3`) VALUES
(1, 'Quel type d’activité préfères‑tu pour rencontrer de nouveaux amis ?', 'Cuisiner ensemble et partager un repas.', 'Aller dans un café ou un restaurant pour discuter.', 'Participer à un événement ou une sortie originale.'),
(2, 'Comment décrirais‑tu ton rapport à la cuisine ?', 'J’adore cuisiner et tester de nouvelles recettes.', 'Je cuisine un peu, surtout des plats simples.', 'Je préfère manger dehors ou me faire livrer.'),
(3, 'Quelle ambiance recherches‑tu avec un ami ?', 'Détendue et amusante, beaucoup de rires.', 'Calme et posée, pour de vraies discussions.', 'Flexible, selon la situation et le feeling.'),
(4, 'Quelles qualités apprécies‑tu chez un ami ?', 'Humour et complicité.', 'Fiabilité et soutien.', 'Ouverture et écoute.'),
(5, 'Comment gères‑tu tes habitudes alimentaires ?', 'Vegan, végétarien, sans gluten ou autre régime spécifique.', 'Je mange un peu de tout mais j’ai des préférences.', 'Je suis flexible, pas de restrictions.'),
(6, 'À quelle fréquence manges‑tu dehors ?', 'Presque tous les jours.', 'Quelques fois par semaine.', 'Rarement, je préfère cuisiner à la maison.'),
(7, 'Quel type de cuisine préfères‑tu partager avec un ami ?', 'Cuisine traditionnelle / maison.', 'Cuisine du monde / exotique.', 'Peu importe, je m’adapte.'),
(8, 'Es-tu plutôt sucré ou salé ?', 'Sucré.', 'Salé.', 'Les deux, selon l’humeur.'),
(9, 'Quelle importance accordes‑tu à cuisiner avec un ami ?', 'Très important, j’aime partager ce moment.', 'Plutôt important, mais pas essentiel.', 'Pas important, je préfère juste manger ensemble.'),
(10, 'À quelle fréquence aimes‑tu voir tes amis ?', 'Très souvent, plusieurs fois par semaine.', 'Quelques fois par mois.', 'Rarement, quand l’occasion se présente.'),
(11, 'Comment décrirais‑tu ton style de communication avec les amis ?', 'Direct et ouvert, j’aime parler de tout.', 'Réfléchi et calme, j’écoute beaucoup avant de parler.', 'Flexible, selon la situation et la personne.'),
(12, 'Qu’attends‑tu d’une amitié ?', 'Moments fun et complicité.', 'Soutien et confiance mutuelle.', 'Écoute et respect des différences.'),
(13, 'Quel rôle joue la spontanéité dans tes amitiés ?', 'Très important, j’aime les surprises et les moments inattendus.', 'Plutôt important, mais je préfère un minimum d’organisation.', 'Pas très important, je préfère planifier nos rencontres.'),
(14, 'Comment aimes‑tu rencontrer de nouveaux amis ?', 'Activités partagées comme cuisiner ou participer à un événement.', 'Discussions autour d’un café ou d’un repas.', 'Peu importe, l’important est de créer du lien.'),
(15, 'Préfères‑tu rencontrer des amis en petit comité ou en groupe ?', 'Petit comité, 2 à 3 personnes.', 'Groupe moyen, 4 à 6 personnes.', 'Groupe plus large, 7 à 10 personnes.'),
(16, 'Comment gères‑tu les premiers contacts avec de nouveaux amis ?', 'Je préfère discuter en groupe avant de se rencontrer.', 'Je préfère parler directement en tête-à-tête.', 'Je suis flexible selon la situation.'),
(17, 'Quelle importance accordes‑tu aux photos sur un profil d’ami ?', 'Très importante, plusieurs photos pour mieux connaître la personne.', 'Moyennement importante, une photo suffit.', 'Pas très importante, les informations comptent plus.'),
(18, 'Comment préfères‑tu organiser une rencontre amicale ?', 'Je préfère réserver un restaurant ou organiser une activité à l’avance.', 'Je suis flexible, mais j’aime avoir une idée générale du plan.', 'Je préfère improviser et décider le jour même.'),
(19, 'Quel rôle joue la participation active dans la cuisine pour toi ?', 'Très important, j’adore cuisiner avec mes amis.', 'Plutôt important, mais je peux m’adapter.', 'Pas important, je préfère observer ou juste partager le repas.'),
(20, 'Comment aimerais‑tu que le groupe fonctionne après la rencontre ?', 'Le groupe continue de discuter et de partager même après la rencontre.', 'Le groupe sert juste à organiser la rencontre et disparaît ensuite.', 'Je suis flexible, ça dépend de la dynamique du groupe.');

-- --------------------------------------------------------

--
-- Structure de la table `quiz_amour`
--

CREATE TABLE `quiz_amour` (
  `id_question` int NOT NULL,
  `question` text NOT NULL,
  `choix_1` varchar(255) DEFAULT NULL,
  `choix_2` varchar(255) DEFAULT NULL,
  `choix_3` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `quiz_amour`
--

INSERT INTO `quiz_amour` (`id_question`, `question`, `choix_1`, `choix_2`, `choix_3`) VALUES
(1, 'À quoi ressemble pour toi le rendez-vous parfait ?', 'Cuisiner ensemble un plat pour apprendre à se connaître.', 'Dîner dans un restaurant sympa et discuter tranquillement.', 'Un mélange des deux : cuisiner un peu, puis partager le repas.'),
(2, 'Comment décrirais-tu ton rapport à la cuisine ?', 'J’adore cuisiner et tester de nouvelles recettes.', 'Je cuisine un peu, surtout des plats simples.', 'Je préfère manger dehors ou me faire livrer.'),
(3, 'Quelle ambiance préfères-tu pour un rendez-vous ?', 'Détendue et amusante, beaucoup de rires.', 'Romantique et calme, pour profiter d’un moment intime.', 'Flexible, selon le feeling et la personne.'),
(4, 'Quelles valeurs recherches-tu chez un partenaire ?', 'Complicité et humour.', 'Ambition et projets communs.', 'Écoute et compréhension.'),
(5, 'Comment gères-tu tes habitudes alimentaires ?', 'Vegan, végétarien, sans gluten ou autre régime spécifique.', 'Je mange un peu de tout mais j’ai des préférences.', 'Je suis flexible, pas de restrictions.'),
(6, 'À quelle fréquence manges-tu dehors ?', 'Presque tous les jours.', 'Quelques fois par semaine.', 'Rarement, je préfère cuisiner à la maison.'),
(7, 'Quel type de cuisine préfères-tu ?', 'Cuisine traditionnelle / maison.', 'Cuisine du monde / exotique.', 'Peu importe, je m’adapte.'),
(8, 'Es-tu plutôt sucré ou salé ?', 'Sucré.', 'Salé.', 'Les deux, selon l’humeur.'),
(9, 'Quelle importance accordes-tu à cuisiner avec quelqu’un ?', 'Très important, j’aime partager ce moment.', 'Plutôt important, mais pas essentiel.', 'Pas important, je préfère manger directement.'),
(10, 'Quelle fréquence de sorties ou de rendez-vous préfères-tu ?', 'Régulièrement, plusieurs fois par semaine.', 'Occasionnellement, une ou deux fois par semaine.', 'Rarement, quand l’occasion se présente.'),
(11, 'Comment décrirais-tu ton style de communication ?', 'Direct et ouvert, j’aime parler de tout.', 'Réfléchi et calme, j’écoute beaucoup avant de parler.', 'Flexible, selon la personne et la situation.'),
(12, 'Qu’attends-tu d’une relation amoureuse ?', 'Complicité, amusement et moments partagés.', 'Engagement et projets communs.', 'Respect, soutien et compréhension mutuelle.'),
(13, 'Quel rôle joue la spontanéité pour toi ?', 'Très important, j’aime les surprises et les moments inattendus.', 'Plutôt important, mais je préfère un minimum d’organisation.', 'Pas très important, je préfère planifier les rendez-vous.'),
(14, 'Comment aimes-tu rencontrer quelqu’un ?', 'Activités partagées comme cuisiner ou participer à un événement.', 'Dîner ou café pour discuter calmement.', 'Peu importe, l’important est la connexion.'),
(15, 'Préfères-tu les rendez-vous en petit comité ou en groupe ?', 'Petit comité, un ou deux participants maximum.', 'Groupe moyen, 3 à 5 personnes.', 'Groupe plus large, 6 à 10 personnes.'),
(16, 'Comment gères-tu les premiers contacts ?', 'Je préfère discuter en groupe avant le rendez-vous.', 'Je préfère parler directement en tête-à-tête.', 'Je suis flexible, selon le contexte.'),
(17, 'Quelle importance accordes-tu aux photos sur un profil ?', 'Très importante, j’aime voir plusieurs photos pour me faire une idée.', 'Moyennement importante, une photo suffit.', 'Pas très importante, les informations sont plus importantes.'),
(18, 'Quelles informations aimerais-tu trouver sur le profil de quelqu’un ?', 'Ses goûts culinaires et habitudes alimentaires.', 'Ses centres d’intérêt et valeurs relationnelles.', 'Les deux, pour mieux le connaître.'),
(19, 'Es-tu à l’aise avec le partage de tes disponibilités ?', 'Oui, je préfère montrer mes créneaux disponibles pour organiser un rendez-vous.', 'Un peu, mais je veux garder une certaine flexibilité.', 'Non, je préfère que ce soit plus informel.'),
(20, 'Qu’est-ce qui te motive le plus à utiliser MeatEat ?', 'Rencontrer quelqu’un qui partage mes goûts culinaires.', 'Trouver une personne compatible pour une relation sérieuse.', 'Vivre une expérience originale et conviviale autour de la cuisine.');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `user_interet`
--

CREATE TABLE `user_interet` (
  `id_user` int NOT NULL,
  `id_interet` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- Index pour la table `quiz_amitie`
--
ALTER TABLE `quiz_amitie`
  ADD PRIMARY KEY (`id_question`);

--
-- Index pour la table `quiz_amour`
--
ALTER TABLE `quiz_amour`
  ADD PRIMARY KEY (`id_question`);

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
-- AUTO_INCREMENT pour la table `quiz_amitie`
--
ALTER TABLE `quiz_amitie`
  MODIFY `id_question` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT pour la table `quiz_amour`
--
ALTER TABLE `quiz_amour`
  MODIFY `id_question` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

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
