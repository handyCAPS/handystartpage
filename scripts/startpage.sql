
CREATE TABLE IF NOT EXISTS `categories` (
  `cat_id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_name` varchar(30) NOT NULL,
  `cat_order` float NOT NULL,
  PRIMARY KEY (`cat_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `images` (
  `img_id` int(11) NOT NULL AUTO_INCREMENT,
  `img_name` varchar(40) NOT NULL,
  `img_location` varchar(100) NOT NULL,
  `img_mime` varchar(8) NOT NULL,
  `img_nice_name` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`img_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `layout` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `num_best` int(11) DEFAULT '13',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `links` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `link` varchar(100) NOT NULL,
  `image` varchar(100) DEFAULT NULL,
  `cat_id` int(10) NOT NULL,
  `link_order` float DEFAULT NULL,
  `clicks` int(11) DEFAULT '0',
  `description` varchar(100) DEFAULT 'No Description Available',
  `img_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT fk_cat_id
    FOREIGN KEY(cat_id)
    REFERENCES categories(cat_id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
