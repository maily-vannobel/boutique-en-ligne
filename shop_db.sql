-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3307
-- Généré le : mar. 25 juin 2024 à 12:11
-- Version du serveur : 11.3.2-MariaDB
-- Version de PHP : 8.2.18

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
  `delivery_address` varchar(255) DEFAULT NULL,
  `address_complement` varchar(255) DEFAULT NULL,
  `postal_code` varchar(20) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `billing_address` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`address_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(100) DEFAULT NULL,
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
  `filter_type` varchar(50) DEFAULT NULL,
  `filter_value` varchar(50) DEFAULT NULL,
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
  `url` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`image_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `images`
--

INSERT INTO `images` (`image_id`, `url`) VALUES
(1, '/images/nourriture/croquettes-purina-adult-small-1.jpg'),
(2, '/images/nourriture/croquettes-purina-adult-small-2.jpg'),
(3, '/images/nourriture/croquettes-purina-adult-small-3.jpg');

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
  `product_name` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `stock` int(11) DEFAULT NULL,
  `quantity_weight` varchar(20) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`product_id`),
  KEY `fk_products_category` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `description`, `stock`, `quantity_weight`, `price`, `category_id`) VALUES
(1, 'PURINA ONE® MINI/SMALL - Croquettes pour petit chien adulte- Bœuf avec du riz', '- Aide à maintenir un microbiome intestinal sain.\r\n- Aide à soutenir des défenses naturelles fortes grâce aux antioxydants et aux protéines de haute qualité.\r\n- Maintient une peau saine et un pelage soyeux grâce à un niveau adapté en nutriments essentiels​.\r\n- Une bonne hygiène bucco-dentaire grâce aux nutriments essentiels et au croustillant des croquettes.', NULL, '1.5 kg', 9.59, 1);

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
(1, 5);

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
(1, 3);

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
(1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `role_id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(50) DEFAULT NULL,
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
  `subcategories_name` varchar(100) DEFAULT NULL,
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
  `last_name` varchar(50) DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
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
  ADD CONSTRAINT `subcategories_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`);

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
