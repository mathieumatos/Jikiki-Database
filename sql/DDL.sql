/* Script SQL pour le SGBD PostgreSQL (v.10.3)
 *
 * Université de Montréal, hiver 2018
 * Marc-André Brochu, Olga Fadeitcheva, Simon Bréard & Mathieu Matos
 * 
 * Ce script effectue trois choses: (1) la création de la structure de la base de données:
 * ses tables et leur champs; (2) initialiser les catégories d'objets ainsi que leurs attributs,
 * qui resteront inchangés une fois la base en production; et (3) remplir la base de données
 * nouvellement initialisée avec des données bidon (i.e. de test).
 */

SET search_path TO jikiki;

DROP TABLE IF EXISTS emplacement CASCADE;
CREATE TABLE emplacement (
    id  serial PRIMARY KEY,
    lat decimaL(10, 6) NOT NULL,
    lon decimal(10, 6) NOT NULL
);

DROP TABLE IF EXISTS categorie CASCADE;
CREATE TABLE categorie (
    id      serial PRIMARY KEY,
    nom     text NOT NULL
);

DROP TABLE IF EXISTS utilisateur CASCADE;
CREATE TABLE utilisateur (
    id             serial PRIMARY KEY,
    username       text NOT NULL,
    password       text NOT NULL,
    email          text NOT NULL,
    full_name      text NOT NULL,
    telephone      text,
    emplacement_id integer REFERENCES emplacement ON DELETE SET NULL
);

DROP TABLE IF EXISTS objet CASCADE;
CREATE TABLE objet (
    id                serial PRIMARY KEY,
    nom               text NOT NULL,
    date_publication  date NOT NULL,
    date_limite       date,
    prix_vente        numeric CHECK (prix_vente >= 0),
    cout_horaire      numeric CHECK (cout_horaire >= 0),
    description       text,
    temps_min_emprunt integer CHECK (temps_min_emprunt > 0),
    emplacement_id    integer REFERENCES emplacement ON DELETE SET NULL,
    categorie_id      integer REFERENCES categorie   ON DELETE RESTRICT,
    proprietaire_id   integer REFERENCES utilisateur ON DELETE CASCADE
);

DROP TABLE IF EXISTS photo CASCADE;
CREATE TABLE photo (
    id       serial PRIMARY KEY,
    chemin   text NOT NULL,
    objet_id integer REFERENCES objet ON DELETE CASCADE
);

DROP TABLE IF EXISTS attribut CASCADE;
CREATE TABLE attribut (
    id           serial PRIMARY KEY,
    nom          text NOT NULL,
    attr_type    text NOT NULL,
    categorie_id integer REFERENCES categorie ON DELETE CASCADE
);

DROP TABLE IF EXISTS valeurattribut CASCADE;
CREATE TABLE valeurattribut (
    attribut_id integer REFERENCES attribut ON DELETE CASCADE,
    objet_id    integer REFERENCES objet    ON DELETE CASCADE,
    valeur      text,
    PRIMARY KEY (attribut_id, objet_id)
);

DROP TABLE IF EXISTS emprunt CASCADE;
CREATE TABLE emprunt (
    id            serial PRIMARY KEY,
    debut         date NOT NULL,
    fin           date NOT NULL,
    montant       numeric NOT NULL,
    objet_id      integer REFERENCES objet       ON DELETE SET NULL, 
    emprunteur_id integer REFERENCES utilisateur ON DELETE SET NULL,
    annonceur_id  integer REFERENCES utilisateur ON DELETE SET NULL
);

DROP TABLE IF EXISTS evaluation CASCADE;
CREATE TABLE evaluation (
    evaluateur_id integer REFERENCES utilisateur ON DELETE SET NULL,
    evalue_id     integer REFERENCES utilisateur ON DELETE CASCADE,
    score         integer NOT NULL,
    commentaire   text,
    PRIMARY KEY (evaluateur_id, evalue_id)
);

-- Simplement copier le contenu des fichiers dans les tables appropriées. Cette opération facilite le
-- développement: si nous voulons rajouter des catégories ou des attributs, pas besoin de modifier ce
-- fichier, seulement les fichiers CSV associés. Il faut toutefois regénérer la BDD dans ce cas (en
-- roulant ce script à nouveau).
\COPY emplacement (lat, lon) FROM 'emplacement.csv' WITH CSV HEADER;
\COPY categorie (nom) FROM 'categories.csv' WITH CSV;
\COPY utilisateur (username, password, email, full_name, telephone, emplacement_id) FROM 'utilisateurs.csv' WITH CSV;
\COPY attribut (nom, attr_type, categorie_id) FROM 'attributs.csv' WITH CSV;
\COPY objet (nom, date_publication, date_limite, prix_vente, cout_horaire, description, temps_min_emprunt, emplacement_id, categorie_id, proprietaire_id) FROM 'objets.csv' WITH CSV;
\COPY valeurattribut (attribut_id, objet_id, valeur) FROM 'valeurattribut.csv' WITH CSV;
\COPY emprunt (debut, fin, montant, objet_id, emprunteur_id, annonceur_id) FROM 'emprunt.csv' WITH CSV;
\COPY evaluation (evaluateur_id, evalue_id, score, commentaire) FROM 'evaluation.csv' WITH CSV HEADER;
\COPY photo (chemin, objet_id) FROM 'photo.csv' WITH CSV HEADER;

-- Donne les privilièges à brochum_app
GRANT ALL PRIVILEGES ON ALL TABLES IN SCHEMA jikiki TO brochum_app;
GRANT ALL PRIVILEGES ON ALL SEQUENCES IN SCHEMA jikiki TO brochum_app;

CREATE VIEW objet_view AS SELECT
    objet.id,
    objet.nom AS nom_objet,
    objet.proprietaire_id AS vendeur_id,
    nom_vendeur,
    email_vendeur,
    objet.description AS desc,
    objet.cout_horaire AS cout,
    objet.prix_vente AS prix,
    objet.date_publication AS pub_date,
    objet.date_limite AS lim_date,
    objet.temps_min_emprunt AS temps_min,
    chemin_photo,
    lat, lon
FROM (
    objet
    NATURAL JOIN (
        SELECT utilisateur.id AS proprietaire_id,
               utilisateur.username AS nom_vendeur,
               utilisateur.email AS email_vendeur
        FROM utilisateur) AS vendeur
    NATURAL JOIN (
        SELECT emplacement.id AS emplacement_id,
               lat, lon
        FROM emplacement) AS place
    LEFT JOIN (
        SELECT photo.objet_id,
               chemin AS chemin_photo
        FROM photo) AS p
    ON objet.id = p.id
);

CREATE VIEW objet_attribut_view AS SELECT
    obj_id AS objet_id,
    attr_id AS attribut_id,
    nom_attribut, valeur AS val_attribut
FROM
   (SELECT objet.id AS obj_id, 
           attribut.id AS attr_id,
           attribut.nom AS nom_attribut
    FROM objet RIGHT JOIN attribut ON objet.categorie_id = attribut.categorie_id) AS a
    LEFT JOIN
    valeurattribut ON obj_id = valeurattribut.objet_id AND valeurattribut.attribut_id = attr_id; 
