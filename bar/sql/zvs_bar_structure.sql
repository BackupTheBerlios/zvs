
# --------------------------------------------------------

#
# Tabellenstruktur für Tabelle _sequence_zvs_pk_bararticle_id
#

CREATE TABLE _sequence_zvs_pk_bararticle_id (
  sequence int(11) NOT NULL auto_increment,
  PRIMARY KEY  (sequence)
) TYPE=InnoDB CHECKSUM=1;

# --------------------------------------------------------

#
# Tabellenstruktur für Tabelle _sequence_zvs_pk_bararticlecat_id
#

CREATE TABLE _sequence_zvs_pk_bararticlecat_id (
  sequence int(11) NOT NULL auto_increment,
  PRIMARY KEY  (sequence)
) TYPE=InnoDB CHECKSUM=1;

# --------------------------------------------------------

#
# Tabellenstruktur für Tabelle _sequence_zvs_pk_barguest_id
#

CREATE TABLE _sequence_zvs_pk_barguest_id (
  sequence int(11) NOT NULL auto_increment,
  PRIMARY KEY  (sequence)
) TYPE=InnoDB CHECKSUM=1;

# --------------------------------------------------------

#
# Tabellenstruktur für Tabelle _sequence_zvs_pk_bought_id
#

CREATE TABLE _sequence_zvs_pk_bought_id (
  sequence int(11) NOT NULL auto_increment,
  PRIMARY KEY  (sequence)
) TYPE=InnoDB CHECKSUM=1;


# --------------------------------------------------------

#
# Tabellenstruktur für Tabelle _sequence_zvs_pk_period_id
#

CREATE TABLE _sequence_zvs_pk_period_id (
  sequence int(11) NOT NULL auto_increment,
  PRIMARY KEY  (sequence)
) TYPE=InnoDB CHECKSUM=1;



# --------------------------------------------------------
#
# TABLE structure for TABLE _sequence_zvs_pk_bookingcat_id
#
DROP TABLE IF EXISTS _sequence_zvs_pk_barbookingcat_id;
CREATE TABLE _sequence_zvs_pk_barbookingcat_id (
  sequence                   INT(11)             NOT NULL AUTO_INCREMENT,

  PRIMARY KEY  (sequence)

) TYPE=InnoDB CHECKSUM = 1;



# --------------------------------------------------------
#
# Tabellenstruktur für Tabelle zvs_period
#

CREATE TABLE zvs_period (
  pk_period_id int(11) NOT NULL default '0',
  period varchar(50) NOT NULL default '',
  active enum('Y','N') NOT NULL default 'N',
  inserted_date datetime NOT NULL default '0000-00-00 00:00:00',
  fk_inserted_user_id int(11) NOT NULL default '0',
  updated_date datetime default NULL,
  fk_updated_user_id int(11) default NULL,
  deleted_date datetime default NULL,
  fk_deleted_user_id int(11) default NULL,
  PRIMARY KEY  (pk_period_id),
  UNIQUE KEY period (period),
  KEY idx_fk_inserted_user_id (fk_inserted_user_id),
  KEY idx_fk_updated_user_id (fk_updated_user_id),
  KEY idx_fk_deleted_user_id (fk_deleted_user_id),
  FOREIGN KEY (fk_inserted_user_id) REFERENCES zvs_system_bar.zvs_user (pk_user_id),
  FOREIGN KEY (fk_updated_user_id) REFERENCES zvs_system_bar.zvs_user (pk_user_id),
  FOREIGN KEY (fk_deleted_user_id) REFERENCES zvs_system_bar.zvs_user (pk_user_id)
) TYPE=InnoDB CHECKSUM=1;



# --------------------------------------------------------

#
# Tabellenstruktur für Tabelle zvs_bararticlecat
#

CREATE TABLE zvs_bararticlecat (
  pk_bararticlecat_id int(11) NOT NULL default '0',
  bararticlecat varchar(50) NOT NULL default '',
  inserted_date datetime NOT NULL default '0000-00-00 00:00:00',
  fk_inserted_user_id int(11) NOT NULL default '0',
  updated_date datetime default NULL,
  fk_updated_user_id int(11) default NULL,
  deleted_date datetime default NULL,
  fk_deleted_user_id int(11) default NULL,
  PRIMARY KEY  (pk_bararticlecat_id),
  UNIQUE KEY bararticlecat (bararticlecat),
  KEY idx_fk_inserted_user_id (fk_inserted_user_id),
  KEY idx_fk_updated_user_id (fk_updated_user_id),
  KEY idx_fk_deleted_user_id (fk_deleted_user_id),
  FOREIGN KEY (fk_inserted_user_id) REFERENCES zvs_system_bar.zvs_user (pk_user_id),
  FOREIGN KEY (fk_updated_user_id) REFERENCES zvs_system_bar.zvs_user (pk_user_id),
  FOREIGN KEY (fk_deleted_user_id) REFERENCES zvs_system_bar.zvs_user (pk_user_id)
) TYPE=InnoDB CHECKSUM=1;






# --------------------------------------------------------

#
# Tabellenstruktur für Tabelle zvs_bararticle
#

