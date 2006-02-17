SET FOREIGN_KEY_CHECKS = 0;

# --------------------------------------------------------
#
# TABLE structure for TABLE _sequence_zvs_pk_hotel_id
#
DROP TABLE IF EXISTS _sequence_zvs_pk_hotel_id;
CREATE TABLE _sequence_zvs_pk_hotel_id (
  sequence                   INT(11)             NOT NULL AUTO_INCREMENT,

  PRIMARY KEY  (sequence)

) TYPE=InnoDB CHECKSUM = 1;


# --------------------------------------------------------
#
# TABLE structure for TABLE _sequence_zvs_pk_salutation_id
#
DROP TABLE IF EXISTS _sequence_zvs_pk_salutation_id;
CREATE TABLE _sequence_zvs_pk_salutation_id (
  sequence                   INT(11)             NOT NULL AUTO_INCREMENT,

  PRIMARY KEY  (sequence)

) TYPE=InnoDB CHECKSUM = 1;



# --------------------------------------------------------
#
# TABLE structure for TABLE _sequence_zvs_pk_language_id
#
DROP TABLE IF EXISTS _sequence_zvs_pk_language_id;
CREATE TABLE _sequence_zvs_pk_language_id (
  sequence                   INT(11)             NOT NULL AUTO_INCREMENT,

  PRIMARY KEY  (sequence)

) TYPE=InnoDB CHECKSUM = 1;

# --------------------------------------------------------
#
# TABLE structure for TABLE _sequence_zvs_pk_default_id
#
DROP TABLE IF EXISTS _sequence_zvs_pk_default_id;
CREATE TABLE _sequence_zvs_pk_default_id (
  sequence                   INT(11)             NOT NULL AUTO_INCREMENT,

  PRIMARY KEY  (sequence)

) TYPE=InnoDB CHECKSUM = 1;



# --------------------------------------------------------
#
# TABLE structure for TABLE _sequence_zvs_pk_tax_id
#
DROP TABLE IF EXISTS _sequence_zvs_pk_tax_id;
CREATE TABLE _sequence_zvs_pk_tax_id (
  sequence                   INT(11)             NOT NULL AUTO_INCREMENT,

  PRIMARY KEY  (sequence)

) TYPE=InnoDB CHECKSUM = 1;



# --------------------------------------------------------
#
# TABLE structure for TABLE _sequence_zvs_pk_tax_period_id
#
DROP TABLE IF EXISTS _sequence_zvs_pk_tax_period_id;
CREATE TABLE _sequence_zvs_pk_tax_period_id (
  sequence                   INT(11)             NOT NULL AUTO_INCREMENT,

  PRIMARY KEY  (sequence)

) TYPE=InnoDB CHECKSUM = 1;


# --------------------------------------------------------

#
# Tabellenstruktur für Tabelle `_sequence_zvs_pk_group_id`
#
DROP TABLE IF EXISTS `_sequence_zvs_pk_group_id`;
CREATE TABLE `_sequence_zvs_pk_group_id` (
  `sequence` int(11) NOT NULL auto_increment,
  PRIMARY KEY  (`sequence`)
) TYPE=InnoDB CHECKSUM=1 AUTO_INCREMENT=2 ;


# --------------------------------------------------------
#
# TABLE structure for TABLE _sequence_zvs_pk_user_id
#
DROP TABLE IF EXISTS _sequence_zvs_pk_user_id;
CREATE TABLE _sequence_zvs_pk_user_id (
  sequence                   INT(11)             NOT NULL AUTO_INCREMENT,

  PRIMARY KEY  (sequence)

) TYPE=InnoDB CHECKSUM = 1;


# --------------------------------------------------------
#
# TABLE structure for TABLE _sequence_zvs_pk_employee_id
#
DROP TABLE IF EXISTS _sequence_zvs_pk_employee_id;
CREATE TABLE _sequence_zvs_pk_employee_id (
  sequence                   INT(11)             NOT NULL AUTO_INCREMENT,

  PRIMARY KEY  (sequence)

) TYPE=InnoDB CHECKSUM = 1;

