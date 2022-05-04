USE gsb_frais;

ALTER TABLE visiteur
RENAME utilisateur;

ALTER TABLE utilisateur
ADD statut char(15) DEFAULT 'Visiteur';