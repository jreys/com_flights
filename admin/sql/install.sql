CREATE TABLE IF NOT EXISTS `#__airports` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`title` VARCHAR(255) NOT NULL,
	`country` VARCHAR(100) NOT NULL,
	`city` VARCHAR(100) NOT NULL,
	`published` tinyint(3) NOT NULL DEFAULT '0',
	`created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
	PRIMARY KEY (id)
)
CHARACTER SET utf8
COLLATE utf8_general_ci;

INSERT INTO `#__airports` (title, country, city, published, created) VALUES 
	('Hartsfield Jackson Atlanta International', 'United States', 'Atlanta', '1', NOW());
INSERT INTO `#__airports` (title, country, city, published, created) VALUES 
	('Beijing Capital International', 'China', 'Beijing', '1', NOW());
INSERT INTO `#__airports` (title, country, city, published, created) VALUES 
	('London Heathrow', 'United Kingdom', 'London', '1', NOW());
INSERT INTO `#__airports` (title, country, city, published, created) VALUES 
	('Tokyo International', 'Japan', 'Tokyo', '1', NOW());



CREATE TABLE IF NOT EXISTS `#__flights` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`origin` int(11) unsigned NOT NULL,
	`destination` int(11) unsigned NOT NULL,
	`seats` VARCHAR(100) NOT NULL,
	`departure` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
	`published` tinyint(3) NOT NULL DEFAULT '0',
	`created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
	PRIMARY KEY (id),
	FOREIGN KEY (`origin`) REFERENCES `#__airports` (`id`) ON DELETE CASCADE,
	FOREIGN KEY (`destination`) REFERENCES `#__airports` (`id`) ON DELETE CASCADE
)
CHARACTER SET utf8
COLLATE utf8_general_ci;

INSERT INTO `#__flights` (origin, destination, seats, published, created) VALUES 
	('1', '2', '400', '1', NOW());
INSERT INTO `#__flights` (origin, destination, seats, published, created) VALUES 
	('2', '1', '450', '1', NOW());
INSERT INTO `#__flights` (origin, destination, seats, published, created) VALUES 
	('1', '3', '300', '1', NOW());
INSERT INTO `#__flights` (origin, destination, seats, published, created) VALUES 
	('1', '4', '300', '1', NOW());

CREATE TABLE IF NOT EXISTS `#__bookings` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`user_id` int(11) NOT NULL,
	`flight_id` int(11) unsigned NOT NULL,
	`published` tinyint(3) NOT NULL DEFAULT '0',
	`created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
	PRIMARY KEY (id),
	FOREIGN KEY (`user_id`) REFERENCES `#__users` (`id`) ON DELETE CASCADE,
	FOREIGN KEY (`flight_id`) REFERENCES `#__flights` (`id`) ON DELETE CASCADE
)
CHARACTER SET utf8
COLLATE utf8_general_ci;
