
# --------------------------------------------------------

#
# Tabellenstruktur für Tabelle `_sequence_zvs_pk_bararticle_id`
#

CREATE TABLE `_sequence_zvs_pk_bararticle_id` (
  `sequence` int(11) NOT NULL auto_increment,
  PRIMARY KEY  (`sequence`)
) TYPE=InnoDB CHECKSUM=1;

# --------------------------------------------------------

#
# Tabellenstruktur für Tabelle `_sequence_zvs_pk_bararticlecat_id`
#

CREATE TABLE `_sequence_zvs_pk_bararticlecat_id` (
  `sequence` int(11) NOT NULL auto_increment,
  PRIMARY KEY  (`sequence`)
) TYPE=InnoDB CHECKSUM=1;

# --------------------------------------------------------

#
# Tabellenstruktur für Tabelle `_sequence_zvs_pk_barguest_id`
#

CREATE TABLE `_sequence_zvs_pk_barguest_id` (
  `sequence` int(11) NOT NULL auto_increment,
  PRIMARY KEY  (`sequence`)
) TYPE=InnoDB CHECKSUM=1;

# --------------------------------------------------------

#
# Tabellenstruktur für Tabelle `_sequence_zvs_pk_bought_id`
#

CREATE TABLE `_sequence_zvs_pk_bought_id` (
  `sequence` int(11) NOT NULL auto_increment,
  PRIMARY KEY  (`sequence`)
) TYPE=InnoDB CHECKSUM=1;

# --------------------------------------------------------

#
# Tabellenstruktur für Tabelle `zvs_bararticle`
#

CREATE TABLE `zvs_bararticle` (
  `pk_bararticle_id` int(11) NOT NULL default '0',
  `fk_bararticlecat_id` int(11) NOT NULL default '0',
  `description` varchar(255) default NULL,
  `price` decimal(10,2) NOT NULL default '0.00',
  `hotkey` char(1) default NULL,
  `inserted_date` datetime NOT NULL default '0000-00-00 00:00:00',
  `fk_inserted_user_id` int(11) NOT NULL default '0',
  `updated_date` datetime default NULL,
  `fk_updated_user_id` int(11) default NULL,
  `deleted_date` datetime default NULL,
  `fk_deleted_user_id` int(11) default NULL,
  PRIMARY KEY  (`pk_bararticle_id`),
  KEY `idx_pk_bararticle_id` (`pk_bararticle_id`),
  KEY `idx_fk_inserted_user_id` (`fk_inserted_user_id`),
  KEY `idx_fk_updated_user_id` (`fk_updated_user_id`),
  KEY `idx_fk_deleted_user_id` (`fk_deleted_user_id`),
  KEY `idx_fk_bararticlecat_id` (`fk_bararticlecat_id`),
  CONSTRAINT `0_1690` FOREIGN KEY (`fk_inserted_user_id`) REFERENCES `zvs_system_bar`.`zvs_user` (`pk_user_id`),
  CONSTRAINT `0_1691` FOREIGN KEY (`fk_updated_user_id`) REFERENCES `zvs_system_bar`.`zvs_user` (`pk_user_id`),
  CONSTRAINT `0_1692` FOREIGN KEY (`fk_deleted_user_id`) REFERENCES `zvs_system_bar`.`zvs_user` (`pk_user_id`),
  CONSTRAINT `zvs_bararticle_ibfk_1` FOREIGN KEY (`fk_bararticlecat_id`) REFERENCES `zvs_bararticlecat` (`pk_bararticlecat_id`)
) TYPE=InnoDB CHECKSUM=1;

# --------------------------------------------------------

#
# Tabellenstruktur für Tabelle `zvs_bararticlecat`
#

