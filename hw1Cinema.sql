Create DATABASE hw1Cinema;
USE hw1Cinema;

CREATE TABLE users (
    id integer primary key auto_increment,
    username varchar(16) not null unique,
    password varchar(255) not null,
    email varchar(255) not null unique,
    name varchar(255) not null,
    surname varchar(255) not null,
    propic varchar(255)
) Engine = InnoDB;

CREATE TABLE ricercheRecenti (
	id integer not null, 
    contenutoID integer not null,
    tstamp datetime, 
    
    index idx_id(id),
    foreign key(id) references users(id),
	index idx_contenutoID(contenutoID),
    foreign key(contenutoID) references FilmSerieTv(id),
    
    primary key (id, contenutoID, tstamp)
) Engine = InnoDB;

CREATE TABLE FilmSerieTv (
	id integer primary key,
    tipo_media varchar(16)
)Engine = InnoDB;

CREATE TABLE commenti (
	commentoID INT AUTO_INCREMENT PRIMARY KEY,
	idFilmSerieTv integer,
    UserID integer,
    contenutoCommento varchar(5000),
	tstamp datetime, 
        
    index idx_idFilmSerieTv(idFilmSerieTv),
    foreign key(idFilmSerieTv) references FilmSerieTv(id),
    
	index idx_UserID(UserID),
    foreign key(UserID) references users(id)
) Engine = InnoDB;

CREATE TABLE preferiti (	
	id integer not null, 
    contenutoID integer not null,
    tipo varchar(16),
    
    index idx_id(id),
    foreign key(id) references users(id),
	index idx_contenutoID(contenutoID),
    foreign key(contenutoID) references FilmSerieTv(id),
    
    primary key (id, contenutoID)
) Engine = InnoDB;