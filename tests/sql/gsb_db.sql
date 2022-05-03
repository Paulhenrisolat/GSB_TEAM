-- Script de création de l'application "GSB Frais"

-- Administration de la base de données
CREATE DATABASE gsb_frais;
CREATE USER IF NOT EXISTS 'userGsb'@localhost IDENTIFIED BY 'secret';
GRANT ALL PRIVILEGES ON `gsb_frais`.* TO userGsb@localhost;
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
USE gsb_frais;

-- Création de la structure de la base de données
CREATE TABLE IF NOT EXISTS fraisforfait (
  id char(3) NOT NULL,
  libelle char(20) NOT NULL,
  montant decimal(5,2) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS etat (
  id char(2) NOT NULL,
  libelle varchar(30) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS utilisateur (
  id char(4) NOT NULL,
  nom char(30) NOT NULL,
  prenom char(30) NOT NULL, 
  login char(20) NOT NULL,
  mdp char(255) NOT NULL,
  adresse char(30) NOT NULL,
  cp char(5) NOT NULL,
  ville char(30) NOT NULL,
  dateembauche date NOT NULL,
  statut varchar(15) DEFAULT 'Visiteur',
  email text NOT NULL,
  codea2f char(6) DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS vehicules (
  id varchar(6) NOT NULL,
  libelle varchar(20) NOT NULL,
  prixkm decimal(3,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS fichefrais (
  idvisiteur char(4) NOT NULL,
  mois char(6) NOT NULL,
  nbjustificatifs int(11) DEFAULT NULL,
  montantvalide decimal(10,2) DEFAULT NULL,
  datemodif date DEFAULT NULL,
  idetat char(2) DEFAULT 'CR' NOT NULL,
  idvehicule varchar(6) DEFAULT '4CV-E' NOT NULL,
  PRIMARY KEY (idvisiteur,mois),
  FOREIGN KEY (idetat) REFERENCES etat(id),
  FOREIGN KEY (idvisiteur) REFERENCES utilisateur(id),
  FOREIGN KEY (idvehicule) REFERENCES vehicules(id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS lignefraisforfait (
  idvisiteur char(4) NOT NULL,
  mois char(6) NOT NULL,
  idfraisforfait char(3) NOT NULL,
  quantite int(11) DEFAULT NULL,
  PRIMARY KEY (idvisiteur,mois,idfraisforfait),
  FOREIGN KEY (idvisiteur, mois) REFERENCES fichefrais(idvisiteur, mois),
  FOREIGN KEY (idfraisforfait) REFERENCES fraisforfait(id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS lignefraishorsforfait (
  id int(11) NOT NULL auto_increment,
  idvisiteur char(4) NOT NULL,
  mois char(6) NOT NULL,
  libelle varchar(100) NOT NULL,
  date date NOT NULL,
  montant decimal(10,2) NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (idvisiteur, mois) REFERENCES fichefrais(idvisiteur, mois)
) ENGINE=InnoDB;

-- Alimentation des données paramètres
INSERT INTO fraisforfait (id, libelle, montant) VALUES
('ETP', 'Forfait Etape', 110.00),
('KM', 'Frais Kilométrique', 0.62),
('NUI', 'Nuitée Hôtel', 80.00),
('REP', 'Repas Restaurant', 25.00);

INSERT INTO etat (id, libelle) VALUES
('RB', 'Remboursée'),
('CL', 'Saisie clôturée'),
('CR', 'Fiche créée, saisie en cours'),
('VA', 'Validée et mise en paiement');

-- Récupération des utilisateurs
INSERT INTO utilisateur (id, nom, prenom, login, mdp, adresse, cp, ville, dateembauche, statut, email) VALUES
('a131', 'Villechalane', 'Louis', 'lvillachane', 'jux7g', '8 rue des Charmes', '46000', 'Cahors', '2005-12-21', 'Visiteur', concat(login, '@swiss-galaxy.fr')),
('a17', 'Andre', 'David', 'dandre', 'oppg5', '1 rue Petit', '46200', 'Lalbenque', '1998-11-23', 'Visiteur', concat(login, '@swiss-galaxy.fr')),
('a55', 'Bedos', 'Christian', 'cbedos', 'gmhxd', '1 rue Peranud', '46250', 'Montcuq', '1995-01-12', 'Visiteur', concat(login, '@swiss-galaxy.fr')),
('a93', 'Tusseau', 'Louis', 'ltusseau', 'ktp3s', '22 rue des Ternes', '46123', 'Gramat', '2000-05-01', 'Visiteur', concat(login, '@swiss-galaxy.fr')),
('b13', 'Bentot', 'Pascal', 'pbentot', 'doyw1', '11 allée des Cerises', '46512', 'Bessines', '1992-07-09', 'Visiteur', concat(login, '@swiss-galaxy.fr')),
('b16', 'Bioret', 'Luc', 'lbioret', 'hrjfs', '1 Avenue gambetta', '46000', 'Cahors', '1998-05-11', 'Visiteur', concat(login, '@swiss-galaxy.fr')),
('b19', 'Bunisset', 'Francis', 'fbunisset', '4vbnd', '10 rue des Perles', '93100', 'Montreuil', '1987-10-21', 'Visiteur', concat(login, '@swiss-galaxy.fr')),
('b25', 'Bunisset', 'Denise', 'dbunisset', 's1y1r', '23 rue Manin', '75019', 'paris', '2010-12-05', 'Visiteur', concat(login, '@swiss-galaxy.fr')),
('b28', 'Cacheux', 'Bernard', 'bcacheux', 'uf7r3', '114 rue Blanche', '75017', 'Paris', '2009-11-12', 'Visiteur', concat(login, '@swiss-galaxy.fr')),
('b34', 'Cadic', 'Eric', 'ecadic', '6u8dc', '123 avenue de la République', '75011', 'Paris', '2008-09-23', 'Visiteur', concat(login, '@swiss-galaxy.fr')),
('b4', 'Charoze', 'Catherine', 'ccharoze', 'u817o', '100 rue Petit', '75019', 'Paris', '2005-11-12', 'Visiteur', concat(login, '@swiss-galaxy.fr')),
('b50', 'Clepkens', 'Christophe', 'cclepkens', 'bw1us', '12 allée des Anges', '93230', 'Romainville', '2003-08-11', 'Visiteur', concat(login, '@swiss-galaxy.fr')),
('b59', 'Cottin', 'Vincenne', 'vcottin', '2hoh9', '36 rue Des Roches', '93100', 'Monteuil', '2001-11-18', 'Visiteur', concat(login, '@swiss-galaxy.fr')),
('c14', 'Daburon', 'François', 'fdaburon', '7oqpv', '13 rue de Chanzy', '94000', 'Créteil', '2002-02-11', 'Visiteur', concat(login, '@swiss-galaxy.fr')),
('c3', 'De', 'Philippe', 'pde', 'gk9kx', '13 rue Barthes', '94000', 'Créteil', '2010-12-14', 'Visiteur', concat(login, '@swiss-galaxy.fr')),
('c54', 'Debelle', 'Michel', 'mdebelle', 'od5rt', '181 avenue Barbusse', '93210', 'Rosny', '2006-11-23', 'Visiteur', concat(login, '@swiss-galaxy.fr')),
('d13', 'Debelle', 'Jeanne', 'jdebelle', 'nvwqq', '134 allée des Joncs', '44000', 'Nantes', '2000-05-11', 'Visiteur', concat(login, '@swiss-galaxy.fr')),
('d51', 'Debroise', 'Michel', 'mdebroise', 'sghkb', '2 Bld Jourdain', '44000', 'Nantes', '2001-04-17', 'Visiteur', concat(login, '@swiss-galaxy.fr')),
('e22', 'Desmarquest', 'Nathalie', 'ndesmarquest', 'f1fob', '14 Place d Arc', '45000', 'Orléans', '2005-11-12', 'Visiteur', concat(login, '@swiss-galaxy.fr')),
('e24', 'Desnost', 'Pierre', 'pdesnost', '4k2o5', '16 avenue des Cèdres', '23200', 'Guéret', '2001-02-05', 'Visiteur', concat(login, '@swiss-galaxy.fr')),
('e39', 'Dudouit', 'Frédéric', 'fdudouit', '44im8', '18 rue de l église', '23120', 'GrandBourg', '2000-08-01', 'Visiteur', concat(login, '@swiss-galaxy.fr')),
('e49', 'Duncombe', 'Claude', 'cduncombe', 'qf77j', '19 rue de la tour', '23100', 'La souteraine', '1987-10-10', 'Visiteur', concat(login, '@swiss-galaxy.fr')),
('e5', 'Enault-Pascreau', 'Céline', 'cenault', 'y2qdu', '25 place de la gare', '23200', 'Gueret', '1995-09-01', 'Visiteur', concat(login, '@swiss-galaxy.fr')),
('e52', 'Eynde', 'Valérie', 'veynde', 'i7sn3', '3 Grand Place', '13015', 'Marseille', '1999-11-01', 'Visiteur', concat(login, '@swiss-galaxy.fr')),
('f21', 'Finck', 'Jacques', 'jfinck', 'mpb3t', '10 avenue du Prado', '13002', 'Marseille', '2001-11-10', 'Visiteur', concat(login, '@swiss-galaxy.fr')),
('f39', 'Frémont', 'Fernande', 'ffremont', 'xs5tq', '4 route de la mer', '13012', 'Allauh', '1998-10-01', 'Visiteur', concat(login, '@swiss-galaxy.fr')),
('f4', 'Gest', 'Alain', 'agest', 'dywvt', '30 avenue de la mer', '13025', 'Berre', '1985-11-01', 'Visiteur', concat(login, '@swiss-galaxy.fr')),
('co01', 'Giraud', 'Anne', 'ganne', 'vix98', 'Avenue Winston Churchill', '83000', 'Toulon', '1987-01-15', 'Comptable', concat(login, '@swiss-galaxy.fr'));

-- Insertion des types de véhicules
INSERT INTO vehicules (id, libelle, prixkm) VALUES
('4CV-D', '4CV Diesel', 0.52),
('56CV-D', '5/6CV Diesel', 0.58),
('4CV-E', '4CV Essence', 0.62),
('56CV-E', '5/6CV Essence', 0.67);
