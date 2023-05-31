-- --------------------------------------------------------
-- Hôte:                         127.0.0.1
-- Version du serveur:           5.7.33 - MySQL Community Server (GPL)
-- SE du serveur:                Win64
-- HeidiSQL Version:             11.2.0.6213
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Listage de la structure de la base pour blog
CREATE DATABASE IF NOT EXISTS `blog` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */;
USE `blog`;

-- Listage de la structure de la table blog. adresses
CREATE TABLE IF NOT EXISTS `adresses` (
  `adresse_id` int(11) NOT NULL AUTO_INCREMENT,
  `nom_hote` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL,
  PRIMARY KEY (`adresse_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table blog.adresses : ~3 rows (environ)
/*!40000 ALTER TABLE `adresses` DISABLE KEYS */;
INSERT INTO `adresses` (`adresse_id`, `nom_hote`, `created_at`) VALUES
	(1, 'TgVURMuqKoOdbu1M3l6lPnIXt8i6yAm029H8HDw/Vs4=', '2023-04-02 11:15:31'),
	(2, 'Shhe66Ytxzlf[plus]Nl5OjTldbdVE[plus]CNtlqiehR1KCYY[plus]R0=', '2023-03-11 11:12:14'),
	(3, '06aH5OhH6q0lbtT70mXms46k0jQTLv7ajU27c187N0qbTJQs8ssdjm5Ozq9Q5n2g', '2023-04-05 10:50:54');
/*!40000 ALTER TABLE `adresses` ENABLE KEYS */;

-- Listage de la structure de la table blog. articles
CREATE TABLE IF NOT EXISTS `articles` (
  `article_id` int(11) NOT NULL AUTO_INCREMENT,
  `article_image` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `article_title` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code_html` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` enum('attente','publier') COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`article_id`),
  UNIQUE KEY `article_title` (`article_title`),
  KEY `category_id` (`category_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `FK_articles_categories` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_articles_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table blog.articles : ~5 rows (environ)
/*!40000 ALTER TABLE `articles` DISABLE KEYS */;
INSERT INTO `articles` (`article_id`, `article_image`, `article_title`, `code_html`, `state`, `category_id`, `user_id`, `created_at`, `updated_at`) VALUES
	(6, 'image647645d17f0f29.58924958.jpg', 'Introduction JavaScript', '<h2 style="text-align: center;"><span style="font-family: \'arial black\', sans-serif; font-size: 18pt; color: rgb(230, 126, 35);"><strong>Welcome to MasterCode</strong></span></h2>\n<p><img style="display: block; margin-left: auto; margin-right: auto;" src="ressources/images/articles_images/image647645737606c4.66314234.jpg" alt="javascript" width="500" height="281"></p>\n<h3 style="text-align: center;"><span style="font-size: 14pt; color: rgb(35, 111, 161);">Essai</span></h3>', 'publier', 18, 3, '2023-05-30 06:52:01', NULL),
	(8, 'Code.jpg', 'Introduction HTML', '<p>Welcome to MasterCode</p>\n<p><img src="ressources/images/articles_images/image64774df3aa0439.04831254.jpeg" alt="" width="555" height="291"></p>\n<p>Bonjour messieurs</p>', 'publier', 20, 2, '2023-05-31 01:39:27', NULL),
	(9, 'image64774e93c3efe4.28453597.jpg', 'Introduction DOM', '<p>Welcome to MasterCode</p>\n<p><img src="ressources/images/articles_images/image64774e67ef33e5.05794793.png" alt="" width="225" height="225"></p>\n<p>Test</p>', 'attente', 18, 3, '2023-05-31 01:41:39', NULL),
	(11, 'image64776f35809c70.76760241.jpg', 'Introduction Java', '<p>Welcome to MasterCode</p>\n<p><img style="display: block; margin-left: auto; margin-right: auto;" src="ressources/images/articles_images/image64776e80c57ea4.18824137.png" alt="test" width="800" height="450"></p>\n<h3 style="text-align: center;"><span style="font-family: \'arial black\', sans-serif; font-size: 14pt;"><code><span style="color: rgb(230, 126, 35);">Voyourie</span></code></span></h3>', 'attente', 19, 13, '2023-05-31 04:00:53', NULL),
	(12, 'image64776f77a1ab75.73847069.jpeg', 'Introduction HyperText Modal Langage', '<p>Welcome to MasterCode</p>\n<p><img src="ressources/images/articles_images/image64776f5ba1aa65.52799252.png" alt="" width="600" height="600"></p>', 'publier', 20, 13, '2023-05-31 04:01:59', NULL);
/*!40000 ALTER TABLE `articles` ENABLE KEYS */;

-- Listage de la structure de la table blog. categories
CREATE TABLE IF NOT EXISTS `categories` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_img` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table blog.categories : ~5 rows (environ)
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` (`category_id`, `category_img`, `category_name`, `category_description`) VALUES
	(16, 'category_image-647204324d99c6.23988483.png', 'PHP', 'procédural...'),
	(18, 'category_image-6472742d627f63.85422378.png', 'Javascript', 'Langage Front et Back'),
	(19, 'category_image-6475a79e28d784.30898492.png', 'Java', 'Langage Back'),
	(20, 'category_image-64774daf69b2c3.31796084.png', 'HTML', 'Langage Web'),
	(21, 'category_image-64774dd4eb49b6.81167070.jpg', 'CSS', 'Feuille de style');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;

-- Listage de la structure de la table blog. comments
CREATE TABLE IF NOT EXISTS `comments` (
  `comment_id` int(11) NOT NULL AUTO_INCREMENT,
  `comment_body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `article_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL,
  PRIMARY KEY (`comment_id`),
  KEY `user_id` (`user_id`),
  KEY `article_id` (`article_id`),
  CONSTRAINT `FK_comments_articles` FOREIGN KEY (`article_id`) REFERENCES `articles` (`article_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_comments_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table blog.comments : ~0 rows (environ)
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;

-- Listage de la structure de la table blog. contacts
CREATE TABLE IF NOT EXISTS `contacts` (
  `contact_id` int(11) NOT NULL AUTO_INCREMENT,
  `contact_email` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_theme` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` enum('attente','valide') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL,
  PRIMARY KEY (`contact_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table blog.contacts : ~1 rows (environ)
/*!40000 ALTER TABLE `contacts` DISABLE KEYS */;
INSERT INTO `contacts` (`contact_id`, `contact_email`, `contact_name`, `contact_theme`, `contact_body`, `state`, `created_at`) VALUES
	(2, 'kol@gmail.com', 'kola', 'text', 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ex non dolorum ab rerum quam doloribus quia tempore quidem, sunt magnam praesentium. Numquam ab minus officiis voluptates consequatur ratione ex ipsum dolore quidem nihil, ullam rem eveniet vel libero quos ad odio sapiente quod reprehenderit voluptate quo doloribus dolor laborum sint? Aspernatur labore exercitationem sunt dolorem similique fugiat error mollitia. Autem minima odit nobis sequi id, laudantium cum dolorem tenetur, quibusdam consequatur ullam corporis facere iusto eos, eveniet a harum. Tenetur, consectetur saepe. Exercitationem quam excepturi nemo doloremque deserunt ad dolorum, eligendi, tempora minima reprehenderit impedit quis dolorem quod sapiente ducimus.', 'attente', '2023-05-27 15:37:51');
/*!40000 ALTER TABLE `contacts` ENABLE KEYS */;

-- Listage de la structure de la table blog. datasusers
CREATE TABLE IF NOT EXISTS `datasusers` (
  `datasuser_id` int(11) NOT NULL AUTO_INCREMENT,
  `article_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL,
  PRIMARY KEY (`datasuser_id`),
  KEY `article_id` (`article_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `FK_datasusers_articles` FOREIGN KEY (`article_id`) REFERENCES `articles` (`article_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_datasusers_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table blog.datasusers : ~0 rows (environ)
/*!40000 ALTER TABLE `datasusers` DISABLE KEYS */;
/*!40000 ALTER TABLE `datasusers` ENABLE KEYS */;

-- Listage de la structure de la table blog. likes
CREATE TABLE IF NOT EXISTS `likes` (
  `like_id` int(11) NOT NULL AUTO_INCREMENT,
  `article_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`like_id`),
  KEY `article_id` (`article_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `FK_likes_articles` FOREIGN KEY (`article_id`) REFERENCES `articles` (`article_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_likes_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table blog.likes : ~0 rows (environ)
/*!40000 ALTER TABLE `likes` DISABLE KEYS */;
/*!40000 ALTER TABLE `likes` ENABLE KEYS */;

-- Listage de la structure de la table blog. users
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_email` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_code` int(11) DEFAULT NULL,
  `user_pseudo` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_role` enum('0','1','2') COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_password` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_bgc` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_email` (`user_email`),
  UNIQUE KEY `user_pseudo` (`user_pseudo`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table blog.users : ~6 rows (environ)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`user_id`, `user_email`, `email_code`, `user_pseudo`, `user_role`, `user_password`, `user_bgc`, `created_at`, `updated_at`) VALUES
	(2, 'koladeaboudou@gmail.com', 201455, 'Kola', '0', '$2y$10$WXZQRuoNjqxiWthZlQOqpuFR6oDWnKeKes9OdAtH/zUU68sr8HaYG', '#66CDAA', '2023-04-01 06:49:13', NULL),
	(3, 'marcosmedenou@gmail.com', NULL, 'marcos', '0', '$2y$10$ppEg5kJHwAoXUOhnQnio/OmZhu4q1yzlph33fKOpiDH.z6aOs5t22', '#D2691E', '2023-04-04 09:02:54', NULL),
	(11, 'erikazankpo@gmail.com', NULL, 'ericaz99', '0', '$2y$10$DlbYGLxKWO6yZw8zQlQKu.RBXOmIomhJy124g4P0ZRWu85XFvudk2', '#FFFACD', '2023-05-26 03:31:33', '2023-05-30 08:20:41'),
	(13, 'geoffroyotegbeye@gmail.com', NULL, 'geoffroy', '2', '$2y$10$lexm1Iu/yj7FQlEOgFEjzevkWmkrZv9qh2kF0XMO2YCWybOdLqBTO', '#48D1CC', '2023-05-30 07:38:15', '2023-05-31 04:06:20'),
	(14, 'masterCode@gmail.com', NULL, 'SuperAdmin', '0', '$2y$10$nIIV1.2QxvTEFmXzbw7hUOIGSzMYIAIL2v9paVJgFiVTTJf5hgWwG', '#ADFF2F', '2023-05-30 10:42:24', '2023-05-30 10:42:59'),
	(15, 'tiburcekouagou@gmail.com', NULL, 'Tiburce', '1', '$2y$10$aBp7Ep8wtLYxRvaggiBQGuxRZF3H7pDBSTyfzVvsmz5/VXO90iMLG', '#0000FF', '2023-05-31 01:43:41', NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

-- Listage de la structure de la table blog. viewsarticles
CREATE TABLE IF NOT EXISTS `viewsarticles` (
  `viewarticle_id` int(11) NOT NULL AUTO_INCREMENT,
  `nom_hote` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `article_id` int(11) NOT NULL,
  PRIMARY KEY (`viewarticle_id`),
  KEY `article_id` (`article_id`),
  CONSTRAINT `FK_viewsarticles_articles` FOREIGN KEY (`article_id`) REFERENCES `articles` (`article_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table blog.viewsarticles : ~1 rows (environ)
/*!40000 ALTER TABLE `viewsarticles` DISABLE KEYS */;
INSERT INTO `viewsarticles` (`viewarticle_id`, `nom_hote`, `article_id`) VALUES
	(2, 'QV7invdN3dfY8SLpQ7T/XlSYmJl7OuxqR6an0SdrkHY=', 6);
/*!40000 ALTER TABLE `viewsarticles` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
