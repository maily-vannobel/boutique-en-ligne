-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3307
-- Généré le : mer. 26 juin 2024 à 19:12
-- Version du serveur : 10.6.5-MariaDB
-- Version de PHP : 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `shop_db`
--

-- --------------------------------------------------------

--
-- Structure de la table `addresses`
--

DROP TABLE IF EXISTS `addresses`;
CREATE TABLE IF NOT EXISTS `addresses` (
  `address_id` int(11) NOT NULL AUTO_INCREMENT,
  `delivery_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address_complement` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postal_code` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billing_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`address_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`) VALUES
(1, 'Alimentation'),
(2, 'Soins-Hygiène'),
(3, 'Jouets'),
(4, 'Accessoires');

-- --------------------------------------------------------

--
-- Structure de la table `filters`
--

DROP TABLE IF EXISTS `filters`;
CREATE TABLE IF NOT EXISTS `filters` (
  `filter_id` int(11) NOT NULL AUTO_INCREMENT,
  `filter_type` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `filter_value` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`filter_id`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `filters`
--

INSERT INTO `filters` (`filter_id`, `filter_type`, `filter_value`) VALUES
(1, 'marque', 'Edgard & Cooper®'),
(2, 'marque', 'Fido®'),
(3, 'marque', 'Friskies®'),
(4, 'marque', 'Pro Plan®'),
(5, 'marque', 'Purina One®'),
(6, 'marque', 'Royal Canin®'),
(7, 'couleur', 'Blanc'),
(8, 'couleur', 'Bleu'),
(9, 'couleur', 'Gris'),
(10, 'couleur', 'Jaune'),
(11, 'couleur', 'Marron'),
(12, 'couleur', 'Noir'),
(13, 'couleur', 'Orange'),
(14, 'couleur', 'Rose'),
(15, 'couleur', 'Rouge'),
(16, 'couleur', 'Vert'),
(17, 'couleur', 'Violet'),
(18, 'ingrédient', 'Agneau'),
(19, 'ingrédient', 'Avoine'),
(20, 'ingrédient', 'Boeuf'),
(21, 'ingrédient', 'Canard'),
(22, 'ingrédient', 'Carotte'),
(23, 'ingrédient', 'Dinde'),
(24, 'ingrédient', 'Maïs'),
(25, 'ingrédient', 'Pomme de terre'),
(26, 'ingrédient', 'Poisson'),
(27, 'ingrédient', 'Poulet'),
(28, 'ingrédient', 'Riz'),
(29, 'ingrédient', 'Saumon'),
(30, 'matériau', 'Bois'),
(31, 'matériau', 'Caoutchouc'),
(32, 'matériau', 'Coton'),
(33, 'matériau', 'Latex'),
(34, 'matériau', 'Nylon'),
(35, 'matériau', 'Plastique'),
(36, 'matériau', 'Polyester'),
(37, 'matériau', 'Tissu'),
(38, 'provenance', 'Canada'),
(39, 'provenance', 'France'),
(40, 'provenance', 'Pays-Bas'),
(41, 'provenance', 'Royaume-Uni'),
(42, 'provenance', 'États-Unis'),
(43, 'âge_chien', 'Chiot'),
(44, 'âge_chien', 'Adulte'),
(45, 'âge_chien', 'Senior'),
(46, 'poids_chien', 'Moins de 10 kg'),
(47, 'poids_chien', '10 à 25 kg'),
(48, 'poids_chien', 'Plus de 25 kg');

-- --------------------------------------------------------

--
-- Structure de la table `images`
--

DROP TABLE IF EXISTS `images`;
CREATE TABLE IF NOT EXISTS `images` (
  `image_id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`image_id`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `images`
--

INSERT INTO `images` (`image_id`, `url`) VALUES
(1, 'https://alonzo-bachelier.students-laplateforme.io/imagesBaseDeDonn%C3%A9es/boutique/nourriture/croquettes-purina-adult-small-1.png'),
(2, 'https://alonzo-bachelier.students-laplateforme.io/imagesBaseDeDonn%C3%A9es/boutique/nourriture/purina-adult-small-2.png'),
(3, 'https://alonzo-bachelier.students-laplateforme.io/imagesBaseDeDonn%C3%A9es/boutique/nourriture/croquettes-purina-adult-small-3.png'),
(9, 'https://alonzo-bachelier.students-laplateforme.io/imagesBaseDeDonn%C3%A9es/boutique/nourriture/croquettes-chow-adult-chicken-1.png'),
(10, 'https://alonzo-bachelier.students-laplateforme.io/imagesBaseDeDonn%C3%A9es/boutique/nourriture/croquettes-chow-adult-chicken-2.png'),
(14, 'https://alonzo-bachelier.students-laplateforme.io/imagesBaseDeDonn%C3%A9es/boutique/nourriture/croquettes-chow-adult-big-turkey-1.png'),
(15, 'https://alonzo-bachelier.students-laplateforme.io/imagesBaseDeDonn%C3%A9es/boutique/nourriture/croquettes-chow-adult-big-turkey-2.png'),
(16, 'https://alonzo-bachelier.students-laplateforme.io/imagesBaseDeDonn%C3%A9es/boutique/nourriture/croquettes-chow-adult-big-turkey-3.png'),
(17, 'https://alonzo-bachelier.students-laplateforme.io/imagesBaseDeDonn%C3%A9es/boutique/nourriture/croquettes-chow-puppy-chicken-1.png'),
(18, 'https://alonzo-bachelier.students-laplateforme.io/imagesBaseDeDonn%C3%A9es/boutique/nourriture/croquettes-chow-puppy-chicken-2.png'),
(19, 'https://alonzo-bachelier.students-laplateforme.io/imagesBaseDeDonn%C3%A9es/boutique/nourriture/croquettes-chow-puppy-chicken-3.png'),
(20, 'https://alonzo-bachelier.students-laplateforme.io/imagesBaseDeDonn%C3%A9es/boutique/nourriture/croquettes-chow-adult-active-chicken-1.png'),
(21, 'https://alonzo-bachelier.students-laplateforme.io/imagesBaseDeDonn%C3%A9es/boutique/nourriture/croquettes-chow-adult-active-chicken-2.png'),
(22, 'https://alonzo-bachelier.students-laplateforme.io/imagesBaseDeDonn%C3%A9es/boutique/nourriture/croquettes-chow-adult-active-chicken-3.png'),
(23, 'https://alonzo-bachelier.students-laplateforme.io/imagesBaseDeDonn%C3%A9es/boutique/nourriture/croquettes-plan-adult-small-chicken-1.png'),
(24, 'https://alonzo-bachelier.students-laplateforme.io/imagesBaseDeDonn%C3%A9es/boutique/nourriture/croquettes-plan-adult-small-chicken-2.png'),
(26, 'https://alonzo-bachelier.students-laplateforme.io/imagesBaseDeDonn%C3%A9es/boutique/nourriture/croquettes-plan-puppy-lamb-1.png'),
(27, 'https://alonzo-bachelier.students-laplateforme.io/imagesBaseDeDonn%C3%A9es/boutique/nourriture/croquettes-plan-puppy-lamb-2.png'),
(28, 'https://alonzo-bachelier.students-laplateforme.io/imagesBaseDeDonn%C3%A9es/boutique/nourriture/croquettes-plan-puppy-lamb-1.png'),
(29, 'https://alonzo-bachelier.students-laplateforme.io/imagesBaseDeDonn%C3%A9es/boutique/nourriture/croquettes-plan-puppy-lamb-2.png'),
(38, 'https://alonzo-bachelier.students-laplateforme.io/imagesBaseDeDonn%C3%A9es/boutique/jouets/fontaine_exterieur.jpg'),
(39, 'https://alonzo-bachelier.students-laplateforme.io/imagesBaseDeDonn%C3%A9es/boutique/jouets/fontaine_exterieur2.jpg'),
(40, 'https://alonzo-bachelier.students-laplateforme.io/imagesBaseDeDonn%C3%A9es/boutique/jouets/fontaine_exterieur3.jpg'),
(41, 'https://alonzo-bachelier.students-laplateforme.io/imagesBaseDeDonn%C3%A9es/boutique/jouets/fontaine_exterieur4.jpg'),
(42, 'https://alonzo-bachelier.students-laplateforme.io/imagesBaseDeDonn%C3%A9es/boutique/jouets/fontaine_exterieur5.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_date` datetime DEFAULT NULL,
  `total_price` decimal(10,2) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`order_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `order_products`
--

DROP TABLE IF EXISTS `order_products`;
CREATE TABLE IF NOT EXISTS `order_products` (
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  PRIMARY KEY (`order_id`,`product_id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stock` int(11) DEFAULT NULL,
  `quantity_weight` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`product_id`),
  KEY `fk_products_category` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `description`, `stock`, `quantity_weight`, `price`, `category_id`) VALUES
(1, 'PURINA ONE® MINI/SMALL - Croquettes pour petit chien adulte- Bœuf avec du riz', '- Aide à maintenir un microbiome intestinal sain.\r\n- Aide à soutenir des défenses naturelles fortes grâce aux antioxydants et aux protéines de haute qualité.\r\n- Maintient une peau saine et un pelage soyeux grâce à un niveau adapté en nutriments essentiels​.\r\n- Une bonne hygiène bucco-dentaire grâce aux nutriments essentiels et au croustillant des croquettes.', NULL, '1.5 kg', '9.59', 1),
(2, 'DOG CHOW® ADULT - POULET', 'Alimentation 100 % complète et équilibrée adaptée à votre chien adulte. Contient des prébiotiques naturels, prouvés pour améliorer l’équilibre de la microflore intestinale et soutenir une digestion saine. Sans colorants, arômes et conservateurs artificiels ajoutés. Deux tailles et formes de croquettes pour une meilleure mastication.', NULL, '14 kg', '50.99', 1),
(3, 'DOG CHOW® ADULT LARGE BREED - DINDE', 'Alimentation 100 % complète et équilibrée adaptée à votre chien adulte de grande taille. Contient des prébiotiques naturels, prouvés pour améliorer l’équilibre de la microflore intestinale et soutenir une digestion saine. Sans colorants, arômes et conservateurs artificiels ajoutés. Deux tailles et formes de croquettes pour une meilleure mastication.', NULL, '14 kg', '55.99', 1),
(4, 'DOG CHOW® PUPPY (jusqu’à 1 an) - POULET', 'Alimentation 100% complète et équilibrée adaptée à votre chiot. Contient des prébiotiques naturels, prouvés pour améliorer l’équilibre de la microflore intestinale et soutenir une digestion saine. Sans colorants, arômes et conservateurs artificiels ajoutés. Deux tailles et formes de croquettes pour une meilleure mastication.', NULL, '14 kg', '57.99', 1),
(5, 'DOG CHOW® ADULT ACTIVE - POULET', 'Alimentation 100 % complète et équilibrée adaptée à votre chien adulte. Contient des prébiotiques naturels, prouvés pour améliorer l’équilibre de la microflore intestinale et soutenir une digestion saine. Sans colorants, arômes et conservateurs artificiels ajoutés. Deux tailles et formes de croquettes pour une meilleure mastication.', NULL, '14 kg', '34.45', 1),
(6, 'PRO PLAN® SMALL ADULT - POULET', 'Favorise le maintien de la bonne santé au quotidien.\r\nAbsorption supérieure des nutriments pour satisfaire les besoins de votre chien.\r\nAide à garder le pelage de votre chien brillant des racines jusqu’aux pointes.\r\nUne combinaison de nutriments essentiels pour aider à soutenir la bonne santé des articulations.', NULL, '3kg', '21.00', 1),
(7, 'PRO PLAN® PUPPY SENSITIVE DIGESTION - DINDE', 'Améliore l\'équilibre de la microflore intestinale, formulé sans céréales.\r\nContient des prébiotiques scientifiquement prouvés pour augmenter le nombre de bifidobactéries, pour un meilleur équilibre de la microflore intestinale.\r\nFormulé avec des ingrédients spécifiques pour contribuer à la bonne santé intestinale et la bonne consistance des selles.\r\nRecette sans céréales, soigneusement formulée sans blé ni maïs. Fabriqué dans un atelier qui utilise des céréales.', NULL, '12kg', '78.85', 1),
(15, 'Fontaine extérieure', 'Jouer et s\'hydrater en autonomie\r\nMécanisme pédale simple\r\nIdéale en période de forte chaleur, la fontaine Spring Break de Zolia permettra à votre chien sur simple action de sa patte sur la pédale de faire jaillir de l\'eau fraîche. Une façon originale, ludique et pratique de joindre l\'utile à l\'agréable : jouer et s\'hydrater tout en étant autonome. Le branchement est simple, il vous suffit de raccorder le tuyau fournit directement à votre robinet ou tuyau d\'arrosage pour que votre chien puisse se mouiller et jouer. Lorsque votre compagnon s\'est bien rafraichi, n\'oubliez pas de couper l\'eau en refermant le robinet !\r\n\r\nCaractéristiques\r\nFontaine extérieure chien Zolia Spring Break\r\n- Fontaine à eau pour chien\r\n- Avec pédale\r\n- Mécanisme simple\r\n- Ultra résistant\r\n- À brancher sur un tuyau d\'arrosage ou sur un robinet\r\n- Vendue avec tuyau de raccordement (longueur 3m)', NULL, 'x1', '27.99', 3);

-- --------------------------------------------------------

--
-- Structure de la table `product_filter`
--

DROP TABLE IF EXISTS `product_filter`;
CREATE TABLE IF NOT EXISTS `product_filter` (
  `product_id` int(11) NOT NULL,
  `filter_id` int(11) NOT NULL,
  PRIMARY KEY (`product_id`,`filter_id`),
  KEY `filter_id` (`filter_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `product_filter`
--

INSERT INTO `product_filter` (`product_id`, `filter_id`) VALUES
(1, 5),
(2, 27),
(2, 44),
(4, 27),
(4, 43),
(5, 27),
(5, 44),
(5, 46),
(5, 47),
(5, 48),
(6, 4),
(6, 27),
(6, 44),
(6, 46),
(7, 18),
(7, 43),
(7, 46),
(7, 47),
(7, 48),
(15, 7),
(15, 8),
(15, 35);

-- --------------------------------------------------------

--
-- Structure de la table `product_images`
--

DROP TABLE IF EXISTS `product_images`;
CREATE TABLE IF NOT EXISTS `product_images` (
  `product_id` int(11) NOT NULL,
  `image_id` int(11) NOT NULL,
  PRIMARY KEY (`product_id`,`image_id`),
  KEY `image_id` (`image_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `product_images`
--

INSERT INTO `product_images` (`product_id`, `image_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(2, 9),
(2, 10),
(3, 14),
(3, 15),
(3, 16),
(4, 17),
(4, 18),
(4, 19),
(5, 20),
(5, 21),
(5, 22),
(6, 23),
(6, 24),
(7, 26),
(7, 27),
(15, 38),
(15, 39),
(15, 40),
(15, 41),
(15, 42);

-- --------------------------------------------------------

--
-- Structure de la table `product_subcategories`
--

DROP TABLE IF EXISTS `product_subcategories`;
CREATE TABLE IF NOT EXISTS `product_subcategories` (
  `product_id` int(11) NOT NULL,
  `subcategories_id` int(11) NOT NULL,
  PRIMARY KEY (`product_id`,`subcategories_id`),
  KEY `subcategories_id` (`subcategories_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `product_subcategories`
--

INSERT INTO `product_subcategories` (`product_id`, `subcategories_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(15, 12),
(15, 16);

-- --------------------------------------------------------

--
-- Structure de la table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `role_id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `roles`
--

INSERT INTO `roles` (`role_id`, `role_name`) VALUES
(1, 'admin'),
(2, 'user');

-- --------------------------------------------------------

--
-- Structure de la table `subcategories`
--

DROP TABLE IF EXISTS `subcategories`;
CREATE TABLE IF NOT EXISTS `subcategories` (
  `subcategories_id` int(11) NOT NULL AUTO_INCREMENT,
  `subcategories_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`subcategories_id`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `subcategories`
--

INSERT INTO `subcategories` (`subcategories_id`, `subcategories_name`, `category_id`) VALUES
(1, 'Croquettes', 1),
(2, 'Pâtés', 1),
(3, 'Régime spécial', 1),
(4, 'Friandises', 1),
(5, 'Produits de toilettes', 2),
(6, 'Soins des dents', 2),
(7, 'Soins des yeux', 2),
(8, 'Soins des oreilles', 2),
(9, 'Anti parasitaire', 2),
(10, 'Compléments alimentaires', 2),
(11, 'Jouets à mâcher', 3),
(12, 'Jouets interactifs', 3),
(13, 'Peluches', 3),
(14, 'Balles et frisbees', 3),
(15, 'Jouets éducatifs', 3),
(16, 'Jouet d\'extérieur', 3),
(17, 'Laisse et colliers', 4),
(18, 'Vêtements pour chiens', 4),
(19, 'Lit et coussins', 4),
(20, 'Gamelle', 4),
(21, 'Transports', 4);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `last_name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `first_name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  KEY `role_id` (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`user_id`, `last_name`, `first_name`, `email`, `password`, `phone`, `role_id`) VALUES
(1, 'Vannobel', 'Maily', 'maily.vannobel@gmail.com', '$2y$10$JRCBGcry70dvD0Zf2A4/l.CYhV52TjjKqXQ1DGlHOF/C6fxWPxi2q', '0610101010', 2),
(2, 'azerty', 'azerty', 'maily.vannobel@gmail.com', '$2y$10$MkIqJaKYmDalx6zRn5D/I.VjbTJbmG.KMCvu3pXrTjunSrsu5z95O', '0610101010', 2);

-- --------------------------------------------------------

--
-- Structure de la table `user_addresses`
--

DROP TABLE IF EXISTS `user_addresses`;
CREATE TABLE IF NOT EXISTS `user_addresses` (
  `address_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`,`address_id`),
  KEY `address_id` (`address_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Contraintes pour la table `order_products`
--
ALTER TABLE `order_products`
  ADD CONSTRAINT `order_products_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`),
  ADD CONSTRAINT `order_products_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Contraintes pour la table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_products_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `product_filter`
--
ALTER TABLE `product_filter`
  ADD CONSTRAINT `product_filter_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`),
  ADD CONSTRAINT `product_filter_ibfk_2` FOREIGN KEY (`filter_id`) REFERENCES `filters` (`filter_id`);

--
-- Contraintes pour la table `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`),
  ADD CONSTRAINT `product_images_ibfk_2` FOREIGN KEY (`image_id`) REFERENCES `images` (`image_id`);

--
-- Contraintes pour la table `product_subcategories`
--
ALTER TABLE `product_subcategories`
  ADD CONSTRAINT `product_subcategories_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`),
  ADD CONSTRAINT `product_subcategories_ibfk_2` FOREIGN KEY (`subcategories_id`) REFERENCES `subcategories` (`subcategories_id`);

--
-- Contraintes pour la table `subcategories`
--
ALTER TABLE `subcategories`
  ADD CONSTRAINT `subcategories_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`);

--
-- Contraintes pour la table `user_addresses`
--
ALTER TABLE `user_addresses`
  ADD CONSTRAINT `user_addresses_ibfk_1` FOREIGN KEY (`address_id`) REFERENCES `addresses` (`address_id`),
  ADD CONSTRAINT `user_addresses_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