# --------------------------------------------------------
# --------------------------------------------------------



#
# TABLE structure for TABLE zvs_salutation
#
DROP TABLE IF EXISTS zvs_salutation;
CREATE TABLE zvs_salutation (
  pk_salutation_id           INT(11)             NOT NULL,
  salutation_de              VARCHAR(10)         NOT NULL,
  salutation_com             VARCHAR(10)         NOT NULL,
  salutation_it              VARCHAR(10)         NOT NULL,

  PRIMARY KEY                (pk_salutation_id),

  UNIQUE KEY                 salutation_de                                (salutation_de),
  UNIQUE KEY                 salutation_com                               (salutation_com),
  UNIQUE KEY                 salutation_it                                (salutation_it)

) TYPE=InnoDB CHECKSUM = 1;



# --------------------------------------------------------
#
# TABLE structure for TABLE zvs_language
#
DROP TABLE IF EXISTS zvs_language;
CREATE TABLE zvs_language (
  pk_language_id             INT(11)             NOT NULL,
  language_de                VARCHAR(15)         NOT NULL,
  language_com               VARCHAR(15)         NOT NULL,
  language_it                VARCHAR(15)         NOT NULL,

  PRIMARY KEY                (pk_language_id),
  
  UNIQUE KEY                 language_de                                  (language_de),
  UNIQUE KEY                 language_com                                 (language_com),
  UNIQUE KEY                 language_it                                  (language_it)

) TYPE=InnoDB CHECKSUM = 1;



# --------------------------------------------------------
#
# TABLE structure for TABLE zvs_country
#
DROP TABLE IF EXISTS zvs_country;
CREATE TABLE zvs_country (
  pk_country_id              VARCHAR(2)          NOT NULL,
  country_de                 VARCHAR(50)         NOT NULL,
  country_com                VARCHAR(50)         NOT NULL,

  PRIMARY KEY                (pk_country_id),
  
  UNIQUE KEY                 country_com                                  (country_com),
  UNIQUE KEY                 country_de                                   (country_de)

) TYPE=InnoDB CHECKSUM = 1;



# --------------------------------------------------------
#
# TABLE structure for TABLE zvs_tax
#
DROP TABLE IF EXISTS zvs_tax;
CREATE TABLE zvs_tax (
  pk_tax_id                  INT(11)             NOT NULL,
  fk_country_id              VARCHAR(2)          NOT NULL,
  tax                        VARCHAR(50)         NOT NULL,
  description                VARCHAR(255)                                 DEFAULT NULL,
  
  PRIMARY KEY                (pk_tax_id),

  UNIQUE KEY                 fk_country_id_tax                            (fk_country_id, tax),

  INDEX                      idx_fk_country_id                            (fk_country_id),
  INDEX                      idx_tax                                      (tax),

  FOREIGN KEY                (fk_country_id) references zvs_country       (pk_country_id)
 
)  TYPE=InnoDB CHECKSUM = 1;



# --------------------------------------------------------
#
# TABLE structure for TABLE zvs_tax_period
#
DROP TABLE IF EXISTS zvs_tax_period;
CREATE TABLE zvs_tax_period (
  pk_tax_period_id           INT(11)             NOT NULL,
  fk_tax_id                  INT(11)             NOT NULL,
  percentage                 NUMERIC(4,2)        NOT NULL,
  start_date                 DATETIME            NOT NULL,
  end_date                   DATETIME            NOT NULL,
  
  PRIMARY KEY                (pk_tax_period_id),

  INDEX                      idx_fk_tax_id                                (fk_tax_id),
  INDEX                      idx_start_date_end_date                      (start_date, end_date),

  FOREIGN KEY                (fk_tax_id) references zvs_tax               (pk_tax_id)
  
)  TYPE=InnoDB CHECKSUM = 1;