CREATE TABLE zvs_bararticle (
  pk_bararticle_id int(11) NOT NULL default '0',
  fk_bararticlecat_id int(11) NOT NULL default '0',
  fk_period_id int(11) NOT NULL default '0',
  description varchar(255) default NULL,
  price decimal(10,2) NOT NULL default '0.00',
  hotkey char(1) default NULL,
  inserted_date datetime NOT NULL default '0000-00-00 00:00:00',
  fk_inserted_user_id int(11) NOT NULL default '0',
  updated_date datetime default NULL,
  fk_updated_user_id int(11) default NULL,
  deleted_date datetime default NULL,
  fk_deleted_user_id int(11) default NULL,
  PRIMARY KEY  (pk_bararticle_id),
  KEY idx_pk_bararticle_id (pk_bararticle_id),
  KEY idx_fk_inserted_user_id (fk_inserted_user_id),
  KEY idx_fk_updated_user_id (fk_updated_user_id),
  KEY idx_fk_deleted_user_id (fk_deleted_user_id),
  KEY idx_fk_bararticlecat_id (fk_bararticlecat_id),
  KEY idx_fk_period_id (fk_period_id),
  FOREIGN KEY (fk_inserted_user_id) REFERENCES zvs_system_bar.zvs_user (pk_user_id),
  FOREIGN KEY (fk_updated_user_id) REFERENCES zvs_system_bar.zvs_user (pk_user_id),
  FOREIGN KEY (fk_deleted_user_id) REFERENCES zvs_system_bar.zvs_user (pk_user_id),
  FOREIGN KEY (fk_bararticlecat_id) REFERENCES zvs_bararticlecat (pk_bararticlecat_id),
  FOREIGN KEY (fk_period_id) REFERENCES zvs_period (pk_period_id)
) TYPE=InnoDB CHECKSUM=1;


# --------------------------------------------------------
#
# TABLE structure for TABLE zvs_bookingcat
#
DROP TABLE IF EXISTS zvs_barbookingcat;
CREATE TABLE zvs_bookingcat (
  pk_bookingcat_id           INT(11)             NOT NULL,
  fk_zvsbookingcat_id	     INT(11)             NOT NULL,
  bookingcat                 VARCHAR(80)         NOT NULL,
  color                      VARCHAR(7)                                   DEFAULT NULL,
  inserted_date              DATETIME            NOT NULL,
  fk_inserted_user_id        INT(11)             NOT NULL,

  PRIMARY KEY  (pk_bookingcat_id),

  UNIQUE KEY                 bookingcat                                   (bookingcat),

  INDEX                      idx_fk_zvsbookingcat_id                      (fk_zvsbookingcat_id),
  INDEX                      idx_fk_inserted_user_id                      (fk_inserted_user_id),
  
  FOREIGN KEY                (fk_inserted_user_id) references zvs_system_bar.zvs_user        (pk_user_id)

) TYPE=InnoDB CHECKSUM = 1;


# --------------------------------------------------------

#
# Tabellenstruktur für Tabelle zvs_barguest
#

CREATE TABLE zvs_barguest (
  pk_barguest_id int(11) NOT NULL default '0',
  fk_zvsguest_id INT(11) default NULL,
  fk_bookingcat_id INT(11) NOT NULL default '0',
  firstname varchar(50) default NULL,
  lastname varchar(50) NOT NULL default '',
  inserted_date datetime NOT NULL default '0000-00-00 00:00:00',
  fk_inserted_user_id int(11) NOT NULL default '0',
  updated_date datetime default NULL,
  fk_updated_user_id int(11) default NULL,
  deleted_date datetime default NULL,
  fk_deleted_user_id int(11) default NULL,
  PRIMARY KEY  (pk_barguest_id),
  KEY idx_fk_inserted_user_id (fk_inserted_user_id),
  KEY idx_fk_updated_user_id (fk_updated_user_id),
  KEY idx_fk_deleted_user_id (fk_deleted_user_id),
  KEY idx_fk_zvsguest_id (fk_zvsguest_id),
  KEY idx_fk_bookingcat_id (fk_bookingcat_id),
  FOREIGN KEY (fk_inserted_user_id) REFERENCES zvs_system_bar.zvs_user (pk_user_id),
  FOREIGN KEY (fk_updated_user_id) REFERENCES zvs_system_bar.zvs_user (pk_user_id),
  FOREIGN KEY (fk_deleted_user_id) REFERENCES zvs_system_bar.zvs_user (pk_user_id),
  FOREIGN KEY (fk_bookingcat_id) REFERENCES zvs_barbookingcat (pk_bookingcat_id)
) TYPE=InnoDB CHECKSUM=1;

# --------------------------------------------------------

#
# Tabellenstruktur für Tabelle zvs_bought
#

CREATE TABLE zvs_bought (
  pk_bought_id int(11) NOT NULL default '0',
  fk_barguest_id int(11) NOT NULL default '0',
  fk_bararticle_id int(11) NOT NULL default '0',
  timestamp datetime NOT NULL default '0000-00-00 00:00:00',
  num tinyint(4) NOT NULL default '1',
  paid enum('Y','N') NOT NULL default 'N',
  inserted_date datetime NOT NULL default '0000-00-00 00:00:00',
  fk_inserted_user_id int(11) NOT NULL default '0',
  updated_date datetime default NULL,
  fk_updated_user_id int(11) default NULL,
  PRIMARY KEY  (pk_bought_id),
  KEY idx_pk_bought_id (pk_bought_id),
  KEY idx_fk_barguest_id (fk_barguest_id),
  KEY idx_fk_bararticle_id (fk_bararticle_id),
  KEY idx_fk_inserted_user_id (fk_inserted_user_id),
  KEY idx_fk_updated_user_id (fk_updated_user_id),
  FOREIGN KEY (fk_barguest_id) REFERENCES zvs_barguest (pk_barguest_id),
  FOREIGN KEY (fk_bararticle_id) REFERENCES zvs_bararticle (pk_bararticle_id),
  FOREIGN KEY (fk_inserted_user_id) REFERENCES zvs_system_bar.zvs_user (pk_user_id),
  FOREIGN KEY (fk_updated_user_id) REFERENCES zvs_system_bar.zvs_user (pk_user_id)
) TYPE=InnoDB CHECKSUM=1;

