drop database if exists biblio_gestion;

create database if not exists biblio_gestion;
use biblio_gestion;

create table adherent (
    id_adh int auto_increment primary key,
    nom varchar(100) not null,
    adresse varchar(255) not null,
    is_suspendu boolean default false,
    is_delete boolean default false
)ENGINE=InnoDB;

create table livre (
    ref_livre int auto_increment primary key,
    titre varchar(255) not null,
    editeur varchar(100) not null,
    prix decimal(10,2) not null,
    is_dispo boolean default true,
    nbr_exemplaire int not null,
    is_delete boolean default false
)ENGINE=InnoDB;

create table emprunt (
    id_emp int auto_increment primary key,
    date_emp date not null,
    date_retour_prevue date not null, -- Date de retour prévue ajoutée
    id_adh int not null,
    is_returned boolean default false, -- Nouvelle colonne pour indiquer si l'emprunt est retourné
    foreign key (id_adh) references adherent(id_adh)
)ENGINE=InnoDB;

create table concerner (
    id_con int auto_increment primary key,
    id_emp int not null,
    ref_livre int not null,
    foreign key (id_emp) references emprunt(id_emp),
    foreign key (ref_livre) references livre(ref_livre)
)ENGINE=InnoDB;

create table retourner (
    id_retour int auto_increment primary key,
    id_emp int not null,
    date_retour date not null,
    foreign key (id_emp) references emprunt(id_emp)
)ENGINE=InnoDB;