# --------------------------------------------------------
#
# TABLE structure for TABLE zvs_hotel
#
DROP TABLE IF EXISTS zvs_hotel;
CREATE TABLE zvs_hotel (
  pk_hotel_id                INT(11)             NOT NULL,
  hotel                      VARCHAR(50)         NOT NULL,
  hotel_code                 VARCHAR(3)          NOT NULL,
  description                VARCHAR(255)                                 DEFAULT NULL,
  database_schema            VARCHAR(25)         NOT NULL,

  PRIMARY KEY                (pk_hotel_id),

  UNIQUE KEY                 hotel                                        (hotel),
  UNIQUE KEY                 hotel_code                                   (hotel_code),
  UNIQUE KEY                 database_schema                              (database_schema)

) TYPE=InnoDB CHECKSUM = 1;


#
# TABLE structure for TABLE zvs_group
#
DROP TABLE IF EXISTS zvs_group;
CREATE TABLE zvs_group (
  pk_group_id                INT(11)             NOT NULL,
  level 					 INT(11)             NOT NULL, 
  fk_hotel_id                INT(11)                                      DEFAULT NULL,
  name                   	 VARCHAR(50)         NOT NULL,
  inserted_date              DATETIME            NOT NULL,
  fk_inserted_user_id        INT(11)             NOT NULL,
  updated_date               DATETIME                                     DEFAULT NULL,
  fk_updated_user_id         INT(11)                                      DEFAULT NULL,
  deleted_date               DATETIME                                     DEFAULT NULL,
  fk_deleted_user_id         INT(11)                                      DEFAULT NULL,

  PRIMARY KEY                (pk_group_id),

  UNIQUE KEY                 name                          							  (fk_hotel_id, name),

  INDEX                      idx_fk_hotel_id                              (fk_hotel_id),
  INDEX                      idx_fk_inserted_user_id                      (fk_inserted_user_id),
  INDEX                      idx_fk_updated_user_id                       (fk_updated_user_id),
  INDEX                      idx_fk_deleted_user_id                       (fk_deleted_user_id),

  FOREIGN KEY                (fk_hotel_id) references zvs_hotel           (pk_hotel_id),
  FOREIGN KEY                (fk_inserted_user_id) references zvs_user    (pk_user_id),
  FOREIGN KEY                (fk_updated_user_id) references zvs_user     (pk_user_id),
  FOREIGN KEY                (fk_deleted_user_id) references zvs_user     (pk_user_id)

) TYPE=InnoDB CHECKSUM = 1;




#
# TABLE structure for TABLE zvs_user
#
DROP TABLE IF EXISTS zvs_user;
CREATE TABLE zvs_user (
  pk_user_id                 INT(11)             NOT NULL,
  fk_hotel_id                INT(11)                                      DEFAULT NULL,
  fk_group_id                INT(11)			 NOT NULL,				  
  lastname                   VARCHAR(50)         NOT NULL,
  firstname                  VARCHAR(50)                                  DEFAULT NULL,
  login                      VARCHAR(50)         NOT NULL,
  password                   VARCHAR(32)         NOT NULL,
  locked                     ENUM('Y','N')       NOT NULL                 DEFAULT 'Y',
  fk_language_id             INT(11)                                      DEFAULT NULL,
  inserted_date              DATETIME            NOT NULL,
  fk_inserted_user_id        INT(11)             NOT NULL,
  updated_date               DATETIME                                     DEFAULT NULL,
  fk_updated_user_id         INT(11)                                      DEFAULT NULL,
  deleted_date               DATETIME                                     DEFAULT NULL,
  fk_deleted_user_id         INT(11)                                      DEFAULT NULL,

  PRIMARY KEY                (pk_user_id),

  INDEX                      idx_fk_hotel_id                              (fk_hotel_id),
  INDEX                      idx_fk_language_id                           (fk_language_id),
  INDEX                      idx_fk_inserted_user_id                      (fk_inserted_user_id),
  INDEX                      idx_fk_updated_user_id                       (fk_updated_user_id),
  INDEX                      idx_fk_deleted_user_id                       (fk_deleted_user_id),
  INDEX                      idx_locked                                   (locked),
  INDEX                      idx_lastname_firstname                       (lastname, firstname),
  INDEX 					 idx_fk_group_id						      (fk_group_id),
  
  FOREIGN KEY                (fk_hotel_id) references zvs_hotel           (pk_hotel_id),
  FOREIGN KEY                (fk_language_id) references zvs_language     (pk_language_id),
  FOREIGN KEY                (fk_inserted_user_id) references zvs_user    (pk_user_id),
  FOREIGN KEY                (fk_updated_user_id) references zvs_user     (pk_user_id),
  FOREIGN KEY                (fk_deleted_user_id) references zvs_user     (pk_user_id),
  FOREIGN KEY                (fk_group_id) references zvs_group     	  (pk_group_id)

) TYPE=InnoDB CHECKSUM = 1;


