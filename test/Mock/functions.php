<?php
/**
 * Functions for the database
 */


/**
 * Create thesqlite table
 */
function doCreateSqliteTable($db)
{
    $sql = "DROP TABLE IF EXISTS `movie`";
    $db->execute($sql);

    $sql = <<<EOD
CREATE TABLE movie (
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
EOD;
    $db->execute($sql);
}



/**
 * Create the mysql table
 */
function doCreateMysqlTable($db)
{
    $sql = "DROP TABLE IF EXISTS `movie`";
    $db->execute($sql);

    $sql = <<<EOD
CREATE TABLE movie (
    `id` INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
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
EOD;
    $db->execute($sql);
}


/**
 * Insert in table
 */
function doInserts($db)
{
    $sql = <<<EOD
INSERT INTO `movie` (`id`,`title`, `year`, `image`) VALUES
    ('1', 'Pulp fiction', 1994, 'img/pulp-fiction.jpg'),
    ('2', 'American Pie', 1999, 'img/american-pie.jpg'),
    ('3', 'Pokémon The Movie 2000', 1999, 'img/pokemon.jpg'),
    ('4', 'Kopps', 2003, 'img/kopps.jpg'),
    ('5', 'From Dusk Till Dawn', 1996, 'img/from-dusk-till-dawn.jpg')
;
EOD;
    $db->execute($sql);
}
