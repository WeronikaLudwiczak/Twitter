
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


CREATE TABLE Comment (
  id INT  AUTO_INCREMENT NOT NULL,
  user_id INT NOT NULL,
  tweet_id INT NOT NULL,
  creation_date DATETIME,
  text VARCHAR(140),
  PRIMARY KEY (id),
  FOREIGN KEY (user_id) REFERENCES User(id),
  FOREIGN KEY (tweet_id) REFERENCES Tweets(id)
);

CREATE TABLE Messages (
  id INT  AUTO_INCREMENT NOT NULL,
  content TEXT,
  sender_id INT NOT NULL,
  addresser_id INT NOT NULL,
  creation_date DATETIME,
  if_read INT,
  PRIMARY KEY (id),
  FOREIGN KEY (sender_id) REFERENCES User(id),
  FOREIGN KEY (addresser_id) REFERENCES User(id)
);