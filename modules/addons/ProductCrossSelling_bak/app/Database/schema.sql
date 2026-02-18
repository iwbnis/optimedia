--
-- `#prefix#ProductSettings`
--
CREATE TABLE IF NOT EXISTS `#prefix#ProductSettings` (
    `id`            INT(10) unsigned NOT NULL AUTO_INCREMENT,
    `productId`     INT(10) unsigned NOT NULL,
    `setting`       VARCHAR(255) NOT NULL,
    `value`         TEXT NOT NULL,
    PRIMARY KEY (`id`, `productId`, `setting`)
) ENGINE=InnoDB DEFAULT CHARSET=#charset# DEFAULT COLLATE #collation#;

--
-- `#prefix#LinkedProducts`
--
CREATE TABLE IF NOT EXISTS `#prefix#LinkedProduct` (
    `id`                 INT(10) unsigned NOT NULL AUTO_INCREMENT,
    `productId`          INT(10) unsigned NOT NULL,
    `linkedProductId`    INT(10) unsigned NOT NULL,
    `type`               ENUM('recommended', 'related') NOT NULL,
    `status`             ENUM('on', 'off') DEFAULT 'off',
    `description`        TEXT,
    `overwriteImage`     ENUM('on', 'off') DEFAULT 'off',
    `priority`           INT(5) NOT NULL,
    `productType`        VARCHAR(250) DEFAULT 'product',
    `backgroundColor`    VARCHAR (24),
    `image`              TEXT,
    PRIMARY KEY (`id`),
    KEY productId (`productId`),
    KEY linkedProductId (`linkedProductId`),
    KEY `type` (`type`),
    KEY status (`status`),
    KEY overwriteImage (`overwriteImage`)
) ENGINE=InnoDB DEFAULT CHARSET=#charset# DEFAULT COLLATE #collation#;

--
-- `#prefix#AddonSettings`
--
CREATE TABLE IF NOT EXISTS `#prefix#AddonSettings` (
    `id`            INT(10) unsigned NOT NULL AUTO_INCREMENT,
    `addonId`       INT(10) unsigned NOT NULL,
    `setting`       VARCHAR(255) NOT NULL,
    `value`         TEXT NOT NULL,
    PRIMARY KEY (`id`, `addonId`, `setting`)
) ENGINE=InnoDB DEFAULT CHARSET=#charset# DEFAULT COLLATE #collation#;

--
-- `#prefix#AddonSettings`
--
CREATE TABLE IF NOT EXISTS `#prefix#CarouselSettings` (
    `id`            INT(10) unsigned NOT NULL AUTO_INCREMENT,
    `setting`       VARCHAR(255) NOT NULL,
    `value`         VARCHAR(100) NOT NULL,
    PRIMARY KEY (`id`, `setting`)
) ENGINE=InnoDB