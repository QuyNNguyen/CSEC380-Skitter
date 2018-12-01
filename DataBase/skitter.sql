CREATE DATABASE  IF NOT EXISTS `skitter`
USE `skitter`;


DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
      `email` varchar(100) NOT NULL,
      `profile_picture` mediumblob,
      PRIMARY KEY (`email`),
      UNIQUE KEY `email_UNIQUE` (`email`),
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `follows`;

CREATE TABLE `follows` (
      `influencer` varchar(10) NOT NULL,
      `follower` varchar(10) NOT NULL,
      PRIMARY KEY (`influencer`,`follower`),
      KEY `follower_data_idx` (`follower`),
      CONSTRAINT `follower_data` FOREIGN KEY (`follower`) REFERENCES `users` (`email`) ON DELETE CASCADE ON UPDATE CASCADE,
      CONSTRAINT `influencer_data` FOREIGN KEY (`influencer`) REFERENCES `users` (`email`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `sessions`;

CREATE TABLE `sessions` (
      `email` varchar(100) NOT NULL,
      `session_id` char(30) DEFAULT NULL,
      PRIMARY KEY (`email`),
      UNIQUE KEY `email_UNIQUE` (`email`),
      UNIQUE KEY `session_id_UNIQUE` (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

