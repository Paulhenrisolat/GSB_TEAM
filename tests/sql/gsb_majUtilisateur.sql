USE gsb_frais;

ALTER TABLE utilisateur
MODIFY mdp char(255) DEFAULT NULL;

ALTER TABLE utilisateur
ADD email text NULL;

UPDATE utilisateur
SET email = CONCAT(login, "@swiss-galaxy.com");

ALTER TABLE utilisateur
ADD codeauthentification char(4) DEFAULT NULL;