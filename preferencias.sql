create database preferencias;

use preferencias;

create table usuario(
  idUsuario int primary key auto_increment,
  nombreUsuario varchar(40) not null,
  correo varchar(80) not null,
  password varchar(30) not null
);

create index ix_nombreUsuario on usuario(nombreUsuario);
create index ix_correo on usuario(correo);

create table juego(
  idJuego tinyint primary key auto_increment,
  nombreJuego varchar(40) not null,
  url varchar(200) not null
);

create table preferencia(
  idPreferencia bigint auto_increment,
  idUsuario int not null,
  idJuego tinyint not null,
  constraint pk_preferencia primary key (idPreferencia, idUsuario, idJuego)
);

/*=============================================================================*/

insert into usuario(nombreUsuario, correo, password) values
  ('tamosCrazy', 'mediolocodelcoco@gmail.com', '123456768'),
  ('cremitaFina', 'lomaskie@hotmail.com', '87654321'),
  ('yipiyou', 'lokitokie@msn.net', '12348765');

insert into juego(nombreJuego, url) values
  ('takeThis', '/takethis'),
  ('deadWrong', 'deadwrong'),
  ('hitHitRun', '/hithitrun'),
  ('readyToDie', '/readytodie'),
  ('leaveLive', '/leavelive'),
  ('headShot', '/headshot');
