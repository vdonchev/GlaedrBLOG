-- --------------------------------------------------------
-- Хост:                         127.0.0.1
-- Версия на сървъра:            10.1.13-MariaDB - mariadb.org binary distribution
-- ОС на сървъра:                Win32
-- HeidiSQL Версия:              9.4.0.5125
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Дъмп структура за таблица blog.comments
CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `authorId` int(10) unsigned NOT NULL,
  `postId` int(10) unsigned NOT NULL,
  `body` text NOT NULL,
  `createdOn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedOn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deletedOn` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_comments_users` (`authorId`),
  KEY `FK_comments_posts` (`postId`),
  CONSTRAINT `FK_comments_posts` FOREIGN KEY (`postId`) REFERENCES `posts` (`id`),
  CONSTRAINT `FK_comments_users` FOREIGN KEY (`authorId`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дъмп данни за таблица blog.comments: ~0 rows (approximately)
DELETE FROM `comments`;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;

-- Дъмп структура за таблица blog.posts
CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `authorId` int(10) unsigned NOT NULL DEFAULT '0',
  `title` varchar(255) NOT NULL DEFAULT '0',
  `body` text NOT NULL,
  `createdOn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedOn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deletedOn` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK__users` (`authorId`),
  CONSTRAINT `FK__users` FOREIGN KEY (`authorId`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дъмп данни за таблица blog.posts: ~0 rows (approximately)
DELETE FROM `posts`;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;

-- Дъмп структура за таблица blog.posts_tags
CREATE TABLE IF NOT EXISTS `posts_tags` (
  `postId` int(10) unsigned NOT NULL,
  `tagId` int(10) unsigned NOT NULL,
  PRIMARY KEY (`postId`,`tagId`),
  UNIQUE KEY `postId_tagId` (`postId`,`tagId`),
  KEY `FK_posts_tags_tags` (`tagId`),
  CONSTRAINT `FK_posts_tags_posts` FOREIGN KEY (`postId`) REFERENCES `posts` (`id`),
  CONSTRAINT `FK_posts_tags_tags` FOREIGN KEY (`tagId`) REFERENCES `tags` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дъмп данни за таблица blog.posts_tags: ~0 rows (approximately)
DELETE FROM `posts_tags`;
/*!40000 ALTER TABLE `posts_tags` DISABLE KEYS */;
/*!40000 ALTER TABLE `posts_tags` ENABLE KEYS */;

-- Дъмп структура за таблица blog.post_views
CREATE TABLE IF NOT EXISTS `post_views` (
  `id` int(10) unsigned NOT NULL,
  `views` int(10) NOT NULL DEFAULT '0',
  KEY `FK__posts` (`id`),
  CONSTRAINT `FK__posts` FOREIGN KEY (`id`) REFERENCES `posts` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дъмп данни за таблица blog.post_views: ~0 rows (approximately)
DELETE FROM `post_views`;
/*!40000 ALTER TABLE `post_views` DISABLE KEYS */;
/*!40000 ALTER TABLE `post_views` ENABLE KEYS */;

-- Дъмп структура за таблица blog.tags
CREATE TABLE IF NOT EXISTS `tags` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дъмп данни за таблица blog.tags: ~0 rows (approximately)
DELETE FROM `tags`;
/*!40000 ALTER TABLE `tags` DISABLE KEYS */;
/*!40000 ALTER TABLE `tags` ENABLE KEYS */;

-- Дъмп структура за таблица blog.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL DEFAULT '0',
  `password` varchar(255) NOT NULL DEFAULT '0',
  `roleId` int(11) unsigned NOT NULL,
  `createdOn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedOn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  KEY `FK_users_user_roles` (`roleId`),
  CONSTRAINT `FK_users_user_roles` FOREIGN KEY (`roleId`) REFERENCES `user_roles` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- Дъмп данни за таблица blog.users: ~2 rows (approximately)
DELETE FROM `users`;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `username`, `password`, `roleId`, `createdOn`, `updatedOn`) VALUES
	(9, 'videlin', '$2y$10$rp7f6rWK3OBYKxER32QIyO.qruIgQjW/mK/tF1gA7WYOnd3wCd2XG', 2, '2017-03-05 19:47:53', '2017-03-06 11:55:45'),
	(10, 'admin', '$2y$10$tViY3e4wQxfYAopgiAjcM.uxFKd42LVqWPabp7zfoADIKXzzOWzHK', 1, '2017-03-06 11:55:20', '2017-03-06 11:55:45');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

-- Дъмп структура за таблица blog.user_roles
CREATE TABLE IF NOT EXISTS `user_roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Дъмп данни за таблица blog.user_roles: ~2 rows (approximately)
DELETE FROM `user_roles`;
/*!40000 ALTER TABLE `user_roles` DISABLE KEYS */;
INSERT INTO `user_roles` (`id`, `name`) VALUES
	(1, 'admin'),
	(2, 'user');
/*!40000 ALTER TABLE `user_roles` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
