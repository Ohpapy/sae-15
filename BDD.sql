CREATE TABLE utilisateur (
        login_ut VARCHAR(50) PRIMARY KEY,
        nom_ut VARCHAR(100),
        mdp_ut VARCHAR(255),
        acces_ut BOOLEAN,
        bloque_ut BOOLEAN,
        tentative_ut INT,
        presence_ut BOOLEAN
    
)

CREATE TABLE phase(
    num_phase INT PRIMARY KEY,
    nom_phase VARCHAR(100)
)


CREATE TABLE programme (
    num_prog VARCHAR(100) PRIMARY KEY,
    utilisation_prog TEXT
)


CREATE TABLE Motclés(
    num_clés VARCHAR(100) PRIMARY KEY
)


CREATE TABLE BonnesPratique(
    num_bp INT PRIMARY KEY,
    test_bp TEXT,
    utilisation_bp TEXT
)


CREATE TABLE Description(
    num_description INT PRIMARY KEY,
    FOREIGN KEY (num_bp) REFERENCES Bonnepratique(num_bp),
    FOREIGN KEY (num_clés) REFERENCES Motsclés(nom_clés)
)

CREATE TABLE Appartenance(
    num_app INT PRIMARY KEY
    FOREIGN KEY (num_prog) REFERENCES programme(num_prog),
    FOREIGN KEY (num_phase) REFERENCES phase(num_phase),
    FOREIGN KEY (num_bp) REFERENCES Bonnepratique(num_bp),
)