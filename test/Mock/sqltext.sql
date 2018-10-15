DROP TABLE IF EXISTS `movie`;
CREATE TABLE `movie`
(
    `id` INTEGER PRIMARY KEY NOT NULL,
    `title` VARCHAR(100) NOT NULL,
    `director` VARCHAR(100),
    `length` INT DEFAULT NULL,
    `year` INT NOT NULL DEFAULT 1900,
    `plot` TEXT,
    `image` VARCHAR(100) DEFAULT NULL,
    `subtext` CHAR(3) DEFAULT NULL,
    `speech` CHAR(3) DEFAULT NULL,
    `quality` CHAR(3) DEFAULT NULL,
    `format` CHAR(3) DEFAULT NULL
);


DELETE FROM `movie`;
INSERT INTO `movie` (`title`, `year`, `image`) VALUES
    ('Pulp fiction', 1994, 'img/pulp-fiction.jpg'),
    ('American Pie', 1999, 'img/american-pie.jpg'),
    ('Pokémon The Movie 2000', 1999, 'img/pokemon.jpg'),  
    ('Kopps', 2003, 'img/kopps.jpg'),
    ('From Dusk Till Dawn', 1996, 'img/from-dusk-till-dawn.jpg')
;

SELECT * FROM `movie`;
