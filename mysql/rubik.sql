DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `niveau` int(11) NOT NULL,
  `nom` VARCHAR(255) NOT NULL,
  `prenom` VARCHAR(255) NOT NULL,
  `mail` VARCHAR(255) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UN_Utilisateur_mail` (`mail`(255))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


INSERT INTO `users` VALUES (1,'2023-02-20 16:00:00','1','admin','admin','admin@rubik.com','21232f297a57a5a743894a0e4a801fc3');


DROP TABLE IF EXISTS `categorie`;

CREATE TABLE `categorie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `description` text CHARACTER SET utf8 NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `categorie` VALUES (1,'Cubique','Ici il y a tous les grand classique cubique. Il y a beaucoup d’options et nous avons toutes les nouvelles. Nous les avons de toutes tailles, du 2x2 au 17x17.'), (2, 'Cuboïde','Les cuboïdes sont un type de puzzle séquentiel qui diffère légèrement des cubes classiques de rubik qui sont totalement cubiques.'), (3, 'Minx','Trouvez une variété de minx : mégaminx, pyraminx, kilominx, gigaminx, teraminx et pétaminx.'), (4, 'Autre', 'Trouvez toutes sorte de puzzle, du plus classique au plus loufoque.');

DROP TABLE IF EXISTS `article`;

CREATE TABLE `article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) NOT NULL,
  `categorie_id` int(11) NOT NULL,
  `title` VARCHAR(255) NOT NULL,
  `image` VARCHAR(255) NOT NULL,
  `description` text CHARACTER SET utf8 NOT NULL,
    PRIMARY KEY (`id`),
  KEY `FK_Article_Categorie` (`categorie_id`),
  KEY `FK_Article_Users` (`user_id`),
  CONSTRAINT `FK_Article_Categorie` FOREIGN KEY (`categorie_id`) REFERENCES `categorie` (`id`),
  CONSTRAINT `FK_Article_Users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `article` VALUES (1,'2023-02-20 16:00:00', 1, 1, 'La classique', 'classique.png', "C'est juste insane"), (2,'2023-02-20 15:00:00', 1, 2, 'Witeden 3*3*7', 'witeden-3x3x7.webp', "Une dinguerie"),(3,'2023-02-20 14:00:00', 1, 3, 'Le nouveaux pentaminx MF8', 'petaminx-mf8.webp', "Une pure folie");

DROP TABLE IF EXISTS `comment`;

CREATE TABLE `comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `comment_text` text CHARACTER SET utf8 NOT NULL,
    `rating` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `article_id` int(11) NOT NULL,
    `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_Comment_Article` (`article_id`),
  KEY `FK_Comment_Users` (`user_id`),
  CONSTRAINT `FK_Comment_Article` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`),
  CONSTRAINT `FK_Comment_Users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;  

INSERT INTO `comment` VALUES (1, 'Ce rubiks est incroyable', 4, 1, 2,'2023-02-20 16:00:00'),(2, "A mourrir d'ennui", 3, 1, 2,'2023-02-22 16:00:00');
