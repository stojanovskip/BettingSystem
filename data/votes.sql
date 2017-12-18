-- c:\xampp\htdocs\vote\votes.sql
CREATE database IF NOT EXISTS php;
USE php;
GRANT ALL PRIVILEGES on php.* TO phpuser@localhost IDENTIFIED BY 'phpass';

DROP TABLE IF EXISTS choices;
DROP TABLE IF EXISTS questions;

CREATE TABLE questions (
  qu_id INT PRIMARY KEY AUTO_INCREMENT,
  qu_text VARCHAR(200)
);
CREATE TABLE choices (
  cho_id INT PRIMARY KEY AUTO_INCREMENT,
  cho_qu INT,
  cho_text VARCHAR(200),
  cho_numvotes INT,
  FOREIGN KEY (cho_qu) REFERENCES questions(qu_id)
);
-- ALTER TABLE choices ADD FOREIGN KEY (cho_qu) REFERENCES questions (qu_id);
INSERT INTO questions VALUES (1, 'What is your favourite color?');
INSERT INTO questions VALUES (2, 'How much do you like PHP?');

INSERT  INTO choices VALUES (NULL, 1, 'Green and white', 0);
INSERT  INTO choices VALUES (NULL, 1, 'White and green', 0);

INSERT  INTO choices VALUES (NULL, 2, 'A lot', 0);
INSERT  INTO choices VALUES (NULL, 2, 'Very much', 0);
INSERT  INTO choices VALUES (NULL, 2, 'Great', 0);
INSERT  INTO choices VALUES (NULL, 2, 'My favourite', 0);
INSERT  INTO choices VALUES (NULL, 2, 'No comment', 0);