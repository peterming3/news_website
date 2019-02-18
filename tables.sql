| users | CREATE TABLE `users` (
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 |
| story | CREATE TABLE `story` (
  `story_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) CHARACTER SET utf8 NOT NULL,
  `title` tinytext CHARACTER SET utf8 NOT NULL,
  `content` mediumtext CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`story_id`),
  KEY `username` (`username`),
  CONSTRAINT `story_ibfk_1` FOREIGN KEY (`username`) REFERENCES `users` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1 |
| comments | CREATE TABLE `comments` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `story_id` mediumint(8) unsigned NOT NULL,
  `username` varchar(50) CHARACTER SET utf8 NOT NULL,
  `content` text CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`),
  KEY `comments_ibfk_1` (`username`),
  KEY `comments_ibfk_2` (`story_id`),
  CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`story_id`) REFERENCES `story` (`story_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`username`) REFERENCES `users` (`username`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1 |
| links | CREATE TABLE `links` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `story_id` mediumint(8) unsigned NOT NULL,
  `username` varchar(50) CHARACTER SET utf8 NOT NULL,
  `content` text CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`),
  KEY `story_id` (`story_id`),
  KEY `username` (`username`),
  CONSTRAINT `links_ibfk_2` FOREIGN KEY (`username`) REFERENCES `users` (`username`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `links_ibfk_1` FOREIGN KEY (`story_id`) REFERENCES `story` (`story_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1 |
| personal_profile | CREATE TABLE `personal_profile` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `nickname` varchar(50) DEFAULT NULL,
  `personal_web` varchar(255) DEFAULT NULL,
  `profile_photo` varchar(255) DEFAULT NULL,
  `following_number` mediumint(8) unsigned DEFAULT '0',
  `follower_number` mediumint(8) unsigned DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `username` (`username`),
  CONSTRAINT `personal_profile_ibfk_1` FOREIGN KEY (`username`) REFERENCES `users` (`username`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 |

