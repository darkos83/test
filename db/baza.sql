CREATE TABLE korisnici (
  korisnik_id BIGINT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  korisnicko_ime VARCHAR(256) NOT NULL,
  sifra VARCHAR(256) NOT NULL,
  ime VARCHAR(256) NOT NULL,
  prezime VARCHAR(256) NOT NULL,
  tip_korisnika TINYINT(2) NOT NULL
) ENGINE = InnoDB;

CREATE TABLE tip_korisnika (
  tip_korisnik_id TINYINT(4) NOT NULL,
  tip VARCHAR(256) NOT NULL
) ENGINE = InnoDB;

INSERT INTO tip_korisnika VALUES (1, 'profesor');
INSERT INTO tip_korisnika VALUES (2, 'student');

INSERT INTO korisnici VALUES (NULL, 'profesor@gmail.com', md5('123123'), 'Profesor', 'Profesor', 1);
INSERT INTO korisnici VALUES (NULL, 'student1@gmail.com', md5('123123'), 'Student1', 'Student1', 2);
INSERT INTO korisnici VALUES (NULL, 'student2@gmail.com', md5('123123'), 'Student2', 'Student2', 2);
INSERT INTO korisnici VALUES (NULL, 'student3gmail.com', md5('123123'), 'Student3', 'Student3', 2);

CREATE TABLE ispiti (
  ispit_id BIGINT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  naziv_ispita VARCHAR(256) NOT NULL,
  broj_pitanja INT NOT NULL,
  korisnik_id INT NOT NULL
) ENGINE = InnoDB;

CREATE TABLE pitanja (
  pitanje_id BIGINT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  pitanje VARCHAR(256) NOT NULL,
  ispit_id INT NOT NULL
) ENGINE = InnoDB;

CREATE TABLE odgovori (
  odgovor_id BIGINT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  odgovor VARCHAR(256) NOT NULL,
  tacno TINYINT(1) NOT NULL,
  pitanje_id INT NOT NULL
) ENGINE = InnoDB;

CREATE TABLE prijave (
  prijava_id BIGINT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  ispit_id INT NOT NULL,
  korisnik_id INT NOT NULL
) ENGINE = InnoDB;

CREATE TABLE rezultati (
  rezultat_id BIGINT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  ispit_id INT NOT NULL,
  korisnik_id INT NOT NULL,
  rezultat DECIMAL(10,2) NOT NULL
) ENGINE = InnoDB;