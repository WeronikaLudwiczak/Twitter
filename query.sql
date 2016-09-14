
--SQL

CREATE TABLE User(
    id INT AUTO_INCREMENT NOT NULL,
    email VARCHAR(255) NOT NULL,
    username VARCHAR(255) NOT NULL,
    hashed_password VARCHAR(60) NOT NULL,
    PRIMARY KEY(id),
    UNIQUE KEY(email));


CREATE TABLE Tweets (
  id INT AUTO_INCREMENT NOT NULL,
  creation_date Date NOT NULL,
  content VARCHAR(140) NOT NULL,
  user_id INT,
  PRIMARY KEY (id),
  FOREIGN KEY (user_id) REFERENCES User(id)
);