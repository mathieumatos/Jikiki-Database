-- Voir le rapport pour explications

SELECT id FROM utilisateur WHERE username = <username> AND password = <password>;

INSERT INTO emprunt (
    debut, fin, montant, objet_id, emprunteur_id, annonceur_id
) VALUES (
    <date debut>,
    <date fin>,
    <montant en dollars>,
    <objet>,
    <emprunteur>,
    <annonceur>
);

SELECT * FROM objet_view NATURAL JOIN (
    SELECT objet_id AS id FROM emprunt WHERE emprunteur_id = <user_id>
) AS e;

SELECT * FROM objet_attribut_view NATURAL JOIN (
    SELECT objet_id FROM emprunt WHERE emprunteur_id = <user_id>
) AS e;

SELECT * FROM objet_view WHERE vendeur_id = <user_id>;

INSERT INTO evaluation (evaluateur_id, evalue_id, score, commentaire) VALUES (
    <évaluateur>,
    <évalué>,
    <score>,
    <commentaire>
);

SELECT * FROM (
    SELECT * FROM objet_view WHERE
        pub_date <= now() AND
        lim_date >= now()) AS l
    NATURAL JOIN (
        SELECT objet_id AS id, nom_attribut, val_attribut
          FROM objet_attribut_view
    ) AS r;

SELECT * FROM (
    SELECT * FROM objet_view WHERE id = <objet_id>) AS l
    NATURAL JOIN (
        SELECT objet_id AS id, nom_attribut, val_attribut
          FROM objet_attribut_view
    ) AS r;

SELECT * FROM objet_attribut_view WHERE objet_id = <objet_id>;

INSERT INTO objet (
    nom, date_publication,
    date_limite, prix_vente,
    cout_horaire, description,
    temps_min_emprunt, emplacement_id,
    categorie_id, proprietaire_id
) VALUES (
    <nom>,
    now(), -- la date de publication peut être changée ultérieurement
    <date limite>,
    <prix de vente si applicable>,
    <cout horaire si applicable>,
    <description de l’objet>,
    <temps minimal d’un emprunt>,
    <emplacement de l’objet>,
    <categorie de l’objet>,
    <propriétaire de l’objet>
);

UPDATE objet SET <liste d’attributs> = <nouvelles valeurs> WHERE id = <objet_id>;

SELECT username, email, full_name, telephone, lat, lon
FROM utilisateur JOIN emplacement
ON (utilisateur.emplacement_id = emplacement.id)
WHERE utilisateur.id = <user_id>;

INSERT INTO utilisateur (
    username, password, email, full_name, telephone, emplacement_id
) VALUES (
    <username>,
    <password>,
    <email>,
    <nom complet>,
    <telephone>,
    <emplacement>
);

UPDATE utilisateur SET <liste d’attributs> = <nouvelles valeurs>
    WHERE id = <user_id>;

SELECT * FROM categorie;