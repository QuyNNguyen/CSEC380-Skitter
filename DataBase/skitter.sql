CREATE DATABASE  IF NOT EXISTS `skitter`;
USE `skitter`;

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
      `rit_user` varchar(10) NOT NULL,
      `email` varchar(100) NOT NULL,
      `display_name` varchar(30) NOT NULL,
      `profile_picture` mediumblob,
      PRIMARY KEY (`rit_user`),
      UNIQUE KEY `email_UNIQUE` (`email`),
      UNIQUE KEY `rit_user_UNIQUE` (`rit_user`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `follows`;
CREATE TABLE `follows` (
      `influencer` varchar(10) NOT NULL,
      `follower` varchar(10) NOT NULL,
      PRIMARY KEY (`influencer`,`follower`),
      KEY `follower_data_idx` (`follower`),
      CONSTRAINT `follower_data` FOREIGN KEY (`follower`) REFERENCES `users` (`rit_user`) ON DELETE CASCADE ON UPDATE CASCADE,
      CONSTRAINT `influencer_data` FOREIGN KEY (`influencer`) REFERENCES `users` (`rit_user`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions` (
      `username` varchar(10) NOT NULL,
      `session_id` char(30) DEFAULT NULL,
      PRIMARY KEY (`username`),
      UNIQUE KEY `username_UNIQUE` (`username`),
      UNIQUE KEY `session_id_UNIQUE` (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `users` WRITE;
INSERT INTO `users` VALUES ('bob1234','bob@skitter.com','Bob McAlister', NULL), ('joe5678','joe@skitter.com','Joe Smith', NULL);
UNLOCK TABLES;

