USE gsb_frais;

ALTER TABLE utilisateur
MODIFY mdp char(255) DEFAULT NULL;

ALTER TABLE utilisateur
ADD email text NULL;

UPDATE utilisateur
SET email = CONCAT(login, "@swiss-galaxy.com");

ALTER TABLE utilisateur
ADD codea2f char(6) DEFAULT NULL;

-- À utiliser si le codea2f existe déjà et ne peut contenir que 4 chiffres
ALTER TABLE utilisateur
MODIFY codea2f char(6);