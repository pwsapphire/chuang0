--
-- File generated with SQLiteStudio v3.0.7 on Mon Feb 8 14:32:23 2016
--
-- Text encoding used: UTF-8
--
PRAGMA foreign_keys = off;
BEGIN TRANSACTION;

-- Table: role
CREATE TABLE `role` (
  `rol_id` PRIMARY KEY NOT NULL,
  `rol_name`  DEFAULT NULL
);
INSERT INTO role (rol_id, rol_name) VALUES (1, 'user');
INSERT INTO role (rol_id, rol_name) VALUES (2, 'editor');
INSERT INTO role (rol_id, rol_name) VALUES (3, 'admin');

-- Table: location
CREATE TABLE `location` (
  `loc_id` PRIMARY KEY  NOT NULL,
  `loc_name` varchar(50) DEFAULT NULL,
  `loc_type` varchar(50) DEFAULT NULL,
  `loc_adresse` varchar(50) DEFAULT NULL,
  `loc_ville` varchar(50) DEFAULT NULL,
  `loc_img_ville` varchar(50) DEFAULT NULL,
  `loc_description` varchar(50) DEFAULT NULL,
  `loc_gps_lat` double DEFAULT NULL,
  `loc_gps_long` double DEFAULT NULL,
  `loc_cp` varchar(10) DEFAULT NULL
);

-- Table: usr
CREATE TABLE usr (usr_id PRIMARY KEY NOT NULL, role_rol_id int (10) NOT NULL REFERENCES role (rol_id), usr_email varchar (50) UNIQUE ON CONFLICT ABORT, usr_password varchar (50) DEFAULT NULL, usr_date_of_creation datetime DEFAULT NULL);
INSERT INTO usr (usr_id, role_rol_id, usr_email, usr_password, usr_date_of_creation) VALUES (3, 2, 'maghnia.dib.pro@gmail.com', '$2y$10$zwsUlaWwnYam7q2ZH8OAYeJoUKVQLG4RG3oOdEH78HQ', '2016-02-08 14:10:14');
INSERT INTO usr (usr_id, role_rol_id, usr_email, usr_password, usr_date_of_creation) VALUES (4, 3, 'perfect_sapphire@hotmail.com', '$2y$10$P/LHVRlaZ9kM/V84K4B3d.jX1cyyi1z4qFpBDf2ctRb', '2016-02-08 14:11:06');
INSERT INTO usr (usr_id, role_rol_id, usr_email, usr_password, usr_date_of_creation) VALUES (5, 2, 'deltgen.david@gmail.com', '$2y$10$t3hgpy3FJTsNG3NCV702Nul4Xbqonoqy0z9BpRX/A4g', '2016-02-08 14:11:28');

-- Table: evaluation
CREATE TABLE evaluation (evaluation_id PRIMARY KEY NOT NULL, location_loc_id INTEGER NOT NULL REFERENCES location (loc_id), usr_id INTEGER NOT NULL, eval_note INTEGER DEFAULT NULL, eval_comment text);

COMMIT TRANSACTION;
PRAGMA foreign_keys = on;
