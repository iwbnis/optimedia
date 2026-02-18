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

ALTER TABLE #prefix#LinkedProduct
ADD productType varchar(250) DEFAULT 'product';

CREATE TABLE IF NOT EXISTS `#prefix#CarouselSettings` (
    `id`            INT(10) unsigned NOT NULL AUTO_INCREMENT,
    `setting`       VARCHAR(255) NOT NULL,
    `value`         VARCHAR(100) NOT NULL,
    PRIMARY KEY (`id`, `setting`)
) ENGINE=InnoDB DEFAULT CHARSET=#charset# DEFAULT COLLATE #collation#;