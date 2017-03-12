/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `authorId` int(10) unsigned DEFAULT NULL,
  `guestId` int(10) unsigned DEFAULT NULL,
  `postId` int(10) unsigned NOT NULL,
  `body` text NOT NULL,
  `createdOn` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedOn` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deletedOn` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_comments_users` (`authorId`),
  KEY `FK_comments_posts` (`postId`),
  KEY `FK_comments_guests` (`guestId`),
  CONSTRAINT `FK_comments_guests` FOREIGN KEY (`guestId`) REFERENCES `guests` (`id`),
  CONSTRAINT `FK_comments_posts` FOREIGN KEY (`postId`) REFERENCES `posts` (`id`),
  CONSTRAINT `FK_comments_users` FOREIGN KEY (`authorId`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

DELETE FROM `comments`;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
INSERT INTO `comments` (`id`, `authorId`, `guestId`, `postId`, `body`, `createdOn`, `updatedOn`, `deletedOn`) VALUES
	(8, NULL, 6, 17, 'dve nazad', '2017-03-11 12:47:54', '2017-03-12 08:37:15', '2017-03-12 08:37:15'),
	(9, 10, NULL, 13, 'asd', '2017-03-11 13:24:06', '2017-03-12 08:32:09', '2017-03-12 08:32:09'),
	(10, 10, NULL, 7, 'Хубав коментар :)', '2017-03-11 13:27:19', '2017-03-11 13:27:19', NULL),
	(11, NULL, 7, 17, 'Moqt komentar\r\nИ малко кириличка', '2017-03-11 13:28:25', '2017-03-12 08:28:56', '2017-03-12 08:28:56'),
	(12, 10, NULL, 13, 'sdf', '2017-03-11 13:34:07', '2017-03-12 08:32:07', '2017-03-12 08:32:07'),
	(13, 10, NULL, 13, 'azsdasd', '2017-03-11 13:34:16', '2017-03-11 13:34:16', NULL),
	(14, NULL, 8, 13, 'da dobavq i az ko', '2017-03-11 13:37:10', '2017-03-11 13:37:10', NULL),
	(15, NULL, 9, 17, 'mn qk komentar iskam da napisha.... no ne mi idva na akyla kakvo tocho da ima v nego', '2017-03-11 13:40:34', '2017-03-11 13:40:34', NULL),
	(16, 10, NULL, 15, 'asd', '2017-03-11 15:11:34', '2017-03-11 15:11:34', NULL),
	(17, 10, NULL, 14, 'Post', '2017-03-11 15:22:31', '2017-03-11 15:22:31', NULL),
	(18, 10, NULL, 14, 'НОв коментар', '2017-03-11 15:22:40', '2017-03-11 15:22:40', NULL),
	(19, 9, NULL, 17, 'коментарче', '2017-03-11 15:28:26', '2017-03-11 15:28:26', NULL),
	(20, 10, NULL, 17, 'к', '2017-03-11 17:52:08', '2017-03-12 08:28:01', '2017-03-12 08:28:01'),
	(21, 10, NULL, 36, '<script>', '2017-03-12 07:50:45', '2017-03-12 07:50:45', NULL),
	(22, 10, NULL, 37, 'КОментар', '2017-03-12 08:16:01', '2017-03-12 08:27:51', '2017-03-12 08:27:51'),
	(23, 10, NULL, 17, 'Нов комент', '2017-03-12 08:54:36', '2017-03-12 08:54:40', '2017-03-12 08:54:40'),
	(24, 9, NULL, 17, 'Айде още един', '2017-03-12 09:45:52', '2017-03-12 09:45:52', NULL);
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `guests` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `ip` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

DELETE FROM `guests`;
/*!40000 ALTER TABLE `guests` DISABLE KEYS */;
INSERT INTO `guests` (`id`, `name`, `email`, `ip`) VALUES
	(6, 'Dicho', 'd2ideo@gmail.com', 2130706433),
	(7, 'Виделин Дончев', 'c0nt4c7@gmail.com', 2130706433),
	(8, 'Evgenii Nazarov', 'c0nt4c7@gmail.com', 2130706433),
	(9, 'Videlin Donchev', 'c0nt4c7@gmail.com', 2130706433);
/*!40000 ALTER TABLE `guests` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `authorId` int(10) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `views` int(10) unsigned NOT NULL DEFAULT '0',
  `createdOn` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedOn` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deletedOn` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK__users` (`authorId`),
  CONSTRAINT `FK__users` FOREIGN KEY (`authorId`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8;

DELETE FROM `posts`;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
INSERT INTO `posts` (`id`, `authorId`, `title`, `body`, `views`, `createdOn`, `updatedOn`, `deletedOn`) VALUES
	(3, 10, 'Algorithm', 'In mathematics and computer science, an algorithm (Listeni/ˈælɡərɪðəm/ al-gə-ri-dhəm) is a self-contained sequence of actions to be performed. Algorithms perform calculation, data processing, and/or automated reasoning tasks.\r\n\r\nAn algorithm is an effective method that can be expressed within a finite amount of space and time[1] and in a well-defined formal language[2] for calculating a function.[3] Starting from an initial state and initial input (perhaps empty),[4] the instructions describe a computation that, when executed, proceeds through a finite[5] number of well-defined successive states, eventually producing "output"[6] and terminating at a final ending state. The transition from one state to the next is not necessarily deterministic; some algorithms, known as randomized algorithms, incorporate random input.[7]\r\n\r\nThe concept of algorithm has existed for centuries; however, a partial formalization of what would become the modern algorithm began with attempts to solve the Entscheidungsproblem (the "decision problem") posed by David Hilbert in 1928. Subsequent formalizations were framed as attempts to define "effective calculability"[8] or "effective method";[9] those formalizations included the Gödel–Herbrand–Kleene recursive functions of 1930, 1934 and 1935, Alonzo Church\'s lambda calculus of 1936, Emil Post\'s "Formulation 1" of 1936, and Alan Turing\'s Turing machines of 1936–7 and 1939. Giving a formal definition of algorithms, corresponding to the intuitive notion, remains a challenging problem.[10]', 0, '2017-03-09 21:56:23', '2017-03-11 18:44:48', NULL),
	(4, 10, 'Dependency injection', 'In software engineering, dependency injection is a technique whereby one object supplies the dependencies of another object. A dependency is an object that can be used (a service). An injection is the passing of a dependency to a dependent object (a client) that would use it. The service is made part of the client\'s state.[1] Passing the service to the client, rather than allowing a client to build or find the service, is the fundamental requirement of the pattern.', 0, '2017-03-09 21:57:04', '2017-03-10 08:17:44', NULL),
	(5, 10, 'Какво е Рекурсия', 'В програмирането с рекурсия се обозначава случай, когато една подпрограма вика предходна своя функция. Рекурсията условно се разделя в две категории: директна (пряка) и индиректна (косвена). Рекурсията е пряка, когато в тялото на подпрограмата има референция към нея. Косвена е тази рекурсия, при която една подпрограма вика друга, а тя вика предходната. Съществуват и случаи на косвена рекурсия, при които подпрограмата извиква себе си, след поредица от обръщения към други подпрограми.', 0, '2017-03-10 08:18:44', '2017-03-10 08:18:44', NULL),
	(7, 10, 'Lazy loading pattern', 'Lazy loading is a design pattern commonly used in computer programming to defer initialization of an object until the point at which it is needed. It can contribute to efficiency in the program\'s operation if properly and appropriately used. The opposite of lazy loading is eager loading.', 0, '2017-03-10 08:19:34', '2017-03-10 08:19:34', NULL),
	(8, 10, 'Конструктор (обектно-ореинтирано програмиране) d', 'a В обектно-ориентираното програмиране конструкторът е блок от инструкции, който се изпълнява за инициализация на един обект при неговото създаване. Практически  dконструкторът може да извършва всякакъв вид действия, но ако не друго, то е поне признак за много лош стил на програмиране да се изполва за действия, които не засягат пряко създавания обект, тъй като това може да доведе до неочаквани грешки, особено в големи програми. В езика за програмиране C++ конструкторът се представя като член-функция на един обект, носеща същото име като него. Тя и деструкторът са единствените типове дефиниции на функции, за които не се дефинира тип на връщания резултат. В тази статия примерите са дадени на този език.', 0, '2017-03-10 08:20:03', '2017-03-10 17:55:42', NULL),
	(9, 10, 'Парадигма на програмиране', 'Парадигмата на програмиране, парадигма за програмиране или програмна парадигма представлява фундаменталния стил на програмиране. Има множество програмни парадигми, но основните сред тях са: обектно-ориентирано, императивно, функционално и декларативно [1].', 0, '2017-03-10 08:20:41', '2017-03-11 18:37:55', NULL),
	(10, 10, 'Graph (discrete mathematics)', 'In mathematics, and more specifically in graph theory, a graph is a structure amounting to a set of objects in which some pairs of the objects are in some sense "related". The objects correspond to mathematical abstractions called vertices (also called nodes or points) and each of the related pairs of vertices is called an edge (also called an arc or line).[1] Typically, a graph is depicted in diagrammatic form as a set of dots for the vertices, joined by lines or curves for the edges. Graphs are one of the objects of study in discrete mathematics.', 0, '2017-03-10 08:21:19', '2017-03-11 18:37:57', NULL),
	(11, 10, 'Depth-first search (DFS)', 'Depth-first search (DFS) is an algorithm for traversing or searching tree or graph data structures. One starts at the root (selecting some arbitrary node as the root in the case of a graph) and explores as far as possible along each branch before backtracking.', 0, '2017-03-10 08:22:01', '2017-03-11 18:40:46', NULL),
	(13, 10, 'Breadth-first search (BFS)', 'Breadth-first search (BFS) is an algorithm for traversing or searching tree or graph data structures. It starts at the tree root (or some arbitrary node of a graph, sometimes referred to as a \'search key\'[1]) and explores the neighbor nodes first, before moving to the next level neighbors.', 0, '2017-03-10 08:22:39', '2017-03-11 18:40:44', NULL),
	(14, 10, 'Едсхер Дейкстра', 'Едсхер Дейкстра (понякога неправилно изписвано Дийкстра; на нидерландски: Edsger Wybe Dijkstra, нидерландско произношение: [ˈɛtsxər ˈwibə ˈdɛɪkstra]) е нидерландски информатик. През 1972 г. получава наградата „А. М. Тюринг“ за основополагащите си приноси за развитие на езиците за програмиране. Бил е Шлумбергер сентениял професор по компютърни науки в Тексаския университет в Остин от 1984 до 2000 г.[1]\r\n\r\nПрез 2003 г. наградата ACM PODC за влиятелини научни публикации върху принципите на разпределените изчислителни системи е преименувана на Премия Дейкстра.[1]\r\n\r\nПръв въвежда термина структурно програмиране в информатиката. Автор на едноименния алгоритъм.[1]', 2, '2017-03-10 08:23:16', '2017-03-12 08:50:10', NULL),
	(15, 10, 'Dijkstra\'s algorithm', 'Dijkstra\'s algorithm is an algorithm for finding the shortest paths between nodes in a graph, which may represent, for example, road networks. It was conceived by computer scientist Edsger W. Dijkstra in 1956 and published three years later.[1][2]', 5, '2017-03-10 08:23:47', '2017-03-12 08:49:39', NULL),
	(17, 10, 'Bogosort Algorithm', 'In computer science, bogosort[1][2] (also permutation sort, stupid sort,[3] slowsort,[4] shotgun sort or monkey sort) is a highly ineffective sorting algorithm based on the generate and test paradigm. The algorithm successively generates permutations of its input until it finds one that is sorted. It is not useful for sorting, but may be used for educational purposes, to contrast it with more efficient algorithms. .', 9, '2017-03-10 08:25:00', '2017-03-12 09:45:52', NULL),
	(33, 10, 'Нов пост', 'Някъв контент', 0, '2017-03-11 14:23:44', '2017-03-12 08:29:12', '2017-03-12 08:29:12'),
	(34, 10, 'ас', 'дасд', 0, '2017-03-11 17:51:48', '2017-03-12 08:29:09', '2017-03-12 08:29:09'),
	(35, 10, 'asd', 'asd', 0, '2017-03-12 07:38:06', '2017-03-12 07:57:24', '2017-03-12 07:57:24'),
	(36, 10, '<script>', '<script>', 0, '2017-03-12 07:45:23', '2017-03-12 08:29:07', '2017-03-12 08:29:07'),
	(37, 10, 'Test', 'Pak test', 0, '2017-03-12 08:05:28', '2017-03-12 08:29:05', '2017-03-12 08:29:05');
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `post_tags` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `postId` int(10) unsigned NOT NULL,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_post_tags_posts` (`postId`),
  CONSTRAINT `FK_post_tags_posts` FOREIGN KEY (`postId`) REFERENCES `posts` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8;

DELETE FROM `post_tags`;
/*!40000 ALTER TABLE `post_tags` DISABLE KEYS */;
INSERT INTO `post_tags` (`id`, `postId`, `name`) VALUES
	(1, 3, 'algo'),
	(2, 3, 'math'),
	(3, 3, 'Алгоритъм'),
	(28, 33, 'тагче'),
	(29, 33, 'друго тагче'),
	(30, 33, 'последно'),
	(31, 34, 'асд'),
	(32, 35, 'asd asdaa sda djJJ s'),
	(33, 35, '123'),
	(34, 36, '<script>'),
	(39, 37, 'tag01'),
	(40, 37, 'tag'),
	(41, 37, 'putag'),
	(42, 17, 'сортиране'),
	(43, 17, 'permutation sort');
/*!40000 ALTER TABLE `post_tags` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `templates` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `cssFile` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

DELETE FROM `templates`;
/*!40000 ALTER TABLE `templates` DISABLE KEYS */;
INSERT INTO `templates` (`id`, `name`, `cssFile`) VALUES
	(1, 'blue', 'blue.min.css'),
	(2, 'light', 'light.min.css'),
	(3, 'dark', 'dark.min.css'),
	(4, 'darkly', 'darkly.min.css'),
	(5, 'cyborg', 'cyborg.min.css'),
	(6, 'united', 'united.min.css');
/*!40000 ALTER TABLE `templates` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `roleId` int(11) unsigned NOT NULL DEFAULT '2',
  `templateId` int(11) unsigned NOT NULL DEFAULT '1',
  `createdOn` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedOn` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  KEY `FK_users_user_roles` (`roleId`),
  KEY `FK_users_templates` (`templateId`),
  CONSTRAINT `FK_users_templates` FOREIGN KEY (`templateId`) REFERENCES `templates` (`id`),
  CONSTRAINT `FK_users_user_roles` FOREIGN KEY (`roleId`) REFERENCES `user_roles` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

DELETE FROM `users`;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `username`, `password`, `name`, `email`, `roleId`, `templateId`, `createdOn`, `updatedOn`) VALUES
	(9, 'videlin', '$2y$10$rp7f6rWK3OBYKxER32QIyO.qruIgQjW/mK/tF1gA7WYOnd3wCd2XG', 'Виделин', 'videlin@gmail.com', 2, 6, '2017-03-05 19:47:53', '2017-03-12 09:45:15'),
	(10, 'admin', '$2y$10$tViY3e4wQxfYAopgiAjcM.uxFKd42LVqWPabp7zfoADIKXzzOWzHK', 'SysOP', 'admin@blog.dev', 1, 6, '2017-03-06 11:55:20', '2017-03-12 08:53:12'),
	(11, 'test', '$2y$10$qxk4Mhc535BFFQFhE8VjnONH17gyXwF9pQpTQqShXixShqTgBXNn.', 'Божинов', 'test@dir.nik', 2, 2, '2017-03-10 10:45:20', '2017-03-11 10:18:20'),
	(12, 'anotherTest', '$2y$10$vgNt2Q5LRoaSsfwS4eeP7ODzeqyHJ9tFPtgMnP7GgupT51LqmbS8S', 'Наско', 'anotherTest@abv.bg', 2, 1, '2017-03-11 10:57:37', '2017-03-11 11:09:42');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `user_roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

DELETE FROM `user_roles`;
/*!40000 ALTER TABLE `user_roles` DISABLE KEYS */;
INSERT INTO `user_roles` (`id`, `name`) VALUES
	(1, 'admin'),
	(2, 'user');
/*!40000 ALTER TABLE `user_roles` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