#
# TABLE structure for TABLE zvs_employee
#
DROP TABLE IF EXISTS zvs_employee;
CREATE TABLE zvs_employee (
  pk_employee_id             INT(11)             NOT NULL,
  fk_hotel_id                INT(11)                                      DEFAULT NULL,
  lastname                   VARCHAR(50)         NOT NULL,
  firstname                  VARCHAR(50)                                  DEFAULT NULL,
  login                      VARCHAR(50)         NOT NULL,
  password                   VARCHAR(32)         NOT NULL,
  salary					 decimal(10,2)       NOT NULL			      DEFAULT '0.00',
  locked                     ENUM('Y','N')       NOT NULL                 DEFAULT 'Y',
  fk_language_id             INT(11)                                      DEFAULT NULL,
  inserted_date              DATETIME            NOT NULL,
  fk_inserted_user_id        INT(11)             NOT NULL,
  updated_date               DATETIME                                     DEFAULT NULL,
  fk_updated_user_id         INT(11)                                      DEFAULT NULL,
  deleted_date               DATETIME                                     DEFAULT NULL,
  fk_deleted_user_id         INT(11)                                      DEFAULT NULL,

  PRIMARY KEY                (pk_employee_id),

  UNIQUE KEY                 fk_hotel_id_login                            (fk_hotel_id, login),

  INDEX                      idx_fk_hotel_id                              (fk_hotel_id),
  INDEX                      idx_fk_language_id                           (fk_language_id),
  INDEX                      idx_fk_inserted_user_id                      (fk_inserted_user_id),
  INDEX                      idx_fk_updated_user_id                       (fk_updated_user_id),
  INDEX                      idx_fk_deleted_user_id                       (fk_deleted_user_id),
  INDEX                      idx_locked                                   (locked),
  INDEX                      idx_lastname_firstname                       (lastname, firstname),

  FOREIGN KEY                (fk_hotel_id) references zvs_hotel           (pk_hotel_id),
  FOREIGN KEY                (fk_language_id) references zvs_language     (pk_language_id),
  FOREIGN KEY                (fk_inserted_user_id) references zvs_user    (pk_user_id),
  FOREIGN KEY                (fk_updated_user_id) references zvs_user     (pk_user_id),
  FOREIGN KEY                (fk_deleted_user_id) references zvs_user     (pk_user_id)

) TYPE=InnoDB CHECKSUM = 1;





#
# TABLE structure for TABLE zvs_employee_times
#
DROP TABLE IF EXISTS zvs_employee_times;
CREATE TABLE zvs_employee_times (
  pk_employee_times_id       INT(11)             NOT NULL,
  fk_employee_id             INT(11)                                      DEFAULT NULL,
  start_date                 DATETIME,
  end_date                   DATETIME,
  inserted_date              DATETIME            NOT NULL,
  fk_inserted_user_id        INT(11)             NOT NULL,
  updated_date               DATETIME                                     DEFAULT NULL,
  fk_updated_user_id         INT(11)                                      DEFAULT NULL,
  deleted_date               DATETIME                                     DEFAULT NULL,
  fk_deleted_user_id         INT(11)                                      DEFAULT NULL,

  PRIMARY KEY                (pk_employee_times_id),

  INDEX						 idx_fk_employee_id							  (fk_employee_id),
  INDEX                      idx_fk_inserted_user_id                      (fk_inserted_user_id),
  INDEX                      idx_fk_updated_user_id                       (fk_updated_user_id),
  INDEX                      idx_fk_deleted_user_id                       (fk_deleted_user_id),

  FOREIGN KEY                (fk_employee_id) references zvs_employee     (pk_employee_id),
  FOREIGN KEY                (fk_inserted_user_id) references zvs_user    (pk_user_id),
  FOREIGN KEY                (fk_updated_user_id) references zvs_user     (pk_user_id),
  FOREIGN KEY                (fk_deleted_user_id) references zvs_user     (pk_user_id)

) TYPE=InnoDB CHECKSUM = 1;



