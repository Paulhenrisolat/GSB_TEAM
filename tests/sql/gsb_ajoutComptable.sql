USE gsb_frais;

INSERT INTO utilisateur (id, nom, prenom, login, mdp, adresse, cp, ville, dateembauche, statut, email) VALUES
('co01', 'Giraud', 'Anne', 'ganne', 'vix98', 'Avenue Winston Churchill', '83000', 'Toulon', '1987-01-15', 'Comptable', concat(login, '@swiss-galaxy.fr'));