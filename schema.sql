create table park_Parking (
	id serial primary key,
	nom varchar(20),
	adresse varchar(100),
	unique (nom, adresse)
);

create table park_Personne(
	id serial primary key,
	nom varchar(20) not null,
	prenom varchar(20) not null,
	dateNaissance date not null,
	type varchar(10) not null,
	check (type IN ('employe', 'abonne'))
);

# vEmploye HERITAGE
create view park_vEmploye AS SELECT * FROM park_Personne WHERE type = 'employe';

# vAbonne HERITAGE
create view park_vAbonne AS SELECT * FROM park_Personne WHERE type = 'abonne';

create table park_Poste (
	parking integer references park_Parking(id),
	employe integer references park_Personne(id),
	occupation varchar(20) not null
	-- type de employe = employe (check) => mail
);

create table park_Etage (
	numero integer primary key,
	parking integer references park_Parking(id),
	maxNbPlaces integer not null,
	unique(numero, parking)
);

create table park_Place (
	id serial primary key,
	etage integer references park_Etage(numero),
	type varchar(8),
	utilise boolean not null
);

create table park_Abonnement (
	id serial primary key,
	type varchar(8),
	dateSouscription date not null,
	dateExpiration date not null,
	abonne integer references park_Personne(id),
	place integer references park_Place(id),
	check (type IN ('mensuel', 'annuel'))
);

create table park_Ticket (
	id serial primary key,
	dateEntree timestamp not null,
	dateSortie timestamp not null,
	parking integer references park_Parking(id) not null
);

create table park_Reglement (
	id serial primary key,
	type varchar(8),
	montant float(24) not null,
	dateEnregistrement date,
	ticket integer references park_Ticket(id),
	abonnement integer references park_Abonnement(id),
	check ((ticket = NULL or abonnement = NULL) and ticket != abonnement)
);