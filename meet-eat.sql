-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:8889
-- Généré le : mer. 07 jan. 2026 à 21:29
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `centre_interet`
--

INSERT INTO `centre_interet` (`id_interet`, `libelle`) VALUES
(1, 'Gastronomie'),
(2, 'Musique'),
(3, 'Voyages'),
(4, 'Sport'),
(5, 'Cinéma');

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

--
-- Déchargement des données de la table `commentaires`
--

INSERT INTO `commentaires` (`id_commentaire`, `id_restaurant`, `nom_personne`, `date_commentaire`, `commentaire`, `note`) VALUES
(1, 1, 'Juliette', '2026-01-01', 'Super expérience dans le noir !', 5),
(2, 2, 'Test User', '2026-01-02', 'Super ambiance sous-marine !', 4);

-- --------------------------------------------------------

--
-- Structure de la table `discussion`
--

CREATE TABLE `discussion` (
  `id_discussion` int NOT NULL,
  `nom_groupe` varchar(150) DEFAULT NULL,
  `id_session` int DEFAULT NULL,
  `date_creation` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `discussion`
--

INSERT INTO `discussion` (`id_discussion`, `nom_groupe`, `id_session`, `date_creation`) VALUES
(1, 'Groupe Dans le Noir', NULL, '2026-01-02 18:43:31'),
(2, 'Groupe Under the Sea', NULL, '2026-01-02 18:44:15'),
(3, 'Chat Privé avec Lili', NULL, '2026-01-02 18:46:30');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `match_user`
--

INSERT INTO `match_user` (`id_match`, `id_user_1`, `id_user_2`, `id_session`, `date_match`) VALUES
(1, 1, 2, 1, '2026-01-02 18:47:34'),
(2, 1, 3, 2, '2026-01-02 18:47:34');

-- --------------------------------------------------------

--
-- Structure de la table `message`
--

CREATE TABLE `message` (
  `id_message` int NOT NULL,
  `id_discussion` int NOT NULL,
  `id_user` int NOT NULL,
  `contenu` text,
  `image_url` varchar(255) DEFAULT NULL,
  `date_envoi` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `message`
--

INSERT INTO `message` (`id_message`, `id_discussion`, `id_user`, `contenu`, `image_url`, `date_envoi`) VALUES
(1, 1, 2, 'Salut Juliette, tu viens au resto demain ?', NULL, '2026-01-02 18:46:30'),
(2, 3, 3, 'Coucou ! Je t envoie la photo du menu.', NULL, '2026-01-02 18:46:30'),
(3, 1, 2, 'Salut Juliette !', NULL, '2026-01-02 18:51:29'),
(4, 3, 3, 'Coucou !', NULL, '2026-01-02 18:51:29');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `participant_discussion`
--

CREATE TABLE `participant_discussion` (
  `id_discussion` int NOT NULL,
  `id_user` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `participant_discussion`
--

INSERT INTO `participant_discussion` (`id_discussion`, `id_user`) VALUES
(1, 1),
(2, 1),
(3, 1),
(1, 2),
(2, 3),
(3, 3);

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
  `bio` text,
  `biographie` text,
  `date_naissance` date DEFAULT NULL,
  `pronoms` varchar(50) DEFAULT NULL,
  `orientation` varchar(50) DEFAULT NULL,
  `intention_relation` varchar(50) DEFAULT NULL,
  `region` varchar(100) DEFAULT NULL,
  `metier` varchar(100) DEFAULT NULL,
  `religion` varchar(100) DEFAULT NULL,
  `origine` varchar(100) DEFAULT NULL,
  `type_relation` varchar(100) DEFAULT NULL,
  `genre` varchar(50) DEFAULT NULL,
  `ville` varchar(100) DEFAULT NULL,
  `taille` int DEFAULT NULL,
  `photo_url` varchar(255) DEFAULT 'default.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `profil`
--

INSERT INTO `profil` (`id_profil`, `id_user`, `prenom`, `nom`, `photo`, `bio`, `biographie`, `date_naissance`, `pronoms`, `orientation`, `intention_relation`, `region`, `metier`, `religion`, `origine`, `type_relation`, `genre`, `ville`, `taille`, `photo_url`) VALUES
(1, 1, 'Juliette', 'Moreau', 'IMAGES/default.png', 'Passionné de cuisine', 'test', '2003-12-02', 'elle', 'les-deux', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'default.jpg'),
(2, 2, 'test', 'testeur', 'IMAGES/default.png', 'Découvreur de saveurs', 'c\'est un test', '2003-09-19', 'il', 'Gay', NULL, 'Bordeau', 'Monteur vidéo', '', 'Français', 'Serieuse', NULL, NULL, NULL, 'default.jpg'),
(3, 3, 'lili', 'Lulu', 'IMAGES/default.png', 'Sportive et gourmande', 'Bonjour, c\'st l\'administrateur, ceci est un test faite pas gaffe. Vive la SF', '2003-01-15', 'elle', 'Hétéro', NULL, NULL, 'Monteur vidéo', 'Non renseigné', NULL, 'Serieuse', 'Homme', 'Paris', 185, 'profile_3_1767740923.jpg');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Structure de la table `reponse_quiz`
--

CREATE TABLE `reponse_quiz` (
  `id_reponse` int NOT NULL,
  `id_user` int NOT NULL,
  `id_question` int NOT NULL,
  `type_quiz` varchar(20) NOT NULL,
  `reponse` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `reservations`
--

CREATE TABLE `reservations` (
  `id_reservation` int NOT NULL,
  `id_user` int NOT NULL,
  `id_session` varchar(50) NOT NULL,
  `id_restaurant` int NOT NULL,
  `date_resa` date NOT NULL,
  `slot` varchar(100) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `restaurants`
--

CREATE TABLE `restaurants` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `typeCuisine` varchar(255) DEFAULT NULL,
  `desc` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `restaurants`
--

INSERT INTO `restaurants` (`id`, `name`, `address`, `typeCuisine`, `desc`) VALUES
(1, 'Dans le Noir ?', '51 Rue Quincampoix, 75004 Paris', 'Cuisine française / expérience sensorielle', 'Dîner dans le noir complet pour éveiller les autres sens et vivre une expérience totalement différente de la restauration classique.'),
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
(29, 'Bouillon historique', 'Paris (Bouillon Julien)', 'Brasserie art nouveau', 'Parisien classique à prix abordable, décor art nouveau emblématique.'),
(30, 'Holybelly', '19 Rue Lucien Sampaix, 75010 Paris', 'Brunch & coffee / gourmand', 'Brunch généreux, café de spécialité et vibes décontractées.'),
(31, 'Season', '1 Rue Dupetit-Thouars, 75003 Paris', 'Brunch healthy / bowls', 'Brunch vitaminé : avocado toast, bowls, jus frais et options veggie.'),
(32, 'Kozy Bosquet', '79 Avenue Bosquet, 75007 Paris', 'Brunch & pâtisserie / cosy', 'Brunch cosy avec pancakes, pâtisseries et boissons maison.');

-- --------------------------------------------------------

--
-- Structure de la table `restaurant_images`
--

CREATE TABLE `restaurant_images` (
  `id` int NOT NULL,
  `restaurant_id` int NOT NULL,
  `image_url` text NOT NULL,
  `ordre` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `restaurant_images`
--

INSERT INTO `restaurant_images` (`id`, `restaurant_id`, `image_url`, `ordre`) VALUES
(1, 1, 'assets/restaurants/1/1.png', 1),
(2, 1, 'assets/restaurants/1/2.png', 2),
(3, 1, 'assets/restaurants/1/3.png', 3),
(4, 2, 'assets/restaurants/2/1.png', 1),
(5, 2, 'assets/restaurants/2/2.png', 2),
(6, 2, 'assets/restaurants/2/3.png', 3),
(7, 3, 'assets/restaurants/3/1.png', 1),
(8, 3, 'assets/restaurants/3/2.png', 2),
(9, 3, 'assets/restaurants/3/3.png', 3),
(10, 4, 'assets/restaurants/4/1.png', 1),
(11, 4, 'assets/restaurants/4/2.png', 2),
(12, 4, 'assets/restaurants/4/3.png', 3),
(13, 5, 'assets/restaurants/5/1.png', 1),
(14, 5, 'assets/restaurants/5/2.png', 2),
(15, 5, 'assets/restaurants/5/3.png', 3),
(16, 6, 'assets/restaurants/6/1.png', 1),
(17, 6, 'assets/restaurants/6/2.png', 2),
(18, 6, 'assets/restaurants/6/3.png', 3),
(19, 7, 'assets/restaurants/7/1.png', 1),
(20, 7, 'assets/restaurants/7/2.png', 2),
(21, 7, 'assets/restaurants/7/3.png', 3),
(22, 8, 'assets/restaurants/8/1.png', 1),
(23, 8, 'assets/restaurants/8/2.png', 2),
(24, 8, 'assets/restaurants/8/3.png', 3),
(25, 9, 'assets/restaurants/9/1.png', 1),
(26, 9, 'assets/restaurants/9/2.png', 2),
(27, 9, 'assets/restaurants/9/3.png', 3),
(28, 10, 'assets/restaurants/10/1.png', 1),
(29, 10, 'assets/restaurants/10/2.png', 2),
(30, 10, 'assets/restaurants/10/3.png', 3),
(31, 11, 'assets/restaurants/11/1.png', 1),
(32, 11, 'assets/restaurants/11/2.png', 2),
(33, 11, 'assets/restaurants/11/3.png', 3),
(34, 12, 'assets/restaurants/12/1.png', 1),
(35, 12, 'assets/restaurants/12/2.png', 2),
(36, 12, 'assets/restaurants/12/3.png', 3),
(37, 13, 'assets/restaurants/13/1.png', 1),
(38, 13, 'assets/restaurants/13/2.png', 2),
(39, 13, 'assets/restaurants/13/3.png', 3),
(40, 14, 'assets/restaurants/14/1.png', 1),
(41, 14, 'assets/restaurants/14/2.png', 2),
(42, 14, 'assets/restaurants/14/3.png', 3),
(43, 15, 'assets/restaurants/15/1.png', 1),
(44, 15, 'assets/restaurants/15/2.png', 2),
(45, 15, 'assets/restaurants/15/3.png', 3),
(46, 16, 'assets/restaurants/16/1.png', 1),
(47, 16, 'assets/restaurants/16/2.png', 2),
(48, 16, 'assets/restaurants/16/3.png', 3),
(49, 17, 'assets/restaurants/17/1.png', 1),
(50, 17, 'assets/restaurants/17/2.png', 2),
(51, 17, 'assets/restaurants/17/3.png', 3),
(52, 18, 'assets/restaurants/18/1.png', 1),
(53, 18, 'assets/restaurants/18/2.png', 2),
(54, 18, 'assets/restaurants/18/3.png', 3),
(55, 19, 'assets/restaurants/19/1.png', 1),
(56, 19, 'assets/restaurants/19/2.png', 2),
(57, 19, 'assets/restaurants/19/3.png', 3),
(58, 20, 'assets/restaurants/20/1.png', 1),
(59, 20, 'assets/restaurants/20/2.png', 2),
(60, 20, 'assets/restaurants/20/3.png', 3),
(61, 21, 'assets/restaurants/21/1.png', 1),
(62, 21, 'assets/restaurants/21/2.png', 2),
(63, 21, 'assets/restaurants/21/3.png', 3),
(64, 22, 'assets/restaurants/22/1.png', 1),
(65, 22, 'assets/restaurants/22/2.png', 2),
(66, 22, 'assets/restaurants/22/3.png', 3),
(67, 23, 'assets/restaurants/23/1.png', 1),
(68, 23, 'assets/restaurants/23/2.png', 2),
(69, 23, 'assets/restaurants/23/3.png', 3),
(70, 24, 'assets/restaurants/24/1.png', 1),
(71, 24, 'assets/restaurants/24/2.png', 2),
(72, 24, 'assets/restaurants/24/3.png', 3),
(73, 25, 'assets/restaurants/25/1.png', 1),
(74, 25, 'assets/restaurants/25/2.png', 2),
(75, 25, 'assets/restaurants/25/3.png', 3),
(76, 26, 'assets/restaurants/26/1.png', 1),
(77, 26, 'assets/restaurants/26/2.png', 2),
(78, 26, 'assets/restaurants/26/3.png', 3),
(79, 27, 'assets/restaurants/27/1.png', 1),
(80, 27, 'assets/restaurants/27/2.png', 2),
(81, 27, 'assets/restaurants/27/3.png', 3),
(82, 28, 'assets/restaurants/28/1.png', 1),
(83, 28, 'assets/restaurants/28/2.png', 2),
(84, 28, 'assets/restaurants/28/3.png', 3),
(85, 29, 'assets/restaurants/29/1.png', 1),
(86, 29, 'assets/restaurants/29/2.png', 2),
(87, 29, 'assets/restaurants/29/3.png', 3),
(88, 30, 'assets/restaurants/30/1.png', 1),
(89, 30, 'assets/restaurants/30/2.png', 2),
(90, 30, 'assets/restaurants/30/3.png', 3),
(91, 31, 'assets/restaurants/31/1.png', 1),
(92, 31, 'assets/restaurants/31/2.png', 2),
(93, 31, 'assets/restaurants/31/3.png', 3),
(94, 32, 'assets/restaurants/32/1.png', 1),
(95, 32, 'assets/restaurants/32/2.png', 2),
(96, 32, 'assets/restaurants/32/3.png', 3),
(97, 1, 'assets/restaurants/1/1.png', 1),
(98, 1, 'assets/restaurants/1/2.png', 2),
(99, 1, 'assets/restaurants/1/3.png', 3),
(100, 2, 'assets/restaurants/2/1.png', 1),
(101, 2, 'assets/restaurants/2/2.png', 2),
(102, 2, 'assets/restaurants/2/3.png', 3),
(103, 3, 'assets/restaurants/3/1.png', 1),
(104, 3, 'assets/restaurants/3/2.png', 2),
(105, 3, 'assets/restaurants/3/3.png', 3),
(106, 4, 'assets/restaurants/4/1.png', 1),
(107, 4, 'assets/restaurants/4/2.png', 2),
(108, 4, 'assets/restaurants/4/3.png', 3),
(109, 5, 'assets/restaurants/5/1.png', 1),
(110, 5, 'assets/restaurants/5/2.png', 2),
(111, 5, 'assets/restaurants/5/3.png', 3),
(112, 6, 'assets/restaurants/6/1.png', 1),
(113, 6, 'assets/restaurants/6/2.png', 2),
(114, 6, 'assets/restaurants/6/3.png', 3),
(115, 7, 'assets/restaurants/7/1.png', 1),
(116, 7, 'assets/restaurants/7/2.png', 2),
(117, 7, 'assets/restaurants/7/3.png', 3),
(118, 8, 'assets/restaurants/8/1.png', 1),
(119, 8, 'assets/restaurants/8/2.png', 2),
(120, 8, 'assets/restaurants/8/3.png', 3),
(121, 9, 'assets/restaurants/9/1.png', 1),
(122, 9, 'assets/restaurants/9/2.png', 2),
(123, 9, 'assets/restaurants/9/3.png', 3),
(124, 10, 'assets/restaurants/10/1.png', 1),
(125, 10, 'assets/restaurants/10/2.png', 2),
(126, 10, 'assets/restaurants/10/3.png', 3),
(127, 11, 'assets/restaurants/11/1.png', 1),
(128, 11, 'assets/restaurants/11/2.png', 2),
(129, 11, 'assets/restaurants/11/3.png', 3),
(130, 12, 'assets/restaurants/12/1.png', 1),
(131, 12, 'assets/restaurants/12/2.png', 2),
(132, 12, 'assets/restaurants/12/3.png', 3),
(133, 13, 'assets/restaurants/13/1.png', 1),
(134, 13, 'assets/restaurants/13/2.png', 2),
(135, 13, 'assets/restaurants/13/3.png', 3),
(136, 14, 'assets/restaurants/14/1.png', 1),
(137, 14, 'assets/restaurants/14/2.png', 2),
(138, 14, 'assets/restaurants/14/3.png', 3),
(139, 15, 'assets/restaurants/15/1.png', 1),
(140, 15, 'assets/restaurants/15/2.png', 2),
(141, 15, 'assets/restaurants/15/3.png', 3);

-- --------------------------------------------------------

--
-- Structure de la table `sessions`
--

CREATE TABLE `sessions` (
  `id_session` varchar(64) NOT NULL,
  `id_restaurant` int NOT NULL,
  `slot` varchar(32) NOT NULL,
  `sort_order` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `sessions`
--

INSERT INTO `sessions` (`id_session`, `id_restaurant`, `slot`, `sort_order`) VALUES
('1_1', 1, '12:30 - 14:00', 1),
('1_2', 1, '15:30 - 17:00', 2),
('1_3', 1, '19:00 - 20:30', 3),
('1_4', 1, '20:30 - 22:00', 4),
('10_1', 10, '12:30 - 14:00', 1),
('10_2', 10, '15:30 - 17:00', 2),
('10_3', 10, '19:00 - 20:30', 3),
('10_4', 10, '20:30 - 22:00', 4),
('11_1', 11, '12:30 - 14:00', 1),
('11_2', 11, '15:30 - 17:00', 2),
('11_3', 11, '19:00 - 20:30', 3),
('11_4', 11, '20:30 - 22:00', 4),
('12_1', 12, '12:30 - 14:00', 1),
('12_2', 12, '15:30 - 17:00', 2),
('12_3', 12, '19:00 - 20:30', 3),
('12_4', 12, '20:30 - 22:00', 4),
('13_1', 13, '12:30 - 14:00', 1),
('13_2', 13, '15:30 - 17:00', 2),
('13_3', 13, '19:00 - 20:30', 3),
('13_4', 13, '20:30 - 22:00', 4),
('14_1', 14, '12:30 - 14:00', 1),
('14_2', 14, '15:30 - 17:00', 2),
('14_3', 14, '19:00 - 20:30', 3),
('14_4', 14, '20:30 - 22:00', 4),
('15_1', 15, '12:30 - 14:00', 1),
('15_2', 15, '15:30 - 17:00', 2),
('15_3', 15, '19:00 - 20:30', 3),
('15_4', 15, '20:30 - 22:00', 4),
('16_1', 16, '12:30 - 14:00', 1),
('16_2', 16, '15:30 - 17:00', 2),
('16_3', 16, '19:00 - 20:30', 3),
('16_4', 16, '20:30 - 22:00', 4),
('17_1', 17, '12:30 - 14:00', 1),
('17_2', 17, '15:30 - 17:00', 2),
('17_3', 17, '19:00 - 20:30', 3),
('17_4', 17, '20:30 - 22:00', 4),
('18_1', 18, '12:30 - 14:00', 1),
('18_2', 18, '15:30 - 17:00', 2),
('18_3', 18, '19:00 - 20:30', 3),
('18_4', 18, '20:30 - 22:00', 4),
('19_1', 19, '12:30 - 14:00', 1),
('19_2', 19, '15:30 - 17:00', 2),
('19_3', 19, '19:00 - 20:30', 3),
('19_4', 19, '20:30 - 22:00', 4),
('2_1', 2, '12:30 - 14:00', 1),
('2_2', 2, '15:30 - 17:00', 2),
('2_3', 2, '19:00 - 20:30', 3),
('2_4', 2, '20:30 - 22:00', 4),
('20_1', 20, '12:30 - 14:00', 1),
('20_2', 20, '15:30 - 17:00', 2),
('20_3', 20, '19:00 - 20:30', 3),
('20_4', 20, '20:30 - 22:00', 4),
('21_1', 21, '12:30 - 14:00', 1),
('21_2', 21, '15:30 - 17:00', 2),
('21_3', 21, '19:00 - 20:30', 3),
('21_4', 21, '20:30 - 22:00', 4),
('22_1', 22, '12:30 - 14:00', 1),
('22_2', 22, '15:30 - 17:00', 2),
('22_3', 22, '19:00 - 20:30', 3),
('22_4', 22, '20:30 - 22:00', 4),
('23_1', 23, '12:30 - 14:00', 1),
('23_2', 23, '15:30 - 17:00', 2),
('23_3', 23, '19:00 - 20:30', 3),
('23_4', 23, '20:30 - 22:00', 4),
('24_1', 24, '12:30 - 14:00', 1),
('24_2', 24, '15:30 - 17:00', 2),
('24_3', 24, '19:00 - 20:30', 3),
('24_4', 24, '20:30 - 22:00', 4),
('25_1', 25, '12:30 - 14:00', 1),
('25_2', 25, '15:30 - 17:00', 2),
('25_3', 25, '19:00 - 20:30', 3),
('25_4', 25, '20:30 - 22:00', 4),
('26_1', 26, '12:30 - 14:00', 1),
('26_2', 26, '15:30 - 17:00', 2),
('26_3', 26, '19:00 - 20:30', 3),
('26_4', 26, '20:30 - 22:00', 4),
('27_1', 27, '12:30 - 14:00', 1),
('27_2', 27, '15:30 - 17:00', 2),
('27_3', 27, '19:00 - 20:30', 3),
('27_4', 27, '20:30 - 22:00', 4),
('28_1', 28, '12:30 - 14:00', 1),
('28_2', 28, '15:30 - 17:00', 2),
('28_3', 28, '19:00 - 20:30', 3),
('28_4', 28, '20:30 - 22:00', 4),
('29_1', 29, '12:30 - 14:00', 1),
('29_2', 29, '15:30 - 17:00', 2),
('29_3', 29, '19:00 - 20:30', 3),
('29_4', 29, '20:30 - 22:00', 4),
('3_1', 3, '12:30 - 14:00', 1),
('3_2', 3, '15:30 - 17:00', 2),
('3_3', 3, '19:00 - 20:30', 3),
('3_4', 3, '20:30 - 22:00', 4),
('30_1', 30, '12:30 - 14:00', 1),
('30_2', 30, '15:30 - 17:00', 2),
('30_3', 30, '19:00 - 20:30', 3),
('30_4', 30, '20:30 - 22:00', 4),
('31_1', 31, '12:30 - 14:00', 1),
('31_2', 31, '15:30 - 17:00', 2),
('31_3', 31, '19:00 - 20:30', 3),
('31_4', 31, '20:30 - 22:00', 4),
('32_1', 32, '12:30 - 14:00', 1),
('32_2', 32, '15:30 - 17:00', 2),
('32_3', 32, '19:00 - 20:30', 3),
('32_4', 32, '20:30 - 22:00', 4),
('4_1', 4, '12:30 - 14:00', 1),
('4_2', 4, '15:30 - 17:00', 2),
('4_3', 4, '19:00 - 20:30', 3),
('4_4', 4, '20:30 - 22:00', 4),
('5_1', 5, '12:30 - 14:00', 1),
('5_2', 5, '15:30 - 17:00', 2),
('5_3', 5, '19:00 - 20:30', 3),
('5_4', 5, '20:30 - 22:00', 4),
('6_1', 6, '12:30 - 14:00', 1),
('6_2', 6, '15:30 - 17:00', 2),
('6_3', 6, '19:00 - 20:30', 3),
('6_4', 6, '20:30 - 22:00', 4),
('7_1', 7, '12:30 - 14:00', 1),
('7_2', 7, '15:30 - 17:00', 2),
('7_3', 7, '19:00 - 20:30', 3),
('7_4', 7, '20:30 - 22:00', 4),
('8_1', 8, '12:30 - 14:00', 1),
('8_2', 8, '15:30 - 17:00', 2),
('8_3', 8, '19:00 - 20:30', 3),
('8_4', 8, '20:30 - 22:00', 4),
('9_1', 9, '12:30 - 14:00', 1),
('9_2', 9, '15:30 - 17:00', 2),
('9_3', 9, '19:00 - 20:30', 3),
('9_4', 9, '20:30 - 22:00', 4);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id_user` int NOT NULL,
  `email` varchar(255) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `date_creation` datetime DEFAULT CURRENT_TIMESTAMP,
  `derniere_connexion` datetime DEFAULT NULL,
  `role` varchar(50) DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id_user`, `email`, `mot_de_passe`, `date_creation`, `derniere_connexion`, `role`) VALUES
(1, 'juju@test.com', '$2y$10$xPww9mWn6TXCXQX7H9.k0.wxnAdTGsm5xMV8.zLs9QL8RJGg7huc.', '2025-12-31 14:47:34', NULL, 'user'),
(2, 'test@test.com', '$2y$10$d.PMiOVfCCz2/qd5kuJniOaWFu/iGYNgQxoGjk3KqtbdWxgE1k9LC', '2025-12-31 15:22:02', NULL, 'user'),
(3, 'lulu@test.com', '$2y$10$gqXum5X0B1lAJ7a.BtVBouqbKQhPmsbGcLuVk9f.jDJbC0QAh9ORO', '2026-01-02 14:22:04', NULL, 'user'),
(4, 'admin@meeteat.fr', 'admin', '2026-01-02 18:49:45', NULL, 'user');

-- --------------------------------------------------------

--
-- Structure de la table `user_interet`
--

CREATE TABLE `user_interet` (
  `id_user` int NOT NULL,
  `id_interet` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user_interet`
--

INSERT INTO `user_interet` (`id_user`, `id_interet`) VALUES
(1, 1),
(2, 1),
(2, 2),
(3, 2),
(1, 3),
(3, 4),
(3, 5);

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
  ADD KEY `fk_discussion_session` (`id_session`);

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
  ADD PRIMARY KEY (`id_message`);

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
  ADD KEY `fk_participant_user` (`id_user`);

--
-- Index pour la table `profil`
--
ALTER TABLE `profil`
  ADD PRIMARY KEY (`id_profil`),
  ADD UNIQUE KEY `id_user` (`id_user`);

--
-- Index pour la table `reponse_quiz`
--
ALTER TABLE `reponse_quiz`
  ADD PRIMARY KEY (`id_reponse`);

--
-- Index pour la table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id_reservation`),
  ADD KEY `fk_resa_user` (`id_user`),
  ADD KEY `fk_resa_restaurant` (`id_restaurant`);

--
-- Index pour la table `restaurants`
--
ALTER TABLE `restaurants`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `restaurant_images`
--
ALTER TABLE `restaurant_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_restaurant_images_restaurant` (`restaurant_id`);

--
-- Index pour la table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id_session`),
  ADD KEY `fk_sessions_restaurant` (`id_restaurant`);

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
  MODIFY `id_interet` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `commentaires`
--
ALTER TABLE `commentaires`
  MODIFY `id_commentaire` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `discussion`
--
ALTER TABLE `discussion`
  MODIFY `id_discussion` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `match_user`
--
ALTER TABLE `match_user`
  MODIFY `id_match` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `message`
--
ALTER TABLE `message`
  MODIFY `id_message` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `paiement`
--
ALTER TABLE `paiement`
  MODIFY `id_paiement` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `profil`
--
ALTER TABLE `profil`
  MODIFY `id_profil` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `reponse_quiz`
--
ALTER TABLE `reponse_quiz`
  MODIFY `id_reponse` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id_reservation` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `restaurant_images`
--
ALTER TABLE `restaurant_images`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=142;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
  ADD CONSTRAINT `fk_discussion_session` FOREIGN KEY (`id_session`) REFERENCES `session` (`id_session`) ON DELETE CASCADE;

--
-- Contraintes pour la table `match_user`
--
ALTER TABLE `match_user`
  ADD CONSTRAINT `match_user_ibfk_1` FOREIGN KEY (`id_user_1`) REFERENCES `user` (`id_user`),
  ADD CONSTRAINT `match_user_ibfk_2` FOREIGN KEY (`id_user_2`) REFERENCES `user` (`id_user`),
  ADD CONSTRAINT `match_user_ibfk_3` FOREIGN KEY (`id_session`) REFERENCES `session` (`id_session`);

--
-- Contraintes pour la table `paiement`
--
ALTER TABLE `paiement`
  ADD CONSTRAINT `paiement_ibfk_1` FOREIGN KEY (`id_reservation`) REFERENCES `reservation` (`id_reservation`);

--
-- Contraintes pour la table `participant_discussion`
--
ALTER TABLE `participant_discussion`
  ADD CONSTRAINT `fk_participant_discussion` FOREIGN KEY (`id_discussion`) REFERENCES `discussion` (`id_discussion`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_participant_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE;

--
-- Contraintes pour la table `profil`
--
ALTER TABLE `profil`
  ADD CONSTRAINT `profil_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`);

--
-- Contraintes pour la table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `fk_resa_restaurant` FOREIGN KEY (`id_restaurant`) REFERENCES `restaurants` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_resa_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE;

--
-- Contraintes pour la table `restaurant_images`
--
ALTER TABLE `restaurant_images`
  ADD CONSTRAINT `fk_restaurant_images_restaurant` FOREIGN KEY (`restaurant_id`) REFERENCES `restaurants` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `sessions`
--
ALTER TABLE `sessions`
  ADD CONSTRAINT `fk_sessions_restaurant` FOREIGN KEY (`id_restaurant`) REFERENCES `restaurants` (`id`) ON DELETE CASCADE;

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