CREATE TABLE `zvs_bararticlecat` (
  `pk_bararticlecat_id` int(11) NOT NULL default '0',
  `bararticlecat` varchar(50) NOT NULL default '',
  `inserted_date` datetime NOT NULL default '0000-00-00 00:00:00',
  `fk_inserted_user_id` int(11) NOT NULL default '0',
  `updated_date` datetime default NULL,
  `fk_updated_user_id` int(11) default NULL,
  `deleted_date` datetime default NULL,
  `fk_deleted_user_id` int(11) default NULL,
  PRIMARY KEY  (`pk_bararticlecat_id`),
  UNIQUE KEY `bararticlecat` (`bararticlecat`),
  KEY `idx_fk_inserted_user_id` (`fk_inserted_user_id`),
  KEY `idx_fk_updated_user_id` (`fk_updated_user_id`),
  KEY `idx_fk_deleted_user_id` (`fk_deleted_user_id`),
  CONSTRAINT `zvs_bararticlecat_ibfk_1` FOREIGN KEY (`fk_inserted_user_id`) REFERENCES `zvs_system_bar`.`zvs_user` (`pk_user_id`),
  CONSTRAINT `zvs_bararticlecat_ibfk_2` FOREIGN KEY (`fk_updated_user_id`) REFERENCES `zvs_system_bar`.`zvs_user` (`pk_user_id`),
  CONSTRAINT `zvs_bararticlecat_ibfk_3` FOREIGN KEY (`fk_deleted_user_id`) REFERENCES `zvs_system_bar`.`zvs_user` (`pk_user_id`)
) TYPE=InnoDB CHECKSUM=1;





# --------------------------------------------------------

#
# Tabellenstruktur für Tabelle `zvs_barguest`
#

CREATE TABLE `zvs_barguest` (
  `pk_barguest_id` int(11) NOT NULL default '0',
  `firstname` varchar(50) default NULL,
  `lastname` varchar(50) NOT NULL default '',
  `inserted_date` datetime NOT NULL default '0000-00-00 00:00:00',
  `fk_inserted_user_id` int(11) NOT NULL default '0',
  `updated_date` datetime default NULL,
  `fk_updated_user_id` int(11) default NULL,
  `deleted_date` datetime default NULL,
  `fk_deleted_user_id` int(11) default NULL,
  PRIMARY KEY  (`pk_barguest_id`)
) TYPE=InnoDB CHECKSUM=1;

# --------------------------------------------------------

#
# Tabellenstruktur für Tabelle `zvs_bought`
#

CREATE TABLE `zvs_bought` (
  `pk_bought_id` int(11) NOT NULL default '0',
  `fk_barguest_id` int(11) NOT NULL default '0',
  `fk_bararticle_id` int(11) NOT NULL default '0',
  `timestamp` datetime NOT NULL default '0000-00-00 00:00:00',
  `num` tinyint(4) NOT NULL default '1',
  `paid` enum('Y','N') NOT NULL default 'N',
  `inserted_date` datetime NOT NULL default '0000-00-00 00:00:00',
  `fk_inserted_user_id` int(11) NOT NULL default '0',
  `updated_date` datetime default NULL,
  `fk_updated_user_id` int(11) default NULL,
  PRIMARY KEY  (`pk_bought_id`),
  KEY `idx_pk_bought_id` (`pk_bought_id`),
  KEY `idx_fk_barguest_id` (`fk_barguest_id`),
  KEY `idx_fk_bararticle_id` (`fk_bararticle_id`),
  KEY `idx_fk_inserted_user_id` (`fk_inserted_user_id`),
  KEY `idx_fk_updated_user_id` (`fk_updated_user_id`),
  CONSTRAINT `0_1694` FOREIGN KEY (`fk_barguest_id`) REFERENCES `zvs_barguest` (`pk_barguest_id`),
  CONSTRAINT `0_1695` FOREIGN KEY (`fk_bararticle_id`) REFERENCES `zvs_bararticle` (`pk_bararticle_id`),
  CONSTRAINT `0_1696` FOREIGN KEY (`fk_inserted_user_id`) REFERENCES `zvs_system_bar`.`zvs_user` (`pk_user_id`),
  CONSTRAINT `0_1697` FOREIGN KEY (`fk_updated_user_id`) REFERENCES `zvs_system_bar`.`zvs_user` (`pk_user_id`)
) TYPE=InnoDB CHECKSUM=1;


