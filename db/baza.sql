CREATE TABLE korisnici (
  korisnik_id BIGINT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  korisnicko_ime VARCHAR(256) NOT NULL,
  sifra VARCHAR(256) NOT NULL,
  ime VARCHAR(256) NOT NULL,
  prezime VARCHAR(256) NOT NULL,
  tip_korisinika TINYINT(2) NOT NULL
) ENGINE = InnoDB;

CREATE TABLE tip_korisnika (
  tip_korisnik_id TINYINT(4) NOT NULL,
  tip VARCHAR(256) NOT NULL
) ENGINE = InnoDB;

INSERT INTO tip_korisnika VALUES (1, 'profesor');
INSERT INTO tip_korisnika VALUES (2, 'student');

INSERT INTO korisnici VALUES (NULL, 'profesor', md5('123123'), 'Profesor', 'Profesor', 1);
INSERT INTO korisnici VALUES (NULL, 'student1', md5('123123'), 'Student1', 'Student1', 2);
INSERT INTO korisnici VALUES (NULL, 'student2', md5('123123'), 'Student2', 'Student2', 2);
INSERT INTO korisnici VALUES (NULL, 'student3', md5('123123'), 'Student3', 'Student3', 2);