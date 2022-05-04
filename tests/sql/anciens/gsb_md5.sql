ALTER TABLE visiteur
MODIFY mdp char(32);

UPDATE visiteur
SET mdp = md5(mdp);