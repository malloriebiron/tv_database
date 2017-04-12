# tv_database
#Copy and paste the uncommented lines to execute
#Log in to mysql as root. source /docs/schema.sql
mysql -u root

#Create the databse. source /docs/schema.sql
  USE mysql;
  GRANT USAGE ON * . * TO 'MyShows_mdb1022'@'localhost' IDENTIFIED BY 'MyShows_mdb1022';
  set sql_mode='TRADITIONAL';
  CREATE DATABASE MyShows_mdb1022;
  GRANT ALL ON MyShows_mdb1022.* to 'MyShows_mdb1022'@'localhost';
  FLUSH PRIVILEGES;
  USE MyShows_mdb1022;

#If you are not already logged into the database, log in. source /bin/sql_console
  mysql -u MyShows_mdb1022 -pMyShows_mdb1022 MyShows_mdb1022

#Create the database tables source /docs/schema.sql
CREATE TABLE Shows (
  ShowID INT UNSIGNED not null AUTO_INCREMENT PRIMARY KEY,
  Title VARCHAR(50) not null,
  Genre VARCHAR(50) not null,
  Seasons TINYINT UNSIGNED not null
);
CREATE TABLE Actors (
  ActorID INT UNSIGNED not null AUTO_INCREMENT PRIMARY KEY,
  First VARCHAR(50) not null,
  Last VARCHAR(50) not null
);

CREATE TABLE RelShowActor (
  SAID INT UNSIGNED not null AUTO_INCREMENT PRIMARY KEY,
  ShowID INT UNSIGNED not null,
  ActorID INT UNSIGNED not null,
  FOREIGN KEY (ShowID) REFERENCES Shows(ShowID) ON DELETE CASCADE,
  FOREIGN KEY (ActorID) REFERENCES Actors(ActorID) ON DELETE CASCADE,
    CONSTRAINT unq_RelShowActor UNIQUE (ShowID,ActorID)
);

CREATE Table RelShowUser (
  SUID INT UNSIGNED not null AUTO_INCREMENT PRIMARY KEY,
  ShowID INT UNSIGNED not null,
  UserID INT UNSIGNED not null,
  FOREIGN KEY (ShowID) REFERENCES Shows(ShowID) ON DELETE CASCADE,
  FOREIGN KEY (UserID) REFERENCES User(UserID) ON DELETE CASCADE,
  CONSTRAINT unq_RelShowUser UNIQUE (ShowID,UserId)
);

####### configure Apache and edit file
cp web/mdb1022/conf/apache/apache.conf.sample /web/mdb1022/conf/apache/apache.conf
vi /web/mdb1022/conf/apache/apache.conf