# --------------------------------------------------------
#
# TABLE structure for TABLE zvs_default
#
DROP TABLE IF EXISTS zvs_default;
CREATE TABLE zvs_default (
  pk_default_id              INT(11)             NOT NULL,
  default_name               VARCHAR(50)         NOT NULL,
  description                VARCHAR(255)                                 DEFAULT NULL,
  fieldtype                  ENUM('string','boolean','file','int','date','color') NOT NULL DEFAULT 'string',
  string_value               VARCHAR(255)                                 DEFAULT NULL,
  integer_value              INT(11)                                      DEFAULT NULL,
  datetime_value             DATETIME                                     DEFAULT NULL,
  boolean_value              ENUM('Y','N')                                DEFAULT NULL,
  editable                   ENUM('Y','N')       NOT NULL                 DEFAULT 'N',

  PRIMARY KEY                (pk_default_id),

  UNIQUE KEY                 default_name                                 (default_name)

) TYPE=InnoDB CHECKSUM = 1;



# --------------------------------------------------------
#
# TABLE structure for TABLE zvs_hotel_default
#
DROP TABLE IF EXISTS zvs_hotel_default;
CREATE TABLE zvs_hotel_default (
  pk_fk_hotel_id             INT(11)             NOT NULL,
  pk_fk_default_id           INT(11)             NOT NULL,
  string_value               VARCHAR(255)                                 DEFAULT NULL,
  integer_value              INT(11)                                      DEFAULT NULL,
  datetime_value             DATETIME                                     DEFAULT NULL,
  boolean_value              ENUM('Y','N')                                DEFAULT NULL,
  inserted_date              DATETIME            NOT NULL,
  fk_inserted_user_id        INT(11)             NOT NULL,
  updated_date               DATETIME                                     DEFAULT NULL,
  fk_updated_user_id         INT(11)                                      DEFAULT NULL,
  deleted_date               DATETIME                                     DEFAULT NULL,
  fk_deleted_user_id         INT(11)                                      DEFAULT NULL,

  PRIMARY KEY  (pk_fk_hotel_id, pk_fk_default_id),

  INDEX                      idx_pk_fk_hotel_id                           (pk_fk_hotel_id),
  INDEX                      idx_fk_default_id                            (pk_fk_default_id),
  INDEX                      idx_fk_inserted_user_id                      (fk_inserted_user_id),
  INDEX                      idx_fk_updated_user_id                       (fk_updated_user_id),
  INDEX                      idx_fk_deleted_user_id                       (fk_deleted_user_id),
  INDEX                      idx_pk_fk_hotel_id_fk_deleted_user_id        (pk_fk_hotel_id, fk_deleted_user_id),

  FOREIGN KEY                (pk_fk_hotel_id) references zvs_hotel        (pk_hotel_id),
  FOREIGN KEY                (pk_fk_default_id) references zvs_default    (pk_default_id),
  FOREIGN KEY                (fk_inserted_user_id) references zvs_user    (pk_user_id),
  FOREIGN KEY                (fk_updated_user_id) references zvs_user     (pk_user_id),
  FOREIGN KEY                (fk_deleted_user_id) references zvs_user     (pk_user_id)

) TYPE=InnoDB CHECKSUM = 1;

SET FOREIGN_KEY_CHECKS = 1;