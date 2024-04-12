CREATE TABLE utilisateur (
    login_ut VARCHAR(50) PRIMARY KEY,
    nom_ut VARCHAR(100),
    mdp_ut VARCHAR(255),
    acces_ut BOOLEAN,
    bloque_ut BOOLEAN,
    tentative_ut INT,
    presence_ut BOOLEAN
);

CREATE TABLE phase(
    num_phase INT PRIMARY KEY,
    nom_phase VARCHAR(100)
);

CREATE TABLE programme (
    num_prog VARCHAR(100) PRIMARY KEY,
    utilisation_prog TEXT
);

CREATE TABLE Motcles(
    num_cles VARCHAR(100) PRIMARY KEY
);

CREATE TABLE BonnesPratique(
    num_bp INT PRIMARY KEY,
    test_bp TEXT,
    utilisation_bp TEXT
);

CREATE TABLE Description(
    num_description INT PRIMARY KEY,
    num_bp INT,
    num_cles VARCHAR(100),
    FOREIGN KEY (num_bp) REFERENCES BonnesPratique(num_bp),
    FOREIGN KEY (num_cles) REFERENCES Motcles(num_cles)
);

CREATE TABLE Appartenance(
    num_app INT PRIMARY KEY,
    num_prog VARCHAR(100),
    num_phase INT,
    num_bp INT,
    FOREIGN KEY (num_prog) REFERENCES programme(num_prog),
    FOREIGN KEY (num_phase) REFERENCES phase(num_phase),
    FOREIGN KEY (num_bp) REFERENCES BonnesPratique(num_bp)
);


CREATE TABLE LiaisonMotcleBonnePratique(
    motcle_num_cles VARCHAR(100) REFERENCES Motcles(num_cles),
    bonnepratique_num_bp INT REFERENCES BonnesPratique(num_bp),
    PRIMARY KEY (motcle_num_cles, bonnepratique_num_bp)
);