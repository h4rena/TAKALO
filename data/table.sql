CREATE DATABASE takalo;

USE takalo;

CREATE TABLE user_role_takalo (
    role_id INT AUTO_INCREMENT PRIMARY KEY,
    role VARCHAR(255) NOT NULL
);

CREATE TABLE user_takalo (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_role INT NOT NULL,
    username VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    hashedpassword VARCHAR(255) NOT NULL,
    FOREIGN KEY (id_role) REFERENCES user_role_takalo(role_id)
);

INSERT INTO user_role_takalo (role) VALUES ('admin'), ('user');

ALTER TABLE user_takalo ALTER id_role SET DEFAULT 2;

CREATE TABLE categorie_takalo (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL UNIQUE
);

CREATE TABLE objet_takalo (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_owner INT NOT NULL,
    id_categorie INT DEFAULT NULL,
    nom_objet VARCHAR(255) NOT NULL,
    description TEXT,
    image VARCHAR(255) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (id_owner) REFERENCES user_takalo(id),
    FOREIGN KEY (id_categorie) REFERENCES categorie_takalo(id)
);

CREATE TABLE objet_photo_takalo (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_objet INT NOT NULL,
    filename VARCHAR(255) NOT NULL,
    FOREIGN KEY (id_objet) REFERENCES objet_takalo(id)
);

CREATE TABLE echange_takalo (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_objet_demande INT NOT NULL,
    id_objet_propose INT NOT NULL,
    status VARCHAR(20) NOT NULL DEFAULT 'pending',
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    responded_at DATETIME NULL,
    FOREIGN KEY (id_objet_demande) REFERENCES objet_takalo(id),
    FOREIGN KEY (id_objet_propose) REFERENCES objet_takalo(id)
);

