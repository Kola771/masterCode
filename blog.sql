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
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table blog.articles : ~4 rows (environ)
/*!40000 ALTER TABLE `articles` DISABLE KEYS */;
INSERT INTO `articles` (`article_id`, `article_image`, `article_title`, `code_html`, `state`, `category_id`, `user_id`, `created_at`, `updated_at`) VALUES
	(6, 'image647645d17f0f29.58924958.jpg', 'Introduction JavaScript', '<h2 style="text-align: center;"><span style="font-family: \'arial black\', sans-serif; font-size: 18pt; color: rgb(230, 126, 35);"><strong>Welcome to MasterCode</strong></span></h2>\n<p><img style="display: block; margin-left: auto; margin-right: auto;" src="ressources/images/articles_images/image647645737606c4.66314234.jpg" alt="javascript" width="500" height="281"></p>\n<h3 style="text-align: center;"><span style="font-size: 14pt; color: rgb(35, 111, 161);">Essai</span></h3>', 'publier', 18, 3, '2023-05-30 06:52:01', NULL),
	(12, 'image647f4f032c0c94.26525032.jpg', 'Introduction HyperText Modal Langage', '<p>Welcome to MasterCode</p>\n<p><img src="ressources/images/articles_images/image64776f5ba1aa65.52799252.png" alt="" width="600" height="600"></p>\n<p>abonnez-vous sur <a title="w3schools" href="https://www.w3schools.com/">https://www.w3schools.com/</a></p>', 'publier', 20, 13, '2023-05-31 04:01:59', '2023-06-06 03:21:39'),
	(14, 'image6479d0c75f9776.99242572.jpg', 'CSS Padding', '<h3 style="text-align: center;"><span style="font-family: helvetica, arial, sans-serif; color: rgb(230, 126, 35);"><strong>Bienvenue chers lecteurs!</strong></span></h3>\n<p>Le cours d\'aujourd\'hui va porter sur une propri&eacute;t&eacute; du <strong><span style="color: rgb(230, 126, 35);">CSS. <span style="color: rgb(224, 62, 45);">Soyez attentifs.</span></span></strong></p>\n<p><strong><span style="color: rgb(230, 126, 35);"><span style="color: rgb(224, 62, 45);"><img style="display: block; margin-left: auto; margin-right: auto;" src="ressources/images/articles_images/image6479d096ab33d5.75613923.jpg" alt="" width="800" height="250"></span></span></strong></p>\n<p><span style="color: rgb(0, 0, 0);">Text</span></p>', 'publier', 21, 13, '2023-06-02 11:21:43', NULL),
	(15, 'image647a23948b0e33.89649666.jpg', 'Comment déclarer une variable en php ?', '<h2 style="text-align: center;"><span style="font-size: 18pt;"><strong><span style="color: rgb(230, 126, 35);">D&eacute;claration en PHP</span></strong></span></h2>\n<p><img style="display: block; margin-left: auto; margin-right: auto;" src="ressources/images/articles_images/image647a230d5943f0.16819215.png" alt="" width="600" height="338"></p>\n<p>D&eacute;clar&eacute; une variable en PHP est :</p>', 'publier', 16, 16, '2023-06-02 05:15:00', NULL);
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
	(19, 'category_image-6479fb2c0756f2.14318116.png', 'Java', 'Langage très vieux'),
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
) ENGINE=InnoDB AUTO_INCREMENT=71 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table blog.comments : ~7 rows (environ)
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
INSERT INTO `comments` (`comment_id`, `comment_body`, `user_id`, `article_id`, `created_at`) VALUES
	(10, '@Tiburce très drôle', 11, 12, '2023-06-01 04:42:17'),
	(11, 'Très intéressant', 15, 6, '2023-06-01 04:53:15'),
	(14, '@Tiburce boss ça va ?<br />\nBien j\'espère', 11, 6, '2023-06-01 05:28:03'),
	(62, '@ericaz99 Coucou par ici<br />\nça va😎?', 15, 12, '2023-06-01 08:49:13'),
	(63, 'Coucou les gars<br />\n😏', 16, 15, '2023-06-05 07:59:19'),
	(64, '@kola comment tu vas ?', 13, 15, '2023-06-05 11:51:27'),
	(65, 'Salut tout le monde ', 13, 15, '2023-06-05 11:51:43'),
	(66, '@ericaz99 hi', 16, 12, '2023-06-05 11:58:15'),
	(67, 'Bonjour', 3, 14, '2023-06-06 05:47:50'),
	(68, '@marcos comment vas-tu ?', 16, 14, '2023-06-06 05:48:29'),
	(69, 'Bonjour les gars ?', 16, 14, '2023-06-06 05:48:41'),
	(70, '@geoffroy cc', 3, 15, '2023-06-06 05:55:46');
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table blog.contacts : ~2 rows (environ)
/*!40000 ALTER TABLE `contacts` DISABLE KEYS */;
INSERT INTO `contacts` (`contact_id`, `contact_email`, `contact_name`, `contact_theme`, `contact_body`, `state`, `created_at`) VALUES
	(2, 'kol@gmail.com', 'kola', 'text', 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ex non dolorum ab rerum quam doloribus quia tempore quidem, sunt magnam praesentium. Numquam ab minus officiis voluptates consequatur ratione ex ipsum dolore quidem nihil, ullam rem eveniet vel libero quos ad odio sapiente quod reprehenderit voluptate quo doloribus dolor laborum sint? Aspernatur labore exercitationem sunt dolorem similique fugiat error mollitia. Autem minima odit nobis sequi id, laudantium cum dolorem tenetur, quibusdam consequatur ullam corporis facere iusto eos, eveniet a harum. Tenetur, consectetur saepe. Exercitationem quam excepturi nemo doloremque deserunt ad dolorum, eligendi, tempora minima reprehenderit impedit quis dolorem quod sapiente ducimus.', 'valide', '2023-05-27 15:37:51'),
	(3, 'marcos@gmail.com', 'marcos', 'text', 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ex non dolorum ab rerum quam doloribus quia tempore quidem, sunt magnam praesentium. Numquam ab minus officiis voluptates consequatur ratione ex ipsum dolore quidem nihil, ullam rem eveniet vel libero quos ad odio sapiente quod reprehenderit voluptate quo doloribus dolor laborum sint? Aspernatur labore exercitationem sunt dolorem similique fugiat error mollitia. Autem minima odit nobis sequi id, laudantium cum dolorem tenetur, quibusdam consequatur ullam corporis facere iusto eos, eveniet a harum. Tenetur, consectetur saepe. Exercitationem quam excepturi nemo doloremque deserunt ad dolorum, eligendi, tempora minima reprehenderit ', 'attente', '2023-06-02 15:57:55');
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
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table blog.datasusers : ~6 rows (environ)
/*!40000 ALTER TABLE `datasusers` DISABLE KEYS */;
INSERT INTO `datasusers` (`datasuser_id`, `article_id`, `user_id`, `created_at`) VALUES
	(7, 6, 15, '2023-06-02 05:09:53'),
	(10, 12, 15, '2023-06-02 07:25:31'),
	(12, 15, 15, '2023-06-01 07:36:05'),
	(13, 15, 16, '2023-06-02 07:42:17'),
	(14, 6, 16, '2023-06-05 02:16:18'),
	(15, 12, 16, '2023-06-05 02:33:52'),
	(16, 14, 16, '2023-06-06 05:42:06'),
	(17, 14, 3, '2023-06-06 05:47:19'),
	(18, 15, 3, '2023-06-06 05:47:21');
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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table blog.likes : ~4 rows (environ)
/*!40000 ALTER TABLE `likes` DISABLE KEYS */;
INSERT INTO `likes` (`like_id`, `article_id`, `user_id`) VALUES
	(1, 12, 16),
	(3, 15, 13),
	(4, 15, 16),
	(5, 14, 3),
	(6, 12, 3);
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
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table blog.users : ~5 rows (environ)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`user_id`, `user_email`, `email_code`, `user_pseudo`, `user_role`, `user_password`, `user_bgc`, `created_at`, `updated_at`) VALUES
	(3, 'marcosmedenou@gmail.com', NULL, 'marcos', '0', '$2y$10$ppEg5kJHwAoXUOhnQnio/OmZhu4q1yzlph33fKOpiDH.z6aOs5t22', '#D2691E', '2023-04-04 09:02:54', NULL),
	(11, 'erikazankpo@gmail.com', NULL, 'ericaz99', '0', '$2y$10$DlbYGLxKWO6yZw8zQlQKu.RBXOmIomhJy124g4P0ZRWu85XFvudk2', '#FFFACD', '2023-05-26 03:31:33', '2023-05-30 08:20:41'),
	(13, 'geoffroyotegbeye@gmail.com', NULL, 'geoffroy', '2', '$2y$10$lexm1Iu/yj7FQlEOgFEjzevkWmkrZv9qh2kF0XMO2YCWybOdLqBTO', '#48D1CC', '2023-05-30 07:38:15', '2023-05-31 04:06:20'),
	(14, 'masterCode@gmail.com', NULL, 'SuperAdmin', '0', '$2y$10$nIIV1.2QxvTEFmXzbw7hUOIGSzMYIAIL2v9paVJgFiVTTJf5hgWwG', '#ADFF2F', '2023-05-30 10:42:24', '2023-05-30 10:42:59'),
	(15, 'tiburcekouagou@gmail.com', NULL, 'Tiburce', '1', '$2y$10$aBp7Ep8wtLYxRvaggiBQGuxRZF3H7pDBSTyfzVvsmz5/VXO90iMLG', '#0000FF', '2023-05-31 01:43:41', NULL),
	(16, 'koladeaboudou@gmail.com', NULL, 'kola', '0', '$2y$10$5imJ/B75Gs0tLB1Os6Bq3eG1mxhfk1/rpM8RBTRVePM.xv7IhZIZq', '#F32F05', '2023-06-02 01:54:32', NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

-- Listage de la structure de la table blog. viewsarticles
CREATE TABLE IF NOT EXISTS `viewsarticles` (
  `viewarticle_id` int(11) NOT NULL AUTO_INCREMENT,
  `nom_hote` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `article_id` int(11) NOT NULL,
  PRIMARY KEY (`viewarticle_id`),
  KEY `article_id` (`article_id`),
  CONSTRAINT `FK_viewsarticles_articles` FOREIGN KEY (`article_id`) REFERENCES `articles` (`article_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table blog.viewsarticles : ~4 rows (environ)
/*!40000 ALTER TABLE `viewsarticles` DISABLE KEYS */;
INSERT INTO `viewsarticles` (`viewarticle_id`, `nom_hote`, `article_id`) VALUES
	(18, 'icgokiAKlEYgJLQlz94DYwOi[plus]dAzR1TAaDC820sTDOE=', 6),
	(19, 'UN5W0Sz0NoFur2VJ1CTqRoKnBGd6J6eVAcsozas7R1eVfP[plus]UeZ/B5Szxe20Db1EE', 12),
	(21, 'Lh5yhjsqDP3iiJz7xFZh[plus]5wtdrTV2h3[plus]weUjqDTtfUtKYys2e6g6s60uAEGoUAHW', 6),
	(22, 'I8lfiOvy6[plus]6lk//Iglf4S9EWQXepwV[plus]nVEvjpvVw4VI=', 12),
	(23, '8ZfVOmpIg5vjFhu4DjyBHmFqCcYcb[plus]r3qarhagEWDRwV66O5AkRIiDfnx25mpAl0', 15),
	(24, '7MOy55elFEvEeyUpZKGw[plus]ib[plus]VqlKHhEAneHrNIyaqlxuDT2mT92Inu/xbRz8/vJk', 14);
/*!40000 ALTER TABLE `viewsarticles` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
