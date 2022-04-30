CREATE TABLE vehicules (
  id VARCHAR(6) NOT NULL,
  libelle VARCHAR(15) NOT NULL,
  prixkm DECIMAL(3,2) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;

INSERT INTO vehicules (id, libelle, prixkm) VALUES
('4CV-D', '4CV Diesel', 0.52),
('56CV-D', '5/6CV Diesel', 0.58),
('4CV-E', '4CV Essence', 0.62),
('56CV-E', '5/6CV Essence', 0.67);

ALTER TABLE fichefrais
ADD idvehicule varchar(6) NOT NULL;

UPDATE fichefrais
SET idvehicule = '4CV-E';

ALTER TABLE fichefrais
ADD FOREIGN KEY (idvehicule) REFERENCES vehicules(id);